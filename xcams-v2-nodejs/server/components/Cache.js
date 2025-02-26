var redisClient = require('./Redis');
var config = require('../config/environment');
var models  = require('../models');
var async = require('async');

function getCache(name, cb) {
  var cacheKey = config.cachePrefix + name;

  redisClient.get(cacheKey, function(err, reply) {
    if (err) { return cb(err); }

    cb(null, JSON.parse(reply));
  });
}

function setCache(name, data, cb) {
  var cacheKey = config.cachePrefix + name;
  data = JSON.stringify(data);

  if (!cb) { cb = function() {}; }
  redisClient.set(cacheKey, data, cb);
}

function findOrCreateChatThreadUser(threadId, userId, cb) {
  var cacheKey = config.cachePrefix + 'ChatThreadUser_thread_' + threadId + '_user_' + userId;
  getCache(cacheKey, function(err, data) {
    if (data) {
      return cb(null, data);
    }

    //find and create new one
    models.ChatThreadUser.findOne({
      where: {
        threadId: threadId,
        userId: userId
      }
    })
    .then(function(threadUser) {
      if(threadUser){
        //store to the cache
        setCache(cacheKey, threadUser.dataValues);
        return cb(null, threadUser.dataValues);
      }

      //create new one
      models.ChatThreadUser.create({ threadId: threadId, userId: userId })
      .then(function(threadUser) {
        setCache(cacheKey, threadUser.dataValues);
        return cb(null, threadUser.dataValues);
      })
      .catch(cb);
    });
  });
};

exports.get = getCache;
exports.set = setCache;
exports.findOrCreateChatThreadUser = findOrCreateChatThreadUser;