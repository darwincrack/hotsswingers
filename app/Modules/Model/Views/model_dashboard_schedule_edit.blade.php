@extends('Model::model_dashboard')
@php use \App\Modules\Api\Models\ScheduleModel; @endphp
@section('content_sub_model')
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="dashboard-long-item">
        <div class="dashboard_tabs_wrapper">
          <div class="dashboard_tabs pull-right">
            <a class="btn btn-dark" href="{{URL('models/dashboard/schedule')}}">@lang('messages.schedules')</a>
            <a class="btn btn-dark active" href="">@lang('messages.editschedulessettings2')</a>
          </div>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="mod_shedule" ng-controller="modelScheduleCtrl"> <!--user's info-->
    <form class="form-horizontal" action="/models/dashboard/schedule" name="frmSchedule" novalidate="" method="post">
      <div class="form-group">
        <label class="col-sm-3 control-label">@lang('messages.timezone')</label>
        <div class="col-sm-9">
          @php $defaultValue = old('timezone', @$mySchedule->timezone ? $mySchedule->timezone : '+00:00') @endphp
          {{Form::select('timezone', ScheduleModel::$LIST_TIMEZONE, $defaultValue, array('class' => 'form-control input-md'))}}
        </div>
      </div>
       <div class="form-group">
        <label class="col-sm-3 control-label"></label>
        <div class="col-sm-9">
          {{Form::text('timezoneDetails', old('timezoneDetails', $mySchedule->timezoneDetails), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Note for user'))}}
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">@lang('messages.monday')</label>
        <div class="col-sm-9">
          <input id="monday" name="monday" value="{{old('monday', $mySchedule->monday)}}" placeholder="HH:mm" class="form-control input-md" type="text">
          <input type="checkbox" class="schedule__notavailable-btn" <?php if(!$mySchedule->monday)echo 'checked';?>/> @lang('messages.notavailable')
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">@lang('messages.tuesday')</label>
        <div class="col-sm-9">
          <input id="tuesday" name="tuesday" value="{{old('tuesday', $mySchedule->tuesday)}}" placeholder="HH:mm" class="form-control input-md" type="text">
          <input type="checkbox" class="schedule__notavailable-btn" <?php if(!$mySchedule->tuesday)echo 'checked';?>/> @lang('messages.notavailable')
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">@lang('messages.wednesday')</label>
        <div class="col-sm-9">
          <input id="wednesday" name="wednesday" placeholder="HH:mm" value="{{old('wednesday', $mySchedule->wednesday)}}" class="form-control input-md" type="text">
          <input type="checkbox" class="schedule__notavailable-btn" <?php if(!$mySchedule->wednesday)echo 'checked';?>/> @lang('messages.notavailable')
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">@lang('messages.thursday')</label>
        <div class="col-sm-9">
          <input id="thursday" name="thursday" value="{{old('thursday', $mySchedule->thursday)}}" placeholder="HH:mm" class="form-control input-md" type="text">
          <input type="checkbox" class="schedule__notavailable-btn" <?php if(!$mySchedule->thursday)echo 'checked';?>/> @lang('messages.notavailable')
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">@lang('messages.friday')</label>
        <div class="col-sm-9">
          <input id="friday" name="friday" value="{{old('friday', $mySchedule->friday)}}" placeholder="HH:mm" class="form-control input-md" type="text">
          <input type="checkbox" class="schedule__notavailable-btn" <?php if(!$mySchedule->friday)echo 'checked';?>/> @lang('messages.notavailable')
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">@lang('messages.saturday')</label>
        <div class="col-sm-9">
          <input id="saturday" name="saturday" placeholder="HH:mm" value="{{old('saturday', $mySchedule->saturday)}}" class="form-control input-md" type="text">
          <input type="checkbox" class="schedule__notavailable-btn" <?php if(!$mySchedule->saturday)echo 'checked';?>/> @lang('messages.notavailable')
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">@lang('messages.sunday')</label>
        <div class="col-sm-9">
          <input id="sunday" name="sunday" value="{{old('sunday', $mySchedule->sunday)}}" placeholder="HH:mm" class="form-control input-md" type="text">
          <input type="checkbox" class="schedule__notavailable-btn" <?php if(!$mySchedule->sunday)echo 'checked';?>/> @lang('messages.notavailable')
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-3">
          <input type="hidden" name="id" value="{{old('id', $mySchedule->id)}}">
        </div>
        <div class="col-sm-9 text-center">
          <button type="submit" class="btn btn-rose btn-lg btn-block">@lang('messages.saveChanges')</button>
        </div>
      </div>
    </form>
  </div> <!--user's info end-->
</div>
@endsection