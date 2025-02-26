 <?php
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();

?>

<style> .ossn-notification-container.hidden{visibility: visible !important;} </style>
                <!-- ossn topbar -->
                <div class="topbar">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-2 left-side left">
                                <div class="topbar-menu-left">
                                    <li id="sidebar-toggle" data-toggle="0">
                                        <a role="button" data-target="#"> <i class="fa fa-th-list"></i></a>
                                    </li>
                                </div>
                            </div>
                            <div class="col-md-7 site-name text-center hidden-xs hidden-sm">
                                
                            <div class="logo" style="width: 100%">
                                    @if(App::getLocale()=="" or App::getLocale()=="es")
                                        <a href="{{URL('/')}}" style="padding: 0;">
                                      @else
                                        <a href="{{URL('/'.App::getLocale())}}" style="padding: 0;">
                                      @endif 
                                    @if(app('settings')->logo)
                                    <img src="/uploads/{{app('settings')->logo}}" alt="{{app('settings')->siteName}}" style="width: 145px;"></a>
                                    @endif
                                  </a>
                            </div>
                            </div>
                            <div class="col-md-3 text-right right-side">

                                <div class="topbar-menu-right admin">
                                    <ul>
                                        <li class="ossn-topbar-dropdown-menu">
                                            <div class="dropdown">
                                                <a role="button" data-toggle="dropdown" data-target="#"><i class="fa fa-sort-desc"></i></a>
                                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                    


                                          @if($userLogin->role === 'member')
                                           
                                              <li><a href="{{URL('members/account-settings')}}" class="menu-topbar-dropdown-accountSettings">@lang('messages.accountSettings')</a></li>
                                              <li><a href="{{URL('messages')}}" class="menu-topbar-dropdown-getNotification"> @lang('messages.messages') ({{AppHelper::getNotification()}})</a></li>
                                              <li><a href="{{URL('members/favorites')}}" class="menu-topbar-dropdown-myfavorites">@lang('messages.myFavorites')</a></li>
                                              <li><a href="{{URL('members/funds-tokens')}}" class="menu-topbar-dropdown-fundsOrTokens">@lang('messages.fundsOrTokens')</a></li>

                                              <li><a class="menu-topbar-dropdown-logout" href="{{URL('members/logout')}}">@lang('messages.cerrarsession')</a></li>
                                            
                                          @endif

                                         @if($userLogin->role === 'model')
                                         
                                            <li><a href="{{URL('models/dashboard/profile')}}" class="menu-topbar-dropdown-profile"> @lang('messages.profile')</a></li>
                                            <li><a href="{{URL('models/dashboard/account-settings?action=commissions')}}" class="menu-topbar-dropdown-accountSettings"> @lang('messages.accountSettings')</a></li>
                                            <li><a href="{{URL('models/dashboard/messages')}}" class="menu-topbar-dropdown-messages"> ( @lang('messages.messages') Webcam {{AppHelper::getNotification()}})</a></li>
                                            <li><a href="{{URL('models/dashboard/chat-settings')}}" class="menu-topbar-dropdown-chatSettings">@lang('messages.chatSettings')</a></li>
                                            <li><a href="{{URL('members/favorites')}}" class="menu-topbar-dropdown-myfavorites">@lang('messages.myFavorites')</a></li>
                                              <li><a href="{{URL('members/funds-tokens')}}" class="menu-topbar-dropdown-fundsOrTokens">@lang('messages.fundsOrTokens')</a></li>
                                            <li><a class="menu-topbar-dropdown-logout" href="{{URL('models/logout')}}">@lang('messages.cerrarsession')</a></li>
                                          
                                          @endif

                                          @if($userLogin->role === 'studio')
                                          
                                            <li><a href="{{URL('studio/account-settings')}}" class="menu-topbar-dropdown-accountSettings"> @lang('messages.accountSettings')</a></li>
                                            <li><a class="menu-topbar-dropdown-logout" href="{{URL($userLogin->role.'/logout')}}">@lang('messages.cerrarsession')</a></li> 
                                          
                                          @endif


                                        @if($userLogin->role === 'admin')
                                          
                                            <li><a href="{{URL('admin')}}" class="menu-topbar-dropdown-admindashboard">@lang('messages.admindashboard')</a></li>
                                          
                                          @endif
                                                                                    



                                                </ul>
                                            </div>
                                        </li>
                                        <li id="ossn-notif-friends">
                                            <a onClick="Ossn.NotificationFriendsShow(this);" class="ossn-notifications-friends" href="javascript:void(0);" role="button" data-toggle="dropdown">
                                                <span>
                                                    <span class="ossn-notification-container hidden"></span>
                                                    <div class="ossn-icon ossn-icons-topbar-friends"><i class="fa fa-users"></i></div>
                                                </span>
                                            </a>
                                        </li>
                                        <li id="ossn-notif-messages">
                                            <a onClick="Ossn.NotificationMessagesShow(this)" href="javascript:void(0);" class="ossn-notifications-messages" role="button" data-toggle="dropdown">
                                                <span>
                                                    <span class="ossn-notification-container hidden"></span>
                                                    <div class="ossn-icon ossn-icons-topbar-messages"><i class="fa fa-envelope"></i></div>
                                                </span>
                                            </a>
                                        </li>

                                    <li id="ossn-notif-notification">
                                        <a href="javascript:void(0);" onclick="Ossn.NotificationShow(this)" class="ossn-notifications-notification" role="button" data-toggle="dropdown"> 
                                                <span>
                                                    <span class="ossn-notification-container hidden" style="display: none;"></span>
                                                    <div class="ossn-icon ossn-icons-topbar-notification">
                                                    <i class="fa fa-bell"></i></div>
                                                </span>
                                        </a>
                                     
                                    </li>
                                        <div class="dropdown">
                                            <div class="dropdown-menu multi-level dropmenu-topbar-icons ossn-notifications-box">
                                                <div class="selected"></div>
                                                <div class="type-name">@lang('messages.Notificaciones')</div>
                                                <div class="metadata">
                                                    <div style="height: 66px;">
                                                        <div class="ossn-loading ossn-notification-box-loading"></div>
                                                    </div>
                                                    <div class="bottom-all">
                                                        <a href="#">@lang('messages.Vertodo')</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./ ossn topbar -->