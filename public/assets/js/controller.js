/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';

angular.module('matroshkiApp').controller('chatSettingCtrl', ['$scope', 'appSettings', 'chatSettingService', function ($scope, appSettings, chatSettingService) {
  $scope.performerchat = [];
  //get chat settings data;
  chatSettingService.get(appSettings.USER.role, appSettings.USER.id).then(function (data) {
    $scope.performerchat = data.data;
  });
  $scope.saveChanges = function (form) {
    var settingsData = angular.copy($scope.performerchat);
    chatSettingService.update(appSettings.USER.id, settingsData).then(function (data) {
      if (data.data.success) {
        return alertify.success(data.data.message);
      }
      return alertify.error(data.data.message);
    });
  };
}]);

'use strict';

angular.module('matroshkiApp')
    .controller('streamCtrl', ['$scope', '$timeout', 'appSettings', '$uibModal',
        'socket', 'PerformerChat', 'chatService', 'chatSettingService', '$http', 'commonHelper', 'userService', 'gamesService', 'multiretosService', 'gamesService',
        function($scope, $timeout, appSettings, $uibModal, socket, PerformerChat, chatService, chatSettingService, $http, commonHelper, userService, gamesService, multiretosService) {
            $scope.tablist = 'profiles';
            if (!appSettings.USER) {
                $('#videos-container').addClass('loader');
            }
            var reTimeoutRoom = null;
            // using single socket for RTCMultiConnection signaling
            var onMessageCallbacks = {};

            var dataruleta ="";

            $scope.isGroupLive = false;
            $scope.isPrivateChat = false;
            $scope.isOffline = false;
            $scope.groupLink = null;
            $scope.roomId = null;
            $scope.currentModelId = null;
            $scope.virtualRoom = null;
            $scope.modeloid = null;
            $scope.loadingJuegos = true;
            $scope.messageJuegos = false;
            $scope.progressMultiretos = false;

            $scope.Multiretogoal = 0;
            $scope.Multiretotext = null;
            $scope.Multiretoacumulado = 0;
            $scope.isPrivateVideox = false;
            $scope.Showvideoprivadox = false;
            $scope.videoPrivadox = false;
            $scope.PrivateVideoxregular = false;
            $scope.isShowruletachart = false;
            $scope.hiddenRuleta = true;
            $scope.tokensTotales = 0;
            $scope.tokensRuleta = 0;
            $scope.tokensRetos = 0;
            $scope.isStreaming = true;
            $scope.isShowRetos = false;
            var vis = "";
            var container = "";
            var svg = "";
            var pie = "";

            var arc = "";

            var arcs = "";


            $scope.gridChat = 'col-sm-6';
            $scope.tokenVideoprivadox = 2000;


            $scope.modelId = null;

            $scope.streamingInfo = {
                spendTokens: 0,
                time: 0,
                tokensReceive: 0,
                type: 'public',
                hasRoom: true
            };

            var threadId;
            $scope.totalView = 0;
            $scope.isStreaming = false;
            $scope.local_stream;
            $scope.micOn =true;
            $scope.tagvideo = "";

            function reCountMember() {
                if (!threadId) {
                    return;
                }
                socket.emit('countMember', threadId, function(data) {
                    $scope.totalView = data.guests + data.members;
                    $scope.$$phase || $scope.$apply();
                });

                $timeout(function() {
                    reCountMember();
                }, 10000);
            }

            socket.on('broadcast-message', function(data) {
                if (data.sender == connection.userid) {
                    return;
                }
                if (onMessageCallbacks[data.channel]) {
                    onMessageCallbacks[data.channel](data.message);
                }
            });

            socket.onGroupChat(function(data) {
                // console.log(data);

                if (PerformerChat.model_id == data.model) {
                    $scope.isGroupLive = data.online;
                    $scope.isOffline = true;
                    $('#videos-container').removeClass('loader');
                    var virtualRoom = data.virtualRoom ? '?vr=' + data.virtualRoom : '';
                    $scope.groupLink = appSettings.BASE_URL + 'members/groupchat/' + data.model + virtualRoom;
                } else {
                    $('#offline-image').show();
                    $scope.isOffline = true;
                }
            });
            socket.on('public-room-status', function(status) {
                if (!status) {
                    $('#videos-container').removeClass('loader');
                    $('#offline-image').show();
                    $scope.isOffline = true;
                } else {
                    $('#videos-container').addClass('loader');
                    $('#offline-image').hide();
                    $scope.isPrivateChat = false;
                    $scope.isGroupLive = false;
                    $scope.isOffline = false;
                }
            });
            socket.onModelInitPublicChat(function(data) {
                $scope.virtualRoom = data.broadcastid;

                $scope.isPrivateChat = false;
                $scope.isGroupLive = false;
                // if($('#offline-image').length > 0){
                $('#offline-image').hide();
                // }
                //$scope.joinBroadcast($scope.roomId, data.broadcastid);
                $('#videos-container').addClass('loader');
                $timeout(function() {
                    const isLoading = $('#videos-container').hasClass('loader');
                    if (isLoading) {
                        location.reload();
                    }
                }, 7000);

            });

            $scope.isShowPrivateMessage = false;

            socket.on('model-private-status', function(data) {
                //      console.log(data);

                if (PerformerChat && data.modelId == PerformerChat.model_id) {
                    $scope.isPrivateChat = data.isStreaming;
                    $scope.isOffline = true;
                    if (data.isStreaming) {
                        if ($('#offline-image').length > 0) {

                            $('#offline-image').hide();
                        }
                    } else {
                        if ($('#offline-image').length > 0) {

                            $('#offline-image').show();
                        }
                    }
                }
                if ($scope.streamingInfo.type == 'private' && !data.isStreaming) {
                    if (!$scope.isShowPrivateMessage) {
                        // alertify.error('Model stopped video call.', 30);
                        $scope.isShowPrivateMessage = true;
                    }
                }
            });
  socket.on('member-missing-tokens', function (chatType) {
    // console.log(chatType);
    if (chatType == 'private') {

 switch($('#idioma').val()) {
          case 'es':
            alertify.warning('Los tokens de usuario no son suficientes, el chat privado se ha desconectado');
            break;
          case 'en':
             alertify.warning('User tokens do not enough, private chat have disconnected');
            break;

            case 'fr':
            alertify.warning('Les jetons utilisateur ne suffisent pas, le chat privé s\'est déconnecté');
            break;
          default:
           alertify.warning('Los tokens de usuario no son suficientes, el chat privado se ha desconectado');
        }

            socket.emit('model-leave-room',{
     modeloid: $scope.modeloid
    });
            console.log($scope.modeloid);
      $timeout(function () {
        window.location.href = appSettings.BASE_URL + 'models/live';
      }, 3000);
    }
  });

            socket.on('disconnectAll', function(data) {
                if (appSettings.CHAT_ROOM_ID != data.id && data.ownerId == appSettings.USER.id) {
                    var modalInstance = $uibModal.open({
                        animation: true,
                        templateUrl: appSettings.BASE_URL + 'app/modals/close-modal/modal.html?v=' + Math.random().toString(36).slice(2),
                        controller: 'modalCloseCtrl',
                        backdrop: 'static',
                        keyboard: false
                    });
                    modalInstance.result.then(function(res) {
                        window.location.reload();
                    });
                }
            });
            var timeoutVideo = null;
            var steamId = null;
            $scope.connectionNow = null;
            // initializing RTCMultiConnection constructor.
            $scope.isStreaming = null;
            $scope.currentConnectStart = null;

            function initRTCMultiConnection(userid) {
                var connection = new RTCMultiConnection();
                // connection.resources.firebaseio = 'https://xcamsv2.firebaseIO.com/';;
                // connection.enableLogs = true;
                // connection.socketURL = appSettings.SOCKET_URL + '/';
                // connection.socketOptions = {
                //   'query': commonHelper.obToquery({token: appSettings.TOKEN}),
                //   path: '/socket.io-client'
                // };

               // connection.enableLogs = true;
                connection.socketURL = appSettings.RTC_URL;


                connection.socketMessageEvent = 'video-broadcast-' + ($scope.roomId || window.appSettings.CHAT_ROOM_ID);
                $scope.connectionNow = connection;
                connection.getExternalIceServers = false;
                connection.videosContainer = document.getElementById('videos-container');
                connection.channel = connection.sessionid = connection.userid = userid || connection.userid;

                connection.sdpConstraints.mandatory = {
                    OfferToReceiveAudio: true,
                    OfferToReceiveVideo: true
                };


                connection.onMediaError = function(error) {
                    JSON.stringify(error);

                    console.log(error);

                    alertify.alert('Warning', error.message);
                };

                connection.onstream = function(event) {
                     $scope.local_stream = event;
                    const numOfVideos = connection.videosContainer.childElementCount;
                    if (numOfVideos > 0) {
                        return true;
                    }
                    if (connection.isInitiator && event.type !== 'local') {
                        return;
                    }
                    event.mediaElement.removeAttribute('src');
                    event.mediaElement.removeAttribute('srcObject');

                    connection.isUpperUserLeft = false;

                    if (event.type == 'local' && $scope.streamingInfo.type == 'public') {
                        var timeout = null;
                        var i = 0;

                        var initNumber = 1;
                        var capture = function capture() {
                            console.log('4 ', event);
                            connection.takeSnapshot(event.userid, function(snapshot) {

                                $http.post(appSettings.BASE_URL + 'api/v1/rooms/' + appSettings.CHAT_ROOM_ID + '/setImage', {
                                    base64: snapshot,
                                    shotNumber: initNumber
                                });
                            });
                            initNumber = initNumber < 6 ? initNumber + 1 : 1;

                            timeout = setTimeout(capture, 30000);
                        };
                        // capture(); // will review it later
                        console.log('5 ', event);
                        $scope.$on('destroy', function() {
                            clearTimeout(timeout);
                            clearTimeout(timeoutVideo);
                            i = 0;
                        });
                        var recordingInterval = 10000;
                        //          var recordSteam = function recordSteam() {
                        //            var recorder = {
                        //              video: RecordRTC(event.stream, {
                        //                type: 'video'
                        //              })
                        //            };
                        //
                        //            recorder.video.startRecording();
                        //
                        //            connection.streamEvents[event.streamid].recorder = recorder;
                        //          };
                        //          timeoutVideo = setTimeout(function(){
                        //              recordSteam();
                        //           var recordToServer = function recordToServer() {
                        //            i++;
                        //             var recorder = connection.streamEvents[event.streamid].recorder;
                        //            recorder.video.stopRecording(function (singleWebM) {
                        //              var blog = this.getBlob();
                        //               var formData = new FormData();
                        //
                        //              formData.append('video-filename', i + 'video-stream.webm');
                        //              formData.append('video-blob', blog);
                        //              formData.append('type', $scope.streamingInfo.type);
                        //
                        //              $http({
                        //                method: 'POST',
                        //                url: appSettings.BASE_URL + 'api/v1/rooms/' + appSettings.CHAT_ROOM_ID + '/recordVideo?userId=' + appSettings.USER.id + '&session=' + event.userid,
                        //                headers: {'Content-Type': undefined},
                        //                transformRequest: angular.identity,
                        //                data: formData
                        //
                        //              }).then(function (err) {
                        //
                        //                recordSteam();
                        //                timeoutVideo = setTimeout(recordToServer, recordingInterval);
                        //              }, function () {
                        //                recordSteam();
                        //                timeoutVideo = setTimeout(recordToServer, recordingInterval);
                        //              });
                        //
                        //            });
                        //
                        //          };
                        //            timeoutVideo = setTimeout(recordToServer, recordingInterval);
                        //
                        //          },3000);
                    }

                    if (connection.isInitiator == false && event.type === 'remote') {
                        $scope.isStreaming = true;
                        connection.dontCaptureUserMedia = true;
                        connection.attachStreams = [event.stream];

                        connection.sdpConstraints.mandatory = {
                            OfferToReceiveAudio: true,
                            OfferToReceiveVideo: true
                        };
                        clearTimeout(reTimeoutRoom);
                        $('#offline-image').hide();
                        $('#videos-container').removeClass('loader');
                    }
                    steamId = event.streamid;
                    var video = document.createElement('video');
                    $scope.tagvideo = video;
                    video.addEventListener("volumechange", $scope.volumevideo);
                    try {
                        video.setAttributeNode(document.createAttribute('autoplay'), true);
                        video.setAttributeNode(document.createAttribute('playsinline'), true);
                    } catch (e) {
                        video.setAttribute('autoplay', true);
                        video.setAttribute('playsinline', true);
                    }
                    if (event.type === 'local') {
                        video.volume = 0;
                        try {
                            video.setAttributeNode(document.createAttribute('muted'));
                        } catch (e) {
                            video.setAttribute('muted', true);
                        }
                    }
                    video.srcObject = event.stream;
                    video.controls = true;
                    var width = parseInt(connection.videosContainer.clientWidth);
                    $scope.isStreaming = true;
                    var mediaElement = getHTMLMediaElement(video, {
                        title: '<img src="/uploads/logostream.png" class="logovideostream">',
                        buttons: [],
                        width: width,
                        showOnMouseEnter: false
                    });
                    connection.videosContainer.appendChild(mediaElement);
                    mediaElement.id = event.streamid;
                    setTimeout(function() {
                        mediaElement.media.play();
                    }, 5000);
                };
                //disable log
               // connection.enableLogs = true;
                return connection;
            }
            socket.on('broadcast-stopped', function() {
                console.log('Broadcast has been stopped.');
                $('#offline-image').show();
                $('#videos-container').removeClass('loader');
            });


            // this RTCMultiConnection object is used to connect with existing users
            var connection = initRTCMultiConnection();


            $scope.initRoom = function(roomId, virtualRoom, modeloid) {
                $scope.roomId = roomId;
                $scope.virtualRoom = virtualRoom;
                $scope.modeloid = modeloid;

                //get model streaming
                socket.emit('join-broadcast', {
                    broadcastid: $scope.virtualRoom,
                    room: $scope.roomId,
                    userid: connection.userid,
                    openBroadcast: false,
                    modeloid: $scope.modeloid,

                    typeOfStreams: {
                        video: false,
                        screen: false,
                        audio: false,
                        oneway: true
                    }
                });
            };

            // ask node.js server to look for a broadcast
            // if broadcast is available, simply join it. i.e. "join-broadcaster" event should be emitted.
            // if broadcast is absent, simply create it. i.e. "start-broadcasting" event should be fired.
            // TODO - model side should start broadcasting and member/client side should join only
            $scope.openBroadcast = function(room, virtualRoom) {
                $scope.roomId = room;
                $scope.virtualRoom = virtualRoom;
                //TODO - hide start button

                connection.session = {
                    video: true,
                    screen: false,
                    audio: true,
                    oneway: true
                };

                socket.emit('join-broadcast', {
                    broadcastid: $scope.virtualRoom,
                    room: $scope.roomId,
                    userid: connection.userid,
                    typeOfStreams: connection.session,
                    openBroadcast: true,
                    modeloid: $scope.modeloid,
                });
                $scope.isStreaming = true;
                $('#startStream_' + room).hide();
            };

            $scope.getAllGames = function(modeloid) {
                console.log(modeloid);

                gamesService.getAllGames(modeloid).success(function(res) {


                    $scope.loadingJuegos = false;
                    if (res.length > 0) {
                        $scope.itemsAllGames = res;
                    } else {
                        $scope.messageJuegos = true;
                    }

                });

            };



            $scope.getMultiretoactual = function(modeloid) {


                // $scope.$broadcast('Multiretoactualc', modeloid);


                console.log("getMultiretoactual stream LADOCLIENTE")

                multiretosService.getFirst(modeloid).success(function(res) {



                    if (res != "") {
                        $scope.progressMultiretos = true;

                        $scope.tokensRetos +=  parseInt(res.ganancia);
                        $scope.isShowRetos = true;
                        console.log($scope.progressMultiretos);
                        $("#acumulado").html(res.ganancia);
                        $("#goal").html(res.goal);
                        $("#multiretotexto").html(res.reto_text);
                        $("#multiretonumero").html(res.posicion);
                        $("#progressMultireto").val(res.ganancia);
                        document.getElementById("progressMultireto").max = res.goal;



                        $('.chat-multiretos').attr('style', 'display: block !important');


                        $scope.Multiretogoal = res.goal;
                        $scope.Multiretotext = res.reto_text;
                        $scope.Multiretonumero = res.reto_text;
                        $scope.Multiretoacumulado = res.ganancia;


                        //socket.Multiretoactual(res);

                    }
                });

            };



            /**
             * join broadcast directly, use for member side
             */

            $scope.joinBroadcast = function(room, virtualRoom, modeloid) {
                $scope.getAllGames(modeloid);


                //if($scope.isStreaming){
                $scope.getMultiretoactual(modeloid);

                //}




                console.log("joinBroadcast stream.controller.js LADO CLIENTE")
                //count online member
                threadId = room;
                reCountMember();
                //check model is online / streaming then open broadcast.
                socket.emit('has-broadcast', virtualRoom, function(has) {




                    if (!has) {
                        //TODO - should show nice alert message
                        $('#offline-image').show();
                        //       $scope.isOffline = true;
                        $('#videos-container').removeClass('loader');
                        return;
                    }
                    $scope.isPrivateChat = false;
                    $scope.isGroupLive = false;
                    $scope.isOffline = false;

                    $scope.roomId = room;
                    $scope.virtualRoom = virtualRoom;
                    $scope.modeloid = modeloid;
                    //TODO - check model room is open or not first?
                    connection.session = {
                        video: true,
                        screen: false,
                        audio: true,
                        oneway: true
                    };
                    socket.emit('join-broadcast', {
                        broadcastid: $scope.virtualRoom,
                        room: $scope.roomId,
                        userid: connection.userid,
                        typeOfStreams: connection.session,
                        modeloid: $scope.modeloid,
                    });
                });




                userService.findById(modeloid).then(function(data) {
                    if (data.data.success) {

                        if (data.data.user.videoPrivado == 1) {

                            $scope.tokenVideoprivadox = data.data.user.tokensVideoPrivado;

                            userService.FindParticipantes(modeloid).then(function(response) {

                                if (parseInt(response.data.tokensprivado) < parseInt($scope.tokenVideoprivadox)) {

                                    $scope.isPrivateVideox = true;
                                    $scope.PrivateVideoxregular = true;

                                    $('#videos-container').hide();
                                    $scope.ocultarVideoPrivadox();


                                }

                                $("#cantvideoprivadox").html(data.data.user.tokensVideoPrivado + " Tokens");
                                $(".text-videoprivado").show();
                                console.log(response);
                                console.log("find participantes");


                            });




                            /*setInterval(function () {
        $('#videos-container').empty();
 },1500);*/


                            return;

                        } else {
                            $(".text-videoprivado").hide();
                            $scope.isPrivateVideox = false;

                        }

                 

                    } else {
                        alertify.alert('Warning', data.data.message);
                    }
                });




            };
            $scope.privateChatRoom = null;


            // this event is emitted when a broadcast is already created.
            // this event is emitted when a broadcast is already created.
            socket.on('join-broadcaster', function(broadcaster, typeOfStreams) {

                if ($scope.isPrivateVideox) {
                    return;
                }
                console.log('join-broadcaster');
                console.log(broadcaster.userid + "broascastee");
                connection.session = typeOfStreams;
                connection.channel = connection.sessionid = broadcaster.userid;

                connection.sdpConstraints.mandatory = {
                    OfferToReceiveVideo: true,
                    OfferToReceiveAudio: true
                };
                (function reCheckRoomPresence() {

                    socket.emit('check-broadcast-presence', broadcaster.broadcastid, function(isRoomExists) {

                        if (isRoomExists) {
                            setTimeout(function() {

                                connection = initRTCMultiConnection();
                                connection.session = typeOfStreams;
                                $scope.broadcaster = broadcaster;

                                connection.channel = connection.sessionid = broadcaster.userid;

                                connection.sdpConstraints.mandatory = {
                                    OfferToReceiveVideo: true,
                                    OfferToReceiveAudio: true
                                };
                                connection.join(broadcaster.userid, {
                                    userid: broadcaster.userid,
                                    extra: {},
                                    session: connection.session
                                });

                            }, 1000);
                            if ($scope.isStreaming) {
                                return;
                            }
                        }
                        if (connection) {
                            connection.close();
                        }
                        reTimeoutRoom = setTimeout(reCheckRoomPresence, 5000);
                    });
                })();

                $scope.isStreaming = true;
            });

            // this event is emitted when a broadcast is absent.
            socket.on('start-broadcasting', function(typeOfStreams) {

                console.log('start-broadcasting');
                // host i.e. sender should always use this!
                connection.sdpConstraints.mandatory = {
                    OfferToReceiveVideo: false,
                    OfferToReceiveAudio: false
                };

                connection.session = typeOfStreams;
                connection.dontTransmit = true;
                connection.open(connection.userid);
                //    if($scope.currentConnectStart){
                //      connection.close();
                //    }else{
                //      $scope.currentConnectStart = true;
                //    }

                //      if (connection.broadcastingConnection) {
                //          // if new person is given the initiation/host/moderation control
                //          connection.close();
                //          connection.broadcastingConnection = null;
                //      }
            });
            var i = 0;
            socket.on('model-left', function() {
                //close connect if model live\
                console.log('model-left', i);
                i++;
                $('#offline-image').show();

                $('.chat-multiretos').hide();
                $('#private-videox').hide();

                $("#myTab").hide();
                $("#myTabContent").hide();
                
                $scope.isPrivateVideox = false;


                $('#videos-container').removeClass('loader');
                if (!appSettings.USER || $scope.modeloid != appSettings.USER.id) {
                    $scope.connectionNow.close();
                    connection.videosContainer.innerHTML = '';
                    connection.close();
                    $scope.isStreaming = false;
                    $scope.isShowruletachart = false;



                }
            });

            socket.on('broadcast-error', function(data) {
                if (!appSettings.USER || $scope.modeloid != appSettings.USER.id) {
                    console.log('broadcast-error');
                    alertify.alert('Warning', data.msg);
                }
                $scope.isStreaming = false;
            });

            //rejoin event
            socket.on('rejoin-broadcast', function(data) {

                if (!appSettings.USER || $scope.modeloid != appSettings.USER.id) {

                    socket.emit('check-broadcast-presence', data.id, function(isBroadcastExists) {
                        setTimeout(function() {

                            console.log('connection.session', connection.session);
                            connection.attachStreams = [];

                            socket.emit('join-broadcast', {
                                broadcastid: data.id,
                                room: data.room,
                                userid: connection.userid,
                                typeOfStreams: connection.typeOfStreams,
                                modeloid: $scope.modeloid,
                            });



                        }, 1000);

                    });
                }
                //      socket.emit('join-broadcast', {
                //          broadcastid: data.id,
                //          room: data.room,
                //          userid: connection.userid,
                //          typeOfStreams: connection.typeOfStreams
                //      });
            });

            function beep() {
                const unique = new Date().getTime();
                var snd = new Audio("/sounds/received_message.mp3?v=" + unique);
                snd.play();
            }



            $scope.multiretosProgressbar = function(sendObj) {
                console.log(" multiretosProgressbar stream LADO CLIENTE");

                console.log($scope.progressMultiretos);




                multiretosService.ganancias(sendObj.roomId, parseInt(sendObj.token)).then(function(response) {


                    if (Object.keys(response).length > 0) {

                        console.log("xxxx--------------------xxx");

                        console.log(response);
                        console.log(response.data.retoscompletados);
                        console.log(response.data.data.reto_text);
                        console.log("--------------------");

                        $("#acumulado").html(response.data.data.ganancia);
                        $("#goal").html(response.data.data.goal);
                        $("#multiretotexto").html(response.data.data.reto_text);
                        $("#multiretonumero").html(response.data.data.posicion);
                        $("#progressMultireto").val(response.data.data.ganancia);
                        document.getElementById("progressMultireto").max = response.data.data.goal;

                        $scope.Multiretogoal = response.data.data.goal;
                        $scope.Multiretotext = response.data.data.reto_text;
                        $scope.Multiretonumero = response.data.data.posicion;
                        $scope.Multiretoacumulado = response.data.data.ganancia;


                    }


                    socket.sendTip(sendObj);
                    socket.sendTipMultiretos(response.data.retoscompletados);
                });




            }



            $scope.sendTipDirect = function(roomId, chatType, value) {

                

                if (angular.isNumber(parseInt(value)) && parseInt(value) > 0) {
                    chatService.sendTipTokens(roomId, parseInt(value)).then(function(response) {
                        if (response.data.success == false) {
                            return alertify.warning(response.data.message);
                        } else {
                            alertify.success(response.data.message);
                            $scope.streamingInfo.spendTokens += parseInt(value);
                            $scope.streamingInfo.tokens -= parseInt(value);

                            var sendObj = {
                                roomId: roomId,
                                token: value,
                                text: parseInt(value) + ' tokens enviados',
                                type: chatType
                            };
                            if ($('.chat-multiretos').is(':visible')) {

                                console.log("existe elemento");

                                $scope.multiretosProgressbar(sendObj);

                            } else {

                                socket.sendTip(sendObj);

                            }
                            socket.sendModelReceiveInfo({
                                time: 0,
                                tokens: value
                            });



                            //si video privado esta activo
                            if ($scope.PrivateVideoxregular) {

                                chatService.sendTipTokensPrivados(roomId, parseInt(value)).then(function(response) {

                                    console.log(response.data.tokensprivado);

                                    if (parseInt(response.data.tokensprivado) >= parseInt($scope.tokenVideoprivadox)) {
                                        console.log("le toca activar el video privado");
                                        $scope.mostrarVideoPrivadox();
                                        $scope.isPrivateVideox = false;
                                        //$('img#private-videox').hide();

                                    }


                                });
                            }



                        }
                    });
                } else {
                    alertify.error('por favor ingresa un número');

                }

            };



            $scope.sendTip = function(roomId, chatType) {

                alertify.prompt("Ingresa tokens", '', function(evt, value) {
                    if (angular.isNumber(parseInt(value)) && parseInt(value) > 0) {
                        chatService.sendTipTokens(roomId, parseInt(value)).then(function(response) {
                            if (response.data.success == false) {
                                return alertify.warning(response.data.message);
                            } else {
                                alertify.success(response.data.message);
                                $scope.streamingInfo.spendTokens += parseInt(value);
                                $scope.streamingInfo.tokens -= parseInt(value);

                                var sendObj = {
                                    roomId: roomId,
                                    token: value,
                                    text: parseInt(value) + ' tokens enviados',
                                    type: chatType
                                };
                                //emit chat event to server

                                if ($('.chat-multiretos').is(':visible')) {

                                    console.log("existe elemento");

                                    $scope.multiretosProgressbar(sendObj);

                                } else {

                                    socket.sendTip(sendObj);

                                }

                                if ($scope.PrivateVideoxregular) {

                                    chatService.sendTipTokensPrivados(roomId, parseInt(value)).then(function(response) {

                                        console.log(response.data.tokensprivado);

                                        if (parseInt(response.data.tokensprivado) >= parseInt($scope.tokenVideoprivadox)) {
                                            console.log("le toca activar el video privado");
                                            $scope.mostrarVideoPrivadox();
                                            $scope.isPrivateVideox = false;
                                            //$('img#private-videox').hide();

                                        }


                                    });
                                }



                                socket.sendModelReceiveInfo({
                                    time: 0,
                                    tokens: value
                                });

                            }
                        });
                    } else {
                        
 switch($('#idioma').val()) {
          case 'es':
            alertify.error('Por favor, introduzca un número.');
            break;
          case 'en':
             alertify.error('Please enter a number.');
            break;

            case 'fr':
            alertify.error('Veuillez saisir un nombre.');
            break;
          default:
           alertify.error('Por favor, introduzca un número.');
        }
                        $scope.sendTip();
                    }
                }).set('title', 'Tip');
            };
            $scope.backToFreeChat = function(modelId, url) {
                if (appSettings.USER) {
                    socket.emit('stop-video-request', {
                        data: {
                            modelId: modelId,
                        }
                    });
                }
                return window.location.href = url;
            };
            /**
             *
             * @param {type} roomId
             * @returns {undefined}
             */




            socket.onModelReceiveInfo(function(data) {

                console.log("onModelReceiveInfo");
                // $scope.streamingInfo.tokens += parseInt(data.tokens);
                if ($scope.streamingInfo.type == 'private' && appSettings.USER && appSettings.USER.id == PerformerChat.model_id) {
                    $scope.streamingInfo.tokensReceive += parseInt(data.tokens);
                    $scope.streamingInfo.time += parseInt(data.time);
                }
            });
            /*
 if (!appSettings.USER || appSettings.USER.id != PerformerChat.model_id) {
    //event get current model online
    socket.getCurrentModelOnline(appSettings.CHAT_ROOM_ID);

    //event receive current model online or offline (return undefined)
    $scope.modelOnline = null;
    socket.onCurrentModelOnline(function (data) {
        $scope.modelOnline = _.find(data, _.matchesProperty('id', PerformerChat.model_id));

        if (!$scope.modelOnline || typeof $scope.modelOnline == 'undefined') {
            alertify.notify('Model is offline.');
            $scope.isOffline = true;
            if($('#offline-image').length > 0){
                    $('#offline-image').show();
            }
            $('#videos-container').removeClass('loader');

        }
    });
 }*/

            $scope.stopStreaming = function() {
                console.log("darrw");
                console.log(connection);
                $scope.connectionNow.close();
                connection.videosContainer.innerHTML = '';
                connection.autoCloseEntireSession = true;

                console.log(connection);
                $scope.connectionNow.close();
                $scope.isStreaming = false;


                //call an event to socket
                socket.emit('model-leave-room');
                location.reload();
            };

            $scope.changeStreaming = function(modelId, type) {
                chatSettingService.getChatPrice(modelId, type).success(function(cost) {
                    var message = type == 'group' ? 'Group chat will take you ' + cost + ' tokens each minute' : 'Private chat will take you ' + cost + ' tokens each minute';
                    alertify.confirm(message, function() {
                        if (type == 'group') {
                            return window.location.href = appSettings.BASE_URL + 'members/groupchat/' + modelId;
                        } else {
                            return window.location.href = appSettings.BASE_URL + 'members/privatechat/' + modelId;
                        }
                    }).set('title', 'Confirm');
                });
            };

            //model's status
            $scope.statusForUpdating = '';
            $scope.modelStatus = '';
            if (appSettings.USER && appSettings.USER.role == 'model' && appSettings.USER.id == $scope.modeloid) {
                userService.get().success(function(data) {
                    $scope.statusForUpdating = data.status;
                });
            }
            $scope.updateStatus = function(form) {
                socket.emit('updateModelStatus', {
                    userId: appSettings.USER.id,
                    roomId: $scope.roomId,
                    status: $scope.statusForUpdating
                }, function() {
                    //alertify.success('Updated successfullyererer');


                    switch ($('#idioma').val()) {
                        case 'es':
                            alertify.success('Actualizado con éxito');
                            break;
                        case 'en':
                            // code block
                            alertify.success('Updated successfully');

                            break;

                        case 'fr':
                            // code block
                            alertify.success('Mis à jour avec succés');
                            break;
                        default:
                            alertify.success('Actualizado con éxito');
                    }


                });
            };
            socket.on('updateModelStatus', function(data) {
                $scope.modelStatus =  data.status;
            });

            // show full screen
            $scope.isFullScreenMode = false;
            $scope.showFullScreen = function() {
                $scope.isFullScreenMode = true;
                $('.header').addClass('hidden');
                $('.line-menu').addClass('hidden');
                $('.footer').addClass('hidden');
                $('body').addClass('fullscreen-mode');
                $('.top-detial').addClass('hidden');
                $('.model-detail-section').addClass('hidden');
                $scope.isFullScreenMode = true;
            };
            $scope.notShowFullScreen = function() {
                $scope.isFullScreenMode = false;
                $('.header').removeClass('hidden');
                $('.line-menu').removeClass('hidden');
                $('.footer').removeClass('hidden');
                $('.top-detial').removeClass('hidden');
                $('body').removeClass('fullscreen-mode');
                $('.model-detail-section').removeClass('hidden');
            };

            $scope.mostrarVideoPrivadox = function() {




                console.log("Room id" + $scope.roomId);
                console.log("virtual room" + $scope.virtualRoom);
                console.log("modelo id" + $scope.modeloid);
                //$('img#private-videox').hide();
                $('#videos-container').show();
                $scope.isPrivateVideox = false;

                $scope.joinBroadcast($scope.roomId, $scope.virtualRoom, $scope.modeloid);
                console.log("MOSTRAR PRIVADO");
                $('img#private-videox').hide();

            }




            $scope.ocultarVideoPrivadox = function() {

                const tracks = $scope.local_stream.stream.getTracks();
                tracks.forEach(function(track) {
                    track.stop();
                });



                $scope.PrivateVideoxregular = true;

                console.log("OCULTAR PRIVADO");
                $scope.isPrivateVideox = true;
                $('img#private-videox').show();

                $('#videos-container').empty();


                console.log("PRIVADO");
            }

            $scope.changeVideoPrivadox = function() {


                if ($scope.videoPrivadox) {



                    alertify.confirm('Si pones el vídeo en privado solo podrán verte los usuarios que hayan aportado o aporten luego al juego activo. ¿Quieres poner el vídeo en privado?', function() {
                        alertify.success('Ok')


                        socket.Videoprivadoxactivar({
                            user_id: appSettings.USER.id,
                            tokens: $scope.tokenVideoprivadox
                        });
                        console.log("activar video privadox");

                        var msg = "Se ha puesto el vídeo privado. Solo visible para quien aporte un mínimo de <strong>" + $scope.tokenVideoprivadox + " tokens</strong><i class='icon-coin'></i>";
                        const msgId = Date.now();
                        var sendObj = {
                            roomId: $scope.roomId,
                            token: $scope.tokenVideoprivadox,
                            text: msg,
                            tip: 'vp',
                            id: msgId,
                            type: 'private',
                            videoprivadox: true
                        };

                        $scope.$broadcast('sendMsgVideoprivadox', sendObj);



                    }, function() {
                        alertify.error('Cancel')
                        $scope.videoPrivadox = false;
                        $('#videoPrivadox').prop('checked', false);
                    }).set({
                        title: "Poner vídeo privado"
                    }).set({
                        labels: {
                            ok: 'Sí, poner vídeo privado',
                            cancel: 'No, seguir con el vídeo público'
                        }
                    });;

                } else {

                    socket.Videoprivadoxdesactivar({
                        user_id: appSettings.USER.id
                    });
                    console.log("Desactivar video privadox");

                    var msg = "Se ha puesto el vídeo público. ";
                    const msgId = Date.now();
                    var sendObj = {
                        roomId: $scope.roomId,
                        token: $scope.tokenVideoprivadox,
                        text: msg,
                        tip: 'vp',
                        id: msgId,
                        type: 'private',
                        videoprivadox: true
                    };

                    $scope.$broadcast('sendMsgVideoprivadox', sendObj);

                }




            }


            socket.onVideoprivadoxactivar(function(data) {

                console.log(data);
                $scope.tokenVideoprivadox = data.tokens;
                $scope.PrivateVideoxregular = true;

                $(".text-videoprivado").show();
                $("#cantvideoprivadox").html(data.tokens + " Tokens");

                console.log("ocultar video para todos");
                //$scope.ocultarVideoPrivadox();




                userService.FindParticipantes($scope.modeloid).then(function(response) {

                    if (parseInt(response.data.tokensprivado) < parseInt($scope.tokenVideoprivadox)) {

                        $scope.ocultarVideoPrivadox();

                    }
                });




            });


            socket.onVideoprivadoxdesactivar(function(data) {

                $scope.PrivateVideoxregular = false;
                $scope.mostrarVideoPrivadox();

                console.log("mostrar video nuevamente");


            });



            socket.Videoprivadoxtip(function(data) {


                if ($scope.videoPrivadox) {

                    userService.Participantes($scope.modeloid).then(function(response) {
                        console.log("participantes");
                        console.log(response.data);
                        $scope.participantes = response.data;
                    });

                }

                console.log("Entro en Videoprivadoxtip");
                console.log($scope.videoPrivadox);

            })


//ruleta

 socket.onInitRuletachart(function (data) {



    dataruleta = data;

    $scope.drawRuleta(1);

    $scope.isShowruletachart = true;


 });







$scope.drawRuleta = function(nivel){




 Website.drawRuleta(dataruleta, nivel);

 Website.girarIndefinido();


}


$scope.gira = function(nivel) {



    $timeout(function(){ 

 return  Website.spin(dataruleta,nivel,false)
});


}



$scope.volumevideo = function(){


   if (!appSettings.USER || $scope.modeloid != appSettings.USER.id) {

            if($scope.tagvideo.muted){
                $scope.local_stream.stream.getAudioTracks()[0].enabled = false;
                return;

            }

          if($scope.tagvideo.volume == 0){

            $scope.local_stream.stream.getAudioTracks()[0].enabled = !$scope.local_stream.stream.getAudioTracks()[0].enabled;

          }else{

            $scope.local_stream.stream.getAudioTracks()[0].enabled = true;

          }

    }

};


$scope.clickRuleta = function(){


   $timeout(function() {
        angular.element('.tab-border .nav.nav-tabs li #juegoruleta').trigger('click');
        $( ".tab-border .nav.nav-tabs li #juegoruleta" ).trigger( "click" );

        });

}


$scope.hideRuleta = function(){

  // $scope.isShowruletachart =false;
   $scope.hiddenRuleta =true;

}


$scope.showRuleta = function(){

  // $scope.isShowruletachart =true;
   $scope.hiddenRuleta =false;

}



            $scope.sendTipSpin = function(roomId, chatType, value, titulo,nivel) {


                if (angular.isNumber(parseInt(value)) && parseInt(value) > 0) {
                    chatService.sendTipTokens(roomId, parseInt(value)).then(function(response) {
                        if (response.data.success == false) {
                            return alertify.warning(response.data.message);
                        } else {

                           var taskWin =   Website.spin(dataruleta,nivel,false);


                           if(taskWin){

                                setTimeout(function(){ 


                                       //alertify.success(response.data.message);
                                    $scope.streamingInfo.spendTokens += parseInt(value);
                                    $scope.streamingInfo.tokens -= parseInt(value);

                                var sendObj = {
                                    roomId: roomId,
                                    tip:'ru',
                                    token: value,
                                    text: "ha girado la Ruleta Hot: <strong class='ruletatitulo'>"+titulo+"</strong><br> y el elemento al azar es: <strong class='ruletatask'>"+ taskWin.task +"</strong><br> Tokens enviados <strong>"+parseInt(value) +"</strong>" ,
                                    type: chatType,
                                    ruleta: true,
                                    taskWin : taskWin.picked,
                                    nivel: nivel
                                };
                               
                                socket.sendModelReceiveInfo({
                                    time: 0,
                                    tokens: value
                                });

                                    socket.sendTip(sendObj);
                                    console.log("task: "+ taskWin);



                            }, 5000);

 



                           }
                        
                        }
                    });
                } else {
                    alertify.error('por favor ingresa un número');

                }

            };

$scope.mic = function(){

    $scope.local_stream.stream.getAudioTracks()[0].enabled = !$scope.local_stream.stream.getAudioTracks()[0].enabled;
    $scope.micOn =$scope.local_stream.stream.getAudioTracks()[0].enabled;
}

$scope.girarModeloruleta = function(data,nivel,picked) {

      $scope.drawRuleta(nivel);


/*console.log(data.datos);

console.log("girar modelo ruleta");


var xxxx =  data;

console.log(xxxx.datosniveluno)
console.log("NIVEL UNO");*/

$scope.hiddenRuleta =false;

  Website.spin(data,nivel,picked)

  return true;



}



        }
    ]);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('likesWidgetCtrl', ['$scope', 'appSettings', 'likesWidgetService', function ($scope, appSettings, likesWidgetService) {

  $scope.init = function (itemId, item) {
    $scope.itemId = itemId;
    $scope.item = item;
    likesWidgetService.count({ itemId: $scope.itemId, item: $scope.item }).success(function (data, status, headers, config) {
      $scope.totalLikes = data;
    });
    //check like status
    likesWidgetService.checkMe({ itemId: $scope.itemId, item: $scope.item }).success(function (data, status, headers, config) {
      $scope.liked = data;
    });
  };

  $scope.likeThis = function () {
    likesWidgetService.likeMe({ itemId: $scope.itemId, status: $scope.liked, item: $scope.item }).then(function (data, status, headers, config) {
      if (data.data.status == 'error') {
        alertify.warning(data.data.message);
        return;
      }
      $scope.liked = data.data.status == 'like' ? 1 : 0;
      likesWidgetService.count({ itemId: $scope.itemId, item: $scope.item }).success(function (data, status, headers, config) {
        $scope.totalLikes = data;
      });
    });
  };
}]);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelProfileImageCtrl', function ($scope, $uibModal, appSettings, mediaService, userService) {

  $scope.currentPage = 1;
  var lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'createdAt';
  $scope.sort = 'desc';

  $scope.myImages = [];

  $scope.loadMoreInfinite = false;

  mediaService.findProfileByMe({ page: lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image', mediaType: 'profile' }).success(function (data) {
    $scope.myImages = data.data;
    $scope.currentPage = data.current_page;
    if (lastPage < data.last_page) {
      lastPage = lastPage + 1;
      $scope.loadMoreInfinite = true;
    }
  });

  //make profile
  $scope.makeProfile = function (index, id) {
    userService.setProfile(id).then(function (data) {
      if (data.data.success) {
        alertify.success(data.data.message);
        window.location.reload();
      }
    });
  };
  //delete image
  $scope.deleteModelImage = function (key, id) {

    let langText = '';

          switch($("#current_idioma").val()){
        case 'en':
            langText= 'Are you sure you want to delete this?';
            break;

        case 'fr':
            langText= 'Voulez-vous vraiment le supprimer?';
            break;

        default:
           langText= '¿Estás seguro que quieres eliminar esto?';
        }
    alertify.confirm(langText, function () {
      mediaService.deleteImage(id).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          $scope.myImages.splice(key, 1);
        } else {
          alertify.error(data.data.error);
        }
      });
    }).set('title', 'Confirm');
  };
  //load more
  $(window).scroll(function () {
    if ($(window).scrollTop() == $(document).height() - $(window).height() && $scope.loadMoreInfinite) {
      mediaService.findProfileByMe({ page: lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image', mediaType: 'profile' }).success(function (data) {
        lastPage = lastPage + 1;

        $scope.myImages = $scope.myImages.concat(data.data);

        if (lastPage > data.last_page) {

          $scope.loadMoreInfinite = false;
        }
      });
    }
  });
  ///call upload model

  $scope.showUploadModal = function (size) {
    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: appSettings.BASE_URL + 'app/modals/model-multiple-upload/multiple-upload.html?v=' + Math.random().toString(36).slice(2),
      controller: 'ModalUploadInstanceCtrl',
      size: size,
      backdrop: 'static',
      keyboard: false,
      resolve: {
        type: function type() {
          return 'image';
        },
        mediaType: function mediaType() {
          return 'profile';
        },
        parentId: function parentId() {
          return 0;
        },
        modelId: function modelId() {
          return appSettings.USER.id;
        }
      }

    });
    modalInstance.result.then(function (data) {
      for (var i in data) {
        $scope.myImages.push(data[i]);
      }
    });
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelVideoCtrl', function ($scope, $uibModal, appSettings, mediaService, userService) {

  $scope.currentPage = 1;
  var lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'createdAt';
  $scope.sort = 'desc';

  $scope.myVideos = [];

  $scope.loadMoreInfinite = false;

  mediaService.findByMe({ page: lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'video' }).success(function (data) {
    $scope.myVideos = data.data;
    $scope.currentPage = data.current_page;
    if (lastPage < data.last_page) {
      lastPage = lastPage + 1;
      $scope.loadMoreInfinite = true;
    }
  });

  //delete image
  $scope.deleteModelImage = function (key, id) {

    let langText = '';
              switch($("#current_idioma").val()){
        case 'en':
            langText= 'Are you sure you want to delete this?';
            break;

        case 'fr':
            langText= 'Voulez-vous vraiment le supprimer?';
            break;

        default:
           langText= '¿Estás seguro que quieres eliminar esto?';
        }
    alertify.confirm(langText, function () {
      mediaService.deleteFile(id).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          $scope.myVideos.splice(key, 1);
        } else {
          alertify.error(data.data.error);
        }
      });
    }).set('title', 'Confirm');
  };
  //load more
  $scope.loadMoreImages = function () {

    if ($scope.loadMoreInfinite == true) {
      mediaService.findByMe({ page: lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'video' }).success(function (data) {
        lastPage = lastPage + 1;

        $scope.myVideos = $scope.myVideos.concat(data.data);

        if (lastPage > data.last_page) {

          $scope.loadMoreInfinite = false;
        }
      });
    }
  };
  ///call upload model

  $scope.showUploadModal = function (size) {
    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: appSettings.BASE_URL + 'app/modals/model-upload-images/upload-images.html?v=' + Math.random().toString(36).slice(2),
      controller: 'ModalUploadInstanceCtrl',
      size: size,
      backdrop: 'static',
      keyboard: false,
      resolve: {
        type: function type() {
          return 'video';
        },
        mediaType: function mediaType() {
          return 'video';
        }
      }

    });
    modalInstance.result.then(function (data) {
      for (var i in data) {
        $scope.myVideos.push(data[i]);
      }
    });
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelProfileCtrl', function ($scope, appSettings, userService, countryService, categoryService) {

  $scope.profile = [];
  $scope.performer = [];
  $scope.countries = [];
  $scope.states = [];
  $scope.cities = [];

  userService.get().then(function (data) {
    $scope.profile = data.data;
  });
  userService.getPerformer().then(function (data) {
    $scope.performer = data.data;
    $scope.performer.category_id = parseInt($scope.performer.category_id);
    $scope.performer.age = parseInt($scope.performer.age) > 0 ? parseInt($scope.performer.age) : null;
    $scope.performer.city_id = parseInt($scope.performer.city_id);
    $scope.performer.countryId = parseInt($scope.performer.countryId);
    $scope.performer.country_id = parseInt($scope.performer.country_id);
    //    $scope.performer.height = parseInt($scope.performer.height);
    $scope.performer.parentId = parseInt($scope.performer.parentId);
    $scope.performer.stateId = parseInt($scope.performer.stateId);
    $scope.performer.state_id = parseInt($scope.performer.state_id);
    $scope.performer.user_id = parseInt($scope.performer.user_id);
    $scope.performer.tokens = parseInt($scope.performer.tokens);

    if (data.data.languages != '') {
      $scope.performer.languages = data.data.languages.split(', ');
    }
    countryService.getCountries().then(function (data) {
      $scope.countries = data.data;
    });
    countryService.getStates($scope.performer.country_id).then(function (data) {
      $scope.states = data.data;
    });
    countryService.getCities($scope.performer.state_id).then(function (data) {
      $scope.cities = data.data;
    });
  });
  $scope.ages = [];

  $scope.init = function () {
    var i;
    for (i = 18; i <= 59; i++) {
      $scope.ages.push(i);
    }
    $scope.heightList = [{
      value: 140,
      text: '4.6 (140 cm)'
    }, {
      value: 141,
      text: '4.6 (141 cm)'
    }, {
      value: 142,
      text: '4.7 (142 cm)'
    }, {
      value: 143,
      text: '4.7 (143 cm)'
    }, {
      value: 144,
      text: '4.7 (144 cm)'
    }, {
      value: 145,
      text: '4.8 (145 cm)'
    }, {
      value: 146,
      text: '4.8 (146 cm)'
    }, {
      value: 147,
      text: '4.8 (147 cm)'
    }, {
      value: 148,
      text: '4.9 (148 cm)'
    }, {
      value: 149,
      text: '4.9 (149 cm)'
    }, {
      value: 150,
      text: '4.9 (150 cm)'
    }, {
      value: 151,
      text: '5.0 (151 cm)'
    }, {
      value: 152,
      text: '5.0 (152 cm)'
    }, {
      value: 153,
      text: '5.0 (153 cm)'
    }, {
      value: 154,
      text: '5.1 (154 cm)'
    }, {
      value: 155,
      text: '5.1 (155 cm)'
    }, {
      value: 156,
      text: '5.1 (156 cm)'
    }, {
      value: 157,
      text: '5.1 (157 cm)'
    }, {
      value: 158,
      text: '5.2 (158 cm)'
    }, {
      value: 159,
      text: '5.2 (159 cm)'
    }, {
      value: 160,
      text: '5.2 (160 cm)'
    }, {
      value: 161,
      text: '5.3 (161 cm)'
    }, {
      value: 162,
      text: '5.3 (162 cm)'
    }, {
      value: 163,
      text: '5.3 (163 cm)'
    }, {
      value: 164,
      text: '5.4 (164 cm)'
    }, {
      value: 165,
      text: '5.4 (165 cm)'
    }, {
      value: 166,
      text: '5.4 (166 cm)'
    }, {
      value: 167,
      text: '5.5 (167 cm)'
    }, {
      value: 168,
      text: '5.5 (168 cm)'
    }, {
      value: 169,
      text: '5.5 (169 cm)'
    }, {
      value: 170,
      text: '5.6 (170 cm)'
    }, {
      value: 171,
      text: '5.6 (171 cm)'
    }, {
      value: 172,
      text: '5.6 (172 cm)'
    }, {
      value: 173,
      text: '5.7 (173 cm)'
    }, {
      value: 174,
      text: '5.7 (174 cm)'
    }, {
      value: 175,
      text: '5.7 (175 cm)'
    }, {
      value: 176,
      text: '5.8 (176 cm)'
    }, {
      value: 177,
      text: '5.8 (177 cm)'
    }, {
      value: 178,
      text: '5.8 (178 cm)'
    }, {
      value: 179,
      text: '5.9 (179 cm)'
    }, {
      value: 180,
      text: '5.9 (180 cm)'
    }, {
      value: 181,
      text: '5.9 (181 cm)'
    }, {
      value: 182,
      text: '6.0 (182 cm)'
    }, {
      value: 183,
      text: '6.0 (183 cm)'
    }, {
      value: 184,
      text: '6.0 (184 cm)'
    }, {
      value: 185,
      text: '6.1 (185 cm)'
    }, {
      value: 186,
      text: '6.1 (186 cm)'
    }, {
      value: 187,
      text: '6.1 (187 cm)'
    }, {
      value: 188,
      text: '6.2 (188 cm)'
    }, {
      value: 189,
      text: '6.2 (189 cm)'
    }, {
      value: 190,
      text: '6.2 (190 cm)'
    }, {
      value: 191,
      text: '6.3 (191 cm)'
    }, {
      value: 192,
      text: '6.3 (192 cm)'
    }, {
      value: 193,
      text: '6.3 (193 cm)'
    }, {
      value: 194,
      text: '6.4 (194 cm)'
    }, {
      value: 195,
      text: '6.4 (195 cm)'
    }, {
      value: 196,
      text: '6.4 (196 cm)'
    }, {
      value: 197,
      text: '6.5 (197 cm)'
    }, {
      value: 198,
      text: '6.5 (198 cm)'
    }, {
      value: 199,
      text: '6.5 (199 cm)'
    }];
    $scope.publics = [{
      value: 'trimmed',
      text: 'Trimmed'
    }, {
      value: 'shaved',
      text: 'Shaved'
    }, {
      value: 'hairy',
      text: 'Hairy'
    }, {
      value: 'no_comment',
      text: 'No Comment'
    }];
    $scope.categories = [];
    $scope.selectState = 'Select a State';
    $scope.selectCity = 'Select a City';
    if (!$scope.performer.country_id) {
      $scope.selectState = 'Select a Country first';
    }
    if (!$scope.performer.state_id) {
      $scope.selectCity = 'Select s State first';
    }

    categoryService.all().then(function (data) {
      $scope.categories = data.data;
    });
  };
  $scope.init();

  $scope.changeCountry = function (countryId) {
    if (countryId) {
      $scope.selectState = 'Select a State';
    } else {
      $scope.selectState = 'Select a Country first';
    }
    countryService.getStates(countryId).then(function (data) {
      $scope.states = data.data;
    });
  };
  $scope.changeState = function (stateId) {
    if (stateId) {
      $scope.selectCity = 'Select a City';
    } else {
      $scope.selectCity = 'Select a State first';
    }
    countryService.getCities(stateId).then(function (data) {
      $scope.cities = data.data;
    });
  };

  $scope.errors = {
    state: false,
    city: false
  };

  $scope.formSubmitted = false;
  $scope.savePerformerProfile = function (form) {

    if (!$scope.performer.state_id && $scope.performer.state_name == '') {
      $scope.errors.state = true;
    } else {
      $scope.errors.state = false;
    }
    if (!$scope.performer.city_id && $scope.performer.city_name == '') {
      $scope.errors.city = true;
    } else {
      $scope.errors.city = false;
    }
    if ($scope.errors.state || $scope.errors.city) {
      return;
    }
    if (form.$valid) {
      $scope.formSubmitted = true;
      userService.updatePerformer($scope.performer, { firstName: $scope.profile.firstName, lastName: $scope.profile.lastName, status: $scope.profile.status }).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          window.location.href = data.data.url;
        } else {
          $scope.formSubmitted = false;
          alertify.error(data.data.message);
        }
      });
    }
  };
  $scope.checkLanguage = function (tag) {
    var myRegEx = /^[a-zA-Z]+$/;
    return myRegEx.test(tag.text);
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelCreateGalleryCtrl', function ($scope, galleryService, appSettings, mediaService) {

  $scope.gallery = {
    name: '',
    description: '',
    price: 100,
    type: '',
    status: 'private'
  };

  $scope.submitted = false;
  $scope.errors = {};

  $scope.submitCreateGallery = function (form) {
    if (form.$valid) {
      $scope.submitted = true;
      galleryService.create($scope.gallery).then(function (data) {
        if (data.data.success) {
          $scope.errors = {};
          alertify.success(data.data.message);
          window.location.href = data.data.url;
        } else {
          $scope.submitted = false;
          $scope.errors = data.data.errors;
          if (data.data.message) {
            alertify.alert(data.data.message).setHeader('Warning');
          }
        }
      });
    }
  };
  $scope.submitCreateImage = function (form, modelId) {
    $scope.errors = {};
    if (!$('#fileInputImage')[0].files.length) {
      $scope.errors.image = 'Please select an image';
      return false;
    }
    if (form.$valid) {
      $scope.submitted = true;
      var idModel = appSettings.USER.id;
      if (modelId) {
        $scope.gallery.model_id = modelId;
        idModel = modelId;
      }
      return galleryService.create($scope.gallery).then(function (data) {
        if (data.data.success) {
          var formData = new FormData();
          formData.append('myFiles', $('#fileInputImage')[0].files[0]);
          return $.ajax({
            url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=image&parent-id=' + data.data.id + '&model-id=' + idModel,
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false
          });
        } else {
          return Promise.reject({
            errors: data.data.errors,
            message: data.data.message
          });
        }
      }).then(function (dataFile) {
        return mediaService.setMainImage(dataFile.file.id).then(function () {
          return Promise.resolve(dataFile);
        });
      }).then(function (dataFile) {
        return mediaService.setMediaStatus(dataFile.file.id, 'inactive');
      }).then(function () {
        $scope.errors = {};
        alertify.success('Create successfully');
        if (!modelId) {
          window.location.href = '/models/dashboard/media/image-galleries';
        } else {
          window.location.href = '/admin/manager/image-gallery/' + modelId;
        }
      }).catch(function (err) {
        $scope.submitted = false;
        $scope.errors = err.errors;
        alertify.alert(err.message).setHeader('Warning');
      });
    }
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelEditGalleryCtrl', function ($scope, galleryService, mediaService) {

  $scope.gallery = {};
  $scope.attachmentId = '';
  $scope.initEdit = function (gallery, attachmentId) {
    $scope.gallery = {
      id: gallery.id,
      description: gallery.description,
      name: gallery.name,
      price: parseInt(gallery.price),
      type: gallery.type,
      previewImage: gallery.previewImage,
      status: gallery.status,
      mediaMeta: gallery.mediaMeta
    };
    $scope.attachmentId = attachmentId;
  };
  if ($('#preview-image-uploader').length > 0) {
    var priviewSetting = {
      url: appSettings.BASE_URL + 'api/v1/upload-items?parent-id=0',
      method: "POST",
      allowedTypes: 'png,jpg,jpeg',
      fileName: 'myFiles',
      multiple: false,
      showDelete: true,
      showPreview: false,
      showDone: true,
      statusBarWidth: '100%',
      dragdropWidth: '100%',
      onSuccess: function onSuccess(files, data, xhr) {

        if (data.success == true) {
          $scope.gallery.previewImage = data.file.id;
          $('#previewImg').attr('src', appSettings.BASE_URL + data.file.path);
          alertify.success(data.message);
        } else {
          alertify.error(data.message);
        }
      },
      onError: function onError(files, status, errMsg) {

 switch($('#idioma').val()) {
          case 'es':
            $("#priviewImageStatus").html("<font color='red'>No se pudo cargar</font>");
            break;
          case 'en':
             $("#priviewImageStatus").html("<font color='red'>Upload is Failed</font>");
            break;

            case 'fr':
            $("#priviewImageStatus").html("<font color='red'>Le téléchargement a échoué</font>");
            break;
          default:
           $("#priviewImageStatus").html("<font color='red'>No se pudo cargar</font>");
        }

        
      },
      deleteCallback: function deleteCallback(element, data, pd) {
        mediaService.deleteFile(element.file.id).then(function (data) {
          if (data.data.success) {
            $scope.gallery.priviewImage = null;
            alertify.success(data.data.message);
          }
        });
      }
    };
    $("#preview-image-uploader").uploadFile(priviewSetting);
  }

  $scope.errors = {};
  $scope.submitUpdateGallery = function (form) {

    if (form.$valid) {

      galleryService.update($scope.gallery).then(function (data) {
        if (data.data.success) {
          $scope.errors = {};
          alertify.success(data.data.message);
          if (data.data.errors != '') {
            alertify.warning(data.data.errors);
          } else {
            window.location.href = data.data.url;
          }
        } else {
          $scope.errors = data.data.errors;
          if (data.data.message) {
            alertify.alert(data.data.message).setHeader('Warning');
          }
        }
      });
    }
  };

  $scope.submitUpdateImage = function (form, modelId) {
    if (form.$valid) {
      var idModel = appSettings.USER.id;
      if (modelId) {
        idModel = modelId;
      }
      return galleryService.update($scope.gallery).then(function (data) {
        if (data.data.success) {
          // if upload new image
          if ($('#fileInputImage')[0].files.length) {
            var formData = new FormData();
            formData.append('myFiles', $('#fileInputImage')[0].files[0]);
            return $.ajax({
              url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=image&parent-id=' + $scope.gallery.id + '&model-id=' + idModel,
              data: formData,
              type: 'POST',
              contentType: false,
              processData: false
            }).then(function (dataFile) {
              return mediaService.setMainImage(dataFile.file.id).then(function () {
                return mediaService.setMediaStatus(dataFile.file.id, 'inactive');
              }).then(function () {
                // remove the old image
                return mediaService.deleteImage($scope.attachmentId);
              }).then(function () {
                $scope.errors = {};

                 switch($('#idioma').val()) {
                          case 'es':
                            alertify.success('Actualizar correctamente');
                            break;
                          case 'en':
                             alertify.success('Update successfully');
                            break;

                            case 'fr':
                          alertify.success('Mettre à jour avec succès');
                            break;
                          default:
                           alertify.success('Actualizar correctamente');
                        }

                if (modelId) {
                  return window.location.href = '/admin/manager/image-gallery/' + modelId;
                } else {
                  return window.location.href = '/models/dashboard/media/image-galleries';
                }
              });
            });
          } else {
            $scope.errors = {};
            alertify.success('Update successfully');
            if (modelId) {
              return window.location.href = '/admin/manager/image-gallery/' + modelId;
            } else {
              window.location.href = '/models/dashboard/media/image-galleries';
            }
          }
        } else {
          $scope.errors = data.data.errors;
          if (data.data.message) {
            alertify.alert(data.data.message).setHeader('Warning');
          }
        }
      });
    }
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelImageGalleryCtrl', function ($scope, galleryService, mediaService, appSettings, $uibModal, earningService) {

  $scope.currentPage = 1;
  $scope.lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'createdAt';
  $scope.sort = 'desc';

  $scope.myImages = [];

  $scope.loadMoreInfinite = false;
  $scope.galleryInit = function (id) {
    $scope.pageLoadSuccess = false;
    $scope.galleryId = id;
    mediaService.findMyMediaGallery({ page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image', galleryId: id }).success(function (data) {
      $scope.myImages = data.data;
      $scope.pageLoadSuccess = true;
      $scope.currentPage = data.current_page;
      if ($scope.lastPage < data.last_page) {
        $scope.lastPage += 1;
        $scope.loadMoreInfinite = true;
      }
    });
  };

  $scope.showUploadModal = function (_modelId, size) {
    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: appSettings.BASE_URL + 'app/modals/model-multiple-upload/multiple-upload.html?v=' + Math.random().toString(36).slice(2),
      controller: 'ModalUploadInstanceCtrl',
      size: size,
      backdrop: 'static',
      keyboard: false,
      resolve: {
        type: function type() {
          return 'image';
        },
        mediaType: function mediaType() {
          return 'image';
        },
        parentId: function parentId() {
          return $scope.galleryId;
        },
        modelId: function modelId() {
          return _modelId;
        }
      }

    });
    modalInstance.result.then(function (data) {
      for (var i in data) {

        $scope.myImages.push(data[i]);
      }
    });
  };
  $scope.setMainImage = function (index, id) {
    mediaService.setMainImage(id).then(function (data) {
      if (data.data.success) {
        alertify.success(data.data.message);
        window.location.reload();
      } else {
        alertify.error(data.data.error);
      }
    });
  };
  //delete media
  $scope.deleteImageGallery = function (key, id) {
              switch($("#current_idioma").val()){
        case 'en':
            langText= 'Are you sure you want to delete this?';
            break;

        case 'fr':
            langText= 'Voulez-vous vraiment le supprimer?';
            break;

        default:
           langText= '¿Estás seguro que quieres eliminar esto?';
        }
    alertify.confirm(langText, function () {
      earningService.countPaidItem(id, 'image').then(function (data) {
        if (data.data == 0) {
          mediaService.deleteImage(id).then(function (data) {
            if (data.data.success) {
              alertify.success(data.data.message);
              $scope.myImages.splice(key, 1);
            } else {
              alertify.error(data.data.error);
            }
          });
        } else {

 switch($('#idioma').val()) {
          case 'es':
            alertify.alert('Esta es una imagen de compra. No puedes borrarlo.');
            break;
          case 'en':
             alertify.alert('This is a purchase image. You can not delete it.');
            break;

            case 'fr':
            alertify.alert('Ceci est une image d\'achat. Vous ne pouvez pas le supprimer.');
            break;
          default:
           alertify.alert('Esta es una imagen de compra. No puedes borrarlo.');
        }


          
        }
      });
    }).set('title', 'Confirm');
  };
  //set image status active or inactive
  $scope.setMediaStatus = function (index, status) {
    if (status == 'processing') {
      return;
    }
    var imageId = $scope.myImages[index].id;
    mediaService.setMediaStatus(imageId, status).then(function (data) {
      if (data.data.success) {
        alertify.success(data.data.message);
        $scope.myImages[index].status = data.data.status;
      } else {
        alertify.error(data.data.message);
      }
    });
  };

  $(window).scroll(function () {
    if ($(window).scrollTop() == $(document).height() - $(window).height() && $scope.loadMoreInfinite) {
      mediaService.findMyMediaGallery({ page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image', galleryId: $scope.galleryId }).success(function (data) {
        $scope.myImages = $scope.myImages.concat(data.data);
        $scope.currentPage = data.current_page;
        if ($scope.lastPage < data.last_page) {
          $scope.lastPage += 1;
          $scope.loadMoreInfinite = true;
        } else {
          $scope.loadMoreInfinite = false;
        }
      });
    }
  });
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelImageGalleriesCtrl', ["$scope", "galleryService", "mediaService", "appSettings", "earningService", function ($scope, galleryService, mediaService, appSettings, earningService) {

  $scope.currentPage = 1;
  $scope.lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'createdAt';
  $scope.sort = 'desc';

  $scope.myGaleries = [];

  $scope.loadMoreInfinite = false;

  galleryService.findMyGalleries({ page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image' }).success(function (data) {
    $scope.myGalleries = data.data;

    $scope.currentPage = data.current_page;
    if ($scope.lastPage < data.last_page) {
      $scope.lastPage += 1;
      $scope.loadMoreInfinite = true;
    }
  });

  //delete media
  $scope.deleteImageGallery = function (key, id) {
              switch($("#current_idioma").val()){
        case 'en':
            langText= 'Are you sure you want to delete this?';
            break;

        case 'fr':
            langText= 'Voulez-vous vraiment le supprimer?';
            break;

        default:
           langText= '¿Estás seguro que quieres eliminar esto?';
        }
    alertify.confirm(langText, function () {
      mediaService.deleteFile(id).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          $scope.myImages.splice(key, 1);
        } else {
          alertify.error(data.data.error);
        }
      });
    }).set('title', 'Confirm');
  };
  //set image gallery status public or private
  $scope.setGalleryStatus = function (index, status) {
    var galleryId = $scope.myGalleries[index].id;
    galleryService.setGalleryStatus(galleryId, status).then(function (data) {
      if (data.data.success) {
        $scope.myGalleries[index].status = data.data.gallery.status;
        alertify.success(data.data.message);
      } else {
        alertify.error(data.data.message);
      }
    });
  };

  /*
   * delete Gallery
   * @author: Phong Le<pt.hongphong@gmail.com>
   */
  $scope.deleteProcessing = 0;
  $scope.deleteGallery = function (index, id) {
    var langText = "";
              switch($("#current_idioma").val()){
        case 'en':
            langText= 'Are you sure you want to delete this?';
            break;

        case 'fr':
            langText= 'Voulez-vous vraiment le supprimer?';
            break;

        default:
           langText= '¿Estás seguro que quieres eliminar esto?';
        }
    alertify.confirm(langText, function () {
      $scope.deleteProcessing = id;
      earningService.countPaidGallery(id, 'image').then(function (data) {
        if (data.data == 0) {

          galleryService.deleteGallery(id).then(function (data) {
            if (data.data.success) {
              alertify.success(data.data.message);
              $scope.myGalleries.splice(index, 1);
            } else {
              alertify.error(data.data.message);
            }
          });
        } else {
          
 switch($('#idioma').val()) {
          case 'es':
            alertify.alert('Esta es la galería de compras. No puedes borrarlo.');
            break;
          case 'en':
             alertify.alert('This is purchase galllery. You can not delete it.');
            break;

            case 'fr':
          alertify.alert('Ceci est la galerie d\'achat. Vous ne pouvez pas le supprimer.');
            break;
          default:
           alertify.alert('Esta es la galería de compras. No puedes borrarlo.');
        }


          $scope.deleteProcessing = 0;
        }
      });
    }).set('title', 'Confirm');
  };
  $(window).scroll(function () {
    if ($(window).scrollTop() == $(document).height() - $(window).height() && $scope.loadMoreInfinite) {
      galleryService.findMyGalleries({ page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'image' }).success(function (data) {
        $scope.myGalleries = $scope.myGalleries.concat(data.data);
        $scope.currentPage = data.current_page;
        if ($scope.lastPage < data.last_page) {
          $scope.lastPage += 1;
          $scope.loadMoreInfinite = true;
        } else {
          $scope.loadMoreInfinite = false;
        }
      });
    }
  });
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelVideoGalleriesCtrl', ["$scope", "galleryService", "mediaService", "appSettings", "earningService", function ($scope, galleryService, mediaService, appSettings, earningService) {

  $scope.currentPage = 1;
  $scope.lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'createdAt';
  $scope.sort = 'desc';

  $scope.myGaleries = [];

  $scope.loadMoreInfinite = false;

  galleryService.findMyGalleries({ page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'video' }).success(function (data) {
    $scope.myGalleries = data.data;

    $scope.currentPage = data.current_page;
    if ($scope.lastPage < data.last_page) {
      $scope.lastPage += 1;
      $scope.loadMoreInfinite = true;
    }
  });

  //delete media
  $scope.deleteImageGallery = function (key, id) {
            switch($("#current_idioma").val()){
        case 'en':
            langText= 'Are you sure you want to delete this?';
            break;

        case 'fr':
            langText= 'Voulez-vous vraiment le supprimer?';
            break;

        default:
           langText= '¿Estás seguro que quieres eliminar esto?';
        }
    alertify.confirm(langText, function () {
      mediaService.deleteFile(id).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          $scope.myGalleries.splice(key, 1);
        } else {
          alertify.error(data.data.error);
        }
      });
    }).set('title', 'Confirm');
  };
  //  set video status public or private
  $scope.setGalleryStatus = function (index, status) {
    var galleryId = $scope.myGalleries[index].id;
    galleryService.setGalleryStatus(galleryId, status).then(function (data) {
      if (data.data.success) {
        $scope.myGalleries[index].status = data.data.gallery.status;
        alertify.success(data.data.message);
      } else {
        alertify.error(data.data.message);
      }
    });
  };

  //delete Gallery
  //@author: Phong Le<pt.hongphong@gmail.com>
  $scope.deleteProcessing = 0;
  $scope.deleteGallery = function (index, id) {
              switch($("#current_idioma").val()){
        case 'en':
            langText= 'Are you sure you want to delete this?';
            break;

        case 'fr':
            langText= 'Voulez-vous vraiment le supprimer?';
            break;

        default:
           langText= '¿Estás seguro que quieres eliminar esto?';
        }
    alertify.confirm(langText, function () {
      $scope.deleteProcessing = id;
      earningService.countPaidGallery(id, 'video').then(function (data) {
        if (data.data == 0) {
          galleryService.deleteGallery(id).then(function (data) {
            if (data.data.success) {
              alertify.success(data.data.message);
              $scope.myGalleries.splice(index, 1);
            } else {
              alertify.error(data.data.message);
            }
          });
        } else {
         

 switch($('#idioma').val()) {
          case 'es':
             alertify.alert('Esta es la galería de compras. No puedes borrarlo.');
            break;
          case 'en':
              alertify.alert('This is purchase galllery. You can not delete it.');
            break;

            case 'fr':
            alertify.alert('Ceci est la galerie d\'achat. Vous ne pouvez pas le supprimer.');
            break;
          default:
            alertify.alert('Esta es la galería de compras. No puedes borrarlo.');
        }



          $scope.deleteProcessing = 0;
        }
      });
    }).set('title', 'Confirm');
  };

  $(window).scroll(function () {
    if ($(window).scrollTop() == $(document).height() - $(window).height() && $scope.loadMoreInfinite) {
      galleryService.findMyGalleries({ page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'video' }).success(function (data) {
        console.log(data.data);
        $scope.myGalleries = $scope.myGalleries.concat(data.data);
        $scope.currentPage = data.current_page;
        if ($scope.lastPage < data.last_page) {
          $scope.lastPage += 1;
          $scope.loadMoreInfinite = true;
        } else {
          $scope.loadMoreInfinite = false;
        }
      });
    }
  });
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelVideoGalleryCtrl', ["$scope", "mediaService", "appSettings", "$uibModal", "earningService", "videoService", function ($scope, mediaService, appSettings, $uibModal, earningService, videoService) {

  $scope.currentPage = 1;
  $scope.lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'createdAt';
  $scope.sort = 'desc';

  $scope.myVideos = [];

  $scope.loadMoreInfinite = false;
  $scope.galleryInit = function (id, modelId) {
    $scope.galleryId = id;
    var options = {
      page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'video'
    };
    if (modelId) {
      options.modelId = modelId;
    }
    if (id) {
      options.galleryId = id;
    }
    mediaService.findMyVideoGallery(options).success(function (data) {
      $scope.myVideos = data.data;
      $scope.currentPage = data.current_page;
      if ($scope.lastPage < data.last_page) {
        $scope.lastPage += 1;
        $scope.loadMoreInfinite = true;
      }
    });
  };

  $scope.showUploadModal = function (size) {
    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: appSettings.BASE_URL + 'app/modals/model-multiple-upload/multiple-upload.html?v=' + Math.random().toString(36).slice(2),
      controller: 'ModalUploadInstanceCtrl',
      size: size,
      backdrop: 'static',
      keyboard: false,
      resolve: {
        type: function type() {
          return 'video';
        },
        mediaType: function mediaType() {
          return 'video';
        },
        parentId: function parentId() {
          return $scope.galleryId;
        }
      }

    });
    modalInstance.result.then(function (data) {
      for (var i in data) {
        $scope.myVideos.push(data[i]);
      }
    });
  };

  //delete media
  $scope.deleteVideoGallery = function (key, id) {

        let langText = '';
              switch($("#current_idioma").val()){
        case 'en':
            langText= 'Are you sure you want to delete this?';
            break;

        case 'fr':
            langText= 'Voulez-vous vraiment le supprimer?';
            break;

        default:
           langText= '¿Estás seguro que quieres eliminar esto?';
        }
    alertify.confirm(langText, function () {
      earningService.countPaidItem(id, 'video').then(function (data) {
        if (data.data == 0) {
          mediaService.deleteVideo(id).then(function (data) {
            if (data.data.success) {
              alertify.success(data.data.message);
              $scope.myVideos.splice(key, 1);
            } else {
              alertify.error(data.data.error);
            }
          });
        } else {

 switch($('#idioma').val()) {
          case 'es':
            alertify.alert('Este es un video de compra. No puedes borrarlo.');
            break;
          case 'en':
             alertify.alert('This is a purchase video. You can not delete it.');
            break;

            case 'fr':
          alertify.alert('Ceci est une vidéo d\'achat. Vous ne pouvez pas le supprimer.');
            break;
          default:
           alertify.alert('Este es un video de compra. No puedes borrarlo.');
        }



          
        }
      });
    }).set('title', 'Confirm');
  };
  //show video popup
  $scope.showVideoDetail = function (_id, size) {

    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: appSettings.BASE_URL + 'app/modals/video/modal.html',
      controller: 'videoPopupCtrl',
      size: size,
      keyboard: false,
      resolve: {
        id: function id() {
          return _id;
        }
      }

    });
    modalInstance.result.then(function (data) {
      //        window.location.reload();
      //        $('#account-status-' + id).text(data.accountStatus);
      console.log(data);
    });
  };

  //set image status active or inactive
  $scope.setVideoStatus = function (index, status) {
    if (status == 'processing') {
      return;
    }
    var videoId = $scope.myVideos[index].id;
    videoService.setVideoStatus(videoId, status).then(function (data) {
      if (data.data.success) {
        alertify.success(data.data.message);
        $scope.myVideos[index].status = data.data.status;
      } else {
        alertify.error(data.data.message);
      }
    });
  };

  $(window).scroll(function () {
    if ($(window).scrollTop() == $(document).height() - $(window).height() && $scope.loadMoreInfinite) {
      var options = { page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, type: 'video', galleryId: $scope.galleryId };
      if ($scope.galleryId) {
        options.galleryId = $scope.galleryId;
      }
      mediaService.findMyVideoGallery().success(function (data) {

        $scope.myVideos = $scope.myVideos.concat(data.data);
        $scope.currentPage = data.current_page;
        if ($scope.lastPage < data.last_page) {
          $scope.lastPage += 1;
          $scope.loadMoreInfinite = true;
        } else {
          $scope.loadMoreInfinite = false;
        }
      });
    }
  });
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelVideoUploadCtrl', function ($scope, galleryService, mediaService, videoService) {

  $scope.uploadInit = function (id, modelId) {
    $scope.video = {};
    $scope.video.ownerId = modelId;

    $scope.video.galleryId = id;
    $scope.unitPrices = [
      {
        value: 100,
        text: '100 tokens'
      },
      {
        value: 200,
        text: '200 tokens'
      },
      {
        value: 500,
        text: '500 tokens'
      },
      {
        value: 1000,
        text: '1000 tokens'
      },
      {
        value: 1500,
        text: '1500 tokens'
      },
      {
        value: 2000,
        text: '2000 tokens'
      },
      {
        value: 2500,
        text: '2500 tokens'
      },
      {
        value: 3000,
        text: '3000 tokens'
      },
      {
        value: 3500,
        text: '3500 tokens'
      },
      {
        value: 4000,
        text: '4000 tokens'
      },
      {
        value: 5000,
        text: '5000 tokens'
      },
      {
        value: 10000,
        text: '10000 tokens'
      },
      {
        value: 20000,
        text: '20000 tokens'
      },
      {
        value: 30000,
        text: '30000 tokens'
      },
      {
        value: 40000,
        text: '40000 tokens'
      },
      {
        value: 50000,
        text: '50000 tokens'
      },
      {
        value: 100000,
        text: '100000 tokens'
      }];
  };

  if ($('#video-poster-uploader').length > 0) {
    var posterSettings = {
      url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=poster&parent-id=0',
      method: "POST",
      allowedTypes: 'png,jpg,jpeg',
      fileName: 'myFiles',
      multiple: false,
      showDelete: true,
      showPreview: false,
      showDone: true,
      statusBarWidth: '100%',
      dragdropWidth: '100%',
      onSuccess: function onSuccess(files, data, xhr) {

        if (data.success == true) {

          $scope.video.poster = data.file.id;
          alertify.success(data.message);
          $("#poster-status").html("");
        } else {
          // alertify.error(data.message);
          $("#poster-status").html("<font color='red'>" + data.message + "</font>");
        }
      },
      onError: function onError(files, status, errMsg) {

 switch($('#idioma').val()) {
          case 'es':
            $("#poster-status").html("<font color='red'>No se pudo cargar</font>");
            break;
          case 'en':
             $("#poster-status").html("<font color='red'>Upload is Failed</font>");
            break;

            case 'fr':
              $("#poster-status").html("<font color='red'>Le téléchargement a échoué</font>");
            break;
          default:
           $("#poster-status").html("<font color='red'>No se pudo cargar</font>");
        }

        
      },
      deleteCallback: function deleteCallback(element, data, pd) {
        mediaService.deleteImage(element.file.id).then(function (data) {
          if (data.data.success) {
            $scope.video.poster = null;
            alertify.success(data.data.message);
          }
        });
      }
    };
    $("#video-poster-uploader").uploadFile(posterSettings);
  }
  if ($('#video-trailer-uploader').length > 0) {
    var trailerSettings = {
      url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=trailer&parent-id=0',
      method: "POST",
      allowedTypes: 'mp4,m4v,ogg,ogv,webm',
      fileName: 'myFiles',
      multiple: false,
      showDelete: true,
      showPreview: false,
      showDone: true,
      statusBarWidth: '100%',
      dragdropWidth: '100%',
      onSuccess: function onSuccess(files, data, xhr) {

        if (data.success == true) {

          $scope.video.trailer = data.file.id;
          alertify.success(data.message);
          $("#video-trailer-status").html('');
        } else {
          // alertify.error(data.message);
          $("#video-trailer-status").html("<font color='red'>" + data.message + "</font>");
        }
      },
      onError: function onError(files, status, errMsg) {
       

         switch($('#idioma').val()) {
          case 'es':
             $("#video-trailer-status").html("<font color='red'>No se pudo cargar</font>");
            break;
          case 'en':
              $("#video-trailer-status").html("<font color='red'>Upload is Failed</font>");
            break;

            case 'fr':
               $("#video-trailer-status").html("<font color='red'>Le téléchargement a échoué</font>");
            break;
          default:
           $("#video-trailer-status").html("<font color='red'>No se pudo cargar</font>");
        }
      },
      deleteCallback: function deleteCallback(element, data, pd) {
        if (data.success) {
          mediaService.deleteVideo(element.file.id).then(function (data1) {
            if (data1.data.success) {
              $scope.video.trailer = null;
              alertify.success(data.data.message);
            }
          });
        }
      }
    };
    $("#video-trailer-uploader").uploadFile(trailerSettings);
  }
  if ($('#video-full-movie-uploader').length > 0) {
    var fullMovieSettings = {
      url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=video&parent-id=0',
      method: "POST",
      allowedTypes: 'mp4,m4v,ogg,ogv,webm',
      fileName: 'myFiles',
      multiple: false,
      showDelete: true,
      showPreview: false,
      showDone: true,
      statusBarWidth: '100%',
      dragdropWidth: '100%',
      onSuccess: function onSuccess(files, data, xhr) {

        if (data.success == true) {

          $scope.video.fullMovie = data.file.id;
          alertify.success(data.message);
          $("#video-full-movie-status").html('');
        } else {
          // alertify.error(data.message);
          $("#video-full-movie-status").html("<font color='red'>" + data.message + "</font>");
        }
      },
      onError: function onError(files, status, errMsg) {
        
 switch($('#idioma').val()) {
          case 'es':
            $("#video-full-movie-status").html("<font color='red'>No se pudo cargar</font>");
            break;
          case 'en':
             $("#video-full-movie-status").html("<font color='red'>Upload is Failed</font>");
            break;

            case 'fr':
            $("#video-full-movie-status").html("<font color='red'>Le téléchargement a échoué</font>");
            break;
          default:
           $("#video-full-movie-status").html("<font color='red'>No se pudo cargar</font>");
        }

      },
      deleteCallback: function deleteCallback(element, data, pd) {
        mediaService.deleteVideo(element.file.id).then(function (data) {
          if (data.data.success) {
            $scope.video.fullMovie = null;
            alertify.success(data.data.message);
          }
        });
      }
    };
    $("#video-full-movie-uploader").uploadFile(fullMovieSettings);
  }

  $scope.formSubmitted = false;
  $scope.errors = {};

  $scope.submitUploadVideo = function (form) {

    if (form.$valid) {
      $scope.formSubmitted = true;

      videoService.create($scope.video).then(function (data) {
        $scope.errors = {};
        if (data.data.success) {
          alertify.success(data.data.message);
          window.location.href = data.data.url;
          $scope.errors = {};
        } else {
          $scope.errors = data.data.errors;
          $scope.formSubmitted = false;
          if (data.data.message) alertify.alert(data.data.message).setHeader('Warning');
        }
      });
    }
  };
  $scope.submitUpdateVideo = function (form) {

    if (form.$valid) {

      videoService.update($scope.video).then(function (data) {
        $scope.errors = {};
        if (data.data.success) {
          alertify.success(data.data.message);
          window.location.href = data.data.url;
        } else {
          $scope.errors = data.data.errors;
          $scope.formSubmitted = false;
          if (data.data.message) alertify.alert(data.data.message).setHeader('Warning');
        }
      });
    }
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelSettingCtrl', function ($scope, authService, userService, countryService) {

  $scope.settings = [{
    password: {
      oldPassword: '',
      newPassword: '',
      newpPasswordRetype: ''
    }
  }];
  $scope.submitOtherSetting = function (form) {
    if (form.$valid) {

      userService.updateOtherSetting($scope.settings).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
        } else {
          alertify.error(data.data.message);
        }
      });
    }
  };

  $scope.submitChangePassword = function (form) {

    if (form.$valid) {
      authService.changePassword($scope.settings.password.oldPassword, $scope.settings.password.newPassword, function (data) {
        if (data.success) {
          alertify.success(data.message);
          window.location.href = '/login';
        } else {
          alertify.notify(data.message, 'error', 15);
        }
      });
    }
  };
  $scope.countries = [];
  $scope.countryInit = function (countryId) {
    countryService.getCountries().then(function (data) {
      $scope.countries = data.data;
    });
    $scope.contact.countryId = countryId;
  };

  $scope.formSubmitted = false;
  $scope.errors = [];
  $scope.submitUpdateContact = function (form) {
    if (form.$valid) {
      $scope.formSubmitted = true;
      userService.updateContact($scope.contact).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          window.location.href = data.data.url;
        } else {
          $scope.formSubmitted = false;
          alertify.error(data.data.message);
          $scope.errors = data.data.errors;
        }
      });
    }
  };
  $scope.payment = {};
  $scope.paymentValue = [{
    min: 20
  }, {
    min: 50
  }, {
    min: 100
  }, {
    min: 200
  }, {
    min: 250
  }, {
    min: 500
  }, {
    min: 1000
  }];
  $scope.paymentInit = function (payment) {
    var data = JSON.parse(payment);

    $scope.payment = data;
  };
  $scope.submitUpdatePayment = function (form) {
    if (form.$valid) {
      $scope.errors = {};
      userService.updatePayment($scope.payment).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          window.location.href = data.data.url;
        } else {
          console.log(data.data.errors);
          $scope.errors = data.data.errors;
        }
      });
    }
  };
  $scope.suspend = {
    reason: '',
    password: '',
    check: false
  };
  $scope.submitted = false;
  $scope.submitDisableAccount = function (form) {

    if (form.$valid) {
      $scope.submitted = true;
      userService.suspendAccount($scope.suspend).then(function (data) {
        if (data.data.success) {
          alertify.success(data.data.message);
          window.location.href = '/';
        } else {
          $scope.submitted = false;
          alertify.error(data.data.message);
        }
      });
    }
  };

  $scope.initSettings = function (settings) {

    $scope.settings = settings;
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelScheduleCtrl', function ($scope, scheduleService, $timeout) {

  $scope.schedule = {
    id: null,
    nextLiveShow: '',
    monday: '',
    tuesday: '',
    wednesday: '',
    thursday: '',
    friday: '',
    saturday: '',
    sunday: ''

  };

  $scope.scheduleInit = function (schedule) {
    if (schedule) {
      $scope.schedule = schedule;
    }
  };
  $('#nextLiveShow').datetimepicker({
    debug: false,
    format: 'YYYY/MM/DD HH:mm',
    minDate: moment(),
    showTodayButton: true,
    showClear: true
  });
  ;
  $('#nextLiveShow').on('dp.change', function (e) {
    $timeout(function () {
      $scope.schedule.nextLiveShow = e.target.value;
    });
  });
  $("#monday, #tuesday, #wednesday, #thursday, #friday, #saturday, #sunday").on('dp.change', function (e) {
    $timeout(function () {
      switch (e.target.id) {
        case 'monday':
          $scope.schedule.monday = e.target.value;
          break;
        case 'tuesday':
          $scope.schedule.tuesday = e.target.value;
          break;
        case 'wednesday':
          $scope.schedule.wednesday = e.target.value;
          break;
        case 'thursday':
          $scope.schedule.thursday = e.target.value;
          break;
        case 'friday':
          $scope.schedule.friday = e.target.value;
          break;
        case 'saturday':
          $scope.schedule.saturday = e.target.value;
          break;
        case 'sunday':
          $scope.schedule.sunday = e.target.value;
          break;
      }
      if (e.target.value) {
        $('#' + e.target.id).parent().find('.schedule__notavailable-btn').prop('checked', false);
      }
      console.log(e.target.value);
    });
  }).datetimepicker({
    format: 'HH:mm'
  });
  $('.schedule__notavailable-btn').click(function () {
    $(this).parent().find('.input-md').val('');
  });
  $scope.submitUpdateSchedule = function (form) {
    if (form.$valid) {
      scheduleService.setSchedule($scope.schedule).then(function (data) {

        if (data.data.id) {
          alertify.success('Update successfully.');
          window.location.href = '/models/dashboard/schedule';
        } else {
          alertify.error('Update error');
          window.location.reload();
        }
      });
    }
  };
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('modelEarningCtrl', function ($scope, $timeout, earningService, appSettings) {
  $scope.timePeriod = {
    group: 'day',
    start: null,
    end: null
  };
  $scope.earnings = {};
  $scope.submitSearch = false;

  $('#timePeriodStart').datetimepicker({
    format: 'YYYY-MM-DD'
  });
  $('#timePeriodEnd').datetimepicker({
    format: 'YYYY-MM-DD',
    useCurrent: false //Important! See issue #1075
  });
  $("#timePeriodStart").on("dp.change", function (e) {
    $timeout(function () {
      $scope.timePeriod.start = e.target.value;
      //      $scope.timePeriod.start = $filter('date')(e.date, 'MM/dd/yyyy');
      $('#timePeriodEnd').data("DateTimePicker").minDate(e.date);
    });
  });
  $("#timePeriodEnd").on("dp.change", function (e) {
    $scope.timePeriod.end = e.target.value;
    $('#timePeriodStart').data("DateTimePicker").maxDate(e.date);
  });

  $scope.earningInit = function () {
    $scope.currentPage = 1;
    $scope.lastPage = 1;
    $scope.perPage = appSettings.LIMIT_PER_PAGE;
    $scope.orderBy = 'createdAt';
    $scope.sort = 'desc';
    $scope.pagination = 0;
    $scope.timePeriod.page = 0;
    $scope.loadMoreInfinite = false;

    earningService.findMe({ page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, start: $scope.timePeriod.start, end: $scope.timePeriod.end, group: $scope.timePeriod.group }).success(function (data) {
      $scope.earnings = data.data;
      $scope.currentPage = data.current_page;
      if ($scope.lastPage < data.last_page) {
        $scope.lastPage += 1;
        $scope.loadMoreInfinite = true;
      }
    });
    //    earningService.pagination($scope.timePeriod).success(function (data) {
    //      $scope.pagination = data;
    //    });
  };
  $scope.earningInit();

  $scope.submitFilterPeriod = function (form) {
    $scope.currentPage = 1;
    $scope.lastPage = 1;
    $scope.perPage = appSettings.LIMIT_PER_PAGE;
    $scope.orderBy = 'createdAt';
    $scope.sort = 'desc';
    $scope.pagination = 0;
    $scope.timePeriod.page = 0;
    $scope.loadMoreInfinite = false;

    if (form.$valid) {

      $scope.submitSearch = true;
      earningService.findMe({ page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, start: $scope.timePeriod.start, end: $scope.timePeriod.end, group: $scope.timePeriod.group }).success(function (data) {

        $scope.earnings = data.data;
        $scope.currentPage = data.current_page;
        if ($scope.lastPage < data.last_page) {
          $scope.lastPage += 1;
          $scope.loadMoreInfinite = true;
        }
      });
    }
  };
  $(window).scroll(function () {
    if ($(window).scrollTop() == $(document).height() - $(window).height() && $scope.loadMoreInfinite) {
      $scope.loadMoreReport();
    }
  });
  $scope.loadMoreReport = function () {
    //    earningService.findMe($scope.timePeriod, $scope.page).then(function (data) {
    //      if (data.data.length > 0) {
    //        $scope.earnings = $scope.earnings.concat(data.data);
    //        $scope.timePeriod.page = parseInt($scope.timePeriod.page + 1);
    //      } else {
    //        $scope.pagination = 0;
    //        $scope.loadMoreInfinite = false;
    //      }
    //    });
    earningService.findMe({ page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, start: $scope.timePeriod.start, end: $scope.timePeriod.end, group: $scope.timePeriod.group }).success(function (data) {

      $scope.earnings = $scope.earnings.concat(data.data);
      $scope.currentPage = data.current_page;
      if ($scope.lastPage < data.last_page) {
        $scope.lastPage += 1;
        $scope.loadMoreInfinite = true;
      } else {
        $scope.loadMoreInfinite = false;
      }
    });
  };
  //return null if change group by
  $scope.changeGroup = function () {
    $scope.earnings = {};
    $scope.submitSearch = false;
    $scope.earningInit();
  };
  //show detail group by day


  $scope.showDayDetail = function (index, date) {
    //    $scope.earnings[index].details = [];
    //    earningService.filterByDay(date).then(function (data) {
    //
    //      $scope.earnings[index].details = data.data;
    //
    //    });
    if (typeof $scope.earnings[index].details != 'undefined' && $scope.earnings[index].details) {
      $scope.earnings[index].details = null;
      return false;
    } else {
      $scope.earnings[index].details = [];
    }
    earningService.filterByDay(date).then(function (data) {

      $scope.earnings[index].details = data.data;
    });
  };
  //Show detail by none
  $scope.showNoneDetail = function (index, earningId) {
    //    $scope.earnings[index].detail = [];
    //    earningService.filterByDefault(earningId).then(function (data) {
    //      $scope.earnings[index].detail = data.data;
    //    });
    if (typeof $scope.earnings[index].detail != 'undefined' && $scope.earnings[index].detail) {

      $scope.earnings[index].detail = null;
      return;
    } else {
      $scope.earnings[index].detail = [];
    }
    //    

    earningService.filterByDefault(earningId).then(function (data) {
      $scope.earnings[index].detail = data.data;
    });
  };
});
'use strict';
var myApp =angular.module('matroshkiApp')
myApp.controller('modelOnlineCtrl', ['$scope', 'appSettings', '_', 'onlineService', 'socket', function ($scope, appSettings, _, onlineService, socket) {
  $scope.currentPage = 1;
  $scope.lastPage = 1;
  $scope.perPage = appSettings.LIMIT_PER_PAGE;
  $scope.orderBy = 'isStreaming';
  $scope.sort = 'desc';
  $scope.totalPages = 0;
  $scope._ = _;
  $scope.modelOnlineNull = false;
  $scope.keyword = '';
  $scope.filter = 'week';
  $scope.styleModelItem = {};
      $scope.maps="";
    $scope.fecha ="";
    $scope.filtertravel ="todos";
    $scope.Desde = "";
    $scope.textLugar="";
    $scope.textDesde="";
    $scope.textHasta="";
    $scope.textDescription="";
       $scope.textPlace="";
  $scope.getData = function () {
    var widthScreen = $(window).width();
    if (widthScreen > 2000) {
      var widthItems = Math.floor(100 / Math.floor(widthScreen / 280));
      $scope.styleModelItem = {
        "width": widthItems + '%'
      };
    }
    onlineService.get({ page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, keyword: $scope.keyword, filter: $scope.filter, category: $scope.categoryId }).success(function (data) {
      $scope.users = data.data;
      $scope.currentPage = data.current_page;
      $scope.totalPages = data.last_page; //Math.ceil(data.total / data.per_page);
      if (data.total == 0) {
        $scope.modelOnlineNull = true;
      } else {
        $scope.modelOnlineNull = false;
      }
    });
  };

  $scope.customSplitStringTags = function (item) {
    if (item.tags != null) {
      var arr = item.tags.split(',');
      return arr;
    }
  };

  $scope.getTopModels = function () {
    onlineService.getTopModels().success(function (data) {
      $scope.topModels = data;
    });
  };

  $scope.setPage = function (page) {
    if (page > 0 && page <= $scope.totalPages) {
      $scope.lastPage = page;
      $scope.getData();
    }
  };

  $scope.onlineInit = function (keyword, id) {
    $scope.keyword = keyword;
    $scope.categoryId = id || '';
    $scope.getData();
    $scope.getTopModels();
    // Run function every second
    setInterval($scope.getData, 30000);
  };

  $scope.setFilter = function (filter) {
    $scope.filter = filter;
    $scope.getData();
  };

    $scope.travel = function (filter = false) {

      if(filter){
        $scope.filtertravel = filter;
      }

       onlineService.getTravel($scope.filtertravel, $scope.textPlace, $scope.fecha).success(function (data) {
         $scope.users = data;
      });
     
    };


$scope.clear = function(){
 // $scope.maps = $scope.textPlace;
  $scope.travel();
}
  
  //load models in streaming page
  $scope.getModelsByCategory = function (model, category) {

    onlineService.getModelsByCategory(model, category).success(function (data) {
      $scope.users = data;
    });
  };

  $scope.setFavorite = function (index, id) {
    onlineService.setFavorite(id).then(function (data) {
      if (data.data.success) {
        $scope.users[index].favorite = data.data.favorite === 'like' ? data.data.favorite : null;
      } else {
        alertify.error(data.data.message);
      }
    });
  };

  $scope.isRotate = false;

  $scope.modelRotates = function (thread) {

    onlineService.getModelRotateImages(thread.threadId).then(function (data) {

      if (data && angular.isArray(data.data)) {
        $scope.isRotate = true;

        var images = data.data;

        angular.forEach(images, function (item) {
          setTimeout(function () {
            thread.lastCaptureImage = item;
          }, 150);
        });
      }
    });
  };
}]);






//https://gist.github.com/victorb/6687484
myApp.directive('googleplace', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, model) {
            var options = {
                types: [],
                componentRestrictions: {}
            };
            scope.gPlace = new google.maps.places.Autocomplete(element[0], options);

            google.maps.event.addListener(scope.gPlace, 'place_changed', function() {
                scope.$apply(function() {
                    model.$setViewValue(element.val());

                    scope.maps= element.val();  
                     scope.travel();   

                });
            });
        }
    };
});


myApp.directive('googleplacetext', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, model) {
            var options = {
                types: [],
                componentRestrictions: {}
            };
            scope.gPlace = new google.maps.places.Autocomplete(element[0], options);

            google.maps.event.addListener(scope.gPlace, 'place_changed', function() {
                scope.$apply(function() {
                    model.$setViewValue(element.val());

                    scope.maps= element.val();  
                     

                });
            });
        }
    };
});








myApp.directive('jqdatepicker', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
         link: function (scope, element, attrs, ngModelCtrl) {
            element.datepicker({
                dateFormat: 'dd-mm-yy',
                onSelect: function (date) {   
                    var ar=date.split("-");
                    date=new Date(ar[2]+"-"+ar[1]+"-"+ar[0]);
                    ngModelCtrl.$setViewValue(date.getTime());
                //    scope.course.launchDate = date;
                      fecha = ar[2]+"-"+ar[1]+"-"+ar[0];
                var str = fecha;
                var fecha = str.replace("/", "-");

                scope.fecha=fecha; 
                 console.log("fecha");
                console.log(scope.fecha);
                console.log("fechaxx");   
                scope.travel(); 
                
                    scope.$apply();
                }
            });

        }
    };
});


myApp.directive('jqdatepickersimple', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
         link: function (scope, element, attrs, ngModelCtrl) {
            element.datepicker({
                dateFormat: 'dd-mm-yy',
                onSelect: function (date) {   
                    var ar=date.split("-");
                    date=new Date(ar[2]+"-"+ar[1]+"-"+ar[0]);
                    ngModelCtrl.$setViewValue(date.getTime());
                //    scope.course.launchDate = date;
                     
                
                    scope.$apply();
                }
            });

        }
    };
});



'use strict';
angular.module('matroshkiApp').controller('mediaCtrl', ['$scope', 'appSettings', 'videoService', 'galleryService', 'mediaService', function ($scope, appSettings, videoService, galleryService, mediaService) {
  $scope.currentTab = 0;
  $scope.currentPage = 1;
  $scope.lastPage = 1;

  $scope.setTab = function (index) {
    $scope.currentTab = index;
    $scope.currentPage = 1;
    $scope.lastPage = 1;
    $scope.getMedia(index, 1);
  };

  //init data
  $scope.init = function (model) {
    $scope.modelId = model;
  };
  $scope.getMedia = function (index, page) {
    if (index == 1) {
      videoService.getModelVideos($scope.modelId, page).success(function (data) {
        $scope.videos = data.data;
        $scope.currentPage = data.current_page;
        $scope.lastPage = data.last_page;
      });
    } else if (index == 2) {
      galleryService.getModelGalleries($scope.modelId, page).success(function (data) {

        $scope.galleries = data.data;
        $scope.currentPage = data.current_page;
        $scope.lastPage = data.last_page;
      });
    }
  };
  $scope.changePage = function (status) {
    if (status == 0) {
      var page = $scope.currentPage > 1 ? parseInt($scope.currentPage - 1) : 1;
      $scope.getMedia($scope.currentTab, page);
    } else {
      console.log($scope.currentPage, $scope.lastPage);
      var page = $scope.currentPage < $scope.lastPage ? parseInt($scope.currentPage + 1) : $scope.lastPage;
      $scope.getMedia($scope.currentTab, page);
    }
  };
  //check owner
  $scope.checkOwner = function (item, url) {

    mediaService.checkOwner({ id: item.id }).then(function (data) {
      if (!data.data.success) {
        return alertify.alert(data.data.message);
      } else {
        if (data.data.owner > 0) {

          window.location.href = url + '/' + item.id;
        } else {
          alertify.confirm("Are you sure you want to buy this ( " + item.galleryPrice + " tokens)?", function (e) {
            if (e) {
              $.ajax({
                url: appSettings.BASE_URL + 'api/v1/buy-item',
                type: 'post',
                data: {
                  id: item.id,
                  item: item.type
                },
                success: function success(data) {
                  if (!data.success) {
                    alertify.alert('Warning', data.message);
                  } else {
                    alertify.success(data.message);
                    window.location.href = data.url;
                  }
                }
              });
            }
          }).setHeader('<em> Confirm </em> ');
        }
      }
    });
  };
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';
angular.module('matroshkiApp').controller('paymentCtrl', ['$scope', '$uibModal', 'appSettings', function ($scope, $uibModal, appSettings) {

  //Reject transaction
  $scope.rejectTransaction = function (id) {
    alertify.confirm('Are you sure you want to reject this transaction? Please refund member money first.', function () {
      return window.location.href = appSettings.BASE_URL + 'admin/manager/transaction/reject/' + id;
    }).set('title', 'Confirm');
  };
  //Approve transaction
  $scope.approveTransaction = function (id) {
    alertify.confirm('Are you sure you want to approve this transaction?', function () {
      return window.location.href = appSettings.BASE_URL + 'admin/manager/transaction/approve/' + id;
    }).set('title', 'Confirm');
  };
  //transaction detail

  $scope.showTransactionDetail = function (_transaction, size) {
    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: appSettings.BASE_URL + 'app/modals/transaction/modal.html',
      controller: 'transactionPopupCtrl',
      size: size,
      backdrop: 'static',
      keyboard: false,
      resolve: {
        transaction: function transaction() {
          return _transaction;
        }
      }

    });
    modalInstance.result.then(function (data) {
      //        window.location.reload();

    });
    //  
  };
}]);
'use strict';

angular.module('matroshkiApp').controller('modelPayoutRequestCtrl', ['$scope', 'payoutService', function ($scope, payoutService) {
  $scope.startDate = {
    open: false,
    value: ''
  };
  $scope.toDate = {
    open: false,
    value: ''
  };
  $scope.typeRequest = '';
  $scope.init = function (typeRequest, dateFrom, dateTo) {
    $scope.typeRequest = typeRequest;
    if (dateFrom) {
      $scope.startDate.value = new Date(dateFrom);
    }
    if (dateTo) {
      $scope.toDate.value = new Date(dateTo);
    }
  };
  $scope.$watch('startDate.value', function (data) {
    showRequestPayout($scope.startDate.value, $scope.toDate.value);
  });
  $scope.$watch('toDate.value', function (data) {
    showRequestPayout($scope.startDate.value, $scope.toDate.value);
  });
  $scope.earningByRequestedDate = null;
  $scope.previousPayout = null;
  $scope.pendingBalance = null;
  function showRequestPayout(startDate, endDate) {
    if (startDate && endDate) {
      var convertedStartDate = new Date(startDate);
      var convertedEndDate = new Date(endDate);
      var options = {
        startDate: convertedStartDate.getFullYear() + "-" + (convertedStartDate.getMonth() + 1) + "-" + convertedStartDate.getDate(),
        endDate: convertedEndDate.getFullYear() + "-" + (convertedEndDate.getMonth() + 1) + "-" + convertedEndDate.getDate()
      };
      payoutService.getEarningByRequestedDate(options).then(function (data) {
        $scope.earningByRequestedDate = data.data.amount;
        return payoutService.getLastestRequestPayout($scope.typeRequest);
      }).then(function (data) {
        $scope.previousPayout = data.data.amount;
        return payoutService.getTotalPendingBalance();
      }).then(function (data) {
        $scope.pendingBalance = (data.data.amount - $scope.earningByRequestedDate).toFixed(1);
      });
    }
  }
}]).controller('ModelRequestPayoutViewCrl', ['$scope', 'payoutService', function ($scope, payoutService) {
  $scope.comments = [];

  $scope.init = function (data) {
    $scope.request = data;
    $scope.status = data.status;
    $scope.note = data.note;
    $scope.studioId = data.studioId;
    payoutService.getComments(data.id, !!$scope.studioId).then(function (resp) {
      $scope.comments = resp.data;
    });
  };

  $scope.comment = function () {
    payoutService.addComment($scope.request.id, {
      text: $scope.newComment,
      studioId: $scope.studioId
    }, !!$scope.studioId).then(function (resp) {
      $scope.comments.push(resp.data);
      $scope.newComment = '';
    });
  };

  //for admin only
  $scope.updateStatus = function () {
    payoutService.updateStatus($scope.request.id, {
      status: $scope.status,
      note: $scope.note
    }, !!$scope.studioId).then(function (resp) {
      alertify.success('Request has been updated!');
    });
  };
}]);
'use strict';
angular.module('matroshkiApp').controller('modelAddProductCtrl', function ($scope, $, mediaService, appSettings) {
  if ($('#video-poster-uploader').length > 0) {
    var posterSettings = {
      url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=poster&parent-id=0',
      method: "POST",
      allowedTypes: 'png,jpg,jpeg',
      fileName: 'myFiles',
      multiple: false,
      showDelete: true,
      showPreview: false,
      showDone: true,
      statusBarWidth: '100%',
      dragdropWidth: '100%',
      onSuccess: function onSuccess(files, data) {
        if (data.success) {
          var productImage = $('.product-image .img-responsive');
          if (productImage.prop('tagName') !== 'undefined') {
            productImage.prop('src', '/' + data.file.path);
          }
          $('#image-id').val(data.file.id);
          alertify.success(data.message);
          $scope.uploadStatus = '';
        } else {
          $scope.uploadStatus = "<font color='red'>" + data.message + "</font>";
        }
      },
      onError: function onError(files, status, errMsg) {
        $("#poster-status").html("<font color='red'>Upload is Failed</font>");
        $scope.uploadStatus = "<font color='red'>Upload failed</font>";
      },
      deleteCallback: function deleteCallback(element, data, pd) {
        mediaService.deleteImage(element.file.id).then(function (data) {
          if (data.data.success) {
            $('#image-id').val('');
            alertify.success(data.data.message);
          }
        });
      }
    };
    $("#video-poster-uploader").uploadFile(posterSettings);
  }

  $scope.submit = function (form) {
    //TODO - validate me
    $('#add-product-frm').submit();
  };
});
'use strict';

angular.module('matroshkiApp').controller('buyProductCtrl', ['$scope', 'productService', function ($scope, productService) {
  $scope.quantity = 1;

  $scope.buy = function (product) {
    if (!$scope.quantity || $scope.quantity < 0) {


      return alertify.error('Invalid quantity');
    }

    if ($scope.quantity > product.inStock) {
      return alertify.error('Invalid quantity');
    }

    if (!window.appSettings.USER) {
      return alertify.error('Please login.');
    }

    productService.buy(product.id, { quantity: $scope.quantity }).then(function (data) {
      if (!data.success) {
        return alertify.error(data.data.message);
      }

      alertify.success('Buy product successfully.');
    });
  };
}]);
'use strict';

angular.module('matroshkiApp').controller('orderTrackingCtrl', ['$scope', 'orderService', function ($scope, orderService) {
  $scope.comments = [];

  $scope.init = function (data) {
    $scope.order = data;
    $scope.shippingStatus = data.shippingStatus;
    $scope.updatedShippingStatus = data.shippingStatus;
    $scope.note = data.note;
    $scope.status = data.status || 'open';

    orderService.getComments(data.id).then(function (resp) {
      $scope.comments = resp.data;
    });
  };

  $scope.updateStatus = function () {
    orderService.update($scope.order.id, {
      shippingStatus: $scope.shippingStatus,
      note: $scope.note,
      status: $scope.status
    }).then(function (data) {
      $scope.updatedShippingStatus = $scope.shippingStatus;
      return alertify.success('Update order successfully.');
    });
  };

  $scope.comment = function () {
    orderService.addComment($scope.order.id, {
      text: $scope.newComment
    }).then(function (resp) {
      $scope.comments.push(resp.data);
      $scope.newComment = '';
    });
  };
}]);
//# sourceMappingURL=controller.js.map
