angular.module('matroshkiApp').directive('mGroupChatVideo', ['appSettings', '$timeout', '$interval', 'socket', 'VideoStream', 'peerService', '$sce', 'onlineService', 'userService', function (appSettings, $timeout, $interval, socket, VideoStream, peerService, $sce, onlineService, userService) {
  return {
    restrict: 'AE',
    templateUrl: appSettings.BASE_URL + 'app/views/partials/group-chat-video-widget.html',
    scope: {
      modelId: '=modelId',
      memberId: '=memberId',
      room: '@',
      onModelRoom: '@',
      virtualRoom: '@',
      streamingInfo: "=ngModel"
    },
    controller: function controller($scope, userService, PerformerChat, $window) {
      $scope.userRole = appSettings.USER.role;
      const streams = [];
      $scope.isShowLargeVideo = false;
      $scope.second = 60;
      $scope.streamingInfo.type = 'group';

 switch($('#idioma').val()) {
          case 'es':
            $scope.JoinConversation = "Unete a la conversación";
            $scope.StartConversation = "Iniciar conversación";
            $scope.Leaveroom = "Dejar la sala";

            break;
          case 'en':
            // code block
              $scope.JoinConversation = "Join Conversation";
              $scope.StartConversation = "Start Conversation";
              $scope.Leaveroom = "Leave room";

             
            break;

            case 'fr':
            // code block
              $scope.JoinConversation = "Rejoindre la conversation";
              $scope.StartConversation = "Démarrer la conversation";
              $scope.Leaveroom = "Quitter la pièce";

            break;
          default:
            $scope.JoinConversation = "Unete a la conversación";
            $scope.StartConversation = "Iniciar conversación";
            $scope.Leaveroom = "Dejar la sala";
        }
      
      $scope.startConversation = function() {
          connection.open($scope.virtualRoom, function(isRoomOpened, roomid, error) {
              if(isRoomOpened === true) {
                $scope.modelStreaming = true;
                peerService.joinGroupRoom($scope.virtualRoom, {
                  memberId: $scope.memberId,
                  modelId: $scope.modelId,
                  type: 'group',
                  room: $scope.room
                });
              }
              else {
                if(error === 'Room not available') {
                  alert('Someone already created this room. Please either join or create a separate room.');
                  return;
                }
                alert(error);
              }
          });
      };
      $scope.joinConversation = function() {
        userService.get().then(function (data) {
          if (data.data) {
            if (parseInt(data.data.tokens) < 1) {
              return alertify.error('Your tokens do not enought, please buy more.');
            } else {
              connection.join($scope.virtualRoom, function(isJoinedRoom, roomid, error) {
                if (error) {
                    if(error === 'Room not available') {
                      alert('This room does not exist. Please either create it or wait for moderator to enter in the room.');
                      return;
                    }
                    alert(error);
                }
                $scope.userStreaming = true;
                $scope.$$phase || $scope.$apply();
              });
            }
          } else {
            return false;
          }
        });

      };
      // ......................................................
      // ..................RTCMultiConnection Code.............
      // ......................................................
      var connection = new RTCMultiConnection();
      // by default, socket.io server is assumed to be deployed on your own URL
      // comment-out below line if you do not have your own socket.io server
      connection.socketURL = appSettings.RTC_URL;
      connection.socketMessageEvent = 'video-conference-' + $scope.room;
      connection.session = {
          audio: true,
          video: true
      };
      connection.sdpConstraints.mandatory = {
          OfferToReceiveAudio: true,
          OfferToReceiveVideo: true
      };
      connection.videosContainer = document.getElementById('groupchat-videos-container');
      connection.onstream = function(event) {
          var existing = document.getElementById(event.streamid);
          if(existing && existing.parentNode) {
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
          if(event.type === 'local') {
            video.volume = 0;
            try {
                video.setAttributeNode(document.createAttribute('muted'));
            } catch (e) {
                video.setAttribute('muted', true);
            }
          }
          streams.push({
            id: event.streamid,
            stream: event.stream
          });
          video.srcObject = event.stream;
          video.controls = true;
          video.className = 'video-in-group';
          connection.videosContainer.appendChild(video);
          setTimeout(function() {
            video.play();
          }, 5000);
          video.id = event.streamid;
          // to keep room-id in cache
          localStorage.setItem(connection.socketMessageEvent, connection.sessionid);
          if(event.type === 'local') {
            connection.socket.on('disconnect' ,{
        modeloid: 2,
      },function(data) {
            
              if(!connection.getAllParticipants().length) {
                location.reload();
              }
            });
          }
          if(connection.getAllParticipants().length > 0 && $scope.userRole === 'member') {
            $interval(function () {
              if($scope.second === 60){
                  $scope.second = 0;
                  $scope.streamingInfo.time++;
                  sendPaidTokens();
              }
              $scope.second++;
            }, 1000);
          }
      };

      //change large video
      $(document).on('click', '.video-in-group', function() {
        $('.video-in-group').removeClass('active');
        $(this).addClass('active');
        const streamId = $(this).attr('id');
        const stream = streams.find(str => streamId === str.id);
        const videoCurr = document.getElementById('currentvideo-groupchat');
        if(stream) {
          videoCurr.srcObject = stream.stream;
          setTimeout(function() {
            videoCurr.play();
            $scope.isShowLargeVideo = true;
            $scope.$$phase || $scope.$apply();
          });
        }
      });

      connection.onstreamended = function(event) {
          var mediaElement = document.getElementById(event.streamid);
          if (mediaElement) {
              mediaElement.parentNode.removeChild(mediaElement);
          }
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
              connection.join(connection.sessionid);
          }
      };

      $scope.stopStreaming = function() {
        socket.emit('model-leave-room');
        endStream();
      };
      function endStream() {
        if(appSettings.USER.role == 'model'){
          $window.location.href = '/models/live';
        } else {
          $window.location.href = '/';
        }
      }
      /**
       * process payment per minute
       */
      function sendPaidTokens() {
        userService.sendPaidTokens($scope.modelId, 'group').then(function (response) {
          if (response.data && parseInt(response.data.spend) > 0) {
            $scope.streamingInfo.spendTokens += parseInt(response.data.spend);
            $scope.streamingInfo.tokens = response.data.tokens;
            socket.sendModelReceiveInfo({ member: $scope.memberId, time: 1, tokens: response.data.spend });
          }
          if (response.data.success == false) {
            alertify.error('Your tokens do not enough, please buy more.', 5, endStream);
            socket.emit('member-missing-tokens', $scope.chatType);
            return;
          }
        });
      }
    }
  };
}]);