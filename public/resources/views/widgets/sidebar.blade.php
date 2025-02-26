 <?php
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();

?>


          <div class="sidebar">
                <div class="sidebar-contents">
                    <div class="newseed-uinfo">
                        <img src="{{AppHelper::getMyProfileAvatar()}}" width="50" height="50" />
 
                        <div class="name">
                            <a href="<?php echo url('dashboard/u/'.$userLogin->username);?>"><?php echo $userLogin->username; ?></a>


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

                                @if($userLogin->role === 'model')

                                      <a class="menu-section-item-a-broadcast" href="{{URL('models/live')}}"><li class="menu-section-item-broadcast">@lang('messages.broadcastYourself')</i></li></a>
                                @endif
                                <a class="menu-section-item-a-quienestadonde" href="{{URL('travel')}}"><li class="menu-section-item-quienestadonde">@lang('messages.quienestadonde')</i></li></a>


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



<form method="get" action="{{URL('dashboard/search')}}">
   
      <input type="submit" class="btn btn-primary" name="submit" value="buscar" style="width: 94%;padding: 3%;margin-left: 3%;">
   
</form>



   
     <div class="text-center" style="    margin-top: 10px;">
         @lang('messages.Selectyourlanguage'):
     </div>
     <ul class="estiloul" style="align-items: center;
    justify-content: center;">
<!--Comprobamos si el status esta a true y existe más de un lenguaje-->
@if (config('locale.status') && count(config('locale.languages')) > 1)
               
                    @foreach (array_keys(config('locale.languages')) as $lang)
                        @if ($lang != App::getLocale())
                               <li class="" style="margin-right: 10px;">
                                     <a class="back" href="{{ url('lang', [$lang]) }}"><img width="30px" height="20px" src='{{URL("images/$lang.jpg")}}'>
                                     </a>
                              </li>
                        @endif
                    @endforeach
              
            @endif
</ul>

                </div>
            </div>