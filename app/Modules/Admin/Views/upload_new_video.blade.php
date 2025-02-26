<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Subir video')
@section('breadcrumb', '<li><a href="/admin/manager/video-gallery/'.$modelId.'"><i class="fa fa-dashboard"></i> Videos</a></li><li class="active">Subir video
<div class="row">
  <!-- left column -->
  <div class="col-md-8">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Subir video</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <div class="" ng-controller="modelVideoUploadCtrl" ng-init="uploadInit({{$galleryId}}, {{$modelId}})" ng-cloak> <!--user's info-->
        <form role='form' method="post" name="newVideoForm" ng-submit="newVideoForm.$valid && submitUploadVideo(newVideoForm)" novalidate>
          <div class="box-body">
            <legend>Detalles de la película</legend>
            <div class="form-group">Primero complete los detalles del video. Ingrese un título y una descripción atractivos para atraer la atención de los miembros. Puede cambiar estos detalles más tarde</div>
            <div class="form-group required">
              <label class="control-label col-sm-3">Galería </label>
              <div class="col-sm-9">
                <select class="form-control input-md" name="videoGallery" ng-model="video.galleryId" ng-options="gallery.id as gallery.name for gallery in galleries" ng-required="true">
                  <option value="">Por favor seleccione</option>
                </select>
                <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoGallery.$error.required">Este campo es requerido.</span>
                <span class="label label-danger" ng-show="errors.galleryId"><% errors.galleryId[0] %></span>
              </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="form-group required">
              <label class="control-label col-sm-3 text-right" for="videoTitle">Título </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="video-title" name="videoTitle" ng-model="video.title" ng-required="true" ng-minlength="5" ng-maxlength="124">
                <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoTitle.$error.required">Este campo es requerido.</span>
                <span ng-show="newVideoForm.videoTitle.$error.minlength" class="label label-danger">Introduzca al menos 5 caracteres.</span>
                <span class="label label-danger" ng-show="errors.title"><% errors.title[0] %></span>
              </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="form-group required">
              <label class="control-label col-sm-3 text-right" for="videlDesc">Descripción</label>
              <div class="col-sm-9">
                <textarea class="form-control" name='videoDesc' id="videoDesc" ng-model="video.description" placeholder="Description" rows="7" maxlength="500" ng-required="true" ng-maxlength="500" ng-minlength="5"></textarea>
                <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoDesc.$error.required">Este campo es requerido.</span>
                <span ng-show="newVideoForm.videoDesc.$error.minlength" class="label label-danger">Introduzca al menos 5 caracteres.</span>
                <span class="label label-danger" ng-show="errors.description"><% errors.description[0] %></span>
              </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="form-group">
              <label class="col-sm-3 control-label text-right" for="videoPrice">Precio unitario</label>
              <div class="col-sm-9">
                <select class="form-control input-md" name="videoPrice" ng-model="video.price" id="performer_media_image_gallery_unit_price" ng-options="price.value as price.text for price in unitPrices">
                  <option value="">Por favor seleccione</option>
                </select>
                <!--<input type="number" name="videoPrice" ng-model="video.price" class="form-control input-md" id="videoPrice" placeholder="" value="">-->
                <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoPrice.$error.required">Este campo es requerido.</span>
                <span class="label label-danger" ng-show="errors.price"><% errors.price[0] %></span>
              </div>
            </div>
            <legend>VISTA PREVIA DE LA IMAGEN <font color='red'>*</font></legend>
            <div class="form-group">
              Puede seleccionar una imagen de vista previa para el video.
               Sugerencia: si no carga una imagen, se generará una automáticamente a partir de la película como captura de pantalla.
            </div>
            <div class="form-group">
              <input type="hidden" name="videoPoster" ng-model="video.poster" ng-required="true">
              <div id="video-poster-uploader">Subir</div><div id="poster-status"></div>
              <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoPoster.$error.required">Este campo es requerido.</span>
              <span class="label label-danger" ng-show="errors.poster"><% errors.poster[0] %></span>
            </div>
            <legend>VIDEO TRÁILER <font color='red'>*</font></legend>
            <div class="form-group">
              Permita que los miembros obtengan una vista previa de su video subiendo un breve avance. Pista: sube un tráiler pegadizo para atraer y convencer a los miembros de que compren el vídeo completo.

            </div>
            <div class="form-group">
              <input type="hidden" name="videoTrailer" ng-model="video.trailer" ng-required="true">
              <div id="video-trailer-uploader">Subir</div><div id="video-trailer-status"></div>
              <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoTrailer.$error.required">Este campo es requerido.</span>
              <span class="label label-danger" ng-show="errors.trailer"><% errors.trailer[0] %></span>
            </div>
            <legend>PELÍCULA DE DURACIÓN COMPLETA <font color='red'>*</font></legend>
            <div class="form-group">

             Es hora de subir el video completo que desea vender.
              <strong>Insinuación:</strong> Si esta es la primera película que agrega a Premium Media, elija una de las mejores &amp; más caliente! ¡Te ayudará a destacar entre la multitud y conseguir fans que querrán verte más!

            </div>
            <div class="form-group">
              <input type="hidden" name="videoFullMovie" ng-model="video.fullMovie" ng-required="true">
              <div id="video-full-movie-uploader">Subir</div><div id="video-full-movie-status"></div>
              <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoFullMovie.$error.required">Este campo es requerido.</span>
              <span class="label label-danger" ng-show="errors.fullMovie"><% errors.fullMovie[0] %></span>
            </div>

            <div class="form-group">Al cargar contenido, cumple con la política de derechos a los medios.</div>
            <div class="row">
              <div class="col-sm-12 text-left">
                <input type="hidden" name="ownerId" ng-model="video.ownerId">
                <button type="submit" id="submit" ng-disabled="newVideoForm.$submitted && formSubmitted" name="submit" class="btn btn-primary">Enviar película</button></div>
            </div>
          </div>
        </form>
      </div>
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@stop
