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

class GamesController extends Controller {

  /**
   * Busca los juegos.
   *
   * @param  int  $id
   * @return Response
   */
  public function getGames($uid = null) {
    $gamesData = GamesModel::Games($uid);

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
