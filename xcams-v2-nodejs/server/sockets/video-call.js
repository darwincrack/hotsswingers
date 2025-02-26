import uuid from 'node-uuid';
let models  = require('../models');
let rooms = {}, userIds = {};
let modelsStorage = require('./../storages/model');
let Redis = require('../components/Redis');
var moment = require('moment');

let PRIVATE_CACHE_PREFIX = 'PRIVATE_';

import _ from 'lodash';
var firstAvailableRooms = {};

export function register(socket) {
  var currentRoom, id;

  socket.on('video-chat-init', function (data, fn) {
    // console.log('init private room');
    currentRoom = (data || {}).room || uuid.v4();
    //in private chat room id is modelId

    var room = rooms[currentRoom];
    var videoType = 'private';
    var roomId = (data && data.data.room) ? data.data.room : data.room;
    //client request, we will create separated room and send event to model for accepting the chat
    if (!room) {
      rooms[currentRoom] = [socket];
      id = userIds[currentRoom] = 0;
      fn(currentRoom, id);

      //emit to model
      if (data.data && data.data.modelId) {

        if(socket.user && data.data.modelId != socket.user.id){
          // console.log('init private room and send request ');
          socket.broadcast.emit('video-chat-request', {
            from: socket.user.id,
            model: data.data.modelId,
            session: data.data.sessionId,
            virtualRoom: currentRoom,
            room: roomId
          });


         //Set list of broadcast to redis for shared data for multile platforms
         Redis.hset(PRIVATE_CACHE_PREFIX + 'ROOMS', data.room, data.data.toString());

        }else{
          modelsStorage.emitTo(data.data.modelId, 'room-has-removed', data);
        }
      }

    }else{

      userIds[currentRoom] += 1;
      id = userIds[currentRoom];
      fn(currentRoom, id);
      room.forEach(function (s) {
        s.emit('peer.connected', { id: id });
      });
      room[id] = socket;
      //console.log('Peer connected to room', currentRoom, 'with #', id);
      //update isStreaming

      models.ChatThread.update({isStreaming: true, virtualId: currentRoom, lastStreamingTime: new Date()}, {
        where: { type: videoType, id: roomId }
      }).then(function(thread) {

        if(!thread){
          // console.log('update room error');
          return null;
        }
        // find chat thread user: id
        models.ChatThread.findOne({
          where: {
            ownerId: data.data.modelId,
             type: videoType,
             id: roomId
          }
        }).then(function(thread) {
          if(thread){
            if(thread.get('type') == 'private'){
              // console.log('Send private status');
              if(socket.user.role == 'model'){
                console.log("DARWIN15");
                //Set list of broadcast to redis for shared data for multile platforms
                Redis.hset(PRIVATE_CACHE_PREFIX + 'ROOMS', data.room, data.data.toString());
              }

              socket.broadcast.emit('model-private-status', {modelId: thread.get('ownerId'), isStreaming: true});
              firstAvailableRooms[currentRoom] = {
                model: socket.user.id
              };
            }
            return models.ChatThreadUser.findOne({
              where: {threadId: thread.id,
                userId: data.data.memberId
              }
            }).then(function(threadUser) {
              if(!threadUser){
                return models.ChatThreadUser.create({
                  threadId: thread.id,
                  userId: data.data.memberId,
                  isStreaming: false,
                  streamingTime: 0
                });
              }
              return threadUser;
            });


          }
          return null;
        }).then(function(threadUser) {
          if(threadUser){
            models.ChatThreadUser.update({
              isStreaming: true,
              lastStreamingTime: new Date()
            }, {
              where: {
                id: threadUser.id,
                userId:data.data.memberId
              }
            });
          }else{
            // console.log('create ChatThreadUser error');
          }
        });

      });

    }
  });

  socket.on('video-msg', function (data) {
    var to = parseInt(data.to, 10);
    if (rooms[currentRoom] && rooms[currentRoom][to]) {
      //console.log('Redirecting message to', to, 'by', data.by);
      rooms[currentRoom][to].emit('video-msg', data);
    } else {
      //console.warn('Invalid user');
    }
  });

  socket.on('disconnect', function () {
    if (!currentRoom || !rooms[currentRoom]) {
      return;
    }

    if(socket && socket.chatType && socket.chatType == 'private'){
      // console.log('disconnect private room', currentRoom);

        models.ChatThread.findOne({
          where: {
            id: socket.threadId,
          }
        }).then(function(thread) {
          if(!thread){return;}
          var endDate = moment(new Date());//now
          var startDate = moment(thread.get('lastStreamingTime'));
          models.ChatThread.update({
            isStreaming: false,
            streamingTime: parseInt(thread.get('streamingTime') + endDate.diff(startDate, 'minutes')) || 0
          }, {
            where: {
              id: thread.get('id')
            }
          });
        });


      if(rooms[currentRoom]){
        delete rooms[currentRoom];
      }
      if(firstAvailableRooms[currentRoom]){
        delete firstAvailableRooms[currentRoom];
      }

      // console.log('remove private');
      Redis.hdel(PRIVATE_CACHE_PREFIX + 'ROOMS', currentRoom);

      socket.broadcast.emit('model-private-status', {modelId: socket.user.id, isStreaming: false});
      socket.broadcast.to(socket.roomId).emit('room-has-removed', socket.user);
      socket.emit('peer.disconnected', { id: userIds[currentRoom] });

    }

  });
  socket.on('has-video-call', function(broadcastid, cb) {

      if (typeof cb !== 'function') { return; }
      if (rooms[broadcastid]) {

        cb(true);
      } else {
        cb(false);
      }
    });


  socket.on('model-private-status', function(modelId){

    var findRoom = _.findKey(firstAvailableRooms, {model: modelId});
    if(findRoom){
      // console.log('request chat room', socket.threadId);
      socket.emit('model-private-status', {
          isStreaming: true,
          modelId: modelId,
      });
    }
  });

  socket.on('model-denial-request', function(roomId){
    if(rooms[roomId] && rooms[roomId][0]){
      var room = rooms[roomId][0];
      room.emit('model-denial-request');
      return;
    }
    console.log('private room not found');
  });
  
  socket.on('pause-private-chat', function(data){    
    socket.broadcast.to(data.room).emit('pause-private-chat', data.room);    
  });
  socket.on('play-private-chat', function(data){    
    socket.broadcast.to(data.room).emit('play-private-chat', data.room);    
  });
  
  socket.on('broadcast-volumn-change', function(data){
    socket.broadcast.to(data.room).emit('broadcast-volumn-change', data.muted);        
  });

  socket.on('stop-video-request', function(data){
    socket.broadcast.emit('stop-video-request', {
      from: socket.user.id,
      model: data.data.modelId
    });      
  });
}
