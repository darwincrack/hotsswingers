@extends('admin-back-end')
@section('title', 'Editar información de video')
@section('breadcrumb', '<li><a href="/admin/manager/media/video-gallery/'.$video->galleryId.'"><i class="fa fa-dashboard"></i> Videos</a></li><li class="active">Editar video</li>')
@section('content')

<div class="row">
  <section class="content col-md-12">
    <div class="box body-primary">
      <div class="box-header"> <h3 class="box-title">{{$video -> title}}</h3></div>
      <div class="panel-body" ng-controller="modelVideoUploadCtrl" ng-init="uploadInit({{$video -> galleryId}}, {{$video->ownerId}})" ng-cloak>
        <form role='form' method="post" name="editVideoForm" class="form-horizontal" ng-submit="editVideoForm.$valid && submitUpdateVideo(editVideoForm)" novalidate>
          <div class="box-body">
            <div class="form-group required">
              <label class="control-label col-sm-3">Galería </label>
              <div class="col-sm-9">
                <select class="form-control input-md" name="videoGallery" ng-model="video.galleryId" ng-options="gallery.id as gallery.name for gallery in galleries" ng-required="true">
                  <option value="">Por favor seleccione</option>
                </select>
                <span class="label label-danger" ng-show="editVideoForm.$submitted && editVideoForm.videoGallery.$error.required">Este campo es requerido.</span>
                <span class="label label-danger" ng-show="errors.galleryId"><%errors.galleryId[0]%></span>       
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-sm-3 text-right" for="videoTitle">Título </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="video-title" name="videoTitle" ng-model="video.title" ng-required="true" ng-minlength="5" ng-maxlength="124" ng-init="video.title ='{{$video -> title}}'">
                <span class="label label-danger" ng-show="editVideoForm.$submitted && editVideoForm.videoTitle.$error.required">Este campo es requerido.</span>
                <span ng-show="editVideoForm.videoTitle.$error.minlength" class="label label-danger">Introduzca al menos 5 caracteres.</span>
                <span class="label label-danger" ng-show="errors.title"><%errors.title[0]%></span>
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-sm-3 text-right" for="videlDesc">Descripción </label>
              <div class="col-sm-9">
                <textarea class="form-control" name='videoDesc' id="videoDesc" ng-model="video.description" placeholder="Description" rows="7" maxlength="500" ng-required="true" ng-maxlength="500" ng-minlength="5" ng-init="video.description ='{{$video -> description}}'"></textarea>
                <span class="label label-danger" ng-show="editVideoForm.$submitted && editVideoForm.videoDesc.$error.required">Este campo es requerido.</span>
                <span ng-show="editVideoForm.videoDesc.$error.minlength" class="label label-danger">Introduzca al menos 5 caracteres.</span>
                <span class="label label-danger" ng-show="errors.description"><%errors.description[0]%></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label text-right" for="videoPrice">Precio unitario</label>
              <div class="col-sm-9">
                <select class="form-control input-md" name="videoPrice" ng-model="video.price" ng-required="true" id="performer_media_image_gallery_unit_price" ng-options="price.value as price.text for price in unitPrices" ng-init="video.price={{$video -> price}}">
                  <option value="">Por favor seleccione</option>
                </select>
                <!--<input type="number" name="videoPrice" ng-model="video.price" class="form-control input-md" id="videoPrice" placeholder="" value="">-->
                <span class="label label-danger" ng-show="editVideoForm.$submitted && editVideoForm.videoPrice.$error.required">Este campo es requerido.</span>
                <span class="label label-danger" ng-show="errors.price"><%errors.price[0]%></span>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-3">
                <input type="hidden" name="videoId" ng-model="video.id" ng-init="video.id={{$video -> id}}">
              </div>
              <div class="col-sm-9 text-left"><button type="submit" id="submit" name="submit" class="btn btn-info">Actualizar la información del video</button></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
@endsection