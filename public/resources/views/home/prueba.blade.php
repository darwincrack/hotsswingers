<?php
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();


?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta https-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Mensajes : implik-2.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="{{URL('uploads/'.app('settings')->favicon)}}" type="image/x-icon" />

        <!-- 
	Open Source Social Network (Ossn) httpss://www.opensource-socialnetwork.org/     
	BY Informatikon Technologies (https://informatikon.com/)
	BY SOFTLAB24 (httpss://www.softlab24.com/)
	-->
        <link type="text/css" href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
        <link type="text/css" href="{{asset('css/ossn-default.css')}}" rel="stylesheet">


        @if ("es" == App::getLocale())
            <script src="{{asset('lib/ossn/ossn.es.language.js')}}"></script>
        @elseif ("en" == App::getLocale())
            <script src="{{asset('lib/ossn/ossn.en.language.js')}}"></script>

        @elseif ("fr" == App::getLocale())
            <script src="{{asset('lib/ossn/ossn.fr.language.js')}}"></script>
        @else
            <script src="{{asset('lib/ossn/ossn.es.language.js')}}"></script>

        @endif

      

        <script type="text/javascript" src="{{asset('lib/jquery/dist/jquery.min.js')}}"></script>

        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

        <script src="{{URL('dashboard/vendors/jquery/jquery-arhandler-1.1-min.js')}}"></script>

        <script src="{{URL('dashboard/components/OssnAutoPagination/vendors/jquery.scrolling.js')}}"></script>

        <script src="{{asset('lib/ossn/opensource.socialnetwork.js')}}"></script>
        <script src="{{asset('lib/ossn/ossn.chat.js')}}"></script>
  
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
 

        <script type="text/javascript"  src="{{asset('js/bootstrap.min.js')}}"></script>

        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery-ui.css" />
        <script></script>

        <script>


            Ossn.site_url = "{{URL('dashboard/')}}/";
            Ossn.Config = { token: { ossn_ts: {{rand(1111111111,9999999999)}}, ossn_token: "{{ csrf_token() }}" }, cache: { last_cache: "87fd8e72", ossn_cache: "1" } };
            Ossn.Init();
            $(document).ready(function () {
                setInterval(function () {
                    Ossn.NotificationsCheck();
                }, 5000 * 12);
            });
        </script>
    </head>

    <body>
        <div class="ossn-page-loading-annimation">
            <div class="ossn-page-loading-annimation-inner">
                <div class="ossn-loading"></div>
            </div>
        </div>

        <div class="ossn-halt ossn-light"></div>
        <div class="ossn-message-box"></div>
        <div class="ossn-viewer" style="display: none;"></div>

        <div class="opensource-socalnetwork">
            <div class="sidebar">
                <div class="sidebar-contents">
                    <div class="newseed-uinfo">
                        <img src="https://xcams.192.168.0.100.nip.io/dashboard/avatar/admin/small/22f64f3a95d71a789227ec734b4c6910.jpeg" />

                        <div class="name">
                            <a href="<?php echo url('dashboard/u/'.$userLogin->username);?>"><?php echo $userLogin->firstName." ".$userLogin->lastName;?></a>


                                @if($userLogin->role === 'member')
                                    <a class="edit-profile" href="{{URL('members/account-settings')}}"> @lang('messages.EditarPerfil')</a>
                                @endif
                                @if($userLogin->role === 'model')
                                     <a class="edit-profile" href="{{URL('models/dashboard/profile')}}"> @lang('messages.EditarPerfil')</a>
                                @endif
                                @if($userLogin->role === 'studio')
                                    <a class="edit-profile" href="{{URL('studio/account-settings')}}"> @lang('messages.EditarPerfil')</a>
                                @endif
                                @if($userLogin->role === 'admin')
                                     <a class="edit-profile" href="{{URL('admin')}}"> @lang('messages.EditarPerfil')</a>

                                @endif

                        </div>
                    </div>
                    <div class="sidebar-menu-nav">
                        <div class="sidebar-menu">
                            <ul id="menu-content" class="menu-content collapse out">
                                <li data-toggle="collapse" data-target="#807765384d9d5527da8848df14a4f02f" class="menu-section-links collapsed active in" style="display: block;visibility: visible;">
                                    <a class="" href="javascript:void(0);"><i class="fa fa-newspaper-o fa-lg"></i>@lang('messages.Enlaces')<span class="arrow"></span></a>
                                </li>
                                <ul class="sub-menu collapse in" id="807765384d9d5527da8848df14a4f02f" class="menu-section-items-links">
                                    <a class="menu-section-item-a-newsfeed" href="{{URL('dashboard/home')}}"><li class="menu-section-item-newsfeed">@lang('messages.Noticias')</li></a>
                                    <a class="menu-section-item-a-friends" href="{{URL('dashboard/u/admin/friends')}}"><li class="menu-section-item-friends">@lang('messages.Amigos')</li></a>
                                    <a class="menu-section-item-a-photos" href="{{URL('dashboard/u/admin/photos')}}"><li class="menu-section-item-photos">@lang('messages.Fotos')</li></a>
                                    <a class="menu-section-item-a-notifications" href="{{URL('dashboard/notifications/all')}}"><li class="menu-section-item-notifications">@lang('messages.Notificaciones')</li></a>
                                    <a class="menu-section-item-a-messages" href="{{URL('dashboard/messages/all')}}"><li class="menu-section-item-messages">@lang('messages.Mensajes')</li></a>
                                    <a class="menu-section-item-a-lives" href="{{URL('lives')}}"><li class="menu-section-item-lives">lives</li></a>
                                    <a class="menu-section-item-a-invite-friends" href="{{URL('dashboard/invite')}}"><li class="menu-section-item-invite-friends">@lang('messages.Invitaramigos')</li></a>
                                </ul>
                                <li data-toggle="collapse" data-target="#1471e4e05a4db95d353cc867fe317314" class="menu-section-groups collapsed active" style="display: block;visibility: visible;">
                                    <a class="" href="javascript:void(0);"><i class="fa fa-users fa-lg"></i>@lang('messages.Grupos')<span class="arrow"></span></a>
                                </li>
                                <ul class="sub-menu collapse" id="1471e4e05a4db95d353cc867fe317314" class="menu-section-items-groups">
                                    <a id="ossn-group-add" class="menu-section-item-a-addgroup" href="javascript:void(0);"><li class="menu-section-item-addgroup">@lang('messages.AgregarGrupo')</li></a>
                                    <a class="menu-section-item-a-allgroups" href="{{URL('dashboard/search?type=groups&amp;q=')}}"><li class="menu-section-item-allgroups">@lang('messages.Grupos')</li></a>
                                </ul>
                            </ul>
                        </div>
                    </div>


                    <form class="ossn-form ossn-search" autocomplete="off" method="get" action="{{URL('dashboard/search')}}" enctype="multipart/form-data"> 
                        <fieldset><input type="text" name="q" placeholder="Buscar" onblur="if (this.value=='') { this.value=Ossn.Print('ossn:search'); }" onFocus="if (this.value==Ossn.Print('ossn:search')) { this.value='' };" /></fieldset>
                    </form>
                </div>
            </div>
            <div class="ossn-page-container">
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
                                
                            <div class="logo">
                                  <a href="{{URL('/')}}" style="padding: 0;">
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
                                              <li><a href="{{URL('members/favorites')}}" class="menu-topbar-dropdown-myfavorites">@lang('messages.myfavorites')</a></li>
                                              <li><a href="{{URL('members/funds-tokens')}}" class="menu-topbar-dropdown-fundsOrTokens">@lang('messages.fundsOrTokens')</a></li>

                                              <li><a class="menu-topbar-dropdown-logout" href="{{URL('members/logout')}}">@lang('messages.cerrarsession')</a></li>
                                            
                                          @endif

                                         @if($userLogin->role === 'model')
                                         
                                            <li><a href="{{URL('models/dashboard/profile')}}" class="menu-topbar-dropdown-profile"> @lang('messages.profile')</a></li>
                                            <li><a href="{{URL('models/dashboard/account-settings?action=commissions')}}" class="menu-topbar-dropdown-accountSettings"> @lang('messages.accountSettings')</a></li>
                                            <li><a href="{{URL('models/dashboard/messages')}}" class="menu-topbar-dropdown-messages"> ( @lang('messages.messages') Webcam {{AppHelper::getNotification()}})</a></li>
                                            <li><a href="{{URL('models/dashboard/chat-settings')}}" class="menu-topbar-dropdown-chatSettings">@lang('messages.chatSettings')</a></li>
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
                                            <a href="javascript:void(0);" onClick="Ossn.NotificationShow(this)" class="ossn-notifications-notification" onClick="Ossn.NotificationShow(this)" role="button" data-toggle="dropdown">
                                                <span>
                                                   <!-- <span class="ossn-notification-container">3</span> -->
                                                    <div class="ossn-icon ossn-icons-topbar-notifications-new"><i class="fa fa-globe"></i></div>
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
                <div class="ossn-inner-page">
                    <div class="container">
                        <div class="row">
                            <div class="ossn-system-messages">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="ossn-system-messages-inner"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="ossn-layout-media">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="content">

                                            que se pueda escribir
                                            <div class="row message-none">
                                                <div class="col-md-12">@lang('messages.Ustednotieneningunmensaje')</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="page-sidebar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer>
                            <div class="col-md-11">
                                <div class="footer-contents">
                                    <div class="ossn-footer-menu">
                                        <a class="menu-footer-a_copyrights" href="https://xcams.192.168.0.100.nip.io/dashboard/">&copy; COPYRIGHT implik-2.com</a>
                                        <a class="menu-footer-about" href="https://xcams.192.168.0.100.nip.io/dashboard/site/about">Acerca de</a>
                                        <a class="menu-footer-site" href="https://xcams.192.168.0.100.nip.io/dashboard/site/terms">Términos y Condiciones</a>
                                        <a class="menu-footer-privacy" href="https://xcams.192.168.0.100.nip.io/dashboard/site/privacy">Privacidad</a>
                                        <a class="menu-footer-powered" href="httpss://www.opensource-socialnetwork.org/">Powered by the Open Source Social Network.</a>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
        <div id="theme-config" class="hidden" data-desktop-cover-height="200" data-minimum-cover-image-width="1040"></div>
        <div class="ossn-chat-base hidden-xs hidden-sm">
            <div class="ossn-chat-bar">
                <div class="friends-list">
                    <div class="ossn-chat-tab-titles">
                        <div class="text">Chat</div>
                    </div>

                   
                </div>
                <div class="inner friends-tab">
                    <div class="ossn-chat-icon">
                        <div class="ossn-chat-inner-text ossn-chat-online-friends-count">
                            Chat (<span>0</span>)
                        </div>
                    </div>
                </div>
            </div>

            <div class="ossn-chat-containers"></div>
        </div>
        <div class="ossn-chat-windows-long">
            <div class="inner">
                <div class="ossn-chat-none">@lang('messages.Nadieestaenlinea')</div>
                <script>
                    Ossn.ChatBoot();
                </script>
            </div>
        </div>
    </body>
</html>
