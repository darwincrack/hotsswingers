const _ = require('lodash');
let models = require('../../models');
module.exports = function(socketComponent) {
    socketComponent.socket.on('MultiretosModel', function(options, callback) {

console.log("ESTOY POR AQUI ");


        models.Multiretos.findOne({
            where: {
                user_id: options.userId,
                active: 1
            }
        }).then(function(Multiretos) {
            if (Multiretos) {
                models.Multiretos.update({
                    active: false,
                    reto_actual: false

                }, {
                    where: {
                        user_id: options.userId
                    }
                }).then(function(thread) {
                    if (!thread) {
                        console.log('update Multiretos  error');
                        return;
                    }
                });

            }


var reto_uno = "uno";
var reto_actual = 0;
   for (var i in options.datos)
        {


            if(i == 0){
                var reto_actual = 1;

            }else{
                var reto_actual = 0;

            }
                reto_uno = options.datos[0].task;

                models.Multiretos.create({
                reto_text: options.datos[i].task,
                goal: options.datos[i].goal,
                user_id: options.userId,
                roomId: options.roomId,
                active: true,
                reto_actual: reto_actual,
                posicion: parseInt(i) + 1
                        }).then(function(Multiretos) {

                            if (!Multiretos) {
                                console.log('create Multiretos  error');
                                return;
                            }

                        });

        }

                models.User.update({
                    multiretos: true,
                    multiretosTopic: reto_uno

                }, {
                    where: {
                        id: options.userId
                    }
                }).then(function(thread) {
                    if (!thread) {
                        console.log('update User Multiretos  error');
                        return;
                    }
                });


          
                socketComponent.socket.broadcast.to(options.roomId).emit('MultiretosModel', {
                      reto_text: options.reto_text,
                });
                callback(options);
            

        });


    });
};