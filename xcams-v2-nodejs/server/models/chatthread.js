'use strict';

module.exports = function(sequelize, DataTypes) {
  var ChatThread = sequelize.define('ChatThread', {
    type: DataTypes.ENUM('private', 'group', 'public'),
    //this is model id
    ownerId: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references:{
        model: 'User'
      }
    },
    //this is member id, use for private chat
    requesterId: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references: {
        model: 'User'
      }
    },
    virtualId: DataTypes.STRING,
    isStreaming: {
      type: DataTypes.INTEGER(1).UNSIGNED
    },
    lastStreamingTime: {
      type: DataTypes.DATE
    },
    streamingTime: {
      type: DataTypes.INTEGER(11).UNSIGNED
    },
    totalViewer: {
        type: DataTypes.INTEGER(11).UNSIGNED
    },
      sendMail: {
      type: DataTypes.INTEGER(1).UNSIGNED
    }
  }, {
    classMethods: {
    },
    tableName: 'chatthreads'
  });

  return ChatThread;
};
