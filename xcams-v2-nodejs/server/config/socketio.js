/**
 * Socket.io configuration
 */
'use strict';

import config from './environment';
import jwt from 'jsonwebtoken';
const Queue = require('../components/Queue');
const Socket = require('../components/Socket');
const redisClient = require('../components/Redis');
const redisIo = require('socket.io-redis');

var JWT_SECRET = '12345';

var modelStorages = require('./../storages/model');

// When the user disconnects.. perform this
function onDisconnect(socket) {
  if (socket.user && socket.user.role === 'model') {
    console.log("DARWIN1");
    modelStorages.remove(socket);
    modelStorages.removeModelSocket(socket);
  }
}

// When the user connects.. perform this
function onConnect(socket, socketio) {
  // When the client emits 'info', this listens and executes
  socket.on('info', function(data) {
    socket.log(JSON.stringify(data, null, 2));
  });

  // Insert sockets below
  //stream broadcast in the video stream
  require('../sockets/streaming-broadcast').register(socket);

  require('../sockets/room-manager').register(socket);
  require('../sockets/chat').register(socket);
  require('../sockets/model-online').register(socket, socketio);
  require('../sockets/tip').register(socket);

  // socketio.of('/conversation').on('connection', function(socket) {
//    require('../sockets/conversation').register(socket);
  // });

  //require user logged in
  require('../sockets/video-call').register(socket);
    require('../sockets/group-call').register(socket);
  if (socket.user) {

    //storage model if valid
    if (socket.user.role === 'model') {
      console.log("DARWIN2");
      modelStorages.add(socket);

      
    }
  }
}

exports = module.exports = function(server) {
  const socketIo = require('socket.io')(server, {
    serveClient: config.env !== 'production',
    path: '/socket.io-client'
  });
  //allow origin
  socketIo.origins('*:*');
  //sockets section
  socketIo.adapter(redisIo({
    //pubClient: redisClient,
    //subClient: redisClient
  }));

  //config authorization
  socketIo.use(function (socket, next) {
    socket.address = socket.request.connection.remoteAddress +
      ':' + socket.request.connection.remotePort;
    //decode json web token in case in constant
    //TODO - find user in this case
    // console.log('token:'+ socket.handshake.query.token);
    if (socket.handshake.query.token) {
      //decode token
      try {
        var decoded = jwt.verify(socket.handshake.query.token, JWT_SECRET, {
          clockTolerance:100
        });

        socket.user = decoded.data;
      } catch(e) {
        socket.user = null;
      }
    } else {
      socket.user = null;
    }

    socket.connectedAt = new Date();

    //integrate queue component to socket then easy to call it
    socket.queue = Queue;

    socket.log = function(...data) {
      console.log(`SocketIO ${socket.nsp.name} [${socket.address}]`, ...data);
    };

    next();
  });

  Socket.init(socketIo, function (component) {
    var socket = component.socket;
    //TODO - move other config to socket and require here
    // Call onDisconnect.
    socket.on('disconnect', function() {
      onDisconnect(socket);
    });

    // Call onConnect.
    onConnect(socket, socketIo);

    require('../sockets/components/count-members')(component);
    require('../sockets/components/performer-online')(component);
    require('../sockets/components/group-chat')(component);
    require('../sockets/components/performer-update-status')(component);
    require('../sockets/components/games')(component);
    require('../sockets/components/multiretos')(component);
    require('../sockets/components/ruleta')(component);
    
  });
}
