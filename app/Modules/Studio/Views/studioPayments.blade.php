@extends('Studio::studioDashboard')
@section('title','Payments')
@section('contentDashboard')
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name">@lang('messages.payments')</div>
      <div class="dashboard-long-item">
        <div class="l_i_text">
          <span>@lang('messages.theseAreYourPayments')</span>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="studio-cont"> <!--user's info-->
    <div class="table-responsive">
      <table class="table table_performers">
        <tr>
          <th class="col-sm-1">Id</th>
          <th class="col-sm-2">@lang('messages.period')</th>
          <th class="col-sm-2">@lang('messages.status')</th>
          <th class="col-sm-2">@lang('messages.paidOn')</th>
          <th class="col-sm-3">@lang('messages.grossNet')</th>
          <th class="col-sm-2">@lang('messages.details')</th>
        </tr>
        <tr>
          <td>2</td>
          <td>01/30/2016 - 01/30/2016</td>
          <td>Paid</td>
          <td>01/30/2016</td>
          <td>
            <p><strong>@lang('messages.gross'):</strong>&nbsp;$1000</p>
            <p><strong>@lang('messages.net'):</strong>&nbsp;$1000</p>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>1</td>
          <td>01/30/2016 - 01/30/2016</td>
          <td>@lang('messages.paid')</td>
          <td>01/30/2016</td>
          <td>
            <p><strong>@lang('messages.gross'):</strong>&nbsp;$1000</p>
            <p><strong>@lang('messages.net'):</strong>&nbsp;$1000</p>
          </td>
          <td></td>
        </tr>
      </table>
    </div>
  </div> <!--user's info end-->
</div>
@endsection