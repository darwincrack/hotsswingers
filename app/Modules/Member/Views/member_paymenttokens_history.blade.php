@extends('Member::member_profile')
@section('content_sub_member')
@section('title', 'Payment Tokens History')

<?php 
use App\Helpers\Helper as AppHelper
?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>@lang('messages.paymenttokenshistory')</h4>
      </div>
      <div class="panel-body">
          <form class="form-inline" action="" name="frmFilterPeriod" novalidate>

            <div class="row">
                <div class="col-sm-4" id="datepicker-1">
                  <div class="input-daterange input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" class="input-lg form-control" name="timePeriodStart" id="timePeriodStart" placeholder="@lang('messages.startDate')" value="{{Request::has('timePeriodStart') ? Request::get('timePeriodStart') : ''}}"/>
                  </div>
                </div>
                <div class="col-sm-4" id="datepicker-2">
                  <div class="input-daterange input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" class="input-lg form-control" name="timePeriodEnd" id="timePeriodEnd" placeholder="End Date" value="{{Request::has('timePeriodEnd') ? Request::get('timePeriodEnd') : ''}}"/>

                  </div>
                </div>
                <div class="col-sm-4">
                  <button class="btn btn-info btn-lg"><i class="fa fa-filter"></i>@lang('messages.filter')</button>
                </div>
              </div>
            

          </form>
        <br>
        <div class="clearfix"></div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody><tr>
                <th>ID</th>
                <th>@lang('messages.item')</th>
                <th>Tokens</th>
                <th>@lang('messages.date')</th>
              </tr>
              @foreach($payments as $item)
              <tr id="user-{{$item->id}}">
                <td>{{$item->id}}</td>
                <td>{{$item->item}}</td>
                <td>{{$item->tokens}}</td>
                <td>{{AppHelper::getDateFormat(AppHelper::formatTimezone($item->createdAt), 'F d, Y h:i A')}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $payments->appends(Request::except('page'))->links() !!}
        </div>
      </div>
    </div>
@endsection