@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name ">@lang('messages.addNewImageGallery')</div>

    </div>
  </div><!--user header end-->
  <div class="mod_settings_cont" ng-controller="modelCreateGalleryCtrl"> <!--user's info-->
    <form role='form' method="post" name="newImageGalleryForm" class="form-horizontal" ng-submit="newImageGalleryForm.$valid && submitCreateGallery(newImageGalleryForm)" novalidate>
      <div class="form-group required">
        <label class="control-label col-sm-3 text-right" for="galleryName">@lang('messages.name') </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="gallery-name" name="galleryName" ng-model="gallery.name" ng-required="true" ng-minlength="5" ng-maxlength="124">
          <span class="label label-danger" ng-show="newImageGalleryForm.$submitted && newImageGalleryForm.galleryName.$error.required">@lang('messages.thisFieldIsRequired')</span>
          <span ng-show="newImageGalleryForm.galleryName.$error.minlength" class="label label-danger">@lang('messages.enterAtLeast5Characters')</span>
        </div>
      </div>
      <div class="form-group required">
        <label class="control-label col-sm-3 text-right" for="galleryDesc">@lang('messages.description') </label>
        <div class="col-sm-9">
          <textarea class="form-control" name='galleryDesc' id="galleryDesc" ng-model="gallery.description" placeholder="Description" rows="7" maxlength="500" ng-required="true" ng-maxlength="500" ng-minlength="5"></textarea>
          <span class="label label-danger" ng-show="newImageGalleryForm.$submitted && newImageGalleryForm.galleryDesc.$error.required">@lang('messages.thisFieldIsRequired')</span>
          <span ng-show="newImageGalleryForm.galleryDesc.$error.minlength" class="label label-danger">@lang('messages.enterAtLeast5Characters')</span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label text-right" for="galleryPrice">@lang('messages.galleryPrice')</label>
        <div class="col-sm-9">
          <input type="number" name="galleryPrice" ng-model="gallery.price" class="form-control input-md" id="galleryPrice" placeholder="" value="100">
          <span class="label label-danger" ng-show="newImageGalleryForm.$submitted && errors.price">@lang('messages.pleaseEnterValidNumber')</span>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <input type="hidden" name="galleryType" ng-model="gallery.type" ng-init="gallery.type = 'image'">

        </div>

        <div class="col-sm-9 text-left"><button type="submit" id="submit" name="submit" class="btn btn-danger" ng-click="submitNewGallery(newImageGalleryForm)">@lang('messages.addImageGallery')</button></div>
      </div>

    </form>
  </div>
</div>
@endsection