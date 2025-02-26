@extends('frontend')
@section('title', Lang::get('messages.home'))
@section('content')
<div class="content">
  <div class="full-container" ng-controller="modelOnlineCtrl" ng-cloak ng-init="setFilter('Everybody','false')" ng-cloak>
    <div class="banner m20">
      <div class="row">
        <div class="col-md-6 col-xs-12">
            @if(app('settings') && app('settings')->banner != '')
                <a href="{{app('settings')->bannerLink}}"><img src="{{URL(app('settings')->banner)}}?time={{time()}}" width="100%"></a>
            @endif
        </div>

        <div class="col-md-6 col-xs-12">
            @if(app('settings') && app('settings')->bannerdos != '')
                <a href="{{app('settings')->bannerLinkDos}}"><img src="{{URL(app('settings')->bannerdos)}}?time={{time()}}" width="100%"></a>
          @endif
        </div>
      </div> 


        
    </div>     

    <!-- Nav tabs -->
 
  
    <ul class="nav nav-tabs tabs-home" role="tablist">
      <li role="presentation" class="active"><a aria-controls="Everybody" role="tab" data-toggle="tab" ng-click="setFilter('Everybody','false')">@lang('messages.Everybody')</a></li>      <li role="presentation"><a aria-controls="females" role="tab" data-toggle="tab" ng-click="setFilter('female','false')">@lang('messages.females')</a></li>
      <li role="presentation"><a aria-controls="males" role="tab" data-toggle="tab" ng-click="setFilter('male','false')">@lang('messages.males')</a></li>
      <li role="presentation"><a aria-controls="couples" role="tab" data-toggle="tab" ng-click="setFilter('pareja','false')">@lang('messages.couples')</a></li>
      <li role="presentation"><a aria-controls="transsexuals" role="tab" data-toggle="tab" ng-click="setFilter('transgender','false')">@lang('messages.Transsexuals')</a></li>
    </ul>
  
    <!-- Tab panes --> 
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active">
        <ul class="list-model flex-container wrap">
          <li ng-style="styleModelItem" class="col-sm-4 col-md-1-8 flex-item" ng-repeat="(key, item) in users" >

            <div class="box-model">
              <div class="img-model">

                <a href="{{URL('profile')}}/<% item.username %>">
                  <img ng-src="/images/rooms/<% item . lastCaptureImage %>" alt="poster" ng-hide="!item.lastCaptureImage" class="img-responsive" height="130px" ng-mouseover="modelRotates(item)" fallback-src="{{URL('images/64x64.png')}}"/>
                  <img ng-src="<% item.avatar | avatar %>" alt="poster" ng-hide="item.lastCaptureImage" class="img-responsive" height="130px" fallback-src="{{URL('images/64x64.png')}}" />
                </a>


                <a class="a-favoured" title="Favorite" ng-click="setFavorite(key, item.id)"><i class="fa fa-heart" ng-class="{'fa-red': item.favorite, 'fa-white': !item.favorite}"></i></a>

              </div>
              <div class="text-box-model">
                  <a href="{{URL('dashboard/u')}}/<% item.username %>" class="name-model">
                    <% item.username | elipsis: 7 %> 
                    <i class="fa fa-circle" ng-class="{'text-success': item.isStreaming == 1 && item.chatType === 'public', 'text-danger': item.isStreaming == 1 && item.chatType !== 'public','text-warning': item.isStreaming == 0}"> </i> 
                    <span class="pull-right">
                    <!--  <% (item.age != '0' && item.age != null) ? item.age : '' %> -->
                      <i class="fa" ng-class="{'text-default': item.isStreaming, 'text-warning': !item.isStreaming, 'fa-male': item.sex == 'male', 'fa-female': item.sex == 'female', 'fa-user': item.sex == 'fa-user'}"></i> 
                    </span></a>
                   
                    <span class="lovense-item" ng-class=" {'hidden': item.lovense != '1'}">
                      <span class="lovense-text"><i class="icon-lovense-toy-small"></i><strong>VibraLush:</strong></span> 
                       <% item.lovenseTopic | elipsis: 50 %>
                     </span>

                    <span class="lovense-item" ng-class=" {'hidden': item.multiretos != '1'}">
                      <span class="lovense-text"><i class="icon-multiretos-toy-small" ></i><strong>Multireto:</strong></span> 
                       <% item.multiretosTopic | elipsis: 50 %>
                     </span>

                     <div ng-show="item.isStreaming == 1">
                  <span><i class="fa fa-eye"></i> <% item.totalViewer %></span>
                </div>
                    <?php /*
                <div ng-show="item.isStreaming == 1">
                  <span><i class="fa fa-eye"></i> <% item.totalViewer %></span>
                </div>
                */ ?>
                <div class="tag list-model__tag">
                 

                  <% item.status %>
                  <!-- <a href="?q=<% elem %>" class="tag" ng-repeat="(key, elem) in customSplitStringTags(item)">#<% elem %> </a> -->
                </div>  
              </div>
            </div>
          </li>
        </ul>
        <p ng-show="users.length == 0">@lang('messages.modelNotFoundMessageControl')!</p>
        <nav class="text-center">
          <ul class="pagination">  </ul>
        </nav>
      </div>



    </div>

  </div>
</div>
@endsection
