'use strict';

module.exports = function(sequelize, DataTypes) {
  var Favorite = sequelize.define('Favorite',{
    type: DataTypes.STRING,
    status: {
      type: DataTypes.ENUM('like', 'unline'),
      defaultValue: 'like'
    },
    ownerId: DataTypes.INTEGER,
    favoriteId: DataTypes.INTEGER
    
  }, {
    classMethods: {
    },
    tableName: 'favorites'
  });

  return Favorite;
};