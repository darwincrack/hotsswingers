<?php
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();
/*echo session('lang');
echo "trauccionnnnnnnn";
\App::setLocale(session('lang'));*/

?>
<div class="header">
  <div class="line-menu" >
    <div class="medidas">
      <div class="estilodiv">
        <ul class="estiloul">


<!--Comprobamos si el status esta a true y existe más de un lenguaje-->
@if (config('locale.status') && count(config('locale.languages')) > 1)
               
                    @foreach (array_keys(config('locale.languages')) as $lang)
                        @if ($lang != App::getLocale())
                               <li class="espaciadorli">
                                     <a class="back" href="{{ url('lang', [$lang]) }}"><img width="20px" height="10px" src='{{URL("images/$lang.jpg")}}'>
                                     </a>
                              </li>
                        @endif
                    @endforeach
              
            @endif




            <!--  <li class="espaciadorli">
                  <a class="back" href="{{ url('lang', ['en']) }}"><img width="20px" height="10px" src="{{URL('images/en.jpg')}}"></a>
              </li>

              <li class="espaciadorli">
                    <a class="back" href="{{ url('lang', ['es']) }}"><img width="20px" height="10px" src="{{URL('images/es.jpg')}}"></a>
              </li>

              <li class="espaciadorli">
                    <a class="back" href="{{ url('lang', ['fr']) }}"><img width="20px" height="10px" src="{{URL('images/fr.jpg')}}"></a>
              </li> -->

          </ul>
        </div>
    </div>
  </div>

  <div class="full-container">


    <div class="logo">
      <a href="{{URL('/')}}">
        @if(app('settings')->logo)
        <img src="/uploads/{{app('settings')->logo}}" alt="{{app('settings')->siteName}}"></a>
        @endif
      </a>
    </div>
    <div class="right-header fffff">
      <?php if (!AppSession::isLogin()): ?>
        <div class="login-top">

          {{Form::open(array('method'=>'post', 'url'=>URL('auth/login'), 'class'=>'form-horizontal', 'autocomplete' => 'off' ))}}

          <input class="form-control" autocomplete="off" placeholder="@lang('messages.username')" name="username" type="text">



          <input class="form-control" autocomplete="off" placeholder="@lang('messages.password')" name="password" type="password" value="">



            <input class="btn btn-grey" type="submit" value="@lang('messages.login')">
          {{Form::close()}}
        </div>
        <a href="{{URL('login')}}" class="btn btn-danger button-register visible-xs">@lang('messages.login')</a>
        <a href="{{URL('register')}}" class="btn btn-danger button-register">@lang('messages.register')</a>
      <?php else: ?>
        <div class="profile-top dropdown">

            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="{{AppHelper::getMyProfileAvatar()}}">
              <?php echo $userLogin->username;?>
            </a>

          @if($userLogin->role === 'member')
            <ul class="dropdown-menu" aria-labelledby="dLabel">
              <li><a href="{{URL('members/account-settings')}}"><i class="fa fa-wrench"></i> @lang('messages.accountSettings')</a></li>
              <li><a href="{{URL('messages')}}"><i class="fa fa-envelope-o"></i> @lang('messages.messages') ({{AppHelper::getNotification()}})</a></li>
              <li><a href="{{URL('members/favorites')}}"><i class="fa fa-heart"></i>@lang('messages.myfavorites')</a></li>
              <li><a href="{{URL('members/funds-tokens')}}"><i class="fa fa-money"></i> @lang('messages.fundsOrTokens')</a></li>
            </ul>
          @endif
          @if($userLogin->role === 'model')
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="{{URL('models/dashboard/profile')}}"><i class="fa fa-user" aria-hidden="true"></i> @lang('messages.profile')</a></li>
            <li><a href="{{URL('models/dashboard/account-settings?action=commissions')}}"><i class="fa fa-wrench"></i> @lang('messages.accountSettings')</a></li>
            <li><a href="{{URL('models/dashboard/messages')}}"><i class="fa fa-envelope-o"></i> ( @lang('messages.messages') {{AppHelper::getNotification()}})</a></li>
            <li><a href="{{URL('models/dashboard/chat-settings')}}"><i class="fa fa-cogs"></i> @lang('messages.chatSettings')</a></li>
             <li><a href="{{URL('members/favorites')}}"><i class="fa fa-heart"></i>@lang('messages.myfavorites')</a></li>
              <li><a href="{{URL('members/funds-tokens')}}"><i class="fa fa-money"></i> @lang('messages.fundsOrTokens')</a></li>
          </ul>
          @endif
          @if($userLogin->role === 'studio')
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="{{URL('studio/account-settings')}}"><i class="fa fa-wrench"></i> @lang('messages.accountSettings')</a></li> 
          </ul>
          @endif
          @if($userLogin->role === 'admin')
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="{{URL('admin')}}"><i class="fa fa-wrench"></i>@lang('messages.admindashboard')</a></li>
          </ul>
          @endif
        </div>
        @if($userLogin->role == 'studio')
        <a href="{{URL($userLogin->role.'/logout')}}" class="logout"><i class="fa fa-power-off"></i></a>
        @endif
        @if($userLogin->role == 'member')
        <a href="{{URL('members/logout')}}" class="logout"><i class="fa fa-power-off"></i></a>
        @endif
         @if($userLogin->role == 'model')
        <a href="{{URL('models/logout')}}" class="logout"><i class="fa fa-power-off"></i></a>
        @endif
      <?php endif; ?>
    </div>
  </div>
</div>
