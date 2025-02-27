<?php

use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();
?>
<!-- Main Header -->
<header class="main-header">

  <!-- Logo -->
  <a href="{{URL('/admin/dashboard')}}" class="logo">
    @if(app('settings')->logo)
    <img src="/uploads/{{app('settings')->logo}}" alt="{{app('settings')->siteName}}"></a>
    @endif
  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">@lang('messages.togglenavigation')</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="{{ AppHelper::getMyProfileAvatar() }}" class="user-image" alt="Profile"/>
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs">{{$userLogin->username}}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="{{ AppHelper::getMyProfileAvatar() }}" class="img-circle" alt="Profile" />
              <p>
                {{$userLogin->username}} - Web Admin
                <!--<small>Member since Nov. 2012</small>-->
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{URL('admin/manager/profile')}}" class="btn btn-default btn-flat">Perfil</a>
              </div>
              <div class="pull-right">
                <a href="{{URL('admin/logout')}}" class="btn btn-default btn-flat">@lang('messages.signout')</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>   
    </div>
  </nav>
</header>