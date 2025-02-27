@extends('admin-back-end')
@section('title', 'Agregar galería')
@section('breadcrumb', '<li><a href="/admin/manager/video-gallery/'.$user->id.'"><i class="fa fa-dashboard"></i> Galerías</a></li><li class="active">Agregar nueva galería</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Agregar nueva galería</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <div class="" ng-controller="modelCreateGalleryCtrl" ng-cloak> <!--user's info-->
        <form role='form' method="post" name="newGalleryForm" class="form-horizontal" ng-submit="newGalleryForm.$valid && submitCreateGallery(newGalleryForm)" novalidate>
          <div class="box-body">
            <div class="form-group required">
              <label class="control-label col-sm-3 text-right" for="galleryName">Nombre </label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="gallery-name" name="galleryName" ng-model="gallery.name" ng-required="true" ng-minlength="5" ng-maxlength="124">
                <span class="label label-danger" ng-show="newGalleryForm.$submitted && newGalleryForm.galleryName.$error.required">Este campo es requerido.</span>
                <span ng-show="newGalleryForm.galleryName.$error.minlength" class="label label-danger">Introduzca al menos 5 caracteres.</span>
                <span ng-show="errors.name" class="label label-danger"><%errors.name[0]%></span>
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-sm-3 text-right" for="galleryDesc">Descripción</label>
              <div class="col-sm-8">
                <textarea class="form-control" name='galleryDesc' id="galleryDesc" ng-model="gallery.description" placeholder="Descripción" rows="7" maxlength="500" ng-required="true" ng-maxlength="500" ng-minlength="5"></textarea>
                <span class="label label-danger" ng-show="newGalleryForm.$submitted && newGalleryForm.galleryDesc.$error.required">Este campo es requerido.</span>
                <span ng-show="newGalleryForm.galleryDesc.$error.minlength" class="label label-danger">Introduzca al menos 5 caracteres.</span>
                <span ng-show="errors.description" class="label label-danger"><%errors.description[0]%></span>
              </div>
            </div>
              <div class="form-group" ng-show="gallery.type == 'image'">
              <label class="col-sm-3 control-label text-right" for="galleryPrice">Precio de la galería</label>
              <div class="col-sm-8">
                <input type="number" name="galleryPrice" ng-model="gallery.price" class="form-control input-md" id="galleryPrice" placeholder="" value="100" min="0">
                <span class="label label-danger" ng-show="newGalleryForm.galleryPrice.$error.number">Número no válido.</span>
                <span class="label label-danger" ng-show="newGalleryForm.galleryPrice.$error.min">¡El valor mínimo es 0!</span>
                <span ng-show="errors.price" class="label label-danger"><%errors.price[0]%></span>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <input type="hidden" name="galleryType" ng-model="gallery.type" ng-init="gallery.type = '{{$galleryType}}'">
                <input type="hidden" ng-init="gallery.model_id = '{{$user -> id}}'">

              </div>

              <div class="col-sm-8 text-left">
                <button type="submit" id="submit" name="submit" class="btn btn-info" ng-disabled="submitted">Agregar galería</button></div>
            </div>
          </div>

        </form>
      </div>

    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
