@extends('Model::modelprofile')
@section('title_profile', $title)
@section('content_sub_model')

<?php 
use App\Helpers\Helper as AppHelper;
?>


@if(App::getLocale()=='en')

 <?php $cabello = array('brown'=>'Brown', 'blonde'=>'Blonde', 'black'=>'Black','red'=>'Red', 'unknown'=>'Unknown'); ?>

 <?php  $eyes = array('blue'=>'Blue', 'brown'=>'Brown', 'green'=>'Green', 'unknown'=>'Unknown'); ?>

@elseif(App::getLocale()=='fr')

 <?php $cabello = array('brown'=>'Marron', 'blonde'=>'Blond', 'black'=>'noire','red'=>'Rouge', 'unknown'=>'Inconnue'); ?>


<?php $eyes = array('blue'=>'Bleue', 'brown'=>'brun', 'green'=>'Verte', 'unknown'=>'Inconnue'); ?>

@else 

<?php  $cabello = array('brown'=>'Marrón', 'blonde'=>'Rubia', 'black'=>'Negro','red'=>'Rojo', 'unknown'=>'Desconocido'); ?>

<?php $eyes = array('blue'=>'Azul', 'brown'=>'marrón', 'green'=>'Verde', 'unknown'=>'Desconocida'); ?>

@endif

<div class="row">
  <div class="col-sm-4">
    <div class="title-main">@lang('messages.bio')</div>
    <table class="table-bio">
      <tr>
        <td><strong>@lang('messages.sex')</strong></td>
        <td>{{$model->performer->sex}}</td>
      </tr>
      <tr>
        <td><strong>@lang('messages.sexualPreference')</strong></td>
        <td>{{ucwords(str_replace('_',' ',$model->performer->sexualPreference))}}</td>
      </tr>
      <tr>
        <td><strong>@lang('messages.age')</strong></td>
        <td>{{$model->performer->age}}</td>
      </tr>
      <tr>
        <td><strong>@lang('messages.height')</strong></td>
        <td>{{$model->performer->height}}</td>
      </tr>
      <tr>
        <td><strong>@lang('messages.weight')</strong></td>
        <td>{{$model->performer->weight}}</td>
      </tr>
      <tr>
        <td><strong>@lang('messages.hair')</strong></td>
       <td>{{@$cabello[$model->performer->hair]}} </td>
      </tr>
      <tr>
        <td><strong>@lang('messages.eyes')</strong></td>
        <td>{{ucwords(str_replace('_', ' ', @$eyes[$model->performer->eyes]))}}</td>
      </tr>
      <tr>
        <td><strong>@lang('messages.ethnicity')</td>
        <td>{{ucwords(str_replace('_', ' ', $model->performer->ethnicity))}}</td>
      </tr>
      <tr>
        <td><strong>@lang('messages.languages')</strong></td>
        <td>{{ucwords($model->performer->languages)}}</td>
      </tr>
      <tr>
        <td><strong>@lang('messages.country')</strong></td>
        <td>{{$countryName}}</td>
      </tr>
    </table>
  </div>
  <div class="col-sm-4">
    <div class="title-main">@lang('messages.aboutMe')</div>
    {{$model->performer->about_me}}
  </div>
  <div class="col-sm-4">
    <div class="title-main">@lang('messages.workingHours') </div>
    <?php if($schedule): ?>
      <table class="table-bio">
        @if($schedule->timezoneDetails)
        <tr>
          <td style="width: 150px;vertical-align: top;"><strong>@lang('messages.timezone') details</strong></td>
          <td>{{$schedule->timezoneDetails}}</td>
        </tr>
        @endif
          @if($nextSchedule)
        <tr>
          <td><strong>@lang('messages.nextLiveShow')</strong></td>
          <td>{{AppHelper::getDateFormat(AppHelper::formatTimezone($nextSchedule), 'm/d/Y h\:i A')}}</td>
        </tr>
        @endif
        <tr>
          <td><strong>@lang('messages.monday')</strong></td>
          <td>{{($schedule->monday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->monday), 'h\:i A') : trans('messages.notWorking')}}</td>
        </tr>
        <tr>
          <td><strong>@lang('messages.tuesday')</strong></td>
          <td>{{($schedule->tuesday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->tuesday), 'h\:i A'): trans('messages.notWorking')}}</td>
        </tr>
        <tr>
          <td><strong>@lang('messages.wednesday')</strong></td>
          <td>{{($schedule->wednesday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->wednesday), 'h\:i A') : trans('messages.notWorking')}}</td>
        </tr>
        <tr>
          <td><strong>@lang('messages.thursday')</strong></td>
          <td>{{($schedule->thursday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->thursday), 'h\:i A') : trans('messages.notWorking')}}</td>
        </tr>
        <tr>
          <td><strong>@lang('messages.friday')</strong></td>
          <td>{{($schedule->friday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->friday), 'h\:i A') : trans('messages.notWorking')}}</td>
        </tr>
        <tr>
          <td><strong>@lang('messages.saturday')</strong></td>
          <td>{{($schedule->saturday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->saturday), 'h\:i A') : trans('messages.notWorking')}}</td>
        </tr>
        <tr>
          <td><strong>@lang('messages.sunday')</strong></td>
          <td>{{($schedule->sunday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->sunday), 'h\:i A') : trans('messages.notWorking')}}</td>
        </tr>
      </table>
    <?php endif; ?>
  </div>
</div>
@endsection   