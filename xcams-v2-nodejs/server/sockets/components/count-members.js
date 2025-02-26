const redisHelper = require('../../components/RedisHelper');
const _ = require('lodash');

module.exports = function (socketComponent) {
  socketComponent.socket.on('countMember', function(roomId, func) {
    if (!func) {
      return;
    }

    redisHelper.getAllRoomMembers(roomId, function(err, data) {
      if (err || _.isEmpty(data)) {
        return func({
          members: 0,
          guests: 0
        });
      }

      let guests = 0;
      let members = 0;
      for (let k in data) {
        if (data[k] === 'guest') {
          guests++;
        } else {
          members++;
        }
      }
      func({
        guests,
        members
      })
    });
  });
};
