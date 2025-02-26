'use strict';

module.exports = function(sequelize, DataTypes) {
  var Ruleta = sequelize.define('Ruleta', {


 user_id: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references:{
        model: 'User'
      }
    },

    items: DataTypes.STRING,
    titulo: DataTypes.STRING,

    goal: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      
    },

    nivel: {
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
    tableName: 'ruleta'
  });

  return Ruleta;
};