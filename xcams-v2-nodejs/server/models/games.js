'use strict';

module.exports = function(sequelize, DataTypes) {
  var Games = sequelize.define('Games', {


 user_id: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references:{
        model: 'User'
      }
    },

    topic: DataTypes.STRING,

    level1value: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      
    },
    level1: DataTypes.STRING,

    level2value: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      
    },
    level2: DataTypes.STRING,

    level3value: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      
    },
    level3: DataTypes.STRING,

    level4value: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      
    },
    level4: DataTypes.STRING,

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
    tableName: 'games'
  });

  return Games;
};