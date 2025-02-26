@extends('Member::member_profile')
@section('content_sub_member')
@section('title', 'Transaction History')

<?php 
use App\Helpers\Helper as AppHelper
?>
<div ng-controller="paymentCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>@lang('messages.transactionHistory')</h4>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody><tr>
                <th>ID</th>
                <th>@lang('messages.transactionId')</th>
                <th>@lang('messages.price')</th>
                <th>Tokens</th>
                <th>@lang('messages.status')</th>
                <th>@lang('messages.date')</th>
              </tr>
              @foreach($transactions as $transaction)
              <tr id="user-{{$transaction->id}}">
                <td>{{$transaction->id}}</td>
                <td><a ng-click="showTransactionDetail('{{$transaction->parameters}}')">{{AppHelper::getJsonDecode($transaction->parameters, 'subscription_id')}}</a></td>
                <td>{{AppHelper::getJsonDecode($transaction->parameters, 'initialFormattedPrice')}}</td>
                <td>{{ $transaction->price }}</td>
                <td>{{$transaction->status}}</td>
                <td>{{AppHelper::getDateFormat(AppHelper::formatTimezone($transaction->createdAt), 'F d, Y')}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $transactions->appends(Request::except('page'))->links() !!}
        </div>
      </div>
    </div>
</div>
@endsection