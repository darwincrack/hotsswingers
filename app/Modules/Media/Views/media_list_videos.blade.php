<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('frontend')
@section('content')
@section('title', 'Videos')

<div class="content video-gallery">
    <div class="container">
        <div class="panel panel-default">
            
            <div class="panel-body">

                <div class="gallery-breadcrumb clearfix">
                    <div class="pull-left">
                        <span>@lang('messages.videos')</span>
                      
                    </div>
                  </div>
                <div class="row">
                    
                  @foreach($videos as $video)
                  <div class="col-sm-6 col-xs-12 col-md-4 col-lg-3 nopadding video-list-thumbs">
                    <div class="embed-responsive embed-responsive-16by9">
                        <img src="{{URL(AppHelper::getMetaValue($video->posterMeta, IMAGE_LARGE))}}" alt="poster" class="img-responsive" height="130px" />
                        <span class="text-left">{{str_limit($video->title, 30)}}</span>
                      <a href="{{URL('media/video/watch/'.$video->seo_url)}}" title="{{$video->title}}"><span class="glyphicon glyphicon-play-circle"></span></a>

                      <span class="duration">{{AppHelper::videoDuration($video->videoMeta)}}</span>
                      <span class="price">{{$video->price.' '.str_plural('Token', $video->price)}}</span>
                    </div>
                  </div>
                    
                 
                  @endforeach
                  @if(count($videos) == 0)
                  <p>
                    Video not found!
                  </p>
                  @endif
                </div>

                {{$videos->appends(Request::except('page'))->links()}}
               
            </div>
        </div>
    </div>
</div>
@stop
