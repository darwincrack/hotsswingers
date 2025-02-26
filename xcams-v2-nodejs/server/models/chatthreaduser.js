'use strict';

module.exports = function(sequelize, DataTypes) {
  var ChatThreadUser = sequelize.define('ChatThreadUser', {
    threadId: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      references: {
        model: 'ChatThread'
      }
    },
    userId: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references:{
        model: 'User'
      }
    },
    isStreaming: {
     type: DataTypes.BOOLEAN,
      allowNull: false,
       defaultValue: false
     },
    lastStreamingTime: {
      type: DataTypes.DATE,
      allowNull: true
    },
    streamingTime: DataTypes.INTEGER(11).UNSIGNED,
    ip: DataTypes.STRING
  }, {
    classMethods: {
    },
    tableName: 'chatthreadusers'
  });

  return ChatThreadUser;
};