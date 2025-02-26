/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';

angular.module('matroshkiApp').directive('pwCheck', [function () {
  return {
    require: 'ngModel',
    link: function link(scope, elem, attrs, ctrl) {
      var firstPassword = '#' + attrs.pwCheck;
      elem.add(firstPassword).on('keyup', function () {
        scope.$apply(function () {
          // console.info(elem.val() === $(firstPassword).val());
          ctrl.$setValidity('pwmatch', elem.val() === $(firstPassword).val());
        });
      });
    }
  };
}]).directive('integer', function () {
  return {
    require: 'ngModel',
    link: function link(scope, elm, attrs, ctrl) {
      ctrl.$validators.integer = function (modelValue, viewValue) {
        if (ctrl.$isEmpty(modelValue)) {
          // consider empty models to be valid
          return true;
        }
        var INTEGER_REGEXP = /^\-?\d+$/;
        if (INTEGER_REGEXP.test(viewValue)) {
          // it is valid
          return true;
        }

        // it is invalid
        return false;
      };
    }
  };
}).directive('welcomeMessage', function () {
  return {
    restrict: 'AE',
    scope: {
      message: '@message'
    },
    controller: function controller($scope) {
      if ($scope.message != '') {
        alertify.success($scope.message, 20);
      }
    }
  };
}).directive('validateWebAddress', function () {
  var URL_REGEXP = /^((?:http|ftp)s?:\/\/)(?:(?:[A-Z0-9](?:[A-Z0-9-]{0,61}[A-Z0-9])?\.)+(?:[A-Z]{2,6}\.?|[A-Z0-9-]{2,}\.?)|localhost|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(?::\d+)?(?:\/?|[\/?]\S+)$/i;
  return {
    require: 'ngModel',
    restrict: 'A',
    link: function link(scope, element, attrs, ctrl) {
      element.on("keyup", function () {
        var isValidUrl = URL_REGEXP.test(element.val());
        if (isValidUrl && element.hasClass('alert-danger') || element.val() == '') {
          element.removeClass('alert-danger');
        } else if (isValidUrl == false && !element.hasClass('alert-danger')) {
          element.addClass('alert-danger');
        }
      });
    }
  };
}).directive('welcomePopup', ['socket', 'userService', '$window', function (socket, userService, $window) {
  return {
    restrict: 'EA',
    scope: {
      inRoom: '=inRoom'
    },
    controller: function controller($scope, $timeout, $uibModal, appSettings) {

      if (!appSettings.USER && !sessionStorage.closePopup) {
        $timeout(function () {
          var autoInstance = $uibModal.open({
            animation: true,
            templateUrl: appSettings.BASE_URL + 'app/modals/register-modal/modal.html?v=' + Math.random().toString(36).slice(2),
            controller: 'RegisterInstanceCtrl',
            backdrop: 'static',
            size: 'lg welcome',
            keyboard: false
          });
          autoInstance.result.then(function (res) {});
        }, 3);
      }

      socket.on('video-chat-request', function (data) {
        //get request name
        //

        if (appSettings.USER && appSettings.USER.role == 'model' && appSettings.USER.id == data.model) {
          userService.findMember(data.from).then(function (user) {

            if (user.status == 200 && user.data.id) {
              //show messages for private request
              data.requestUrl = appSettings.BASE_URL + 'models/privatechat/' + data.from + '?roomId=' + data.room + '&vr=' + data.virtualRoom;
              data.name = user.data.firstName + ' ' + user.data.lastName;
              data.username = user.data.username;
              data.avatar = user.data.avatar;

              //show as confirm
              if (!$scope.inRoom) {

      var vlang = "";
      var vlang2= "";
        switch($('#idioma').val()) {
          case 'es':
            vlang = "enviar solicitud de chat privado.";
            vlang2 = "Acaba de recibir una solicitud de llamada privada de ";
            break;
          case 'en':
            vlang = "send private chat request.";
            vlang2 = "You just received a private call request from ";
            break;

          case 'fr':
            vlang = "envoyer une demande de chat privé.";
            vlang2 = "Vous venez de recevoir une demande d'appel privé de ";
            break;

          default:
             vlang = "enviar solicitud de chat privado.";
             vlang2 = "Acaba de recibir una solicitud de llamada privada de ";
        }


                alertify.confirm(data.name + vlang, function () {
                  $window.location.href = data.requestUrl;
                }, function () {
                  callBackDenial(data);
                }).setting('labels', { 'ok': 'Accept', 'cancel': 'Deny' }).setHeader('Private Chat').autoCancel(25).setting('modal', false);
              } else {

          var vlang = "";
        switch($('#idioma').val()) {
          case 'es':
            vlang = ", haga clic aquí para aceptar.";
            break;
          case 'en':
            vlang = ", click here to accept.";
            break;

          case 'fr':
            vlang = ", cliquez ici pour accepter.";
            break;

          default:
             vlang = ", haga clic aquí para aceptar.";
        }

                var msg = alertify.message(vlang + data.name + vlang, 25);
                msg.callback = function (isClicked) {
                  if (isClicked) $window.location.href = data.requestUrl;else callBackDenial(data);
                };
              }
            }
          });
        }
      });
      function callBackDenial(data) {
        angular.element('ul.list-user li#private-' + data.from).remove();
        var totalRequest = angular.element('.tab-content .tab-private ul.list-user li').length;

        angular.element('span#private-amount').text(totalRequest);
        socket.emit('model-denial-request', data.virtualRoom);
      }
    }
  };
}]).directive('validateEmail', function () {
  var EMAIL_REGEXP = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

  return {
    require: 'ngModel',
    restrict: '',
    link: function link(scope, elm, attrs, ctrl) {
      // only apply the validator if ngModel is present and Angular has added the email validator
      if (ctrl && ctrl.$validators.email) {

        // this will overwrite the default Angular email validator
        ctrl.$validators.email = function (modelValue) {
          return ctrl.$isEmpty(modelValue) || EMAIL_REGEXP.test(modelValue);
        };
      }
    }
  };
}).directive('fallbackSrc', function () {
  var fallbackSrc = {
    link: function postLink(scope, iElement, iAttrs) {
      iElement.bind('error', function () {
        angular.element(this).attr("src", iAttrs.fallbackSrc);
      });
    }
  };
  return fallbackSrc;
}).directive('emojiInput', ['$timeout', function ($timeout) {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function link($scope, $el, $attr, ngModel) {
      $.emojiarea.path = '/lib/jquery-emojiarea-master/packs/basic/images';

      var options = $scope.$eval({ wysiwyg: true });
      var $wysiwyg = $($el[0]).emojiarea(options);
      $wysiwyg.on('change', function () {
        ngModel.$setViewValue($wysiwyg.val());
        $scope.$apply();
      });

      $('.chat-mes').on('keypress', function (e) {

        var code = e.keyCode || e.which;
        if (code == 13) {
          angular.element('#send-message').trigger('click');
          e.preventDefault();
        }
      });
      ngModel.$formatters.push(function (data) {
        // emojiarea doesn't have a proper destroy :( so we have to remove and rebuild
        $wysiwyg.siblings('.emoji-wysiwyg-editor, .emoji-button').remove();
        $timeout(function () {
          $wysiwyg.emojiarea(options);
        }, 0);
        return data;
      });
    }
  };
}]);
'use strict';

angular.module('matroshkiApp').directive('videoPlayer', ['$sce', function ($sce) {
  return {
    template: '<div><video ng-src="{{trustSrc()}}" id="streaming-{{videoId}}" autoplay  class="img-responsive" height="130px"></video></div>',
    restrict: 'E',
    replace: true,
    scope: {
      vidSrc: '@',
      showControl: '@',
      vid: '@',
      muted: '='
    },
    link: function link(scope, elem, attr) {
      console.log('Initializing video-player');
      scope.videoId = scope.vid;
      scope.isMuted = scope.muted ? 'muted' : '';
      if (scope.isMuted) {
        jQuery(elem.context.firstChild).attr('muted', true);
        elem.context.firstChild.muted = true;
      }

      scope.trustSrc = function () {
        if (!scope.vidSrc) {
          return undefined;
        }
        return $sce.trustAsResourceUrl(scope.vidSrc);
      };
      if (scope.showControl && elem.context && elem.context.firstChild) {
        elem.context.firstChild.controls = true;
      }
    }
  };
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('matroshkiApp').directive('convertToNumber', function () {
  return {
    require: 'ngModel',
    link: function link(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function (val) {
        return parseInt(val);
      });
      ngModel.$formatters.push(function (val) {
        return '' + val;
      });
    }
  };
});

'use strict';

angular.module('matroshkiApp').directive('mChatText', ['appSettings', 'chatService','multiretosService','gamesService', '_', '$uibModal', function (appSettings, chatService,multiretosService, gamesService, _, $uibModal) {
    return {
      restrict: 'AE',
      templateUrl: appSettings.BASE_URL + 'app/views/partials/chat-text-widget.html',
      scope: {
        modelId: '=modelId',
        chatType: '@chatType',
        memberId: '@',
        roomId: '@',
        isStreaming: '@',
        streamingInfo : "=ngModel"
      },
      controller: function ($scope, $timeout, appSettings, PerformerChat, $uibModal, $rootScope, socket, $sce, userService, chatService, onlineService, gamesService, multiretosService) {
        $scope.chatPanel = 'chats';
        $scope.hightLighTab = false;
        //redirect to private chat if group_chat_allowed is no
        var intervalChecking = setInterval(function(){
          var video = $('#videos-container').find('video');
          if(video.height() && video.height() > 0) {
            $('.list-chat').height(video.height() - 100);
          }
        }, 3000);

        $scope.Performerchat = PerformerChat;
        $scope.chatMessages = [];
        $scope.lastpage = 1;
        $scope.orderBy = 'createdAt';
        $scope.sort = 'desc';
        $scope.limit = 20;
        $scope.enableLoadMore = false;
        $scope.showLoading = false;
        $scope.isShowPrivateRequest = false;
        $scope.isOffline = false;
        $scope.isShowResetMessage = false;
        $scope.isShowRemoveMessage = false;
        $scope.progressMultiretos =false;
        $scope.Multiretoacumulado = 0;
        $scope.finalizarBtnMr =false;
        $scope.isShowJugarRuleta =false;
        $scope.isShowtabniveluno = false;
        $scope.isShowtabniveldos = false;
        $scope.isShowtabniveltres = false;


        switch($('#idioma').val()) {
          case 'es':
            $scope.Users = "Usuarios";
            $scope.PrivateChat = "CAM2CAM";
            $scope.Showpreviousmessage= "Mostrar mensaje anterior";
              $scope.loading = "Cargando...";
              $scope.Deletethismessage = "Borrar este mensaje";
              $scope.SEND = "ENVIAR";
              $scope.Typeamessagehere = "Escriba un mensaje aquí...";
              $scope.Therearenomemberonline = "No hay ningún miembro en línea!";
              $scope.ResetMessages = "Restablecer mensajes";
            break;
          case 'en':
            // code block
              $scope.Users = "Users";
              $scope.PrivateChat = "CAM2CAM";
              $scope.Showpreviousmessage= "Show previous message";
              $scope.loading = "Loading...";
              $scope.Deletethismessage = "Delete this message";
              $scope.SEND = "SEND";
              $scope.Typeamessagehere = "Type a message here...";
              $scope.Therearenomemberonline = "There are no member online!";
              $scope.ResetMessages = "Reset Messages";
             
            break;

            case 'fr':
            // code block
              $scope.Users = "Utilisateurs";
              $scope.PrivateChat = "CAM2CAM";
              $scope.Showpreviousmessage= "Afficher le message précédent";
              $scope.loading = "Chargement...";
              $scope.Deletethismessage = "Supprimer ce message";
              $scope.SEND = "ENVOYER";
              $scope.Typeamessagehere = "Tapez un message ici...";
              $scope.Therearenomemberonline = "Il n'y a aucun membre en ligne!";
              $scope.ResetMessages = "Réinitialiser les messages";
            break;
          default:
            $scope.Users = "Usuarios";
            $scope.PrivateChat = "CAM2CAM";
            $scope.Showpreviousmessage= "Mostrar mensaje anterior";
              $scope.loading = "Cargando...";
              $scope.Deletethismessage = "Borrar este mensaje";
              $scope.SEND = "ENVIAR";
              $scope.Typeamessagehere = "Escriba un mensaje aquí...";
              $scope.Therearenomemberonline = "No hay ningún miembro en línea!";
              $scope.ResetMessages = "Restablecer mensajes";
        }


        if(appSettings.USER && appSettings.USER.role === 'model') {
          $scope.isShowResetMessage = true;
          $scope.isShowRemoveMessage = true;
        }

        ////load messages at first time
        // chatService.findByModel({
        //   modelId: $scope.modelId,
        //   memberId: $scope.memberId || '',
        //   type: $scope.chatType,
        //   page: $scope.lastpage,
        //   orderBy: $scope.orderBy,
        //   sort: $scope.sort,
        //   limit: $scope.limit
        // }).success(function (res) {
        //   $scope.chatMessages = $scope.chatMessages.concat(res.data);
        //   //$scope.gotoAnchor($scope.chatMessages.length - 1);

        //   if (res.last_page > $scope.lastpage) {

        //     $scope.lastpage += 1;

        //     $scope.enableLoadMore = true;
        //   } else {
        //     $scope.enableLoadMore = false;
        //   }
        //   $scope.currentpage = res.current_page;

        //   //scroll to bottom
        //   $timeout(function () {
        //     $scope.$emit('new-chat-message');
        //   });
        // });












 socket.Multiretostip(function (data) {

      console.log(data);



      console.log("probandoXXXXXXXXX"+ appSettings.USER.id);



        multiretosService.getFirst($scope.modelId).success(function (res) {



           if (res != ""){

             $scope.progressMultiretos =true;
             $scope.Multiretogoal =  res.goal;
             $scope.Multiretotext = res.reto_text;
             $scope.Multiretoacumulado = res.ganancia;
              $scope.Multiretonumero = res.posicion;

             console.log(res);

         

     console.log($scope.tokensRetos);
      console.log("DEBERIA APLICAR LOS AJUSTOS"+ appSettings.USER.id + "sddd:"+$scope.modelId);

            }else{

  console.log("NO VA APLICAR LOS AJUSTES"+ appSettings.USER.id + "sddd:"+$scope.modelId);

            }
      });

     });







$scope.$on('sendMsgLovense', sendMsgLovense)

  function sendMsgLovense($event, message){
   
const msgId = Date.now();
            var sendObj = {
                    roomId: $scope.roomId,
                    text: message,
                    type: $scope.chatType,
                    id: msgId,
                    toys: true                  
                  };
socket.sendChatMessage(sendObj);
$scope.chatMessages.push({text: message, toys:true, username: "VibraLush", createdAt: new Date(), userId: appSettings.USER.id, id: msgId});



  }




  $scope.$on('Multiretoactualc', Multiretoactualc)

  function Multiretoactualc($event, message){

    console.log("Multiretoactualc chat-text-directive.js LADO cliente");

        multiretosService.getFirst($scope.modelId).success(function (res) {



           if (res != ""){

             $scope.progressMultiretos =true;
             $scope.Multiretogoal =  res.goal;
             $scope.Multiretotext = res.reto_text;
             $scope.Multiretoacumulado = res.ganancia;
            $scope.Multiretonumero = res.posicion;


            }
      });


   



  }
















  $scope.$on('sendMsgMultiretos', sendMsgMultiretos)

  function sendMsgMultiretos($event, message){

    console.log("sendMsgMultiretos chat-text-directive.js LADO SERVER");

        multiretosService.getFirst($scope.modelId).success(function (res) {



           if (res != ""){

             $scope.progressMultiretos =true;
             $scope.Multiretogoal =  res.goal;
             $scope.Multiretotext = res.reto_text;
             $scope.Multiretoacumulado = res.ganancia;
             $scope.Multiretonumero = res.posicion;
            

              if($scope.modelId == appSettings.USER.id){


                  $scope.finalizarBtnMr = true;
              }


              socket.Multiretoactual(res);

            }
      });


   

      const msgId = Date.now();
                  var sendObj = {
                          roomId: $scope.roomId,
                          text: message,
                          type: $scope.chatType,
                          id: msgId,
                          multiretos: true,
                          tip: 'mr'                  
                        };

      socket.sendChatMessage(sendObj);
     // socket.Multiretoactual(sendObj);
      $scope.chatMessages.push({text: message, tip: 'mr',username: "Desafios", createdAt: new Date(), userId: appSettings.USER.id, id: msgId});



  }


  $scope.btnFinalizarMultireto = function () {


 if(appSettings.USER && $scope.modelId == appSettings.USER.id){


   $scope.finalizarBtnMr = false;
  $scope.progressMultiretos = false;

  $scope.$parent.isShowRetos = false;

    $rootScope.$broadcast('FinalizarMultireto', "");

     var message = "<strong>El juego de Desafios ha finalizado!!</strong>";


    const msgId = Date.now();
                  var sendObj = {
                          roomId: $scope.roomId,
                          text: message,
                          type: $scope.chatType,
                          id: msgId,
                          multiretos: true,
                          tip: 'mr'                  
                        };


      socket.Multiretofinalizar({user_id:appSettings.USER.id});
      socket.sendChatMessage(sendObj);
      console.log("Multiretofinalizar");

     // socket.Multiretoactual(sendObj);
      $scope.chatMessages.push({text: message, tip: 'mr',username: "Desafios", createdAt: new Date(), userId: appSettings.USER.id, id: msgId});

if( !$scope.finalizarBtnMr && !$scope.isShowJugarRuleta){
      if( $scope.$parent.videoPrivadox) {
              $scope.$parent.videoPrivadox =  false;
          console.log("ssdd");
          socket.Videoprivadoxdesactivar({user_id:appSettings.USER.id});
          console.log("Desactivar video privadox");

          var msg = "Se ha puesto el vídeo público. ";
          const msgId = Date.now();
          var sendObj = {
              roomId: $scope.roomId,
              token: $scope.tokenVideoprivadox,
              text:  msg,
              tip: 'vp',
              id: msgId,
                      type: 'private',
                      videoprivadox: true
            };

            $scope.$broadcast('sendMsgVideoprivadox', sendObj);

      }

  }
                   
  }



 





  };





        $scope.loadPreviousMessage = function () {

          if ($scope.enableLoadMore) {
            $scope.showLoading = true;
            chatService.findByModel({
              modelId: $scope.modelId,
              memberId: $scope.memberId || '',
              type: $scope.chatType,
              page: $scope.lastpage,
              orderBy: $scope.orderBy,
              sort: $scope.sort,
              limit: $scope.limit
            }).success(function (res) {
              $scope.chatMessages = $scope.chatMessages.concat(res.data);
              $scope.showLoading = false;
              if (res.last_page > $scope.lastpage) {
                $scope.lastpage += 1;

                $scope.enableLoadMore = true;
              } else {
                $scope.enableLoadMore = false;
              }
              $scope.currentpage = res.current_page;

            });
          }
        };

        $scope.data = {text: ''};
//        $.emoticons.define(emoticonsData);
//        $scope.$on('emoticonsParser:selectIcon', function (event, icon) {
//          $scope.data.text += ' ' + icon;
//          $scope.$$phase || $scope.$apply();
//        });

        //get my info
        //
        var myInfo = [];
        $scope.userData = appSettings.USER;



        userService.get().then(function (data) {
          if (data.data != "") {
            $scope.userData = _.clone(data.data);
            $scope.streamingInfo.tokens = data.data.tokens;
          } else {
            $scope.userData = {
              id: 0,
              username: 'guest',
              avatar: ''
            };
          }
        });
        
        $scope.members = {};
        $scope.guests = [];
        socket.getOnlineMembers($scope.roomId);
        socket.onlineMembers(function (data) {


        if(appSettings.USER.id==$scope.modelId){

             userService.SetConnectByUser($scope.modelId,data.members.length).then(function (data) {

                        if (data.data.success) {

                           alertify.success(data.data.message,60);

                        } else {
                          console.log(data.data.message);
                        }

                      });


        }

                  

          $scope.members = angular.copy(data.members);
          const mems = angular.copy($scope.members);
          // if(appSettings.USER){
          //   _.remove($scope.members, function (currentObject) {
          //     return currentObject.id == appSettings.USER.id;
          //   });
          // }else {
          //   _.remove($scope.members, function (currentObject) {
          //     return currentObject.id == appSettings.IP;
          //   });
          // }
          $scope.guests = mems.filter(function(m) {
            return m.role === 'guest';
          });
          $scope.$$phase || $scope.$apply();
        });
         socket.onModelReceiveInfo(function (data){
            if(data.member){
                var existed = _.find($scope.members, ['id', data.member]);
                if(existed){
                    existed.time = (existed.time) ? existed.time + parseInt(data.time) : parseInt(data.time);
                    existed.spendTokens = (existed.spendTokens) ? existed.spendTokens + parseInt(data.tokens) : parseInt(data.tokens);
                }
            } 
         });

        
        //listen event when member is online
        socket.onMemberJoin(function (data) {
         console.log('onmenberjoin', data);


         console.log("se unio un miembro");

         console.log($scope.members);
          if(data && data.id != $scope.modelId){
//            console.log(data, $scope.members);
            var extised = _.find($scope.members, ['id', data.id]);
            if(!extised){
                $scope.members.push(angular.copy(data));
                const mems = angular.copy($scope.members);
                $scope.guests = mems.filter(function(m) {
                  return m.role === 'guest';
                });
            }
          }

          if ($scope.userData && $scope.userData.role == 'model') {
            if (data && typeof data.username != 'undefined' && $scope.chatType != 'private') {
              alertify.message(data.username + " join the room.");




          if($scope.isShowJugarRuleta){

            console.log("HABER QUE TAL");

            console.log($scope.dataruleta);


            socket.emit('reInitRuleta',{
                datos: $scope.dataruleta,
                userId: appSettings.USER.id,
                roomId: $scope.roomId
            });


          }




            }
          }
          //TODO: get user join data via api and show on model message by userId
          //update view
         
          $scope.$$phase || $scope.$apply();
        });
        
        //listen event when member is leave
        socket.onLeaveRoom(function (data) {

                  let mensaje= '';
              switch($('#idioma').val()) {
          case 'es':
           mensaje = ' abandono la sala';
            
            break;
          case 'en':
            
               mensaje = ' left the room';
             
            break;

            case 'fr':
              mensaje = ' a quitté la pièce';
            break;
          default:
            mensaje = ' left the room';
           
        }
//          console.log(data, $scope.chatType);
          if (($scope.userData && $scope.userData.role == 'model' && data && data.username && $scope.chatType == 'public') || $scope.chatType == 'group') {
            alertify.message(data.username + mensaje);
            
          }
          if($scope.chatType == 'private'){
//              socket.emit('model-leave-room');
          }
          
          
          _.remove($scope.members, function (currentObject) {
            return currentObject.id === data.id;
          });
          //update view
          $scope.$$phase || $scope.$apply();
        });



        //if user is not anonymous, join to group chat
        if (!appSettings.USER) {

          if ($scope.chatType === 'private') {
            //request to join private room
            socket.emit('join-private-room', {
              modelId: $scope.modelId,
              memberId: $scope.memberId
            }, function (data) {
              //assign room id to the thread
              roomId = data.id;
            });
          } else {
            //join to public room
            var joinRoomData = {
              roomId: $scope.roomId,
              userData: $scope.userData,
              type: $scope.chatType
            };

            socket.joinRoom(joinRoomData);
          }
        } else {
          var joinRoomData = {
            roomId: $scope.roomId,
            userData: $scope.userData,
            type: $scope.chatType
          };

          socket.joinRoom(joinRoomData);
        }

        $scope.send = function (keyEvent) {
          if ((keyEvent && keyEvent.keyCode === 13) || !keyEvent) {

            console.log("sdfd");
              
            //allow once user inputs text only
            var text = $scope.data.text.trim();
            sendMessage(text);
            
            $scope.data.text = '';
            
          }
        };

        //send tips
        $scope.sendTip = function () {

          alertify.prompt("Enter your tips.", 10,
                  function (evt, value) {
                    if (angular.isNumber(parseInt(value)) && parseInt(value) > 0) {
                      userService.sendTokens($scope.roomId, parseInt(value)).then(function (response)
                      {
                        if (response.data.success == false) {
                          alertify.error(response.data.message);
                          return;
                        } else {
                          alertify.success(response.data.message);
                          sendMessage('Enviar ' + parseInt(value) + ' tokens');
                        }
                      });
                    } else {
                      alertify.error('Please enter a number.');
                      $scope.sendTip();
                    }


                  });
        };



        function sendMessage(message) {
          socket.emit('checkOnline', $scope.modelId.toString(), function(data) {
            if(!data.isOnline) {
              return alertify.error('Model is now offline');
            }
             //check room id
            //TODO - wait timeout
            if (!$scope.roomId) {
              return alertify.notify('Room does not exist.', 'warning');
            }
            if (typeof message !== 'undefined' && message != '') {
              userService.checkBanNick($scope.modelId).then(function (data) {
                if (data.data.success && data.data.lock == 'no') {
                  const msgId = Date.now();
                  var sendObj = {
                    roomId: $scope.roomId,
                    text: message,
                    type: $scope.chatType,
                    id: msgId                  
                  };
                  if (!appSettings.USER) {
                    return alertify.alert('Warning', 'Please login to enter new message.');

                  }

                  //emit chat event to server
                  socket.sendChatMessage(sendObj);

  //                var icon = $.emoticons.replace(message);

  console.log("sendMessage");
                  
                  $scope.chatMessages.push({text: message, username: $scope.userData.username, createdAt: new Date(), userId: appSettings.USER.id, id: msgId});
                  $scope.data.text = '';
                  angular.element('.emoji-wysiwyg-editor').focus();
                  $scope.$emit('new-chat-message');
                } else {
                  alertify.error(data.data.message);
                }

              });

            }
          });
         
        }

        /**
         * @requires user is premium and premium chat only
         * @returns check and process payment for premium
         */
        if ($scope.chatType != 'public' && !appSettings.USER) {
          alertify.alert('Warning', 'Please login to join this room.');
          window.location.href = '/';
        }






function ShowProgressMrActual() {

console.log("onMultiretoactual chat-text-directive.js LADO CLIENTExxxxxxxxxx");

console.log("onMultiretoactual chat-text-directive.js LADO CLIENTE. modelo"+ $scope.modelId);




      multiretosService.getFirst($scope.modelId).success(function (res) {

           if (res != ""){
              console.log("MOSTRAR DESAFIOSSSS");
             $scope.progressMultiretos =true;
             $scope.Multiretogoal =  res.goal;
             $scope.Multiretotext = res.reto_text;
             $scope.Multiretoacumulado = res.ganancia;
             $scope.Multiretonumero = res.posicion;

             $(".chat-multiretos").show();


             // socket.Multiretoactual(res);

            }else{
                $scope.progressMultiretos =false;
                $(".chat-multiretos").hide();

                console.log("desafio ha finalidao");

            }
      });



}







socket.onMultiretoactual(function (data) { 

ShowProgressMrActual();


});

socket.onMultiretofinalizar(function (data) { 

ShowProgressMrActual();


});


        //add handler for new message from server
        socket.onReceiveChatMessage(function (data) {

          $scope.$on('Multiretoactualc', Multiretoactualc);

          $scope.chatMessages.push({text: data.text, tip: data.tip, toys: data.toys, username: data.username, createdAt: data.createdAt, userId: data.message.ownerId, id: data.id});
          //calculate position and scroll to bottom
          $scope.$emit('new-chat-message');
        });
        //get send tip event
        function beep() {
          const unique = new Date().getTime();
          var snd = new Audio("/sounds/received_message.mp3?v=" + unique);
          snd.play();
        }










 socket.onreciveTipMultiretos(function (data) {
var x = 0;
var msg = "";
console.log("ssxxxx"); 

console.log(data);
console.log(data.segundo);

if(data.segundo.length){


   for (var i in data.segundo)
  {


          console.log(data.segundo[i].goal);


   x = x+1;
          

              msg = msg + "<span class='txt__content atv_msg_contentdoneGoal'>Desafio conseguido!<br></span>";

            
             msg =  msg +  "<div class='goal doneGoal'><div class='noty-pill'>DESAFIO "+data.segundo[i].posicion+"</div><span class='goalInfo'> <ins class='atv_game_totalcoins'>"+data.segundo[i].goal+"<i class='icon-coin'></i></ins></span> <q class='goalInfo-txt atv_info_goal'>"+data.segundo[i].reto_text+"</q></div>";

  }

      $scope.chatMessages.push({text: msg, tip: 'mr',username: "Desafios", createdAt: new Date(), userId: appSettings.USER.id, id: Date.now()});



}



 });








        socket.onReceiveTip(function (data) {

          console.log(data);

          console.log("DARWWWWWWWWW");

          if(data.ruleta){


            if(appSettings.USER && $scope.modelId == appSettings.USER.id){
                 $scope.$parent.tokensRuleta += parseInt(data.token);
                 $scope.$parent.tokensTotales += parseInt(data.token);

                 if($scope.$parent.girarModeloruleta($scope.dataruleta,data.nivel,data.taskWin)){




                        $timeout(function(){ 
                              console.log("holaaaa");
                            $scope.chatMessages.push({text: data.username+" "+data.text, tip: 'ru', username: 'Ruleta', createdAt: data.createdAt});

                        },4000);




                 }


            }else{

                $scope.chatMessages.push({text: data.username+" "+data.text, tip: 'ru', username: 'Ruleta', createdAt: data.createdAt});

            }

             
          }else{


                if(appSettings.USER && $scope.modelId == appSettings.USER.id){
                    $scope.$parent.tokensTotales += parseInt(data.token);

                     if($scope.progressMultiretos){
                      $scope.$parent.tokensRetos +=  parseInt(data.token);
                      $scope.$parent.isShowRetos = true;
                    }
                }

          
              $scope.chatMessages.push({text: data.text, tip: 'yes', username: data.username, createdAt: data.createdAt});

          }
          //calculate position and scroll to bottom
          $scope.$emit('new-chat-message');
          beep();


        });
        
        
        //check group and private chat init
        socket.reqPrivateChat($scope.modelId);
        socket.reqGroupChat($scope.modelId);
        $scope.banNick = function (user, index) {
          userService.addBlackList(user.username).then(function (data) {
            if (data.data.success) {
              alertify.success(data.data.message);
              _.findIndex($scope.chatMessages, function (o) {
                if (o.username == user.username) {
                  o.banStatus = 'yes';
                }
              });
            } else {
              alertify.error(data.data.message);
            }
          });
        };
        $scope.unlockNick = function (user, index) {
          userService.removeBlackList(user.username).then(function (data) {
            if (data.data.success) {
              alertify.success(data.data.message);
              _.findIndex($scope.chatMessages, function (o) {
                if (o.username == user.username) {
                  o.banStatus = 'no';
                }
              });
            } else {
              alertify.error(data.data.message);
            }
          });
        };
        
        if(appSettings.USER && $scope.modelId == appSettings.USER.id){
            $scope.isShowPrivateRequest = true;
        }
        
         //TODO - move to global controller
        //this is for test only
        $scope.videoRequests = [];
        socket.on('video-chat-request', function (data) {

          console.log("holaaa por aquiii");
          //get request name
          //
//          console.log(data);
          if($scope.modelId == data.model) {
            userService.findMember(data.from).then(function (user){
              if(user.status == 200 && user.data.id){
                //show messages for private request
                data.requestUrl = appSettings.BASE_URL + 'models/privatechat/' + data.from + '?roomId=' + data.room + '&vr=' +data.virtualRoom;
                data.name = user.data.firstName + ' ' + user.data.lastName;
                data.username = user.data.username;
                data.avatar = user.data.avatar;
                data.id = user.data.id;
                var existed = _.find($scope.videoRequests, ['from', data.from]);
                if(existed){
                    existed.requestUrl = data.requestUrl;
                }else{
                      $scope.videoRequests.push(data);
                }
                if($scope.chatPanel !== 'privateChat'){
                  $scope.hightLighTab = true;
                }
              }
            });
          }
        });
        socket.on('stop-video-request', function (data) {
          if($scope.modelId == data.model) {
            _.remove($scope.videoRequests, ['from', data.from]);
          }
        });

        $scope.resetMessage = function(){
          $scope.chatMessages = [];
          socket.emit('reset-chat-message',{
            roomId: $scope.roomId
          });
        };
        socket.on('reset-chat-message', function(data) {
          $scope.chatMessages = [];
        });
        function removeMsg(msgId){
          const msgs = angular.copy($scope.chatMessages);
          $scope.chatMessages  = msgs.filter(function(item) {
            return item.id !== msgId;
          });
          $scope.$$phase || $scope.$apply();
        }
        $scope.removeMessage = function(msgId){
        
        var vlang = "";
        switch($('#idioma').val()) {
          case 'es':
            vlang = "¿Estás seguro de que deseas eliminar estos mensajes?";
            break;
          case 'en':
            vlang = "Are you sure you want to delete this messages?";
            break;

          case 'fr':
            vlang = "Voulez-vous vraiment supprimer ces messages?";
            break;

          default:
             vlang = "¿Estás seguro de que deseas eliminar estos mensajes?";
        }


          alertify.confirm(vlang,
          function () {
            removeMsg(msgId);
            socket.emit('remove-chat-message',{
              msgId: msgId
            });
          }).set('title', 'Confirm');
        };
        socket.on('remove-chat-message', function(data) {
          console.log(data);
          console.log($scope.chatMessages);
          removeMsg(data.msgId);
        });
        $scope.changeTab = function(tab) {
          $scope.chatPanel = tab;
          if($scope.chatPanel === 'privateChat'){
            $scope.hightLighTab = false;
            reloadUsersToken();
          }
        };
        function reloadUsersToken() {
          var userIds = [];
          const members = angular.copy($scope.videoRequests);
          _.map(members, function(member){
              userIds.push(member.from);
          });
          userService.getToken(userIds.join()).success(function(data){
            for(var i in members){
              var member = _.find(data, function(o) { return o.id === members[i].from; });
              $scope.videoRequests[i].tokens = member.tokens;
            }
            $scope.$$phase || $scope.$apply();            
          });
        }




    socket.onVideoprivadoxactivarmsg(function (data) {

    console.log(data);
    console.log("onVideoprivadoxactivarmsg");


    });




  $scope.$on('sendMsgVideoprivadox', sendMsgVideoprivadox)

  function sendMsgVideoprivadox($event, data){

    console.log("sendMsgVideoprivadox chat-text-directive.js LADO SERVER");



$timeout(function(){ 
  // Any code in here will automatically have an $scope.apply() run afterwards 
     $scope.chatMessages.push({text:data.text,videoprivadox: true, tip: 'vp',username: "Video Privado", createdAt: new Date(), userId: appSettings.USER.id, id: data.msgId});

  // And it just works! 
});



   // $scope.$emit('new-chat-message');
    socket.sendChatMessage(data);





  }


//ruleta


 socket.onInitRuleta(function (data) {


  $scope.dataruleta = data;

        $scope.isShowJugarRuleta = 1;

        var message = "Juego de la ruleta esta ahora activo!!";
        const msgId = Date.now();


      $scope.chatMessages.push({text: message, tip: 'ru',username: "Ruleta", createdAt: new Date(), userId: appSettings.USER.id, id: msgId});

      if(data.datos.datosniveluno.length >0){

        $scope.tabListNiveluno = data.datos.datosniveluno;
        $scope.tabListNiveluno_titulo = data.datos.datosniveluno[0].titulo;
        $scope.tabListNiveluno_goal = data.datos.datosniveluno[0].goal;

        $scope.isShowtabniveluno = true;

      }

      if(data.datos.datosniveldos.length >0){

        $scope.tabListNiveldos = data.datos.datosniveldos;
        $scope.tabListNiveldos_titulo = data.datos.datosniveldos[0].titulo;
        $scope.tabListNiveldos_goal = data.datos.datosniveldos[0].goal;
        $scope.isShowtabniveldos = true;
      
      }
      

      if(data.datos.datosniveltres.length >0){

        $scope.tabListNiveltres = data.datos.datosniveltres;
        $scope.tabListNiveltres_titulo = data.datos.datosniveltres[0].titulo;
        $scope.tabListNiveltres_goal = data.datos.datosniveltres[0].goal;
        $scope.isShowtabniveltres = true;
      }

 });








  $scope.btnFinalizarRuleta = function () {


    $scope.isShowJugarRuleta = 0;
    $rootScope.$broadcast('FinalizarRuleta', "");

  };




 socket.onFinalizarRuleta(function (data) {

     $scope.isShowJugarRuleta = false;
     $scope.$parent.isShowruletachart = false;
    $timeout(function() {
        angular.element('#chats').trigger('click');

        });
      var message = "Juego de la ruleta ha finalizado!!";
      const msgId = Date.now();

      $scope.chatMessages.push({text: message, tip: 'ru',username: "Ruleta", createdAt: new Date(), userId: appSettings.USER.id, id: msgId});
    


if( !$scope.finalizarBtnMr && !$scope.isShowJugarRuleta){


      if( $scope.$parent.videoPrivadox) {
          $scope.$parent.videoPrivadox =  false;

          socket.Videoprivadoxdesactivar({user_id:appSettings.USER.id});


          var msg = "Se ha puesto el vídeo público. ";
          const msgId = Date.now();
          var sendObj = {
              roomId: $scope.roomId,
              token: $scope.tokenVideoprivadox,
              text:  msg,
              tip: 'vp',
              id: msgId,
                      type: 'private',
                      videoprivadox: true
            };

            $scope.$broadcast('sendMsgVideoprivadox', sendObj);

      }

}

 });


$scope.gira = function(nivel) {


console.log("giraaaaa"+ $scope.roomId);

  if(nivel == "1"){

       $scope.$parent.sendTipSpin($scope.roomId, 'public',  $scope.dataruleta.datos.datosniveluno[0].goal,$scope.dataruleta.datos.datosniveluno[0].titulo,1)

  }
  if(nivel == "2"){

     $scope.$parent.sendTipSpin($scope.roomId, 'public',  $scope.dataruleta.datos.datosniveldos[0].goal,$scope.dataruleta.datos.datosniveldos[0].titulo,2)
    
  }
  if(nivel == "3"){

    $scope.$parent.sendTipSpin($scope.roomId, 'public',  $scope.dataruleta.datos.datosniveltres[0].goal,$scope.dataruleta.datos.datosniveltres[0].titulo,3)
    
  }
 


}


$scope.drawRuleta = function(nivel){

$scope.$parent.drawRuleta(nivel);

}





      }
    };
  }
])
        .directive('mChatScroll', ['$', function ($) {
            return {
              link: function (scope, ele) {
                scope.$on('new-chat-message', function () {

                  //check current scroll of the div
//                  var height = $('.list-chat', $(ele)).outerHeight();

                  //TODO - check position on scroll
//                  if($ele.scrollTop() + $ele.innerHeight() >= $(ele)[0].scrollHeight) {
//                    alert('end reached');
//                  }
//                  

                  var height = $('.list-chat', $(ele)).height();
                  ele.find('li').each(function (i, value) {
                    height += parseInt($(this).outerHeight());
                  });

                  $('.list-chat', ele).animate({scrollTop: height});
//                  ele.animate({scrollTop: height});
                });
              }
            };
          }]);



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
      $scope.local_stream;
      $scope.remote_stream;
      $scope.micOnprivate =true; 
      $scope.tagvideo = ""; 
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

              $scope.modelStreaming = true;
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
        $scope.tagvideo = video;
        video.addEventListener("volumechange", $scope.volumevideo);

        try {
            video.setAttributeNode(document.createAttribute('autoplay'));
            video.setAttributeNode(document.createAttribute('playsinline'));
        } catch (e) {
            video.setAttribute('autoplay', true);
            video.setAttribute('playsinline', true);
        }

        if(event.type== 'remote'){
            $scope.remote_stream = event;

        }
        if (event.type === 'local') {
          $scope.local_stream = event;
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

$scope.micprivate = function(){

    console.log("directivamicx");
    $scope.local_stream.stream.getAudioTracks()[0].enabled = !$scope.local_stream.stream.getAudioTracks()[0].enabled;
    $scope.micOnprivate =$scope.local_stream.stream.getAudioTracks()[0].enabled;
}




$scope.volumevideo = function() {

    console.log($scope.remote_stream.stream);

    console.log($scope.tagvideo.muted);

    if($scope.tagvideo.muted){
        $scope.remote_stream.stream.getAudioTracks()[0].enabled = false;
        return;

    }

  if($scope.tagvideo.volume == 0){

    $scope.remote_stream.stream.getAudioTracks()[0].enabled = !$scope.remote_stream.stream.getAudioTracks()[0].enabled;

  }else{

    $scope.remote_stream.stream.getAudioTracks()[0].enabled = true;

  }

};





    }
  };
}]);
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
      var streams = [];
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

      $scope.startConversation = function () {
        connection.open($scope.virtualRoom, function (isRoomOpened, roomid, error) {
          if (isRoomOpened === true) {
            $scope.modelStreaming = true;
            peerService.joinGroupRoom($scope.virtualRoom, {
              memberId: $scope.memberId,
              modelId: $scope.modelId,
              type: 'group',
              room: $scope.room
            });
          } else {
            if (error === 'Room not available') {

      var vlang = "";
 
        switch($('#idioma').val()) {
          case 'es':
            vlang = "Alguien ya creó esta sala. Únase o cree una sala separada.";
           
            break;
          case 'en':
            vlang = "Someone already created this room. Please either join or create a separate room.";
           
            break;

          case 'fr':
            vlang = "Quelqu'un a déjà créé cette salle. Veuillez rejoindre ou créer une salle séparée.";
           
            break;

          default:
             vlang = "Alguien ya creó esta sala. Únase o cree una sala separada.";
            
        }


              alert(vlang);
              return;
            }
            alert(error);
          }
        });
      };
      $scope.joinConversation = function () {
        userService.get().then(function (data) {
          if (data.data) {
            if (parseInt(data.data.tokens) < 1) {

      var vlang = "";
 
        switch($('#idioma').val()) {
          case 'es':
            vlang = "Tus tokens no son suficientes, compra más.";
           
            break;
          case 'en':
            vlang = "Your tokens do not enough, please buy more.";
           
            break;

          case 'fr':
            vlang = "Vos jetons ne suffisent pas, veuillez en acheter plus.";
           
            break;

          default:
             vlang = "Tus tokens no son suficientes, compra más.";
            
        }

              return alertify.error(vlang);
            } else {
              connection.join($scope.virtualRoom, function (isJoinedRoom, roomid, error) {
                if (error) {
                  if (error === 'Room not available') {
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
      connection.onstream = function (event) {
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
        streams.push({
          id: event.streamid,
          stream: event.stream
        });
        video.srcObject = event.stream;
        video.controls = true;
        video.className = 'video-in-group';
        connection.videosContainer.appendChild(video);
        setTimeout(function () {
          video.play();
        }, 5000);
        video.id = event.streamid;
        // to keep room-id in cache
        localStorage.setItem(connection.socketMessageEvent, connection.sessionid);
        if (event.type === 'local') {
          connection.socket.on('disconnect', function () {
            if (!connection.getAllParticipants().length) {
              location.reload();
            }
          });
        }
        if (connection.getAllParticipants().length > 0 && $scope.userRole === 'member') {
          $interval(function () {
            if ($scope.second === 60) {
              $scope.second = 0;
              $scope.streamingInfo.time++;
              sendPaidTokens();
            }
            $scope.second++;
          }, 1000);
        }
      };

      //change large video
      $(document).on('click', '.video-in-group', function () {
        $('.video-in-group').removeClass('active');
        $(this).addClass('active');
        var streamId = $(this).attr('id');
        var stream = streams.find(function (str) {
          return streamId === str.id;
        });
        var videoCurr = document.getElementById('currentvideo-groupchat');
        if (stream) {
          videoCurr.srcObject = stream.stream;
          setTimeout(function () {
            videoCurr.play();
            $scope.isShowLargeVideo = true;
            $scope.$$phase || $scope.$apply();
          });
        }
      });

      connection.onstreamended = function (event) {
        var mediaElement = document.getElementById(event.streamid);
        if (mediaElement) {
          mediaElement.parentNode.removeChild(mediaElement);
        }
      };
      connection.onMediaError = function (e) {
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

      $scope.stopStreaming = function () {
        socket.emit('model-leave-room');
        endStream();
      };
      function endStream() {
        if (appSettings.USER.role == 'model') {
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

   var vlang = "";
 
        switch($('#idioma').val()) {
          case 'es':
            vlang = "Tus tokens no son suficientes, compra más.";
           
            break;
          case 'en':
            vlang = "Your tokens do not enough, please buy more.";
           
            break;

          case 'fr':
            vlang = "Vos jetons ne suffisent pas, veuillez en acheter plus.";
           
            break;

          default:
             vlang = "Tus tokens no son suficientes, compra más.";
            
        }
            
            alertify.error(vlang, 5, endStream);
            socket.emit('member-missing-tokens', $scope.chatType);
            return;
          }
        });
      }
    }
  };
}]);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';

angular.module('matroshkiApp').directive('uploadFile', ['appSettings', 'mediaService', function (appSettings, mediaService) {

  return {
    restrict: 'AE',
    template: '<div><input type="hidden" name="myFiles" ng-model="myFiles"><div id="mulitplefileuploader">Upload</div><div id="status"></div></div>',
    require: 'ngModel',
    replace: true,
    scope: {
      myfiles: '=ngModel',
      fileName: '@',
      multiple: '@',
      showDelete: '@',
      showPreview: '@',
      allowedTypes: '@',
      mediaType: '@',
      parentId: '@',
      showDone: '@'
    },
    //      templateUrl: appSettings.BASE_URL + 'app/views/partials/editor.html',
    link: function link(scope, elem, attr, ngModel) {
      var current = [];
      //        scope.myPhotos = ngModelCtrl;
      if (!ngModel) return; // do nothing if no ng-model

      // Specify how UI should be updated
      //        ngModel.$render = function () {
      //          
      //        };
      ngModel.$render = function () {
        //          elem.html(ngModel.$viewValue || '');
      };
      var mediaType = scope.mediaType ? scope.mediaType : '';
      var parentId = scope.parentId ? scope.parentId : 0;
      var settings = {
        url: appSettings.BASE_URL + 'api/v1/upload-items?parent-id=' + parentId + '&mediaType=' + mediaType,
        method: "POST",
        allowedTypes: "jpg,png,gif,jpeg,mp4,m4v,ogg,ogv,webm",
        fileName: "myFiles",
        multiple: true,
        showDelete: true,
        showPreview: false,
        showDone: true,
        statusBarWidth: '55%',
        dragdropWidth: '55%',
        onSuccess: function onSuccess(files, data, xhr) {

          if (data.success == true) {
            //              ngModelCtrl.$viewValue = data.fileName;
            //              scope.$apply(function () {
            //                ngModelCtrl.$setViewValue(data.fileName);
            //                ngModelCtrl.$setViewValue('StackOverflow');
            //              });
            //              scope.$watch('myPhotos', function (value) {
            //                if (ngModelCtrl.$viewValue != value) {
            //                  ngModelCtrl.$setViewValue(data.fileName);
            //                  
            //                }
            //              });


            current.push(data.file.id);
            ngModel.$setViewValue(current);

            $("#status").html("<font color='green'>" + data.message + "</font>");
          } else {
            $("#status").html("<font color='red'>" + data.message + "</font>");
          }
        },
        onError: function onError(files, status, errMsg) {
         switch($('#idioma').val()) {
          case 'es':
           $("#status").html("<font color='red'>No se pudo cargar</font>");

            break;
          case 'en':
           $("#status").html("<font color='red'>Upload is Failed</font>");
             
            break;

            case 'fr':
            $("#status").html("<font color='red'>Le téléchargement a échoué</font>");

            break;
          default:
            $("#status").html("<font color='red'>No se pudo cargar</font>");
        }
        },
        deleteCallback: function deleteCallback(element, data, pd) {

          if (element.file.type.indexOf('image') != -1) {
            mediaService.deleteImage(element.file.id).then(function (data) {
              if (data.data.success) {
                var index = current.indexOf(element.file.id);
                current.splice(index, 1);
                ngModel.$setViewValue(current);
                alertify.success(data.data.message);
              } else {
                alertify.error(data.data.message);
              }
            });
          } else if (element.file.type.indexOf('video') != -1) {
            mediaService.deleteVideo(element.file.id).then(function (data) {
              if (data.data.success) {
                var index = current.indexOf(element.file.id);
                current.splice(index, 1);
                ngModel.$setViewValue(current);
                alertify.success(data.data.message);
              } else {
                alertify.error(data.data.message);
              }
            });
          }
        }
      };
      $("#mulitplefileuploader").uploadFile(settings);
    }

  };
}]);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';

angular.module('matroshkiApp').directive('multipleUpload', ['appSettings', 'mediaService', function (appSettings, mediaService) {

  return {
    restrict: 'AE',
    template: '<div><input type="hidden" name="myfiles" ng-model="myFiles"><div id="mulitplefileuploader">Upload</div><div id="status"></div></div>',
    require: 'ngModel',
    replace: true,
    scope: {
      files: '=ngModel',
      fileName: '@',
      multiple: '@',
      showDelete: '@',
      showPreview: '@',
      allowedTypes: '@',
      mediaType: '@',
      parentId: '@',
      showDone: '@',
      modelId: '@'
    },
    link: function link(scope, elem, attr, ngModel) {
      var myFiles = [];

      if (!ngModel) return; // do nothing if no ng-model

      // Specify how UI should be updated
      //        ngModel.$render = function () {
      //          
      //        };

      ngModel.$render = function () {};
      var mediaType = scope.mediaType ? scope.mediaType : '';
      var parentId = scope.parentId ? scope.parentId : null;
      var modelId = scope.modelId ? scope.modelId : null;
      var settings = {
        url: appSettings.BASE_URL + 'api/v1/upload-items?mediaType=' + mediaType + '&parent-id=' + parentId + '&model-id=' + modelId,
        method: "POST",
        allowedTypes: scope.allowedTypes,
        fileName: 'myFiles',
        multiple: scope.multiple,
        showDelete: scope.showDelete,
        showPreview: scope.showPreview,
        showDone: scope.showDone,
        statusBarWidth: '100%',
        dragdropWidth: '100%',
        onSuccess: function onSuccess(files, data, xhr, pd) {

          if (data.success == true) {

            myFiles.push(data.file);

            ngModel.$setViewValue(myFiles);
            //              alertify.success(files);
            //              console.log(pd);
            var uploadName = pd.filename[0].innerHTML;
            alertify.success(uploadName + ' ' + data.message);
            //              $("#status").html("<font color='green'>" + data.message + "</font>");
          } else {
            //              $("#status").html("<font color='red'>" + data.message + "</font>");
            alertify.error(data.message);
          }
        },
        onError: function onError(files, status, errMsg) {
          switch($('#idioma').val()) {
          case 'es':
           $("#status").html("<font color='red'>No se pudo cargar</font>");

            break;
          case 'en':
           $("#status").html("<font color='red'>Upload is Failed</font>");
             
            break;

            case 'fr':
            $("#status").html("<font color='red'>Le téléchargement a échoué</font>");

            break;
          default:
            $("#status").html("<font color='red'>No se pudo cargar</font>");
        }
        },
        deleteCallback: function deleteCallback(element, data, pd) {

          if (element.file.type.indexOf('image') != -1) {
            mediaService.deleteImage(element.file.id).then(function (data) {
              if (data.data.success) {
                var index = myFiles.indexOf(element.file.id);
                myFiles.splice(index, 1);
                ngModel.$setViewValue(myFiles);
                alertify.success(data.data.message);
              } else {
                alertify.error(data.data.message);
              }
            });
          } else if (element.file.type.indexOf('video') != -1) {
            mediaService.deleteVideo(element.file.id).then(function (data) {
              if (data.data.success) {
                var index = myFiles.indexOf(element.file.id);
                myFiles.splice(index, 1);
                ngModel.$setViewValue(myFiles);
                alertify.success(data.data.message);
              } else {
                alertify.error(data.data.message);
              }
            });
          }
        }
      };
      $("#mulitplefileuploader").uploadFile(settings);
    }

  };
}]);

'use strict';
angular.module('matroshkiApp').directive('checkUserOnline', ['socket', 'userService', function (socket, userService) {
  return {
    restrict: 'A',
    scope: {
      userId: '@'
    },
    template: '<span ng-class="{\'text-warning\': !online, \'text-success\': online && !isBusy , \'text-danger\': isBusy}"><i class="fa fa-circle"></i>\n\t              <span ng-show="!online">Offline</span><span ng-show="online && !isBusy">Online</span><span ng-show="isBusy">Busy</span></span>',
    link: function link(scope) {
      userService.checkBusy(scope.userId).then(function (data) {
        if (data.data.isBusy) {
          scope.isBusy = true;
        }
      });
      socket.emit('checkOnline', scope.userId.toString(), function (data) {
        scope.online = data.isOnline;
      });
    }
  };
}]);

'use strict';

angular.module('matroshkiApp').directive('mJuegos', ['appSettings', 'gamesService','multiretosService', '_', '$uibModal', function (appSettings, gamesService, _, $uibModal) {
    return {
      require: "^mChatText",
      restrict: 'AE',
      templateUrl: appSettings.BASE_URL + 'app/views/partials/juegos-widget.html',
      scope: {
        modelId: '=modelId',
        chatType: '@chatType',
        memberId: '@',
        roomId: '@',
        streamingInfo : "=ngModel"
      },
      controller: function ($scope, $timeout, appSettings, PerformerChat, $uibModal, socket, $sce, $rootScope,userService, gamesService, multiretosService, onlineService,$http, $location, $anchorScroll) {
        
     //   GetAllGames();
        $scope.chatPanel = 'juegos';
        $scope.Jugando= false;
        $scope.windowsgame = false;
        $scope.messageText=true;
        $scope.messageToy=false;
        $scope.loading= false;
        $scope.loadingJuegos= true;
        $scope.messageJuegos =false;
        $scope.jugandoBtn =false;
        $scope.jugandoBtnMr =false;
        $scope.loadingOpenwindows= false;
        $scope.BtnShowVibralush = true;
        $scope.BtnShowMultireto = true;
        $scope.finalizarBtnMr = false;
        $scope.activeJugando = '';
        $scope.toyId = {};
        $scope.deviceId = {};
        $scope.domain = {};
        $scope.httpsPort = {};
        $scope.toys= {};
        $scope.items = {};
        $scope.progress = "Enter a value";
        $scope.topic        = "Lush a tope en el trabajo!!",
        $scope.level1value  = 100,
        $scope.level1       = "mmmm...",
        $scope.level2value  = 200,
        $scope.level2       = "¡Oh! Qué gustito",
        $scope.level3value  = 300,
        $scope.level3       = "¡UFFFF que no aguanto!",
        $scope.level4value  = 400,
        $scope.level4       = "¡¡me muero de PLACEEEEER!!",
        $scope.taskList_niveluno  = [];
        $scope.taskList_niveldos  = [];
        $scope.taskList_niveltres = [];
        $scope.taskList_nivelfull = [];
        $scope.nivel = "1";

        $scope.ruletaniveluno_name = "Ruleta 1";
        $scope.ruletaniveldos_name = "Ruleta 2";
        $scope.ruletaniveltres_name = "Ruleta 3";
        $scope.ruletaniveluno_obj = 50;
        $scope.ruletaniveldos_obj = 100;
        $scope.ruletaniveltres_obj = 200;


  multiretosService.get(appSettings.USER.id).success(function (res) {

        

       $scope.taskList = res;

      });





        /*   $scope.taskList = [
        {goal: 1000,
        task: 'Do nothing'
      },
        {
          goal: 2000,
          task: 'Show some tasks'
        },
        {
          goal: 3000,
          task: 'Add a task'
        },
        {
        goal: 4000,
        task: 'Walk the dog'
      }
      ];*/




       /* $scope.lovenses=[{diviceconnect:true,nombre:"Lovense1",id:20},
                        {diviceconnect:false,nombre:"Lovense2",id:40}];*/

    //    $scope.items =  {"192-168-1-38.lovense.club":{"deviceId":"connect_52b7205d31d24e60bcac93a03a783901","domain":"192-168-1-38.lovense.club","httpPort":34567,"wsPort":34567,"httpsPort":34568,"wssPort":34568,"toyJson":"{\"ed0faf47705e\":{\"nickName\":\"\",\"name\":\"lush\",\"id\":\"ed0faf47705e\",\"battery\":\"97\",\"version\":\"3\",\"status\":1}}","platform":"android","appVersion":"2.6.7","toys":{"ed0faf47705e":{"nickName":"","name":"lush","id":"ed0faf47705e","battery":"97","version":"3","status":1}}}};
                
/*$scope.items = {
    "192-168-0-11.lovense.club":{
        "domain":"192-168-0-11.lovense.club",
         "checked": true,
        "httpPort": 34567,
        "wsPort": 34567,
        "httpsPort": 34568,
        "wssPort": 34568,
        "toys":{
            "D03972ACB452":{
                "id":"D03972ACB452",
                "name":"Nora",
                "nickName":"Lily's Nora"
            }
        }
    },
    "192-168-0-12.lovense.club":{
        "domain":"192-168-0-12.lovense.club",
        "httpPort": 34567,
        "wsPort": 34567,
        "httpsPort": 34568,
        "wssPort": 34568,
        "toys":{}
    }
};*/
        
      $scope.$watch(function() {
          return $scope.$parent.isStreaming;
        }, function(value) {
          if (value){
            
            $scope.isStreaming = value;
          }
        })



 gamesService.getAllGames(appSettings.USER.id).success(function (res) {

              $scope.loadingJuegos= false;
             if(res.length > 0){
                $scope.itemsAllGames = res; 
             }else{
                $scope.messageJuegos =true;
             }
            
            
            });

        /*    $scope.$watch(function() {
          return $scope.$parent.chatMessages;
        }, function(value) {
          if (value){
            
            $scope.chatMessages = value;
          }
        })*/


        switch($('#current_idioma').val().trim()) {
          case 'es':
            $scope.juegos = "Juegos";
            $scope.comienzaemitir = "Comienza a emitir para poder crear juegos";
            $scope.vincula = "Vincula tus vibradores Lovense y elige los niveles para que vibren con las propinas.";
            $scope.jugar = "Jugar";
            $scope.jugando = "Jugando";

            break;
          case 'en':
            // code block
              $scope.juegos = "Plays";
              $scope.comienzaemitir = "Starts broadcasting to create games";
              $scope.vincula = "Pair your Lovense vibrators and choose the levels to vibrate with tips.";
              $scope.jugar = "play";
              $scope.jugando = "Playing";
             
            break;

            case 'fr':
            // code block
              $scope.juegos = "Jeux";
              $scope.comienzaemitir = "Discussion privée";
              $scope.vincula = "Associez vos vibrateurs Lovense et choisissez les niveaux pour vibrer avec des astuces.";
              $scope.jugar = "jouer";
              $scope.jugando = "En jouant";
            break;
          default:
            $scope.juegos = "Juegos";
            $scope.comienzaemitir = "Comienza a emitir para poder crear juegos";
            $scope.vincula = "Vincula tus vibradores Lovense y elige los niveles para que vibren con las propinas.";
            $scope.jugar = "Jugar";
            $scope.jugando = "Jugando";
        }







   $scope.addMultireto = function () {



         if (($scope.input_titulo_value && $scope.input_titulo_value.length) && ($scope.input_goal_value)) {


if ($scope.taskList.length >= 10){

alert("Ha alcanzado el maximo de 10 desafios")
  return;
}



                    $scope.taskList.push({
                      task: $scope.input_titulo_value,
                      goal: $scope.input_goal_value
                    });


                    $scope.input_titulo_value= "";

                    $scope.input_goal_value = "";


console.log($scope.taskList);


       for (var i in $scope.taskList)
        {
          console.log($scope.taskList[i].task);
          console.log($scope.taskList[i].goal)
        }




               
        }else{

         alert("existen campos vacios ");
        }

}


   $scope.DeleteMultireto = function () {
      $scope.taskList.splice(this.$index, 1);

   }




        $scope.openwindowsgame = function (value) {


          $scope.windowsgameMr=false;
          $scope.loadingOpenwindows=true;
        $scope.BtnShowMultireto = false;


          if(value){

            gamesService.getLastGame(appSettings.USER.id).success(function (res) {



              if (Object.keys(res).length > 0){
                  $scope.topic        = res.topic;
                  $scope.level1value  = res.level1value;
                  $scope.level1       = res.level1;
                  $scope.level2value  = res.level2value;
                  $scope.level2       = res.level2;
                  $scope.level3value  = res.level3value;
                  $scope.level3       = res.level3;
                  $scope.level4value  = res.level4value;
                  $scope.level4       = res.level4;

              }

             



              $scope.windowsgame=value;
              

            });


          }else{
             $location.hash('m-juegos');
              $anchorScroll();
              $scope.loadingOpenwindows=false;
              $scope.windowsgame=value;
              $scope.BtnShowMultireto = true;

             
          }

        //$scope.loadingOpenwindows=false;

          
        


        };








//multireto
        $scope.openwindowsgameMr = function (value) {


          $scope.windowsgame=false;
          $scope.BtnShowVibralush = false;

          $scope.loadingOpenwindowsMr=true;


          if(value){


             $scope.windowsgameMr=value;


          }else{
             $location.hash('m-juegos');
              $anchorScroll();
              $scope.loadingOpenwindows=false;
              $scope.windowsgameMr=value;
              $scope.BtnShowVibralush = true;

             
          }

        };





        $scope.IniciarLovence = function (value) {

            $scope.windowsgame= true;
            console.log('daaas');

        };





  $scope.guardarJuegos = function(form){

    

if(!form.$valid) {

              switch($('#idioma').val()) {
          case 'es':
            alertify.error('Por favor complete los datos');
            break;
          case 'en':
            // code block
              alertify.error('Por favor complete los datos');
             
            break;

            case 'fr':
            // code block
              alertify.error('Por favor complete los datos');
            break;
          default:
            alertify.error('Por favor complete los datos');
        }

   return;
  }



 if(!Object.keys($scope.items).length){
    
    alertify.error('No hay ningún juguete vinculado');
    return;
}



    $scope.windowsgame=false;
    $scope.activeJugando ="active";
    $scope.jugandoBtn = true;
    $scope.loadingOpenwindows=false;
        
       
    socket.emit('GamesModel', {
      topic: $scope.topic,
      level1value: $scope.level1value,
      level1: $scope.level1,
      level2value: $scope.level2value,
      level2: $scope.level2,
      level3value: $scope.level3value,
      level3: $scope.level3,
      level4value: $scope.level4value,
      level4: $scope.level4,
      userId: appSettings.USER.id,
      roomId: $scope.roomId,
      toys: $scope.toys,
      items:$scope.items

      

    }, function() {

        console.log("guardado juegos");
        $location.hash('m-juegos');
        $anchorScroll();

        $scope.Jugando=true;

        $scope.enviarmensaje();

        //setTimeout(function(){ $scope.enviarmensaje() }, 60000);


              switch($('#idioma').val()) {
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



$scope.$parent.Showvideoprivadox = true;
$scope.$parent.gridChat = 'col-sm-4';

//notificar mensaje//





    });
  };









  $scope.guardarJuegosMr = function(form){

$scope.$parent.Showvideoprivadox = true;
$scope.$parent.gridChat = 'col-sm-4';
console.log($scope.$parent.Showvideoprivadox);


if ($scope.taskList.length == 0){

alert("Debe agregar un desafio")
  return;
}


if ($scope.taskList.length == 9){

alert("Ha alcanzado el maximo de 10 desafios")
  return;
}


    socket.emit('MultiretosModel', {
      datos: $scope.taskList,
      userId: appSettings.USER.id,
      roomId: $scope.roomId
 

      

    }, function() {

        console.log("guardado juegos");
        $location.hash('m-juegos');
        $anchorScroll();

        $scope.Jugando=true;


      //   $rootScope.$broadcast('progressMultireto', $scope.taskList);

        $scope.enviarmensajemr();

        //setTimeout(function(){ $scope.enviarmensaje() }, 60000);


              switch($('#idioma').val()) {
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





//notificar mensaje//





    });










    

/*if(!form.$valid) {

    switch($('#idioma').val()) {
          case 'es':
            alertify.error('Por favor complete los datos');
            break;
          case 'en':
            // code block
              alertify.error('Por favor complete los datos');
             
            break;

            case 'fr':
            // code block
              alertify.error('Por favor complete los datos');
            break;
          default:
            alertify.error('Por favor complete los datos');
        }

   return;
  }*/



 



    $scope.windowsgameMr=false;
    $scope.activeJugandoMr ="active";
    $scope.jugandoBtnMr = true;
    $scope.loadingOpenwindows=false;
    $scope.finalizarBtnMr = false;

  console.log( $scope.finalizarBtnMr);

/////////////////////////////////////ddd
       
    /*socket.emit('GamesModel', {
      topic: $scope.topic,
      level1value: $scope.level1value,
      level1: $scope.level1,
      level2value: $scope.level2value,
      level2: $scope.level2,
      level3value: $scope.level3value,
      level3: $scope.level3,
      level4value: $scope.level4value,
      level4: $scope.level4,
      userId: appSettings.USER.id,
      roomId: $scope.roomId,
      toys: $scope.toys,
      items:$scope.items

      

    }, function() {

        console.log("guardado juegos");
        $location.hash('m-juegos');
        $anchorScroll();

        $scope.Jugando=true;

        $scope.enviarmensaje();

        //setTimeout(function(){ $scope.enviarmensaje() }, 60000);


              switch($('#idioma').val()) {
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


    });*/





  };





 $scope.enviarmensaje = function() {

console.log("scope.enviarmensaje");
    var msg = "VibraLush activo";
    gamesService.get(appSettings.USER.id).success(function (res) {


console.log("encontro juegos para el usuario");
              if (Object.keys(res).length > 0){
            
                   msg= res.topic+"<br><br><strong>Nivel 1</strong>: "+res.level1value+"<i class='icon-coin'></i> <small>"+res.level1+"</small><br><strong class=''>Nivel 2</strong>: "+res.level2value+"<i class='icon-coin'></i> <small>"+res.level2+"</small><br><strong class=''>Nivel 3</strong>: "+res.level3value+"<i class='icon-coin'></i> <small>"+res.level3+" </small><br><strong class=''>Nivel 4</strong>: "+res.level4value+"<i class='icon-coin'></i> <small>"+res.level4+"</small><br>";
             
              

              }

              $rootScope.$broadcast('sendMsgLovense', msg);

              console.log("mensaje enviado");

      });



//var msg= "Aporta monedas para hacerlo vibrar!<br><strong>Nivel 1</strong>: 100<i class='icon-coin'></i> <small>cosquillitas ricas!!!</small><br><strong class=''>Nivel 2</strong>: 500<i class='icon-coin'></i> <small>Traviesoooooo!!!</small><br><strong class=''>Nivel 3</strong>: 2.000<i class='icon-coin'></i> <small>Me mojas delicioosooo mmmmmmm </small><br><strong class=''>Nivel 4</strong>: 3.000<i class='icon-coin'></i> <small>NO PARES AMOR, ME ENCANTA !!!</small><br>";

setTimeout(function(){ $scope.enviarmensaje() }, 60000);






 };




 $scope.enviarmensajemr = function() {

    console.log("enviarmensajemr juegos.directive.js LADO SERVER");
    var msg ="";
    var x = 0;
    var classMeta = "";
    multiretosService.get(appSettings.USER.id).success(function (res) {

        

      console.log(msg);


   if (Object.keys(res).length > 0){



     
        for (var i in res)
        {
          console.log(res[i].completado);


          if(res[i].completado){

              msg = msg + "<span class='txt__content atv_msg_contentdoneGoal'>Desafio conseguido!<br></span>";

              classMeta = "doneGoal";

          }else{


              msg = msg + "<span class='txt__content atv_msg_content'> ¡Aporta monedas para lograr los desafios!<br></span>";
              classMeta = "currentGoal";

          }
            
             msg =  msg +  "<div class='goal "+classMeta+"'><div class='noty-pill'>DESAFIO "+res[i].posicion+"</div><span class='goalInfo'> <ins class='atv_game_totalcoins'>"+res[i].goal+"<i class='icon-coin'></i></ins></span> <q class='goalInfo-txt atv_info_goal'>"+res[i].task+"</q></div>";

        }
       // msg =  msg + "</span>";



    }

          

              $rootScope.$broadcast('sendMsgMultiretos', msg);

              console.log("mensaje enviadosssdfds");

      });



//var msg= "Aporta monedas para hacerlo vibrar!<br><strong>Nivel 1</strong>: 100<i class='icon-coin'></i> <small>cosquillitas ricas!!!</small><br><strong class=''>Nivel 2</strong>: 500<i class='icon-coin'></i> <small>Traviesoooooo!!!</small><br><strong class=''>Nivel 3</strong>: 2.000<i class='icon-coin'></i> <small>Me mojas delicioosooo mmmmmmm </small><br><strong class=''>Nivel 4</strong>: 3.000<i class='icon-coin'></i> <small>NO PARES AMOR, ME ENCANTA !!!</small><br>";

//setTimeout(function(){ $scope.enviarmensajemr() }, 50000);





 };











        $scope.getToys = function() {

          
          

          $scope.messageText=false;
          $scope.loading=true;
           $scope.messageToy =false;
           $http({
              method : "get",
                url : "https://api.lovense.com/api/lan/getToys"
            }).then(function mySuccess(response) {
              $scope.loading=false;
              if(!Object.keys(response.data).length){
                
                $scope.messageToy =true;
                console.log("No se han detectado dispositivos.");
              }
                console.log(response);
               $scope.items = response.data;



            }, function myError(response) {
              $scope.loading=false;
              console.log(response.statusText);
              
            });
          
    


        };



        $scope.testLovense = function (item,vel=10) {


        var domain= item.domain;

        var httpsPort=  item.httpsPort;

        for (var i in item.toys)
        {
          var id= item.toys[i].id;
        }


          var url = 'https://'+domain+':'+httpsPort+'/Vibrate?t='+id+'&v='+vel;

          console.log(url);


          
          $http({
              method : "get",
                url : url
            }).then(function mySuccess(response) {

              if(!Object.keys(response.data).length){

                alertify.error("Error! no se ha realizado el testo con exito, intente de nuevo", '15');

                console.log("No vibro.");
              }

                console.log(response);

                    if (vel > 0){

                    alertify.success("Test satisfactorio!", '15');
                    setTimeout(function(){ $scope.testLovense(item,0) }, 2000);

                } 


            }, function myError(response) {
              console.log("ocurrio un error: "+response.statusText);
              if (vel > 0) setTimeout(function(){ $scope.testLovense(item,0) }, 2000);
              
            });




        };






        $scope.removeMessage = function(msgId){
        



        };


        $scope.changeTab = function(tab) {
          $scope.chatPanel = tab;
        };








$scope.sendVibracion = function(params) {



        var url = 'https://'+params.domain+':'+params.httpsPort+'/Vibrate?t='+params.id_toy+'&v='+params.vel;

          console.log(url);

          $http({
              method : "get",
                url : url
            }).then(function mySuccess(response) {

              if(!Object.keys(response.data).length){

                alertify.error("Error! no ha vibrado a pesar de que enviaron token, contacte al soporte tecnico", '15');

                console.log("No vibro.");
              }

                console.log(response);

                    if (params.vel > 0){

                    alertify.success("Test satisfactorio!", '15');
                    setTimeout(function(){ $scope.sendVibracion({"domain":params.domain,"httpsPort":params.httpsPort,"id_toy":params.id_toy,"vel":0}) }, 3000);


                } 


            }, function myError(response) {
              console.log("ocurrio un error: "+response.statusText);
              if (params.vel > 0)  setTimeout(function(){ $scope.sendVibracion({"domain":params.domain,"httpsPort":params.httpsPort,"id_toy":params.id_toy,"vel":0}) }, 3000);

              
            });




};















  





    socket.Vibrartip(function (data) {

    console.log("Entro en Vibrartip");
    var vel       = 0;
    var domain    = '';
    var httpsPort = '';
    var id_toy    = '';


console.log($scope.Jugando);
      if($scope.Jugando){

        console.log("deberia enviar vibracion");

          if(data.token==$scope.level1value){
            vel=5;
          }

          if(data.token==$scope.level2value){
            vel=10;
          }

          if(data.token==$scope.level3value){
            vel=15;
          }

          if(data.token==$scope.level4value){
            vel=20;
          }

            for (const [key, value] of Object.entries($scope.toys)) {
               var id_toy = null;

                if (value) {

                    for (var values in $scope.items[key].toys) {                   
                          id_toy = $scope.items[key].toys[values].id;
                    }

                   console.log($scope.items[key].domain);
                   console.log($scope.items[key].httpsPort);
                   console.log(id_toy);


                  $scope.sendVibracion({"domain":$scope.items[key].domain,"httpsPort":$scope.items[key].httpsPort,"id_toy":id_toy,"vel":vel});
        /*  var url = 'https://'+$scope.items[key].domain+':'+$scope.items[key].httpsPort+'/Vibrate?t='+id_toy+'&v='+vel;

          console.log(url);*/







              }
          }


      }
      else{
        console.log("no se enviara vibracion");
      }




     








          console.log($scope.Jugando);

          console.log($scope.level1value);

          console.log("Darwin");
          console.log(data);
          console.log(data.token);
        });


$scope.$on('MostrarLovense', MostrarLovense)

  function MostrarLovense($event, message){
   
     /* $scope.windowsgame=true;
      $scope.windowsgameMr =true;
      $scope.windowsgameRuleta = true;*/

       $scope.$parent.isStreaming = true;

  }





  $scope.$on('FinalizarMultireto', FinalizarMultireto)

  function FinalizarMultireto($event, message){



    

      console.log("finalizar multireto");

       // $scope.windowsgameMr=true;
        $scope.activeJugandoMr ="false";
        $scope.jugandoBtnMr = false;

        $scope.openwindowsgameMr(false);



if( !$scope.jugandoBtnruleta && !$scope.jugandoBtnMr){

    $scope.$parent.Showvideoprivadox = false;
    $scope.$parent.gridChat = 'col-sm-6';

}
 




    
       

  }

// ruleta

        $scope.openwindowsgameRuleta = function (value) {


          $scope.windowsgame=false;
          $scope.BtnShowVibralush = false;

          $scope.loadingOpenwindowsMr=false;
        //  $scope.loadingOpenwindowsRuleta=true;

          if(value){


              $scope.windowsgameRuleta=value;


          }else{
             $location.hash('m-juegos');
              $anchorScroll();
              $scope.loadingOpenwindows=false;
              $scope.windowsgameRuleta=value;
              $scope.BtnShowVibralush = true;

             
          }

        };


$scope.addRuleta = function() {



  if (($scope.input_titulo_value_ruleta && $scope.input_titulo_value_ruleta.length) && ($scope.input_goal_value_ruleta)) {


    if ($scope.taskList_niveluno.length > 12 || $scope.taskList_niveldos.length > 12 || $scope.taskList_niveltres.length > 12) {

      alert("Ha alcanzado el maximo de 12 items por ruleta")
      return;
    }









    if($scope.nivel == "1"  ){
         $scope.ruletaniveluno_name = $scope.input_name_ruleta_value_ruleta;
          $scope.ruletaniveluno_obj = $scope.input_goal_value_ruleta;
         $scope.taskList_niveluno.push({
          titulo: $scope.input_name_ruleta_value_ruleta,
          task: $scope.input_titulo_value_ruleta,
          goal: $scope.input_goal_value_ruleta
        });

    }

    if($scope.nivel == "2" ){

        $scope.ruletaniveldos_name = $scope.input_name_ruleta_value_ruleta;
         $scope.ruletaniveldos_obj = $scope.input_goal_value_ruleta;
        $scope.taskList_niveldos.push({
          titulo: $scope.input_name_ruleta_value_ruleta,
          task: $scope.input_titulo_value_ruleta,
          goal: $scope.input_goal_value_ruleta
        });

    }

    if($scope.nivel == "3" ){

        $scope.ruletaniveltres_name = $scope.input_name_ruleta_value_ruleta;
         $scope.ruletaniveltres_obj = $scope.input_goal_value_ruleta;
        $scope.taskList_niveltres.push({
           titulo: $scope.input_name_ruleta_value_ruleta,
          task: $scope.input_titulo_value_ruleta,
          goal: $scope.input_goal_value_ruleta
        });

    }


$scope.taskList_nivelfull.push({
          titulo: $scope.input_name_ruleta_value_ruleta,
          task: $scope.input_titulo_value_ruleta,
          goal: $scope.input_goal_value_ruleta,
          nivel: $scope.nivel
        });


    $scope.input_titulo_value_ruleta = "";



  } else {

    alert("existen campos vacios ");
  }

}


   $scope.DeleteRuleta = function (nivel) {

    if(nivel == 1  ){
        $scope.taskList_niveluno.splice(this.$index, 1);
    }

    if(nivel == 2 ){
      $scope.taskList_niveldos.splice(this.$index, 1);

    }

    if(nivel == 3 ){
        $scope.taskList_niveltres.splice(this.$index, 1);
       
    }
      

   }





  $scope.guardarJuegosRuleta = function(form){

$scope.$parent.Showvideoprivadox = true;
$scope.$parent.gridChat = 'col-sm-4';
console.log($scope.$parent.Showvideoprivadox);


if ($scope.taskList_niveluno.length == 0){
  alert("Debe agregar al menos un elemento en algún nivel")
  return;
}


if ($scope.taskList_niveluno.length == 13){

alert("No puede tener mas de 12 elementos en una ruleta")
  return;
}


    if (($scope.taskList_niveluno.length >= 1 && $scope.taskList_niveluno.length<4)  || ($scope.taskList_niveldos.length >= 1 && $scope.taskList_niveldos.length<4) || ($scope.taskList_niveltres.length >= 1 && $scope.taskList_niveltres.length<4) ) {

      alert("La cantidad de elementos de la ruleta debe ser mayor a 3")
      return;
    }


console.log($scope.taskList_nivelfull);

    socket.emit('RuletaModel', {
      datos: $scope.taskList_nivelfull,
      datosniveluno: $scope.taskList_niveluno,
      datosniveldos: $scope.taskList_niveldos,
      datosniveltres: $scope.taskList_niveltres,
      userId: appSettings.USER.id,
      roomId: $scope.roomId
 

      

    }, function() {
      

      $location.hash('m-juegos')
         
        $anchorScroll();
     
        $scope.Jugando=true;

              switch($('#idioma').val()) {
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

  // $scope.enviarmensajeRuleta();

    });

    $scope.jugandoBtnruleta = true;
    $scope.windowsgameRuleta=false;
    $scope.windowsgameMr=false;
    $scope.activeJugandoRuleta ="active";
  
    $scope.loadingOpenwindows=false;
    $scope.finalizarBtnMr = false;


  };





        $scope.nivelUpdate = function () {


           if($scope.nivel == 1  ){
              $scope.input_name_ruleta_value_ruleta =  $scope.ruletaniveluno_name;
              $scope.input_goal_value_ruleta = $scope.ruletaniveluno_obj;
          }

          if($scope.nivel == 2 ){
              $scope.input_name_ruleta_value_ruleta =  $scope.ruletaniveldos_name;
              $scope.input_goal_value_ruleta = $scope.ruletaniveldos_obj;
          }

          if($scope.nivel == 3 ){
              $scope.input_name_ruleta_value_ruleta =  $scope.ruletaniveltres_name;
              $scope.input_goal_value_ruleta = $scope.ruletaniveltres_obj;
                
          }
          

        };



  $scope.$on('FinalizarRuleta', FinalizarRuleta)

  function FinalizarRuleta($event, message){



    


  
      socket.emit('finalizarRuleta', {
      userId: appSettings.USER.id,
      roomId: $scope.roomId
 

      

    }, function() {
      

    
      console.log("finalizar FinalizarRuleta");

      
        $scope.activeJugandoRuleta ="false";
        $scope.jugandoBtnruleta = false;

        $scope.openwindowsgameRuleta(false);



        if( !$scope.jugandoBtnruleta && !$scope.jugandoBtnMr){

            $scope.$parent.Showvideoprivadox = false;
            $scope.$parent.gridChat = 'col-sm-6';

        }
 

     

             

    });
       

  }












      }
    };
  }
])