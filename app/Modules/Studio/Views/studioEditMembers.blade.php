@extends('Studio::studioDashboard')
@section('title','Edit Model Profile')
@section('contentDashboard')
<?php

use App\Helpers\Helper as AppHelper; ?>

<div class="panel panel-default"> <!--user's info-->
  <div class="panel-heading">
    <h4>@lang('messages.editModel'): {{$model->username}}</h4>
  </div>
  <div class="panel-body">
    @include('Studio::memberMenu', ['modelId' => $model->id, 'activeMenu' => 'registrationInfo'])
    <br />
    <div class="mod_shedule"> <!--user's info-->
      {!! Form::open(array('method' => 'POST', 'role' => 'form')) !!}
      <div class="form-group">
        <label for="gender" class="control-label">Gender </label>
          @include('render_gender_block', array('default' => old('gender', $model->gender)))
          <label class="label label-danger">{{$errors->first('gender')}}</label>
      </div>

          <div class="form-group required">
              <label for="firstname" class="control-label">@lang('messages.firstname')</label>
            <input type="text" class="form-control" name="firstName" id="firstname" placeholder="" maxlength="32" value="{{Request::old('firstName', $model->firstName)}}">
            <label class="label label-danger">{{$errors->first('firstName')}}</label>
          </div>
          <div class="form-group required">
              <label for="lastname" class="control-label">@lang('messages.lastname') </label>
            <input type="text" class="form-control" id="lastname" name="lastName" placeholder="" maxlength="32" value="{{Request::old('lastName', $model->lastName)}}">
            <label class="label label-danger">{{$errors->first('lastName')}}</label>
          </div>
          <div class="form-group required">
              <label for="username" class="control-label">@lang('messages.username') </label>
            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="{{old('username', $model->username)}}">
            <label class="label label-danger">{{$errors->first('username')}}</label>
          </div>
          <div class="form-group required">
              <label for="email" class="control-label">@lang('messages.enterEmail') </label>
            <input type="email" class="form-control" id="email" name="email" placeholder="@lang('messages.enterEmail')" value="{{$model->email}}" disabled="disabled">
            <label class="label label-danger">{{$errors->first('email')}}</label>
          </div>
          <div class="form-group">
            <label for="passwordHash">@lang('messages.changePassword')</label>
            <span class="help-block">@lang('messages.passwordChangeEnterNewPassword')</span>
            <input type="password" class="form-control" id="passwordHash" name="passwordHash" placeholder="Password" value="{{old('passwordHash')}}">
            <label class="label label-danger">{{$errors->first('passwordHash')}}</label>
          </div>

          <div class="form-group required">
              <label for="country" class="control-label">@lang('messages.location') </label>
            {{Form::select('country', $countries, old('country', $performer->country_id), array('class'=>'form-control ', 'placeholder' => '@lang('messages.pleaseSelect')'))}}

            <label class="label label-danger">{{$errors->first('country')}}</label>
          </div>


          <legend>@lang('messages.modelpersonalinfo')</legend>

          <div class="form-group required">
            <label class="control-label" for="sexualPreference">@lang('messages.sexualPreference') </label>
            {{Form::select('sexualPreference', array('lesbian'=>'Lesbian','transsexual'=>'Transsexual','female'=>'Female', 'male'=>'Male', 'couple'=>'Couple','no_comment'=>'No Comment'), old('sexualPreference', $performer->sexualPreference), array('class'=>'form-control input-md', 'placeholder' => '@lang('messages.pleaseSelect')'))}}
            <label class="label label-danger">{{$errors->first('sexualPreference')}}</label>
          </div>
          <div class="form-group required">
            <label class="control-label" for="age">@lang('messages.age') </label>
             {{Form::selectRange('age', 18, 100, old('age', $performer->age), ['class'=>'form-control input-md', 'placeholder'=>'@lang('messages.pleaseSelect')'])}}
            <label class="label label-danger">{{$errors->first('age')}}</label>
          </div>

          <div class="form-group">
            <label class="control-label" for="ethnicity">@lang('messages.ethnicity')</label>
            {{Form::select('ethnicity', array('unknown'=>'Unknown', 'white'=>'White', 'asian'=>'Asian', 'black'=>'Black', 'india'=>'India', 'latin'=>'Latin'), old('ethnicity', $performer->ethnicity), array('class'=>'form-control input-md', 'placeholder' => '@lang('messages.pleaseSelect')'))}}

            <label class="label label-danger">{{$errors->first('ethnicity')}}</label>
          </div>
          <div class="form-group">
            <label class="control-label" for="eyes"> @lang('messages.eyes') </label>
              {{Form::select('eyes', array('blue'=>'Blue', 'brown'=>'Brown', 'green'=>'Green', 'unknown'=>'Unknown'), old('eyes', $performer->eyes), array('class'=>'form-control input-md', 'placeholder' => '@lang('messages.pleaseSelect')'))}}
            <label class="label label-danger">{{$errors->first('eye')}}</label>
          </div>
          <div class="form-group">
            <label class="control-label" for="hair">@lang('messages.hair')</label>
            {{Form::select('hair', array('brown'=>'Brown', 'blonde'=>'Blonde', 'black'=>'Black','red'=>'Red', 'unknown'=>'Unknown'), old('hair', $performer->hair), array('class'=>'form-control input-md', 'placeholder' => '@lang('messages.pleaseSelect')'))}}
            <label class="label label-danger">{{$errors->first('hair')}}</label>
          </div>
          <div class="form-group">
            <label class="control-label" for="height">@lang('messages.height')</label>
            {{Form::select('height', $heightList, old('height', $performer->height), array('class'=>'form-control input-md', 'placeholder' => '@lang('messages.pleaseSelect')'))}}
            <label class="label label-danger">{{$errors->first('height')}}</label>
          </div>
          <div class="form-group">
            <label class="control-label" for="weight">@lang('messages.weight')</label>
            {{Form::select('weight', $heightList, old('weight', $performer->weight), array('class'=>'form-control input-md', 'placeholder' => '@lang('messages.pleaseSelect')'))}}
            <label class="label label-danger">{{$errors->first('weight')}}</label>
          </div>
          <div class="form-group required">
              <label for="category" class="control-label">@lang('messages.category') </label>
              {{Form::select('category', $categories, old('category', $performer->category_id), array('class'=>'form-control ', 'placeholder' => '@lang('messages.pleaseSelect')'))}}

          <label class="label label-danger">{{$errors->first('category')}}</label>
        </div>


          <div class="form-group">
            <label class="control-label" for="pubic">@lang('messages.pubic')</label>
            {{Form::select('pubic', array('trimmed'=>'Trimmed', 'shaved'=>'Shaved', 'hairy'=>'Hairy', 'no_comment'=>'No Comment'), old('pubic', $performer->pubic), array('class'=>'form-control input-md', 'placeholder' => '@lang('messages.pleaseSelect')'))}}
            <label class="label label-danger">{{$errors->first('public')}}</label>
          </div>

          <div class="form-group">
            <label class="control-label" for="bust">@lang('messages.bust')</label>
            {{Form::select('bust', array('large'=>'Large', 'medium'=>'Medium', 'small'=>'Small', 'no_comment'=>'No Comment'), old('bust', $performer->bust), array('class'=>'form-control input-md', 'placeholder' => '@lang('messages.pleaseSelect')'))}}
            <span class="label label-danger">{{$errors->first('bust')}}</span>
          </div>

        <div class="form-group">
            <label class="control-label">@lang('messages.tags')</label>
            <input type="text" name="tags" value="{{old('tags', $performer->tags)}}"
                   data-role="tagsinput" id="tagsinput" class="form-control input-md tag-input"/>
            <label class="help-block">@lang('messages.tagHelpBlock')</label>
            <span class="label label-danger">{{$errors->first('tags')}}</span>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-rose btn-lg btn-block">@lang('messages.save')</button>

        </div>
        {{Form::close()}}
    </div>
  </div> <!--user's info end-->
</div>
@endsection
