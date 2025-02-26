@extends('Studio::studioDashboard')
@section('title','Studio Commission Report')
@section('contentDashboard')
<?php use App\Helpers\Helper as AppHelper; ?>
<div class="panel panel-default"> <!--all left-->
  <div class="panel-heading">
    <h4>@lang('messages.commissionReport')</h4>
  </div>
  <div class="panel-body"> <!--user's info-->
    <div class="table-responsive">
      <table id="studioCommission"  class="table table_performers">
      <thead>
          <tr>
            <th>@lang('messages.performer')</th>
            <th>(%)Commission</th>
            <th>@lang('messages.activeDate')</th>
            <th>@lang('messages.action')</th>
          </tr>
      </thead>
      <tfoot>
        <tr>
            <th colspan="1" style="text-align:right"></th>
            <th colspan="6" ></th>
        </tr>
      </tfoot>
      <tbody>
      @if(count($commission)>0)
      @foreach($commission as $result)
      <tr>
        <td><?=$result->username?></td>
        <td><?=$result->referredMember?></td>
        <td><?=AppHelper::getFortmatDateEarning($result->createdAt)?></td>
        <td><a class="btn btn-warning btn-sm" href="{{URL('studio/commission-report/' . $result->id)}}">@lang('messages.edit')</a></td>
      </tr>
      @endforeach
      @endif
      </tbody>
      </table>
       {!! $commission->links() !!}
    </div>
  </div> <!--user's info end-->
</div>

@endsection