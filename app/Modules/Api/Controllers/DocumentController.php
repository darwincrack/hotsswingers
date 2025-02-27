<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Models\DocumentModel;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;

class DocumentController extends Controller {

  /**
   * @param int $id model id
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getDetail($id) {
    
    \App::setLocale(session('lang'));   

    $youHaveNoPermission = trans('messages.youHaveNoPermission');

    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return Response()->json(['success' => false, 'message' => $youHaveNoPermission]);
    }
    $document = DocumentModel::select('documents.id', 'documents.idImage','documents.idImage2', 'documents.faceId', 'u.accountStatus')
      ->join('users as u', 'u.id', '=', 'documents.ownerId')
      ->where('documents.ownerId', $id)
      ->where('u.id', $id)
      ->first();

    return Response()->json(['success' => true, 'document' => $document]);
  }

}
