@extends('frontend')
@section('title','Studio Login')
@section('content')
<div class="content log_reg_form">
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
          <div class="panel-heading">@lang('messages.studioLogin')</div>
          <div class="panel-body">
            <div class="form_block">
              <div class="help-block">
                <strong>@lang('messages.alreadyhaveastudioaccount') </strong><br/>
                @lang('messages.enteryourusernameandpasswordandthenclicklogintoyouraccount')
              </div>
              <form method="POST" class="form-horizontal" action="{{URL('studio/auth/login')}}">
                <div class="form-group">
                  <label for="login" class="col-sm-3 control-label input-lg">@lang('messages.username')</label>
                  <div class="col-sm-9">
                      <input class="form-control input-lg" id="login" name="username" type="text" placeholder="@lang('messages.username')" value="{{old('username')}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="passw1" class="col-sm-3 control-label input-lg">@lang('messages.password')</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" id="passw1" name="password" type="password" placeholder="@lang('messages.password')">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-6 col-sm-push-3">
                    <label class="checkbox-inline">
                      <input id="inlineCheckbox1" value="option1" checked="" type="checkbox"> @lang('messages.rememberMe')
                    </label>
                  </div>
                  <div class="col-xs-6 col-sm-6 text-right f_pwd">
                    <a id="checkForgotPassword" href="javascript:void(0);">@lang('messages.forgotPass') ?</a>
                  </div>
                </div>
                <div class="form-group" id="load-from-rest-pw" style="display: none">
                  <div class="col-sm-9 col-sm-offset-3">
                    <span id ="required" class="required label label-danger"></span>
                    <div class="input-group">
                      <input type="email" id="emailReset" name='emailReset' class="form-control input-lg" placeholder="@lang('messages.Enteremailaccount')" >
                      <span class="input-group-addon btn btn-dark btn-lg btn-block" id="frm-reset-send">@lang('messages.send')</span>
                    </div>

                  </div>
                </div>
                <div class="form-group text-center bottom-button-wrap">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-dark btn-lg btn-block">@lang('messages.loginToYourAccount')</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>     <!-- content end-->
@endsection