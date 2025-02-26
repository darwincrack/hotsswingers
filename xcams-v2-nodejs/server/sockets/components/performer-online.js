const Socket = require('../../components/Socket');

module.exports = function (socketComponent) {
  //emit too global room that model is online
  if (socketComponent.socket.user && socketComponent.socket.user.role && socketComponent.socket.user.role === 'model') {
    
console.log("DARWIN16");
    Socket.toRoom(Socket.room, 'performer_online', {
      performerId: socketComponent.socket.user.id,
      isOnline: true
    });
  }

  socketComponent.socket.on('disconnect', function() {


    //send broadcast to the room if user is a model
    if (socketComponent.socket.user && socketComponent.socket.user.role && socketComponent.socket.user.role === 'model') {
      //return console.log(Socket.room)

      console.log("DARWIN17");
      Socket.toRoom(Socket.room, 'performer_online', {
        performerId: socketComponent.socket.user.id,
        isOnline: false
      });
    }
  });

  socketComponent.socket.on('checkOnline', function(userId, func) {
    if (!func || typeof userId !== 'string') {
      return;
    }

    Socket.hasUser(userId, function(has) {
      func({
        userId,
        isOnline: has > 0
      });
    });
  });
};
