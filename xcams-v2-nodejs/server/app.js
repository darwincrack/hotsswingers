/**
 * Main application file
 */

'use strict';

import express from 'express';
import http from 'http';
import https from 'https';
import config from './config/environment';
import cors from 'cors';
import fs from 'fs';


var useHttps = config.USE_SSL;

// Setup server
var app = express();
app.use(cors());

var server = useHttps ? https.Server({
  key: fs.readFileSync(config.ssl.key),
  cert: fs.readFileSync(config.ssl.cert),
  // ca: [
  // 	fs.readFileSync('./certs/AddTrustExternalCARoot.crt'),
  // 	fs.readFileSync('./certs/COMODORSAAddTrustCA.crt'),
  // 	fs.readFileSync('./certs/COMODORSADomainValidationSecureServerCA.crt')
  // ]
}, app) : http.Server(app);

//import queue
require('./queues');
require('./config/socketio')(server);

// Start server
function startServer() {
  server.listen(config.port, config.ip, function() {
    console.log('Expressssssdf server listening on %d, in %s mode', config.port, app.get('env'));
  });
}

setImmediate(startServer);

// Expose app
exports = module.exports = app;
