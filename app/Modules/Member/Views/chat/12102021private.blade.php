<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('frontend')
@section('title', 'CAM2CAM')
@section('content')
<div class="content">
  <div class="full-container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>@lang('messages.privateChatTo') {{$model->username}}</h4>
      </div>
      
      <div class="panel-body content chat-box">
        <div class="full-container" ng-controller="streamCtrl" ng-cloak>
          <p class="private-chat-instruction">Al hacer clic en <strong> enviar solicitud de videollamada </strong>, acepta que pagará {{$tokensPerMinute}} tokens por minuto por modelo.</p>
          <div class="row m20">
            <div class="col-sm-6">
              <div class="show-model">
                <!--<img src="{{AppHelper::getProfileAvatar($model->avatar, IMAGE_LARGE)}}" class="img-response" width="100%" ng-hide="isStreaming">-->
                
                <span m-private-chat-video model-id="{{$model->id}}" member-id="{{$user->id}}" room="{{$room}}" virtual-room="{{MD5(time())}}" ng-hide="isStreaming" ng-model="streamingInfo"></span>
              </div>
              <div class="row show-model" >
                <div class="col-sm-6" ng-show="isGroupLive"><a href="{{URL('members/groupchat/'.$model->id)}}" class="btn btn-grey btn-block">Group Chat</a></div>
                <div ng-class="{'col-sm-6': isGroupLive, 'col-sm-12': !isGroupLive}"><a class="btn btn-danger btn-block" ng-click="sendTip({{$room}}, 'private')">Enviar tokens </a></div>
                     <!--  <div class="list-sendTip">
                      <span>Aportar:</span>  <a href="#" ng-click="sendTipDirect({{$room}}, 'public', '100')">100</a> | <a href="#" ng-click="sendTipDirect({{$room}}, 'public', '200')">200</a> | <a href="#" ng-click="sendTipDirect({{$room}}, 'public', '500')">500</a> | <a href="#" ng-click="sendTipDirect({{$room}}, 'public', '1000')">1000</a> | <a href="#" ng-click="sendTipDirect({{$room}}, 'public', '2000')">2000</a>

                      </div> -->


              </div>
              <div class="row">
                <div class="col-sm-12"><a class="btn btn-info btn-block" ng-click="backToFreeChat('{{$model->id}}', '{{URL('profile/'.$model->username)}}')">@lang('messages.Backtofreechat')</a></div>
              </div>
                <div class="col-sm-12" ng-show="streamingInfo.status == 'active'">
                    <h3>@lang('messages.streamingInfo')</h3>
                    <p>@lang('messages.callTimeMemberPrivateChat'): <%streamingInfo.time | minutePlural%></p>
                    <p>@lang('messages.remainingTokenMemberPrivateChat'): <%streamingInfo.tokens%> </p>
                    <p><p>@lang('messages.tokensSpentMemberGroupChat'): <%streamingInfo.spendTokens%></p>
                    
                </div>
                
                <h2 ng-show="!streamingInfo.hasRoom">@lang('messages.privatechatendedpleasereturnto')</h2>
                
            </div>

              <div class="col-sm-6" m-chat-text model-id="{{$model->id}}" ng-model="streamingInfo" chat-type="private" room-id="{{$room}}" member-id="{{$user->id}}" is-streaming="<%isStreaming%>"> 

            </div>
          </div>
          <canvas id="nosignal" ></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var PerformerChat = <?php echo AppHelper::getPerformerChat($model->id); ?>;
</script>
@endsection