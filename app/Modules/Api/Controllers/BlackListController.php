<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\BlackListModel;

class BlackListController extends Controller {

  /**
   * ban nick
   * @param int $id member id
   * @author Phong Le <pt.hongphong@gmail.com>
   * return response
   */
  public function addBlackList($username) {

    \App::setLocale(session('lang'));   

    $youdoesnothavepermission = trans('messages.youdoesnothavepermission');
    $userNotExist = trans('messages.userNotExist');
    $memberwasaddedtoblacklist = trans('messages.memberwasaddedtoblacklist');
    $systemError = trans('messages.systemError');


    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role != UserModel::ROLE_MODEL) {
      return Response()->json(array('success' => false, 'message' => $youdoesnothavepermission));
    }
    $user = UserModel::where('username', $username)->first();
    if (!$user) {
      return Response()->json(array('success' => false, 'message' => $userNotExist));
    }
    $lock = BlackListModel::where('locker', $userData->id)
      ->where('userId', $user->id)
      ->first();
    if (!$lock) {
      $lock = new BlackListModel;
      $lock->locker = $userData->id;
      $lock->userId = $user->id;
    }

    $lock->lock = BlackListModel::LOCK_YES;
    if ($lock->save()) {
      return Response()->json(array('success' => true, 'message' => $memberwasaddedtoblacklist));
    }
    return Response()->json(array('success' => false, 'message' => $systemError));
  }

  /**
   * remove from black list
   * @param int $id member id
   * @author Phong Le <pt.hongphong@gmail.com>
   * return response
   */
  public function removeBlackList($username) {

    \App::setLocale(session('lang'));   

    $youdoesnothavepermission = trans('messages.youdoesnothavepermission');
    $userNotExist = trans('messages.userNotExist');
    $memberwasremovedfromblacklist = trans('messages.memberwasremovedfromblacklist');
    $systemError = trans('messages.systemError');


    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role != UserModel::ROLE_MODEL) {
      return Response()->json(array('success' => false, 'message' => $youdoesnothavepermission));
    }
    $user = UserModel::where('username', $username)->first();
    if (!$user) {
      return Response()->json(array('success' => false, 'message' => $userNotExist));
    }
    $lock = BlackListModel::where('locker', $userData->id)
      ->where('userId', $user->id)
      ->first();
    if (!$lock) {
      $lock = new BlackListModel;
      $lock->locker = $userData->id;
      $lock->userId = $user->id;
    }

    $lock->lock = BlackListModel::LOCK_NO;
    if ($lock->save()) {
      return Response()->json(array('success' => true, 'message' => $memberwasremovedfromblacklist));
    }
    return Response()->json(array('success' => false, 'message' => $systemError));
  }

  /**
   * check user is in black list or no
   * @param int $modelid 
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return response
   */
  public function checkBlackList($id) {


    \App::setLocale(session('lang'));   

    $pleaseLogin = trans('messages.pleaseLogin');
    $accountBanned = trans('messages.accountBanned');


    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(array('success' => false, 'message' => $pleaseLogin ));
    }

    $blackList = BlackListModel::where('locker', $id)
      ->where('userId', $userData->id)
      ->first();
    if ($blackList && $blackList->lock == BlackListModel::LOCK_YES) {
      return Response()->json(array('success' => false, 'lock' => BlackListModel::LOCK_YES, 'message' => $accountBanned ));
    }
    return Response()->json(array('success' => true, 'lock' => BlackListModel::LOCK_NO));
  }

}
