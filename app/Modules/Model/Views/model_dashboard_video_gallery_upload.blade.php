@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name ">@lang('messages.uploadNewVideo')</div>


    </div>
  </div><!--user header end-->

  <div class="mod_settings_cont" ng-controller="modelVideoUploadCtrl" ng-init="uploadInit(0)" ng-cloak> <!--user's info-->
    <form role='form' method="post" name="newVideoForm" class="form-horizontal" role='form' ng-submit="newVideoForm.$valid && submitUploadVideo(newVideoForm)" novalidate>
      <legend>@lang('messages.movieDetails')</legend>
      <div class="col-sm-12">@lang('messages.firstlyfillinthevideodetails2')</div>
      <div class="form-group required">
        <label class="control-label col-sm-3 text-right" for="videoTitle">@lang('messages.title') </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="video-title" name="videoTitle" ng-model="video.title" ng-required="true" ng-minlength="5" ng-maxlength="124">
          <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoTitle.$error.required">@lang('messages.thisFieldIsRequired')</span>
          <span ng-show="newVideoForm.videoTitle.$error.minlength" class="label label-danger">@lang('messages.enterAtLeast5Characters')</span>
          <span class="label label-danger" ng-show="errors.title"><% errors.title[0] %></span>
        </div>
      </div>
      <div class="form-group required">
        <label class="control-label col-sm-3 text-right" for="videoTitle">@lang('messages.description') </label>
        <div class="col-sm-9">

          <textarea class="form-control" name='videoDesc' id="videoDesc" ng-model="video.description" placeholder="Description" rows="7" maxlength="500" ng-required="true" ng-maxlength="500" ng-minlength="5"></textarea>
          <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoDesc.$error.required">@lang('messages.thisFieldIsRequired')</span>
          <span ng-show="newVideoForm.videoDesc.$error.minlength" class="label label-danger">@lang('messages.enterAtLeast5Characters')</span>
          <span class="label label-danger" ng-show="errors.description"><% errors.description[0] %></span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label text-right" for="videoPrice">@lang('messages.unitPrice')</label>
        <div class="col-sm-9">
          <select class="form-control input-md" name="videoPrice" ng-model="video.price" id="performer_media_image_gallery_unit_price" ng-options="price.value as price.text for price in unitPrices">
            <option value="">@lang('messages.pleaseSelect')</option>
          </select>
          <!--<input type="number" name="videoPrice" ng-model="video.price" class="form-control input-md" id="videoPrice" placeholder="" value="">-->
          <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoPrice.$error.required">@lang('messages.thisFieldIsRequired')</span>
          <span class="label label-danger" ng-show="errors.price"><% errors.price[0] %></span>
        </div>
      </div>
      <div class="col-sm-12">
      <legend>@lang('messages.previewImage')</legend>
      <div class="form-group">
        @lang('messages.youmayselectapreviewimageforthevideo')
      </div>
      <div class="form-group">
        <input type="hidden" name="videoPoster" ng-model="video.poster" >
        <div id="video-poster-uploader">Upload</div><div id="poster-status"></div>
        <span class="label label-danger" ng-if="newVideoForm.$submitted && newVideoForm.videoPoster.$error.required">@lang('messages.thisFieldIsRequired')</span>
        <span class="label label-danger" ng-if="errors.poster"><% errors.poster[0] %></span>
      </div>
      <legend>@lang('messages.trailerVideo') </legend>
      <div class="form-group">
        @lang('messages.allowmemberstopreviewyourvideo')

      </div>
      <div class="form-group">
        <input type="hidden" name="videoTrailer" ng-model="video.trailer">
        <div id="video-trailer-uploader">@lang('messages.upload')</div><div id="video-trailer-status"></div>
        <span class="label label-danger" ng-if="newVideoForm.$submitted && newVideoForm.videoTrailer.$error.required">@lang('messages.thisFieldIsRequired')</span>
        <span class="label label-danger" ng-if="errors.trailer"><% errors.trailer[0] %></span>
      </div>
      <legend>@lang('messages.fullLengthMovie') <font color='red'>*</font></legend>
      <div class="form-group">

        @lang('messages.itstimetouploadthefullvideoyouwanttosell')
        <strong>@lang('messages.hint'):</strong> @lang('messages.ifthisisthefirstmovie')

      </div>
      <div class="form-group">
        <input type="hidden" name="videoFullMovie" ng-model="video.fullMovie" ng-required="true">
        <div id="video-full-movie-uploader">@lang('messages.upload')</div><div id="video-full-movie-status"></div>
        <span class="label label-danger" ng-if="newVideoForm.$submitted && newVideoForm.videoFullMovie.$error.required">@lang('messages.thisFieldIsRequired')</span>
        <span class="label label-danger" ng-if="errors.fullMovie"><% errors.fullMovie[0] %></span>
      </div>

      <div class="form-group">@lang('messages.uploadingContentYouComplyWithRightsToMediaPolicy')</div>
      <div class="row">
        <div class="col-sm-12 text-left"><button type="submit" id="submit" name="submit" class="btn btn-danger">@lang('messages.submitMovie')</button></div>
      </div>
      </div>
    </form>
  </div>
</div>
@endsection