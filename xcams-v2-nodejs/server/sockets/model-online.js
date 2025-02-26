let models  = require('../models');
import jwt from 'jsonwebtoken';
import _ from 'lodash';
let modelStorages = require('./../storages/model');
let streamStorages = require('./../storages/streaming');

let onlineUsers = {};

export function register(socket, io) {
 let room;
 if(socket.user){
    if(socket.user.role === 'studio') {
      console.log("DARWIN4");
    room = socket.user.id;
    socket.join(room);
   };

   if(socket.user.role === 'model') {
    console.log("DARWIN5");
    room = socket.user.parentId;
    onlineUsers[room] =  onlineUsers[room] || [];
    (onlineUsers[room].indexOf(socket.user.id) !== -1) ||  onlineUsers[room].push(socket.user.id);
   }
   if(room && onlineUsers[room]) {
    io.sockets.in(room).emit('model-online', {'onlineUsers': onlineUsers[room]  });
   }
 }


  /**
  * @author Phong Le pt.hongphong@gmail.com
  * @param {int} [roomId]
  * @description check currect model is online or no
  */

  socket.on('current-model-online', function(data, fn) {
 
 console.log("DARWIIIIIIIIIIIIIIIIIIIIIIIIIIIIII");
var listModels = "darwin23432432";
    socket.emit('current-model-online', listModels);
  });

 /**
  * @author Phong Le pt.hongphong@gmail.com
  * @param {int} [roomId]
  * @description check currect model is streaming or no
  */

  socket.on('model-streaming', function(data, fn) {
    //get
    var streaming =streamStorages.get(data.room);

    //
    _.map(streaming, function(item){
       if(item.user.id == data.model){
        socket.emit('model-streaming', item.user);
       }
    });
    // console.log(streaming);

  });

 socket.on('disconnect', function() {
    if(socket.user && socket.user.parentId && onlineUsers[socket.user.parentId]) {
      let idx = onlineUsers[socket.user.parentId].indexOf(socket.user.id);
      (idx === -1) || onlineUsers[socket.user.parentId].splice(idx, 1);
      io.sockets.in(room).emit('model-online', {'onlineUsers': onlineUsers[socket.user.parentId]});
    }
 });
}