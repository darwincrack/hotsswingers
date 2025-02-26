const _ = require('lodash');
let models = require('../../models');
module.exports = function(socketComponent) {
    socketComponent.socket.on('GamesModel', function(options, callback) {


        models.Games.findOne({
            where: {
                user_id: options.userId,
                active: 1
            }
        }).then(function(Games) {
            if (Games) {
                models.Games.update({
                    active: false

                }, {
                    where: {
                        user_id: options.userId
                    }
                }).then(function(thread) {
                    if (!thread) {
                        console.log('update Games  error');
                        return;
                    }
                });

            }


            models.Games.create({
                topic: options.topic,
                level1value: options.level1value,
                level1: options.level1,
                level2value: options.level2value,
                level2: options.level2,
                level3value: options.level3value,
                level3: options.level3,
                level4value: options.level4value,
                level4: options.level4,
                user_id: options.userId,
                roomId: options.roomId,
                active: true
            }).then(function(Games) {



                models.User.update({
                    lovense: true,
                    lovenseTopic: options.topic

                }, {
                    where: {
                        id: options.userId
                    }
                }).then(function(thread) {
                    if (!thread) {
                        console.log('update User lovense  error');
                        return;
                    }
                });


                for (const [key, value] of Object.entries(options.toys)) {
                    var id_toy = null;
                    var name = null;
                    if (value) {


                        for (var values in options.items[key].toys) {

                            id_toy = options.items[key].toys[values].id;
                            name = options.items[key].toys[values].name;



                        }


                        models.Juguetes.create({
                            games_id: Games.id,
                            user_id: options.userId,
                            toyId: id_toy,
                            name: name,
                            deviceId: options.items[key].deviceId,
                            domain: options.items[key].domain,
                            httpsPort: options.items[key].httpsPort
                        }).then(function(Juguetes) {

                            if (!Juguetes) {
                                console.log('create Juguetes  error');
                                return;
                            }

                        });


                    }


                }


                socketComponent.socket.broadcast.to(options.roomId).emit('GamesModel', {
                    topic: options.topic
                });
                callback(options);
            });

        });


    });
};