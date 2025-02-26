<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\UserModel;
//use DispatchesJobs;
use App\Jobs\ProcessConvertVideo;
use DB;
use \Illuminate\Support\Facades\Mail;

class VideoController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function index(Request $req) {

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  array
   * @method post methodName(type $paramName) Description
   * @return Response
   */
  public function create() {

  }

  /**
   * get videos image by model
   * @param int $id model id
   */
  public function getModelVideos($id) {
  
    return VideoModel::select('videos.id','videos.title', 'videos.seo_url', 'a.mediaMeta as posterMeta')
        ->leftJoin('attachment as a', 'a.id', '=', 'videos.poster')
        ->where('videos.ownerId', $id)
        ->where('videos.status', VideoModel::ACTIVE)
        ->where('videos.estado', 1)
        ->orderBy('videos.createdAt', 'desc')
        ->paginate(6);
  }

  /**
   *
   * @return post
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param string $title video title
   * @param string $description video description
   * @param int $price video price
   * @param int $galleryId video gallery id
   * @param int $poster video main poster id (attachment field)
   * @param int $trailer video trailer id  (attachment field)
   * @param int $fullMovie movie id ( attachment field )
   */
  public function store() {
     \App::setLocale(session('lang')); 
    //get form data
    $input = Input::all();
    $validation = Validator::make($input, array(
    'title' => 'required|Unique:videos|Min:5|Max:124',
    'description' => 'required|Min:5|Max:500',
    'galleryId' => 'required',
    'price' => 'Integer|Min:0',
   /* 'poster' => 'Required',
    'trailer' => 'Required',*/
    'fullMovie' => 'Required'
  ));

    if (!$validation->passes()) {
      return Response()->json(array('success' => false, 'errors' => $validation->errors()));
    }
//      $tokenDecode = AppJwt::getTokenDecode($input['token']);
    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role == UserModel::ROLE_MEMBER) {
      return Response()->json(array('success' => false, 'errors' => trans('messages.pleaseloginwithmodelrole'), 'message' => trans('messages.loginWithModelRole')));
    }
    $video = new VideoModel();
    $video->title = $input['title'];
    $video->seo_url = str_slug($input['title']);
    $video->description = $input['description'];
    $video->fullMovie = $input['fullMovie'];
    $video->galleryId = $input['galleryId'];

    if(@$input['poster']){

       $video->poster = $input['poster'];
    }else{
       $video->poster = '';

    }

        if(@$input['trailer']){

       $video->trailer = $input['trailer'];
    }else{
       $video->trailer = '';

    }
    $video->price = (Input::has('price')) ? $input['price'] : 0;
    if ($userData->role == UserModel::ROLE_MODEL) {
      $video->ownerId = $userData->id;
    } else if (Input::has('ownerId')) {
      $video->ownerId = $input['ownerId'];
    }
    $video->status = VideoModel::PROCESSING;
    if ($video->save()) {
      $url = ($userData->role == UserModel::ROLE_MODEL) ? BASE_URL . 'models/dashboard/media/videos' : BASE_URL . 'admin/manager/video-gallery/' . $video->ownerId;



      $send = Mail::send('email.solicitud_video', array('username' => $userData->username, 'user_id' => $userData->id, 'video'=>$video), function($message) use($userData) {
              $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to("fotos-videos@implik-2.com")->subject('El usuario '.$userData->username.' ha creado un video | ' . app('settings')->siteName);
          });




      return Response()->json(array('success' => true, 'errors' => '', 'message' => trans('messages.createVideoSuccessful'), 'id' => $video->id, 'url' => $url));
    }
    return Response()->json(array('success' => false, 'errors' => '', 'message' => trans('messages.Saveeventerrorpleasetrialagain')));
  }

  /**
   *
   * @return json
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param string $title video title
   * @param string $description video description
   * @param int $price video price
   * @param int $galleryId video gallery id
   *
   */
  public function update() {
//
    //get form data
    $input = Input::all();
    if(!Input::has('id')){
        return Response()->json(array('success' => false, 'message'=> trans('messages.Videodoesnotfound')));
    }
    $validation = Validator::make($input, array(
        'title' => 'required|Unique:videos,title,'.$input['id'].'|Min:5|Max:124',
        'description' => 'required|Min:5|Max:500',
        'galleryId' => 'required',
        'price' => 'Integer|Min:0'
      ));
    

    if ($validation->passes()) {
      $userData = AppSession::getLoginData();
      if (!$userData || $userData->role == UserModel::ROLE_MEMBER) {
        return Response()->json(array('success' => false, 'errors' => array(), 'message' => trans('messages.pleaseloginwithmodelrole')));
      }

      $video = VideoModel::where('id', $input['id']);
      if ($userData->role == UserModel::ROLE_MODEL) {
        $video = $video->where('ownerId', $userData->id);
      }
      $video = $video->first();
      $video->title = $input['title'];
      $video->seo_url = str_slug($input['title']);
      $video->description = $input['description'];
      $video->price = $input['price'];
      $video->galleryId = $input['galleryId'];
      if ($video->save()) {
        $url = ($userData->role == UserModel::ROLE_MODEL) ? BASE_URL . 'models/dashboard/media/view-video/' . $video->id : BASE_URL . 'admin/manager/video-gallery/' . $video->ownerId;
        return Response()->json(array('success' => true, 'errors' => '', 'message' => trans('messages.updateSuccessfully'), 'id' => $video->id, 'url' => $url));
      }
      return Response()->json(array('success' => false, 'errors' => '', 'message' => trans('messages.Savedataerror')));
    } else {
      return Response()->json(array('success' => false, 'errors' => $validation->errors()));
    }
  }

  public function findVideoName(Request $req) {
     \App::setLocale(session('lang')); 
    $userData = AppSession::getLoginData();

    if (!$userData) {
      return Response()->json(array('success' => false, 'message' => trans('messages.PleaselogintoaddVideo')));
    }

    $videoTitle = (Input::has('title')) ? $req->get('title') : null;
    $galleryId = (Input::has('gallery')) ? $req->get('gallery') : null;
    $videoId = ($req->get('id')) ? $req->get('id') : null;
    $check = VideoModel::where('title', '=', $videoTitle)
      ->where('galleryId', $galleryId);
    if ($videoId) {
      $check = $check->where('id', '<>', $videoId);
    }
    $check = $check->first();
    if ($check) {
      return Response()->json(array('success' => true, 'message' => trans('messages.videonameAlreadyExist')));
    }
  }

  /**
   * @param id $id video id
   * @author Phong Le <pt.hongphong@gmail.com>
   * status : active: show on member or inactive hidden it
   * * */
  public function setVideoStatus($id) {
     \App::setLocale(session('lang')); 
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(array('success' => false, 'message' => trans('messages.pleaseloginagain')));
    }
    $media = VideoModel::where('id', $id)
      ->where('ownerId', $userData->id)
      ->first();
    if ($media) {
      $post = \Request::all();
      $status = ($post['status'] == 'active') ? 'inactive' : 'active';
      $media->status = $status;
      $media->save();
      return Response()->json(array('success' => true, 'status' => $media->status, 'message' => trans('messages.thestatuswassuccessfullychanged')));
    } else {
      return Response()->json(array('success' => false, 'message' => trans('messages.changestatuserror')));
    }
  }

  /**
   * @param int $id video id
   * @return Response
   * @author Phong Le <pt.hongphong@gmail.com>
   * @access public
   * @group admin
   */
  public function getVideoById($id) {
     \App::setLocale(session('lang')); 
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(['success' => false, 'error' => trans('messages.pleaseLogin')]);
    }
    $video = VideoModel::where('id', $id);
    if ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN) {
      $video = $video->where('ownerId', $userData->id);
    }
    $video = $video->first();
    if (!$video) {
      return Response()->json(['success' => false, 'error' => trans('messages.Videonotexist')]);
    }
    return Response()->json(['success' => true, 'video' => $video]);
  }

}
