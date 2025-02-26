@extends('Studio::studioDashboard')
@section('title',trans('messages.commission'))
@section('contentDashboard')

<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="text-center">(%)@lang('messages.commission')</h4>
  </div>
  <div class="panel-body">
    @include('Studio::accountSettingMenu', ['activeMenu' => 'commisionSetting'])
    <table class="table table-bordered">
      <tr>
        <td>@lang('messages.commission')</td>
        <td><span class="h3">{{$commission->referredMember}}%</span>
          <div class="help-block"><span class="text-danger"><i class="fa fa-lightbulb-o"></i>
              <strong>@lang('messages.hint'): </strong>@lang('messages.whenamemberspendspaid')</span></div>
        </td>
      </tr>
    </table>
  </div>
</div>
@endsection