@extends('Studio::studioDashboard')
@section('title','Studio Stats')
@section('contentDashboard')
<?php use App\Helpers\Helper as AppHelper; ?>
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name">@lang('messages.recoverPassword')Studio Stats</div>
      <div class="dashboard-long-item">
        <div class="l_i_text">
          <span>@lang('messages.theseAreYourStudioStats')</span>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="studio-cont"> <!--user's info-->
    <div class="table-responsive" style="color: #FFF;">
      <table id="studioStats"  class="table table_performers">
      <thead>
          <tr>
            <th class="col-sm-1">@lang('messages.date')</th>
            <th class="col-sm-2">@lang('messages.earned')</th>
            <th class="col-sm-2">@lang('messages.paid')</th>
            <th class="col-sm-2">@lang('messages.customers')</th>
            <th class="col-sm-3">@lang('messages.performers')</th>
            <th class="col-sm-3">@lang('messages.item')</th>
            <th class="col-sm-3">@lang('messages.type')</th>
          </tr>
      </thead>
      <tfoot>
        <tr>
            <th colspan="1" style="text-align:right">@lang('messages.total'):</th>
            <th colspan="6" ></th>
        </tr>
      </tfoot>
      <tbody>
      @if(count($loadStats)>0)
      @foreach($loadStats as $result)
        <tr>
          <td><?=AppHelper::getFortmatDateEarning($result->createdAt)?></td>
          <td><?=$result->tokens?></td>
          <td><?=$result->earned?></td>
          <td><?=$result->customer?></td>
          <td><?=$result->performer?></td>
          <td><?=$result->item?></td>
          <td><?=$result->type?></td>
        </tr>
      @endforeach
      @endif
      </tbody>
      </table>
    </div>
  </div> <!--user's info end-->
</div>

@endsection