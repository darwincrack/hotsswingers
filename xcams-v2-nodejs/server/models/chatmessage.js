'use strict';

module.exports = function(sequelize, DataTypes) {
  var ChatMessage = sequelize.define('ChatMessage', {
    type: DataTypes.ENUM('private', 'group', 'public'),
    tip: {
      type: DataTypes.ENUM('yes', 'no'),
      defaultValue: 'no'
    },
    ownerId: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references:{
        model: 'User'
      }
    },
    threadId: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      
    },
    text: DataTypes.TEXT
  }, {
    classMethods: {
    },
    tableName: 'chatmessages'
  });

  return ChatMessage;
};