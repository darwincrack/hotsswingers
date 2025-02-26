process.env.NODE_ENV = process.env.NODE_ENV || "development";

var httpServer = require("https");

const ioServer = require("socket.io");
const RTCMultiConnectionServer = require("rtcmulticonnection-server");
var configEnv = require("./config/environment");
var PORT = 9001;
var isUseHTTPs = configEnv.USE_SSL;
var config = {
  socketURL: "/",
  dirPath: null,
  socketMessageEvent: "RTCMultiConnection-Message",
  socketCustomEvent: "RTCMultiConnection-Custom-Message",
  port: PORT,
};
const fs = require('fs');

if (isUseHTTPs === false) {
  isUseHTTPs = config.isUseHTTPs;
}

function serverHandler(request, response) {
  console.log("RTC server started!");
}

var httpApp;

if (isUseHTTPs) {
  httpServer = require("https");

  // See how to use a valid certificate:
  // https://github.com/muaz-khan/WebRTC-Experiment/issues/62
  var options = {
    key: fs.readFileSync(configEnv.ssl.key),
    cert: fs.readFileSync(configEnv.ssl.cert),
    ca: null,
  };

  var pfx = false;

  if (pfx === true) {
    options = {
      pfx: sslKey,
    };
  }

  httpApp = httpServer.createServer(options, serverHandler);
} else {
  httpApp = httpServer.createServer(serverHandler);
}

RTCMultiConnectionServer.beforeHttpListen(httpApp, config);
httpApp = httpApp.listen(
  process.env.PORT || PORT,
  process.env.IP || "0.0.0.0",
  function () {
    RTCMultiConnectionServer.afterHttpListen(httpApp, config);
  }
);

// --------------------------
// socket.io codes goes below

ioServer(httpApp).on("connection", function (socket) {
  RTCMultiConnectionServer.addSocket(socket, config);

  // ----------------------
  // below code is optional

  const params = socket.handshake.query;

  if (!params.socketCustomEvent) {
    params.socketCustomEvent = "custom-message";
  }

  socket.on(params.socketCustomEvent, function (message) {
    socket.broadcast.emit(params.socketCustomEvent, message);
  });
});
