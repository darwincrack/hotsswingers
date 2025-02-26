@extends('admin-back-end')
@section('title', 'galería de imágenes - '.stripcslashes($gallery -> name))
@section('breadcrumb', '<li><a href="/admin/manager/image-gallery/'.$gallery->ownerId.'"><i class="fa fa-dashboard"></i> Galerías</a></li><li class="active">Galerías de imágenes</li>')
@section('content')

<?php 
use App\Helpers\Session as AppSession;
$adminData = AppSession::getLoginData();
?>
<div class="content row">
  <section class="content col-md-12">
    <div class="box">
      
 
      <div class="panel-body" ng-controller="modelImageGalleryCtrl" ng-cloak ng-init="galleryInit({{$gallery->id}})">
        <div class="box-header">
          <h3 class="box-title"><a ng-click="showUploadModal({{$gallery->ownerId}})" class="btn btn-info m20"><i class="fa fa-plus-circle"></i> Añadir imagen</a></h3>
        </div>
        @if(session('msgInfo'))<div class="alert alert-success">{{session('msgInfo')}}</div>@endif
        
        <div class="col-sm-4 col-md-3" ng-repeat="(key, image) in myImages" ng-cloak>
            <div class="box-picvideo" >

              <a   data-toggle="modal" data-target="#previewModel" >
                <img ng-src="{{URL('image')}}/<% image . id %>?size={{IMAGE_THUMBNAIL260}}" style="cursor: pointer;" class="ShowImage" data-url="{{URL('image')}}/<% image . id %>?size=normal"></a>
              <div class="line-picvideo">
                <div class="action-picvideo"><% image . status %></div>


                <a ng-hide="image.main == 'yes'" ng-click="setMainImage(key, image.id)" class="delete-pic" title="Set as main image"><i class="fa fa-eye"></i></a>
                <a ng-hide="image.main == 'yes'" ng-click="deleteImageGallery(key, image.id)" title="Delete" ng-disabled="<% deleteProcessing == iage . id %>" href="" class="delete-pic"><i class="fa fa-trash-o">&nbsp&nbsp</i></a>
                &nbsp;<span ng-show="image.main == 'yes'">Imagen principal</span>
              </div>
            </div>
          </div>

              <div class="col-sm-12">
            <?php if($adminData->role=='admin') { ?>
             @if($gallery->estado == 0)

                <a class="btn btn-danger btn-sm" href="{{url('admin/manager/rechazar/gallery/'.$gallery->id)}}">No aprobar Galería</a>&nbsp;&nbsp;<a class="btn btn-success btn-sm" href="{{url('admin/manager/aprobar/gallery/'.$gallery->id)}}">Aprobar Galería</a>
 
             @endif

               @if($gallery->estado == 1)

                <a class="btn btn-danger btn-sm" href="{{url('admin/manager/rechazar/gallery/'.$gallery->id)}}">No aprobar Galería</a>
 
             @endif

              @if($gallery->estado == 2)

                <a class="btn btn-success btn-sm" href="{{url('admin/manager/aprobar/gallery/'.$gallery->id)}}">Aprobar Galería</a>
 
             @endif
         
            <?php }?>
          </div>
        
      </div>
    </div>
  </section>
</div>

<div class="modal fade" id="previewModel" tabindex="-1" role="dialog" aria-labelledby="previewModelLabel">
  <div class="modal-dialog" role="image">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>

<script>
$(document).on("click", ".ShowImage", function() {

    var src = $(this).attr("data-url");
    $('#previewModel .modal-body').html('<img src="' + src + '" class="img-responsive">');
    
});



function showPreview(src) {

}
$('.image-galleries .thumbnail').hover(
        function () {
          $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function () {
          $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
);

</script>
@endsection