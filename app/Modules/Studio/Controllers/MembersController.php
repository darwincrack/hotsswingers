<?php

namespace App\Modules\Studio\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\CategoryModel;
use App\Modules\Api\Models\PerformerModel;
use App\Helpers\Session as AppSession;
use App\Modules\Model\Models\PerformerTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Events\AddModelPerformerChatEvent;
use App\Events\AddModelScheduleEvent;
use App\Events\AddEarningSettingEvent;
use App\Events\AddModelPerformerEvent;
use App\Modules\Api\Models\CountryModel;
use DB;
use App\Modules\Api\Models\DocumentModel;

class MembersController extends Controller {

  /**
   * Display a Studio Performers resource.
   * @author LongPham <long.it.stu@gmail.com>
   * @return Response
   */
  public function studioMembers() {
    \App::setLocale(session('lang'));
    $userLogin = AppSession::getLoginData();
    $searchData = \Request::only('q', 'modelOnlineStatus');
    $allMembers = UserModel::select("users.firstName", 'users.lastName', 'users.username', 'users.email','users.id', 'users.avatar', 'users.tokens', 'users.accountStatus', DB::raw('IF(users.gender is null, "Unknow", users.gender) as gender'), DB::raw('IF(p.age > 0, p.age, "Unknow") as modelAge'), DB::raw("(SELECT sum(streamingTime) FROM chatthreads WHERE ownerId=users.id) as totalOnline"), DB::raw('IF(p.country_id > 0, c.name, "Unknow") as countryName'))

            ->join('performer as p', 'p.user_id', '=', 'users.id')
            ->leftJoin('countries as c', 'c.id', '=', 'p.country_id')
      ->where('parentId', '=', $userLogin->id);
    if (!empty($searchData['q'])) {
      $allMembers = $allMembers->where('username', 'like', $searchData['q'] . '%');
    }
    if (!empty($searchData['modelOnlineStatus'])) {
      if ($searchData['modelOnlineStatus'] !== 'all') {
        $allMembers = $allMembers->where('accountStatus', '=', $searchData['modelOnlineStatus']);
      }
    }

    $allMembers = $allMembers->paginate(LIMIT_PER_PAGE);

    return view("Studio::studioMembers")->with('loadModel', $allMembers);
  }

  /**
   * Show the form for creating a new member resource.
   * @return Response
   * @author LongPham <long.it.stu@gmail.com>
   */
  public function studioAddMember() {
    \App::setLocale(session('lang'));
    return view('Studio::studioMembers');
  }

  /**
   * Action the form for creating a new member resource.
   * @return Response
   * @author LongPham <long.it.stu@gmail.com>
   */
  public function studioActionAddMember(Request $get) {
    \App::setLocale(session('lang'));
    $rules = [
      'firstName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      'lastName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      'username' => 'required|min:6|max:32|unique:users',
      'email' => 'required|email|unique:users'
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    $userLogin = AppSession::getLoginData();

    $postData = $get->only('firstName', 'lastName', 'username', 'email');
    $password = str_random(6);
    $model = new UserModel();
    $model->parentId = $userLogin->id;
    $model->username = $postData['username'];
    $model->passwordHash = md5($password);
    $model->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $model->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $model->email = $postData['email'];
    $model->role = UserModel::ROLE_MODEL;
    $model->accountStatus = UserModel::ACCOUNT_WAITING;
    $model->autoApprovePayment = 1;
    if ($model->save()) {

      $sendTo = $model->email;
      $token = \App\Helpers\AppJwt::create(array('user_id' => $model->id, 'username' => $model->username, 'email' => $model->email));
      $sendConfirmMail = Mail::send('email.assign', array('username' => $model->username, 'email' => $model->email, 'studio' => $userLogin->username, 'password' => $password, 'token' => $token, 'assignedBy'=>$userLogin->email), function($message) use($sendTo) {
          $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($sendTo)->subject(trans('messages.modelVerifyAccount').' | '. app('settings')->siteName);
        });
      if ($sendConfirmMail) {
        \Event::fire(new AddModelPerformerChatEvent($model));
        \Event::fire(new AddModelScheduleEvent($model));
        \Event::fire(new AddEarningSettingEvent($model));
        \Event::fire(new AddModelPerformerEvent($model));
        return redirect('studio/members')->with('msgInfo', 'Created user successfully!');
      }
    }
    return back()->withInput()->with('msgError', 'System error. ');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   * @author LongPham <long.it.stu@gmail.com>
   */
  public function studioEditMember($id) {
    \App::setLocale(session('lang'));
    $userLogin = AppSession::getLoginData();
    if (empty($id)) {
      return back()->with('msgError', 'Member not found.');
    }
    if (UserModel::where('id', '=', $id)->where('parentId', '=', $userLogin->id)->count() === 0) {
      return back()->with('msgError', 'Member not found.');
    }
     $categories = CategoryModel::pluck('name', 'id')->all();

    $heightList = UserModel::getHeightList();
     $weightList = UserModel::getWeightList();
    $performer = PerformerModel::where('user_id', '=', $id)->first();
    $model = UserModel::where('id', '=', $id)->where('parentId', '=', $userLogin->id)->first();
    $countries = CountryModel::pluck('name', 'id')->all();
    if (!$performer) {
      $performer = new PerformerModel;
      $performer->user_id = $model->id;
      $performer->sex = $model->gender;
      if (!$performer->save()) {
        return redirect('admin/manager/performers')->with('msgError', 'Performer Setting error!');
      }
    }

    return view('Studio::studioEditMembers')->with('model', $model)->with('categories', $categories)->with('performer', $performer)->with('heightList', $heightList)->with('weightList', $weightList)->with('countries', $countries);

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   * @author LongPham <long.it.stu@gmail.com>
   */
  public function studioActionEditMember(Request $get, $id) {
    \App::setLocale(session('lang'));
    $userLogin = AppSession::getLoginData();
    $rules = [
      'username' => 'Required|Between:3,32|alphaNum|Unique:users,username,' . $id,
      'passwordHash' => 'AlphaNum|Between:6,32',
      'firstName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      'lastName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      'country' => 'Required',
      'gender' => 'Required',
      'age' => 'Required|Integer|Min:18|Max:59',
      'category' => 'required|Exists:categories,id',
      'sexualPreference' => 'Required'
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    if (empty($id)) {
      return back()->with('msgError', 'Member not found.')->withInput();
    }
    $user = UserModel::where('id', '=', $id)->where('parentId', '=', $userLogin->id)->first();
    if (!$user) {
      return back()->with('msgError', 'Member not found.')->withInput();
    }
    $userData = Input::all();

    $user->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $user->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $user->gender = $userData['gender'];
    $user->username = $userData['username'];
//    $user->countryId = $userData['country'];

    if (Input::has('passwordHash') && !empty($userData['passwordHash'])) {
      $user->passwordHash = md5($userData['passwordHash']);
    }
    if ($user->save()) {

      $performer = PerformerModel::where('user_id', '=', $id)->first();
      if (!$performer) {
        $performer = new PerformerModel;
      }

      $performer->sex = $userData['gender'];
      $performer->sexualPreference = $userData['sexualPreference'];

      if (Input::has('ethnicity')) {
        $performer->ethnicity = $userData['ethnicity'];
      }
      if (Input::has('eyes')) {
        $performer->eyes = $userData['eyes'];
      }
      if (Input::has('hair')) {
        $performer->hair = $userData['hair'];
      }
      if (Input::has('height')) {
        $performer->height = $userData['height'];
      }
      if (Input::has('weight')) {
        $performer->weight = $userData['weight'];
      }
      $performer->bust = $userData['bust'];

      $performer->category_id = $userData['category'];
      $performer->country_id = $userData['country'];

      if (Input::has('pubic')) {
        $performer->pubic = $userData['pubic'];
      }

      if (Input::has('age')) {
        $performer->age = $userData['age'];
      }
        $performer->tags = Input::get('tags');
      if ($performer->save()) {
        PerformerTag::updateTags($performer->id, $performer->tags);
        return back()->with('msgInfo', 'Model was successfully updated!');
      }
    }
    return back()->withInput()->with('msgError', 'System error. ');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function studioDeleteMember($id) {
    \App::setLocale(session('lang'));
    $userLogin = AppSession::getLoginData();
    if (empty($id)) {
      return back()->with('msgError', 'Member not found.')->withInput();
    }
    if (UserModel::where('id', '=', $id)->where('parentId', '=', $userLogin->id)->count() === 0) {
      return back()->with('msgError', 'Member not found.')->withInput();
    }
    if (UserModel::destroy($id)) {
      return redirect('studio/members')->with('msgInfo', 'Model was successfully deleted.');
    }
    return back()->with('msgError', ' System error');
  }

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
  public function getMemberDocuments($id) {
    \App::setLocale(session('lang'));
    $document = DocumentModel::where('ownerId', $id)->first();
    $model = UserModel::find($id);
    return view('Studio::member-documents')->with('document', $document)->with('model', $model);
  }
  public function postMemberDocuments($id){
    \App::setLocale(session('lang'));
    $validator = Validator::make(Input::all(), [
      'idImage' => 'Max:2000|Mimes:jpg,jpeg,png',
      'idImage2' => 'Max:2000|Mimes:jpg,jpeg,png',
      'faceId' => 'Max:2000|Mimes:jpg,jpeg,png',
      'releaseForm' => 'Max:2000|Mimes:doc,docx,pdf'
    ]);
    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    $identityDocument = DocumentModel::where('ownerId', $id)->first();
    $model = UserModel::find($id);
    if(!$identityDocument){
      $identityDocument = new DocumentModel;
    }

    $identityDocument->ownerId = $id;
    $destinationPath = 'uploads/models/identity/';
    if (Input::file('idImage')) {
      if (!Input::file('idImage')->isValid()) {
        return Back()->with('msgInfo', 'uploaded file is not valid');
      }
      $image = Input::file('idImage');
      $filename = $model->username . '.' . $image->getClientOriginalExtension();
      $idPath = $destinationPath . 'id-images/' . $filename;
      Input::file('idImage')->move($destinationPath . 'id-images', $filename);
      $identityDocument->idImage = $idPath;
    }
        if (Input::file('idImage2')) {
      if (!Input::file('idImage2')->isValid()) {
        return Back()->with('msgInfo', 'uploaded file is not valid');
      }
      $image = Input::file('idImage2');
      $filename = $model->username . '.' . $image->getClientOriginalExtension();
      $idPath = $destinationPath . 'id-images2/' . $filename;
      Input::file('idImage2')->move($destinationPath . 'id-images2', $filename);
      $identityDocument->idImage = $idPath;
    }
    if (Input::file('faceId')) {
      if (!Input::file('faceId')->isValid()) {
        return Back()->with('msgInfo', 'uploaded file is not valid');
      }
      $image = Input::file('faceId');
      $filename = $model->username . '.' . $image->getClientOriginalExtension();
      $faceId = $destinationPath . 'face-ids/' . $filename;
      Input::file('faceId')->move($destinationPath . 'face-ids', $filename);
      $identityDocument->faceId = $faceId;
    }
    if (Input::file('releaseForm')) {
      if (!Input::file('releaseForm')->isValid()) {
        return Back()->with('msgInfo', 'uploaded file is not valid');
      }
      $image = Input::file('releaseForm');
      $filename = $model->username . '.' . $image->getClientOriginalExtension();
      $releaseForm = $destinationPath . 'release-forms/' . $filename;
      Input::file('releaseForm')->move($destinationPath . 'release-forms', $filename);
      $identityDocument->releaseForm = $releaseForm;
    }
    if($identityDocument->save()) {
      return redirect('studio/members/documents/'.$id)->with('msgInfo', 'Uploaded successfully!');
    }else {
      return Back()->withInput()->with('msgError', 'System error.');
    }
  }

  public function getMemberPayeeInfo($id) {
    \App::setLocale(session('lang'));
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($id);
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

    return view('Studio::memberPayeeInfo')->with('model', $model)->with('bankTransferOptions', $bankTransferOptions);
  }

  public function postMemberPayeeInfo($id){
    \App::setLocale(session('lang'));
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
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
    $model = UserModel::find($id);
    $model->bankTransferOptions = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }

  public function getMemberDirectDeposity($id){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($id);
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

    return view('Studio::memberDirectDeposit')->with('model', $model)->with('directDeposit', $directDeposit);
  }
  public function postMemberDirectDeposity($id){
    \App::setLocale(session('lang'));
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
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
    $model = UserModel::find($id);
    $model->directDeposit = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }
  public function getMemberPaxum($id){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($id);
    $paxum = (object)[
      'paxumName' => '',
      'paxumEmail' => '',
      'paxumAdditionalInformation' => ''
    ];
    if($model->paxum){
      $paxum = json_decode($model->paxum);
    }

    return view('Studio::memberPaxum')
            ->with('model', $model)
            ->with('paxum', $paxum);
  }
  public function postMemberPaxum($id){
    \App::setLocale(session('lang'));
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
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
    $model = UserModel::find($id);
    $model->paxum = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }
  public function getMemberBitpay($id){
    \App::setLocale(session('lang'));
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($id);
    $bitpay = (object)[
      'bitpayName' => '',
      'bitpayEmail' => '',
      'bitpayAdditionalInformation' => ''
    ];
    if($model->bitpay){
      $bitpay = json_decode($model->bitpay);
    }

    return view('Studio::memberBitpay')
            ->with('model', $model)
            ->with('bitpay', $bitpay);
  }
  public function postMemberBitpay($id){
    \App::setLocale(session('lang'));
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
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
    $model = UserModel::find($id);
    $model->bitpay = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }
}
