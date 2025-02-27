<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\AttachmentModel;
use App\Modules\Api\Models\UserModel;
use App\Events\DeleteVideo;
use App\Events\DeleteImageGallery;
use App\Events\DeleteImage;
use DB;
use \Illuminate\Support\Facades\Mail;

class GalleryController extends Controller {

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
   * get galleries by model
   * return json
   */
  public function getModelGalleries($id) {

    return GalleryModel::select('galleries.id', 'galleries.name', 'galleries.slug', DB::raw("IF(galleries.price, galleries.price, 0) as galleryPrice"), DB::raw("(SELECT a1.mediaMeta FROM attachment a1 WHERE a1.parent_id=galleries.id AND a1.main='yes' AND a1.media_type='" . GalleryModel::IMAGE . "' LIMIT 1) as previewMeta"), DB::raw("(SELECT a2.mediaMeta FROM attachment a2 WHERE a2.parent_id=galleries.id AND a2.media_type='" . GalleryModel::IMAGE . "' AND a2.status='".AttachmentModel::ACTIVE."' LIMIT 1 ) as subImage"), 'galleries.type')
        ->where('galleries.ownerId', $id)
        ->where('galleries.status', '!=', GalleryModel::INVISIBLESTATUS)
        ->where('galleries.type', GalleryModel::IMAGE)
        ->where('galleries.estado', 1)
        ->paginate(6);
  }

  /**
   * 
   * @return Response
   */
  public function store() {



    \App::setLocale(session('lang'));   

    $pleaseloginagain = trans('messages.pleaseloginagain');

      
    $userData = AppSession::getLoginData();
    
    if (!$userData) {
      return Response()->json(array('success' => false, 'message' => $pleaseloginagain));
    }
    //get form data
    $input = Input::all();

    $validator = Validator::make(Input::all(), [
        'name' => 'Required|Unique:galleries|Min:5|Max:124',
        'description' => 'Required|Min:5|Max:500',
        'price' => 'Integer|Min:0'
    ]);

    if ($validator->passes()) {

      $gallery = new GalleryModel();
      $gallery->name = $input['name'];
      $gallery->description = $input['description'];
      $gallery->price = $input['price'];
      $gallery->slug = str_slug($input['name']);
      
      if ($userData->role == UserModel::ROLE_MODEL) {
        $gallery->ownerId = $userData->id;
      } else if ($userData->role == UserModel::ROLE_ADMIN || $userData->role == UserModel::ROLE_SUPERADMIN) {
        $gallery->ownerId = $input['model_id'];
      }
      $gallery->type = $input['type'];
      $gallery->status = $input['status'];
      if ($gallery->save()) {

        if ($gallery->type == 'image') {
          $url = ($userData->role == UserModel::ROLE_MODEL) ? BASE_URL . 'models/dashboard/media/image-gallery/' . $gallery->id : BASE_URL . 'admin/manager/media/image-gallery/' . $gallery->id;
        } else {
          $url = ($userData->role == UserModel::ROLE_MODEL) ? BASE_URL . 'models/dashboard/media/video-gallery/' . $gallery->id : BASE_URL . 'admin/manager/media/video-gallery/' . $gallery->id;
        }


      $send = Mail::send('email.solicitud_galeria', array('username' => $userData->username, 'user_id' => $userData->id, 'gallery'=>$gallery), function($message) use($userData) {
              $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to("fotos-videos@implik-2.com")->subject('El usuario '.$userData->username.' ha creado una galería | ' . app('settings')->siteName);
          });



        return Response()->json(array('success' => true, 'errors' => '', 'message' => 'create successfully.', 'id' => $gallery->id, 'url' => $url));
      }
      return Response()->json(['success' => false, 'error' => 'System error.', 'message' => 'System error.']);
    } else {
      return Response()->json(array('success' => false, 'errors' => $validator->errors()));
    }
  }

  /*   * *
   * set status
   * return json
   */

  public function setGalleryStatus() {



    \App::setLocale(session('lang'));   

    $pleaselogintochangegallerystatus = trans('messages.pleaselogintochangegallerystatus');
    $galleryMissingItem = trans('messages.galleryMissingItem');
    $videoProcessing = trans('messages.videoProcessing');
    $updatestatussuccessfully = trans('messages.updatestatussuccessfully');
    $updatefail = trans('messages.updatefail');

    $post = Input::all();
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(array('success' => false, 'message' => $pleaselogintochangegallerystatus));
    }
    $gallery = GalleryModel::where('id', $post['id'])
      ->where('ownerId', $userData->id)
      ->first();
    if ($gallery) {
      //check gallery items
      if ($post['status'] == GalleryModel::PRIVATESTATUS) {
        if ($gallery->type == GalleryModel::IMAGE) {
          $items = AttachmentModel::where('parent_id', $gallery->id)->count();
        } else {
          $items = VideoModel::where('galleryId', $gallery->id)->count();
        }
        if ($items == 0) {
          return Response()->json(['success' => false, 'message' => $galleryMissingItem]);
        }
        if ($gallery->type == GalleryModel::VIDEO) {
          $check = VideoModel::where('galleryId', $gallery->id)
            ->where('status', VideoModel::PROCESSING)
            ->count();
          if ($check > 0) {
            return Response()->json(['success' => false, 'message' => $videoProcessing]);
          }
        }
      }
      $gallery->status = ($post['status'] == GalleryModel::PUBLICSTATUS) ? GalleryModel::PRIVATESTATUS : GalleryModel::PUBLICSTATUS;
      $gallery->save();
      return Response()->json(array('success' => true, 'message' => $updatestatussuccessfully, 'gallery' => $gallery));
    }
    return Response()->json(array('success' => false, 'message' => $updatefail));
  }

  public function update() {


    \App::setLocale(session('lang'));   

    $gallerydoesnotfound = trans('messages.gallerydoesnotfound');
    $pleaseLoginToUpdateGallery = trans('messages.pleaseLoginToUpdateGallery');
    $systemError = trans('messages.systemError');
    $galleryMustHasAtLeastOneItem = trans('messages.galleryMustHasAtLeastOneItem');
    $updateSuccessfully = trans('messages.updateSuccessfully');

//    
    if(!Input::has('id')){
        return Response()->json(array('success'=>false, 'message'=> $gallerydoesnotfound ));
    }
    
    //get form data
    $input = Input::all();
    $validator = Validator::make(Input::all(), [
        'name' => 'Required|Unique:galleries,name,'.$input['id'].'|Min:5|Max:124',
        'description' => 'Required|Min:5|Max:500',
        'price' => 'Integer|Min:0',
        'status' => 'Required'
    ]);
    if ($validator->fails()) {
      return Response()->json(array('success' => false, 'errors' => $validator->errors()));
    }

    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(array('success' => false, 'message' => $pleaseLoginToUpdateGallery));
    }
    
    $gallery = GalleryModel::where('id', $input['id']);
    if ($userData->role == 'model') {
      $gallery = $gallery->where('ownerId', $userData->id);
    }
    $gallery = $gallery->first();

    $gallery->name = $input['name'];
    $gallery->description = $input['description'];
    $gallery->price = $input['price'];
    $gallery->slug = str_slug($input['name']);
    $gallery->previewImage = (Input::has('previewImage')) ? $input['previewImage'] : null;
    //Check items in gallery before publish
    $statusMessage = '';

    if ($gallery->type == GalleryModel::IMAGE) {
      $items = AttachmentModel::where('parent_id', $gallery->id)->count();
    } else {
      $items = VideoModel::where('galleryId', $gallery->id)->count();
    }

    $gallery->status = $input['status'];
    if ($items == 0 && $input['status'] != GalleryModel::INVISIBLESTATUS) {
      $gallery->status = GalleryModel::INVISIBLESTATUS;
      $statusMessage = $galleryMustHasAtLeastOneItem;
    }

    if ($gallery->save()) {
      //Gallery must has at least 1 item before publish
      if ($gallery->type == 'image') {
        $url = ($userData->role == UserModel::ROLE_MODEL) ? BASE_URL . 'models/dashboard/media/image-gallery/' . $gallery->id : BASE_URL . 'admin/manager/image-gallery/' . $gallery->ownerId;
      } else {
        $url = ($userData->role == UserModel::ROLE_MODEL) ? BASE_URL . 'models/dashboard/media/video-gallery/' . $gallery->id : BASE_URL . 'admin/manager/video-gallery/' . $gallery->ownerId;
      }
      return Response()->json(array('success' => true, 'errors' => $statusMessage, 'message' => $updateSuccessfully, 'id' => $gallery->id, 'url' => $url));
    }
    return Response()->json(['success' => false, 'message' => $systemError ]);
  }

  public function FindMyGalleries(Request $req) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return null;
    }
    $type = $req->get('type');
    if ($type == 'image') {
      $gallery = GalleryModel::select('galleries.*', DB::raw("(select count(a.parent_id) from attachment a where a.parent_id = galleries.id) as total"), DB::raw("(SELECT a1.mediaMeta FROM attachment a1 WHERE a1.parent_id=galleries.id AND a1.main='yes' AND a1.media_type='" . GalleryModel::IMAGE . "' ) as mainImage"))
        ->where('galleries.type', $type);
      if (($userData->role == UserModel::ROLE_ADMIN || $userData->role == UserModel::ROLE_SUPERADMIN) && Input::has('modelId')) {
        $gallery = $gallery->where('ownerId', Input::get('modelId'));
      } else {
        $gallery = $gallery->where('ownerId', $userData->id);
      }
      if (!Input::has('limit') || Input::get('limit') == 'all') {
        return $gallery->get();
      }
      return $gallery->paginate(LIMIT_PER_PAGE);
    } else if ($type == 'video') {
      $gallery = GalleryModel::select('*', DB::raw('(select count(v.galleryId) from videos v where v.galleryId = galleries.id) as total'), DB::raw('(SELECT a.mediaMeta FROM attachment a WHERE a.id = galleries.previewImage) as mainImage'))
        ->where('galleries.type', $type);
      if (($userData->role == UserModel::ROLE_ADMIN || $userData->role == UserModel::ROLE_SUPERADMIN) && Input::has('modelId')) {
        $gallery = $gallery->where('galleries.ownerId', Input::get('modelId'));
      } else {
        $gallery = $gallery->where('galleries.ownerId', $userData->id);
      }
      if (!Input::has('limit') || Input::get('limit') == 'all') {
        return $gallery->get();
      }
      return $gallery->paginate(LIMIT_PER_PAGE);
    }
  }

  public function findGalleryName(Request $req) {


    \App::setLocale(session('lang'));   

    $pleaseloginfirst = trans('messages.pleaseloginfirst');
    $allFieldAreRequired = trans('messages.allFieldAreRequired');
    $galleryNameAlreadyExisted = trans('messages.galleryNameAlreadyExisted');
    $galleryNameIsAvailable = trans('messages.galleryNameIsAvailable');


    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(array('success' => false, 'message' => $pleaseloginfirst));
    }
    if (!$req->has('name') || !$req->has('type')) {
      return Response()->json(array('success' => false, 'message' => $allFieldAreRequired));
    }

    $check = GalleryModel::where('name', $req->get('name'))
      ->where('type', $req->get('type'));
    if ($req->has('id')) {
      $check = $check->where('id', '<>', $req->get('id'));
    }
    if ($check->first()) {
      return Response()->json(array('success' => true, 'message' => $galleryNameAlreadyExisted));
    } else {
      return Response()->json(array('success' => false, 'message' => $galleryNameIsAvailable));
    }
  }

  /**
   * destroy gallery
   * @param integer $id id of gallery
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function destroy($id) {
    
    $userData = AppSession::getLoginData();


    \App::setLocale(session('lang'));   

    $notLoginOrNoHavePermission = trans('messages.notLoginOrNoHavePermission');
    $deleteGallerySuccessful = trans('messages.deleteGallerySuccessful');
    $deleteGalleryError = trans('messages.deleteGalleryError');


    if (!$userData || ($userData->role != UserModel::ROLE_MODEL && $userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return Response()->json(array('success' => false, 'message' => $notLoginOrNoHavePermission));
    }

    $gallery = GalleryModel::where('id', $id);
    if ($userData->role == UserModel::ROLE_MODEL) {
      $gallery = $gallery->where('ownerId', $userData->id);
    }
    $gallery = $gallery->first();

    if ($gallery && $gallery->type == 'image') {
      //delete image
      \Event::fire(new DeleteImageGallery($gallery));
    } else {
      //delete video
      $videos = VideoModel::where('galleryId', $gallery->id);
      if ($userData->role == UserModel::ROLE_MODEL) {
        $videos = $videos->where('ownerId', $userData->id);
      }
      $videos = $videos->get();

      if ($videos) {
//          \Event::fire('deleteVideoAction', $videos);
        //process delete video attachment and images in video
        foreach ($videos as $video) {
          \Event::fire(new DeleteVideo($video));
        }
      }
    }
    if ($gallery->delete()) {
      if ($gallery->previewImage) {
        \Event::fire(new DeleteImage($gallery->previewImage));
      }
      return Response()->json(array('success' => true, 'message' => $deleteGallerySuccessful));
    } else {
      return Response()->json(array('success' => false, 'message' => $deleteGalleryError));
    }
  }

}
