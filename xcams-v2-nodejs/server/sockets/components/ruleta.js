const _ = require('lodash');
let models = require('../../models');
module.exports = function(socketComponent) {
    socketComponent.socket.on('RuletaModel', function(options, callback) {

console.log("ESTOY POR AQUI EN LA RULETA");


        models.Ruleta.findOne({
            where: {
                user_id: options.userId,
                active: 1
            }
        }).then(function(Ruleta) {
            if (Ruleta) {
                models.Ruleta.update({
                    active: false

                }, {
                    where: {
                        user_id: options.userId
                    }
                }).then(function(thread) {
                    if (!thread) {
                        console.log('update Ruleta  error');
                        return;
                    }
                });

            }



   for (var i in options.datos)
        {


               var ruletaTopic = options.datos[0].titulo;

                models.Ruleta.create({
                items: options.datos[i].task,
                goal: options.datos[i].goal,
                nivel: options.datos[i].nivel,
                titulo: options.datos[i].titulo,
                user_id: options.userId,
                roomId: options.roomId,
                active: true
                        }).then(function(Ruleta) {

                            if (!Ruleta) {
                                console.log('create Ruleta  error');
                                return;
                            }

                        });

        }

                models.User.update({
                    ruleta: true,
                    ruletaTopic: ruletaTopic

                }, {
                    where: {
                        id: options.userId
                    }
                }).then(function(thread) {
                    if (!thread) {
                        console.log('update User Ruleta  error');
                        return;
                    }
                });







            socketComponent.socket.emit('init-ruleta', {
                              datos: options,
                });

          
                socketComponent.socket.broadcast.to(options.roomId).emit('init-ruleta', {
                      datos: options,
                });
                callback(options);
            

        });


    });








    socketComponent.socket.on('finalizarRuleta', function(options, callback) {

console.log("FINALIZANDO LA RULETA");


        models.Ruleta.findOne({
            where: {
                user_id: options.userId,
                active: 1
            }
        }).then(function(Ruleta) {
            if (Ruleta) {
                models.Ruleta.update({
                    active: false

                }, {
                    where: {
                        user_id: options.userId
                    }
                }).then(function(thread) {
                    if (!thread) {
                        console.log('update Ruleta  error');
                        return;
                    }
                });

            }





                models.User.update({
                    ruleta: false,
                    ruletaTopic: null

                }, {
                    where: {
                        id: options.userId
                    }
                }).then(function(thread) {
                    if (!thread) {
                        console.log('update User Ruleta  error');
                        return;
                    }
                });







            socketComponent.socket.emit('finalizar-ruleta', {
                              datos: options,
                });

          
                socketComponent.socket.broadcast.to(options.roomId).emit('finalizar-ruleta', {
                      datos: options,
                });
                callback(options);
            

        });


    });








    socketComponent.socket.on('reInitRuleta', function(options, callback) {

            console.log("reInitRuleta LA RULETAaaaaaa");


console.log(options.datos.datos);
          /* se envia al modelo

           socketComponent.socket.emit('init-ruleta', {
                              datos: options,
                });*/

          
                socketComponent.socket.broadcast.to(options.roomId).emit('init-ruleta', {
                      datos: options.datos.datos,
                });
                
            

        });
















};