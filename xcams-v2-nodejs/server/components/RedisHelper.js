const redisClient = require('./Redis');

exports.addToRoom = function(roomId, id, value, cb) {
  if (!roomId || !id) {
    return;
  }

  cb = cb || function() {};

  redisClient.hset('rooms_' + roomId, id, value, cb);
};

exports.removeFromRoom = function(roomId, id, cb) {
  cb = cb || function() {};
  redisClient.hdel('rooms_' + roomId, id, cb);
};

exports.countRoomMember = function(roomId, cb) {
  redisClient.hlen('rooms_' + roomId, cb);
};

exports.getAllRoomMembers = function(roomId, cb) {
  redisClient.hgetall('rooms_' + roomId, cb);
};
