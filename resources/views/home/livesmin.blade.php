<?php

use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();

?>
<!DOCTYPE html>
<html lang="en" ng-app="matroshkiApp">
  <head>
    <meta charset="utf-8">
    <title>@yield('title') | {{app('settings')->title}}</title>
    <meta name="Description" CONTENT="{{app('settings')->description}}">
    <meta name="keywords" CONTENT="{{app('settings')->keywords}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{URL('uploads/'.app('settings')->favicon)}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    @if (env('APP_DEBUG'))
    <link type="text/css" href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('css/flexslider.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('css/bootstrap-tagsinput.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('lib/rtc-multi-connection/getHTMLMediaElement.css')}}" rel="stylesheet" />
    <link type="text/css" href="{{asset('css/style.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('css/responsive.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('lib/alertifyjs/build/css/alertify.min.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('lib/alertifyjs/build/css/themes/default.min.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('lib/easy/easy-autocomplete.min.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('lib/jquery-multiple-file-upload/uploadfile.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('lib/jquery-emojiarea-master/jquery.emojiarea.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('lib/jquery-emojiarea-master/fontello/css/fontello.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('lib/select2/dist/css/select2.css')}}" rel="stylesheet">
    @else
    <link type="text/css" href="{{asset('assets/css/frontend.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('assets/css/lib.css')}}" rel="stylesheet">
    @endif
    <script type="text/javascript" src="{{asset('lib/jquery/dist/jquery.min.js')}}"></script>
<link type="text/css" href="{{asset('css/custom.css')}}" rel="stylesheet">
    {!! app('settings')->code_before_head_tag !!}

    <style>
      .full-container {
         padding: 0px 0;
       }

       .content {
        padding: 0px 0px;
        min-height: auto;
    }




.list-model li {
  margin-bottom: 5px;
}

    </style>

    <base target="_parent" />
  </head>
  <body style="margin-bottom: 10px;">


   <div class="content">
  <div class="full-container" ng-controller="modelOnlineCtrl" ng-cloak ng-init="onlineInit('{{Request::get('q')}}')" ng-cloak>
  
    <!-- Tab panes --> 
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active">
        <ul class="list-model flex-container wrap">
          <li ng-style="styleModelItem" class="col-sm-6 col-md-6 col-xs-6 col-md-1-8 flex-item" ng-repeat="(key, item) in users">
            <div class="box-model ocultando<%item.isStreaming%>">
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
                      <span class="lovense-text"><i class="icon-lovense-toy-small" ></i><strong>VibraLush:</strong></span> 
                       <% item.lovenseTopic | elipsis: 50 %>
                     </span>

                     <span class="lovense-item" ng-class=" {'hidden': item.multiretos != '1'}">
                      <span class="lovense-text"><i class="icon-multiretos-toy-small" ></i><strong>Desafio:</strong></span> 
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
                  <!--<a href="?q=<% elem %>" class="tag" ng-repeat="(key, elem) in customSplitStringTags(item)">#<% elem %> </a> -->
                </div>  
              </div>
            </div>
          </li>
        </ul>
        <p ng-show="users.length == 0">@lang('messages.modelNotFoundMessageControl')!</p>

        
      </div>



    </div>

  </div>
</div>

 <input type="hidden" id="idioma" value="{!! App::getLocale()!!}">

    <script type="text/javascript">
      window.appSettings = <?= json_encode([
          'SOCKET_URL' => env('SOCKET_URL'),
          'RTC_URL' => env('RTC_URL'),
          'CHAT_ROOM_ID' => isset($room) ? $room : null,
          'BASE_URL' => BASE_URL,
          'TOKEN' => ($userLogin) ? $userLogin->token : null,
          'LIMIT_PER_PAGE' => LIMIT_PER_PAGE,
          'USER' => !$userLogin ? null : ['id' => $userLogin->id, 'role' => $userLogin->role],
          'TIMEZONE'=> isset(app('userSettings')['timezone']) ? app('userSettings')['timezone'] : null,
          'registerImage' => isset(app('settings')['registerImage']) ? URL(app('settings')['registerImage']) : URL('images/welcome.png'),
          'IP' => $_SERVER['REMOTE_ADDR'],
          'placeholderAvatars' => []
      ]); ?>;
      <?php if(app('settings')->placeholderAvatar1){?>
        window.appSettings.placeholderAvatars.push('<?= app('settings')->placeholderAvatar1; ?>');
      <?php }?>
       <?php if(app('settings')->placeholderAvatar2){?>
        window.appSettings.placeholderAvatars.push('<?= app('settings')->placeholderAvatar2; ?>');
      <?php }?>
       <?php if(app('settings')->placeholderAvatar3){?>
        window.appSettings.placeholderAvatars.push('<?= app('settings')->placeholderAvatar3; ?>');
      <?php }?>
      window.appSettings.TURN_CONFIG = [{"url":"stun:<?= env('TURN_URL'); ?>"},{"url":"turn:<?= env('TURN_URL'); ?>?transport=tcp","username":"<?= env('TURN_USERNAME');?>","credential":"<?= env('TURN_CREDENTIAL');?>"},{"url":"turn:<?= env('TURN_URL'); ?>?transport=udp","username":"<?= env('TURN_USERNAME');?>","credential":"<?= env('TURN_CREDENTIAL');?>"}];
      window.appSettings.ICE_SERVER = {
        url: "<?= env('TURN_URL'); ?>",
        username: "<?= env('TURN_USERNAME');?>",
        credential:"<?= env('TURN_CREDENTIAL');?>"
      };
    </script>
    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{asset('lib/select2/dist/js/select2.min.js')}}"></script>
    @if (env('APP_DEBUG'))
    <script type="text/javascript"  src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/eventEmitter/EventEmitter.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/lodash/lodash.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/json3/lib/json3.min.js')}}"></script>
    <script type="text/javascript"  src="{{asset('lib/jquery-emojiarea-master/jquery.emojiarea.js')}}"></script>
    <script type="text/javascript"  src="{{asset('lib/jquery-emojiarea-master/packs/basic/emojis.js')}}"></script>
    <script src="{{ asset('lib/angular/angular.min.js') }}"></script>
    <script src="{{ asset('lib/angular-cookies/angular-cookies.min.js') }}"></script>
    <script src="{{ asset('lib/angular-sanitize/angular-sanitize.min.js') }}"></script>
    <script src="{{ asset('lib/angular-bootstrap/ui-bootstrap-tpls.min.js') }}"></script>
    <script src="{{ asset('lib/angular-socket-io/socket.min.js') }}"></script>
    <script src="{{ asset('lib/socketio/socket.io-1.4.5.js') }}"></script>
    <script src="{{ asset('lib/rtc-multi-connection/RTCMultiConnection.js') }}"></script>
    <script src="{{ asset('lib/rtc-multi-connection/adapter.js') }}"></script>
    <script src="{{ asset('lib/rtc-multi-connection/getHTMLMediaElement.js') }}"></script>
    <script src="{{ asset('lib/alertifyjs/build/alertify.js') }}"></script>
    <script src="{{ asset('lib/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('lib/moment-timezone/moment-timezone.js') }}"></script>
    <script src="{{ asset('lib/moment-timezone/moment-timezone-utils.js') }}"></script>
    <script src="{{ asset('lib/moment-timezone/moment-timezone-utils.js') }}"></script>
    <script src="{{ asset('lib/jssor/js/jssor.slider.min.js') }}"></script>
    <script src="{{ asset('lib/easy/jquery.easy-autocomplete.js') }}"></script>
    <script src="{{ asset('lib/video-js/video.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('lib/jquery/src/site.js')}}"></script>
    <script src="{{asset('lib/angularlazyimg/release/angular-lazy-img.js')}}"></script>
    <script src="{{ asset('lib/jquery-multiple-file-upload/jquery.uploadfile.min.js') }}"></script>
    <script src="{{ asset('app/adapter.js') }}"></script>
    <script src="{{ asset('app/app.js') }}"></script>
    <script src="{{ asset('app/components/common.js') }}"></script>
    <script src="{{ asset('app/filters/filter.js') }}"></script>
    <script src="{{ asset('app/services/user.service.js') }}"></script>
    <script src="{{ asset('app/services/auth.service.js') }}"></script>
    <script src="{{ asset('app/services/chat.service.js') }}"></script>
    <script src="{{ asset('app/services/socket.service.js') }}"></script>
    <script src="{{ asset('app/services/peer.service.js') }}"></script>
    <script src="{{ asset('app/services/video-stream.service.js') }}"></script>
    <script src="{{ asset('app/services/chat-settings.service.js') }}"></script>
    <script src="{{ asset('app/services/likes-widget.service.js') }}"></script>
    <script src="{{ asset('app/services/online.service.js') }}"></script>
    <script src="{{ asset('app/services/gallery.service.js') }}"></script>
    <script src="{{ asset('app/services/video.service.js') }}"></script>
    <script src="{{ asset('app/services/schedule.service.js') }}"></script>
    <script src="{{ asset('app/services/media.service.js') }}"></script>
    <script src="{{ asset('app/services/country.service.js') }}"></script>
    <script src="{{ asset('app/services/category.service.js') }}"></script>
    <script src="{{ asset('app/services/earning.service.js') }}"></script>
    <script src="{{ asset('app/services/payout.service.js') }}"></script>
    <script src="{{ asset('lib/tag-input/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('app/services/product.service.js') }}"></script>
    <script src="{{ asset('app/services/order.service.js') }}"></script>

    <script src="{{ asset('app/controllers/chat-settings.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/stream.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-profile-image.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-video.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-profile.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-create-gallery.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-edit-gallery.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-image-gallery.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-image-galleries.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-video-galleries.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-video-gallery.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-video-upload.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-setting.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-schedule.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-earning.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/chat-settings.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/stream.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/likes-widget.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/ModelOnline.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/media.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/payment.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/payout/model-request.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/model-manage-product.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/product/buy.controller.js') }}"></script>
    <script src="{{ asset('app/controllers/product/order-tracking.controller.js') }}"></script>
    <script src="{{ asset('app/directives/app-directive.js') }}"></script>
    <script src="{{ asset('app/directives/stream-video-player.directive.js') }}"></script>
    <script src="{{ asset('app/directives/convert-to-number/convert-to-number.js') }}"></script>
    <script src="{{ asset('app/directives/chat-text.directive.js') }}"></script>
    <script src="{{ asset('app/directives/private-chat-video.directive.js') }}"></script>
    <script src="{{ asset('app/directives/group-chat-video.directive.js') }}"></script>
    <script src="{{ asset('app/directives/upload-file/upload-file.js') }}"></script>
    <script src="{{ asset('app/directives/multiple-upload/multiple-upload.js') }}"></script>
    <script src="{{ asset('app/directives/check-user-online.directive.js') }}"></script>
    
    <script src="{{ asset('app/modals/register-modal/register-modal-controller.js') }}"></script>
    <script src="{{ asset('app/modals/transaction/transaction-popup-controller.js') }}"></script>
    <script src="{{ asset('app/modals/model-multiple-upload/model-multiple-upload-modal-controller.js') }}"></script>
    @else
    <script type="text/javascript"  src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/eventEmitter/EventEmitter.min.js')}}"></script>
    <script src="{{ asset('assets/js/angular.js') }}"></script>
    <script type="text/javascript" src="{{asset('lib/lodash/lodash.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/json3/lib/json3.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/angularlazyimg/release/angular-lazy-img.js')}}"></script>
    <script src="{{ asset('assets/js/lib.js') }}"></script>
    <script type="text/javascript"  src="{{asset('lib/jquery-emojiarea-master/jquery.emojiarea.js')}}"></script>
    <script type="text/javascript"  src="{{asset('lib/jquery-emojiarea-master/packs/basic/emojis.js')}}"></script>
    <script src="{{ asset('assets/js/app.js') }}?v=<?= env('BUILD_VERSION');?>"></script>
    <script type="text/javascript" src="{{asset('app/filters/filter.js')}}?v=<?= env('BUILD_VERSION');?>"></script>
    <script src="{{ asset('assets/js/service.js') }}?v=<?= env('BUILD_VERSION');?>"></script>
    <script src="{{ asset('assets/js/controller.js') }}?v=<?= env('BUILD_VERSION');?>"></script>
    <script src="{{ asset('assets/js/directive.js') }}?v=<?= env('BUILD_VERSION');?>"></script>
    <script type="text/javascript" src="{{asset('lib/jquery/src/site.js')}}?v=<?= env('BUILD_VERSION');?>"></script>
    <script src="{{ asset('assets/js/modal.js') }}?v=<?= env('BUILD_VERSION');?>"></script>
    @endif

    <script src="{{ asset('assets/js/iframeResizer.min.js') }}?v=<?= env('BUILD_VERSION');?>"></script>

    @yield('scripts')
    <script type="text/javascript">
      $(document).ready(function () {
        $('.menu ul li a.menu-category').click(function () {
          $('.menu ul li ul').toggle();
        });
        $('.toggle-menu').click(function () {
          $('.menu').toggle();
          return false;
        });
        $('.button-login').click(function () {
          $('.login-top').toggle();
          return false;
        });
        $('.menu-left-account').click(function () {
          $('.menu-account ul').toggle();
          return false;
        });
        $('.left_nav button').click(function () {
          $('.left_nav .user_navigation.collapsed').toggle();
        });
        $('.btn-switch').hover(function(){
          $(this).parent().find('.btn-switch').addClass('btn-remove-background');
          $(this).removeClass('btn-remove-background');
          $(this).addClass('btn-active');
        }, function(){
          $(this).parent().find('.btn-switch').removeClass('btn-remove-background');
          $(this).parent().find('.btn-switch').removeClass('btn-active');
        });
        $('.btn-switch input').change(function(){
          var value = $(this).val();
          if(value === 'studio') {
            $('.register__studio-field').show();
            $('.register__user-field').hide();
          }else{
            $('.register__studio-field').hide();
            $('.register__user-field').show();
          }
        });
        $(".withdraw-studio-payee").change(function(){
          var withdrawType = $(this).val();
          $('.payee-payment-box-type').addClass('hidden');
          $('.'+withdrawType+'-payee-payment').removeClass('hidden');
        });
          $('input.tag-input').tagsinput({});
      });
    </script>
    {!! app('settings')->code_before_body_tag !!}
  </body>
  @include('alerts.index')
</html>