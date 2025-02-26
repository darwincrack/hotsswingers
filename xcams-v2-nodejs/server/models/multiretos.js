'use strict';

module.exports = function(sequelize, DataTypes) {
  var Multiretos = sequelize.define('Multiretos', {


 user_id: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references:{
        model: 'User'
      }
    },

    reto_text: DataTypes.STRING,

    goal: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      
    },

    posicion: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      
    },
     threadId: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      references: {
        model: 'ChatThread'
      }
    },

    active: DataTypes.STRING,
    reto_actual: DataTypes.STRING
  }, {
    classMethods: {
    },
    tableName: 'multiretos'
  });

  return Multiretos;
};