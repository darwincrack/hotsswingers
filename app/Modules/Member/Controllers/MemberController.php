<?php

namespace App\Modules\Member\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\ZoneModel;
use App\Modules\Api\Models\FollowingModel;
use App\Modules\Api\Models\FavoriteModel;
use App\Modules\Api\Models\LikeModel;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\PaymentPackageModel;
use App\Modules\Api\Models\PaymentSettingModel;
use App\Modules\Api\Models\NotifiSettingModel;
use App\Modules\Api\Models\PaymentsModel;
use App\Modules\Api\Models\CountryModel;
use App\Modules\Api\Models\AttachmentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use App\Helpers\Image as AppImage;
use \Illuminate\Support\Facades\Mail;
use DB;
use Carbon\Carbon;
use App\Events\ConvertMemberProfile;

class MemberController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index(Request $req) {
    $userData = [];

    if (\Session::has('UserLogin')) {
      $userData = json_decode(\Session::get('UserLogin'));
    }
    //check if room exit return true else false;
    $room = new RoomController();
    \App::setLocale(session('lang'));
    return view("Member::index", [
      'userData' => $userData
    ]);
  }

  /**
   * Display a member profile.
   *
   * @return Response
   */
  public function getMemberProfile() {
    $userData = AppSession::getLoginData();
    $following = AppHelper::getFollowing();
    \App::setLocale(session('lang'));
    return view('Member::member_profile_sub_wall')->with('followId', $userData->id)->with('ownerId', $userData->id);
  }

  /**
   * Action Memmber follow model.
   *
   * @return Response
   */
  public function postFollow(Request $get) {

    \App::setLocale(session('lang'));

    $disFollowModelMemberControl = trans('messages.disFollowModelMemberControl');
    $followModelMemberControl = trans('messages.followModelMemberControl');
    $requestNotFoundMemberLogin = trans('messages.requestNotFoundMemberLogin');
    $youaddfollowtoyourself = trans('messages.youaddfollowtoyourself');

    if (\Request::ajax()) {
      if (AppSession::isLogin()) {

        $userLogin = AppSession::getLoginData();
        $type = $get->type;
        $item_id = $get->item;
        if ($userLogin->id != $item_id) {
          $model = UserModel::find($item_id);
          if (!empty($model)) {
            $follwing = FollowingModel::where('owner_id', '=', $item_id)->where('follower', '=', $userLogin->id)->first();
            if (!empty($follwing)) {
              if ($follwing->status === FollowingModel::FOLLOW) {
                $updateExisting = FollowingModel::find($follwing->id);
                $updateExisting->status = FollowingModel::DIS_FOLLOW;
                $updateExisting->save();
                return response()->json([
                    'success' => true,
                    'disfollow' => true,
                    'message' => $disFollowModelMemberControl
                    ], 200);
              } else {
                $updateExisting = FollowingModel::find($follwing->id);
                $updateExisting->status = FollowingModel::FOLLOW;
                $updateExisting->save();
                return response()->json([
                    'success' => true,
                    'disfollow' => false,
                    'message' => $followModelMemberControl
                    ], 200);
              }
            } else {
              $newFollow = new FollowingModel();
              $newFollow->type = $userLogin->role;
              $newFollow->owner_id = $item_id;
              $newFollow->follower = $userLogin->id;
              $newFollow->status = FollowingModel::FOLLOW;
              if ($newFollow->save()) {
                return response()->json([
                    'success' => true,
                    'disfollow' => false,
                    'message' => $followModelMemberControl
                    ], 200);
              }
            }
          } else {
            return response()->json([
                'success' => false,
                'disfollow' => false,
                'message' => $requestNotFoundMemberLogin
                ], 200);
          }
        } else {
          return response()->json([
              'success' => false,
              'disfollow' => false,
              'message' => $youaddfollowtoyourself
              ], 200);
        }
      }
    } else {
      return redirect('/')->with('msgError', $requestNotFoundMemberLogin);
    }
  }

  /**
   * Action Memmber like model.
   *
   * @return Response
   */
  public function postLike(Request $get) {

    \App::setLocale(session('lang'));

    $disLikeModelMemberControl = trans('messages.disLikeModelMemberControl');
    $likeModelMemberControl = trans('messages.likeModelMemberControl');
    $requestNotFoundMemberLogin = trans('messages.requestNotFoundMemberLogin');
    $youaddfollowtoyourself = trans('messages.youaddfollowtoyourself');


    if (\Request::ajax()) {
      $userLogin = AppSession::getLoginData();
      $type = $get->type;
      $item_id = $get->item;
      if ($userLogin->id != $item_id) {
        $model = UserModel::find($item_id);
        if (!empty($model)) {
          $liked = LikeModel::where('item_id', '=', $item_id)->where('owner_id', '=', $userLogin->id)->where('item', '=', LikeModel::TYPE_MODEL)->first();
          if (!empty($liked)) {
            if ($liked->status === LikeModel::LIKE) {
              $updateLike = LikeModel::find($liked->id);
              $updateLike->status = LikeModel::DISLIKE;
              $updateLike->save();
              return response()->json([
                  'success' => true,
                  'dislike' => true,
                  'message' => $disLikeModelMemberControl
                  ], 200);
            } else {
              $updateLike = LikeModel::find($liked->id);
              $updateLike->status = LikeModel::LIKE;
              $updateLike->save();
              return response()->json([
                  'success' => true,
                  'dislike' => false,
                  'message' => $likeModelMemberControl
                  ], 200);
            }
          } else {
            $newLike = new LikeModel();
            $newLike->item = LikeModel::TYPE_MODEL;
            $newLike->item_id = $item_id;
            $newLike->owner_id = $userLogin->id;
            $newLike->status = LikeModel::LIKE;
            if ($newLike->save()) {
              return response()->json([
                  'success' => true,
                  'dislike' => false,
                  'message' => $likeModelMemberControl
                  ], 200);
            }
          }
        } else {
          return response()->json([
              'success' => false,
              'dislike' => false,
              'message' => $requestNotFoundMemberLogin
              ], 200);
        }
      } else {
        return response()->json([
            'success' => false,
            'dislike' => false,
            'message' => $youaddfollowtoyourself
            ], 200);
      }
    } else {
      return redirect('/')->with('msgError', $requestNotFoundMemberLogin);
    }
  }

  /**
    TODO: Member Dashboard profile
   * */
  public function getMyProfile() {
    $userLogin = AppSession::getLoginData();
    $member = UserModel::find($userLogin->id);
    $countries = CountryModel::orderBy('name')->lists('name', 'id');
    \App::setLocale(session('lang'));
    return view('Member::member_profile_sub_account')->with('getMember', $member)->with('countries',$countries);
  }

  /**
    TODO: Member Update Profile
   * */
  public function postUpdateProfile(Request $get) {

    \App::setLocale(session('lang'));

    $profileUpdateMemberControl = trans('messages.profileUpdateMemberControl');
    $errorProfileUpdateMemberControl = trans('messages.errorProfileUpdateMemberControl');

    $userLogin = AppSession::getLoginData();
    $rules = [
      'height' => 'numeric',
      'email' => 'email',
      'birthdate' => 'Required|date|before:18 years ago|after:100 years ago',
      'state' => 'max:100',
      'city' => 'max:100',
      'avatar' => 'mimes:jpeg,bmp,png,gif',
      'ethnicity' => 'max:100',
      'appearance' => 'max:100',
      'aboutMe' => 'max:400'
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    $bio = $get->aboutMe;
    $email = $get->email;
    $birthdate = $get->birthdate;
    $location_id = $get->country;
    $file = $get->file('avatar');
    $userMetaPost = array(
      'visible' => $get->visible,
      'state' => $get->state,
      'city' => $get->city,
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
    $updateProfile = UserModel::find($userLogin->id);
    $updateProfile->userMeta = serialize($userMetaPost);
    $updateProfile->bio = $bio;
    $updateProfile->email = $email;
    $updateProfile->birthdate = $birthdate;
    $updateProfile->location_id = $location_id;
    if (!empty($file)) {
      $extension = $file->getClientOriginalExtension();
      $notAllowed = array("exe", "php", "asp", "pl", "bat", "js", "jsp", "sh", "doc", "docx", "xls", "xlsx");
      $destinationPath = $_SERVER['DOCUMENT_ROOT'] . PATH_IMAGE . "upload/member/";
      $filename = "avatar_member_" . $userLogin->id . "." . $extension;
      $fileNameLarge = "avatar_member_large_" . $userLogin->id . "." . $extension;
      $fileNameMedium = "avatar_member_medium_" . $userLogin->id . "." . $extension;
      $fileNameSmall = "avatar_member_small_" . $userLogin->id . "." . $extension;
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


      AppSession::setAge($birthdate);
      AppSession::setAvatar($updateProfile->smallAvatar);
      return redirect('members/profile')->with('msgInfo', $profileUpdateMemberControl);
    } else {
      return redirect('members/profile')->with('msgError', $errorProfileUpdateMemberControl);
    }
  }

  /**
    TODO : Get Member Favorites
   * */
  public function getMemberFollowing() {
    $userLogin = AppSession::getLoginData();
    $memberFollowing = FollowingModel::where('follower', '=', $userLogin->id)->where('status', '=', FollowingModel::FOLLOW)->paginate(LIMIT_PER_PAGE);
    \App::setLocale(session('lang'));
    return view('Member::member_profile_sub_following')->with('following', $memberFollowing);
  }

  /**
    TODO : Get Member Favorites
   * */
  public function getFavorites() {
    $userLogin = AppSession::getLoginData();

    $favorites = FavoriteModel::select('favorites.id', 'u.username', 'u.id as ownerId', 'u.avatar', 'u.smallAvatar', 'u.gender', 'p.age', 'c.name as countryName')
      ->join('users as u', 'u.id', '=', 'favorites.favoriteId')
      ->join('performer as p', 'p.user_id', '=', 'u.id')
      ->leftJoin('countries as c', 'c.id', '=', 'p.country_id')
      ->where('favorites.ownerId', $userLogin->id)
      ->where('favorites.status', '=', FavoriteModel::LIKE)
      ->where('u.accountStatus', UserModel::ACCOUNT_ACTIVE)
      ->paginate(LIMIT_PER_PAGE);

    return view('Member::member_profile_sub_favorites')->with('favorites', $favorites);
  }

  /**
    TODO: Get Member Settings
   * */
  public function getMemberSettings() {

    \App::setLocale(session('lang'));

    $requestNotFoundMemberLogin = trans('messages.requestNotFoundMemberLogin');

    $action = \Request::all();
    if (isset($action['action'])) {
      switch ($action['action']) {
        case 'other-actions':
          return $this->getOtherActionSettings($action['action']);
          break;
        case 'notification':
          return $this->getNotificationSettings($action['action']);
          break;
        case 'change-password':
          return $this->getChangePassword($action['action']);
          break;
        case 'suspend-account':
          return $this->getSuspendAccount($action['action']);
          break;
        default:
          return redirect('members/account-settings')->with('msgError', $requestNotFoundMemberLogin);
          break;
      }
    } else {
      $userLogin = AppSession::getLoginData();
      $member = UserModel::find($userLogin->id);

      $countries = CountryModel::orderBy('name')->lists('name', 'id');

      return view('Member::member_profile_sub_setting')->with('getMember', $member)->with('countries', $countries);
    }
  }

  /**
    TODO: Post Update  Settings
   * */
  public function postMemberSettings(Request $req) {

    \App::setLocale(session('lang'));

    $profileUpdateMemberControl = trans('messages.profileUpdateMemberControl');
    $errorProfileUpdateMemberControl = trans('messages.errorProfileUpdateMemberControl');
    $youraccountnotfound = trans('messages.youraccountnotfound');
    $changePassSucMemberControl = trans('messages.changePassSucMemberControl');
    $systemError = trans('messages.systemError');

    $userLogin = AppSession::getLoginData();

    if (!$req->has('action')) {

      $rules = [
        'username'=>"required|alphaNum|Max:40|unique:users,username,{$userLogin->id}",
        'firstName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
        'lastName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
        'email' => "Email|Required|Between:3,40|Unique:users,email,{$userLogin->id}",
        'birthdate' => 'Required|date|before:18 years ago|after:100 years ago',
        'location' => 'Required|country',
        'stateName' => ['max:32', 'Regex:/^[A-Za-z0-9(\s)]+$/'],
        'cityName' => ['max:32', 'Regex:/^[A-Za-z0-9(\s)]+$/'],
        'sex' => 'Required',
        'avatar' => 'image|mimes:jpg,png,jpeg',
      ];
      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
      }

      $userMetaPost = array(
        'visible' => Input::get('visible')
      );

      $updateProfile = UserModel::find($userLogin->id);
      $updateProfile->userMeta = serialize($userMetaPost);
      $updateProfile->username = Input::get('username');
      $updateProfile->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
      $updateProfile->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
      $updateProfile->email = Input::get('email');
      $updateProfile->birthdate = \Date(Input::get('birthdate'));
      $updateProfile->location_id = Input::get('location');
      $updateProfile->stateName = preg_replace('/\s+/', ' ',  Input::get('stateName', null));
      $updateProfile->cityName = preg_replace('/\s+/', ' ',  Input::get('cityName', null));

      $updateProfile->mobilePhone = (Input::has('mobilePhone')) ? Input::get('mobilePhone') : '';
      $updateProfile->gender = Input::get('sex');
      $file = Input::file('avatar');

      if ($file) {

        $destinationPath = 'uploads/members/' . Carbon::now()->format('Y/m/d'); // upload path
        $extension = Input::file('avatar')->getClientOriginalExtension(); // getting image extension
        //$fileName = MD5(time()) . '.' . $extension; // renameing image
        $fileName = 'original-' . substr(MD5(time()), 0, 10) . '-' . str_replace(' ', '-', $file->getClientOriginalName());
        $size = Input::file('avatar')->getSize();
        $mimeType = Input::file('avatar')->getMimeType();


        Input::file('avatar')->move($destinationPath, $fileName); // uploading file to given path
// sending back with message
//store attachment
        $path = $destinationPath . '/' . $fileName;

        $avatar = \Event::fire(new ConvertMemberProfile($updateProfile, $path));

        if(is_array($avatar)){
            if(AppHelper::is_serialized($avatar[0])){
                $updateProfile->avatar = $avatar[0];
                $imageMeta = unserialize($avatar[0]);
                if(isset($imageMeta[IMAGE_SMALL])){
                    $updateProfile->smallAvatar = $imageMeta[IMAGE_SMALL];
                }
            }

        }

      }
      if ($updateProfile->save()) {
        AppSession::setAvatar($updateProfile->smallAvatar);
        AppSession::setAge($updateProfile->birthdate);
        AppSession::setName($updateProfile);
        return Back()->with('msgInfo', $profileUpdateMemberControl);
      } else {
        return Back()->with('msgError', $errorProfileUpdateMemberControl);
      }
    } else if ($req->get('action') == 'change-password') {
      $validator = Validator::make(Input::only('oldPassword', 'newPassword', 'newPassword_confirmation'), [
          'oldPassword' => 'Required|hashmatch:passwordHash',
          'newPassword' => 'Required|AlphaNum|Between:6,32|Confirmed',
          'newPassword_confirmation' => 'Required|AlphaNum|Between:6,32'
      ]);
      if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
      }

      $profile = UserModel::find($userLogin->id);
      if (!$profile) {
        AppSession::getLogout();
        return Redirect::to('login')->with('msgError', $youraccountnotfound);
      }

      $profile->passwordHash = md5(Input::get('newPassword'));

      if ($profile->save()) {
        return Back()->with('msgInfo', $changePassSucMemberControl);
      }
      return Back()->with('msgError', $systemError);
    }
  }

  /**
   * change timezone settings
   *
   */
  public function getOtherSettings() {
    \App::setLocale(session('lang'));
    $getUserLogin = AppSession::getLoginData();
    $updateSettings = UserModel::find($getUserLogin->id);
    $timezone = null;
    if (AppHelper::is_serialized($updateSettings->userSettings)) {
      $userOtherAction = unserialize($updateSettings->userSettings);
      if(is_array($userOtherAction) && array_key_exists('timezone', $userOtherAction)){
          $timezone = $userOtherAction['timezone'];
      }
    }
    $zones = ZoneModel::orderBy('zone_name')->lists('zone_name', 'zone_name')->all();

    return view('Member::member_profile_other_settings', compact('zones', 'timezone'));
  }

  /**
   * save user timezone
   */
  public function postOtherSettings() {


    \App::setLocale(session('lang'));

    $youraccountnotfound = trans('messages.youraccountnotfound');
    $saveSettingSucMemberControl = trans('messages.saveSettingSucMemberControl');
    $systemError = trans('messages.systemError');

    $validator = Validator::make(Input::all(), [
        'timezone' => 'Required|Exists:zone,zone_name'
    ]);
    if ($validator->fails()) {
      return Back()->withInput()->withErrors($validator);
    }
    $data = serialize(array('timezone' => Input::get('timezone')));
    $userData = AppSession::getLoginData();
    $setting = UserModel::find($userData->id);
    if (!$setting) {
      return Redirect('/')->with('msgError', $youraccountnotfound);
    }
    $setting->usersettings = $data;
    if ($setting->save()) {
      return redirect()->back()->with('msgInfo', $saveSettingSucMemberControl);
    } else {
      return redirect()->back()->with('msgError', $systemError);
    }
  }

  /**
    TODO: Get OtherAction  Settings
   * */
  public function getOtherActionSettings($action) {
    \App::setLocale(session('lang'));
    $getUserLogin = AppSession::getLoginData();
    $updateSettings = UserModel::find($getUserLogin->id);
    if ($updateSettings->usersettings != null and AppHelper::is_serialized($updateSettings->usersettings)) {
      $userOtherAction = unserialize($updateSettings->usersettings);
    } else {
      $userOtherAction = array(
        'timezone' => '',
        'anonymous' => '',
        'notifications' => ''
      );
    }
    return view('Member::member_profile_sub_setting')->with('action', $action)->with('otherAction', $userOtherAction);
  }

  /**
    TODO: Get Notification  Settings
   * */
  public function getNotificationSettings($action) {
    \App::setLocale(session('lang'));
    $getUserLogin = AppSession::getLoginData();
    $checkNotifiSettings = NotifiSettingModel::where('userId', '=', $getUserLogin->id)->first();
    if (!empty($checkNotifiSettings)) {
      return view('Member::member_profile_sub_setting')->with('action', $action)->with('notification', $checkNotifiSettings);
    } else {
      return view('Member::member_profile_sub_setting')->with('action', $action);
    }
  }

  /**
    TODO: Get ChangePassword  Settings
   * */
  public function getChangePassword($action) {
    \App::setLocale(session('lang'));
    return view('Member::member_profile_sub_setting')->with('action', $action);
  }

  /**
    TODO: Get SuspendAccount  Settings
   * */
  public function getSuspendAccount($action) {
    \App::setLocale(session('lang'));
    return view('Member::member_profile_sub_setting')->with('action', $action);
  }

  /**
    TODO: Post Update OtherAction
   * */
  public function postOtherActionSettings($postData) {


    \App::setLocale(session('lang'));

    $updateotheractionsuccessfull = trans('messages.updateotheractionsuccessfull');
    $systemError = trans('messages.systemError');

    $getUserLogin = AppSession::getLoginData();
    $updateSettings = UserModel::find($getUserLogin->id);
    $updateSettings->usersettings = serialize($postData);
    if ($updateSettings->save()) {
      return redirect()->back()->with('msgInfo', $updateotheractionsuccessfull);
    } else {
      return redirect()->back()->with('msgError', $systemError);
    }
  }

  /**
    TODO: Post Update NotificationSettings
   * */
  public function postNotificationSettings($postData) {
    
    \App::setLocale(session('lang'));

    $messageEmailChangePassMemberControl = trans('messages.messageEmailChangePassMemberControl');
    $systemError = trans('messages.systemError');
    $updateNotificationSucMemberControl = trans('messages.updateNotificationSucMemberControl');


    $getUserLogin = AppSession::getLoginData();
    $checkNotifiSettings = NotifiSettingModel::where('userId', '=', $getUserLogin->id)->first();
    // Post Type Private
    $makePrivate = array(
      'makePrivateNews' => array(
        'onSite' => isset($postData['makePrivateNews']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['makePrivateNews']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['makePrivateNews']['bySMS']) ? 1 : 0,
      ),
      'makePrivateTokenPurchased' => array(
        'onSite' => isset($postData['makePrivateTokenPurchased']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['makePrivateTokenPurchased']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['makePrivateTokenPurchased']['bySMS']) ? 1 : 0,
      )
    );
    // Post Type Performers
    $performers = array(
      'performersFavorite' => array(
        'onSite' => isset($postData['performersFavorite']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['performersFavorite']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['performersFavorite']['bySMS']) ? 1 : 0,
      )
    );
    // Post Type Tickets
    $tickets = array(
      'ticketCreated' => array(
        'onSite' => isset($postData['ticketCreated']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['ticketCreated']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['ticketCreated']['bySMS']) ? 1 : 0,
      ),
      'ticketReplyAdded' => array(
        'onSite' => isset($postData['ticketReplyAdded']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['ticketReplyAdded']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['ticketReplyAdded']['bySMS']) ? 1 : 0,
      ),
      'ticketUpdate' => array(
        'onSite' => isset($postData['ticketUpdate']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['ticketUpdate']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['ticketUpdate']['bySMS']) ? 1 : 0,
      )
    );
    // Post Type Profile
    $profile = array(
      'profilePerformerViews' => array(
        'onSite' => isset($postData['profilePerformerViews']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['profilePerformerViews']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['profilePerformerViews']['bySMS']) ? 1 : 0,
      ),
      'profileAddsfavorite' => array(
        'onSite' => isset($postData['profileAddsfavorite']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['profileAddsfavorite']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['profileAddsfavorite']['bySMS']) ? 1 : 0,
      ),
    );
    // Post Type Account
    $account = array(
      'accountNewPassword' => array(
        'onSite' => isset($postData['accountNewPassword']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['accountNewPassword']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['accountNewPassword']['bySMS']) ? 1 : 0,
      ),
      'accountNotificationsUpdated' => array(
        'onSite' => isset($postData['accountNotificationsUpdated']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['accountNotificationsUpdated']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['accountNotificationsUpdated']['bySMS']) ? 1 : 0,
      ),
      'accountDisabled' => array(
        'onSite' => isset($postData['accountDisabled']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['accountDisabled']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['accountDisabled']['bySMS']) ? 1 : 0,
      ),
      'accountUpgraded' => array(
        'onSite' => isset($postData['accountUpgraded']['onSite']) ? 1 : 0,
        'byEmail' => isset($postData['accountUpgraded']['byEmail']) ? 1 : 0,
        'bySMS' => isset($postData['accountUpgraded']['bySMS']) ? 1 : 0,
      ),
    );
    if (!empty($checkNotifiSettings)) {
      $updateNotifiSettings = NotifiSettingModel::find($checkNotifiSettings->id);
      $updateNotifiSettings->makePrivate = serialize($makePrivate);
      $updateNotifiSettings->performers = serialize($performers);
      $updateNotifiSettings->tickets = serialize($tickets);
      $updateNotifiSettings->profile = serialize($profile);
      $updateNotifiSettings->account = serialize($account);
      if ($updateNotifiSettings->save()) {
        return redirect()->back()->with('msgInfo', $messageEmailChangePassMemberControl);
      } else {
        return redirect()->back()->with('msgError', $systemError);
      }
    } else {
      $newSettings = new NotifiSettingModel();
      $newSettings->makePrivate = serialize($makePrivate);
      $newSettings->performers = serialize($performers);
      $newSettings->tickets = serialize($tickets);
      $newSettings->profile = serialize($profile);
      $newSettings->account = serialize($account);
      $newSettings->userId = $getUserLogin->id;
      if ($newSettings->save()) {
        return redirect()->back()->with('msgInfo', $updateNotificationSucMemberControl);
      } else {
        return redirect()->back()->with('msgError', $systemError);
      }
    }
  }

  /**
    TODO: function ChangePassword
   * */
  public function postChangePassword($postData) {

    \App::setLocale(session('lang'));

    $messageEmailChangePassMemberControl = trans('messages.messageEmailChangePassMemberControl');
    $oldPassNotMatchMemberControl = trans('messages.oldPassNotMatchMemberControl')."!";

    $getUserLogin = AppSession::getLoginData();
    $oldPassword = $postData['oldPassword'];
    $newPassword = $postData['newPassword'];
    $newPasswordRetype = $postData['newPasswordRetype'];
    $checkPass = UserModel::find($getUserLogin->id);
    if ($checkPass->passwordHash === md5($oldPassword)) {
      $checkPass->passwordHash = md5($newPassword);
      if ($checkPass->save()) {
        $sendChangePass = Mail::send('email.change-password', array('username' => $checkPass->username, 'password' => $newPassword), function($message) use($checkPass) {
            $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($checkPass->email)->subject('Change Password | ' . app('settings')->siteName);
          });
        if ($sendChangePass) {
          AppSession::getLogout();
          return back()->with('msgInfo', $messageEmailChangePassMemberControl);
        }
      } else {
        return redirect()->back()->with('msgError', $systemError);
      }
    } else {
      return back()->with('msgError', $oldPassNotMatchMemberControl);
    }
  }

  /**
   * @action post suspend account
   * @author : Long Pham <long.it.stu@gmail.com>
   * */
  public function postSuspendAccount($postData) {

    \App::setLocale(session('lang'));

    $requestHasBeenSend = trans('messages.requestHasBeenSend');
    $oldPassNotMatchMemberControl = trans('messages.oldPassNotMatchMemberControl')."!";
    $systemError = trans('messages.systemError')."!";
    $yourPassNotMatchMemberControl = trans('messages.yourPassNotMatchMemberControl');

    $userLogin = AppSession::getLoginData();
    $reason = $postData['reason'];
    $password = $postData['password'];
    $checkPasswordExisting = UserModel::find($userLogin->id);
    if (!empty($checkPasswordExisting)) {
      if ($checkPasswordExisting->passwordHash === md5($password)) {
        $checkPasswordExisting->accountStatus = UserModel::ACCOUNT_SUSPEND;
        $checkPasswordExisting->suspendReason = $reason;
        if ($checkPasswordExisting->save()) {
          return redirect()->back()->with('msgInfo', $requestHasBeenSend);
        } else {
          return redirect()->back()->with('msgError', $systemError);
        }
      } else {
        return redirect()->back()->with('msgError', $yourPassNotMatchMemberControl);
      }
    } else {
      AppSession::getLogout();
    }
  }

  /**
   * @return payment candies
   * @author : Long Pham <long.it.stu@gmail.com>
   * */
  public function getMemberCandies() {
    \App::setLocale(session('lang'));
    $userLogin = AppSession::getLoginData();
    $member = UserModel::find($userLogin->id);
    $paymentSetting = PaymentSettingModel::first();
    $packages = PaymentPackageModel::orderBy('price')->get();
    return view('Member::member_profile_sub_candies')->with('getMember', $member)->with('paymentSetting', $paymentSetting)->with('packages', $packages);
  }




//DArwinDarwin


    public function getEnlacePayment($Item) {
    \App::setLocale(session('lang'));
    $userLogin = AppSession::getLoginData();
    $member = UserModel::find($userLogin->id);
    $paymentSetting = PaymentSettingModel::first();


    $packages = PaymentPackageModel::where('id', $Item)->first();


   return MemberController::GenerarTokenPago($packages,$paymentSetting);


  }


 public static function GenerarTokenPago($packages,$paymentSetting){



   $userLogin = AppSession::getLoginData();

  $api_key =  base64_encode($paymentSetting->api_key);


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $paymentSetting->url_entorno."/payment");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, "{
  \"signature\": \"".$paymentSetting->signature."\",
  \"amount\": ".str_replace(".","",$packages->price).",
  \"operative\": \"AUTHORIZATION\",
  \"additional\": \"".$userLogin->username."\",
  \"service\": \"".$paymentSetting->service."\",
  \"secure\": true,
  \"url_post\": \"".url("/paymentresult")."\",
  \"url_ok\": \"".url("/paymentsucess")."\",
  \"url_ko\": \"".url("/paymenterror")."\", 
  \"template_uuid\": \"".$paymentSetting->formName."\",
   \"description\": \" ". trim($packages->description)."  \",
  \"extra_data\": {
    \"profile\": {
      \"first_name\": \" ". $userLogin->firstName." \",
      \"last_name\": \"". $userLogin->lastName."\",
      \"email\": \"". $userLogin->email."\",

      \"document_identification_number\": \"". $userLogin->id."\"
    },

    \"payment\": {
      \"installments\": 1
    },
    \"cof\": {
      \"reason\": \"INSTALLMENTS\"
    }
  },
  \"save_card\": false,
  \"reference\": \"paquete de ".$packages->tokens." Tokens | implik-2.com\"
}");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Basic {$api_key}"
));

$response = curl_exec($ch);
curl_close($ch);


 $datos = json_decode( $response);


 if( $datos==""){
      $error = "no hubo respuesta del metodo de pago";
      return redirect('members/funds-tokens')->with('msgError', $error);
 }

if($datos->code !='200'){

   \App::setLocale(session('lang'));

    $error = "code: ".$datos->code. "<br> error: <br>".$datos->message."<br>". $datos->details;
    
    return redirect('members/funds-tokens')->with('msgError', $error);

}

return MemberController::GenerarEnlacePago($datos,$paymentSetting);

}



 public static function GenerarEnlacePago($datos,$paymentSetting){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $paymentSetting->url_entorno."/payment/process/".$datos->order->token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: text/html"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}



 public function getPaymentError() {

     \App::setLocale(session('lang'));
        return view('Member::member_payments_error');

 }


   public function getPaymentSuccess() {

    \App::setLocale(session('lang'));

    $thankYouPamentMemberControl = trans('messages.thankYouPamentMemberControl');
    $unableOpenFileMemberControl = trans('messages.unableOpenFileMemberControl');

    return redirect('members/funds-tokens')->with('msgInfo', $thankYouPamentMemberControl);

  }


     public function getPaymentResult() {

    \App::setLocale(session('lang'));

    $for = trans('messages.for');
    $unableUpFileMemberControl = trans('messages.unableUpFileMemberControl');

    $data = file_get_contents('php://input');

    $jsonData = json_decode($data);


    if ($jsonData) {
          $price = 0;
          $price = $jsonData->order->amount/100;

          $userId = '';
          $userId = $jsonData->extra_data->profile->document_identification_number;

          //check package
          $package = PaymentPackageModel::where('price', $price)->first();
          $newPayment = new PaymentsModel();
          if(!$package){
            $newPayment->price = 0;
          }else{
            $newPayment->price = $package->tokens;
            $newPayment->packageId = $package->id;

          }


      if($jsonData->order->status=='SUCCESS'){
        $newPayment->status = PaymentsModel::STATUS_APPROVED;
        if($package){
        $newPayment->description = $price .' '.$for.' '.$package->tokens . 'tokens';
        }else{
          $newPayment->description = $price . ' '.$for.' 0 tokens';
        }
      }else{
        $newPayment->status = PaymentsModel::STATUS_DENIAL;
        $newPayment->description = $jsonData->order->transactions[0]->error;
      }


      $newPayment->memberId = $userId;
      $newPayment->type = PaymentsModel::CANDY_PAYMENT;

      $newPayment->uuid = $jsonData->order->uuid;
      $newPayment->parameters = $data;


        if ($newPayment->save()) {
        
          if($jsonData->order->status=='SUCCESS'){

              $updateMemberCandy = UserModel::find($userId);
              $updateMemberCandy->increment('tokens', $package->tokens); // = (int) (AppHelper::getMemberinfo($jsonData->userid)->tokens) + (int) ($jsonData->candies);
              if (!$updateMemberCandy->save()) {
                $newPayment->status = PaymentsModel::STATUS_ERROR;
                $newPayment->save();
                //TODO send success email
    //            AppHelper::sendPaymentEmail($updateMemberCandy->email, $jsonData);
              }else{

              }

          }
          //TODO process send mail here;

       
      } else {
        $newPayment->status = PaymentsModel::STATUS_ERROR;
        $newPayment->save();
        //TODO send error increment tokens here

      }



    }else{
      $file = md5(time()).'.txt';
      $myfile = fopen(public_path() . "/uploads/".$file, "w") or die($unableUpFileMemberControl);
      fwrite($myfile, $jsonData);
      fclose($myfile);
    }

    


  }




//aqui se va a guardar la respuesta del metodo de pago.
  /**
   * insert data from ccbill response
   */
  public function postPaymentAccessBackData() {


    \App::setLocale(session('lang'));

    $for = trans('messages.for');
    $unableUpFileMemberControl = trans('messages.unableUpFileMemberControl');


    $paymentData = json_encode($_REQUEST);
    $jsonData = json_decode($paymentData);

    if ($jsonData) {
      $price = 0;
      if (property_exists($jsonData, 'initialPrice')) {
        $price = $jsonData->initialPrice;
      } else if (property_exists($jsonData, 'subscriptionInitialPrice')) {
        $price = $jsonData->subscriptionInitialPrice;
      } else if (property_exists($jsonData, 'billedInitialPrice')) {
        $price = round($jsonData->billedInitialPrice);
      }

      $subscriptionId = '';
      if (property_exists($jsonData, 'subscriptionId')) {
        $subscriptionId = $jsonData->subscriptionId;
      } else if (property_exists($jsonData, 'subscription_id')) {
        $subscriptionId = $jsonData->subscription_id;
      }

      $userId = '';
      if (property_exists($jsonData, 'userid')) {
        $userId = $jsonData->userid;
      } else if (property_exists($jsonData, 'userId')) {
        $userId = $jsonData->{'userId'};
      } else if (property_exists($jsonData, 'X-userid')) {
        $userId = $jsonData->{'X-userid'};
      }

      //check package
      $package = PaymentPackageModel::where('price', $price)->first();
      $newPayment = new PaymentsModel();
      if(!$package){
        $newPayment->price = 0;
      }else{
        $newPayment->price = $package->tokens;
        $newPayment->packageId = $package->id;

      }
      if(!empty($subscriptionId)){
        $newPayment->status = PaymentsModel::STATUS_APPROVED;
        if($package){
        $newPayment->description = $price .' '.$for.' '.$package->tokens . 'tokens';
        }else{
          $newPayment->description = $price . ' '.$for.' 0 tokens';
        }
      }else{
        $newPayment->status = PaymentsModel::STATUS_DENIAL;
        $newPayment->description = $jsonData->reasonForDecline;
      }
      $newPayment->memberId = $userId;
      $newPayment->type = PaymentsModel::CANDY_PAYMENT;
      $newPayment->parameters = $paymentData;


      if ($newPayment->save()) {
        if(!empty($subscriptionId)){
          $updateMemberCandy = UserModel::find($userId);
          $updateMemberCandy->increment('tokens', $package->tokens); // = (int) (AppHelper::getMemberinfo($jsonData->userid)->tokens) + (int) ($jsonData->candies);
          if (!$updateMemberCandy->save()) {
            $newPayment->status = PaymentsModel::STATUS_ERROR;
            $newPayment->save();
            //TODO send success email
//            AppHelper::sendPaymentEmail($updateMemberCandy->email, $jsonData);
          }else{

          }
          //TODO process send mail here;

        }else{
          //TODO send denial payment here.
        }
      } else {
        $newPayment->status = PaymentsModel::STATUS_ERROR;
        $newPayment->save();
        //TODO send error increment tokens here

      }
    }else{
      $file = md5(time()).'.txt';
      $myfile = fopen(public_path() . "/uploads/".$file, "w") or die($unableUpFileMemberControl);
      fwrite($myfile, $paymentData);
      fclose($myfile);
    }
  }

  public function getPaymentAccessBackData() {


    \App::setLocale(session('lang'));

    $thankYouPamentMemberControl = trans('messages.thankYouPamentMemberControl');
    $unableOpenFileMemberControl = trans('messages.unableOpenFileMemberControl');

    return redirect('members/funds-tokens')->with('msgInfo', $thankYouPamentMemberControl);
  }

  public function postPaymentDeniBackData() {
    $myfile = fopen($_SERVER['DOCUMENT_ROOT'] . "/paymentDeni.txt", "w") or die($unableOpenFileMemberControl);
    $txt = json_encode($_POST);
    fwrite($myfile, $txt);
    fclose($myfile);
  }

  /**
   * Show list  purchased image.
   * @return Response
   * @author LongPham <long.it.stu@gmail.com>
   */
  public static function getPurchased($action) {

    \App::setLocale(session('lang'));

    $requestNotFound = trans('messages.requestNotFound');

    if ($action === 'images') {
      $userLogin = AppSession::getLoginData();
      $getPurchased = PaymentTokensModel::select('paymenttokens.*', 'g.*', DB::raw("(SELECT a.id FROM attachment as a WHERE a.parent_id=g.id AND a.main='yes' limit 1) as media"), DB::raw("(SELECT a1.id FROM attachment a1 WHERE a1.parent_id=g.id AND a1.status='".AttachmentModel::ACTIVE."'  limit 1) as subImage"))
        ->where('paymenttokens.ownerId', '=', $userLogin->id)
        ->where('paymenttokens.item', '=', PaymentTokensModel::ITEM_IMAGE)
        ->where('paymenttokens.status', '<>', PaymentTokensModel::STATUS_REJECT)
        ->join('galleries as g', 'g.id', '=', 'paymenttokens.itemId')
        ->paginate(LIMIT_PER_PAGE);
      return view('Member::member_profile_sub_purchased_item')->with('galleries', $getPurchased)->with('action', $action);
    }
    if ($action === 'videos') {
      $userLogin = AppSession::getLoginData();
      $getPurchased = PaymentTokensModel::select('paymenttokens.*', 'v.*', DB::raw("(SELECT a.mediaMeta FROM attachment as a WHERE a.id=v.poster) as media"))
        ->where('paymenttokens.ownerId', '=', $userLogin->id)
        ->where('paymenttokens.item', '=', PaymentTokensModel::ITEM_VIDEO)
        ->where('paymenttokens.status', '<>', PaymentTokensModel::STATUS_REJECT)
        ->join('videos as v', 'v.id', '=', 'paymenttokens.itemId')
        ->paginate(LIMIT_PER_PAGE);

      return view('Member::member_profile_sub_purchased_item')->with('videos', $getPurchased)->with('action', $action);
    } else {
      return redirect()->back()->with('msgError', $requestNotFound);
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

  public function getTermsConditions() {
    \App::setLocale(session('lang'));
    return view('home.termsandconditions');
  }

  public function getPrivacyPolicy() {
    \App::setLocale(session('lang'));
    return view('home.privacypolicy');
  }
  /**
   * blog list
   */
  public function getBlog(Request $req){
    $blog = UserModel::select('users.id', 'username', 'users.avatar', 'blog', 'blogname')
      ->join('performer as p', 'p.user_id', '=', 'users.id')
      ->where('blog', '<>', '')
      ->where('blogname', '<>', '')
      ->where('users.accountStatus', UserModel::ACCOUNT_ACTIVE);
    if($req->has('q')){
      $blog = $blog->where('p.blogname', 'like', $req->get('q').'%');
    }
    $blog = $blog->paginate(LIMIT_PER_PAGE);

    return view('blog.blog')->with('blog', $blog);
  }



  public function link(Request $request, $referralCode)
{   
   // if (!$request->hasCookie('referral')) {
        $cookie = cookie('referral', $referralCode, 60 * 24 * 1);

        return redirect('/')->withCookie($cookie);
   // }

   // return redirect('/');
}


  public function Promocion() {
    \App::setLocale(session('lang'));
    $userLogin = AppSession::getLoginData();
    $member = UserModel::find($userLogin->id);

    return view('Member::member_profile_promocion')->with('getMember', $member);
  }


}
