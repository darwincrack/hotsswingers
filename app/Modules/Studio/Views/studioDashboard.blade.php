<?php 

use App\Helpers\Helper as AppHelper;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\UserModel;
?>
@extends('frontend')
@section('title','Studio Profile')
@section('content')
<?php 
  $userLogin = AppSession::getLoginData();
?>
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-sm-4 col-md-3">
        <div class="tk-studio dashboard-menu">
            <table>
              <tr>
                  <td>@lang('messages.totalModels')<strong class="pull-right">{{AppHelper::getTotalModels()}}</strong></td>
                </tr>
                <tr>
                    <td>@lang('messages.totalEarned')<strong class="pull-right" title="${{AppHelper::getTotalEarned()}}">${{AppHelper::getTotalEarned()}}</strong></td>
                </tr>
                <tr>
                    <td>@lang('messages.total') {{str_plural('Session', AppHelper::getTotalOnlinePerDay())}}<strong class="pull-right">{{AppHelper::getTotalOnlinePerDay()}}</strong></td>
                </tr>
                <tr>
                    <td>@lang('messages.totalHoursOnline')<strong class="pull-right">{{AppHelper::getTotalHoursOnline()}}</strong></td>
                </tr>
            </table>
        </div>
        <div class="menu-account">
            <a href="#" class="btn btn-grey btn-block menu-left-account"><i class="fa fa-bars"></i> @lang('messages.menuAccount')</a>
            <ul>
                <li><a href="/studio/account-settings" class="{{(\Request::is('*/account-settings') || Request::is('*change-password'))? 'active' : ''}}"><i class="fa fa-wrench"></i> @lang('messages.accountSettings')</a></li>
                @if($userLogin->accountStatus == UserModel::ACCOUNT_ACTIVE)
                <li><a href="/studio/earnings" class="{{(\Request::is('*/earnings'))? 'active' : ''}}"><i class="fa fa-money"></i> @lang('messages.earnings')</a></li>
                <li><a href="/studio/commission-report" class="{{\Request::is('*/commision-report/*')? 'active' : ''}}"><i class="fa fa-credit-card"></i> @lang('messages.commission')</a></li>
                <li><a href="/studio/members" class="{{(\Request::is('*/members*'))? 'active' : ''}}"><i class="fa fa-group"></i> Models</a></li>
                <li>
                  <a href="/studio/payouts/requests" class="{{(\Request::is('*/payouts/requests*'))? 'active' : ''}}">
                    <i class="fa fa-money"></i> @lang('messages.payoutRequests')
                  </a>
                </li>
                <li>
                  <a href="/studio/payouts/performer-requests" class="{{(\Request::is('*/payouts/performer-requests*'))? 'active' : ''}}">
                    <i class="fa fa-money"></i> @lang('messages.performerPayoutRequests')
                  </a>
                </li>
                <li>
                  <a href="/studio/performers/stats" class="{{(\Request::is('*/performers/stats'))? 'active' : ''}}">
                    <i class="fa fa-line-chart"></i> @lang('messages.performersStats')
                  </a>
                </li>
                @endif
                @if($userLogin->accountStatus != UserModel::ACCOUNT_ACTIVE)
                <li><a title="Waiting for admin approve to use this function"><i class="fa fa-money"></i> @lang('messages.payoutRequests') Earnings</a></li>
                <li><a title="Waiting for admin approve to use this function"><i class="fa fa-credit-card"></i> @lang('messages.commission')</a></li>
                <li><a title="Waiting for admin approve to use this function"><i class="fa fa-group"></i> @lang('messages.payoutRequests') Models</a></li>
                <li>
                  <a title="Waiting for admin approve to use this function">
                    <i class="fa fa-money"></i> @lang('messages.payoutRequests')
                  </a>
                </li>
                <li>
                  <a title="Waiting for admin approve to use this function">
                    <i class="fa fa-money"></i> @lang('messages.performerPayoutRequests')
                  </a>
                </li>
                <li>
                  <a title="Waiting for admin approve to use this function">
                    <i class="fa fa-line-chart"></i> @lang('messages.performersStats')
                  </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
      <div class="col-md-9 col-sm-8">
        @yield('contentDashboard')
      </div>
    </div>
  </div>
</div>
</div>     <!-- content end-->
@endsection