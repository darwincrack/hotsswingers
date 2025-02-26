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

             $scope.$parent.tokensRetos +=  parseInt(res.ganancia);
              $scope.$parent.isShowRetos = true;

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
