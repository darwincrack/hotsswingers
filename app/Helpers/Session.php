<?php

namespace App\Helpers;

use App\Helpers\AppJwt;
use Lang;
use App;

class Session {

  /**
   * set user data to session
   */
  public static function setLogin($user) {



            /*sesion de socialnetwork*/

        include(getcwd() ."/valor.php");


        $obj->firstName = $user->firstName;
        $obj->lastName = $user->lastName;
        $obj->username = $user->username;
       // $obj->studioName = $user->studioName;
        $obj->email = $user->email;
        $obj->gender = $user->gender;
        $obj->birthdate = $user->birthdate;
       // $obj->bitpay = $user->bitpay;
        $obj->fullname = $user->firstName." ".$user->lastName;
        $obj->password_algorithm = "bcrypt";
        $obj->data = $objeto2;

        $obj->guid = $user->id;
        $obj->type = "normal";
        $obj->last_login = "";
        $obj->activation = "";
        $obj->time_created = $user->createdAt;
        $obj->role = $user->role;
        $obj->base_url = url('');
        $obj->avatar = $user->avatar;
        $_SESSION['OSSN_USER'] = $obj;

    //TODO - config redis, mongo... for session for better performance
    if(isset($user->smallAvatar)){
        $user->avatar = $user->smallAvatar;
    }
    \Session::put('UserLogin', json_encode([
      'token' => AppJwt::create(['id' => $user->id, 'username' => $user->username, 'firstName' => $user->firstName, 'lastName' => $user->lastName, 'role' => $user->role, 'avatar' => $user->avatar]),
      'id' => $user->id,
      'firstName' => $user->firstName,
      'lastName' => $user->lastName,
      'username' => $user->username,
      'role' => $user->role,
      'premium' => $user->premium,
      'tokens' => $user->tokens,
      'email' => $user->email,
      'gender' => $user->gender,
      'avatar' => $user->avatar,
      'candies' =>$user->tokens,
      'location_id' => $user->location_id,
      'birthdate' => $user->birthdate,
      'createdAt' => $user->createdAt,
      'is_social'=> $user->is_social,
      'accountStatus' => $user->accountStatus,
      'isSuperAdmin' => $user->isSuperAdmin
    ]));


    $_SESSION['OSSN_USER'] = $obj;


  }

  public static function setAvatar($avatar) {
    $userData = Session::getLoginData();
    $userData->avatar = $avatar;
    Session::setLogin($userData);
  }

  /**
  TODO:  Set Age
  **/
  public static function setAge($birthdate) {
    $userData = Session::getLoginData();
    $userData->birthdate = $birthdate;
    Session::setLogin($userData);
  }
  /**
   * set user name after change settings
   */
  public static function setName($data){
      $userData = Session::getLoginData();
      $userData->firstName = $data->firstName;
      $userData->lastName = $data->lastName;
      Session::setLogin($userData);
  }

  /**
  TODO:  Set Age
  **/
  public static function setCandies($candies) {
    $userData = Session::getLoginData();
    $userData->candies = $candies;
    Session::setLogin($userData);
  }

  /**
   * check user is login (by checking session)
   * TODO - should check jwt token also
   * @return boolean
   */
  public static function isLogin() {
    return \Session::has('UserLogin');
  }

  /**
   *  check user is model
   */
  public static function isModel() {
    $loginData = Session::getLoginData();
    if ($loginData) {
      return ($loginData->role == 'model') ? $loginData->id : null;
    } else {
      return null;
    }
  }

  /**
   * get login data from session
   *
   * @return Object
   */
  public static function getLoginData() {
    $loginData = \Session::get('UserLogin');
    return $loginData ? json_decode($loginData) : null;
  }

  public static function getLogout() {


    include(getcwd() ."/cerrar.php");
    \Session::forget('UserLogin');

    $idioma = (string)session('lang');


    return redirect('/'.$idioma);
  }

  public static function getAdminLogout() {
    \Session::forget('UserLogin');
    return redirect('admin/login')->with('msgInfo', \Lang::get('messages.Goodbye'));
  }

}
