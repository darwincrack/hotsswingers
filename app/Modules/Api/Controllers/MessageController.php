<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\MessageConversationModel;
use App\Modules\Api\Models\MessageReplyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Helpers\Session as AppSession;
use Laravel\Socialite\Facades\Socialite;
use DB;

class MessageController extends Controller {

  /**
   * @param string $type (inbox, sent, trash)
   * @param int $id thread id
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function deleteAll($type) {


    \App::setLocale(session('lang'));   

    $yoursessionhasexpiredpleaseloginagain = trans('messages.yoursessionhasexpiredpleaseloginagain');
    $deleteMessagesSuccessful = trans('messages.deleteMessagesSuccessful');
    $deleteerror = trans('messages.deleteerror');
    $deleteTheadMessagesSuccessful = trans('messages.deleteTheadMessagesSuccessful');


    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(['success' => false, 'message' => $yoursessionhasexpiredpleaseloginagain]);
    }
    if ($type == 'inbox' || $type == 'sent') {
      $deletes = MessageReplyModel::whereIn('conversationId', Input::get('ids'))
        ->update(['userAction' => DB::raw("IF(userAction='', '" . $userData->id . '|' . MessageReplyModel::TRASH . "', CONCAT( userAction , '" . '|' . $userData->id . '|' . MessageReplyModel::TRASH . "' )) ")]);
      if ($deletes) {
        return Response()->json(['success' => true, 'message' => $deleteMessagesSuccessful]);
      }
      return Response()->json(['success' => false, 'message' => $deleteerror]);
    } else {
      $deletes = MessageConversationModel::whereIn('id', Input::get('ids'))
        ->update(['deleteUser' => DB::raw("IF(deleteUser='', '" . $userData->id . '|' . MessageConversationModel::DELETE . "', CONCAT( deleteUser , '" . '|' . $userData->id . '|' . MessageConversationModel::DELETE . "' )) ")]);
      if ($deletes) {
        return Response()->json(['success' => true, 'message' => $deleteTheadMessagesSuccessful]);
      }
      return Response()->json(['success' => false, 'message' => $deleteerror]);
    }
  }

}
