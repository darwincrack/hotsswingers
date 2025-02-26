// Set default node environment to development
var env = process.env.NODE_ENV = process.env.NODE_ENV || 'development';

if (env === 'development' || env === 'test') {
  //require('v8-profiler');
  // Register the Babel require hook
  require('babel-core/register');
}

// Export the application
exports = module.exports = require('./app');
