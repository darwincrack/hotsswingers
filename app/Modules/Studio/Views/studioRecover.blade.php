@extends('studio-back-end')
@section('title','Studio Recover Account')
@section('content')
<div class="content log_reg_form">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="panel">
          <div class="panel-heading"><strong>@lang('messages.recoverPassword') </strong>on {{app('settings')->siteName}} </div>
          <div class="panel-body" style="overflow: hidden; max-height: 370px;">
            <div class="form_block">
              <div class="help-block">
                @lang('messages.descriptionForgotYourPassword')
              </div>
              <form class="form-horizontal" action="#">
                <div class="form-group">
                  <label for="user" class="col-sm-3 control-label input-lg">@lang('messages.username')</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" id="user" type="text" placeholder="Please type in your username">
                  </div>
                </div>
                <div class="form-group">
                  <label for="email" class="col-sm-3 control-label input-lg">@lang('messages.email')</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" id="email" name="pass" type="email" placeholder="email you used at account creation">
                  </div>
                </div>
                <div class="form-group">
                  <label for="vcode" class="col-sm-3 control-label input-lg">@lang('messages.verificationCode')</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" id="vcode" type="text" placeholder="">
                  </div>
                </div>
                <div class="form-group text-center bottom-button-wrap">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-dark btn-lg btn-block">@lang('messages.recoverPassword')</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 hidden-xs">
        <div class="log_reg_images text-center">
        <img src="{{PATH_IMAGE}}login-right.png" alt=""/>
        </div>
      </div>
    </div>
  </div>
</div>     <!-- content end-->
@endsection