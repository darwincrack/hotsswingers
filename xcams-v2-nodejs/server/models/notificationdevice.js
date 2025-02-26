'use strict';

module.exports = function(sequelize, DataTypes) {
  var NotificationDevice = sequelize.define('NotificationDevice', {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true
    },
    userId: DataTypes.INTEGER,
    deviceType: {
      type: DataTypes.ENUM('IOS', 'ANDROID'),
      allowNull: true,
      defaultValue: false
    },
    deviceToken: {
      type: DataTypes.STRING,  
      allowNull: true,
      defaultValue: false
    },
    push: {
      type: DataTypes.ENUM('YES', 'NO'),
      allowNull: false,
      defaultValue: 'NO'
    },
    
    deviceId: {
      type: DataTypes.STRING,  
      allowNull: true,
      defaultValue: false
    },
    
  }, {
    classMethods: {
    },
    tableName: 'notificationdevices'
  });

  return NotificationDevice;
};