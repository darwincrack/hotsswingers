<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\MultiretosModel;
use App\Modules\Api\Models\ChatThreadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;

class MultiretosController extends Controller {

  /**
   * Busca los juegos.
   *
   * @param  int  $id
   * @return Response
   */
  public function get($uid = null) {
    $data = MultiretosModel::get($uid);

    if ($data != NULL) {
      return $data;
    }
  }



 public function getFirst($uid = null) {
    $data = MultiretosModel::getFirst($uid);

    if ($data != NULL) {
      return $data;
    }
  }


 public function getNext($uid = null) {


  MultiretosModel::where("active", 1)
  ->where("completado", 0)
  ->where("user_id", $uid)
  ->first()
  ->update(["active" => 0, "completado" => 1]);
 
$data = MultiretosModel::getFirst($uid);





   // $data = MultiretosModel::getFirst($uid);

    if ($data != NULL) {
      return $data;
    }
  }



public function ganancias($roomId = null) {


$retos_completados = array();
$data = "";
$reto_actual = "";
      $tokens = (Input::has('tokens')) ? Input::get('tokens') : null;


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



$retos = MultiretosModel::getallretos($room->ownerId);

$retosMaxid = MultiretosModel::getMaxid($room->ownerId);

foreach ($retos as $key=>$reto) {

$reto_actual = $reto->reto_text;

  $totalganado =  $reto->ganancia + $tokens;
  

      if($tokens > 0){


         if( $tokens >= $reto->goal){

                if ($retosMaxid->multiretos_id == $reto->multiretos_id){

                      MultiretosModel::where("active", 1)
                      ->where("id", $reto->multiretos_id)
                      ->where("user_id",  $room->ownerId)
                      ->first()
                      ->update(["ganancia" => $reto->ganancia + $tokens,"active" => 1, "completado" => 0, "reto_actual" =>1]);

                }else{

                      MultiretosModel::where("active", 1)
                    ->where("id", $reto->multiretos_id)
                    ->where("user_id",  $room->ownerId)
                    ->first()
                    ->update(["ganancia" => $reto->goal,"active" => 0, "completado" => 1, "reto_actual" =>0]);
                }

                

              MultiretosModel::where("active", 1)
              ->where("user_id",  $room->ownerId)
              ->first()
              ->update(["reto_actual" => 1]);

             // $tokens = $tokens - $reto->goal;
                     //   500 -              500

                         $temp = $reto->goal - $reto->ganancia; 
                        $tokens = $tokens - $temp;




           $retos_completados[$key] =  array(
                  'id' => $reto->multiretos_id,
                   'reto_text' => $reto->reto_text,
                   'goal' => $reto->goal,
                   'ganancia' => $reto->goal,
                   'posicion' => $reto->posicion
               );


           }else{

              $totalganado =  $reto->ganancia + $tokens;

              if ($totalganado >= $reto->goal){


                   if ($retosMaxid->multiretos_id == $reto->multiretos_id){

                           MultiretosModel::where("active", 1)
                                      ->where("id", $reto->multiretos_id)
                                      ->where("user_id",  $room->ownerId)
                                      ->first()
                                      ->update(["ganancia" => $totalganado,"active" => 1, "completado" => 0, "reto_actual" =>1]);

                                $retos_completados[$key] =  array(
                                             'id' => $reto->multiretos_id,
                                             'reto_text' => $reto->reto_text,
                                             'goal' => $reto->goal,
                                             'ganancia' => $totalganado,
                                             'posicion' => $reto->posicion
                                         );


                       }else{
                         MultiretosModel::where("active", 1)
                                      ->where("id", $reto->multiretos_id)
                                      ->where("user_id",  $room->ownerId)
                                      ->first()
                                      ->update(["ganancia" => $reto->goal,"active" => 0, "completado" => 1, "reto_actual" =>0]);

                                $retos_completados[$key] =  array(
                                             'id' => $reto->multiretos_id,
                                             'reto_text' => $reto->reto_text,
                                             'goal' => $reto->goal,
                                             'ganancia' => $reto->goal,
                                             'posicion' => $reto->posicion
                                         );


                       }
                        $temp = $reto->goal - $reto->ganancia; 
                        $tokens = $tokens - $temp;
          



              }else{





if ($retosMaxid->multiretos_id == $reto->multiretos_id){

                           MultiretosModel::where("active", 1)
                                      ->where("id", $reto->multiretos_id)
                                      ->where("user_id",  $room->ownerId)
                                      ->first()
                                      ->update(["ganancia" => $totalganado,"active" => 1, "completado" => 0, "reto_actual" =>1]);



                                      if($totalganado >= $reto->goal)
                                       $retos_completados[$key] =  array(
                                            'id' => $reto->multiretos_id,
                                             'reto_text' => $reto->reto_text,
                                             'goal' => $reto->goal,
                                             'ganancia' => $totalganado,
                                             'posicion' => $reto->posicion

                                         );

                       }else{
                        
                MultiretosModel::where("active", 1)
                              ->where("id", $reto->multiretos_id)
                              ->where("user_id",  $room->ownerId)
                              ->first()
                              ->update(["ganancia" => $totalganado]);




                       }







                      $tokens = 0;        
              }

//$temp = $reto->goal - $reto->ganancia; 


       //   $tokens = $totalganado - $tokens;

//$tokens = $temp - $tokens;
          }



      }else{


          MultiretosModel::where("active", 1)
          ->where("active", 1)
          ->where("user_id",  $room->ownerId)
          ->first()
          ->update(["reto_actual" => 1]);


      }
 

 
}



UserModel::where("id", $room->ownerId)->update(["multiretosTopic" => $reto_actual]);

$data = MultiretosModel::getFirst($room->ownerId);


  /*  if ($data != NULL) {
      return $data;
    }*/
  


return response()->json([
          'success' => true,
          'data' => $data,
          'retoscompletados' => $retos_completados,

      ]);




}


    /**
   * Busca todos los juegos de un usuario.
   *
   * @param  int  $id
   * @return Response
   */
  public function getAllGames($uid = null) {
    $gamesData = GamesModel::AllGames($uid);

    if ($gamesData != NULL) {
      return $gamesData;
    }
  }


    /**
   * Busca todos los juegos de un usuario.
   *
   * @param  int  $id
   * @return Response
   */
  public function getLastGames($uid = null) {
    $gamesData = GamesModel::getLastGame($uid);

    if ($gamesData != NULL) {
      return $gamesData;
    }
  }

}
