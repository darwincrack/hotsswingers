const _ = require('lodash');
let models  = require('../../models');
module.exports = function (socketComponent) {
  socketComponent.socket.on('updateModelStatus', function(options, callback) {
    models.User.update({
      status: options.status
    }, {
      where: {id: options.userId}
    }).then(function() {
    	socketComponent.socket.broadcast.to(options.roomId).emit('updateModelStatus', {status: options.status});
    	callback(options);
    });
  });
};
