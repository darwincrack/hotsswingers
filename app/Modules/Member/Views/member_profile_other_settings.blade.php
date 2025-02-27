@extends('Member::member_profile')
@section('content_sub_member')
<?php

use App\Helpers\Helper as AppHelper;
?>
<div class="dashboard-long-item">
  <div class="dashboard_tabs_wrapper">
    <div class="pull-left">
      <a class="btn btn-dark pull-left" href="{{URL('members/account-settings')}}">@lang('messages.accountInformation')</a>
      <a class="btn btn-dark pull-left <?= (!isset($action) ? 'active' : '') ?>" href="{{URL('members/other-settings')}}">@lang('messages.timezone')</a>
      <a class="btn btn-dark pull-left <?= (isset($action) ? ($action === 'change-password') ? 'active' : '' : '') ?>"  href="{{URL('members/account-settings')}}?action=change-password">@lang('messages.changePassword')</a>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="panel panel-default">
  <div class="panel-heading"><h4>@lang('messages.timezone')</h4></div>
  <div class="panel-body">
    <div class="user-setting-item">
    <span class="user-setting-notif">@lang('messages.headMessageTimezoneSucMemberControl') </span>
    <div class="other_act">
        {!! Form::open(array('method' => 'POST', 'role' => 'form', 'class'=>'form-horizontal')) !!}
      
        <div class="form-group required">
          <label for="time" class="col-sm-4 control-label ">@lang('messages.timezoneSelect') </label>
            <div class="col-sm-8">
            {{Form::select('timezone', $zones, old('timezone', $timezone), array('class'=>'form-control ', 'placeholder' => 'Please select'))}}
              
              <span class="label label-danger">{{$errors->first('timezone')}}</span>
            </div>
          </div>
            
              <div class="form-group text-center bottom-button-wrap">
                <div class="col-sm-8 col-sm-offset-4">
                 
                  <button type="submit" class="btn btn-rose btn-lg btn-block ">@lang('messages.saveChanges')</button>
                </div>
              </div>
            {!!Form::close()!!}
          </div>
  </div>
  </div>
</div>


  <!--end content  -->
  @endsection