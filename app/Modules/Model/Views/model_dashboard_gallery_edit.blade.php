@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name ">@lang('messages.editGallery')</div>

    </div>
  </div><!--user header end-->
  <div class="mod_settings_cont" ng-controller="modelEditGalleryCtrl" ng-init="initEdit({{$gallery}})" ng-cloak> <!--user's info-->
    <form role='form' method="post" name="editGalleryForm" class="form-horizontal" ng-submit="editGalleryForm.$valid && submitupdateGallery(editGalleryForm)" novalidate>
      <div class="form-group required">
        <label class="control-label col-sm-3 text-right" for="galleryName">@lang('messages.name') </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="gallery-name" name="galleryName" ng-model="gallery.name" ng-required="true" ng-minlength="5" ng-maxlength="124">
          <span class="label label-danger" ng-show="editGalleryForm.$submitted && editGalleryForm.galleryName.$error.required">@lang('messages.thisFieldIsRequired')</span>
          <span ng-show="editGalleryForm.galleryName.$error.minlength" class="label label-danger">@lang('messages.enterAtLeast5Characters')</span>
          <span ng-show="editGalleryForm.galleryName.$error.maxlength" class="label label-danger">@lang('messages.galaryNameMaxLength124')</span>
          <span ng-show="errors.name" class="label label-danger"><%errors.name[0]%></span>
        </div>
      </div>
      <div class="form-group required">
        <label class="control-label col-sm-3 text-right" for="galleryDesc">@lang('messages.description') </label>
        <div class="col-sm-9">
          <textarea class="form-control" name='galleryDesc' id="galleryDesc" ng-model="gallery.description" placeholder="@lang('messages.description')" rows="7" ng-required="true" ng-maxlength="500" ng-minlength="5"></textarea>
          <span class="label label-danger" ng-show="editGalleryForm.$submitted && editGalleryForm.galleryDesc.$error.required">@lang('messages.thisFieldIsRequired')</span>
          <span ng-show="editGalleryForm.galleryDesc.$error.minlength" class="label label-danger">@lang('messages.enterAtLeast5Characters')</span>
          <span ng-show="editGalleryForm.galleryDesc.$error.maxlength" class="label label-danger">@lang('messages.descriptionMaxLength500')</span>
          <span ng-show="errors.description" class="label label-danger"><%errors.description[0]%></span>
        </div>
      </div>
        <div class="form-group" ng-show="gallery.type == 'image'">
        <label class="col-sm-3 control-label text-right" for="galleryPrice">@lang('messages.galleryPrice')</label>
        <div class="col-sm-9">
          <input type="number" name="galleryPrice" ng-model="gallery.price" class="form-control input-md" id="galleryPrice" placeholder="" min="0">
          <span class="label label-danger" ng-show="editGalleryForm.galleryPrice.$error.number">@lang('messages.notValidNumber')</span>
          <span class="label label-danger" ng-show="editGalleryForm.galleryPrice.$error.min">@lang('messages.minValueIs0')</span>
          <span ng-show="errors.price" class="label label-danger"><%errors.price[0]%></span>
        </div>
      </div>
      
      <div class="form-group" ng-show="gallery.type == 'video'">
        <label class="col-sm-3 control-label text-right" for="previewImage">@lang('messages.previewImage')</label>
        <div class="col-sm-9">
          <input type="hidden" name="previewImage" ng-model="gallery.previewImage">
          <div id="preview-image-uploader">@lang('messages.upload')</div><div id="poster-status"></div>
          <img id="previewImg" ng-src="<% '{{$gallery->mediaMeta}}' | imageMedium %>" alt="" class="img-responsive">
          <span ng-show="errors.previewImage" class="label label-danger"><%errors.previewImage[0]%></span>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-3 text-right">@lang('messages.status')</label>
        <div class="col-sm-9">
         
          <label class="radio-inline">
            <input type="radio" name="galleryStatus" id="galleryStatusPrivate" ng-model="gallery.status" value="private" > @lang('messages.private')
          </label>
           <label class="radio-inline">
            <input type="radio" name="galleryStatus" id="galleryStatusPublic" value="public" ng-model="gallery.status" > @lang('messages.public')( @lang('messages.disponiblegratuitamente'))
          </label>
          <label class="radio-inline">
            <input type="radio" name="galleryStatus" id="galleryStatusPrivate" ng-model="gallery.status" value="invisible" > @lang('messages.invisible')
          </label>
            <span ng-show="errors.status" class="label label-danger"><%errors.status[0]%></span>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <input type="hidden" name="galleryType" ng-model="gallery.type">
          <input type="hidden" name="galleryId" ng-model="gallery.id">

        </div>

        <div class="col-sm-9 text-left"><button type="submit" id="submit" name="submit" class="btn btn-primary" ng-click="submitUpdateGallery(editGalleryForm)">@lang('messages.updateGallery')</button></div>
      </div>   

    </form>
  </div>
</div>
@endsection