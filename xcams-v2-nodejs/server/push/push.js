const PushService = require('../push/push-service');
const Sequelize = require('sequelize');
const _ = require('lodash');
const config = require('./../config/environment');
const FCM = require('fcm-node');
const apn = require('apn');
const async = require('async');
const apnProvider = new apn.Provider({
    token: {
        key: config.apn.key,
        keyId: config.apn.keyId,
        teamId: config.apn.teamId
    },
    production: config.apn.production
});

// https://www.npmjs.com/package/fcm-node#classic-usage-example
function sendFCM(androidDevices, message, cb) {
    cb = cb || function() {};
    const key = process.env.FCM_SERVER_KEY || config.FCM_SERVER_KEY;
    if (!key) {
        return cb('Missing key');
    }
    const fcm = new FCM(key);
    async.eachSeries(androidDevices, function(to, cb2) {
        fcm.send(Object.assign(message, { to }), () => cb2());
    }, cb);
}

function sendAPN(devices, message, cb) {
    cb = cb || function() {};
    const note = new apn.Notification();

    note.expiry = Math.floor(Date.now() / 1000) + 3600; // Expires 1 hour from now.
    note.badge = 3;
    note.sound = 'ping.aiff';
    note.alert =  message;
    note.topic = config.apn.bundleId;
    async.eachSeries(devices, function(deviceToken, cb2) {
        apnProvider.send(note, deviceToken).then(() => cb2()).catch(() => cb2());
    }, cb);
}

module.exports = exports = {
    push: function(socket, status) {
        if (process.env.APP_PUSH_NOTIFICATION === 'false' && !config.APP_PUSH_NOTIFICATION) {
            return false;
        }
        const sequelize = new Sequelize(config.db.database, config.db.username, config.db.password);
        const title = `Model ${socket.user.firstName} ${socket.user.lastName} is ${status}.`
        const message = (status == 'online') ? `${socket.user.firstName} ${socket.user.lastName} is live on Cam, chat with me at xCams` :
            `Model ${socket.user.firstName} ${socket.user.lastName} is offline.`;
        const otherfields = Object.assign({}, socket.user);
        socket.user.status = status;
        //raw query
        sequelize.query(`SELECT n.deviceToken, n.deviceType
            FROM favorites AS f, notificationdevices AS n
            WHERE f.ownerId = n.userId and f.status = ? AND f.favoriteId = ? AND n.push = ? `,
          { replacements: ['like', socket.user.id, 'YES'], type: sequelize.QueryTypes.SELECT }
        ).then(function(devices) {
            if (!devices || !devices.length) {
                return false;
            }

            const androidDevices = _.filter(devices, d => d.deviceType.toLowerCase() === 'android')
                .map(d => d.deviceToken);
            const iosDevices = _.filter(devices, d => d.deviceType.toLowerCase() === 'ios')
                .map(d => d.deviceToken);

            if (androidDevices.length) {
                // TODO - check me
                // since we must call too much requests, so it should be in queue
                sendFCM(androidDevices, {
                    //this may vary according to the message type (single recipient, multicast, topic, et cetera)
                    collapse_key: 'model_status',
                    notification: {
                        title,
                        body: message
                    },
                    data: otherfields
                });
            }

            if (iosDevices.length) {
                sendAPN(iosDevices, message);
            }

            return true;
        });
    }
};

