@extends('Studio::studioDashboard')
@section('title','Edit Account')
@section('contentDashboard')
<?php use App\Helpers\Helper as AppHelper; ?>
<div class="content" ng-controller="studioProfileCtrl" ng-cloak ng-init="init()">
  <div class="full-container">
    <div class="menu-setting">
      <a href="{{URL('studio/account-settings')}}">@lang('messages.accountInformation')</a>
      <a href="{{URL('studio/change-password')}}">@lang('messages.changePassword')</a>
    </div>
    <form class="form-horizontal" name="frmSettings" method="post" ng-submit="frmSettings.$valid && updateProfile(frmSettings)" novalidate>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.accountInformation')</h4></div>
        <div class="panel-body">
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="firstName">@lang('messages.firstname') </label>
            <div class="col-sm-9">
              <input id="live" name="firstName" placeholder="" class="form-control input-md" type="text" ng-model="profile.firstName" ng-required="true">
              <span class="label label-danger" ng-show="frmSettings.$submitted && frmSettings.firstName.$error.required"><i class="fa fa-exclamation-triangle"></i> @lang('messages.thisFieldIsRequired')</span>
              <span class="label label-danger" ng-show="frmSettings.$submitted && errors.firstName"><i class="fa fa-exclamation-triangle"></i> <%errors.firstName[0]%></span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="tuesday">@lang('messages.lastname') </label>
            <div class="col-sm-9">
              <input id="tuesday" name="lastName" placeholder="" class="form-control input-md" type="text" ng-model="profile.lastName" ng-required="true">
              <span class="label label-danger" ng-show="frmSettings.$submitted && frmSettings.lastName.$error.required"><i class="fa fa-exclamation-triangle"></i> @lang('messages.thisFieldIsRequired')</span>
              <span class="label label-danger" ng-show="frmSettings.$submitted && errors.lastName"><i class="fa fa-exclamation-triangle"></i> <%errors.lastName[0]%></span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="country">@lang('messages.country') </label>
            <div class="col-sm-9">
              <select class="form-control input-md" name="country" field="location_id" id="performer_country_id" ng-model="profile.countryId" ng-required="true" ng-options="country.id as country.name for country in countries">
                <option value="">@lang('messages.pleaseSelectCountry')</option>
              </select>
              <span class="label label-danger" ng-show="frmSettings.$submitted && frmSettings.country.$error.required"><i class="fa fa-exclamation-triangle"></i> @lang('messages.thisFieldIsRequired')</span>
              <span class="label label-danger" ng-show="frmSettings.$submitted && errors.countryId"><i class="fa fa-exclamation-triangle"></i> <%errors.countryId[0]%></span>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-3 control-label" for="stateName">@lang('messages.state') @lang('messages.name') </label>
            <div class="col-sm-9">
              <input class="form-control input-md" name="stateName" ng-model="profile.stateName" type="text" ng-maxlength="32" maxlength="32">
              <span class="label label-danger" ng-show="frmSettings.$submitted && errors.stateName"><i class="fa fa-exclamation-triangle"></i> <%errors.stateName[0]%></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="cityName">@lang('messages.city')</label>
            <div class="col-sm-9">
              <input class="form-control input-md" name="cityName" ng-model="profile.cityName" type="text" ng-maxlength="32" maxlength="32">
              <span class="label label-danger" ng-show="frmSettings.$submitted && errors.cityName"><i class="fa fa-exclamation-triangle"></i> <%errors.cityName[0]%></span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="zip">Zip </label>
            <div class="col-sm-9">
              <input id="saturday" name="zip" placeholder="" class="form-control input-md" type="text" ng-required="true" ng-model="profile.zip">
             <span class="label label-danger" ng-show="frmSettings.$submitted && frmSettings.zip.$error.required"><i class="fa fa-exclamation-triangle"></i> @lang('messages.thisFieldIsRequired')</span>
             <span class="label label-danger" ng-show="frmSettings.$submitted && errors.zip"><i class="fa fa-exclamation-triangle"></i> <%errors.zip[0]%></span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="address1">@lang('messages.address') 1 </label>
            <div class="col-sm-9">
              <input id="address1" name="address1" ng-model="profile.address1" placeholder="" class="form-control input-md" type="text" ng-required="true">
              <span class="label label-danger" ng-show="frmSettings.$submitted && frmSettings.address1.$error.required"><i class="fa fa-exclamation-triangle"></i> @lang('messages.thisFieldIsRequired')</span>
              <span class="label label-danger" ng-show="frmSettings.$submitted && errors.address1"><i class="fa fa-exclamation-triangle"></i> <%errors.address1[0]%></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="address2">@lang('messages.address') 2</label>
            <div class="col-sm-9">
              <input id="sunday" name="address2" ng-model="profile.address2" placeholder="" class="form-control input-md" type="text">
              <span class="label label-danger" ng-show="frmSettings.$submitted && errors.address2"><i class="fa fa-exclamation-triangle"></i> <%errors.address2[0]%></span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="email">@lang('messages.email')  </label>
            <div class="col-sm-9">
              <input id="sunday" name="email" placeholder="" class="form-control input-md" type="email" ng-model="profile.email">
               <span class="label label-danger" ng-show="frmSettings.$submitted && frmSettings.email.$error.required"><i class="fa fa-exclamation-triangle"></i> @lang('messages.thisFieldIsRequired')</span>
              <span class="label label-danger" ng-show="frmSettings.email.$error.email"><i class="fa fa-exclamation-triangle"></i> @lang('messages.notValidEmail')</span>
              <span class="label label-danger" ng-show="frmSettings.$submitted && errors.email"><i class="fa fa-exclamation-triangle"></i> <%errors.email[0]%></span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="mobilePhone">@lang('messages.mobilePhone') </label>
            <div class="col-sm-9">
              <input id="sunday" name="mobilePhone" placeholder="" ng-model="profile.mobilePhone" class="form-control input-md" type="text"  ng-required="true"  ng-minlength="10" ng-maxlength="15">
              <span class="label label-danger" ng-show="frmSettings.$submitted && frmSettings.mobilePhone.$error.required"><i class="fa fa-exclamation-triangle"></i> @lang('messages.modelpersonalinfo') @lang('messages.thisFieldIsRequired')</span>
              <span class="label label-danger" ng-show="frmSettings.mobilePhone.$error.minlength"> @lang('messages.theFixPhoneMustBeAtLeast10')</span>
              <span class="label label-danger" ng-show="frmSettings.mobilePhone.$error.maxlength"> @lang('messages.theFixPhoneMustNotBeGreaterThan15')</span>
              <span class="label label-danger" ng-show="frmSettings.$submitted && errors.mobilePhone"><i class="fa fa-exclamation-triangle"></i> <%errors.mobilePhone[0]%></span>
            </div>
          </div>
            <div class="form-group">
              <label class="col-sm-4 col-md-3 control-label" for="minPayment"> @lang('messages.minpayment') </label>
              <div class="col-sm-8 col-md-9">
                <select class="form-control input-md" name="minPayment" ng-model="profile.minPayment" ng-options="val.min as val.min + '$' for val in paymentValue">
                  <option value="">@lang('messages.pleaseSelect')</option>
                </select>
                <span class="label label-danger" ng-show="frmSettings.$submitted && frmSettings.minPayment.$error.required"> @lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmSettings.$submitted && errors.minPayment"><%errors.minPayment[0]%></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 col-md-3 control-label" for="payoneer">Payoneer </label>
              <div class="col-sm-8 col-md-9">
                <input type="text" name="payoneer" class="form-control input-md" ng-model="profile.payoneer">
                <span class="label label-danger" ng-show="frmSettings.$submitted && frmSettings.payoneer.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmSettings.$submitted && errors.payoneer"><%errors.payoneer[0]%></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 col-md-3 control-label" for="paypal">Paypal </label>
              <div class="col-sm-8 col-md-9">
                <input type="text" name="paypal" class="form-control input-md" ng-model="profile.paypal">
                <span class="label label-danger" ng-show="frmSettings.$submitted && frmSettings.paypal.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmSettings.$submitted && errors.paypal"><%errors.paypal[0]%></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 col-md-3 control-label" for="bankAccount">@lang('messages.bankaccountwithcode') </label>
              <div class="col-sm-8 col-md-9">
                <input type="text" name="bankAccount" class="form-control input-md" ng-model="profile.bankAccount">
                <span class="label label-danger" ng-show="frmSettings.$submitted && frmSettings.bankAccount.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmSettings.$submitted && errors.bankAccount"><%errors.bankAccount[0]%></span>
              </div>
            </div>
          <div class="form-group">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-9 text-center">
              <button type="submit" class="btn btn-rose btn-lg btn-block">@lang('messages.saveChanges')</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
  @endsection