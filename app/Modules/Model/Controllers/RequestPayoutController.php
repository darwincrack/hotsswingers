<?php
namespace App\Modules\Model\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\Model\Models\PerformerPayoutRequest;
use App\Modules\Api\Models\UserModel;

class RequestPayoutController extends Controller {

  public function createRequest(Request $req) {
    \App::setLocale(session('lang'));
    $createrequestsuccessfully = trans('messages.createrequestsuccessfully');
    $performer = $req->get('performer');
    if (!$req->isMethod('post')) {
      return view('Model::request_payout.create_request')
            ->with('request', new PerformerPayoutRequest());
    }

    $payoutRequestParams = [
      'performerId' => $performer->id,
      'comment' => Input::get('comment'),
      'dateFrom' => Input::get('dateFrom'),
      'dateTo' => Input::get('dateTo'),
      'status' => 'pending',
      'payout' => Input::get('payout'),
      'previousPayout' => Input::get('previousPayout'),
      'pendingBalance' => Input::get('pendingBalance'),
      'paymentAccount' => Input::get('paymentAccount')
    ];
    $userModel = UserModel::find($performer->user_id);
    $studio = UserModel::find($userModel->parentId);
    
    if($studio && $studio->role === UserModel::ROLE_STUDIO){
      $payoutRequestParams['studioRequestId'] = $studio->id;
    }
    $model = new PerformerPayoutRequest($payoutRequestParams);
    $model->save();

    return redirect('models/dashboard/payouts/requests')->with('msgInfo', $createrequestsuccessfully);
  }

  public function editRequest($id, Request $req) {
    \App::setLocale(session('lang'));


    $requestNotFoundMemberLogin = trans('messages.requestNotFoundMemberLogin');
    $updaterequestsuccessfully = trans('messages.updaterequestsuccessfully');

    
    $performerPayoutRequest = PerformerPayoutRequest::find($id);
    if (!$performerPayoutRequest) {
      throw new Exception($requestNotFoundMemberLogin, 404);
    }
    $performer = $req->get('performer');
    if (!$req->isMethod('post')) {
      return view('Model::request_payout.edit_request')
            ->with('request', $performerPayoutRequest);
    }

    $payoutRequestParams = [
      'performerId' => $performer->id,
      'comment' => Input::get('comment'),
      'dateFrom' => Input::get('dateFrom'),
      'dateTo' => Input::get('dateTo'),
      'status' => 'pending',
      'payout' => Input::get('payout'),
      'previousPayout' => Input::get('previousPayout'),
      'pendingBalance' => Input::get('pendingBalance'),
      'paymentAccount' => Input::get('paymentAccount')
    ];
    $userModel = UserModel::find($performer->user_id);
    $studio = UserModel::find($userModel->parentId);
    
    if($studio && $studio->role === UserModel::ROLE_STUDIO){
      $payoutRequestParams['studioRequestId'] = $studio->id;
    }
    $performerPayoutRequest->update($payoutRequestParams);

    return redirect('models/dashboard/payouts/requests')->with('msgInfo', $updaterequestsuccessfully);
  }

  public function listingRequests(Request $req) {
    \App::setLocale(session('lang'));
    $performer = $req->get('performer');
    $items = PerformerPayoutRequest::where(['performerId' => $performer->id])
            ->orderBy('id', 'desc')
            ->paginate(10);
    return view('Model::request_payout.list_requests')->with('items', $items);
  }

  public function viewRequest(Request $req, $id) {
    \App::setLocale(session('lang'));
    $performer = $req->get('performer');
    $item = PerformerPayoutRequest::where([
      'performerId' => $performer->id,
      'id' => $id
    ])
    ->first();

    if (!$item) {
      throw new Exception($requestNotFoundMemberLogin, 404);
    }

    return view('Model::request_payout.detail_request')->with('item', $item);
  }
}
