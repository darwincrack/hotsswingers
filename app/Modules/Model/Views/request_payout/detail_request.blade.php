@extends('Model::model_dashboard')
@section('content_sub_model')
<?php use App\Modules\Model\Models\PerformerPayoutRequest;?>
<div ng-controller="ModelRequestPayoutViewCrl" ng-init="init({{json_encode($item)}})">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4>@lang('messages.paymentDetails')</h4>
    </div>
    <div class="right_cont panel-body">
      <div class="row">
        <div class="col-md-6">
          <p> 
            <strong>@lang('messages.payPeriod'): </strong> {{$item->dateFrom}} @lang('messages.to') {{$item->dateTo}}
          </p>
          <p>
            <strong>@lang('messages.paymentMethod'): </strong> 
            <?php 
            $paymentMethod = '';
            if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYPAL){
              $paymentMethod = trans('messages.paypal');
            }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_ISSUE_CHECK_US){
              $paymentMethod = trans('messages.checkTransfer');
            }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_WIRE){
              $paymentMethod = trans('messages.bankTransfer');
            }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_DEPOSIT){
              $paymentMethod = trans('messages.directDeposit');
            }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYONEER){
              $paymentMethod = trans('messages.paxum');
            }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_BITPAY){
              $paymentMethod = trans('messages.bitpay');
            }             
            echo $paymentMethod;
            ?>
           
          </p>
          <div>
            <strong>@lang('messages.comments'): </strong> {!! $item->comment !!}
          </div>
          <div class="clearfix"></div>
          <p>
            <strong>@lang('messages.dateRequest'): </strong> {{$item->createdAt}}
          </p>
          <p>
            <strong>@lang('messages.earningsForTheSelectedDate'): </strong> $<?php echo ($item->payout) ? $item->payout : 0;?>
          </p>
          <p>
            <strong>@lang('messages.previousPayout'): </strong> $<?php echo ($item->previousPayout) ? $item->previousPayout : 0;?>
          </p>
          <p>
            <strong>@lang('messages.earningsPendingInYourAccount'): </strong> $<?php echo ($item->pendingBalance) ? $item->pendingBalance : 0;?> ( @lang('messages.thisWillBeTheEarnings') {{$item->dateTo}} )
          </p>
        </div>
        <div class="col-md-6">
          <h4>@lang('messages.confirmInformation')</h4>

          <p>
            <strong>@lang('messages.statusInformation'): </strong> <span class="capitialize">{{$item->status}}</span>
          </p>
          <div>
            <strong>@lang('messages.note'): </strong> {!! $item->note !!}
          </div>
        </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4>@lang('messages.comments')</h4>
    </div>
    <div class="right_cont panel-body">
      <ul class="comment-list">
        <li ng-repeat="comment in comments track by $index">
          <div>
            <p><strong><% comment.sender.username %>: </strong> <small><% comment.createdAt|date:'short' %></small></p>
            <p><% comment.text %></p>
          </div>
        </li>
      </ul>
      <hr/>
      <form ng-submit="comment()">
        <div class="form-group">
          <label>@lang('messages.newComment')</label>
          <textarea class="form-control" ng-model="newComment" required></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">@lang('messages.send')</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection