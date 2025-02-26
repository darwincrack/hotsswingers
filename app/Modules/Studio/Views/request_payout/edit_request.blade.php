@extends('Studio::studioDashboard')
@section('title','Edit payout request')
@section('contentDashboard')
<?php use App\Modules\Model\Models\PerformerPayoutRequest;?>
<div ng-controller="modelPayoutRequestCtrl" ng-init="init('studio', '{{$request->dateFrom}}', '{{$request->dateTo}}')">
  <form method="post" action="" name="form">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>@lang('messages.editrequest')</h4>
      </div>

      <div class="right_cont panel-body">
        <div class="row">
          <div class="col col-md-4">
            <div class="form-group">
              <label>@lang('messages.fromdate')</label>
              <p class="input-group">
                <input type="text" name="dateFrom" class="form-control" required
                    uib-datepicker-popup
                    is-open="startDate.open"
                    placeholder="@lang('messages.startDate')"
                    value="{{$request->dateFrom}}"
                    ng-model="startDate.value" />
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default" ng-click="startDate.open=!startDate.open">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </button>
                </span>
              </p>
            </div>
            <div class="form-group">
              <label>@lang('messages.todate')</label>
              <p class="input-group">
                <input type="text" name="dateTo" class="form-control" required
                    uib-datepicker-popup
                    is-open="toDate.open"
                    placeholder="To date"
                    value="{{$request->dateTo}}"
                    ng-model="toDate.value" />
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default" ng-click="toDate.open=!toDate.open">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </button>
                </span>
              </p>
            </div>
          </div>
          <div class="col col-md-6 earning-for-requested-date-box" ng-show="earningByRequestedDate">
            <br>
            <strong>@lang('messages.earningsForTheSelectedDate'):</strong> $<% earningByRequestedDate %><br>
            <strong>@lang('messages.previousPayout'): </strong>$<% previousPayout %><br>
            <strong>@lang('messages.earningsPendingInYourAccount'): </strong>$<% pendingBalance %>            
          </div>
          <input type="hidden" name="payout" value="<% earningByRequestedDate %>"/>
          <input type="hidden" name="previousPayout" value="<% previousPayout %>"/>
          <input type="hidden" name="pendingBalance"value="<% pendingBalance %>"/>
        </div>
        <div class="form-group">
          <label>@lang('messages.toPaymentAccount')</label>
          <select class="form-control" name="paymentAccount">
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_WIRE?>' <?php if($request->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_WIRE)echo 'selected';?>>@lang('messages.bankTransfer')</option>
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_PAYPAL?>' <?php if($request->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYPAL)echo 'selected';?>>@lang('messages.paypal')</option>
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_ISSUE_CHECK_US?>' <?php if($request->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_ISSUE_CHECK_US)echo 'selected';?>>@lang('messages.checkTransfer')</option>
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_DEPOSIT?>' <?php if($request->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_DEPOSIT)echo 'selected';?>>@lang('messages.directDeposit')</option>
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_PAYONEER?>' <?php if($request->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYONEER)echo 'selected';?>>@lang('messages.paxum')</option>
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_BITPAY?>' <?php if($request->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_BITPAY)echo 'selected';?>>@lang('messages.bitpay')</option>
          </select>
        </div>
        <div class="form-group">
          <label>@lang('messages.comment')</label>
          <textarea class="ckeditor form-control" name="comment" rows="10">{{$request->comment}}</textarea>
        </div>
        <hr/>
        <button class="btn btn-primary" type="submit" normal-submit>@lang('messages.save')</button>
      </div>
    </div>
  </form>
</div>
@endsection