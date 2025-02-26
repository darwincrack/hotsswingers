'use strict';

module.exports = function(sequelize, DataTypes) {
  var Videoprivadotokens = sequelize.define('Videoprivadotokens', {


 modelId: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references:{
        model: 'User'
      }
    },

 ownerId: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references:{
        model: 'User'
      }
    },

     tokens: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      
    },   

     threadId: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      references: {
        model: 'ChatThread'
      }
    },

    active: DataTypes.STRING

  }, {
    classMethods: {
    },
    tableName: 'videoprivadotokens'
  });

  return Videoprivadotokens;
};