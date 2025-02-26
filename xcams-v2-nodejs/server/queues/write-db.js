var models = require('../models');

module.exports = function(queue) {
  queue.process('UPDATE_DB', function(job, done) {
    /**
     * {
     *   model: ChatThread,
     *   data: {},
     *   condition: {}
     * }
     */
    var data = job.data;
    models[data.model].update(data.data, {
      where: data.condition || {}
    })
    .then(function(resp) {
      console.log(resp);
      done();
    }, function(e) {
      console.log(e);
      done();
    });
  });

  queue.process('CREATE_DB', function(job, done) {
    /**
     * {
     *   model: ChatThread,
     *   data: {}
     * }
     */
    if (job.flag) {
      console.log("Task CREATE_DB - DEBUG");
      return;
    }
    var data = job.data;
    models[data.model].create(data.data)
    .then(function(resp) {
      done();
    }, function(e) {
      //TODO - should handle it
      console.log(e);
      done();
    });
  });
};