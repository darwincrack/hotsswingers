@extends('admin-back-end')
@section('title', $user->username.' - Galerías de video')
@section('breadcrumb', '<li><a href="/admin/manager/performers"><i class="fa fa-dashboard"></i> Modelos</a></li><li class="active">Galerías de video</li>')
@section('content')

<div class="content row">
  <section class="content col-md-12">
    <div class="box">
      <div class="panel-body" ng-controller="modelVideoGalleryCtrl" ng-cloak ng-init="galleryInit(0, {{$user->id}})">

        @if(session('msgInfo'))<div class="alert alert-success">{{session('msgInfo')}}</div>@endif

        <a href="{{URL('admin/manager/media/video-gallery/'.$user->id.'/upload-video')}}" class="btn btn-danger m20"><i class="fa fa-plus-circle"></i> Subir video</a>
        <br /><br />
        <ul class="row list-picvideo">
          <li class="col-sm-4 col-md-3" ng-repeat="(key, video) in myVideos" >
            <div class="box-picvideo">
              <a href="<% (video.status != 'processing') ? '/media/video/watch/' + video.seo_url : '#' %>"><img ng-src="<% video.posterData | imageMedium %>"></a>
              <div class="line-picvideo">
                <div class="action-picvideo"><% video.status %></div>
                <a href="{{URL('admin/manager/media/video-gallery/'.$user->id.'/edit-video')}}/<% video . id %>" class="delete-pic" title="Edit"><i class="fa fa-pencil"></i></a>
                <a ng-click="deleteVideoGallery(key, video.id)" class="delete-pic" href=""><i class="fa fa-trash-o">&nbsp&nbsp</i></a>
              </div>
            </div>
          </li>
        </ul>
        
      </div>
    </div>
  </section>
</div>
@endsection