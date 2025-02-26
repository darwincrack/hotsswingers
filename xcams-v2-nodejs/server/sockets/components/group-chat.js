const Socket = require('../../components/Socket');

module.exports = function (socketComponent) {
  socketComponent.socket.on('groupChatRequest', function(modelId, func) {
    console.log(modelId)
    if (!socketComponent.socket.user || !func || !modelId) {
      return;
    }

    Socket.emitToSocket(modelId, 'groupChatRequest', {
      userId: socketComponent.socket.user.id
    });
  });
};
