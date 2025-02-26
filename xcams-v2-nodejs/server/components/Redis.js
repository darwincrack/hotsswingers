var redis = require('redis');
var config = require('../config/environment');

var client = redis.createClient(config.redis);

//TODO - get / set redis config here

module.exports = client;