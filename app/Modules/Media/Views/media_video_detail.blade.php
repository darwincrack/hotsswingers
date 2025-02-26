<?php

use App\Helpers\Helper as AppHelper;
use App\Helpers\Session as AppSession;
$userData = AppSession::getLoginData();
$adminData = AppSession::getLoginData();
?>
@extends('frontend')
@section('title',$video->title)
@section('content')

<div class="container-fluid">
  <div class="gallery-breadcrumb clearfix"> 
    <div class="pull-left">
      <a href="/">{{app('settings')->siteName}}</a>  /
      <a href="/videos">@lang('messages.videos')</a>  /
      <a href="/videos?model={{$video->username}}">{{$video->username}}</a>  /
      <span>{{$video->title}}</span>
    </div>
    @if($video->bought == null and $adminData->role !='admin')
    <div class="pull-right"><a class="btn btn-warning btn-sm" href="/video/{{$video->id}}/buy">@lang('messages.buyThisVideo') ({{$video->price.' '.str_plural('Token', $video->price)}})</a></div>
    @else

    @endif
  </div>
  <div class="gallery-item">
    <div class="item">
      <center>

        <div id='video-player-trailer'>
        <video width="100%" height="500px" poster="<% '{{$video->posterData}}' | imageMedium %>" controls>
          <source src="<?= URL('media/video'); ?>/<?php echo ($video->bought || $adminData->role =='admin' ||($userData && $userData->id == $video->ownerId)) ? $video->fullMovie : $video->trailer; ?>"  type="video/mp4">
          @lang('messages.Yourbrowserdoesnotsupportthevideo')
        </video>
        </div>
        <?php
        /*
        <script type='text/javascript'>
                  var player = jwplayer('video-player-trailer'); // Created new video player

                  player.setup({
                  width: '100%',
                          height: '350px',
                          aspectratio: '16:9',
                          image: '<?php echo ($video->bought) ? AppHelper::getImageMeta($video->videoMeta, 'frame') : AppHelper::getImageMeta($video->trailerMeta, 'frame'); ?>',
                          sources: [{
                          file: '<?= URL('media/video'); ?>/<?php echo ($video->bought || ($userData && $userData->id == $video->ownerId)) ? $video->fullMovie : $video->trailer; ?>',
                                                    type: 'mp4'
                                            },
                                            {
                                            file: '<?= URL('media/video'); ?>/<?php echo ($video->bought || ($userData && $userData->id == $video->ownerId)) ? $video->fullMovie : $video->trailer; ?>?q=hd',
                                                    type: 'mp4'
                                            }]
                                    });
        </script>
        */?>
      </center>


    </div>


             <div class="col-sm-12 text-center">
            <?php 
            if( $adminData->role=='admin') { ?>
             @if($video->estado == 0)

                <a class="btn btn-danger btn-sm" href="{{url('admin/manager/rechazar/video/'.$video->id)}}">No aprobar video</a>&nbsp;&nbsp;<a class="btn btn-success btn-sm" href="{{url('admin/manager/aprobar/video/'.$video->id)}}">Aprobar video</a>
 
             @endif

               @if($video->estado == 1)

                <a class="btn btn-danger btn-sm" href="{{url('admin/manager/rechazar/video/'.$video->id)}}">No aprobar Video</a>
 
             @endif

              @if($video->estado == 2)

                <a class="btn btn-success btn-sm" href="{{url('admin/manager/aprobar/video/'.$video->id)}}">Aprobar Video</a>
 
             @endif
         
            <?php }?>
          </div>


    <?php //echo Widget::run('likeswg', array('item'=>'video', 'id'=>$video->id)) ?>

    <div class="details">
      <div class="row-fluid" style=" margin-bottom: 15px;">
        <div class="col-sm-8" style="padding: 15px;">
          <div class="title">{{$video->title}}</div>
          <p>{{$video->description}}</p>
        </div>
        <div class="col-sm-4">
          <table width="100%" class="table">
            <tbody>
              <tr>
                <td align="left">@lang('messages.postedBy'):</td>
                <td align="left"><strong> {{$video->username}}</a></td>
              </tr>
              <tr>
                <td align="left">@lang('messages.addedOn'):</td>
                <td align="left"><strong> {{ date('F d, Y', strtotime($video->createdAt)) }}</strong></td>
              </tr>

              <tr>
                <td align="left">@lang('messages.length'):</td>
                <td align="left"><strong> {{AppHelper::videoDuration($video->videoMeta)}}</strong></td>
              </tr>
              <tr>
                <td align="left">@lang('messages.price'):</td>
                <td align="left"><strong> {{$video->price.' '.str_plural('Token', $video->price)}}</strong></td>
              </tr>

            </tbody>
          </table>
        </div>

      </div>
      <!-- Widget::run('commentswg', array('item'=>'video', 'id'=>$video->id, 'parent' => 0, 'showComment'=>true, 'ownerItemId'=>$video->ownerId)) -->
    </div>
  </div>
</div>
@endsection
