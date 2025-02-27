<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('blank')
@section('title','Go live')
@section('content')
<div class="container">
  <div class="content">
    <div class="row">
      <div class="col-md-6">
        <div ng-controller="streamCtrl">
          <ul ng-if="videoRequests.length">
            <li ng-repeat="request in videoRequests">
              <span><a ng-href="<% request . requestUrl %>">@lang('messages.anuser') (<% request . from %>)... @lang('messages.sendsaprivatecallrequest')</a></span>
            </li>
          </ul>
          <p>@lang('messages.click') <button ng-click="openBroadcast({{$room}})" class="btn btn-danger">@lang('messages.here')</button> @lang('messages.tostartstreaming')</p>
          <div id="videos-container"></div>
        </div>
      </div>
      <div class="col-md-6">
        <div m-chat-text model-id="{{$modelId}}" chat-type="public" ng-model="streamingInfo" room-id="{{$room}}" member-id="{{$memberId}}"></div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
          var streamOptions = <?= json_encode(isset($streamOptions) ? $streamOptions : null); ?>;
          var PerformerChat = <?php echo AppHelper::getPerformerChat($modelId); ?>;
</script>
@endsection
