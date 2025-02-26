var kue = require('kue');
var config = require('../config/environment');

//TODO - allow config multiple redis server

var queue = kue.createQueue({
  prefix: 'q',
  //TODO - get redis config here
  redis: config.redis
});

queue.on('job enqueue', function(id, type) {
  //TODO - hide/remove me in the production mode
//  console.log( 'Job %s has got queued of type %s', id, type );
}).on('job complete', function(id, result) {
  //after job is completed, remove the key, we dont need it anymore
  kue.Job.get(id, function(err, job) {
    if (err) { return; }

    job.remove(function(err){
      if (err) { return console.log('Queue remove job error!', err); }

//      console.log('removed completed job #%d', job.id);
    });
  });
}).on('failed', function(error) {
  console.log("job failed : " + error);
}).on('progress', function(progress, data) {
  console.log("on progress queue");
});

module.exports = queue;