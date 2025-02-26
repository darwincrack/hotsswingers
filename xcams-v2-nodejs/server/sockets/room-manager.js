let models  = require('../models');
import jwt from 'jsonwebtoken';
import _ from 'lodash';

var memberStorages = require('./../storages/member');
var modelStorages = require('./../storages/model');
let Redis = require('../components/Redis');
const RedisHelper = require('../components/RedisHelper');

let PRIVATE_CACHE_PREFIX = 'PRIVATE_';

var rooms = {};
var clients = [];
var moment = require('moment');
var Cache = require('../components/Cache');

var prueba = "";

export function register(socket) {

  socket.on('join-room', function(data, fn){
//    modelStorages.disconnectOtherModelSockets(socket);
    socket.threadId = data.roomId || null;
    data.userData = socket.user || {};
    var roomId = data.roomId;
    var userId = data.userData.id;
    var userRole = data.userData.role;
    var type = data.type;
     var modeloid = data.modeloid;
    socket.chatType = data.type;

   console.log("probando probando");
   // console.log(socket.broadcastUser);


  console.log("OTRO  probando");
  //  prueba = socket.broadcastUser;

     // console.log(modeloid);
  console.log("FIN  probando");
   // socket.user.modeloid = 2 || null;

      console.log("DARWIN6xxxxx-member");

   //   console.log(socket.broadcastUser);
      //console.log("DARWIN25-member");
    //  console.log(userId);
   // if(socket.user && modeloid === 'member'){

     if(socket.user && modeloid != userId){

      console.log("DARWIN6-member");
      memberStorages.add(data.roomId, socket.user);
      models.ChatThreadUser.findOne({
        where:  {  threadId: socket.threadId,
                  userId: socket.user.id
                }
      }).then(function(threadUser) {
        if(!threadUser){
          return models.ChatThreadUser.create({
            threadId: socket.threadId,
            userId: socket.user.id,
            isStreaming: true,
            streamingTime: 0
          });
        }else{
          models.ChatThreadUser.update({
            isStreaming: true,
            lastStreamingTime: new Date()
          }, {
            where: {
              id: threadUser.id,
              userId:socket.user.id
            }
          });
        }
      });
    }else if(!socket.user) {
      memberStorages.add(data.roomId, {
        role: 'guest',
        id: socket.request.connection.remoteAddress
      });
      models.ChatThreadUser.findOne({
        where: {threadId: socket.threadId,
          ip: socket.request.connection.remoteAddress
        }
      }).then(function(threadUser) {
        if(!threadUser){
          return models.ChatThreadUser.create({
            threadId: socket.threadId,
            userId: 0,
            isStreaming: true,
            streamingTime: 0,
            ip: socket.request.connection.remoteAddress
          });
        }else{
          models.ChatThreadUser.update({
            isStreaming: true,
            lastStreamingTime: new Date(),
          }, {
            where: {
              id: threadUser.id,
              ip: socket.request.connection.remoteAddress
            }
          });
        }
      });
    }

    socket.roomId = data.roomId;
    //TODO - verify role & create room
    // var model = modelStorages.get(socket);
    // var modelId = (model[0]) ? model[0].id : null;


    // models.ChatThread.findOne({
    //   where: { type: data.type, ownerId: modelId, id: socket.threadId}
    // }).then(function(thread) {
    //   if (!thread) {
    //     console.log('Room is not found');
    //     return null;
    //   }

    //   return thread;
    // }).then(function(thread) {
    //   if (!thread) {
    //     rooms[roomId] = {};
    //   } else {
    //     if(socket.user && thread.ownerId != socket.user.id) {
    //       Cache.findOrCreateChatThreadUser(thread.id, socket.user.id, function(err, threadUser) {
    //         if (err) {
    //           //call disconnect?
    //           return;
    //         }
    //       });
    //     }
    //     //if has roomId call socket.join
    //     socket.join(roomId);
    //   }
    // });
    console.log('Joined room '+ roomId);

    console.log("VISORES TOTALESSSSS")
    socket.join(roomId);
    var members = memberStorages.get(roomId);
    socket.broadcast.to(roomId).emit('online-members', {members});
    //add to redis
    RedisHelper.addToRoom(roomId, socket.userId, socket.user ? 'model' : 'guest', function() {
      RedisHelper.getAllRoomMembers(roomId, function (err, data) {
        let total = 0;
        if (err || _.isEmpty(data)) {
          total = 0;
        } else {
          let guests = 0;
          let members = 0;
          for (let k in data) {
            if (data[k] === 'guest') {
              guests++;
            } else {
              members++;
            }
          }
        //  total = guests + members - 1;

          total = members - 1;
        }

console.log("VISORES TOTALESSSSS RESOLTADOS: "+total)

console.log(data)

//console.log(data[k]);

console.log("total: "+total)
//console.log("members: "+members)
        models.ChatThread.update({
          totalViewer: total
        }, {
            where: { id: roomId }
          });


      });
    });
  });

  /**
  * create private room or get current thread for the private message chage
  */
  socket.on('join-private-room', function(data, fn) {
    //restriction, for logged in user only
    if (!socket.user) { return; }

    //TODO - check restriction
    models.ChatThread.findOne({
      where: {
        ownerId: data.modelId,
        requesterId: data.memberId
      }
    }).then(function(thread) {

      if (!thread) {
        return models.ChatThread.create({
          type: 'private',
          ownerId: data.modelId,
          requesterId: data.memberId,
          streamingTime: 0
        });
      }

      return thread;
    }).then(function(thread) {
      console.log('room: ',thread.id);
      //join this socket to private room
      socket.join(thread.id);

      if (fn && _.isFunction(fn)) {
        fn({ id: thread.id });
      }

      console.log('join private chat ');
      socket.broadcast.to(thread.id).emit('join-room', socket.user);
    });
  });

  socket.on('disconnect', function() {

    


    try {
      if (socket.user) {

var modeloid = null;
if (typeof socket.modeloid != 'undefined') {
  modeloid = socket.modeloid;
  console.log("por aqui");
}


  console.log('TU DESCONEX');
//console.log(socket.user.id);
     console.log('TU DESCONEXsdfds');
//console.log(  socket.modeloid);
     console.log('TU werewrewDESCONEXsdfds');


console.log("quien transmite");

  console.log("quien OTRO  probando");
  //  prueba = socket.broadcastUser;

      //console.log(prueba);
  console.log("quien FIN  probando");

//console.log(socket.broadcastUser);

console.log("COMENZANDO EL TRABAJO disconnect");
  console.log(modeloid);
        socket.broadcast.to(socket.roomId).emit('leave-room', socket.user);
        memberStorages.remove(socket.user);
        if(socket.user.role == 'model' && (socket.user.id == modeloid || modeloid == null)){
          console.log("DARWIN7-model");
          modelStorages.remove(socket);
        }else if(socket.modeloid !=socket.user.id){
           //}else if(socket.user.role == 'member'){
          console.log("DARWIN8-member");
          models.ChatThreadUser.findOne({
            where: {
              threadId: socket.roomId,
              userId: socket.user.id
            }
          }).then(function(threadUser) {
            if(threadUser){
              models.ChatThreadUser.update({
                isStreaming: false
              }, {
                where: {
                  id: threadUser.id,
                  userId:socket.user.id
                }
              });
            }
          });
        }
      }else if(!socket.user){
        memberStorages.remove({
          role: 'guest',
          id: socket.request.connection.remoteAddress
        });
        models.ChatThreadUser.findOne({
          where: {
            threadId: socket.roomId,
            ip: socket.request.connection.remoteAddress
          }
        }).then(function(threadUser) {
          if(threadUser){
            models.ChatThreadUser.update({
              isStreaming: false
            }, {
              where: {
                id: threadUser.id,
                ip: socket.request.connection.remoteAddress
              }
            });
          }
        });
      }

        let roomId = socket.roomId;
        // if (!socket.roomId) {
        //   return;
        // }
        //remove redis store




        console.log("VISORES TOTALES DOS");
        RedisHelper.removeFromRoom(roomId, socket.userId, function() {
          RedisHelper.getAllRoomMembers(roomId, function (err, data) {
            let total = 0;
            if (err || _.isEmpty(data)) {
              total = 0;
            } else {
              let guests = 0;
              let members = 0;
              for (let k in data) {
                if (data[k] === 'guest') {
                  guests++;
                } else {
                  members++;
                }
              }
             // total = guests + members - 1;

             total =  members - 1;
            }

            models.ChatThread.update({
              totalViewer: total
            }, {
                where: { id: roomId }
              });
          });
        });
        
      var members = memberStorages.get(roomId);
      socket.emit('online-members', {members});
    } catch(err) {
      console.log(err);
      // err
    }

    socket.log('DISCONNECTED IN ROOM');
  });

  socket.on('online-members', function(roomId, fn) {
    var members = memberStorages.get(roomId);
   // console.log(members);
     socket.emit('online-members', {members});
  });

  socket.on('model-leave-room', function(data){

  /*  console.log("aquiiiii");


  console.log(data);

  console.log("------------");

   console.log(socket.broadcastUser.modeloid);

 // console.log(socket);

    socket.modeloid = data.modeloid; 
     console.log(data.modeloid);*/
    console.log('model leave roomDARWWWW');
    socket.emit('disconnect');
  });
  //event when member is missing tokens. break private chat.
  socket.on('member-missing-tokens', function(chatType){
    socket.broadcast.to(socket.threadId).emit('member-missing-tokens', chatType);
  });

  //model receive tokens from member
  socket.on('model-receive-info', function(data){
    socket.broadcast.emit('model-receive-info', data);
  });
}
