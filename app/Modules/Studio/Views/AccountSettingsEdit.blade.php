@extends('Studio::studioDashboard')
@section('title','Edit Account')
@section('contentDashboard')
<div class="content">
  <div class="full-container">
    @include('Studio::accountSettingMenu', ['activeMenu' => 'account-settings'])
      {{Form::open(array('method'=>'post', 'class'=>'form-horizontal', 'name'=>'frmSettings', 'novalidate'=>'novalidate','enctype' => 'multipart/form-data'))}}
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.accountInformation')</h4></div>
        <div class="panel-body">
          
            <div class="form-group required hidden">
                <label for="gender" class="col-sm-3 control-label">@lang('messages.gender') </label>
                <div class=" col-sm-9" id="gender-group">
                    @include('render_gender_block', array('default' => $user->gender))
                </div>
            <label class="label label-danger col-sm-offset-3">{{$errors->first('gender')}}</label>
          </div>

          <div class="form-group required hidden">
              <label for="firstname" class="control-label col-sm-3">@lang('messages.firstname') </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="firstName" id="firstname" placeholder="" maxlength="32" value="{{Request::old('firstName', $user->firstName)}}">
                <label class="label label-danger">{{$errors->first('firstName')}}</label>
              </div>
          </div>
          <div class="form-group required hidden">
              <label for="lastname" class="control-label col-sm-3">@lang('messages.lastname') </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="lastname" name="lastName" placeholder="" maxlength="32" value="{{Request::old('lastName', $user->lastName)}}">
                <label class="label label-danger">{{$errors->first('lastName')}}</label>
              </div>
          </div>
          <div class="form-group required">
              <label for="studioName" class="control-label col-sm-3">@lang('messages.studioname') </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="studioName" name="studioName" placeholder="" maxlength="32" value="{{Request::old('studioName', $user->studioName)}}">
                <label class="label label-danger">{{$errors->first('studioName')}}</label>
              </div>
          </div>
          <div class="form-group required">
              <label for="username" class="control-label col-sm-3">@lang('messages.username') </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="{{old('username', $user->username)}}">
                <label class="label label-danger">{{$errors->first('username')}}</label>
              </div>
          </div>
          <div class="form-group required">
              <label for="email" class="control-label col-sm-3">@lang('messages.enterEmail') </label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{old('email', $user->email)}}">
                <label class="label label-danger">{{$errors->first('email')}}</label>
              </div>
          </div>
          
            <div class="form-group required">
                {{Form::label('country', Lang::get('messages.country'), array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    {{Form::select('country', $countries, old('country', $user->countryId), array('class'=>'form-control', 'placeholder'=>'Please select'))}}
                    <span class="label label-danger">{{$errors->first('country')}}</span>
                </div>
                
                
            </div>
            <div class="form-group required">
                {{Form::label('state', Lang::get('messages.state'), array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    {{Form::text('state', old('state', $user->stateName), array('class'=>'form-control', 'placeholder'=>Lang::get('messages.statename')))}}
                    <span class="label label-danger">{{$errors->first('state')}}</span>
                </div>
            </div>
            <div class="form-group required">
                {{Form::label('city', Lang::get('messages.city'), array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    {{Form::text('city', old('city', $user->cityName), array('class'=>'form-control', 'placeholder'=>Lang::get('messages.city')))}}
                    <span class="label label-danger">{{$errors->first('city')}}</span>
                </div>
            </div>
            <div class="form-group required">
                {{Form::label('zip', 'Zip ', array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    {{Form::text('zip', old('zip', $user->zip), array('class'=>'form-control', 'placeholder'=>'Zip'))}}
                    <span class="label label-danger">{{$errors->first('zip')}}</span>
                </div>
            </div>
            <div class="form-group required">
                {{Form::label('address1', Lang::get('messages.address1'), array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    {{Form::text('address1', old('address1', $user->address1), array('class'=>'form-control', 'placeholder'=>Lang::get('messages.address1')))}}
                    <span class="label label-danger">{{$errors->first('address1')}}</span>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('address2', Lang::get('messages.address2'), array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    {{Form::text('address2', old('address2', $user->address2), array('class'=>'form-control', 'placeholder'=> Lang::get('messages.address2')))}}
                    <span class="label label-danger">{{$errors->first('address2')}}</span>
                </div>
            </div>
            <div class="form-group required">
                {{Form::label('mobilePhone', Lang::get('messages.mobilePhone'), array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    {{Form::text('mobilePhone', old('mobilePhone', $user->mobilePhone), array('class'=>'form-control', 'placeholder'=>Lang::get('messages.mobilePhone')))}}
                    <span class="label label-danger">{{$errors->first('mobilePhone')}}</span>
                </div> 
            </div>
            <div class="form-group">
                {{Form::label('minPayment', Lang::get('messages.minPayment'), array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    {{Form::select('minPayment', array(20=>'20$', 50=>'50$', 100=>'100$', 200=>'200$', 250=>'250$', 500=>'500$', 1000=>'1000$'), old('minPayment', $user->minPayment), array('class'=>'form-control', 'placeholder'=>'Please select'))}}
                    <span class="label label-danger">{{$errors->first('minPayment')}}</span>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('payoneer', 'Payoneer', array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    {{Form::text('payoneer', old('payoneer', $user->payoneer), array('class'=>'form-control', 'placeholder'=>'Payoneer'))}}
                    <span class="label label-danger">{{$errors->first('payoneer')}}</span>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('paypal', 'Paypal', array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    {{Form::text('paypal', old('paypal', $user->paypal), array('class'=>'form-control', 'placeholder'=>'Paypal'))}}
                    <span class="label label-danger">{{$errors->first('paypal')}}</span>
                </div>
            </div>
            <div class="form-group"> 
                {{Form::label('bankAccount', Lang::get('messages.bankaccountwithcode') , array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    {{Form::text('bankAccount', old('bankAccount', $user->bankAccount), array('class'=>'form-control', 'placeholder'=>Lang::get('messages.bankaccountwithcode')))}}
                    <span class="label label-danger">{{$errors->first('bankAccount')}}</span>
                </div>
            </div>
            <div class="form-group"> 
                {{Form::label('studioProff', Lang::get('messages.Submityourcompanyregistrationcertificate') , array('class'=>'control-label col-sm-3'))}}
                <div class="col-sm-9">
                    <input name="studioProff" id="studioProff" type="file" accept=".doc,.docx,.pdf"/>
                    <span class="label label-danger">{{$errors->first('studioProff')}}</span>
                    @if($document && $document->studioProff)
                        <a class="btn btn-link" href="{{URL($document->studioProff)}}" target="_blank">View</a>
                @endif
                </div>
            </div>
            <div class="form-group">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-9 text-center">
                {{Form::submit(Lang::get('messages.saveChanges'), array('class'=>'btn btn-rose btn-lg btn-block'))}}
              
            </div>
          </div>
            
        </div>
      </div>
    {{Form::close()}}
  </div>
</div>
  @endsection