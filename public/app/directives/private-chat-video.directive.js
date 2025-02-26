'use strict';

angular.module('matroshkiApp')
.directive('mPrivateChatVideo', ['appSettings', '$timeout', '$interval', 'socket', 'VideoStream', 'peerService', '$sce', 'userService', 'onlineService', function(appSettings, $timeout, $interval, socket, VideoStream, peerService, $sce, userService, onlineService) {
  return {
    restrict: 'AE',
    templateUrl: appSettings.BASE_URL + 'app/views/partials/private-chat-video-widget.html',
    scope: {
      modelId: '=modelId',
      memberId: '=memberId',
      room: '@',
      virtualRoom: '@',
      streamingInfo : "=ngModel"
    },
    controller: function($scope, socket, userService, PerformerChat, $timeout, $window, $rootScope) {

   console.log($scope.modelId);
    console.log($scope.memberId);
    console.log("darww");
      $scope.userRole = appSettings.USER.role;
      $scope.streamingInfo.type = 'private';
      $scope.streamingInfo.hasRoom = true;
      $scope.streamingInfo.removeMyRoom = false;
      $scope.second = 60;
      $scope.userLogin = appSettings.USER.id;
  
 switch($('#idioma').val()) {
          case 'es':
            $scope.Sendvideocallrequest = "Enviar solicitud de videollamada";
            $scope.Acceptvideocallrequest = "Aceptar solicitud de videollamada";
            $scope.Stopstreaming = "Detener la transmisión";

            break;
          case 'en':
            // code block
             $scope.Sendvideocallrequest = "Send video call request";
              $scope.Acceptvideocallrequest = "Accept video call request";
               $scope.Stopstreaming = "Stop streaming";

             
            break;

            case 'fr':
            // code block
              $scope.Sendvideocallrequest = "Envoyer une demande d'appel vidéo";
              $scope.Acceptvideocallrequest = "Accepter la demande d'appel vidéo";
               $scope.Stopstreaming = "Arrêter la diffusion";

            break;
          default:
            $scope.Sendvideocallrequest = "Enviar solicitud de videollamada";
           $scope.Acceptvideocallrequest = "Aceptar solicitud de videollamada";
            $scope.Stopstreaming = "Detener la transmisión";
        }
      
      $scope.sendCallRequest = function() {


        socket.emit('checkOnline', $scope.modelId.toString(), function(data) {
          if(!data.isOnline) {
            return alertify.error('Usuario esta  offline');
          }

        
          //check user token before start connect.
          userService.get().then(function (data) {
            if (data.data) {
              if(parseInt(data.data.tokens) < 1){
                var vlang = "";
 
        switch($('#idioma').val()) {
          case 'es':
            vlang = "El crédito está terminado y el chat terminará";
            vlang2 = "Alguien ya creó esta sala. Únase o cree una sala separada.";
           
            break;
          case 'en':
            vlang = "Credit is finished and chat will end";
            vlang2 = "Someone already created this room. Please either join or create a separate room.";
           
            break;

          case 'fr':
            vlang = "Le crédit est terminé et le chat prendra fin";
            vlang2 = "Quelqu'un a déjà créé cette salle. Veuillez rejoindre ou créer une salle séparée.";
           
            break;

          default:
             vlang = "El crédito está terminado y el chat terminará";
             vlang2 = "Alguien ya creó esta sala. Únase o cree una sala separada.";
            
        }
                return alertify.error(vlang, 6, function () {
                  return endStream();
                })
              } else {
 //return endStream();
               
                // open room for streaming
                connection.open($scope.virtualRoom, function(isRoomOpened, roomid, error) {

                  
                  if (isRoomOpened === true) {
                    alertify.message('Solicitud enviada', 15);
                    $scope.userStreaming = true;
                    peerService.joinRoom($scope.virtualRoom, {

                      memberId: $scope.memberId,
                      modelId: $scope.modelId,
                      room: $scope.room
                    });
                  } else {
                    if (error === connection.errors.ROOM_NOT_AVAILABLE) {
                        alert('Alguien ya creó esta sala. Únase o cree una sala separada.');
                        return;
                    }
                    alert(error);
                  }
                });
              }
            } else {
              console.log("nodebe pasar pora qui");
              return false;
            }
          });
        });

      };
      $scope.acceptRequest = function() {
          connection.join($scope.virtualRoom, function(isJoinedRoom, roomid, error) {
              if (error) {
                  if (error === connection.errors.ROOM_NOT_AVAILABLE) {
                          
              switch($('#idioma').val()) {
          case 'es':
           alert('This room does not exist. Please either create it or wait for moderator to enter in the room.');

            break;
          case 'en':
           alert('This room does not exist. Please either create it or wait for moderator to enter in the room.');
             
            break;

            case 'fr':
            alert('This room does not exist. Please either create it or wait for moderator to enter in the room.');

            break;
          default:
            alert('This room does not exist. Please either create it or wait for moderator to enter in the room.');
        }

              return;
                  }
                  if (error === connection.errors.ROOM_FULL) {
                      switch($('#idioma').val()) {
          case 'es':
            alert('Cuarto lleno.');

            break;
          case 'en':
            alert('Room is full.');
             
            break;

            case 'fr':
             alert('La salle est pleine.');

            break;
          default:
             alert('Cuarto lleno.');
        }

             
              return;
                  }
                  alert(error);
                  return;
              }
              peerService.joinRoom($scope.virtualRoom, {
                memberId: $scope.memberId,
                modelId: $scope.modelId,
                room: $scope.room
              });
              $scope.$parent.modelStreaming = true;
              $scope.$parent.streamingInfo.status = 'active';
             
              $rootScope.$broadcast('MostrarLovense', true);
             
          });
      };
      var connection = new RTCMultiConnection();
      // maximum two users are allowed to join single room
      connection.maxParticipantsAllowed = 2;
      connection.socketURL = appSettings.RTC_URL;
      connection.socketMessageEvent = 'one-to-one-' + $scope.room;
      connection.session = {
          audio: true,
          video: true
      };
      connection.sdpConstraints.mandatory = {
          OfferToReceiveAudio: true,
          OfferToReceiveVideo: true
      };
      connection.videosContainer = document.getElementById('private-videos-container');
      var intervalPayment = null;
      connection.onstream = function(event) {
        var existing = document.getElementById(event.streamid);
        if (existing && existing.parentNode) {
            existing.parentNode.removeChild(existing);
        }
        event.mediaElement.removeAttribute('src');
        event.mediaElement.removeAttribute('srcObject');
        event.mediaElement.muted = true;
        event.mediaElement.volume = 0;
        var video = document.createElement('video');
        try {
            video.setAttributeNode(document.createAttribute('autoplay'));
            video.setAttributeNode(document.createAttribute('playsinline'));
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
        video.className = event.type;
        connection.videosContainer.appendChild(video);
        setTimeout(function() {
            video.play();
        }, 5000);
        video.id = event.streamid;
        // to keep room-id in cache
        localStorage.setItem(connection.socketMessageEvent, connection.sessionid);
        if (event.type === 'local') {
            connection.socket.on('disconnect',{
        modeloid: $scope.modelId

      }, function() {
                if (!connection.getAllParticipants().length) {
                    location.reload();
                }
            });
        }

        //darwinnnnn
        if(connection.getAllParticipants().length > 0 && $scope.modelId != appSettings.USER.id && !intervalPayment) {
          intervalPayment = $interval(function () {
            if($scope.second === 60){
                $scope.second = 0;
                $scope.streamingInfo.time++;
                sendPaidTokens();
            }
            $scope.second++;
          }, 1000);
        }
      };

      connection.onstreamended = function(event) {
          var mediaElement = document.getElementById(event.streamid);
          if (mediaElement) {
              mediaElement.parentNode.removeChild(mediaElement);
          }
           var vlang = "";
 
        switch($('#idioma').val()) {
          case 'es':
            vlang = "El chat terminará ahora";
           
            break;
          case 'en':
            vlang = "Chat will end now";
           
            break;

          case 'fr':
            vlang = "Le chat va se terminer maintenant";
           
            break;

          default:
             vlang = "El chat terminará ahora";
            
        }


        alertify.message(vlang, 30);
          $timeout(endStream, 6000);
      };
      connection.onMediaError = function(e) {
          if (e.message === 'Concurrent mic process limit.') {
              if (DetectRTC.audioInputDevices.length <= 1) {
                  alert('Please select external microphone. Check github issue number 483.');
                  return;
              }
              var secondaryMic = DetectRTC.audioInputDevices[1].deviceId;
              connection.mediaConstraints.audio = {
                  deviceId: secondaryMic
              };
              document.getElementById('join-room').onclick();
          }
      };
      $scope.stopStreaming = function() {



        if (appSettings.USER && appSettings.USER.id != $scope.modelId) {
          socket.emit('stop-video-request',
          {
            data: {
              modelId: $scope.modelId,
            }
          });
        }
        socket.emit('model-leave-room');
        endStream();
      };
      function endStream() {
        if(appSettings.USER.id == $scope.modelId){
          $window.location.href = '/models/live';
        } else {
          $window.location.href = '/';
        }
      }

      function sendPaidTokens() {

        $scope.$parent.streamingInfo.status = 'active';
        userService.sendPaidTokens($scope.modelId, 'private').then(function (response)
        {
          if(response.data && parseInt(response.data.spend) > 0){
              $scope.$parent.streamingInfo.spendTokens += parseInt(response.data.spend);
              $scope.$parent.streamingInfo.tokens = response.data.tokens;
              socket.sendModelReceiveInfo({time: 1, tokens: response.data.spend});
          }
          if (response.data.success == false) {
             socket.emit('member-missing-tokens', $scope.chatType);
               var vlang = "";
 
        switch($('#idioma').val()) {
          case 'es':
            vlang = "El crédito está terminado y el chat terminará";
           
            break;
          case 'en':
            vlang = "Credit is finished and chat will end";
           
            break;

          case 'fr':
            vlang = "Le crédit est terminé et le chat prendra fin";
           
            break;

          default:
             vlang = "El crédito está terminado y el chat terminará";
            
        }


            return alertify.error(vlang, 6, endStream);
          }
        });
      }

      // show full screen
      $scope.isFullScreenMode = false;
      $scope.showFullScreen = function() {
          $scope.isFullScreenMode = true;
          $('.header').addClass('hidden');
          $('.line-menu').addClass('hidden');
          $('.footer').addClass('hidden');
          $('body').addClass('fullscreen-mode');
          $('.panel-heading').addClass('hidden');
          $('.private-chat-instruction').addClass('hidden');
          $scope.isFullScreenMode = true;
      };
      $scope.notShowFullScreen = function() {
          $scope.isFullScreenMode = false;
          $('.header').removeClass('hidden');
          $('.line-menu').removeClass('hidden');
          $('.footer').removeClass('hidden');
          $('body').removeClass('fullscreen-mode');
          $('.panel-heading').removeClass('hidden');
          $('.private-chat-instruction').removeClass('hidden');
      };
    }
  };
}]);