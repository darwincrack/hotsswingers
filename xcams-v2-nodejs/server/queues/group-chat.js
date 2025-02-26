var models = require('../models');

module.exports = function(queue) {
  queue.process('GROUP_CHAT_DISCONNECT', function(job, done) {
    var data = job.data;
    console.log('disconnect event', data);
    return done();

    models.ChatThread.findOne({
      where: {
        id: socket.threadId,
        ownerId: socket.user.id
      }
    }).then(function(thread) {
      if(!thread){return;}
      var endDate = moment(new Date());//now
      var startDate = moment(thread.get('lastStreamingTime'));

      models.ChatThread.update({
        isStreaming: false,
        streamingTime: parseInt(thread.get('streamingTime') + endDate.diff(startDate, 'minutes'))
      }, {
        where: {
          id: thread.get('id')
        }
      });
    });
  });

  queue.process('GROUP_CHAT_CONNECT', function(job, done) {
    var data = job.data;

    models.ChatThread.update({
      isStreaming: true,
      virtualId: data.virtualId,
      lastStreamingTime: new Date(data.lastStreamingTime)
    }, {
      where: { type: data.type, id: data.threadId }
    }).then(function(thread) {
      console.log('1')
      if(!thread){
        return null;
      }

      // find chat thread user: id
      models.ChatThread.findOne({
        where: {
          ownerId: data.modelId,
          type: data.type,
          id: data.threadId
        }
      }).then(function(thread) {
        // console.log('2')
        if(thread){
          return models.ChatThreadUser.findOne({
            where: {
              threadId: thread.id,
              userId: data.userId
            }
          })
          .then(function(threadUser) {
            // console.log('3')
            if(!threadUser){
              return models.ChatThreadUser.create({
                threadId: thread.id,
                userId: data.userId,
                isStreaming: false,
                streamingTime: 0
              });
            }

            return threadUser;
          }, function() { done(); });
        }

        return null;
      }, function() { done(); })
      .then(function(threadUser) {
        // console.log('4')
        if(threadUser){
          models.ChatThreadUser.update({
            isStreaming: true,
            lastStreamingTime: new Date(data.lastStreamingTime)
          }, {
            where: {
              id: threadUser.id,
              userId: data.userId
            }
          })
          .then(function() {
            console.log('5')
            done();
          }, function() { done(); });
        }else{
          done();
        }
      }, function() { done(); });
    }, function() { done(); });
  });
};