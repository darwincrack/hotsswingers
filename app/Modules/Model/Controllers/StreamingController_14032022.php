<?php

namespace App\Modules\Model\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use App\Modules\Api\Models\ChatThreadModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\DocumentModel;

class StreamingController extends Controller {

  /**
   * action when member view a model room
   */
  public function goLive(Request $get) {


    \App::setLocale(session('lang'));

    $accountNotApproveNeedUploadDocument = trans('messages.accountNotApproveNeedUploadDocument');
    $accoutNotApproveNeedContactWithAdmin = trans('messages.accoutNotApproveNeedContactWithAdmin');
    $hasbeenupdated = trans('messages.hasbeenupdated');
    $createRoomError = trans('messages.createRoomError');
    $createchatroomerrorpleasetryagainlater = trans('messages.createchatroomerrorpleasetryagainlater');

    //TODO - setup ACL instead
    $loginData = AppSession::getLoginData();

    if (!$loginData) {
      //restrict for mdoel only
      return redirect('/login');
    }

    //Check model is approved or no
    $model = UserModel::find($loginData->id);
    if(!$model || $model->role != UserModel::ROLE_MODEL){
      AppSession::getLogout();
    }else if($model->role == UserModel::ROLE_MODEL){
      if($model->accountStatus == UserModel::ACCOUNT_WAITING){
        //check model verification document
        $document = DocumentModel::where('ownerId', $model->id)
        ->first();
        if(!$document){
          return redirect("models/dashboard/account-settings?action=documents")->with('msgError', $accountNotApproveNeedUploadDocument);
        }
        else{
          return redirect("models/dashboard/profile")->with('msgWarning', $accoutNotApproveNeedContactWithAdmin);
        }
        
      }
    }

    //TODO - get model ID and create room with this model
    //Handle socket event for online status

//    $roomId = AppHelper::getRoomId($loginData->id, ChatThreadModel::TYPE_PUBLIC);
    $room = ChatThreadModel::where('ownerId',$loginData->id)
            ->where('type', ChatThreadModel::TYPE_PUBLIC)
            ->first();
    if(!$room){
        $room = new ChatThreadModel();
        $room->ownerId = $loginData->id;
        $room->type = ChatThreadModel::TYPE_PUBLIC;
        $room->streamingTime = 0;
        if(!$room->save()){
            return redirect('/')->with('msgError', $createchatroomerrorpleasetryagainlater);
        }
    }
    if(!$room->virtualId){
        $room->virtualId = md5(time());
        if(!$room->save()){
            return redirect('/')->with('msgError', $createRoomError);
        }
    }
    \App::setLocale(session('lang'));
    return view('Model::streaming.live')->with('room', $room->id)->with('virtualRoom', $room->virtualId)->with('modelId', $loginData->id)->with('memberId', $loginData->id)->with('inRoom', true);
  }

  public function conversation(Request $request) {

    \App::setLocale(session('lang'));

    $pleaseLogin = trans('messages.pleaseLogin');
    $modelNotFoundMessageControl = trans('messages.modelNotFoundMessageControl');

    //TODO - setup ACL instead
    $loginData = AppSession::getLoginData();

    if (!$loginData) {
      //restrict for mdoel only
      return redirect('/')->with('msgError', $pleaseLogin);
    }

    //TODO - get model ID and create room with this model
    //Handle socket event for online status
    $id = $request->get('id');
    $type = 'participant';
    if (!isset($id)) {
      if($loginData->role == UserModel::ROLE_MEMBER){
        return Redirect('/')->with('msgError', $modelNotFoundMessageControl);
      }
      $roomId = AppHelper::getRoomId($loginData->id, ChatThreadModel::TYPE_GROUP);
      $type = 'broadcaster';
      $modelId = $loginData->id;
    } else {
      //check model
      $model = UserModel::find($id);
      if(!$model){
        return Redirect('/')->with('msgError', $modelNotFoundMessageControl);
      }
      
      $room = ChatThreadModel::where('ownerId', $id)->where('type', ChatThreadModel::TYPE_GROUP)->first();
      if(!$room){
        return Redirect('/')->with('msgError', $modelNotFoundMessageControl);
      }
      $roomId = $room ? $room->id : $room;
      $modelId = $room->ownerId;
    }
    $data = [
      'room' => $roomId,
      'uid' => $loginData->id,
      'type' => $type,
      'modelId' => $modelId
    ];
    return view('Model::streaming.group')->with('data', $data);
  }

  public function goOnlinePopup(Request $get) {
    \App::setLocale(session('lang'));
    //TODO - setup ACL instead
    $loginData = AppSession::getLoginData();

    if (!$loginData) {
      //restrict for mdoel only
      return redirect('/login');
    }

    //TODO - get model ID and create room with this model
    //Handle socket event for online status

    $roomId = AppHelper::getRoomId($loginData->id, ChatThreadModel::TYPE_PUBLIC);

    return view('Model::streaming.go-online-popup')->with('room', $roomId)->with('modelId', $loginData->id)->with('memberId', $loginData->id);
  }

}
