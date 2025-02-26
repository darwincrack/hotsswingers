@extends('Model::model_dashboard')
@section('content_sub_model')

<?php
use App\Helpers\Helper as AppHelper;
?>
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="dashboard-long-item">
        <div class="dashboard_tabs_wrapper">
          <div class="pull-left">
            <a class="btn btn-dark pull-left {{ ($action == 'commissions') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=commissions">@lang('messages.commission')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'documents') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=documents">@lang('messages.documents')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'others') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=others">Timezone</a>
            <a class="btn btn-dark pull-left {{ ($action == 'contact' || $action == 'edit-contact') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=contact">@lang('messages.contactSettings')</a>
            <?php /*
            <a class="btn btn-dark pull-left {{ ($action == 'payment' || $action == 'edit-payment') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=payment">Payment Options</a>
            */ ?>
            <a class="btn btn-dark pull-left {{ ($action == 'payee-info' || $action == 'payee-info') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=payee-info">@lang('messages.payeeInfo')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'direct-deposity' || $action == 'direct-deposity') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=direct-deposity">@lang('messages.directDeposit')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'paxum' || $action == 'paxum') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=paxum">@lang('messages.paxum')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'bitpay' || $action == 'bitpay') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=bitpay">@lang('messages.bitpay')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'change-password') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=change-password">@lang('messages.changePassword')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'disable-account') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=disable-account">@lang('messages.disableAccount')</a>
          </div>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="clearfix">&nbsp;</div>
  <div class="mod_settings_cont" ng-controller="modelSettingCtrl" ng-cloak> <!--user's info-->
    <?php if ($action && $action == 'commissions') { ?>
      <div class="panel panel-default">
        <table class="table table-bordered">
          <tr>
            <td>@lang('messages.commission')</td>
            <td><span class="h3">{{$commission->referredMember}}%</span>
              <div class="help-block"><span class="text-danger"><i class="fa fa-lightbulb-o"></i>
                  <strong>@lang('messages.hint'): </strong>@lang('messages.youwillgetthiscommission')</span></div>
            </td>
          </tr>
        </table>
      </div> <!--Commission -->
    <?php } ?>
    <?php if ($action && $action == 'others') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.timezone')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" ng-submit="submitOtherSetting(otherSettingForm)" name="otherSettingForm" method="post" novalidate ng-init="initSettings({{$otherSettings}})">
            <div class="form-group required">
              <label for="s9" class="col-sm-4 control-label input-lg">@lang('messages.timezone')</label>
              <div class="col-sm-8">

                <select class="form-control input-lg" name="timezone" id="otherProfileSettingsForm_timezone" ng-model="settings.timezone" ng-required="true" >
                  <option value="">@lang('messages.pleaseSelectAnOption')</option>
                  @if($timezone)

                  @foreach($timezone as $zone)

                  <option value="{{$zone -> zone_name}}">{{$zone -> zone_name}}</option>

                  @endforeach
                  @endif
                </select>
                <span class="label label-danger" ng-show="otherSettingForm.$submitted && otherSettingForm.timezone.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
              </div>
              <div class="col-sm-8 text-center">
                <button type="submit" class="btn btn-rose btn-lg btn-block">@lang('messages.updateSettings')</button>
              </div>
            </div>
          </form>
        </div>
      </div><!--Other settings -->
    <?php } ?>
    <?php if ($action && $action == 'documents') { ?>

      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.documents')</h4></div>
        <div class="panel-body">
            @if(!$document)

                

              <form class="form-horizontal" action="/models/dashboard/account-settings/documents" enctype="multipart/form-data" method="post">

                <div class="form-group">
                      <label class="col-sm-12 control-label input-lg" style="text-align: left;"> Foto del DNI: </label>

                  <div class="col-sm-9">
                      <span class="">Para poder recibir ingresos hay que añadir la foto del DNI por las 2 caras, para confirmar la mayoria de edad.</span>
                  </div>
              

                </div>
                 




              <div class="form-group required">
               
                <label class="col-sm-3 control-label input-lg">@lang('messages.idImage') </label>
                <div class="col-sm-9">
                    <input name="idImage" id="idImage" type="file" accept="image/*">
                  <div class="help-block">
                    
                    
                    <span class="text-danger">@lang('messages.uploadingAnotherFileWillRemoveTheOldOne')</span>
                  </div>
                  <span class="label label-danger">{{$errors->first('idImage')}}</span>
                </div>
              </div>


              <div class="form-group required">
               
                <label class="col-sm-3 control-label input-lg">@lang('messages.idImage2') </label>
                <div class="col-sm-9">
                    <input name="idImage2" id="idImage2" type="file" accept="image/*">
                  <div class="help-block">

                    <span class="text-danger">@lang('messages.uploadingAnotherFileWillRemoveTheOldOne')</span>
                  </div>
                  <span class="label label-danger">{{$errors->first('idImage2')}}</span>
                </div>
              </div>


              <div class="form-group required">
                <label class="col-sm-3 control-label input-lg">@lang('messages.faceIDImage')</label>
                <div class="col-sm-9">
                    <input name="faceId" id="faceId" type="file" accept="image/*">
                  <div class="help-block">
                    <span class="">@lang('messages.faceidtext')</span>

                    <br>
                    <span class="text-danger">@lang('messages.herfilewillremovetheoldone')</span></div>
                  <span class="label label-danger">{{$errors->first('faceId')}}</span>
                </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label input-lg"></label>
                <div class="col-sm-9">
                    <div class="model_document_policy_checkbox">
                        <input ng-click="readDocuments=!readDocuments" name="releaseForm" id="releaseForm" type="checkbox" value="1">
                    </div>
                    <div class="model_document_policy">
                      @lang('messages.youarethesoleownerandproducer')
                    <br/>
                    @lang('messages.youandanyothersonyourcamare')
                    <br/>
                    @lang('messages.youaregranting')
                    {{app('settings')->siteName}} @lang('messages.therighttoshowordisplay')
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-9 text-center">
                  <button ng-disabled="!readDocuments" type="submit" class="btn btn-rose btn-lg btn-block">@lang('messages.updateDocuments')</button>
                </div>
              </div>
            </form>
            
            @else 

                @if(trim($cuentaestatus) != "active")
              <form class="form-horizontal" action="/models/dashboard/account-settings/documents" enctype="multipart/form-data" method="post">

                <fieldset class="form-group">
                      <label class="col-sm-12 control-label input-lg" style="text-align: left;"> Foto del DNI: </label>

                 <!-- <div class="col-sm-9">
                      <span class="">Para poder recibir ingresos hay que añadir la foto del DNI por las 2 caras, para confirmar la mayoria de edad.</span> -->
                  </div>
              

                </fieldset>

                <fieldset class="form-group">
                    <div class="col-sm-3">
                        <label>@lang('messages.idImage') </label>  
                    </div>
                    <div class="col-sm-9 text-center">
                      <input name="idImage" id="idImage" type="file" accept="image/*">
                      <br />
                      @if($document->idImage && file_exists(public_path($document->idImage)))
                      <img src="{{asset($document->idImage)}}?v={{uniqid()}}" class="img-responsive">
                      @endif
                    </div>
                </fieldset>
                <br />

                <fieldset class="form-group">
                    <div class="col-sm-3">
                        <label>@lang('messages.idImage2')</label>  
                    </div>
                    <div class="col-sm-9 text-center">
                      <input name="idImage2" id="idImage2" type="file" accept="image/*">
                      <br />
                      @if($document->idImage2 && file_exists(public_path($document->idImage2)))
                      <img src="{{asset($document->idImage2)}}?v={{uniqid()}}" class="img-responsive">
                      @endif
                    </div>
                </fieldset>
                <br />
                <fieldset class="form-group">
                    <div class="col-sm-3">
                        <label>@lang('messages.faceid')</label>  
                    </div>
                    <div class="col-sm-9 text-center">
                      <input name="faceId" id="faceId" type="file" accept="image/*">
                      <br />
                      @if($document->faceId && file_exists(public_path($document->faceId)))
                      <img src="{{asset($document->faceId)}}?v={{uniqid()}}" class="img-responsive">
                      @endif
                    </div>
                </fieldset>
                <div class="form-group">
                  <div class="col-sm-3">
                  </div>
                  <div class="col-sm-9 text-center">
                    <button type="submit" class="btn btn-rose btn-lg btn-block">@lang('messages.updateDocuments')</button>
                  </div>
                </div>
              </form>
              @else 
            <h3>@lang('messages.Lacuentayaestaactiva')</h3>
            @endif

            @endif
        </div>
      </div><!--Documents -->





    <?php } ?>
    <?php if ($action && $action == 'contact') { ?>
      <div class="mod_settings_cont">
        <div class="user-mailbox-folder-name">@lang('messages.yourContactDetails')</div>
          <table class="table table-bordered">
            <tr>
              <td class="text-right" style="width: 50%"><strong>@lang('messages.firstname')</strong></td>
              <td>{{$contact->firstName}}</td>
            </tr>
    <!--        <tr>
              <td class="text-right"><strong>Middle name</strong></td>
              <td>Middle name</td>
            </tr>-->
            <tr>
              <td class="text-right"><strong>@lang('messages.lastname')</strong></td>
              <td>{{$contact->lastName}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.country')</strong></td>
              <td>{{$contact->countryName}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong> @lang('messages.statename') </strong></td>
              <td>{{$contact->stateName}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.city')</strong></td>
              <td>{{$contact->cityName}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.zip')</strong></td>
              <td>{{$contact->zip}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.address') 1</strong></td>
              <td>{{$contact->address1}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.address') 2</strong></td>
              <td>{{$contact->address2}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.email')</strong></td>
              <td>{{$contact->email}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.mobilePhone')</strong></td>
              <td>{{$contact->mobilePhone}}</td>
            </tr>
            
          </table>
          <a class="btn center-block btn-rose" href="{{URL('models/dashboard/account-settings?action=edit-contact')}}">@lang('messages.editContactDetails')</a>
        </div>
    <?php } ?>
    <?php if ($action && $action == 'edit-contact') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.editContactDetails')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" ng-submit="submitUpdateContact(frmContact)" name="frmContact" novalidate method="post">
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactEmail">@lang('messages.email') </label>
              <div class="col-sm-9">
                <input type="email" name="contactEmail" class="form-control input-md" ng-model="contact.email" ng-required="true" ng-init="contact.email = '{{$contact->email}}'" ng-maxlength="50" maxlength="50">
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.contactEmail.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmContact.contactEmail.$error.email">
        Not valid email!</span>
                <span class="label label-danger" ng-show="frmContact.contactEmail.$error.maxlength">@lang('messages.emailOnlyMax50')</span>
              </div>
            </div>
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactCountryId">@lang('messages.country') </label>
              <div class="col-sm-9">
                <select class="form-control input-md" name="contactCountryId" ng-model="contact.countryId" ng-init="countryInit({{$contact->countryId}})" ng-options="country.id as country.name for country in countries" ng-required="true" ng-change="changeCountry(contact.countryId)">
                  <option value="">@lang('messages.pleaseSelectCountry')</option>
                </select>
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.contactCountryId.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="stateName">@lang('messages.state') </label>
              <div class="col-sm-9">
                <input type="text" name="stateName" id="contactCityName" ng-model="contact.stateName" class="form-control input-md" ng-init="contact.stateName = '{{$contact->stateName}}'" ng-required="true" maxlength="32">
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.stateName.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactCityName">@lang('messages.city') </label>
              <div class="col-sm-9">
                <input type="text" name="cityName" id="contactCityName" ng-model="contact.cityName" class="form-control input-md" ng-init="contact.cityName = '{{$contact->cityName}}'" ng-required="true" maxlength="32">
<!--                <select class="form-control input-md" name="contactCityId" ng-model="contact.cityId" ng-init="cityInit({{$contact->stateId}}, {{$contact->cityId}})" ng-options="city.id as city.name for city in cities" ng-required="true">
                  <option value="">Please select a city</option>
                </select>-->
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.cityName.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactZip">@lang('messages.zip') </label>
              <div class="col-sm-9">
                
                <input type="text" class="form-control input-md" name="contactZip" ng-model="contact.zip" ng-required="true" maxlength="10" ng-init="contact.zip='{{$contact->zip}}'">
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.contactZip.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactAddress1">@lang('messages.address') 1 </label>
              <div class="col-sm-9">
                <input type="text" name="contactAddress1" class="form-control input-md" ng-model="contact.address1" maxlength="64" ng-required="true" ng-init="contact.address1='{{$contact->address1}}'">
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.contactAddress1.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="contactAddress2">@lang('messages.address') 2</label>
              <div class="col-sm-9">
                <input type="text" name="contactAddress2" class="form-control input-md" ng-model="contact.address2" maxlength="64" ng-init="contact.address2='{{$contact->address2}}'">
              </div>
            </div>
            
            
            
             <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactMobilePhone">@lang('messages.mobilePhone') </label>
              <div class="col-sm-9">
                <input type="text" name="contactMobilePhone" class="form-control input-md" ng-model="contact.mobilePhone" maxlength="15" ng-init="contact.mobilePhone = '{{$contact->mobilePhone}}'" ng-pattern="/^[0-9]+$/" ng-minlength="10" ng-maxlength="15" ng-required="true">
                <span class="label label-danger" ng-show="frmContact.contactMobilePhone.$error.required">@lang('messages.phoneIsRequired')</span>
                  <span class="label label-danger" ng-show="frmContact.contactMobilePhone.$error.pattern">@lang('messages.phoneMustBeNumeric')</span>
                  <span class="label label-danger" ng-show="frmContact.contactMobilePhone.$error.minlength">@lang('messages.phoneMustMin10')</span>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <p class="alert alert-danger" ng-repeat="err in errors"><%err%></p>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3">
              </div>
              <div class="col-sm-9 text-center">
                
                <button type="submit" class="btn btn-rose btn-lg btn-block" ng-disabled="frmContact.$submitted && formSubmitted">@lang('messages.saveChanges')</button>
              </div>
            </div>
          </form>
        </div>
      </div><!--Edit Contact Details -->
    <?php } ?>
    <?php if ($action && $action == 'payment') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.yourPaymentDetails')</h4></div>
        <div class="panel-body">
          <table class="table table-bordered">
            <tr>
              <td class="text-right" style="width: 50%"><strong>@lang('messages.minPayment')</strong></td>
              <td>{{$paymentInfo -> minPayment}} $</td>
            </tr>
            <tr>
              <td class="text-right"><strong>Payoneer</strong></td>
              <td>{{$paymentInfo -> payoneer}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>Paypal</strong></td>
              <td>{{$paymentInfo->paypal}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.bankAccount')</strong></td>
              <td>{{$paymentInfo->bankAccount}}</td>
            </tr>
          </table>
          <a href="{{URL('models/dashboard/account-settings?action=edit-payment')}}" class="btn center-block btn-rose">@lang('messages.editPaymentDetails')</a>
        </div>
      </div><!--Payment option -->
    <?php } ?>
    <?php if ($action && $action == 'edit-payment') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.editPaymentDetails')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" ng-submit="submitUpdatePayment(frmPayment)" name="frmPayment" novalidate method="post" ng-init="paymentInit('{{$paymentInfo}}')">
            <div class="form-group required">
              <label class="col-sm-4 col-md-3 control-label" for="minPayment">Pago mínimo </label>
              <div class="col-sm-8 col-md-5">
                <select class="form-control input-md" name="minPayment" ng-model="payment.minPayment" ng-options="val.min as val.min + '$' for val in paymentValue" ng-required="true">
                  <option value="">@lang('messages.pleaseSelect')</option>
                </select>
                <span class="label label-danger" ng-show="frmPayment.$submitted && frmPayment.minPayment.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmPayment.$submitted && errors.minPayment"><%errors.minPayment[0]%></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 col-md-3 control-label" for="payoneer">Payoneer </label>
              <div class="col-sm-8 col-md-5">
                <input type="text" name="payoneer" class="form-control input-md" ng-model="payment.payoneer">
                <span class="label label-danger" ng-show="frmPayment.$submitted && frmPayment.payoneer.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmPayment.$submitted && errors.payoneer"><%errors.payoneer[0]%></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 col-md-3 control-label" for="paypal">Paypal </label>
              <div class="col-sm-8 col-md-5">
                <input type="text" name="paypal" class="form-control input-md" ng-model="payment.paypal">
                <span class="label label-danger" ng-show="frmPayment.$submitted && frmPayment.paypal.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmPayment.$submitted && errors.paypal"><%errors.paypal[0]%></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 col-md-3 control-label" for="bankAccount">@lang('messages.bankaccountwithcode') </label>
              <div class="col-sm-8 col-md-5">
                <input type="text" name="bankAccount" class="form-control input-md" ng-model="payment.bankAccount">
                <span class="label label-danger" ng-show="frmPayment.$submitted && frmPayment.bankAccount.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmPayment.$submitted && errors.bankAccount"><%errors.bankAccount[0]%></span>
              </div>
            </div>
            <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">Guardar </button></div>
          </form>
        </div>
      </div><!--Edit Payment Details -->
    <?php } ?>

    <?php if ($action && $action == 'payee-info') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.payeeInfo')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" method="POST" action="{{URL('models/dashboard/account-settings/payee-info')}}">
              @include('Studio::payeeForm', ['bankTransferOptions' => $bankTransferOptions])
             <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">@lang('messages.saveChanges')</button></div>
          </form>
        </div>
      </div>
    <?php } ?>  
    <?php if ($action && $action == 'direct-deposity') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.directDeposit')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" method="POST" action="{{URL('models/dashboard/account-settings/direct-deposity')}}">
              @include('Studio::directDepositForm', ['directDeposit' => $directDeposit])
             <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">Guardar</button></div>
          </form>
        </div>
      </div>
    <?php } ?> 
    <?php if ($action && $action == 'paxum') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.paxum')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" method="POST" action="{{URL('models/dashboard/account-settings/paxum')}}">
              @include('Studio::paxumForm', ['paxum' => $paxum])
             <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">@lang('messages.saveChanges')</button></div>
          </form>          
        </div>
      </div>
    <?php } ?> 

    <?php if ($action && $action == 'bitpay') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.bitpay')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" method="POST" action="{{URL('models/dashboard/account-settings/bitpay')}}">
              @include('Studio::bitpayForm', ['bitpay' => $bitpay])
             <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">@lang('messages.saveChanges')</button></div>
          </form>           
        </div>
      </div>
    <?php } ?> 

    <?php if ($action && $action == 'change-password') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.changePassword')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" novalidate method="POST" name="passwordForm" ng-submit="submitChangePassword(passwordForm)">
            <div class="form-group required">
              <label for="oldPassword" class="col-sm-4 col-md-3 control-label">@lang('messages.oldPassword') </label>
              <div class="col-sm-8 col-md-5">
                <input class="form-control" id="oldPassword" name="oldPassword" type="password" placeholder="" ng-model="settings.password.oldPassword" ng-required="true">
                <span class="label label-danger" ng-show="passwordForm.$submitted && passwordForm.oldPassword.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="form-group required">
              <label for="newPassword" class="col-sm-4 col-md-3 control-label">@lang('messages.newPassword') </label>
              <div class="col-sm-8 col-md-5">
                <input class="form-control" id="newPassword" name="newPassword" type="password" placeholder="" ng-model="settings.password.newPassword" ng-required="true" ng-minlength="6" ng-maxlength="30">
                <span class="label label-danger" ng-show="passwordForm.$submitted && passwordForm.newPassword.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="passwordForm.newPassword.$error.minlength">@lang('messages.passwordIsTooShort')</span>
                <span class="label label-danger" ng-show="passwordForm.newPassword.$error.maxlength">@lang('messages.passwordIsTooLong')</span>
              </div>
            </div>
            <div class="form-group required">
              <label for="newPasswordRetype" class="col-sm-4 col-md-3 control-label">@lang('messages.retypePassword') </label>
              <div class="col-sm-8 col-md-5">
                <input class="form-control" id="newPasswordRetype" name="newPasswordRetype" type="password" placeholder="" ng-model="settings.password.newPasswordRetype" ng-minlength="6" ng-maxlength="30" ng-required="true" pw-check="newPassword">
                <span class="label label-danger" ng-show="passwordForm.$submitted && passwordForm.newPasswordRetype.$error.required">@lang('messages.thisFieldIsRequired')</span>

                <span class="label label-danger" ng-show="passwordForm.newPasswordRetype.$viewValue.length > 0 && passwordForm.newPasswordRetype.$error.pwmatch">@lang('messages.retypePasswordNotMatch')</span>
              </div>
            </div>
            <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">@lang('messages.saveChanges')</button></div>
          </form>
        </div>
      </div><!--Change Password -->
    <?php } ?>
    <?php if ($action && $action == 'disable-account') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.disableAccount')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" method="post" ng-submit="submitDisableAccount(frmDisableAccount)" name="frmDisableAccount" novalidate>
            <div class="form-group required">
              <label for="suspendReason" class="col-sm-4 col-md-3 control-label">@lang('messages.suspensionReason') </label>
              <div class="col-sm-8 col-md-5">
                <textarea class="form-control" rows="3" name="suspendReason" id="suspend-reason" ng-model="suspend.reason" ng-required="true"></textarea>
                <span class="label label-danger" ng-show="frmDisableAccount.$submitted && frmDisableAccount.suspendReason.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="form-group required">
              <label for="suspendPass" class="col-sm-4 col-md-3 control-label">@lang('messages.enterYourPassword') </label>
              <div class="col-sm-8 col-md-5">
                <input class="form-control" id="suspendPass" name="suspendPass" ng-model="suspend.password" type="password" placeholder="" ng-required="true">
                <span class="label label-danger" ng-show="frmDisableAccount.$submitted && frmDisableAccount.suspendPass.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4 col-md-3 control-label">
              </div>
              <div class="col-sm-8 col-md-5">
                <label class="checkbox-inline">
                  <input id="suspendCheck" name="suspendCheck" value="1" ng-required="true" type="checkbox" ng-model="suspend.check">@lang('messages.iWantToSuspendMyAccount') 
                </label>
                <div class="clearfix"></div>
                <span class="label label-danger" ng-show="frmDisableAccount.$submitted && frmDisableAccount.suspendCheck.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="text-center"><button type="submit" class="btn btn-danger btn-lg" ng-disabled="frmDisableAccount.$submitted && frmDisableAccount.$valid && submitted">@lang('messages.suspendAccount')</button></div>
          </form>
        </div>
      </div> <!--Disable Account-->
    <?php } ?>

  </div> <!--user's info end-->
</div>

@endsection