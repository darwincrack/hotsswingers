import uuid from 'node-uuid';
let models  = require('../models');
var groupRooms = {}, userIds = {};
let modelsStorage = require('./../storages/model');
let Redis = require('../components/Redis');
var moment = require('moment');

let GROUP_CACHE_PREFIX = 'GROUP_';

import _ from 'lodash';

var firstAvailableRooms = {};

export function register(socket) {
  var currentRoom, id;

  socket.on('group-call-init', function (data, fn) {
    // console.log('init group call');
    currentRoom = (data || {}).room || uuid.v4();
    //in private chat room id is modelId
    var room = groupRooms[currentRoom];
    var videoType = 'group';

    var roomId = (data && data.data.room) ? data.data.room : data.room;
    //client request, we will create separated room and send event to model for accepting the chat
    if (!room && socket.user.role === 'model') {
      console.log("DARWIN3");
      groupRooms[currentRoom] = [socket];
      id = userIds[currentRoom] = 0;
      fn(currentRoom, id);

      room = groupRooms[currentRoom];

      firstAvailableRooms[currentRoom] = {
        model: socket.user.id
      };
    }

    if(room){
      socket.broadcast.emit('on-group-chat', {
        online: true,
        model: socket.user.id,
        virtualRoom: currentRoom,
        room: roomId
      });

      userIds[currentRoom] += 1;
      id = userIds[currentRoom];
      fn(currentRoom, id);
      room.forEach(function (s) {
        s.emit('peer.connected', { id: id });
      });
      room[id] = socket;
      socket.groupId = id;
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
            socket.broadcast.to(socket.threadId).emit('join-room', socket.user);
          }else{
            // console.log('create ChatThreadUser error');
          }
        });
      });
    }
  });


  socket.on('video-msg', function (data) {
    var to = parseInt(data.to, 10);
    if (groupRooms[currentRoom] && groupRooms[currentRoom][to]) {
      //console.log('Redirecting message to', to, 'by', data.by);
      groupRooms[currentRoom][to].emit('video-msg', data);
    } else {
      //console.warn('Invalid user');
    }
  });

  socket.on('disconnect', function () {
    if (!currentRoom || !groupRooms[currentRoom] ) {
      return;
    }

    var virtualRoom = currentRoom;

    if(socket && socket.chatType && socket.chatType == 'group'){
      models.ChatThread.findOne({
        where: {
          id: socket.threadId,
          ownerId: socket.user.id
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

      socket.broadcast.emit('on-group-chat', {
        online: false,
        model: socket.user.id,
        virtualRoom: virtualRoom,
        room: socket.roomId
      });

      if(currentRoom && userIds[currentRoom]){
        var groupId = (socket.groupId) ? socket.groupId : userIds[currentRoom];

        socket.broadcast.emit('group.disconnected', { id: groupId });
      }

      if(firstAvailableRooms[currentRoom] && firstAvailableRooms[currentRoom].model == socket.user.id){

        // console.log('Delete group room', currentRoom);
        delete groupRooms[currentRoom];
        delete firstAvailableRooms[currentRoom];
      }
    }
  });

  socket.on('has-group-room', function(broadcastid, cb) {
    if (typeof cb !== 'function') { return; }
    if (groupRooms[broadcastid]) {

      cb(true);
    } else {
      cb(false);
    }
  });

  socket.on('get-all-group-chat', function(modelId){

    var findRoom = _.findKey(firstAvailableRooms, {model: modelId});
    if(findRoom){
      // console.log('request chat room', socket.threadId);
      socket.emit('on-group-chat', {
        online: true,
        model: modelId,
        virtualRoom: findRoom,
        room: socket.threadId
      });
    }
  });
}
