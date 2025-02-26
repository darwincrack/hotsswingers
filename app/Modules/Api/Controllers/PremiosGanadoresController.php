<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\GamesModel;
use App\Modules\Api\Models\ChatThreadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\SettingModel;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\PremiosGanadoresModel;

class PremiosGanadoresController extends Controller {

  /**
   * Busca los juegos.
   *
   * @param  int  $id
   * @return Response
   */
  public function SetConnect($id, $userConnect) {

        $settings = SettingModel::first();


if($settings->premiosUserConectados !="" or $settings->premiosTokens !=""){



if ($userConnect >=$settings->premiosUserConectados){



    $data=PremiosGanadoresModel::findByUserId($id);

    if ($data == NULL) {




      /*  $user = UserModel::find($id);
        $user->increment('tokens', $settings->premiosTokens);

        if ($user->save()) {


                $premiosganadores = new PremiosGanadoresModel;

                $premiosganadores->user_id        =   $id;
                $premiosganadores->tokens         =   $settings->premiosTokens;
                $premiosganadores->totalviewer    =   $userConnect;

                if (!$premiosganadores->save()) { 
                  return Response()->json(array('success' => false, 'message' => "error" ));
                }


            return Response()->json(array('success' => true, 'message' => "te has ganado ".$settings->premiosTokens." Tokens por alacanzar ". $settings->premiosUserConectados." usuarios conectados en una transmisión"));
      }*/









      $payment = new PaymentTokensModel;
      $payment->ownerId = 1;
      $payment->item = 'tip';
      $payment->itemId = 2;
      $payment->modelId = $id;
      $payment->tokens = $settings->premiosTokens;
      $payment->status = 'approved';
      $payment->modelCommission = 100;
      $payment->afterModelCommission = $settings->premiosTokens;
      
      

      if ($payment->save()) { 





          $earning = new EarningModel;
          $earning->item = 'tip';
          $earning->itemId = $payment->id;
          $earning->payFrom = 1;
          $earning->payTo = $id;
          $earning->tokens = $settings->premiosTokens;
          $earning->percent = 100;
          $earning->type = EarningModel::PERFORMERSITEMEMBER;
          if ($earning->save()) {

             $user = UserModel::find($id);
           //  $user->increment('tokens', $settings->premiosTokens);
            
                $premiosganadores = new PremiosGanadoresModel;

                $premiosganadores->user_id        =   $id;
                $premiosganadores->tokens         =   $settings->premiosTokens;
                $premiosganadores->totalviewer    =   $userConnect;

                if (!$premiosganadores->save()) { 
                  return Response()->json(array('success' => false, 'message' => "error" ));
                }
          }

      }

       return Response()->json(array('success' => true, 'message' => "te has ganado ".$settings->premiosTokens." Tokens por alacanzar ". $settings->premiosUserConectados." usuarios conectados en una transmisión"));
 






    }/*else{

     return Response()->json(array('success' => true, 'message' => "ya te ganaste ".$settings->premiosTokens." Tokens por alacanzar ". $settings->premiosUserConectados." usuarios conectados en una transmisión"));
    }*/



}


}


}














 }
