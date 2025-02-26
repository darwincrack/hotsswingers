<?php

use App\Helpers\Helper as AppHelper;
use App\Helpers\Session as AppSession;

if (AppSession::isLogin())
  $user = AppSession::getLoginData();
if (!empty(AppHelper::getMemberinfo($user->id))) {
  $member = AppHelper::getMemberinfo($user->id);
}
?>
@extends('frontend')
@section('title','Account Settings')
@section('content')
<div class="content">
  <div class="full-container">
    <div class="row">
      <div class="col-sm-4 col-md-2 col-xs-12">
        <div class="menu-account">
          <a href="#" class="btn btn-grey btn-block menu-left-account"><i class="fa fa-bars"></i> @lang('messages.timezone')@lang('messages.menuAccount')</a>
          <ul>

 @if(trim($user->accountStatus) == "waiting")
            <li><a class="{{ Request::is('models/dashboard/account-settings?action=documents*') ? 'active' : '' }}" href="{{URL('models/dashboard/account-settings?action=documents')}}" style="background: #DB4437"><i class="fa fa-check"></i> @lang('messages.documents')</a></li>

@endif

            <li><a class="{{ Request::is('models/dashboard/profile*')? 'active' : '' }}" href="{{URL('models/dashboard/profile')}}"><i class="fa fa-user"></i> @lang('messages.profile')</a></li>


            <li><a class="{{ Request::is('members/funds-tokens') ? 'active' : '' }}" href="{{URL('members/funds-tokens')}}"><i class="fa fa-money"></i>  @lang('messages.fundsOrTokens')</a></li>

  <li><a class="{{ Request::is('models/dashboard/earnings') ? 'active' : '' }}" href="{{URL('models/dashboard/earnings')}}"><i class="fa fa-money"></i>@lang('messages.earnings')</a></li>

 <li><a class="{{ 
                  (Request::is('models/dashboard/messages*')) ? 
                  'active' : '' }}" href="{{URL('models/dashboard/messages')}}">
                <i class="fa fa-envelope-o"></i> @lang('messages.messages') ({{AppHelper::getNotification()}})</a></li>


 <li>
              <a class="{{ Request::is('models/dashboard/payouts/requests*') ? 'active' : '' }}" href="{{URL('models/dashboard/payouts/requests')}}"><i class="fa fa-money"></i>@lang('messages.payoutRequests')</a>
            </li>

            <li><a class="{{ Request::is('models/dashboard/account-settings')? 'active' : '' }}" href="{{URL('models/dashboard/account-settings?action=commissions')}}"><i class="fa fa-wrench"></i>@lang('messages.accountSettings')</a></li>

                      <li><a class="{{ Request::is('models/dashboard/travel*') ? 'active' : '' }}" href="{{URL('models/dashboard/travel')}}"><i class="fa fa-location-arrow"></i> @lang('messages.quienestadonde')</a></li>
            
             <li><a class="{{ Request::is('members/promocion')? 'active' : '' }}" href="{{URL('members/promocion')}}"><i class="fa fa-globe"></i> @lang('messages.promocion')</a></li>

            <li><a class="{{ Request::is('models/dashboard/schedule*') ? 'active' : '' }}" href="{{URL('models/dashboard/schedule')}}"><i class="fa fa-clock-o"></i> @lang('messages.schedules')</a></li>
            <li><a class="{{ Request::is('models/dashboard/chat-settings')? 'active' : '' }}" href="{{URL('models/dashboard/chat-settings')}}"><i class="fa fa-cogs"></i>@lang('messages.chatSettings')</a></li>
            <li><a class="{{ (Request::is('*media/video-galleries') || Request::is('*media/videos') || Request::is('*media/view-video*') || Request::is('*media/edit-video*') || Request::is('*/media/add-video-gallery*'))? 'active' : '' }}" href="{{URL('models/dashboard/media/videos')}}"><i class="fa fa-video-camera"></i> @lang('messages.vendervideos')</a></li>
            <li><a class="{{ (Request::is('*media/image-galleries') || Request::is('*media/image-gallery*') || Request::is('*media/edit-image-gallery*') || Request::is('*media/add-image-gallery*'))? 'active' : '' }}" href="{{URL('models/dashboard/media/image-galleries')}}"><i class="fa fa-camera"></i> @lang('messages.venderimagenes')</a></li>
            <li>
              <a class="{{ Request::is('models/dashboard/products') ? 'active' : '' }}" href="{{URL('models/dashboard/products')}}"><i class="fa fa-list"></i>@lang('messages.venderproductos')</a>
            </li>

            <li><a class="{{ Request::is('models/dashboard/geo-blocking')? 'active' : '' }}" href="{{URL('models/dashboard/geo-blocking')}}"><i class="fa fa-map-marker" aria-hidden="true"></i> GEO Blocking</a></li>




            
           
            <li><a class="{{ Request::is('members/favorites') ? 'active' : '' }}" href="{{URL('members/favorites')}}"><i class="fa fa-heart"></i> @lang('messages.myFavoritesMemberControl')</a></li>
           
            <li><a class="{{ Request::is('members/transaction-history')? 'active' : '' }}" href="{{URL('members/transaction-history')}}"><i class="fa fa-history"></i>  @lang('messages.transactionHistory')</a></li>
            <li><a class="{{ Request::is('members/payment-tokens-history')? 'active' : '' }}" href="{{URL('members/payment-tokens-history')}}"><i class="fa fa-history"></i> @lang('messages.paymenttokenshistory')</a></li>


           
            <li>
              <a class="{{ Request::is('models/dashboard/products/orders') ? 'active' : '' }}" href="{{URL('models/dashboard/products/orders')}}"><i class="fa fa-list"></i>@lang('messages.purchasedItems')</a>
            </li>

            <li><a class="{{ Request::is('*/purchased/images') ? 'active' : '' }}" href="{{URL('members/purchased/images')}}"><i class="fa fa-history"></i> @lang('messages.purchasedImages')</a></li>
            <li><a class="{{ Request::is('members/purchased/videos')? 'active' : '' }}" href="{{URL('members/purchased/videos')}}"><i class="fa fa-history"></i> @lang('messages.purchasedVideos')</a></li>
            <li><a class="{{ Request::is('members/products/purchased')? 'active' : '' }}" href="{{URL('members/products/purchased')}}"><i class="fa fa-history"></i> @lang('messages.purchasedProducts')</a></li>

          </ul>
        </div>
      </div>
      <div class="col-sm-8 col-md-10 col-xs-12">
        @yield('content_sub_member')
      </div>
    </div>
  </div>
</div>     <!-- content end-->
@endsection