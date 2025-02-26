@extends('Member::member_profile')
@section('content_sub_member')
<?php

use App\Helpers\Helper as AppHelper;
?>
<div class="form_block">
  <div class="l_i_name ">@lang('messages.yourProfileMemberControl')</div>
  <div class="dashboard-long-item">
    <div class="l_i_text">
      <span>@lang('messages.viewingProfileMemberControl')</span>
    </div>
  </div>
  @if(session('msgInfo'))<div class="alert alert-success">{{session('msgInfo')}}</div>@endif
  
    {!! Form::open(array('url' => 'members/profile', 'method' => 'POST', 'role' => 'form', 'files'=>true, 'accept-charset'=>'utf-8', 'class'=>'form-horizontal')) !!}
    <div class="form-group <?= $errors->has('email') ? 'has-error' : '' ?>">
      <label for="email" class="col-sm-3 control-label ">@lang('messages.email')</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= $getMember->email ?>" name="email" id="email" placeholder="" type="text">
        <span class="required help-block">{{$errors->first('email')}}</span>
      </div>
    </div>
    <div class="form-group">
      <label for="visib" class="col-sm-3 control-label ">@lang('messages.profileVisibility')</label>
      <div class="col-sm-9">
        <select class="form-control " name="visible" id="visib">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['visible'] === 1) ? 'selected=selected' : '' ?> value="1">@lang('messages.onlyPerformers')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['visible'] === 0) ? 'selected=selected' : '' ?> value="0">@lang('messages.authenticatedMembers')</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="country" class="col-sm-3 control-label ">@lang('messages.country')</label>
      <div class="col-sm-9">
          {{Form::select('country', $countries, old('country', $getMember->location_id), array('class'=>'form-control', 'placeholder'=>'Please select'))}}
        
      </div>
    </div>
    <div class="form-group <?= $errors->has('state') ? 'has-error' : '' ?>">
      <label for="state" class="col-sm-3 control-label ">@lang('messages.state')</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= AppHelper::getUserMeta($getMember->userMeta)['state'] ?>" name="state" id="state" placeholder="" type="text">
        <span class="required help-block">{{$errors->first('state')}}</span>
      </div>
    </div>
    <div class="form-group <?= $errors->has('city') ? 'has-error' : '' ?>">
      <label for="city" class="col-sm-3 control-label ">@lang('messages.cityName')</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= AppHelper::getUserMeta($getMember->userMeta)['city'] ?>" name="city" id="city" placeholder="" type="text">
        <span class="required help-block">{{$errors->first('city')}}</span>
      </div>
    </div>
    <div class="form-group ">
      <label for="sex" class="col-sm-3 control-label ">dsfsd @lang('messages.sex')</label>
      <div class="col-sm-9">
        <select class="form-control " name="sex" id="sex">
          <option <?= ($getMember->gender === 'male') ? 'selected=selected' : '' ?> value="male">@lang('messages.male')</option>
          <option <?= ($getMember->gender === 'female') ? 'selected=selected' : '' ?> value="female">@lang('messages.female')</option>
          <option <?= ($getMember->gender === 'transgender') ? 'selected=selected' : '' ?> value="female">@lang('messages.buy')Transgender</option>
          <option <?= ($getMember->gender === 'not-telling') ? 'selected=selected' : '' ?> value="not-telling">@lang('messages.notTelling')</option>
        </select>
      </div>
    </div>
    <div class="form-group <?= $errors->has('birthdate') ? 'has-error' : '' ?>">
      <label for="birthdate" class="col-sm-3 control-label ">@lang('messages.birthdate')</label>
      <div class="col-sm-9">
        <input type="date" class="form-control " value="<?= $getMember->birthdate ?>" name="birthdate" id="birthdate"  value="" placeholder="">
        <span class="required help-block">{{$errors->first('birthdate')}}</span>
      </div>
    </div>
    <div class="form-group">
      <label for="sign" class="col-sm-3 control-label ">@lang('messages.starSign')</label>
      <div class="col-sm-9">
        <select class="form-control " name="starSign" id="sign">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Aries') ? 'selected=selected' : '' ?> value="Aries">@lang('messages.aries')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Taurus') ? 'selected=selected' : '' ?> value="Taurus">@lang('messages.taurus')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Gemini') ? 'selected=selected' : '' ?> value="Gemini">@lang('messages.gemini')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Cancer') ? 'selected=selected' : '' ?> value="Cancer">@lang('messages.cancer')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Leo') ? 'selected=selected' : '' ?> value="Leo">@lang('messages.notTelling')Leo</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Virgo') ? 'selected=selected' : '' ?> value="Virgo">@lang('messages.Virgo')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Libra') ? 'selected=selected' : '' ?> value="Libra">@lang('messages.Libra')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Scorpio') ? 'selected=selected' : '' ?> value="Scorpio">@lang('messages.Scorpio')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Sagittarius') ? 'selected=selected' : '' ?> value="Sagittarius">@lang('messages.notTelling')Sagittarius</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Capricorn') ? 'selected=selected' : '' ?> value="Capricorn">@lang('messages.capricorn')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Aquarius') ? 'selected=selected' : '' ?> value="Aquarius">@lang('messages.aquarius')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Pisces') ? 'selected=selected' : '' ?> value="Pisces">@lang('messages.pisces')</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="eyes" class="col-sm-3 control-label ">@lang('messages.eyesColor')</label>
      <div class="col-sm-9">
        <select class="form-control " name="eyesColor" id="eyes">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['eyesColor'] === 'Brown') ? 'selected=selected' : '' ?> value="Brown">Brown</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['eyesColor'] === 'Green') ? 'selected=selected' : '' ?> value="Green">Green</option>

        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="hair" class="col-sm-3 control-label ">@lang('messages.hairColor')</label>
      <div class="col-sm-9">
        <select class="form-control " name="hairColor" id="hair">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['hairColor'] === 'Black') ? 'selected=selected' : '' ?> value="Black">Black</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['hairColor'] === 'Red') ? 'selected=selected' : '' ?> value="Red">Red</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['hairColor'] === 'Yellow') ? 'selected=selected' : '' ?> value="Yellow">Yellow</option>
        </select>
      </div>
    </div>
    <div class="form-group <?= $errors->has('height') ? 'has-error' : '' ?>">
      <label for="height" class="col-sm-3 control-label ">@lang('messages.height')</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= AppHelper::getUserMeta($getMember->userMeta)['height'] ?>" id="height" name="height" placeholder="Height" type="text">
        <span class="required help-block">{{$errors->first('height')}}</span>
      </div>
    </div>
    <div class="form-group <?= $errors->has('ethnicity') ? 'has-error' : '' ?>">
      <label for="ethnicity" class="col-sm-3 control-label ">@lang('messages.ethnicity')</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= AppHelper::getUserMeta($getMember->userMeta)['ethnicity'] ?>"  name="ethnicity" id="ethnicity" placeholder="Ehnicity" type="text">
        <span class="required help-block">{{$errors->first('ethnicity')}}</span>
      </div>
    </div>
    <div class="form-group">
      <label for="build" class="col-sm-3 control-label ">@lang('messages.build')</label>
      <div class="col-sm-9">
        <select class="form-control " name="build" id="build">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['build'] === 'slender') ? 'selected=selected' : '' ?> value="slender">Slender</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['build'] === 'large') ? 'selected=selected' : '' ?> value="large">Large</option>
        </select>
      </div>
    </div>
    <div class="form-group <?= $errors->has('appearance') ? 'has-error' : '' ?>">
      <label for="appearance" class="col-sm-3 control-label ">@lang('messages.appearance')</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= AppHelper::getUserMeta($getMember->userMeta)['appearance'] ?>" name="appearance" id="appearance" placeholder="appearance" type="text">
        <span class="required help-block">{{$errors->first('appearance')}}</span>
      </div>
    </div>
    <div class="form-group">
      <label for="status" class="col-sm-3 control-label ">@lang('messages.maritalStatus')</label>
      <div class="col-sm-9">
        <select class="form-control " name="marital" id="status">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['marital'] === 1) ? 'selected=selected' : '' ?> value="1">@lang('messages.married')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['marital'] === 0) ? 'selected=selected' : '' ?> value="0">@lang('messages.noComments')</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="orient" class="col-sm-3 control-label ">@lang('messages.sexualOrientation')</label>
      <div class="col-sm-9">
        <select class="form-control " name="orient" id="orient">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['orient'] === 1) ? 'selected=selected' : '' ?> value="1">@lang('messages.notTelling')</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['orient'] === 0) ? 'selected=selected' : '' ?> value="0">@lang('messages.noComments')</option>
        </select>
      </div>
    </div>
    <div class="form-group ">
      <label class="col-sm-3 control-label ">@lang('messages.lookingFor')</label>
      <div class="col-sm-9">
        <div class="row look_checkbox">
          <label class="col-xs-4">
            <input name="looking[]" <?= isset(AppHelper::getUserMeta($getMember->userMeta)['looking']) ? (in_array('not-telling', AppHelper::getUserMeta($getMember->userMeta)['looking'])) ? 'checked' : 'checked' : '' ?> value="not-telling" type="checkbox"> Not Teling
          </label>
          <label class="col-xs-4">
            <input name="looking[]" <?= isset(AppHelper::getUserMeta($getMember->userMeta)['looking']) ? (in_array('female', AppHelper::getUserMeta($getMember->userMeta)['looking'])) ? 'checked' : '' : '' ?> value="female" type="checkbox"> @lang('messages.female')
          </label>
          <label class="col-xs-4">
            <input name="looking[]" <?= isset(AppHelper::getUserMeta($getMember->userMeta)['looking']) ? (in_array('male', AppHelper::getUserMeta($getMember->userMeta)['looking'])) ? 'checked' : '' : '' ?> value="male" type="checkbox"> @lang('messages.male')
          </label>
        </div>
      </div>
    </div>
    <div class="form-group <?= $errors->has('aboutMe') ? 'has-error' : '' ?>">
      <label for="aboutme"  class="col-sm-3 control-label ">@lang('messages.aboutMe')</label>
      <div class="col-sm-9">
        <textarea class="form-control " name="aboutMe" rows="3" id="aboutme"><?= $getMember->bio ?></textarea>
        <span class="required help-block">{{$errors->first('aboutMe')}}</span>
      </div>
    </div>
    <div class="form-group <?= $errors->has('avatar') ? 'has-error' : '' ?>">
      <label class="col-sm-3 control-label ">@lang('messages.avatar')</label>
      <span class="required help-block">{{$errors->first('avatar')}}</span>
      <div class="col-sm-9 imgFile">
        <input type="file" name="avatar" id="imgFile">
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
      <div class="col-sm-3">
      </div>
      <div class="col-sm-9 text-center">
        <button type="submit" class="btn btn-rose btn-lg btn-block">@lang('messages.update')</button>
      </div>
    </div>
  {!!Form::close()!!}
</div>
@endsection