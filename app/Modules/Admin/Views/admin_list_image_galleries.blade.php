@extends('admin-back-end')
@section('title', $user->username.' - Galerías de imágenes')
@section('breadcrumb', '<li><a href="/admin/manager/performers"><i class="fa fa-dashboard"></i> Modelos</a></li><li class="active">Galerías de imágenes</li>')
@section('content')

<div class="content row">
  <section class="content col-md-12">
    <div class="box">
      <div class="panel-body" ng-controller="studioImageGalleriesCtrl" ng-cloak ng-init="listGalaryInit({{$user -> id}})">

        @if(session('msgInfo'))<div class="alert alert-success">{{session('msgInfo')}}</div>@endif
          <div class="box-header">
          <h3 class="box-title">
            <a href="{{URL('admin/manager/media/add-image-gallery/'.$user->id)}}" class="btn btn-info m20"><i class="fa fa-plus-circle"></i> Agregar galería de imágenes</a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{{URL('admin/manager/media/add-image/'.$user->id)}}" class="btn btn-danger m20"><i class="fa fa-plus-circle"></i> Agregar una nueva imagen</a>
          </h3>
        </div>
        <div class="col-sm-4 col-md-3" ng-repeat="(key, gallery) in myGalleries" ng-cloak>
            <div class="box-picvideo">
              <a href="{{URL('admin/manager/media/image-gallery')}}/<% gallery . id %>"><img ng-src="<% gallery . mainImage | imageMedium %>"></a>
              <div class="line-picvideo">
                <div class="action-picvideo"><% gallery . status %></div><br>
                <div class="action-picvideo"><strong><% gallery . estado | estadoGalerias:'es' %><strong></div>
                <a ng-if="gallery.total > 1" href="{{URL('admin/manager/image-gallery/edit/')}}/<% gallery . id %>" class="delete-pic" title="Edit"><i class="fa fa-pencil"></i></a>
                <a ng-if="gallery.total == 1" href="{{URL('admin/manager/media/edit-image/'.$user->id)}}/<% gallery . id %>" class="delete-pic" title="Edit"><i class="fa fa-pencil"></i></a>
                <a ng-click="deleteGallery(key, gallery.id)" title="Delete" ng-disabled="<% deleteProcessing == gallery . id %>" href="" class="delete-pic"><i class="fa fa-trash-o">&nbsp&nbsp</i></a>
              </div>
            </div>
          </div>
        
      </div>
    </div>
  </section>
</div>
@endsection