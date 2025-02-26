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