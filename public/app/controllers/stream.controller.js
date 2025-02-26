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

                connection.enableLogs = true;
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
                connection.enableLogs = true;
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

                        console.log("que data trajo");
                        console.log(data.data.user);

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

                //		if (connection.broadcastingConnection) {
                //			// if new person is given the initiation/host/moderation control
                //			connection.close();
                //			connection.broadcastingConnection = null;
                //		}
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
                //		socket.emit('join-broadcast', {
                //			broadcastid: data.id,
                //			room: data.room,
                //			userid: connection.userid,
                //			typeOfStreams: connection.typeOfStreams
                //		});
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



$scope.girarModeloruleta = function(data,nivel,picked) {

      $scope.drawRuleta(nivel);


/*console.log(data.datos);

console.log("girar modelo ruleta");


var xxxx =  data;

console.log(xxxx.datosniveluno)
console.log("NIVEL UNO");*/

$scope.hiddenRuleta =false;

console.log("----girar modelo ruleta-------");


console.log(data);

console.log("+++++girar modelo ruleta++++++");

  Website.spin(data,nivel,picked)

  return true;



}



        }
    ]);