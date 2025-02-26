<?php

  namespace App\Modules\Member\Controllers;

  use App\Http\Requests;
  use App\Http\Controllers\Controller;
  use App\Modules\Api\Models\UserModel;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Validator;
  use Illuminate\Support\Facades\Input;
  use App\Helpers\Session as AppSession;
  use \Illuminate\Support\Facades\Mail;
  use \Firebase\JWT\JWT;
  use Laravel\Socialite\Facades\Socialite;
  use App\Events\AddModelPerformerChatEvent;
  use App\Events\AddModelScheduleEvent;
  use App\Events\AddEarningSettingEvent;
  use App\Events\AddModelPerformerEvent;
  use App\Events\UpdateExtendMember;
  use App\Events\MakeChatRoomEvent;
  use App\Modules\Api\Models\CountryModel;
  use App\Modules\Api\Models\GustosGente;
  use App\Modules\Api\Models\PreferenciasPersonas;
  use App;
  use Session;
  use Cookie;
  use App\Modules\Api\Models\PaymentTokensModel;
  use App\Modules\Api\Models\EarningModel;



  class MemberAuthController extends Controller {

      /**
       * Member Login.
       *
       * @return Response
       */
      public function getLogin() {
          // return view('home.index');
       App::setLocale(session('lang'));
          return view('login.login');
      }

      /**
       * Member logout.
       *
       * @return Response
       */
      public function getLogOut() {
          return AppSession::getLogout();
      }

      /**
       * model and member login
       */
      public function postLogin() {

        session_start();

    \App::setLocale(session('lang'));

    $welcomeback = trans('messages.welcomeback2');
    $hi = trans('messages.hi');

          $user = UserModel::where('username', '=', Input::get('username'))
                  ->where('passwordHash', '=', md5(Input::get('password')))
                  ->whereRaw('(role = "' . UserModel::ROLE_MEMBER . '" OR role = "' . UserModel::ROLE_MODEL . '")')
                  ->first();
          if (!$user) {
              return Redirect('login')->withInput()->with('msgError', \Lang::get('messages.Usernamepassworddoesnotmatch'));
          }

          if ($user->emailVerified == 0) {
              return redirect('login')->with('msgError', \Lang::get('messages.Youraccounthasnotbeenverified'));
          } else if ($user->accountStatus == UserModel::ACCOUNT_DISABLE) {
              return Redirect('login')->with('msgError', \Lang::get('messages.Youraccountwasdisabled'));
          } else if ($user->accountStatus == UserModel::ACCOUNT_SUSPEND) {
              return Redirect('login')->with('msgError', \Lang::get('messages.Youraccountwassuspend'));
          }

          AppSession::setLogin($user);




/*sesion de socialnetwork*/

include(getcwd() ."/valor.php");


$obj->firstName = $user->firstName;
$obj->lastName = $user->lastName;
$obj->username = $user->username;
$obj->studioName = $user->studioName;
$obj->email = $user->email;
$obj->gender = $user->gender;
$obj->birthdate = $user->birthdate;
$obj->bitpay = $user->bitpay;
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


          //TODO - should redirect to specific page for model / user...
          if ($user->role == 'model') {

              //TODO - should redirect pa model panel
              //after click live we will rediect to this view
             // return redirect('/models/live');
            //darwin
            return redirect('/dashboard');
          }

          if (!empty(\Request::cookie('backUri'))) {
              return redirect(\Request::cookie('backUri'))->with('msgInfo', $hi.' ' . $user->firstName . ' ' . $user->lastName . '. '.$welcomeback);
          } else {

              return redirect('/dashboard')->with('msgInfo', $hi.' ' . $user->firstName . ' ' . $user->lastName . '. '.$welcomeback);

          }
      }

      /**
        TODO: Social Login redirect to provider
       * */
      public function redirectToProvider($provider) {
          return Socialite::with($provider)->redirect();

//          if ($provider == 'facebook') {
//              if (app('settings')->fb_client_id) {
//                  $social->clientId = app('settings')->fb_client_id;
//              }
//              if (app('settings')->fb_client_secret) {
//                  $social->clientSecret = app('settings')->fb_client_secret;
//              }
//              $social->redirectUrl = url('login/facebook');
//              $social->version = 'v2.7';
//          }
//          if ($provider == 'google') {
//              if (app('settings')->google_client_id) {
//                  $social->clientId = app('settings')->google_client_id;
//              }
//              if (app('settings')->google_client_secret) {
//                  $social->clientSecret = app('settings')->google_client_secret;
//              }
//              $social->redirectUrl = url('login/google');
//          }
//          if ($provider == 'twitter') {
//              if (app('settings')->tw_client_id) {
//                  $social->clientId = app('settings')->tw_client_id;
//              }
//              if (app('settings')->tw_client_secret) {
//                  $social->clientSecret = app('settings')->tw_client_secret;
//              }
//              $social->redirectUrl = url('login/twitter');
//          }
//    var_dump($social);
          return $social->redirect();
          die();
      }

      /**
        TODO: Social Login callback
       * */
      public function handleProviderCallback($provider) {

    \App::setLocale(session('lang'));

    $welcomeback = trans('messages.welcomeback2');
    $$systemError = trans('messages.$systemError');
    $hi = trans('messages.hi');
    $Welcome = trans('messages.Welcome');

          if (isset($_GET['error'])) {
              return \Redirect::to('/')->with('msgError', \Lang::get('messages.CannotAccessYour') . $provider . \Lang::get('messages.account'));
          }
          if (isset($_GET['denied'])) {
              return \Redirect::to('/')->with('msgError', \Lang::get('messages.CannotAccessYour') . $provider . \Lang::get('messages.account'));
          }
          $user = Socialite::driver($provider)->user();
          if (!$user->getEmail() || empty($user->getEmail())) {
              $member = UserModel::where('username', '=', $user->nickname)->where('is_social', '=', 'yes')->first();
          } else {
              $member = UserModel::where('email', '=', $user->getEmail())->first();
          }

          if ($member) {
              AppSession::setLogin($member);
              return redirect("/")->with('msgInfo', $hi.' ' . $member->firstName . ' ' . $member->lastName . '.'.$welcomeback);
          } else {
              $newUser = new UserModel();
              if ($provider == 'twitter') {
                  $newUser->lastName = '&nbsp;';
                  $newUser->firstName = $user->getName();
                  $newUser->username = $user->getNickname();
                  $newUser->email = ($user->getEmail()) ? $user->getEmail() : '';
              }
              if ($provider == 'facebook') {
                  $newUser->lastName = '&nbsp;';
                  $newUser->firstName = $user->getName();
                  $newUser->username = ($user->getNickname()) ? $user->getNickname() : $user->getId();
                  $newUser->email = $user->getEmail();
                  $newUser->is_social = 'yes';
                  if(isset($user->getRaw()['gender'])):
                    $newUser->gender = $user->getRaw()['gender'];
                  endif;
              }
              if ($provider == 'google') {
                  $newUser->firstName = (isset($user->getRaw()['name']) && isset($user->getRaw()['name']['givenName'])) ? $user->getRaw()['name']['givenName'] : $user->getName();
                  $newUser->lastName = (isset($user->getRaw()['name']) && isset($user->getRaw()['name']['familyName'])) ? $user->getRaw()['name']['familyName'] : '&nbsp;';
                  if(isset($user->getRaw()['gender'])):
                    $newUser->gender = $user->getRaw()['gender'];
                  endif;
                  $newUser->username = ($user->getNickname()) ? $user->getNickname() : $user->getId();
                  $newUser->email = $user->getEmail();
              }

              $newUser->avatar = $user->getAvatar();
              $newUser->is_social = 'yes';
              $newUser->role = UserModel::ROLE_MEMBER;
              $newUser->emailVerified = true;
              $newUser->accountStatus = UserModel::ACCOUNT_ACTIVE;
              $newUser->tokens = app('settings')->memberJoinBonus;

              if ($newUser->save()) {
                  AppSession::setLogin($newUser);

                  return redirect("members/account-settings")->with('msgInfo', $hi.' ' . $newUser->firstName . ' ' . $newUser->lastName . '. '.$Welcome);
              } else {
                  return redirect("/register")->with('msgError', $$systemError);
              }
          }
      }

      /**
       * Member register.
       *
       * @return Response
       */
      public function getRegister(Request $req) {

         App::setLocale(session('lang'));
          $userData = AppSession::getLoginData();
          if($userData){
            AppSession::getLogout();
          }
          $type = ($req->has('type')) ? $req->get('type') : '';
          $countries = CountryModel::orderBy('name')->lists('name', 'id');
          return view('login.register', compact('type', 'countries'));
      }




      /**
       * Member Post register.
       *
       * @return Response
       */
      public function postRegister(Request $get) {


         App::setLocale(session('lang'));
          
          if (AppSession::isLogin()) {
              AppSession::getLogout();
          }



            $rules = [
                'sexo'                    => 'required',
                'type'                    => 'required',
                'experiencias'            => 'required',
                'ellanacimientodia'       => 'required',
                'ellanacimientomes'       => 'required',
                'ano'                     => 'required',
                'ellacm'                  => 'required',
                'ellafionomia'            => 'required',
                'ellaetnia'               => 'required',
                'location'                => 'required',
                'username'                => 'required|alphaNum|unique:users|max:40',
                'email'                   => 'required|email|unique:users|max:40',
                'password'                => 'Required|Between:6,32|Confirmed',
                'password_confirmation'   => 'Required|Between:6,32'

            ];

            $rules['firstName'] = ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'];
            $rules['lastName'] = ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'];
            $rules['birthdate'] = 'Required|date|before:18 years ago|after:100 years ago';
      
            if(Input::get('sexo') == "4")
            {
                $rules['subirthdate'] = 'Required|date|before:18 years ago|after:100 years ago';
            }      


            $validator = Validator::make(Input::all(), $rules);

            if(!empty($validator->errors()->first('email')))
            {
                return redirect()->back()->withInput()->with('msgError', $validator->errors()->first('email'));
            }


            if(!empty($validator->errors()->first('username')))
            {
                return redirect()->back()->withInput()->with('msgError', $validator->errors()->first('username'));
            }


            if(!empty($validator->errors()->first('password')))
            {
                return redirect()->back()->withInput()->with('msgError', $validator->errors()->first('password'));
            }

            if(!empty($validator->errors()->first('password_confirmation')))
            {
                return redirect()->back()->withInput()->with('msgError', $validator->errors()->first('password_confirmation'));
            }


            if(!empty($validator->errors()->first('birthdate')))
            {
                return redirect()->back()->withInput()->with('msgError', $validator->errors()->first('birthdate'));
            }


            if(!empty($validator->errors()->first('subirthdate')))
            {
                return redirect()->back()->withInput()->with('msgError', $validator->errors()->first('subirthdate'));
            }



            $email = Input::get('email');
             
           
            $newMember = new UserModel ();

            $newMember->experiencias = Input::get('experiencias');
            $newMember->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
            $newMember->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
            $newMember->gender = Input::get('sexo');
            $newMember->birthdate = Input::get('birthdate');
            $newMember->username = Input::get('username');
            $newMember->email = $email;
            $newMember->passwordHash = md5(Input::get('password'));
            $newMember->location_id = Input::get('location');
            $newMember->countryId = Input::get('location');
            $newMember->autoApprovePayment = 1;
           
            if(Input::get('sexo') != "2")
            {
              
              $newMember->orientacionsex = Input::get('inclinacion');

            }



             $newMember->ellacm = Input::get('ellacm');
             $newMember->ellafionomia = Input::get('ellafionomia');
             $newMember->ellaetnia = Input::get('ellaetnia');
             $newMember->subirthdate = Input::get('subirthdate');

             $newMember->elcm = Input::get('elcm');
             $newMember->elfisionomia = Input::get('elfisionomia');
             $newMember->eletnia = Input::get('eletnia');


            $newMember->referral_code = $this->getUniqueReferralCode();

            $referred_by = $this->getReferredBy();

            $newMember->referred_by   =  $referred_by;




            $newMember->role = UserModel::ROLE_MODEL;

             $newMember->accountStatus = UserModel::ACCOUNT_WAITING;

            if ($newMember->save()) {




            if($referred_by !=null){


                if( ! empty(app('settings')->referidosTokens) and app('settings')->referidosTokens !="0" ){


                  $referred_byId = $this->getReferredById();
                  $payment = new PaymentTokensModel;
                    $payment->ownerId = 1;
                    $payment->item = 'ref';
                    $payment->itemId = 2;
                    $payment->modelId =  $referred_byId;
                    $payment->tokens = app('settings')->referidosTokens;
                    $payment->status = 'approved';
                    $payment->modelCommission = 100;
                    $payment->afterModelCommission = app('settings')->referidosTokens;

            
                    if ($payment->save()) {

                        $earning = new EarningModel;
                        $earning->item = 'ref';
                        $earning->itemId = $payment->id;
                        $earning->payFrom = 1;
                        $earning->payTo =  $referred_byId;
                        $earning->tokens =   app('settings')->referidosTokens;
                        $earning->percent = 100;
                        $earning->type = EarningModel::PERFORMERSITEMEMBER;
                        $earning->save();
                    }



                }
                   
            }







              foreach (json_decode(Input::get('todoslosgustos')) as $key => $value) {                   
                $newgustos = new GustosGente ();
                $newgustos->gustos_id = $value;
                $newgustos->users_id = $newMember->id;
                  if($newgustos->save()){
                    //echo "guardo bien el gusto";
                  }

              }


            foreach (json_decode(Input::get('todoslasbusquedas')) as $key => $value) {                   
              $newPreferenciasPersonas = new PreferenciasPersonas ();
              $newPreferenciasPersonas->Preferencias_id = $value;
              $newPreferenciasPersonas->users_id = $newMember->id;
                if($newPreferenciasPersonas->save()){
                  //echo "guardo bien la busqueda";
                }

            }



              UserModel::where( 'id', $newMember->id )
                ->update(['guid' => $newMember->id ] );




                 if ($get->type == 'model') {
                    \Event::fire(new AddModelPerformerChatEvent($newMember));
                    \Event::fire(new AddModelScheduleEvent($newMember));
                    \Event::fire(new AddEarningSettingEvent($newMember));
                    \Event::fire(new AddModelPerformerEvent($newMember));
                    \Event::fire(new MakeChatRoomEvent($newMember));
                    \Event::fire(new UpdateExtendMember($newMember));  
                } else if ($get->type == 'studio') {
                    \Event::fire(new AddEarningSettingEvent($newMember));
                }
                $token = \App\Helpers\AppJwt::create(array('user_id' => $newMember->id, 'username' => $newMember->username, 'email' => $email));
                $sendConfirmMail = Mail::send('email.confirm', array('username' => $newMember->username, 'email' => $email, 'token' => $token), function($message) use($email) {
                            $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($email)->subject( trans('messages.VerifyAccount'). ' | ' . app('settings')->siteName);
                        });
                if ($sendConfirmMail) {
                    return redirect('/')->with('msgInfo', \Lang::get('messages.sentEmailVerifyMemberLogin'));
                } else {
                    return redirect()->back()->withInput()->with('msgError', \Lang::get('messages.sentEmailErrorMemberLogin'));
                }
            } else {



                return redirect()->back()->withInput()->with('msgError', \Lang::get('messages.systemError'));
            }

      }







      /**
       * Member Confirm active account.
       *
       * @return Response
       */
      public function getActiveAccount(Request $req) {
        session_start();
         App::setLocale(session('lang'));

          $token = $req->get('token');
          $getData = JWT::decode($token, JWT_SECRET, array('HS512'));
          $exp = (int) ($getData->exp / 6000);
          $time = time() - $exp;


        $putLogin = UserModel::find($getData->data->user_id);


          if (!isset($_SESSION['OSSN_USER'])) {

              $updateVerifyAccount = UserModel::find($getData->data->user_id);
              if ($updateVerifyAccount->emailVerified) {
                  return Redirect('/')->with('msgError', \Lang::get('messages.activeAlreadyMemberLogin'));
              }
              $updateVerifyAccount->emailVerified = UserModel::EMAIL_VERIFIED;
              $updateVerifyAccount->emailVerifyToken = $getData->data->email;
              if ($updateVerifyAccount->role == UserModel::ROLE_MEMBER) {
                  $updateVerifyAccount->accountStatus = UserModel::ACCOUNT_ACTIVE;
              }


              if ($updateVerifyAccount->save()) {


                  AppSession::setLogin($putLogin);





                  if ($putLogin->role == UserModel::ROLE_MEMBER || ($putLogin->accountStatus == UserModel::ACCOUNT_ACTIVE && $putLogin->role == UserModel::ROLE_MODEL)) {


                      return redirect('')->with('msgInfo', \Lang::get('messages.Youraccountisactive'));
                  } else if ($updateVerifyAccount->accountStatus == UserModel::ACCOUNT_WAITING) {
                    if($putLogin->role == UserModel::ROLE_MODEL) {


                      return Redirect('models/dashboard/account-settings?action=documents')->with('msgInfo', \Lang::get('messages.upVerifyDocumentMemberLogin'));
                    }else {

                      return Redirect('studio/account-settings')->with('msgInfo', \Lang::get('messages.upVerifyDocumentMemberLogin'));
                    }
                  }
                  else
                  {

                      return Redirect('/')->with('msgInfo', \Lang::get('messages.activeAlreadyMemberLogin'));

                  }
              }
          }
          else
          {

            return Redirect('/dashboard')->with('msgError', 'No puedes activar una cuenta con una cuenta abierta');

          }
      }

      /**
       * Member forgot passwrod.
       *
       * @return Response
       */
      public function postForgotPassword(Request $get) {
         App::setLocale(session('lang'));
          if (\Request::ajax()) {
              $rules = [
                  'emailReset' => 'Required|Email|Exists:users,email',
              ];

              $validator = Validator::make(Input::all(), $rules);
              if ($validator->fails()) {
                  return response()->json([
                              'success' => false,
                              'message' => $validator->errors()->first('emailReset')
                                  ], 200);
              }

              $postEmail = $get->emailReset;
              $member = UserModel::where('email', $postEmail)->first();
              if ($member) {
                  if(!$member->isSuperAdmin && env('DISABLE_EDIT_ADMIN')) {
                    return response()->json([
                              'success' => false,
                              'message' => "xee".\Lang::get('messages.Youraccountcannotusethisfunction')
                                  ], 200);
                  }
                  $newPassword = str_random(8);
                  $token = \App\Helpers\AppJwt::create(array('newPassword' => $newPassword, 'email' => $postEmail));
                  $sendConfirmMail = Mail::send('email.forgot_password', array('newPassword' => $newPassword, 'token' => $token, 'email' => $postEmail), function($message) use($postEmail) {
                              $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($postEmail)->subject('Reset Password | ' . app('settings')->siteName);
                          });
                  if ($sendConfirmMail) {
                      return response()->json([
                                  'success' => true,
                                  'message' => \Lang::get('messages.messageEmailMemberLogin')
                                      ], 200);
                  }
              } else {
                  return response()->json([
                              'success' => false,
                              'message' => \Lang::get('messages.messageEmailExistMemberLogin')
                                  ], 200);
              }
          } else {
              return redirect('login')->with('msgInbox', \Lang::get('messages.requestNotFoundMemberLogin'));
          }
      }

      /**
       * Member verify forgot passwrod.
       *
       * @return Response
       */
      public function getResetPassword(Request $req) {
         App::setLocale(session('lang'));
          $token = $req->get('token');
          $getData = JWT::decode($token, JWT_SECRET, array('HS512'));
          $exp = (int) ($getData->exp / 6000);
          $time = time() - $exp;
          if ($time > 6000) {
              return redirect('')->with('msgerror', \Lang::get('messages.expiredTokenMemberLogin'));
          } else {
              $verify = UserModel::where('email', '=', $getData->data->email)->update(array('passwordHash' => md5($getData->data->newPassword)));
              
              if ($verify) {
                  $model = UserModel::where('email', '=', $getData->data->email)
                          ->where('passwordHash', '=', md5($getData->data->newPassword))
                          ->first();
                  if(!$model){
                      return redirect('/')->with('msgError', \Lang::get('messages.modelNotFoundMemberLogin'));
                  }
                  if($model->role == UserModel::ROLE_ADMIN || $model->role == UserModel::ROLE_SUPERADMIN){
                      return redirect('admin/login')->with('msgInfo', \Lang::get('messages.resetPassMemberLogin'));
                  }else if($model->role == UserModel::ROLE_STUDIO){
                      return redirect('studio/login')->with('msgInfo', \Lang::get('messages.resetPassMemberLogin'));
                  }
                  return redirect('login')->with('msgInfo', \Lang::get('messages.resetPassMemberLogin'));
              }else{
                  return redirect('/')->with('msgError', \Lang::get('messages.errorTryAgainMemberLogin'));
              }
          }
      }

      /* Show the form for creating a new resource.
       *
       * @return Response
       */

      public function create() {

      }

      /**
       * Store a newly created resource in storage.
       *
       * @return Response
       */
      public function store() {
          //
      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return Response
       */
      public function show($id) {
          //
      }

      /**
       * Show the form for editing the specified resource.
       *
       * @param  int  $id
       * @return Response
       */
      public function edit($id) {
          //
      }

      /**
       * Update the specified resource in storage.
       *
       * @param  int  $id
       * @return Response
       */
      public function update($id) {
          //
      }

      /**
       * Remove the specified resource from storage.
       *
       * @param  int  $id
       * @return Response
       */
      public function destroy($id) {
          //
      }


private function getUniqueReferralCode()
{
    do {
        $code =  str_random(8);   
    } while (UserModel::where('referral_code', $code)->exists());

    return $code;
}

private function getReferredBy()
{
    $referralCode = Cookie::get('referral');

    if ($referralCode)
        return UserModel::where('referral_code', $referralCode)->value('username');

    return null;
}


private function getReferredById()
{
    $referralCode = Cookie::get('referral');

    if ($referralCode)
        return UserModel::where('referral_code', $referralCode)->value('id');

    return null;
}



  }


