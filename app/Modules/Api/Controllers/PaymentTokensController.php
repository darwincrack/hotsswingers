<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Mail;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\PerformerChatModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\ChatThreadModel;
use App\Modules\Api\Models\VideoModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\VideoprivadotokensModel;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use Illuminate\Http\Request;
use App\Events\SendTokensEvent;
use App\Events\SendPaidTokensEvent;
use DB;

class PaymentTokensController extends Controller {

  /**
   * 
   * @param Request $require(roomId, tokens)
   * @return json
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function sendTokens() {
    \App::setLocale(session('lang'));  
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return response()->json([
          'success' => false,
          'message' => trans('messages.loginToSendTokens')
      ]);
    }

    // get user tokens
    $postData = Input::all();

    //TODO check commission percent
    if (!Input::has('modelId')) {
      return response()->json([
          'success' => false,
          'message' => trans('messages.Modeldoesnotexist')
      ]);
    }
    if (!Input::has('tokens')) {
      return response()->json([
          'success' => false,
          'message' => trans('messages.tokenIsRequired')
      ]);
    }



    $totalTokens = UserModel::find($userData->id);

    if ($totalTokens->tokens < $postData['tokens']) {
      return response()->json([
          'success' => false,
          'message' => trans('messages.yourTokensNotEnoughMediaControl'),
          'tokens' => $totalTokens
      ]);
    }
    $totalTokens->decrement('tokens', $postData['tokens']);

    if ($totalTokens->save()) {
      //TODO get premium token and spy price from db

      $send = \Event::fire(new SendTokensEvent($postData, $userData));
      if (!$send) {
        $totalTokens->increment('tokens', $postData['tokens']);
        if ($totalTokens->save()) {
          return response()->json([
              'success' => true,
              'message' => trans('messages.HavesomeerroryourTokensdoesnotsend')
          ]);
        }
      }


      return response()->json([
          'success' => true,
          'message' => 'Send ' . $postData['tokens'] . ' tokens'
      ]);
    } else {
      return response()->json([
          'success' => false,
          'message' => trans('messages.sendTokensError')
      ]);
    }
  }

  /**
   * 
   * @param Request $require(roomId, tokens)
   * @return json
   * @author Phong Le <pt.hongphong@gmail.com>
   * 
   */
  public function sendPaidTokens() {
    \App::setLocale(session('lang'));  
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return response()->json([
          'success' => false,
          'message' => trans('messages.loginToSendTokens')
      ]);
    }

    // get user tokens
    $postData = Input::all();

    //TODO check commission percent
    if (!Input::has('modelId') || !Input::has('chatType')) {
      return response()->json([
          'success' => false,
          'message' => 'Send tokens error.'
      ]);
    }
    if (Input::get('chatType') != ChatThreadModel::TYPE_GROUP && Input::get('chatType') != ChatThreadModel::TYPE_PRIVATE) {
      return;
    }

    $modelSetting = PerformerChatModel::where('model_id', $postData['modelId'])->first();
    if (!$modelSetting) {
      return Response()->json(['success' => false, 'message' => trans('messages.modelsettingNotFound')]);
    }
    if (Input::get('chatType') == ChatThreadModel::TYPE_GROUP) {
      $tokens = ($modelSetting->group_price > 0) ? $modelSetting->group_price : app('settings')->group_price;
    }
    if (Input::get('chatType') == ChatThreadModel::TYPE_PRIVATE) {
      $tokens = ($modelSetting->private_price > 0) ? intval($modelSetting->private_price) : intval(app('settings')->private_price);
    }

    $totalTokens = UserModel::find($userData->id);

    if ($totalTokens->tokens < $tokens) {
      return response()->json([
          'success' => false,
          'message' => trans('messages.yourTokensNotEnoughMediaControl'),
          'tokens' => $totalTokens->tokens
      ]);
    }


    $totalTokens->decrement('tokens', $tokens);

    if ($totalTokens->save()) {
      //TODO get premium token and spy price from db

      $send = \Event::fire(new SendPaidTokensEvent($postData, $tokens, $userData));
      if (!$send) {
        $totalTokens->increment('tokens', $tokens);
        if ($totalTokens->save()) {
          return response()->json([
              'success' => false,
              'message' => trans('messages.HavesomeerroryourTokensdoesnotsend'),
              'tokens' => $totalTokens->tokens
          ]);
        }
      }


      return response()->json([
          'success' => true,
          'message' => 'Send ' . $tokens . ' tokens',
          'tokens'  => $totalTokens->tokens,
          'spend'   => $tokens
      ]);
    } else {
      return response()->json([
          'success' => false,
          'message' => trans('messages.sendTokensError'),
          'tokens'  => $totalTokens->tokens
      ]);
    }
  }


  /**
   * 
   * @param Request $require(roomId)
   * @return json
   * @author Phong Le <pt.hongphong@gmail.com>
   * pay tokens per each chat message
   */
  public function sendTipTokens($roomId = null) {
\App::setLocale(session('lang'));  
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return response()->json([
          'success' => false,
          'message' => trans('messages.PleaseLogin')
      ]);
    }

    //TODO Check room exist.
    $room = ChatThreadModel::select('chatthreads.*')
      ->join('users as u', 'u.id', '=', 'chatthreads.ownerId')
      ->where('u.role', UserModel::ROLE_MODEL)
      ->where('chatthreads.id', $roomId)
      ->first();
    if (!$room) {
      return response()->json([
          'success' => false,
          'message' => trans('messages.roomOrModelNotFound')
      ]);
    }

    //TODO get user token from db
    $min_tip_amount = app('settings')->min_tip_amount;
    $tokens = (Input::has('tokens')) ? Input::get('tokens') : null;

    if (!$tokens || $min_tip_amount > $tokens) {
      return Response()->json([
          'success' => false,
          'message' => trans('messages.Pleasenteratleast').$min_tip_amount. "Tokens"
      ]);
    }
    //Check member tokens
    $userDataDB = UserModel::find($userData->id);

    if ($userDataDB->tokens < $tokens) {
      return response()->json([
          'success' => false,
          'message' => trans('messages.yourTokensNotEnoughMediaControl'),
          'tokens' => $userDataDB->tokens
      ]);
    }
    $userDataDB->decrement('tokens', $tokens);

    if ($userDataDB->save()) {
      $params = array(
        'tokens' => $tokens,
        'modelId' => $room->ownerId,
        'options' => array(
          'type' => 'tip'
        )
      );
      $send = \Event::fire(new SendTokensEvent($params, $userData));
      if (!$send) {
        $userDataDB->increment('tokens', $tokens);
        if ($userDataDB->save()) {
          return response()->json([
              'success' => false,
              'message' => trans('messages.HavesomeerroryourTokensdoesnotsend')
          ]);
        }
        return response()->json([
            'success' => false,
            'message' => trans('messages.refundTokenError')
        ]);
      }


      return response()->json([
          'success' => true,
          'message' => trans('messages.Yousent') . $tokens . ' tokens'
      ]);
    } else {
      return response()->json([
          'success' => false,
          'message' => trans('messages.sendTokensError')
      ]);
    }
  }








  public function sendTipTokensPrivados($roomId = null) {
\App::setLocale(session('lang'));  
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return response()->json([
          'success' => false,
          'message' => trans('messages.PleaseLogin')
      ]);
    }

    //TODO Check room exist.
    $room = ChatThreadModel::select('chatthreads.*')
      ->join('users as u', 'u.id', '=', 'chatthreads.ownerId')
      ->where('u.role', UserModel::ROLE_MODEL)
      ->where('chatthreads.id', $roomId)
      ->first();
    if (!$room) {
      return response()->json([
          'success' => false,
          'message' => trans('messages.roomOrModelNotFound')
      ]);
    }

  
    $tokens = (Input::has('tokens')) ? Input::get('tokens') : null;

    if (!$tokens ) {
      return Response()->json([
          'success' => false,
          'message' => trans('messages.Pleasenteratleast'). "Tokens"
      ]);
    }
  
 


   $VideoprivadotokensModel = new VideoprivadotokensModel;
      $VideoprivadotokensModel->modelId = $room->ownerId;
      $VideoprivadotokensModel->ownerId = $userData->id;
      $VideoprivadotokensModel->active = true;
      $VideoprivadotokensModel->tokens = $tokens;
     
      if ($VideoprivadotokensModel->save()) {

        $data = VideoprivadotokensModel::get($room->ownerId,$userData->id);

        return $data;

       // return Response()->json(['success' => true, 'message' => trans('messages.buyItemSuccessful'), 'url' => $url]);
      }



  }




  /**
   * @param int $id item id
   * @param string $item 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function buyItem() {
    \App::setLocale(session('lang'));  
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(['success' => false, 'message' => trans('messages.loginToBuyItem')]);
    }

    if (!Input::has('item') || !Input::has('id')) {
      return Response()->json(['success' => false, 'message' => trans('messages.Itemnotexist')]);
    }
    $item = Input::get('item');
    $itemId = Input::get('id');
    //TODO check owner

    $check = PaymentTokensModel::checkOwner($userData, $item, $itemId);
    $url = ($item == PaymentTokensModel::ITEM_IMAGE) ? BASE_URL . 'media/image-gallery/preview/' . $itemId : BASE_URL . 'media/video/watch/' . $itemId;
    if ($check) {
      //TODO item was bought
      return Response()->json(['success' => true, 'message' => trans('messages.itemWasBought'), 'url' => $url]);
    }
    //get item
    $chooseItem = self::getPaidItem($item, $itemId);
    if (!$chooseItem) {
      return Response()->json(['success' => false, 'message' => trans('messages.Thisitemnotexistorprivategallery')]);
    }
    //TODO check user tokens
    $user = UserModel::find($userData->id);
    if ($user->tokens < intval($chooseItem->price)) {
      return Response()->json(['success' => false, 'message' => trans('messages.tokensNotEnoughToBuyItem')]);
    }
    //TODO process buy item here
    $user->decrement('tokens', intval($chooseItem->price));
    if ($user->save()) {
      $payment = new PaymentTokensModel;
      $payment->item = $item;
      $payment->itemId = $itemId;
      $payment->ownerId = $user->id;
      $payment->tokens = intval($chooseItem->price);
      $payment->status = PaymentTokensModel::STATUS_PROCESSING;
      if ($payment->save()) {

        return Response()->json(['success' => true, 'message' => trans('messages.buyItemSuccessful'), 'url' => $url]);
      }
      $user->increment('tokens', intval($chooseItem->price));
      if ($user->save()) {
        return response()->json([
            'success' => false,
            'message' => trans('messages.tokenCanNotSend')
        ]);
      }
    }
    return Response()->json(['success' => false, 'message' => trans('messages.systemError')]);
  }

  /**
   * @return response
   * 
   */
  public function getPaidItem($item, $itemId) {
    if ($item == PaymentTokensModel::ITEM_VIDEO) {
      return VideoModel::select('videos.price')
          ->join('galleries as g', 'g.id', '=', 'videos.galleryId')
          ->where('videos.id', $itemId)
          ->where('g.type', $item)
          ->where('g.status', GalleryModel::PUBLICSTATUS)
          ->first();
    }
    return GalleryModel::select('price')
        ->where('type', $item)
        ->where('status', GalleryModel::PUBLICSTATUS)
        ->where('id', $itemId)
        ->first();
  }

  /**
   * @return response 
   * @param int $galleryId
   * @param string $paymentItem 
   * */
  public function paidAllbumImage() {
    \App::setLocale(session('lang'));  
    if (!Input::has('galleryId') || !Input::has('paymentItem')) {
      return Response()->json(['success' => false, 'message' => trans('messages.galleryOrItemNotExist')]);
    }
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(['success' => false, 'message' => trans('messages.loginToBuyItem')]);
    }

    $item = Input::get('paymentItem');
    $itemId = Input::get('galleryId');
    //TODO check owner

    $check = PaymentTokensModel::checkOwner($userData, $item, $itemId);
    if ($check) {
      //TODO item was bought
      return Response()->json(['success' => true, 'message' => trans('messages.itemWasBought')]);
    }
    //get item
    $chooseItem = self::getPaidItem($item, $itemId);
    if (!$chooseItem) {
      return Response()->json(['success' => false, 'message' => trans('messages.Thisitemnotexistorprivategallery')]);
    }
    //TODO check user tokens
    $user = UserModel::find($userData->id);
    if ($user->tokens < $chooseItem->price) {
      return Response()->json(['success' => false, 'message' => trans('messages.tokensNotEnoughToBuyItem')]);
    }
    //TODO process buy item here
    $user->decrement('tokens', $chooseItem->price);
    if ($user->save()) {
      $payment = new PaymentTokensModel;
      $payment->item = $item;
      $payment->itemId = $itemId;
      $payment->ownerId = $user->id;
      $payment->tokens = $chooseItem->price;
      $payment->status = PaymentTokensModel::STATUS_PROCESSING;
      if ($payment->save()) {
        return Response()->json(['success' => true, 'message' => trans('messages.buyItemSuccessful')]);
      }
      $user->increment('tokens', $chooseItem->price);
      if ($user->save()) {
        return response()->json([
            'success' => false,
            'message' => trans('messages.HavesomeerroryourTokenscannotbuy')
        ]);
      }
    }
    return Response()->json(['success' => false, 'message' => trans('messages.systemError')]);
  }

}
