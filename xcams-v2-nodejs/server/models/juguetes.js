'use strict';

module.exports = function(sequelize, DataTypes) {
  var Juguetes = sequelize.define('Juguetes', {


 user_id: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references:{
        model: 'User'
      }
    },


     games_id: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references:{
        model: 'Games'
      }
    },

    toyId: DataTypes.STRING,


    deviceId: DataTypes.STRING,

    domain: DataTypes.STRING,

        name: DataTypes.STRING,

    httpsPort: DataTypes.STRING
  }, {
    classMethods: {
    },
    tableName: 'juguetes'
  });

  return Juguetes;
};