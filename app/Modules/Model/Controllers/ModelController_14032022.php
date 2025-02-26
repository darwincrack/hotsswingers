<?php

namespace App\Modules\Model\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Controllers\AuthController;
use App\Modules\Api\Controllers\UserController;
use App\Modules\Api\Controllers\RoomController;
use App\Modules\Api\Controllers\PerformerChatController;
use App\Modules\Model\Models\PerformerTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use \Firebase\JWT\JWT;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\PerformerModel;
use App\Modules\Api\Models\PerformerChatModel;
use App\Modules\Api\Models\MessageModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use App\Modules\Api\Models\AttachmentModel;
use App\Modules\Api\Models\CountryModel;
use App\Modules\Api\Models\ZoneModel;
use App\Modules\Api\Models\ScheduleModel;
use App\Modules\Api\Models\EarningSettingModel;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\MeetHerModel;
use App\Modules\Api\Models\ChatThreadModel;
use App\Modules\Api\Models\CategoryModel;
use App\Modules\Api\Models\DocumentModel;
use App\Modules\Api\Models\FavoriteModel;
use App\Modules\Api\Models\GustosGente;
use App\Modules\Api\Models\Gustos;
use App\Modules\Api\Models\Preferencias;
use App\Modules\Api\Models\PreferenciasPersonas;
use DB;
use App\Modules\Api\Models\GeoBlockingModel;
use App\Modules\Api\Models\TravelModel;
use App;
use App\Modules\Model\Models\OssnRelationships;
use \Illuminate\Support\Facades\Mail;
class ModelController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index(Request $req) {
    \App::setLocale(session('lang'));

    return view("Model::index");
  }

  /*
   * view settings page
   */

  public function chatSettings() {
    \App::setLocale(session('lang'));
    //check if is login and is model
    $userData = AppSession::getLoginData();

    $pleaseloginwithmodelrole = trans('messages.pleaseloginwithmodelrole');

    if (!$userData) {
      return redirect::to('/login')->with('message', $pleaseloginwithmodelrole);
    }
    if ($userData->role == 'model') {
      return view("Model::chat-settings", [
        'userData' => $userData
      ]);
    } else {
      return redirect::to('/');
    }
  }

  /*
   * Chat room
   * roomId is model id
   */

  public function chatRoom($roomId) {
    \App::setLocale(session('lang'));

    $anonymous = trans('messages.anonymous');
    $guest = trans('messages.guest');

    //get room data
    $auth = new AuthController();
    $user = new UserController();
//    $room = new RoomController();
//    var_dump($user->findMe());
//    if ($auth->isLogin()) {
//
//      return view("Model::chat-room", [
//        'turnConfig' => $data->info(),
//        'userData' => $user->findMe(),
//        'isRoom' => $room->checkRoom($roomId)
//      ]);
//    } else {
//      return redirect::to('/login')->with('message', 'Please login with model role');
//    }
    $userData = [];
    $userD = $user->findMe($auth->isLogin());


//get turn servers info
    //check if room exit return true else false;
    $room = new RoomController();
    $performerChat = new PerformerChatController();

    if ($auth->isLogin()) {

      return view("Model::chat-room", [
        'userData' => $user->findMe(),
        'isAnonymous' => false,
        'PerformerChat' => $performerChat->getPerformerChat('model', $roomId)
      ]);
    } else {
      $tokenId = rand();
      $issuedAt = time();
      $notBefore = $issuedAt + 10;             //Adding 10 seconds
      $expire = $notBefore * 6000;            // Adding 60 seconds
      $serverName = 'localhost'; // Retrieve the server name from config file

      $data = [
        'iat' => $issuedAt, // Issued at: time when the token was generated
        'jti' => $tokenId, // Json Token Id: an unique identifier for the token
        'iss' => $serverName, // Issuer
        'nbf' => $notBefore, // Not before
        'exp' => $expire, // Expire
        'data' => [                  // Data related to the signer user
          'userId' => 0, // userid from the users table
          'userName' => $anonymous, // User name
        ]
      ];

      $secretKey = '12345';

      /*
       * Encode the array to a JWT string.
       * Second parameter is the key to encode the token.
       *
       * The output string can be validated at http://jwt.io/
       */
      $jwt = JWT::encode(
          $data, //Data to be encoded in the JWT
          $secretKey, // The signing key
          'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
      );
      return view("Model::chat-room", [
        'turnConfig' => AppHelper::getTurnInfo(),
        'userData' => ['id' => 0, 'username' => $anonymous, 'premium' => 'no', 'role' => $guest, 'token' => $jwt],
        'roomId' => $roomId,
        'isRoom' => $room->checkRoom($roomId),
        'isAnonymous' => true
      ]);
    }
  }

  /**
   * Show Message Inbox.
   *
   * @return Response
   */
  public function getMessageBox() {
    \App::setLocale(session('lang'));
    $userData = AppSession::getLoginData();
    $memberMessage = MessageModel::select('messages.*', 'users.username', 'users.firstName', 'users.lastName', 'users.avatar')
      ->where('messages.messagetoId', '=', $userData->id)
      ->where('messages.status', MessageModel::SENT)
      ->join('users', 'users.id', '=', 'messages.messageformId')
      ->orderby('createdAt', 'desc')
      ->groupby('messages.messageformId')
      ->paginate(LIMIT_PER_PAGE);
    return view('Model::model_dashboard_messages')->with('msgInbox', $memberMessage);
  }

  /*
   * Show model schedule
   * #return response
   *    */

  public function mySchedule() {
    \App::setLocale(session('lang'));
    $userData = AppSession::getLoginData();
    $schedule = null;

    if ($userData && $userData->role == 'model') {
      $schedule = ScheduleModel::where('modelId', $userData->id)->first();
    }
    $schedules = [
      'monday' => $schedule->monday,
      'tuesday' => $schedule->tuesday,
      'wednesday' => $schedule->wednesday,
      'thursday' => $schedule->thursday,
      'friday' => $schedule->friday,
      'saturday' => $schedule->saturday,
      'sunday' => $schedule->sunday
    ];

    $currentKey = lcfirst(date('l', strtotime('today')));
    $nextSchedule = null;

    if ($schedules[$currentKey] > date('H:i:s') && array_key_exists($currentKey, array_filter($schedules))) {

      $nextSchedule = date('Y-m-d') . ' ' . date('H:i', strtotime($schedules[$currentKey]));
    } else {
      for ($i = 1; $i < 7; $i++) {
//          echo date('l', strtotime($currentKey . " +{$i} + day"));
        $nextKey = lcfirst(date('l', strtotime($currentKey . " +{$i} day")));
        if (array_key_exists($nextKey, array_filter($schedules))) {
          $nextSchedule = date('Y-m-d', strtotime($currentKey . " +{$i} day")) . ' ' . date('H:i', strtotime($schedules[$nextKey]));
          break;
        }
      }
    }

    $notWorking =  trans('messages.notWorking');
    return view('Model::model_dashboard_schedule')->with('mySchedule', $schedule)->with('nextSchedule', $nextSchedule)->with('mynotWorking',$notWorking);
  }

  /*
   * Edit
   * @return schedule data
   */

  public function editSchedule() {
    \App::setLocale(session('lang'));
    $userData = AppSession::getLoginData();
    $schedule = null;

    if ($userData && $userData->role == 'model') {
      $schedule = ScheduleModel::where('modelId', $userData->id)->first();
    }
    return view('Model::model_dashboard_schedule_edit')->with('mySchedule', $schedule);
  }

  public function postSchedule(){
    \App::setLocale(session('lang'));

    $Schedulewassuccessfullyupdated = trans('messages.Schedulewassuccessfullyupdated');
    $systemerrorcannotsave = trans('messages.systemerrorcannotsave');


      $userData = AppSession::getLoginData();

      $inputData = Input::all();
      $schedule = (Input::has('id') && $inputData['id'] != null) ? ScheduleModel::findOrFail(Input::get('id')) : new ScheduleModel();

      $schedule->modelId = $userData->id;
//      $schedule->nextLiveShow = ($inputData['nextLiveShow'] != '') ? $inputData['nextLiveShow'] : null;
      $schedule->timezone = ($inputData['timezone'] != '') ? $inputData['timezone'] : '+00:00';
      $schedule->timezoneDetails = $inputData['timezoneDetails'];
      $schedule->monday = ($inputData['monday'] != '') ? $inputData['monday'] : null;
      $schedule->tuesday = ($inputData['tuesday'] != '') ? $inputData['tuesday'] : null;
      $schedule->wednesday = ($inputData['wednesday'] != '') ? $inputData['wednesday'] : null;
      $schedule->thursday = ($inputData['thursday'] != '') ? $inputData['thursday'] : null;
      $schedule->friday = ($inputData['friday'] != '' ) ? $inputData['friday'] : null;
      $schedule->saturday = ($inputData['saturday']) ? $inputData['saturday'] : null;
      $schedule->sunday = ($inputData['sunday'] != '') ? $inputData['sunday'] : null;
//      $schedule->fill($inputData);
      if($schedule->save()){
          return redirect('models/dashboard/schedule')->with('msgInfo', $Schedulewassuccessfullyupdated);
      }
      return back()->withInput()->with('msgError', $systemerrorcannotsave);
  }

  /*   * *
   * TODO -- filter model payments
   * * */

  public function myEarnings() {
    \App::setLocale(session('lang'));
    return view('Model::model_dashboard_earnings');
  }

  /**
    TODO: Member Dashboard profile
   * */
  public function getMyProfile() {


  //die("hola mundo");
   \App::setLocale(session('lang'));
   $userData = AppSession::getLoginData();
   

   $Unknown = trans('messages.unknown');
    
   $model = UserModel::select('users.*','p.*','users.birthdate','users.subirthdate','users.ellacm','users.elcm','users.elfisionomia','users.ellafionomia','users.eletnia','users.ellaetnia','users.ellafionomia' ,'users.ellacm','p.country_id', 'p.age', 'p.agellla', 'gender', 'p.ethnicity', 'p.eyes', 'p.hair', 'p.height', 'p.weight', 'p.languages', 'p.pubic', 'p.bust', 'p.state_name', 'p.city_name', 'p.about_me', 'p.blog', DB::raw('IF(p.country_id = ct.id, ct.name, "Unknown") as countryName'))
            ->join('performer as p', 'p.user_id', '=', 'users.id')
            ->leftJoin('countries as ct', 'ct.id', '=', 'p.country_id')
//            ->leftJoin('categories as c', 'c.id', '=', 'p.category_id')
            ->where('users.id', $userData->id)
            ->with('categories')
            ->first();

$gustosperson = array();
$elgusta = array();

$preferenciaperson = array();
$elpreferencia = array();

$preferenciaperson = PreferenciasPersonas::where('users_id', '=', $userData->id )->get();
$gustosperson = GustosGente::where('users_id', '=', $userData->id )->get();  




if(!empty($gustosperson)){

        foreach ($gustosperson as $key => $value) {
          $gustos[$value->gustos_id] = Gustos::where('gustos_id', '=', $value->gustos_id )->first();
          $elgusta[$value->gustos_id] = $gustos[$value->gustos_id]['descripcionES'];

      }

}


if(!empty($preferenciaperson)){

    foreach ($preferenciaperson as $key => $value) {

    $preferencias[$value->Preferencias_id] = Preferencias::where('Preferencias_id', '=', $value->Preferencias_id )->first();  
    $elpreferencia[$value->Preferencias_id] = $preferencias[$value->Preferencias_id]['descripcionES'];

    }

}

 $document = DocumentModel::where('ownerId', $userData->id)->first();


    return view('Model::model_dashboard_profile', compact('model', 'document', 'elpreferencia','elgusta','elpreferencia') )->with('myUnknown', $Unknown);
  }
  /**
    TODO: Member Dashboard profile
   * */
  public function getProfileImages() {
    \App::setLocale(session('lang'));
    $getUserLogin = AppSession::getLoginData();
    if (!$getUserLogin) {
      return redirect('login');
    }
    $profileImages = AttachmentModel::where('media_type', 'profile')
      ->where('owner_id', $getUserLogin->id)
      ->get();

    return view('Model::model_dashboard_profile_view_images')->with('profileImages', $profileImages);
  }

  /**
    TODO: Member Dashboard profile
   * */
  public function getEditProfile() {


    \App::setLocale(session('lang'));
       $getUserLogin = AppSession::getLoginData();
    if (!$getUserLogin) {
      return redirect('login');
    }
    $elgust = "";
    $user = UserModel::find($getUserLogin->id);
    //$gustos = GustosGente::find($getUserLogin->id);
    $gustosperson      = GustosGente::where('users_id', '=', $getUserLogin->id )->get();
    $preferenciaperson = PreferenciasPersonas::where('users_id', '=', $getUserLogin->id )->get();



    if(!empty($gustosperson)){

        foreach ($gustosperson as $key => $value) {
         $gustos[$value->gustos_id] = Gustos::where('gustos_id', '=', $value->gustos_id )->first();
          $elgusta[$value->gustos_id] = $gustos[$value->gustos_id]['descripcionES'];

        }

    }
    else
    {
        $gustosperson = array();
        $elgusta = array();

    }


    $gustosES = Gustos::orderBy('descripcionES')->lists('descripcionES', 'gustos_id');
    $gustosEN = Gustos::orderBy('descripcionEN')->lists('descripcionEN', 'gustos_id');
    $gustosFR = Gustos::orderBy('descripcionFR')->lists('descripcionFR', 'gustos_id');


    $allgustos = array();
    $allgustos2 = array();

    foreach ($gustosEN as $key => $value) {
      $gustosingles[$key] =  $value;  
    }

    foreach ($gustosFR as $key => $value) {
      $gustosfrances[$key] =  $value;  
    }


    foreach ($gustosES as $key => $value) {
      $allgustos[$key] =  $value;  
    }

    $idioma['ES'] = $allgustos;
    $idioma['EN'] = $gustosingles;
    $idioma['FR'] = $gustosfrances;


    foreach ($idioma as $clav => $valg) {

      foreach ($valg as $indice => $texto ) {
        $val = $idioma['ES'][$indice];
        $allgustos2[$val]['lang'][$clav] =  $texto;
        $allgustos2[$val]['lang']['valor'] = $indice;
      } 

    }




   // $gustosopt = "";
    foreach ($allgustos2 as $key => $value){
      
      
      if(!empty($elgusta))
      {   
          $lotiene = array_search($key, $elgusta);    
          

          
          if(!empty($lotiene))
          {
          
              $valgo = $elgusta[$lotiene];

              $miid = str_replace(" ", "", $elgusta[$lotiene]);
              $miid = str_replace("(", "", $miid);
              $miid = str_replace(")", "", $miid);
              $miid = str_replace("+", "", $miid);
              $miid = str_replace("í", "i", $miid);
              $miid = str_replace("-", "", $miid);

              $allgustos2[$valgo]['lang']['marcar'] = "checked";
              $allgustos2[$valgo]['lang']['id'] = $miid;

          }
          else
          {

              $miid = str_replace(" ", "", $key);
              $miid = str_replace("(", "", $miid);
              $miid = str_replace(")", "", $miid);
              $miid = str_replace("+", "", $miid);
              $miid = str_replace("í", "i", $miid);
              $miid = str_replace("-", "", $miid);

              $allgustos2[$key]['lang']['marcar'] = "check";
              $allgustos2[$key]['lang']['id'] = $miid;

          }
      }
      else
      {

        $miid = str_replace(" ", "", $key);
        $miid = str_replace("(", "", $miid);
        $miid = str_replace(")", "", $miid);
        $miid = str_replace("+", "", $miid);
        $miid = str_replace("í", "i", $miid);
        $miid = str_replace("-", "", $miid);

        $allgustos2[$key]['lang']['marcar'] = "check";
        $allgustos2[$key]['lang']['id'] = $miid;

      }

    }


/*Preferencias*/





    if(!empty($preferenciaperson)){

    foreach ($preferenciaperson as $key => $value) {

    $preferencias[$value->Preferencias_id] = Preferencias::where('Preferencias_id', '=', $value->Preferencias_id )->first();  
    $elpreferencia[$value->Preferencias_id] = $preferencias[$value->Preferencias_id]['descripcionES'];

    }

    }
    else
    {

        $preferenciaperson = array();
        $elpreferencia = array();

    }


            
    $PreferenciasES = Preferencias::orderBy('Preferencias_id')->lists('descripcionES', 'Preferencias_id');
    $PreferenciasEN = Preferencias::orderBy('Preferencias_id')->lists('descripcionEN', 'Preferencias_id');
    $PreferenciasFR = Preferencias::orderBy('Preferencias_id')->lists('descripcionFR', 'Preferencias_id');


    $Preferencias['ES'] = $PreferenciasES;
    $Preferencias['EN'] = $PreferenciasEN;
    $Preferencias['FR'] = $PreferenciasFR;



    $allpreferencia = array();
    $allpreferencia2 = array();

    foreach ($PreferenciasEN as $key => $value) {
      $preferenciaingles[$key] =  $value;  
    }

    foreach ($PreferenciasFR as $key => $value) {
      $preferenciafrances[$key] =  $value;  
    }


    foreach ($PreferenciasES as $key => $value) {
      $allpreferencia[$key] =  $value;  
    }

    $idioma2['ES'] = $allpreferencia;
    $idioma2['EN'] = $preferenciaingles;
    $idioma2['FR'] = $preferenciafrances;


    foreach ($idioma2 as $clav => $valg) {

      foreach ($valg as $indice => $texto ) {

        $val = $idioma2['ES'][$indice];
        $allpreferencia2[$val]['lang'][$clav] =  $texto;
        $allpreferencia2[$val]['lang']['valor'] = $indice;

      } 

    }




   // $gustosopt = "";
    foreach ($allpreferencia2 as $key => $value){

      if(!empty($elpreferencia))
      {


        $lotiene = array_search($key, $elpreferencia);    
        

        
        if(!empty($lotiene))
        {
        
            $valgo = $elpreferencia[$lotiene];

            $miid = str_replace(" ", "", $elpreferencia[$lotiene]);
            $miid = str_replace("(", "", $miid);
            $miid = str_replace(")", "", $miid);
            $miid = str_replace("+", "", $miid);
            $miid = str_replace("í", "i", $miid);
            $miid = str_replace("-", "", $miid);

            $allpreferencia2[$valgo]['lang']['marcar'] = "checked";
            $allpreferencia2[$valgo]['lang']['id'] = $miid;
        }
        else
        {

            $miid = str_replace(" ", "", $key);
            $miid = str_replace("(", "", $miid);
            $miid = str_replace(")", "", $miid);
            $miid = str_replace("+", "", $miid);
            $miid = str_replace("í", "i", $miid);
            $miid = str_replace("-", "", $miid);

            $allpreferencia2[$key]['lang']['marcar'] = "check";
            $allpreferencia2[$key]['lang']['id'] = $miid;

        }


      }
      else
      {


            $miid = str_replace(" ", "", $key);
            $miid = str_replace("(", "", $miid);
            $miid = str_replace(")", "", $miid);
            $miid = str_replace("+", "", $miid);
            $miid = str_replace("í", "i", $miid);
            $miid = str_replace("-", "", $miid);

            $allpreferencia2[$key]['lang']['marcar'] = "check";
            $allpreferencia2[$key]['lang']['id'] = $miid;


      }


  }











    $countries = CountryModel::orderBy('name')->lists('name', 'id')->all();
    $performer = PerformerModel::where('user_id', $user->id)->first();
    
    $cat = $user->categories->pluck('id')->toArray();
    if(empty($cat) && !empty($performer->category_id)){
        $cat = [$performer->category_id];
    }
    $heightList = UserModel::getHeightList();
    $weightList = UserModel::getWeightList();

    //aquiestoyyo
   

    $locale = App::getLocale();
   if($locale =="en"){
      $categories = CategoryModel::orderBy('name_en')->lists('name_en', 'id')->all();

   }elseif($locale =="fr"){
      $categories = CategoryModel::orderBy('name_fr')->lists('name_fr', 'id')->all();

   }else{
         $categories = CategoryModel::orderBy('name')->lists('name', 'id')->all();
   }



   
    return view('Model::model_dashboard_profile_edit', compact('countries', 'user', 'performer', 'heightList', 'weightList', 'categories', 'cat', 'allgustos2','allpreferencia2'));

  }

  /**
    TODO: Member Update Profile
   * */






   public function guardarextras($valor, $id, $condicion){

    switch ($condicion) {
    
    case "GUSTOS":

    if(!empty($valor))
    {


      $GustosGente              =   new GustosGente;
      $GustosGente->gustos_id   =   $valor;
      $GustosGente->users_id    =   $id;

      if ($GustosGente->save()) {
        return "guardo";
      }


      

    }
    else
    {
      return "noguardo";
    }
        
    break;

    case "Preferencias":



    if(!empty($valor))
    {

      $PreferenciasPersonas              =   new PreferenciasPersonas;
      $PreferenciasPersonas->Preferencias_id   =   $valor;
      $PreferenciasPersonas->users_id    =   $id;

      if ($PreferenciasPersonas->save()) {
        return "guardo";
      }

    }
    else
    {
      return "noguardo";
    }
      


    break;
  }



  }

  public function updateProfile() {


    \App::setLocale(session('lang'));

    session_start();



    $youraccountdoesnotfound = trans('messages.youraccountdoesnotfound');
    $profileUpdateSuccessfull = trans('messages.profileUpdateSuccessfull');
    $errorProfileUpdateMemberControl = trans('messages.errorProfileUpdateMemberControl');

    $rules = [
      'firstName'           => ['Required', 'Min:2', 'Max:32'],
      'lastName'            => ['Required', 'Min:2', 'Max:32'],
      'gender'              => 'Required|in:'.UserModel::GENDER_MALE.','.UserModel::GENDER_FEMALE.','.UserModel::GENDER_TRANSGENDER.','.UserModel::pareja,
      
     // 'age' => 'Required|Integer|Min:18|Max:100',
      'ethnicity'           => 'String',
      'eyes'                => 'Alpha',
      'hair'                => 'Alpha',
      //'weight'              => 'Required',
      'country'             => 'Required',
      'state_name'          => 'String|Max:100',
      'city_name'           => 'String|Max:100',
      'about_me'            => 'String|Max:500',
      'status'              => 'String|Max:144',
      'blogname'            => 'String|Max:100',
      'blog'                => 'active_url|Max:255',
      'languages'           => 'String',
      'tags' => 'string',
      'category' => 'Required'
    ];






    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }


    $userData = AppSession::getLoginData();
    $user = UserModel::find($userData->id);
    if (!$user){
        AppSession::getLogout();
      return redirect('login')->with('msgError', $youraccountdoesnotfound);
    }

    unset($_SESSION['OSSN_USER']);

    include(getcwd() ."/valor.php");


    $obj->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $obj->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $obj->username = $user->username;
    $obj->studioName = $user->studioName;
    $obj->email = $user->email;
    $obj->gender = Input::get('gender');
    $obj->birthdate = $user->birthdate;
    $obj->bitpay = $user->bitpay;
    $obj->fullname = preg_replace('/\s+/', ' ',  Input::get('firstName'))." ".preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $obj->password_algorithm = "bcrypt";
    $obj->data = $objeto2;
    $obj->guid = $user->id;
    $obj->type = "admin";
    $obj->last_login = 1600912483;
    $obj->activation = "";
    $obj->time_created = $user->createdAt;

    $_SESSION['OSSN_USER'] = $obj;


    $user->firstName    = preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $user->lastName    = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $user->gender       = Input::get('gender');
    $user->bio          = Input::get('about_us');
    $user->status       = preg_replace('/\s+/', ' ',  Input::get('status'));
     $user->elfisionomia       = preg_replace('/\s+/', ' ',  Input::get('fionomia'));
    $user->ellafionomia       = preg_replace('/\s+/', ' ',  Input::get('fionomiaellla'));
    $user->eletnia       = preg_replace('/\s+/', ' ',  Input::get('ethnicity'));
    $user->ellaetnia       = preg_replace('/\s+/', ' ',  Input::get('ethnicityellla'));
    $user->elcm       = preg_replace('/\s+/', ' ',  Input::get('height'));
    $user->ellacm       = preg_replace('/\s+/', ' ',  Input::get('heightellla'));
    $user->location_id        = Input::get('country');
    $user->countryId        = Input::get('country');
    $user->experiencias    = preg_replace('/\s+/', ' ',  Input::get('experiencias'));

    if ($user->save()) {

        $user->categories()->sync(Input::get('category'));

        $performer = PerformerModel::where('user_id', '=', $user->id)->first();
        if (!$performer) {
          $performer = new PerformerModel;
        }

        $performer->sex               = Input::get('gender');
        $performer->sexualPreference  = Input::get('sexualPreference');
        $performer->age               = Input::get('age');
         $performer->agellla          = Input::get('agellla');
        $performer->ethnicity         = Input::get('ethnicity', null);
        $performer->eyes              = Input::get('eyes');
        $performer->hair              = Input::get('hair');
        $performer->height            = Input::get('height');
        $performer->fisionomia        = Input::get('fionomia');
        $performer->weight            = Input::get('weight');
        $performer->category_id       = null;
        $performer->pubic             = Input::get('pubic');
        $performer->bust              = Input::get('bust');
        $performer->languages         = Input::get('languages');
        $performer->country_id        = Input::get('country');

        $performer->state_name        = Input::get('state_name');
        $performer->city_name         = Input::get('city_name');
        $performer->about_me          = Input::get('about_me');
        
        $performer->eyes_ella              = Input::get('eyes_ella');
        $performer->hair_ella              = Input::get('hair_ella');
        $performer->weight_ella            = Input::get('weight_ella');
        $performer->pubit_ella             = Input::get('pubit_ella');


        $performer->blogname          = preg_replace('/\s+/', ' ',  Input::get('blogname'));
        $performer->blog              = Input::get('blog');
        $performer->tags = Input::get('tags');


        if ($performer->save()) {

$gustose = GustosGente::where('users_id', '=', $user->id)->get();


GustosGente::where( 'users_id', $user->id )->delete();

//aqui1

$contente = array();  
$contente[0] = ModelController::guardarextras(Input::get('22'),$user->id,'GUSTOS');
$contente[1] = ModelController::guardarextras(Input::get('BDSM'),$user->id,'GUSTOS');
$contente[2] = ModelController::guardarextras(Input::get('Candaulismo'),$user->id,'GUSTOS');
$contente[3] = ModelController::guardarextras(Input::get('Chat'),$user->id,'GUSTOS');
$contente[4] = ModelController::guardarextras(Input::get('Dúo'),$user->id,'GUSTOS');
$contente[5] = ModelController::guardarextras(Input::get('Exhibición'),$user->id,'GUSTOS');
$contente[6] = ModelController::guardarextras(Input::get('Extremo'),$user->id,'GUSTOS');
$contente[7] = ModelController::guardarextras(Input::get('Fetichismo'),$user->id,'GUSTOS');
$contente[8] = ModelController::guardarextras(Input::get('Fotos'),$user->id,'GUSTOS');
$contente[9] = ModelController::guardarextras(Input::get('Gangbang'),$user->id,'GUSTOS');  
$contente[10] = ModelController::guardarextras(Input::get('Hard'),$user->id,'GUSTOS');
$contente[11] = ModelController::guardarextras(Input::get('Intercambiocompleto'),$user->id,'GUSTOS');
$contente[12] = ModelController::guardarextras(Input::get('Intercambiosuave'),$user->id,'GUSTOS');
$contente[13] = ModelController::guardarextras(Input::get('Juegosderol'),$user->id,'GUSTOS');
$contente[14] = ModelController::guardarextras(Input::get('Lives'),$user->id,'GUSTOS');
$contente[15] = ModelController::guardarextras(Input::get('Mimitos'),$user->id,'GUSTOS');
$contente[16] = ModelController::guardarextras(Input::get('Sensación'),$user->id,'GUSTOS');
$contente[17] = ModelController::guardarextras(Input::get('Sincontactofisico'),$user->id,'GUSTOS');
$contente[18] = ModelController::guardarextras(Input::get('Suave'),$user->id,'GUSTOS');
$contente[19] = ModelController::guardarextras(Input::get('Trio'),$user->id,'GUSTOS');
$contente[20] = ModelController::guardarextras(Input::get('Videos'),$user->id,'GUSTOS');
$contente[21] = ModelController::guardarextras(Input::get('Voyerismo'),$user->id,'GUSTOS');
  


$hacer = "no";
foreach ($contente as $keys => $values) {
  if( $values == "guardo"){
    $hacer = "si";
  }

}

if($hacer == "no")
{
 
  foreach ($gustose as $yu => $manyi) {
      $GustosGente              =   new GustosGente;
      $GustosGente->gustos_id   =   $manyi->gustos_id;
      $GustosGente->users_id    =   $manyi->users_id;
      $GustosGente->save();
  }

}



/*Preferencias*/


$Preferenciae = PreferenciasPersonas::where('users_id', '=', $user->id)->get();


PreferenciasPersonas::where( 'users_id', $user->id )->delete();

//aqui1
$contente = array();  
$contente[0] = ModelController::guardarextras(Input::get('Mujerhetero'),$user->id,'Preferencias');
$contente[1] = ModelController::guardarextras(Input::get('MujerBi'),$user->id,'Preferencias');
$contente[2] = ModelController::guardarextras(Input::get('Lesbiana'),$user->id,'Preferencias');
$contente[3] = ModelController::guardarextras(Input::get('Hombrehetero'),$user->id,'Preferencias');
$contente[4] = ModelController::guardarextras(Input::get('HombreBi'),$user->id,'Preferencias');
$contente[5] = ModelController::guardarextras(Input::get('Gay'),$user->id,'Preferencias');
$contente[6] = ModelController::guardarextras(Input::get('Parejahetero'),$user->id,'Preferencias');
$contente[7] = ModelController::guardarextras(Input::get('ParejaHBi'),$user->id,'Preferencias');
$contente[8] = ModelController::guardarextras(Input::get('ParejaMBi'),$user->id,'Preferencias');
$contente[9] = ModelController::guardarextras(Input::get('ParejaBi'),$user->id,'Preferencias');  
$contente[10] = ModelController::guardarextras(Input::get('CrossDresser'),$user->id,'Preferencias');
$contente[11] = ModelController::guardarextras(Input::get('Transexual'),$user->id,'Preferencias');
  


$hacer = "no";
foreach ($contente as $keys => $values) {

  if( $values == "guardo"){
    $hacer = "si";
  }

}

if($hacer == "no")
{
 
  foreach ($Preferenciae as $yu => $manyi) {
      $GustosGente              =   new PreferenciasPersonas;
      $GustosGente->Preferencias_id   =   $manyi->Preferencias_id;
      $GustosGente->users_id    =   $manyi->users_id;
      $GustosGente->save();
  }

}

/*FIN DE PRERERENCIAS*/

    PerformerTag::updateTags($performer->id, $performer->tags);
          return redirect('models/dashboard/profile')->with('msgInfo', $profileUpdateSuccessfull);
        }
    }
    return back()->with('msgError', $errorProfileUpdateMemberControl);

  }

  /**
    TODO: Member Update Profile
   * */
  public function postUpdateProfile(Request $get) {


    \App::setLocale(session('lang'));

    $yourprofilewassuccessfullyupdated = trans('messages.yourprofilewassuccessfullyupdated');
    $systemerrorcannotupdateprofile = trans('messages.systemerrorcannotupdateprofile');


    $getUserLogin = AppSession::getLoginData();
    if (!$getUserLogin) {
      return redirect::to('/login');
    }

    $bio = $get->aboutMe;
    $location_id = $get->country;
    $file = $get->file('avatar');
    $userMetaPost = array(
      'visible' => $get->visible,
      'state' => $get->state,
      'city' => $get->city,
      'age' => $get->age,
      'starSign' => $get->starSign,
      'eyesColor' => $get->eyesColor,
      'hairColor' => $get->hairColor,
      'height' => $get->height,
      'ethnicity' => $get->ethnicity,
      'build' => $get->build,
      'appearance' => $get->appearance,
      'marital' => $get->marital,
      'orient' => $get->orient,
      'looking' => $get->looking,
    );
    $updateProfile = UserModel::find($getUserLogin->id);
    $updateProfile->userMeta = serialize($userMetaPost);
    $updateProfile->bio = $bio;
    $updateProfile->location_id = $location_id;
    if ($file) {
      $extension = $file->getClientOriginalExtension();
      $notAllowed = array("exe", "php", "asp", "pl", "bat", "js", "jsp", "sh", "doc", "docx", "xls", "xlsx");
      $destinationPath = $_SERVER['DOCUMENT_ROOT'] . PATH_IMAGE . "upload/member/";
      $filename = "avatar_member_" . $getUserLogin->id . "." . $extension;
      $fileNameLarge = "avatar_member_large_" . $getUserLogin->id . "." . $extension;
      $fileNameMedium = "avatar_member_medium_" . $getUserLogin->id . "." . $extension;
      $fileNameSmall = "avatar_member_small_" . $getUserLogin->id . "." . $extension;
      if (!in_array($extension, $notAllowed)) {
        $file->move($destinationPath, $filename);
        $resizeImage = new AppImage($destinationPath . $filename);
        $imageLage = $resizeImage->resize(800, 600)->save($destinationPath . $fileNameLarge);
        $imageMedium = $resizeImage->resize(400, 300)->save($destinationPath . $fileNameMedium);
        $imageSmall = $resizeImage->resize(100, 100)->save($destinationPath . $fileNameSmall);
        $profileImage = array(
          'imageLarge' => $fileNameLarge,
          'imageMedium' => $fileNameMedium,
          'imageSmall' => $fileNameSmall,
          'normal' => $filename
        );
        $updateProfile->avatar = serialize($profileImage);
        $updateProfile->smallAvatar = $fileNameSmall;
      }
    }
    if ($updateProfile->save()) {
      return redirect('models/dashboard/profile')->with('msgInfo', $yourprofilewassuccessfullyupdated);
    } else {
      return redirect('models/dashboard/profile')->with('msgError', $systemerrorcannotupdateprofile );
    }
  }


  public function getMySettings(Request $req) {
    \App::setLocale(session('lang'));
    $zone = null;
    $userData = AppSession::getLoginData();
    $otherSettings = null;
    $contact = null;
    switch ($req->get('action')) {
      case 'others':
        $zone = ZoneModel::orderBy('zone_name')->get();
        $me = UserModel::find($userData->id);

        if (AppHelper::is_serialized($me->userSettings)) {
          $otherSettings = json_encode(unserialize($me->userSettings));
        }

        return view('Model::model_dashboard_settings')->with('action', $req->get('action'))->with('timezone', $zone)->with('otherSettings', $otherSettings);
        break;
      case 'contact':
        $contact = UserModel::leftJoin('countries', 'users.countryId', '=', 'countries.id')
          ->select('users.*', 'countries.name as countryName', 'stateName')
          ->where('users.id', $userData->id)
          ->first();

        return view('Model::model_dashboard_settings')->with('action', $req->get('action'))->with('contact', $contact);
        break;
      case 'edit-contact':
        $contact = UserModel::leftJoin('countries', 'users.countryId', '=', 'countries.id')
          ->select('users.*', 'countries.name as countryName', 'stateName')
          ->where('users.id', $userData->id)
          ->first();
        return view('Model::model_dashboard_settings')->with('action', $req->get('action'))->with('contact', $contact);
        break;
      case 'payment':
        $paymentInfo = UserModel::find($userData->id);

        return view('Model::model_dashboard_settings')->with('action', $req->get('action'))->with('paymentInfo', $paymentInfo);
        break;
      case 'payee-info':
        $model = UserModel::find($userData->id);
        $bankTransferOptions = (object)[
          'withdrawCurrency' => '',
          'taxPayer' => '',
          'bankName' => '',
          'bankAddress' => '',
          'bankCity' => '',
          'bankState' => '',
          'bankZip' => '',
          'bankCountry' => '',
          'bankAcountNumber' => '',
          'bankSWIFTBICABA' => '',
          'holderOfBankAccount' => '',
          'additionalInformation' => '',
          'payPalAccount' => '',
          'checkPayable' => ''
        ];
        if($model->bankTransferOptions){
          $bankTransferOptions = json_decode($model->bankTransferOptions);
        }
        return view('Model::model_dashboard_settings')->with('action', $req->get('action'))->with('bankTransferOptions', $bankTransferOptions);
        break;
      case 'direct-deposity':
        $model = UserModel::find($userData->id);
        $directDeposit = (object)[
          'depositFirstName' => '',
          'depositLastName' => '',
          'accountingEmail' => '',
          'directBankName' => '',
          'accountType' => '',
          'accountNumber' => '',
          'routingNumber' => ''
        ];
        if($model->directDeposit){
          $directDeposit = json_decode($model->directDeposit);
        }
        return view('Model::model_dashboard_settings')->with('action', $req->get('action'))->with('directDeposit', $directDeposit);
        break;
      case 'paxum':
        $model = UserModel::find($userData->id);
        $paxum = (object)[
          'paxumName' => '',
          'paxumEmail' => '',
          'paxumAdditionalInformation' => ''
        ];
        if($model->paxum){
          $paxum = json_decode($model->paxum);
        }
        return view('Model::model_dashboard_settings')->with('action', $req->get('action'))->with('paxum', $paxum);
        break;
      case 'bitpay':
        $model = UserModel::find($userData->id);
        $bitpay = (object)[
          'bitpayName' => '',
          'bitpayEmail' => '',
          'bitpayAdditionalInformation' => ''
        ];
        if($model->bitpay){
          $bitpay = json_decode($model->bitpay);
        }
        return view('Model::model_dashboard_settings')->with('action', $req->get('action'))->with('bitpay', $bitpay);
        break;
      case 'edit-payment':
        $paymentInfo = UserModel::select('minPayment', 'payoneer', 'bankAccount', 'paypal')->where('id', $userData->id)->first();
          if(!$paymentInfo){
              return redirect('404')->with('msgError', 'Payment settings not found.');
          }
        return view('Model::model_dashboard_settings')->with('action', $req->get('action'))->with('paymentInfo', $paymentInfo);
        break;
      case 'commissions':
        $commission = EarningSettingModel::where('userId', $userData->id)
          ->first();
          if(!$commission){
              $commission = new EarningSettingModel();
              $commission->userId = $userData->id;
              $commission->save();
          }
        return view('Model::model_dashboard_settings')->with('action', $req->get('action'))->with('commission', $commission);
        break;
      case 'documents':
          $document = DocumentModel::where('ownerId', $userData->id)->first();
          return view('Model::model_dashboard_settings')->with('action', $req->get('action'))->withdocument($document)->withcuentaestatus($userData->accountStatus);
      default:
        return view('Model::model_dashboard_settings')->with('action', $req->get('action'));
        break;
    }
  }

  /**
   * @return Response
   * @description update setting
   */
  public function updateDocumentSetting() {

    \App::setLocale(session('lang'));

    $yoursessionwasexpired = trans('messages.yoursessionwasexpired');
    $uploadFileNotValid = trans('messages.uploadFileNotValid');
    $docummentUploadedSuccessfull = trans('messages.docummentUploadedSuccessfull');
    $systemError = trans('messages.systemError');
    

    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', $yoursessionwasexpired);
    }
    $validator = Validator::make(Input::all(), [
        'idImage' => 'Mimes:jpg,jpeg,png',
        'idImage2' => 'Mimes:jpg,jpeg,png',
        'faceId' => 'Mimes:jpg,jpeg,png',
        'usernameContrato' => 'Required|String',
        'fechaNacimientoContrato' => 'Required',
        'fechaFirmaContrato' => 'Required',
    ]);

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }

    $identityDocument = DocumentModel::where('ownerId', $userData->id)->first();
    if (!$identityDocument) {
      $identityDocument = new DocumentModel;
    }
    $identityDocument->ownerId = $userData->id;
    $destinationPath = 'uploads/models/identity/'; // upload path
    if (Input::file('idImage')) {
      // checking file is valid.
      if (!Input::file('idImage')->isValid()) {
        return Back()->with('msgInfo', $uploadFileNotValid);
      }

      $image = Input::file('idImage');
      $filename = $userData->username . '.' . $image->getClientOriginalExtension();

      $idPath = $destinationPath . 'id-images/' . $filename;

      Input::file('idImage')->move($destinationPath . 'id-images', $filename);
      $identityDocument->idImage = $idPath;
    }

    if (Input::file('idImage2')) {
      // checking file is valid.
      if (!Input::file('idImage2')->isValid()) {
        return Back()->with('msgInfo', $uploadFileNotValid);
      }

      $image = Input::file('idImage2');
      $filename = $userData->username . '.' . $image->getClientOriginalExtension();

      $idPath = $destinationPath . 'id-images2/' . $filename;

      Input::file('idImage2')->move($destinationPath . 'id-images2', $filename);
      $identityDocument->idImage2 = $idPath;
    }
    if (Input::file('faceId')) {
      // checking file is valid.
      if (!Input::file('faceId')->isValid()) {
        return Back()->with('msgInfo', $uploadFileNotValid);
      }

      $image = Input::file('faceId');
      $filename = $userData->username . '.' . $image->getClientOriginalExtension();

      $facePath = $destinationPath . 'face-ids/' . $filename;

      Input::file('faceId')->move($destinationPath . 'face-ids', $filename);
      $identityDocument->faceId = $facePath;
            $identityDocument->usernameContrato = Input::get('usernameContrato');
      $identityDocument->fechaNacimientoContrato = Input::get('fechaNacimientoContrato');
      $identityDocument->fechaFirmaContrato = Input::get('fechaFirmaContrato');
    }
    if ($identityDocument->save()) {

            $send = Mail::send('email.verificacionemision', array('username' => $userData->username, 'email' => $userData->email), function($message) use($userData) {
              $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($userData->email)->subject('En proceso de validación de la cuenta | ' . app('settings')->siteName);
          });



      $send = Mail::send('email.verificacionsolicitud', array('username' => $userData->username, 'user_id' => $userData->id), function($message) use($userData) {
              $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to("verificaciones@implik-2.com")->subject('El usuario '.$userData->username.' ha solicitado verificar su cuenta | ' . app('settings')->siteName);
          });
            
      return Back()->with('msgInfo', $docummentUploadedSuccessfull);
    }
    return Back()->with('msgError', $systemError);
  }

  public function postPayeeInfo(){
    \App::setLocale(session('lang'));

    $yoursessionwasexpired = trans('messages.yoursessionwasexpired');
    $systemError = trans('messages.systemError');
    $docummentUploadedSuccessfull = trans('messages.docummentUploadedSuccessfull');


    $userData = AppSession::getLoginData();

    if (!$userData) {
      return Redirect('login')->With('msgError', $yoursessionwasexpired);
    }
    $rules = [
      'withdrawCurrency' => 'Required|String',
      'taxPayer' => 'String',
      'bankName' => 'Required|String',
      'bankAddress' => 'Required|String',
      'bankCity' => 'Required|String',
      'bankState' => 'Required|String',
      'bankZip' => 'Required|String',
      'bankCountry' => 'Required|String',
      'bankAcountNumber' => 'Required|String',
      'bankSWIFTBICABA' => 'Required|String',
      'holderOfBankAccount' => 'Required|String',
      'additionalInformation' => 'String'
    ];
    if(Input::get('withdraw') === 'paypal'){
      $rules = [
          'payPalAccount' => 'Required|String'
      ];
    }elseif(Input::get('withdraw') === 'check'){
      $rules = [
          'checkPayable' => 'Required|String'
      ];
    }
    $validator = Validator::make(Input::all(), $rules);
    
    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    $model = UserModel::find($userData->id);
    $model->bankTransferOptions = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', $docummentUploadedSuccessfull);
    }
    return Back()->with('msgError', $systemError);
  }

  public function postDirectDeposity(){
    \App::setLocale(session('lang'));

        $yoursessionwasexpired = trans('messages.yoursessionwasexpired');
    $docummentUploadedSuccessfull = trans('messages.docummentUploadedSuccessfull');

    $systemError = trans('messages.systemError');


    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', $yoursessionwasexpired);
    }
    $rules = [
      'depositFirstName' => 'Required|String',
      'depositLastName' => 'Required|String',
      'accountingEmail' => 'Email|Required|String',
      'directBankName' => 'Required|String',
      'accountType' => 'Required|String',
      'accountNumber' => 'Required|String',
      'routingNumber' => 'Required|String'
    ];

    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    $model = UserModel::find($userData->id);
    $model->directDeposit = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', $docummentUploadedSuccessfull);
    }
    return Back()->with('msgError', $systemError);
  }

  public function postPaxum(){
    \App::setLocale(session('lang'));

    $systemError = trans('messages.systemError');
    $yoursessionwasexpired = trans('messages.yoursessionwasexpired');
    $docummentUploadedSuccessfull = trans('messages.docummentUploadedSuccessfull');


    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', $yoursessionwasexpired);
    }
    $rules = [
      'paxumName' => 'Required|String',
      'paxumEmail' => 'Email|Required|String',
      'paxumAdditionalInformation' => 'Required|String'
    ];

    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    $model = UserModel::find($userData->id);
    $model->paxum = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', $docummentUploadedSuccessfull);
    }
    return Back()->with('msgError', $systemError);
  }
  public function postBitpay(){
    \App::setLocale(session('lang'));

    $yoursessionwasexpired = trans('messages.yoursessionwasexpired');
    $docummentUploadedSuccessfull = trans('messages.docummentUploadedSuccessfull');

    $systemError = trans('messages.systemError');


    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', $yoursessionwasexpired);
    }
    $rules = [
      'bitpayName' => 'Required|String',
      'bitpayEmail' => 'Email|Required|String',
      'bitpayAdditionalInformation' => 'Required|String'
    ];

    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    $model = UserModel::find($userData->id);
    $model->bitpay = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', $docummentUploadedSuccessfull);
    }
    return Back()->with('msgError', $systemError);
  }

  /**
   * Display a Model community.
   *
   * @return Response
   */
  public function getCommunity() {
    \App::setLocale(session('lang'));
    return view('community.community');
  }

  /**
   * Display a Model profile.
   *
   * @return Response
   */
  public function getModelProfile(UserModel $user) {
    \App::setLocale(session('lang'));


    $createRoomError = trans('messages.createRoomError');
    $chatwith = trans('messages.chatwith');
    $in = trans('messages.in');
    $liveadultwebcamroomnow = trans('messages.liveadultwebcamroomnow');


    $loginData = AppSession::getLoginData();
   /* if($loginData && $loginData->role == UserModel::ROLE_MODEL){
      return redirect('/models/live');
    }*/
    // country code for the client's ip address
    $data = AppHelper::getCountryCodeFromClientIp(); 


    if($data){
     // return $data->city_name;
        $geo =   GeoBlockingModel::where('userId', $user->id)
                ->where('isBlock', GeoBlockingModel::isBlock)
                ->orderBy('city_name', 'asc')
                ->get();





                if($geo){

                      foreach ($geo as $key => $value) {

                          if($value->city_name == null){

                              if($value->iso_code == $data->country_code){

                                  return redirect('/')->with('msgError', trans('messages.blockCountry'));
  
                               }

                          }else{

                              if($value->city_name == $data->city_name and $value->iso_code ==$data->country_code){

                                    return redirect('/')->with('msgError', trans('messages.blockCountry'));
                              }

                          }

                      }

                       
                      }
                }




    $memberId = ($loginData) ? $loginData->id : 0;

    $block = OssnRelationships::where('relation_from', '=', $user->id)
                ->where('relation_to', $memberId)
                ->where('type', OssnRelationships::isBlock)
                ->first();
        if($block){
            return redirect('/')->with('msgError', 'Bloqueado');
        }
//    $performer = PerformerModel::select('performer.*', 'users.username', 'users.avatar', DB::raw('(select categories.name from categories where categories.id=performer.category_id) as categoryName'), DB::raw('(select countries.name from countries where countries.id = performer.country_id) as countryName'), 'state_name', 'city_name', DB::raw("(SELECT f.status FROM favorites f WHERE f.favoriteId={$user->id} AND f.ownerId={$memberId}) as favorite"))
//      ->join('users', 'users.id', '=', 'performer.user_id')
//      ->where('user_id', $user->id)
//      ->first();
//    if (!$performer) {
//      return Back()->with('msgError', 'Performer chat does not setting.');
//    }
    //SELECT f.status FROM favorites f WHERE f.favoriteId={$user->id} AND f.ownerId={$memberId}
    $favorite = FavoriteModel::select('status')
            ->where('favoriteId', $user->id)
            ->where('ownerId', $memberId)
            ->first();


    $schedules = [
      'monday' => $user->schedule->monday,
      'tuesday' => $user->schedule->tuesday,
      'wednesday' => $user->schedule->wednesday,
      'thursday' => $user->schedule->thursday,
      'friday' => $user->schedule->friday,
      'saturday' => $user->schedule->saturday,
      'sunday' => $user->schedule->sunday
    ];

    $currentKey = lcfirst(date('l', strtotime('today')));
    $nextSchedule = null;

    if ($schedules[$currentKey] > date('H:i:s') && array_key_exists($currentKey, array_filter($schedules))) {

      $nextSchedule = date('Y-m-d') . ' ' . date('H:i', strtotime($schedules[$currentKey]));
    } else {
      for ($i = 1; $i < 7; $i++) {
//          echo date('l', strtotime($currentKey . " +{$i} + day"));
        $nextKey = lcfirst(date('l', strtotime($currentKey . " +{$i} day")));
        if (array_key_exists($nextKey, array_filter($schedules))) {
          $nextSchedule = date('Y-m-d', strtotime($currentKey . " +{$i} day")) . ' ' . date('H:i', strtotime($schedules[$nextKey]));
          break;
        }
      }
    }


    $room = ChatThreadModel::where('type', ChatThreadModel::TYPE_PUBLIC)
      ->where('ownerId', $user->id)
      ->first();
    if (!$room) {
      $room = new ChatThreadModel;
      $room->ownerId = $user->id;
      $room->type = ChatThreadModel::TYPE_PUBLIC;
      $room->virtualId = md5(time());

      if (!$room->save()) {
        return Back()->with('msgError', $createRoomError);
      }
    }
    $chatSetting = PerformerChatModel::select('welcome_message')
      ->where('model_id', $user->id)
      ->first();

    $domain = $_SERVER['HTTP_HOST'];

    $country = CountryModel::find($user->performer->country_id);
    $countryName = '';
    if($country) {
      $countryName = $country->name;
    }
    return view('Model::profile_detail')
            ->with('room', $room->id)
            ->with('virtualRoom', $room->virtualId)
            ->with('favorite', $favorite)
            ->with('modelId', $user->id)
            ->with('memberId', $memberId)
            ->with('schedule', $user->schedule)
            ->with('model', $user)
            ->with('nextSchedule', $nextSchedule)
            ->with('welcome_message', $chatSetting->welcome_message)
            ->with('title', $chatwith." {$user->username} ".$in." {$domain} ".$liveadultwebcamroomnow)
            ->with('countryName', $countryName);
  }

  /**
   * Display list model by category.
   *
   * @return Response
   */
  public function getModelByCategory($name) {
    \App::setLocale(session('lang'));

    $categoryNotFound = trans('messages.categoryNotFound');

    $category = CategoryModel::where('slug', '=', $name)->first();
    if (!$category) {
      return Redirect('/')->with('msgError', $categoryNotFound);
    }
    return view('Model::list_model_by_category')->with('category', $category);
  }

  /**
   * * */
  public function getMemberProfile() {
    \App::setLocale(session('lang'));

    //--TODO Check current user if member return to member page
    $userData = AppSession::getLoginData();

//
//    $feeds = Feed::select('posts.id as feedId', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'posts.title', 'posts.text', 'posts.owner_id', 'posts.createdAt', 'posts.updatedAt')
//      ->join('users', 'users.id', '=', 'posts.owner_id')
//      ->orderBy('posts.createdAt', 'desc')
//      ->where('owner_id', $userData->id)
//      ->paginate(LIMIT_PER_PAGE);
    //$feeds->setPath('models/dashboard');
    return view('Model::model_profile_sub_wall')->with('userData', $userData)->with('ownerId', $userData->id);
  }

  public function modelDashboard() {
    \App::setLocale(session('lang'));
    return view('Model::model_dashboard');
  }

  /**
   * @Action paid model album image
   * @Author LongPham <long.it.stu@gmail.com>
   * */
  public function paidAllbumImage(Request $get) {

    \App::setLocale(session('lang'));

    $youhavealreadypurchased = trans('messages.youhavealreadypurchased');
    $purchasedSuccessfull = trans('messages.purchasedSuccessfull');
    $tokensNotEnough = trans('messages.tokensNotEnough');
    $requestNotFoundMemberLogin = trans('messages.requestNotFoundMemberLogin');


    if (\Request::ajax()) {
      $userData = AppSession::getLoginData();
      $checkItemExisting = EarningModel::where('itemId', '=', $get->galleryId)->where('item', '=', $get->paymentItem)->where('payFrom', '=', $userData->id)->first();
      $CheckMemberTokens = UserModel::find($userData->id);
      $getModel = UserModel::find($get->paidToId);
      if (!empty($checkItemExisting)) {
        return response()->json([
            'success' => true,
            'message' => $youhavealreadypurchased,
            ], 200);
      } else {
        if ($CheckMemberTokens->tokens >= $get->paidPrice) {
          $newPaid = new EarningModel();
          $newPaid->item = $get->paymentItem;
          $newPaid->itemId = $get->galleryId;
          $newPaid->payFrom = $userData->id;
          $newPaid->payTo = $get->paidToId;
          $newPaid->tokens = $get->paidPrice;
          $newPaid->status = 'paid';
          if ($newPaid->save()) {
            AppHelper::updateMemberTokens($CheckMemberTokens->tokens, $get->paidPrice);
            AppHelper::updateModelTokens($getModel->id, $getModel->tokens, $get->paidPrice);
            return response()->json([
                'success' => true,
                'message' => $purchasedSuccessfull,
                ], 200);
          }
        } else {
          return response()->json([
              'success' => false,
              'message' => $tokensNotEnough,
              ], 200);
        }
      }
    } else {
      return redirect()->back()->with('msgError', $requestNotFoundMemberLogin);
    }
  }

  /**
   * Show resource meet here
   * @return resource
   * @author LongPham <long.it.stu@gmail.com>
   * */
  public function getMeetHer() {
    \App::setLocale(session('lang'));
    return view('Model::meet_her');
  }

  /**
   * Action Search autocomplete model
   * @return resource
   * @author LongPham <long.it.stu@gmail.com>
   * */
  public function getSearchModel() {

    \App::setLocale(session('lang'));

    $methodNotAllowed = trans('messages.methodNotAllowed');
    $accountHasExpired = trans('messages.accountHasExpired');

    if (!\Request::ajax()) {
      return redirect()->back()->with('msgError', $methodNotAllowed);
    }

    $action = \Request::only('modelname');
    if (empty($action['modelname'])) {
      //
    }
    if (!AppSession::isLogin()) {
      return response()->json([
          'success' => false,
          'message' => $accountHasExpired,
          ], 404);
    }
    $userLogin = AppSession::getLoginData();
    if ($userLogin->role == UserModel::ROLE_MODEL) {
      $searchRole = UserModel::ROLE_MEMBER;
    } else {
      $searchRole = UserModel::ROLE_MODEL;
    }
    $getModel = UserModel::where('username', 'like', '%' . $action['modelname'] . '%')->where('role', '=', $searchRole)->get();
    $html = '';
    $html .= '<table class="table table-condensed" style="border-radius: 4px">';

    if (!empty($getModel)) {
      foreach ($getModel as $key => $value) {
        $html .= '<tr class="insertThis" style="cursor:pointer" modelName = "' . $value->username . '" ><td class="info" style="color:#df6026"><i class="fa fa-user"></i> ' . $value->username . '</td></tr>';
      }
    }

    $html .= '</table>';
    return $html;
  }

  /**
   * Action Created Meet Her
   * @return resource
   * @author LongPham <long.it.stu@gmail.com>
   * */
  public function postMeetHer(Request $get) {

    \App::setLocale(session('lang'));

    $systemError = trans('messages.systemError');
    $modelNotFoundMessageControl = trans('messages.modelNotFoundMessageControl');
    $youhavesentarequestto = trans('messages.youhavesentarequestto');
    $pleasewaitaccept = trans('messages.pleasewaitaccept');
    $requestHasBeenSend = trans('messages.requestHasBeenSend');


    $rules = [
      'country' => 'required',
      'startDate' => 'required|date',
      'endDate' => 'required|date|after:startDate',
      'modelName' => 'required',
      'requestContent' => 'required',
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    $country = $get->country;
    $startDate = $get->startDate;
    $endDate = $get->endDate;
    $modelName = $get->modelName;
    $request = $get->requestContent;
    $userLogin = AppSession::getLoginData();
    $model = UserModel::where('username', '=', $modelName)->first();
    if (empty($model)) {
      return redirect()->back()->with('msgError', $modelNotFoundMessageControl);
    }
    $checkExisting = MeetHerModel::where('himId', '=', $userLogin->id)
        ->where('herId', '=', $model->id)->where('status', '=', MeetHerModel::WAITING)->first();
    if (!empty($checkExisting)) {
      return redirect()->back()->with('msgError', $youhavesentarequestto . $modelName . $pleasewaitaccept);
    }
    $addMeetHer = new MeetHerModel();
    $addMeetHer->himId = $userLogin->id;
    $addMeetHer->herId = $model->id;
    $addMeetHer->startDate = $startDate;
    $addMeetHer->endDate = $endDate;
    $addMeetHer->request = $request;
    $addMeetHer->locationId = $country;
    $addMeetHer->status = MeetHerModel::WAITING;
    if ($addMeetHer->save()) {
      return redirect()->back()->with('msgInfo', $requestHasBeenSend);
    }
    return redirect()->back()->with('msgInfo', $systemError);
  }

  /**
    }
   * Get Offline Tip
   * @return resource
   * @author LongPham <long.it.stu@gmail.com>
   * */
  public function getOfflineTip($username = null) {
    \App::setLocale(session('lang'));
    $model = UserModel::where('username', '=', $username)->first();
    return view('Model::model_profile_sub_offline_tip')->with('model', $model);
  }

  /**
   * Get Offline Tip
   * @return resource
   * @author LongPham <long.it.stu@gmail.com>
   * */
  public function postOfflineTip(Request $get, $username = null) {

    \App::setLocale(session('lang'));


    $modelNotFoundMessageControl = trans('messages.modelNotFoundMessageControl');
    $waitForCompleteFunction = trans('messages.waitForCompleteFunction');


    $rules = [
      'tipmessage' => 'required',
      'tipamount' => 'numeric|min:1',
      'checkAgree' => 'required',
    ];

    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }

    $model = UserModel::where('username', '=', $username)->first();
    if (empty($model)) {
      return redirect()->back()->withInput()->with('msgError', $modelNotFoundMessageControl);
    }

    $postData = $get->only('tipmessage', 'tipamount', 'checkAgree');
    return redirect()->back()->withInput()->with('msgInfo', $waitForCompleteFunction);
  }








public function getTravel(Request $req) {
  
    $filter     = $req->get('filter');
    $maps       = $req->get('maps');
    $fecha      = $req->get('fecha');
    $userData   = AppSession::getLoginData();
    $userid= $userData->id;

    $travel = TravelModel::select("*","travel.id as travelid",DB::raw("DATE_FORMAT(travel.salida,'%d-%m-%Y') as salida, DATE_FORMAT(travel.llegada,'%d-%m-%Y') as llegada"))
     ->join('users as u', 'u.id', '=', 'travel.userid')
     ->where('u.id', $userData->id)
      ->orderby('salida', 'desc')
     ->get();

 return view('Model::model_dashboard_travel', compact('travel','userid'));
    
  }







  /**
   * logout
   */
  public function getLogOut() {

    return AppSession::getLogout();
  }

  //--TODO Move all FeedController function to here.

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    //
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

}
