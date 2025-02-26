<?php

use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();
?>
<!DOCTYPE html>
<html lang="{!! App::getLocale()!!}" ng-app="matroshkiApp">
  <head>
    <meta charset="utf-8">
    <title> {{app('settings')->title}}</title>
    <meta name="Description" CONTENT="{{app('settings')->description}}">
    <meta name="keywords" CONTENT="{{app('settings')->keywords}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{URL('uploads/'.app('settings')->favicon)}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->

    <link type="text/css" href="{{asset('assets/css/frontend.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('assets/css/lib.css')}}" rel="stylesheet">
     <link type="text/css" href="{{asset('css/ossn-default.css')}}" rel="stylesheet">
      <link type="text/css" href="{{asset('css/custom.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('lib/jquery/dist/jquery.min.js')}}"></script>
    @if(env('ANALYTICS_TRACKING_ID'))
        {!! Analytics::render() !!}  
    @endif
    {!! app('settings')->code_before_head_tag !!}


  </head>
  <body class="ossn-layout-startup-background">
<div class="topbar">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5 left-side left">

     

      </div>
      <div class="col-md-2 site-name text-center ">
          <div class="logo">
              @if(App::getLocale()=="" or App::getLocale()=="es")
                <a href="{{URL('/')}}" style="padding: 0;">
              @else
                <a href="{{URL('/'.App::getLocale())}}" style="padding: 0;">
              @endif 
          @if(app('settings')->logo)
            <img src="/uploads/{{app('settings')->logo}}" alt="{{app('settings')->siteName}}">
          @endif
        </a>
          </div> 
      </div>
      <div class="col-md-5 text-right right-side">
        <div class="topbar-menu-right">
          <ul>
          <li class="ossn-topbar-dropdown-menu">
            <div class="dropdown">
                        </div>
          </li>                
                    </ul>
        </div>
      </div>
    </div>
  </div>
</div>

 


<div class="content">
  <div class="container">
  <div class="panel panel-default">
    <div class="panel-heading"><h4>@lang('messages.login')</h4>

    </div>
    <div class="panel-body">
        <div class="row">
          <div class="col-md-6 col-sm-offset-3">
            <div class="form_block">
              @if(session('msgError'))<div class=" col-md-9  col-md-offset-3 alert alert-danger"><i class="fa fa-times-circle"></i> {{session('msgError')}}</div>@endif
              
                {{Form::open(array('method'=>'post', 'url'=>URL('auth/login'), 'class'=>'form-horizontal', 'autocomplete' => 'off' ))}}
                <div class="form-group">
                  <label for="email" class="col-sm-3 control-label input-lg">@lang('messages.username')</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" value="{{old('username')}}" id="email" name="username" type="text" placeholder="@lang('messages.username')" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label for="passw1" class="col-sm-3 control-label input-lg">@lang('messages.password')</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" id="passw1" name="password" type="password" placeholder="@lang('messages.password')" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-6 col-sm-push-3">
                    <label class="checkbox-inline">
                      <input id="inlineCheckbox1" value="option1" checked="" type="checkbox"> @lang('messages.rememberMe')  
                    </label>
                  </div>
                  <div class="col-xs-6 col-sm-6 text-right f_pwd">
                    <a id="checkForgotPassword" href="javascript:void(0);">@lang('messages.forgotPass')?</a>
                  </div>
                </div>
                <div class="form-group" id="load-from-rest-pw" style="display: none">
                  <div class="col-sm-9 col-sm-offset-3">
                    <span id ="required" class="required label label-danger"></span>
                    <div class="input-group">
                      <input type="email" id="emailReset" name='emailReset' class="form-control input-lg" placeholder="@lang('messages.Enteremailaccount')" >
                      <span class="input-group-addon btn btn-dark btn-lg btn-block" id="frm-reset-send">@lang('messages.send')</span>
                    </div>

                  </div>
                </div>
                <div class="form-group text-center bottom-button-wrap">
                  <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn btn-dark btn-lg btn-block">@lang('messages.login')</button>
                  </div>
                </div>
              {{Form::close()}}
              <div class="clearfix"></div>
              <div class="sosial_reg col-sm-9 col-sm-offset-3 text-center">
                <h4 class="text-center">@lang('messages.orLoginWith')</h4>
                <ul>
                  <li  class="col-md-4 col-xs-4"><a href="{{ route('social.login', ['twitter']) }}"><i class="fa fa-twitter fa-3x"></i></a></li>
                  <li  class="col-md-4 col-xs-4"><a href="{{ route('social.login', ['facebook']) }}"><i class="fa fa-facebook-official fa-3x"></i></a></li>
                  <li  class="col-md-4 col-xs-4"><a href="{{ route('social.login', ['google']) }}"><i class="fa fa-google-plus fa-3x"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>     <!-- content end-->









    <!-- content end-->

    <!-- content end-->

     <footer class="text-center">
                            <div class="col-md-12">
                                <div class="footer-contents">
                                    <div class="ossn-footer-menu">

                                        <a href="{{URL('/')}}">&COPY; COPYRIGHTtt {{app('settings')['siteName']}} </a>

                                          @foreach( app('pages') as $page )
                                              @if(App::getLocale() == '')

                                                  @if($page->idioma == 'es')

                                                      <a href="{{URL('pag/'.$page->alias)}}">{{$page->title}}</a>

                                                  @endif
                                              @else
                                                  @if($page->idioma == App::getLocale())
                                                        @if(App::getLocale() == 'es')
                                                            <a href="{{URL('pag/'.$page->alias)}}">{{$page->title}}</a>

                                                        @else
                                                            <a href="{{URL(App::getLocale().'/pag/'.$page->alias)}}">{{$page->title}}</a>

                                                        @endif

                                                                 
                                                  @endif

                                              @endif

                                           @endforeach
                                           <a href="{{URL('blog')}}">Blog</a> 

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="background: black; color: white; padding: 10px;">
                              
                              <ul class="estiloul" style="align-items: center;
                                  justify-content: center;">
                                 
                                   <li>
                                     @lang('messages.Selectyourlanguage'): 
                                   </li>
                           @if (config('locale.status') && count(config('locale.languages')) > 1)
               
                    @foreach (array_keys(config('locale.languages')) as $lang)
                        @if ($lang != App::getLocale())
                               <li class="" style="margin-right: 10px; margin-left: 3px;">
                                     <a class="back" href="{{ url('lang', [$lang]) }}"> <img width="30px" height="15px" src='{{URL("images/$lang.jpg")}}'>
                                     </a>
                              </li>
                        @endif
                    @endforeach
              
            @endif
                              </ul>
                            </div>
                        </footer>

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