@extends('admin-back-end')
@section('title', 'Editar imagen')
@section('breadcrumb', '<li><a href="/admin/manager/image-gallery/'.$modelId.'"><i class="fa fa-dashboard"></i> Galerías</a></li><li class="active">Agregar nueva imagen</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Actualizar Imagen</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <div class="mod_settings_cont" ng-controller="modelEditGalleryCtrl" ng-init="initEdit({{$gallery}}, {{$attachment->id}})" ng-cloak> <!--user's info-->
	    <form role='form' method="post" name="editGalleryForm" class="form-horizontal" ng-submit="editGalleryForm.$valid && submitUpdateImage(editGalleryForm, {{$modelId}})" novalidate>
	      <div class="form-group required">
	        <label class="control-label col-sm-3 text-right" for="galleryName">Nombre </label>
	        <div class="col-sm-9">
	          <input type="text" class="form-control" id="gallery-name" name="galleryName" ng-model="gallery.name" ng-required="true" ng-minlength="5" ng-maxlength="124">
	          <span class="label label-danger" ng-show="editGalleryForm.$submitted && editGalleryForm.galleryName.$error.required">Este campo es requerido.</span>
	          <span ng-show="editGalleryForm.galleryName.$error.minlength" class="label label-danger">Introduzca al menos 5 caracteres.</span>
	          <span ng-show="editGalleryForm.galleryName.$error.maxlength" class="label label-danger">La longitud máxima del nombre de la galería es de 124 caracteres.</span>
	          <span ng-show="errors.name" class="label label-danger"><%errors.name[0]%></span>
	        </div>
	      </div>
	      <div class="form-group required">
	        <label class="control-label col-sm-3 text-right" for="galleryDesc">Descripción </label>
	        <div class="col-sm-9">
	          <textarea class="form-control" name='galleryDesc' id="galleryDesc" ng-model="gallery.description" placeholder="Descripción" rows="7" ng-required="true" ng-maxlength="500" ng-minlength="5"></textarea>
	          <span class="label label-danger" ng-show="editGalleryForm.$submitted && editGalleryForm.galleryDesc.$error.required">Este campo es requerido.</span>
	          <span ng-show="editGalleryForm.galleryDesc.$error.minlength" class="label label-danger">Introduzca al menos 5 caracteres.</span>
	          <span ng-show="editGalleryForm.galleryDesc.$error.maxlength" class="label label-danger">La longitud máxima de la descripción es de 500 caracteres.</span>
	          <span ng-show="errors.description" class="label label-danger"><%errors.description[0]%></span>
	        </div>
	      </div>
	      <div class="form-group required">
	        <label class="control-label col-sm-3 text-right" for="galleryDesc">Imagen </label>
	        <div class="col-sm-9">
	          <input class="input-file" id="fileInputImage" type="file" name="file" accept="image/*" />
	          <span ng-show="errors.image" class="label label-danger"><%errors.image%></span>
	          <br/>
	          <img src="/{{$attachment->path}}" class="editimage__preview-image"/>
	          <br/>
	        </div>
	      </div>
	        <div class="form-group" ng-show="gallery.type == 'image'">
	        <label class="col-sm-3 control-label text-right" for="galleryPrice">Precio de la galería</label>
	        <div class="col-sm-9">
	          <input type="number" name="galleryPrice" ng-model="gallery.price" class="form-control input-md" id="galleryPrice" placeholder="" min="0">
	          <span class="label label-danger" ng-show="editGalleryForm.galleryPrice.$error.number">Número no válido.</span>
	          <span class="label label-danger" ng-show="editGalleryForm.galleryPrice.$error.min">¡El valor mínimo es 0!</span>
	          <span ng-show="errors.price" class="label label-danger"><%errors.price[0]%></span>
	        </div>
	      </div>
	      
	      <div class="form-group">
	        <label class="control-label col-sm-3 text-right">Status</label>
	        <div class="col-sm-9">
	          <label class="radio-inline">
	            <input type="radio" name="galleryStatus" id="galleryStatusPublic" value="public" ng-model="gallery.status" > Publico
	          </label>
	          <label class="radio-inline">
	            <input type="radio" name="galleryStatus" id="galleryStatusPrivate" ng-model="gallery.status" value="private" > Privado
	          </label>
	          <label class="radio-inline">
	            <input type="radio" name="galleryStatus" id="galleryStatusPrivate" ng-model="gallery.status" value="invisible" > Invisible
	          </label>
	            <span ng-show="errors.status" class="label label-danger"><%errors.status[0]%></span>
	        </div>
	      </div>
	      <div class="row">
	        <div class="col-sm-3">
	          <input type="hidden" name="galleryType" ng-model="gallery.type">
	          <input type="hidden" name="galleryId" ng-model="gallery.id">
	        </div>

	        <div class="col-sm-9 text-left"><button type="submit" id="submit" name="submit" class="btn btn-primary">Actualizar imagen</button></div>
	      </div>

	    </form>
	  </div>

    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
