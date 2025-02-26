@extends('Model::model_dashboard')
@section('content_sub_model')
<?php use App\Helpers\Helper as AppHelper;?>
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="dashboard-long-item">
        <div class="dashboard_tabs_wrapper">
          <div class="dashboard_tabs pull-right">
            <a class="btn btn-dark active" href="">@lang('messages.schedules')</a>
            <a class="btn btn-dark" href="{{URL('models/dashboard/schedule/edit')}}">Edit @lang('messages.schedulessettings')</a>
          </div>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="mod_shedule"> <!--user's info-->
    <!--Jan/26/2016 00:42-->
    <table class="table table-bordered">
    @if($nextSchedule)
      <tr>
        <td style="width: 50%">@lang('messages.nextshow')</td>
        <td>{{AppHelper::getDateFormat(AppHelper::formatTimezone($nextSchedule), 'm/d/Y h\:i A')}}</td>
      </tr>
      @endif

<?php $Noworking = $mynotWorking; ?>

      <tr>
        <td>@lang('messages.monday')</td>
        <td>{{($mySchedule->monday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($mySchedule->monday), 'h\:i A') : $Noworking }}</td>
      </tr>
      <tr>
        <td>@lang('messages.tuesday')</td>
        <td>{{($mySchedule->tuesday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($mySchedule->tuesday), 'h\:i A') : $Noworking }}</td>
      </tr>
      <tr>
        <td>@lang('messages.wednesday')</td>
        <td>{{($mySchedule->wednesday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($mySchedule->wednesday), 'h\:i A') : $Noworking }}</td>
      </tr>
      <tr>
        <td>@lang('messages.thursday')</td>
        <td>{{($mySchedule->thursday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($mySchedule->thursday), 'h\:i A') : $Noworking }}</td>
      </tr>
      <tr>
        <td>@lang('messages.friday')</td>
        <td>{{($mySchedule->friday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($mySchedule->friday), 'h\:i A') : $Noworking }}</td>
      </tr>
      <tr>
        <td>@lang('messages.saturday')</td>
        <td>{{($mySchedule->saturday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($mySchedule->saturday), 'h\:i A') : $Noworking }}</td>
      </tr>
      <tr>
        <td>@lang('messages.sunday')</td>
        <td>{{($mySchedule->sunday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($mySchedule->sunday), 'h\:i A') : $Noworking }}</td>
      </tr>
    </table>
    <a href="{{URL('models/dashboard/schedule/edit')}}" class="btn center-block btn-rose">@lang('messages.editschedulessettings2')</a>
  </div> <!--user's info end-->
</div>
@endsection