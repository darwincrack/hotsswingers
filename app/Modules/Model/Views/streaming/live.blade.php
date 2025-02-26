<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('frontend')
@section('title','Go live')
@section('content')

<style>
  
.switch {
    position: relative;
    display: inline-block;
    width: 43px;
    height: 20px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.sliderswitch {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.sliderswitch:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 4px;
    bottom: 1px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}
input:checked + .sliderswitch {
  background-color: #2196F3;
}

input:focus + .sliderswitch {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .sliderswitch:before {
  -webkit-transform: translateX(17px);
  -ms-transform: translateX(17px);
  transform: translateX(17px);
}

/* Rounded sliders */
.sliderswitch.round {
  border-radius: 34px;
}

.sliderswitch.round:before {
  border-radius: 50%;
}

.game-panel__private-video {
    background-color: #E0E0E0;
    padding: 8px 8px;
    font-size: 12px;
    margin-top: 44px;
}

.show-video-privadox{
  padding: 0;
}
.tooltip {
    position: fixed;
}


#minDonationInputId{
  width: 100%;
}

.participantes .icon-coin{
    width: 16px;
    height: 16px;
    background-image: url(../images/coin.svg);
    margin-left: 3px;
    display: inline-block;
}

button.ajs-button.ajs-ok {
    background-color: #0b769c !important;
    color: #fff !important;
    padding: 5px;
    text-transform: inherit !important;
}

button.ajs-button.ajs-cancel {
    background-color: #868686 !important;
    color: white !important;
    padding: 5px;

    text-transform: inherit !important;
}

.fullscreen-section {
    display: none;
}
</style>


<div ng-controller="streamCtrl">
<div class="content chat-box"  ng-cloak ng-init="initRoom({{$room}}, '{{$virtualRoom}}', '{{$modelId}}');">
  <div class="full-container">
    <div class="row m20">
      <div class="col-sm-6">
        <div class="show-model">
          <!--darwwww<img src="/images/img1.jpg" class="img-response" ng-hide="isStreaming">-->
          <canvas id="canvas" hidden></canvas>






<div ng-show="isShowruletachart && hiddenRuleta" ng-click="showRuleta()">
  <span style="
  position: absolute;
    z-index: 1;
    left: 88.8%;
    top: 40%;
    text-align: center;
    cursor: pointer;
    padding: 7px;
    background: red;
    border-radius: 13px;
    opacity: 1;
    background-color: rgba(33, 33, 33, 0.6);
" title="Juega a LA RULETA HOT!!"><i class="icon-lovense-toy-big ruleta" style="margin-right: 0"></i></span>

</div>

  <div ng-show="isShowruletachart && !hiddenRuleta" ng-click="hideRuleta()">  <i class='fa fa-times' style='position: absolute;
    z-index: 1;
    left: 96.8%;
    top: 11%;
    text-align: center;
    cursor: pointer;'></i></div>
 
  <div id="chart" class="" ng-show="isShowruletachart && !hiddenRuleta"  title="Gira LA RULETA HOT!!" ng-click="clickRuleta()"></div>




          
          <div id="videos-container" room="{{$room}}" style="margin-top: 47px;"></div>
          <div class="fullscreen-section" ng-show="isStreaming">
            <div class="fullscreen-section__inner">
              <div class="transparent-bg"></div>
              <a class="cursor" title="full screen mode" ng-click="showFullScreen()" ng-show="!isFullScreenMode"><i class="fa fa-expand"></i></a>
              <a class="cursor" title="compress screen mode" ng-click="notShowFullScreen()" ng-show="isFullScreenMode"><i class="fa fa-compress"></i></a>
            </div>
          </div>
        </div>


<div class="row" ng-show="isStreaming">
  <div class="col-sm-4"><strong>Total tokens:</strong> <span ><% tokensTotales %></span></div>

  <div class="col-sm-4" ng-show="isShowruletachart"><strong>Tokens Ruleta:</strong> <span><% tokensRuleta %></span></div>


<div class="col-sm-4" ng-show="isShowRetos"><strong>Tokens Retos:</strong> <span><% tokensRetos %></span></div>



</div>
        

        <form ng-submit="updateStatus(form)" name="form">
          <div class="form-group row">
            <div class="col col-md-9"><input class="form-control" type="text" placeholder="@lang('messages.Updateyourstatus')" ng-model="statusForUpdating"/></div>
            <div class="col col-md-3"><input type="submit" value="@lang('messages.update')" class="btn btn-danger btn-block"/></div>
          </div>
        </form>

        <div class="row" ng-class="{'hidden': !isStreaming}">
          
          <div class="col-sm-11 col-md-6 col-md-offset-2 col-xs-10"><button class="btn btn-grey btn-block" ng-click="stopStreaming()">@lang('messages.stopStreaming')</button></div>

          <div class="col-sm-1 col-md-1 col-xs-2">
            <div class="mic" ng-click="mic()"><i class="fa " ng-class="{'fa-microphone': micOn, 'fa-microphone-slash': !micOn}" title=""></i></div>

          </div>

        </div>
        <div class="row" >
          <div class="col-sm-12" >
            <a class="btn btn-danger btn-block" ng-show="!isStreaming" ng-click="openBroadcast({{$room}}, '{{$virtualRoom}}', '{{$modelId}}')">@lang('messages.startStreaming') </a>
          </div>
        </div>
      </div>

      <div class="<% gridChat %>" m-chat-text model-id="{{$modelId}}" chat-type="public" ng-model="streamingInfo" room-id="{{$room}}" member-id="{{$memberId}}">


      </div>

       <div class="col-sm-2 show-video-privadox" ng-show="Showvideoprivadox">
            <div class="game-panel__private-video atv_game_active_panel_mute_video" data-script="PrivateVideoPanel">




                <div class="">
                    <label class="switch">
                        <input type="checkbox"  id="videoPrivadox" ng-model="videoPrivadox" ng-change="changeVideoPrivadox()">
                        <span class="sliderswitch round"></span>
                    </label>
                   
                    <label class="games-switch" for="private-switch">Vídeo privado</label>
                    <a data-toggle="tooltip" data-placement="top"  title="Al poner el video en privado solo podran verlo los usuarios que hayan aportado o aporten luego la cantidad que indiques."><i class="fa fa-question-circle"></i></a>
                </div>


                
                <div class="atv_video_price_selectable">Tokens para ver vídeo privado:</div>
                <div class="select-container select-lighter select__hollow-arrow atv_video_price_selectable">

                  <input type="number" class="form-control ng-pristine ng-valid ng-valid-required ng-touched" ng-disabled="videoPrivadox" id="tokenVideoprivadox" name="tokenVideoprivadox" placeholder="2000" value="2000" ng-model="tokenVideoprivadox" ng-required="true" required="required">
                    
                        
                                               
                </div>

                <span style="display:none" class="form-msg--labeled form-msg--error form-msg--error-spoken video_private_error">Debes seleccionar un precio para el vídeo privado</span>

            </div>
              <div class="participantes">
                
                <p><strong>Participantes:</strong></p>
                <p ng-repeat="x in participantes"><%x.username%> - <%x.tokensprivado%> <i class="icon-coin"></i></p>
              </div>
              


      </div>


        <div class= "col-md-12" m-juegos room-id="{{$room}}" member-id="{{$memberId}}" model-id="{{$modelId}}" id="m-juegos" ng-init="GetAllGames('{{$modelId}}')">

        </div>

    </div>




  </div>
</div>


<div class="container hidden">
  <div class="content">
    <div class="row">
      <div class="col-md-6">
        <div >
          <ul ng-if="videoRequests.length">
            <li ng-repeat="request in videoRequests">
              <span><a ng-href="<% request . requestUrl %>" target="_blank"><font size="3" color="green"><strong>@lang('messages.membersendsaprivatecallrequesclickheretofindoutwho')</font></strong></a></span>
            </li>
          </ul>

        </div>
      </div>
      <div class="col-md-6">

      </div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
                  var streamOptions = <?= json_encode(isset($streamOptions) ? $streamOptions : null); ?>;
                  var PerformerChat = <?php echo AppHelper::getPerformerChat($modelId); ?>;
</script>
@endsection
