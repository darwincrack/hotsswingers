//handler for broad cast streaming
//TODO - should change with redis or something else?
//hold for broadcast list conenct
var listOfBroadcasts = {};
var streamingStorage = require('./../storages/streaming');
var _ = require('lodash');
let models  = require('../models');
let Redis = require('../components/Redis');
var moment = require('moment');
var PushService = require('../push/push');
var async = require('async');
var listOfUsers = {};
var shiftedModerationControls = {};
var ScalableBroadcast;
var MAX_CONNECTORS = 50; //should be 3 for scalable
let STREAMING_CACHE_PREFIX = 'STREAMING_';
var prueba = "";

function getFirstAvailableBraodcater(user) {

  var broadcasters = listOfBroadcasts[user.broadcastid].broadcasters;
  var firstResult;
  for (var userid in broadcasters) {
    if (broadcasters[userid].numberOfViewers <= MAX_CONNECTORS) {
      firstResult = broadcasters[userid];
      continue;
    } else delete listOfBroadcasts[user.broadcastid].broadcasters[userid];
  }
  return firstResult;
}

var firstAvailableBroadcasters = {};

module.exports = exports = {
  register: function(socket) {
    var currentUser;

  socket.on('videoprivadox-activar', function(body) {  


  models.ChatThread.findOne({
            where: { id: socket.threadId, isStreaming: 1, ownerId: socket.user.id}
          }).then(function(room) {
            if (!room) {
              return;
            }


            models.User.update({
                              videoPrivado: true,
                              tokensVideoPrivado: body.tokens

                          }, {
                              where: {
                                  id: room.get('ownerId')
                              }
                          }).then(function(thread) {
                              if (!thread) {
                                  console.log('update User Multiretos  error');
                                  return;
                              }
                          });


  });

              




    console.log("por aqui pasooooooooooooooooo videoprivadox-activar");
     socket.broadcast.to(socket.threadId).emit('videoprivadox-activar', {
        message: 'ok',
        tokens: body.tokens
      });
  });


  socket.on('videoprivadox-desactivar', function(body) {    


 models.ChatThread.findOne({
            where: { id: socket.threadId, isStreaming: 1, ownerId: socket.user.id}
          }).then(function(room) {
            if (!room) {
              return;
            }


            models.User.update({
                              videoPrivado: false,
                             

                          }, {
                              where: {
                                  id: room.get('ownerId')
                              }
                          }).then(function(thread) {
                              if (!thread) {
                                  console.log('update User Multiretos  error');
                                  return;
                              }
                          });


  });


    console.log("por aqui pasooooooooooooooooo videoprivadox-desactivar");
     socket.broadcast.to(socket.threadId).emit('videoprivadox-desactivar', {
        message: 'ok'
      });
  });

    socket.on('check-broadcast-presence', function (broadcastid, callback) {
      // we can pass number of viewers as well
      try {
         callback(firstAvailableBroadcasters[broadcastid] && firstAvailableBroadcasters[broadcastid].openBroadcast === true);
      } catch (e) {
        consoleLog(e);
      }
    });
    socket.on('join-broadcast', function(user) {
      
      console.log("MODELOID");
   //   console.log(user.modeloid);
     console.log("USERID");
    //  console.log(socket.user.id);

      




      currentUser = user;
      socket.broadcastUser =  user;
      socket.modeloid = user;
      var modelHasJoined = false;

      console.log("SOCKET MODELO");
      //console.log(socket.broadcastUser.modeloid);

     // prueba = socket.broadcastUser.modeloid;

      user.numberOfViewers = 0;
      //if user is model we can open a new room, otherwise check room and notify for user if it does not exist
      //TODO - should create model room from model jwt id instead of broadcastid
      //TODO - check model id with broadcastid
      if (!listOfBroadcasts[user.broadcastid]) {
        if (socket.user && socket.user.role === 'model' && socket.user.id == user.modeloid) {

         // console.log("soy modelo");
          listOfBroadcasts[user.broadcastid] = {
            broadcasters: {},
            allusers: {},
            typeOfStreams: user.typeOfStreams, // object-booleans: audio, video, screen
            openBroadcast: false
          };

          //pass broadcastid as session
          socket.broadcastid = user.broadcastid;
          //flag key to update event if model join any room
          modelHasJoined = true;

          //add model to broadcaster
          firstAvailableBroadcasters[user.broadcastid] = {
            broadcastid            : user.broadcastid,
            userid                 : user.userid,
            goalId                 : user.goalId,
            goalTipTitle           : user.goalTipTitle,
            goalTipAmountAchieved  : user.goalTipAmountAchieved,
            goalTipAmountGoal      : user.goalTipAmountGoal,
            archievedGoalTipsNumber: user.archievedGoalTipsNumber,
            lastedArchievedGoalTip : user.lastedArchievedGoalTip,
            typeOfStreams          : { video: true, screen: false, audio: true, oneway: true },
            numberOfViewers        : 0,
            openBroadcast          : false
          };

        } else {
          //do nothing and alert to user that room is not exist
          return socket.emit('broadcast-error', {
            msg: 'Model is not available in this room'
          });
        }
      } else {
        if (socket.user && socket.user.role === 'model'  && socket.user.id == user.modeloid) {

           console.log("soyyyyyyyyyyyy modelo");
          modelHasJoined = true;
          listOfBroadcasts[user.broadcastid].typeOfStreams = { video: true, screen: false, audio: true, oneway: true };
          listOfBroadcasts[user.broadcastid].openBroadcast = false;

         
          firstAvailableBroadcasters[user.broadcastid].userid = user.userid; 
        }
      }

      // console.log('join-broadcaster data', user);

      //var firstAvailableBroadcaster = getFirstAvailableBraodcater(user);
      //model will be broadcaster

if(socket.user && socket.user.role === 'model' && socket.user.id == user.modeloid){
  var firstAvailableBroadcaster= null;
}else{
  var firstAvailableBroadcaster= firstAvailableBroadcasters[user.broadcastid];
}


      //var firstAvailableBroadcaster = socket.user && socket.user.role === 'model' ? null : firstAvailableBroadcasters[user.broadcastid];
      //only emit for
      if (firstAvailableBroadcaster) {
        if(firstAvailableBroadcaster.openBroadcast){
            //listOfBroadcasts[user.broadcastid].broadcasters[firstAvailableBroadcaster.userid].numberOfViewers++;
          socket.emit('join-broadcaster', firstAvailableBroadcaster, listOfBroadcasts[user.broadcastid].typeOfStreams);

          //TODO update viewer time here
          //if(socket.user && socket.user.role == 'member') {
            if(socket.user && socket.user.id != user.modeloid) {
            models.ChatThreadUser.update({
              isStreaming: true,
              lastStreamingTime: new Date()
            }, {
              where: {threadId: socket.threadId, userId: socket.user.id}
            });
            socket.broadcast.to(socket.threadId).emit('join-room', socket.user);
          }

          // console.log('User <', user.userid, '> is trying to get stream from user <', firstAvailableBroadcaster.userid, '>');
        }else{
          // console.log('Room does not init');
          socket.emit('public-room-status', false);
        }
      } else if(user.openBroadcast){
        currentUser.isInitiator = true;
        // console.log('broadcast data',user);
        firstAvailableBroadcasters[user.broadcastid].openBroadcast = true;
        socket.emit('start-broadcasting', listOfBroadcasts[user.broadcastid].typeOfStreams);


    console.log("11072021");

        models.ChatThread.update({
          isStreaming: true,
          lastStreamingTime: new Date(),
          sendMail:true
        }, {
          where: {id: socket.threadId, ownerId: socket.user.id}
        }).then(function(thread) {
          if(!thread){console.log( 'Update isStreaming = true error');return;}

          // console.log('User <', user.room, '> will be next to serve broadcast.');
          socket.broadcast.to(socket.threadId).emit('public-chat-init', user);
          // //send push notification here
          PushService.push(socket, 'online');
        });
      }
      listOfBroadcasts[user.broadcastid].broadcasters[user.userid] = user;
      listOfBroadcasts[user.broadcastid].allusers[user.userid] = user;

      //storage this socket into streaming storage to emit event
      streamingStorage.add(user.broadcastid, socket);

      if (modelHasJoined && listOfBroadcasts[user.broadcastid].typeOfStreams.video) {
        //send reconnect event to client?
        //send re join event to clients
        if (socket.user && socket.user.role === 'model' && socket.user.id == user.modeloid) {

          streamingStorage.emitToRoom(user.broadcastid, 'rejoin-broadcast', { id: user.broadcastid }, [socket]);
        }
        // console.log('rejoin broadcast');
      }
      var broadcastUser = socket.broadcastUser;

      //Set list of broadcast to redis for shared data for multile platforms
      Redis.get(STREAMING_CACHE_PREFIX + 'USERS', function(err, users) {
        if (err) { return; }

        if (!users) { users = []; }
        else {
          users = JSON.parse(users);
        }
        //push user to the array
        users.push(broadcastUser);

        //set to redis
        Redis.set(STREAMING_CACHE_PREFIX + 'USERS', JSON.stringify(users));
      });
    });

    socket.on('broadcast-message', function(message) {
      socket.broadcast.emit('broadcast-message', message);
    });

    socket.on('disconnect', function(datos) {
      //remove socket
     console.log("ANTES DE SOCKET MODELOOOOO");
      //console.log(prueba);
      streamingStorage.remove(socket);
      var broadcastUser = socket.broadcastUser;

     // console.log(broadcastUser);
 console.log("SOCKET MODELOOOOO");

 //console.log(prueba);

  console.log("----------------sssdfds");

  // console.log(socket);
      //if model is disconnect, remove all sockets which are viewing this mode
      //TODO - check streaming model here because shared session
var modeloid = null;
if (broadcastUser) {
  var modeloid = socket.broadcastUser.modeloid;
}
console.log("PENDIENTE UNO-- ---------");
//console.log(modeloid);
console.log("PENDIENTE UNO");
//PENDIENTE POR AQUI
      if (socket.user && socket.user.role === 'model' && socket.user.id == modeloid) {

        console.log("BORRAR BROSCASTER");
        //check broadcast id
        delete listOfBroadcasts[socket.broadcastid];
        delete firstAvailableBroadcasters[socket.broadcastid];
        console.log('================= model-left');
        streamingStorage.emitToRoom(socket.broadcastid, 'model-left');

        if (broadcastUser) {
          models.ChatThread.findOne({
            where: { id: socket.threadId, isStreaming: 1, ownerId: socket.user.id}
          }).then(function(room) {
            if (!room) {
              return;
            }
            var endDate = moment(new Date());//now
            var startDate = moment(room.get('lastStreamingTime'));


            console.log("POR AQUI SIEMPRE PASA");

             console.log(room.get('ownerId'));


            models.Games.update({
              active: false
            }, {
              where: {user_id: room.get('ownerId')}
            }).then(function(thread) {
              if(!thread) { console.log('update games lovense false error'); return;}
              
            });



     models.Multiretos.update({
              active: false,
              reto_actual: false
            }, {
              where: {user_id: room.get('ownerId')}
            }).then(function(thread) {
              if(!thread) { console.log('update multiretos lovense false error'); return;}
              
            });


            models.Ruleta.update({
              active: false
            }, {
              where: {user_id: room.get('ownerId')}
            }).then(function(thread) {
              if(!thread) { console.log('update ruleta lovense false error'); return;}
              
            });


          models.Videoprivadotokens.update({
              active: false,
            }, {
              where: {modelId: room.get('ownerId')}
            }).then(function(thread) {
              if(!thread) { console.log('update Videoprivadotokens false error'); return;}
              
            });
    
            models.User.update({
              lovense: false,
              lovenseTopic: null
            }, {
              where: {id: room.get('ownerId')}
            }).then(function(thread) {
              if(!thread) { console.log('update user lovense false error'); return;}
              
            });


           models.User.update({
              videoPrivado: false,
            }, {
              where: {id: room.get('ownerId')}
            }).then(function(thread) {
              if(!thread) { console.log('update user lovense false error'); return;}
              
            });





            models.User.update({
              multiretos: false,
              multiretosTopic: null
            }, {
              where: {id: room.get('ownerId')}
            }).then(function(thread) {
              if(!thread) { console.log('update user lovense false error'); return;}
              
            });



            models.User.update({
              ruleta: false,
              ruletaTopic: null
            }, {
              where: {id: room.get('ownerId')}
            }).then(function(thread) {
              if(!thread) { console.log('update user ruleta false error'); return;}
              
            });



            models.ChatThread.update({
              isStreaming: false,
              sendMail:false,
              streamingTime: parseInt(room.get('streamingTime') + endDate.diff(startDate, 'minutes')) || 0
            }, {
              where: {id: room.get('id')}
            }).then(function(thread) {
              if(!thread) { console.log('update thread status false error'); return;}
              //send push notification here
              PushService.push(socket, 'offline');
            });
          });
          //TODO update ChatThreadUser here
          models.ChatThreadUser.findAll({
            where: {
              threadId: socket.threadId,
              isStreaming: true
            }
          }).then(function(threadUsers) {
            if(!threadUsers){
              return;
            }

            async.map(threadUsers, function (item, cb) {
              var endDate = moment(new Date());//now
              var startDate = moment(item.lastStreamingTime);

              models.ChatThreadUser.update({
                isStreaming: false,
                streamingTime: parseInt(item.streamingTime + endDate.diff(startDate, 'minutes')) || 0
              }, {
                where: {id: item.id}
              }).then(function(threadUser) {
                if(!threadUser){
                  console.log('disconnected: Save threadUser error');
                }
                cb();
              }).catch(() => cb());
            }, function(err, results) {
              console.log(err);
            });
          });
        }
      }else if(socket.user){
        // console.log('disconnected Update ChatThreadUser');
        models.ChatThreadUser.findOne({
          where: {
              threadId: socket.threadId,
              isStreaming: true,
              userId: socket.user.id
            }
          }).then(function(threadUser) {
            if(!threadUser){
              return;
            }

            var endDate = moment(new Date());//now
            var startDate = moment(threadUser.get('lastStreamingTime'));

            models.ChatThreadUser.update({
              isStreaming: false,
              streamingTime: parseInt(threadUser.get('streamingTime') + endDate.diff(startDate, 'minutes')) || 0
            }, {
              where: {id: threadUser.get('id')}
            });
          });
      }

      if (!currentUser) return;
      if (!listOfBroadcasts[currentUser.broadcastid]) return;
      if (!listOfBroadcasts[currentUser.broadcastid].broadcasters[currentUser.userid]) return;
    
      delete listOfBroadcasts[currentUser.broadcastid].broadcasters[currentUser.userid];
      delete listOfBroadcasts[currentUser.broadcastid].allusers[currentUser.userid];
      if (currentUser.isInitiator) {
        delete listOfBroadcasts[currentUser.broadcastid];
      }

      if (broadcastUser) {
        //update redis
        Redis.get(STREAMING_CACHE_PREFIX + 'USERS', function(err, users) {
          if (err || !users) { return; }
          users = JSON.parse(users);

          _.remove(users, function(user) {
            return user.userid === broadcastUser.userid;
          });

          //set to redis
          Redis.set(STREAMING_CACHE_PREFIX + 'USERS', JSON.stringify(users));
        });
      }
    });

    socket.on('has-broadcast', function(broadcastid, cb) {
      if (typeof cb !== 'function') { return; }
      if (listOfBroadcasts[broadcastid]) {
        cb(true);
      } else {
        cb(false);
      }
    });
    
    



    function appendUser(socket) {
        var alreadyExists = listOfUsers[socket.userid];
        var extra = {};

        if (alreadyExists && alreadyExists.extra) {
            extra = alreadyExists.extra;
  }

        var params = socket.handshake.query;

        if (params.extra) {
            try {
                if (typeof params.extra === 'string') {
                    params.extra = JSON.parse(params.extra);
                }
                extra = params.extra;
            } catch (e) {
                extra = params.extra;
            }
        }

        listOfUsers[socket.userid] = {
            socket: socket,
            connectedWith: {},
            isPublic: false, // means: isPublicModerator
            extra: extra || {}
};
    }
    
        var params = socket.handshake.query;
        var socketMessageEvent = params.msgEvent || 'RTCMultiConnection-Message';

        var sessionid = params.sessionid;
        var autoCloseEntireSession = params.autoCloseEntireSession;

//        if (params.enableScalableBroadcast) {
//            if (!ScalableBroadcast) {
//                ScalableBroadcast = require('./Scalable-Broadcast.js');
//            }
//            ScalableBroadcast(socket, params.maxRelayLimitPerUser);
//        }

        // temporarily disabled
        if (params.userid !== 'undefined') {
            if (false && !!listOfUsers[params.userid]) {
              params.dontUpdateUserId = true;

              var useridAlreadyTaken = params.userid;
              params.userid = (Math.random() * 1000).toString().replace('.', '');
              socket.emit('userid-already-taken', useridAlreadyTaken, params.userid);
            }

            if (params.userid) {

              socket.userid = params.userid;
              console.log('appendUser socket');
              appendUser(socket);
            }
        }

        if (autoCloseEntireSession == 'false' && Object.keys(listOfUsers).length == 1) {
            socket.shiftModerationControlBeforeLeaving = true;
        }

        socket.on('shift-moderator-control-on-disconnect', function() {
            socket.shiftModerationControlBeforeLeaving = true;
        });

        socket.on('extra-data-updated', function(extra) {
            try {
                if (!listOfUsers[socket.userid]) return;
                listOfUsers[socket.userid].extra = extra;

                for (var user in listOfUsers[socket.userid].connectedWith) {
                    listOfUsers[user].socket.emit('extra-data-updated', socket.userid, extra);
                }
            } catch (e) {
                pushLogs('extra-data-updated', e);
            }
        });

        socket.on('get-remote-user-extra-data', function(remoteUserId, callback) {
            callback = callback || function() {};
            if (!remoteUserId || !listOfUsers[remoteUserId]) {
                callback('remoteUserId (' + remoteUserId + ') does NOT exist.');
                return;
            }
            callback(listOfUsers[remoteUserId].extra);
        });

        socket.on('become-a-public-moderator', function() {
            try {
                if (!listOfUsers[socket.userid]) return;
                listOfUsers[socket.userid].isPublic = true;
            } catch (e) {
                pushLogs('become-a-public-moderator', e);
            }
        });

        var dontDuplicateListeners = {};
        socket.on('set-custom-socket-event-listener', function(customEvent) {
            if (dontDuplicateListeners[customEvent]) return;
            dontDuplicateListeners[customEvent] = customEvent;

            socket.on(customEvent, function(message) {
                try {
                    socket.broadcast.emit(customEvent, message);
                } catch (e) {}
            });
        });

        socket.on('dont-make-me-moderator', function() {
            try {
                if (!listOfUsers[socket.userid]) return;
                listOfUsers[socket.userid].isPublic = false;
            } catch (e) {
                pushLogs('dont-make-me-moderator', e);
            }
        });

        socket.on('get-public-moderators', function(userIdStartsWith, callback) {
            try {
                userIdStartsWith = userIdStartsWith || '';
                var allPublicModerators = [];
                for (var moderatorId in listOfUsers) {
                    if (listOfUsers[moderatorId].isPublic && moderatorId.indexOf(userIdStartsWith) === 0 && moderatorId !== socket.userid) {
                        var moderator = listOfUsers[moderatorId];
                        allPublicModerators.push({
                            userid: moderatorId,
                            extra: moderator.extra
                        });
                    }
                }

                callback(allPublicModerators);
            } catch (e) {
                pushLogs('get-public-moderators', e);
            }
        });

        socket.on('changed-uuid', function(newUserId, callback) {
          console.log('changed-uuid');
            callback = callback || function() {};
            if (params.dontUpdateUserId) {
                delete params.dontUpdateUserId;
                return;
            }

            try {
                if (listOfUsers[socket.userid] && listOfUsers[socket.userid].socket.userid == socket.userid) {
                    if (newUserId === socket.userid) return;

                    var oldUserId = socket.userid;
                    listOfUsers[newUserId] = listOfUsers[oldUserId];
                    listOfUsers[newUserId].socket.userid = socket.userid = newUserId;
                    delete listOfUsers[oldUserId];
                     console.log(' delete listOfUsers[oldUserId];', newUserId);
                    console.log(' delete listOfUsers[oldUserId];', oldUserId);
                    callback();
                    return;
                }

                socket.userid = newUserId;
                appendUser(socket);

                callback();
            } catch (e) {
                pushLogs('changed-uuid', e);
            }
        });

        socket.on('set-password', function(password) {
            try {
                if (listOfUsers[socket.userid]) {
                    listOfUsers[socket.userid].password = password;
                }
            } catch (e) {
                pushLogs('set-password', e);
            }
        });

        socket.on('disconnect-with', function(remoteUserId, callback) {
            try {
              console.log('disconnect-with',remoteUserId);
                if (listOfUsers[socket.userid] && listOfUsers[socket.userid].connectedWith[remoteUserId]) {
                    delete listOfUsers[socket.userid].connectedWith[remoteUserId];
                    socket.emit('user-disconnected', remoteUserId);
                }

                if (!listOfUsers[remoteUserId]) return callback();

                if (listOfUsers[remoteUserId].connectedWith[socket.userid]) {
                    delete listOfUsers[remoteUserId].connectedWith[socket.userid];
                    listOfUsers[remoteUserId].socket.emit('user-disconnected', socket.userid);
                }
                callback();
            } catch (e) {
                pushLogs('disconnect-with', e);
            }
        });

        socket.on('close-entire-session', function(callback) {
          consoe.log('close-entire-session');
            try {
                var connectedWith = listOfUsers[socket.userid].connectedWith;
                Object.keys(connectedWith).forEach(function(key) {
                    if (connectedWith[key] && connectedWith[key].emit) {
                        try {
                            connectedWith[key].emit('closed-entire-session', socket.userid, listOfUsers[socket.userid].extra);
                        } catch (e) {}
                    }
                });

                delete shiftedModerationControls[socket.userid];
                callback();
            } catch (e) {
                pushLogs('close-entire-session', e);
            }
        });
   

         socket.on('check-presence', function(userid, callback) {
            if (userid === socket.userid && !!listOfUsers[userid]) {
                callback(false, socket.userid, listOfUsers[userid].extra);
                return;
            }

            var extra = {};
            if (listOfUsers[userid]) {
                extra = listOfUsers[userid].extra;
            }
            console.log('userid',userid);
            console.log('listOfUsers[userid]',listOfUsers[userid]);
            console.log('check',!!listOfUsers[userid]);
            callback(!!listOfUsers[userid], userid, extra);
        });


        function onMessageCallback(message) {
            try {
                if (!listOfUsers[message.sender]) {
                    socket.emit('user-not-found', message.sender);
                    return;
                }

                if (!message.message.userLeft && !listOfUsers[message.sender].connectedWith[message.remoteUserId] && !!listOfUsers[message.remoteUserId]) {
                    listOfUsers[message.sender].connectedWith[message.remoteUserId] = listOfUsers[message.remoteUserId].socket;
                    listOfUsers[message.sender].socket.emit('user-connected', message.remoteUserId);

                    if (!listOfUsers[message.remoteUserId]) {
                        listOfUsers[message.remoteUserId] = {
                            socket: null,
                            connectedWith: {},
                            isPublic: false,
                            extra: {},
                            maxParticipantsAllowed: params.maxParticipantsAllowed || 1000
                        };
                    }

                    listOfUsers[message.remoteUserId].connectedWith[message.sender] = socket;
                   
                    if (listOfUsers[message.remoteUserId].socket) {
                      console.log('user-connected');
                        listOfUsers[message.remoteUserId].socket.emit('user-connected', message.sender);
                    }
                }

                if (listOfUsers[message.sender].connectedWith[message.remoteUserId] && listOfUsers[socket.userid]) {
                    message.extra = listOfUsers[socket.userid].extra;
                    console.log('message.sender',message.sender);
                    console.log('connectedWith',message.remoteUserId);
                    listOfUsers[message.sender].connectedWith[message.remoteUserId].emit(socketMessageEvent, message);
                }
            } catch (e) {
                pushLogs('onMessageCallback', e);
            }
        }

        function joinARoom(message) {
            var roomInitiator = listOfUsers[message.remoteUserId];

            if (!roomInitiator) {
              console.log('room not found');
                return;
            }

            var usersInARoom = roomInitiator.connectedWith;

            var maxParticipantsAllowed = roomInitiator.maxParticipantsAllowed;

            if (Object.keys(usersInARoom).length >= maxParticipantsAllowed) {
              console.log('room-full');
                socket.emit('room-full', message.remoteUserId);

                if (roomInitiator.connectedWith[socket.userid]) {
                    delete roomInitiator.connectedWith[socket.userid];
                }
                return;
            }

            var inviteTheseUsers = [roomInitiator.socket];
                      Object.keys(usersInARoom).forEach(function(key) {
                inviteTheseUsers.push(usersInARoom[key]);
            });
              console.log('inviteTheseUsers',inviteTheseUsers.length);

            var keepUnique = [];
            var i = 1;
            inviteTheseUsers.forEach(function(userSocket) {
              console.log(i);
              i++;
                if (userSocket.userid == socket.userid) return;
                if (keepUnique.indexOf(userSocket.userid) != -1) {
                    return;
                }
                keepUnique.push(userSocket.userid);

                if (params.oneToMany && userSocket.userid !== roomInitiator.socket.userid) return;

                message.remoteUserId = userSocket.userid;
                console.log('userSocket',userSocket.userid);
                console.log('message.remoteUserId',message.remoteUserId);
                 console.log('message.remoteUserId=========================');
                userSocket.emit(socketMessageEvent, message);
            });
        }

        var numberOfPasswordTries = 0;
        socket.on(socketMessageEvent, function(message, callback) {
            console.log('message.remoteUserId',message.remoteUserId);
            console.log('socket.userid',socket.userid)
            if (message.remoteUserId && message.remoteUserId === socket.userid) {
                // remoteUserId MUST be unique
                return;
            }

            try {
              
              
                if (message.remoteUserId && message.remoteUserId != 'system' && message.message.newParticipationRequest) {
                    if (listOfUsers[message.remoteUserId] && listOfUsers[message.remoteUserId].password) {
                        if (numberOfPasswordTries > 3) {
                            socket.emit('password-max-tries-over', message.remoteUserId);
                            return;
                        }

                        if (!message.password) {
                            numberOfPasswordTries++;
                            socket.emit('join-with-password', message.remoteUserId);
                            return;
                        }

                        if (message.password != listOfUsers[message.remoteUserId].password) {
                            numberOfPasswordTries++;
                            socket.emit('invalid-password', message.remoteUserId, message.password);
                            return;
                        }
                    }
               
                    if (listOfUsers[message.remoteUserId]) {
                        joinARoom(message);
                        return;
                    }
                }

                if (message.message.shiftedModerationControl) {
                  console.log('shiftedModerationControl');
                    if (!message.message.firedOnLeave) {
                        onMessageCallback(message);
                        return;
                    }
                    shiftedModerationControls[message.sender] = message;
                    return;
                }

                // for v3 backward compatibility; >v3.3.3 no more uses below block
               
                if (message.remoteUserId == 'system') {
                    if (message.message.detectPresence) {
                        if (message.message.userid === socket.userid) {
                            callback(false, socket.userid);
                            return;
                        }

                        callback(!!listOfUsers[message.message.userid], message.message.userid);
                        return;
                    }
                }

                if (!listOfUsers[message.sender]) {
                    listOfUsers[message.sender] = {
                        socket: socket,
                        connectedWith: {},
                        isPublic: false,
                        extra: {},
                        maxParticipantsAllowed: params.maxParticipantsAllowed || 1000
                    };
                }
             
                // if someone tries to join a person who is absent
                if (message.message.newParticipationRequest) {
        
                    var waitFor = 60 * 10; // 10 minutes
                    var invokedTimes = 0;
                    (function repeater() {
                        if (typeof socket == 'undefined' || !listOfUsers[socket.userid]) {
                            return;
                        }

                        invokedTimes++;
                        if (invokedTimes > waitFor) {
                            socket.emit('user-not-found', message.remoteUserId);
                            return;
                        }

                        if (listOfUsers[message.remoteUserId] && listOfUsers[message.remoteUserId].socket) {
                            joinARoom(message);
                            return;
                        }

                        setTimeout(repeater, 1000);
                    })();

                    return;
                }
                console.log('send onMessageCallback');
                onMessageCallback(message);
            } catch (e) {
                pushLogs('on-socketMessageEvent', e);
            }
        });

        socket.on('disconnect', function() {
            try {
                if (socket && socket.namespace && socket.namespace.sockets) {
                    delete socket.namespace.sockets[this.id];
                }
            } catch (e) {
                pushLogs('disconnect', e);
            }

            try {
                var message = shiftedModerationControls[socket.userid];

                if (message) {
                    delete shiftedModerationControls[message.userid];
                    onMessageCallback(message);
                }
            } catch (e) {
                pushLogs('disconnect', e);
            }

            try {
                // inform all connected users
                if (listOfUsers[socket.userid]) {
                    var firstUserSocket = null;
                    for (var s in listOfUsers[socket.userid].connectedWith) {
                        if (!firstUserSocket) {
                            firstUserSocket = listOfUsers[socket.userid].connectedWith[s];
                        }

                        listOfUsers[socket.userid].connectedWith[s].emit('user-disconnected', socket.userid);

                        if (listOfUsers[s] && listOfUsers[s].connectedWith[socket.userid]) {
                            delete listOfUsers[s].connectedWith[socket.userid];
                            listOfUsers[s].socket.emit('user-disconnected', socket.userid);
                        }
                    }

                    if (socket.shiftModerationControlBeforeLeaving && firstUserSocket) {
                        firstUserSocket.emit('become-next-modrator', sessionid);
                    }
                }
            } catch (e) {
                pushLogs('disconnect', e);
            }
            console.log('xxdelete listOfUsers[socket.userid]',socket.userid);
            delete listOfUsers[socket.userid];
         
        });
  }
};var enableLogs = false;

try {
    var _enableLogs = require('./config.json').enableLogs;

    if (_enableLogs) {
        enableLogs = true;
    }
} catch (e) {
    enableLogs = false;
}

var fs = require('fs');

function pushLogs() {
  
    if (!enableLogs) return;
    console.log('eaweaw');
    var logsFile = process.cwd() + '/logs.json';

    var utcDateString = (new Date).toUTCString().replace(/ |-|,|:|\./g, '');

    // uncache to fetch recent (up-to-dated)
    uncache(logsFile);

    var logs = {};

    try {
        logs = require(logsFile);
    } catch (e) {}

    if (arguments[1] && arguments[1].stack) {
        arguments[1] = arguments[1].stack;
    }

    try {
        logs[utcDateString] = JSON.stringify(arguments, null, '\t');
        fs.writeFileSync(logsFile, JSON.stringify(logs, null, '\t'));
    } catch (e) {
        logs[utcDateString] = arguments.toString();
    }
}

// removing JSON from cache
function uncache(jsonFile) {
    searchCache(jsonFile, function(mod) {
        delete require.cache[mod.id];
    });

    Object.keys(module.constructor._pathCache).forEach(function(cacheKey) {
        if (cacheKey.indexOf(jsonFile) > 0) {
            delete module.constructor._pathCache[cacheKey];
        }
    });
}

function searchCache(jsonFile, callback) {
    var mod = require.resolve(jsonFile);

    if (mod && ((mod = require.cache[mod]) !== undefined)) {
        (function run(mod) {
            mod.children.forEach(function(child) {
                run(child);
            });

            callback(mod);
        })(mod);
    }
}