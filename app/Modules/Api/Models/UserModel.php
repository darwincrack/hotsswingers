<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Modules\Model\Models\PerformerPayoutRequest;
use App\Helpers\Session as AppSession;

class UserModel extends Model {

  protected $table = "users";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const ROLE_MEMBER = 'member';
  const ROLE_MODEL = 'model';
  const ROLE_STUDIO = 'studio';
  const ROLE_ADMIN = 'admin';
  const ROLE_SUPERADMIN = 'superadmin';
  const EMAIL_VERIFIED = 1;
  const ALLOW_ONLY_PERFORMERS = 1;
  CONST ALLOW_ALSO_AUTHENTICATED = 0;
  const ACCOUNT_ACTIVE = 'active';
  const ACCOUNT_SUSPEND = 'suspend';
  const ACCOUNT_DISABLE = 'disable';
  const ACCOUNT_NOTCONFIRMED = 'notConfirmed';
  const ACCOUNT_WAITING = 'waiting';
  const PLATFORM_ANDROID = 'ANDROID';
  const PLATFORM_IOS = 'IOS';
  const GENDER_MALE = 'male';
  const GENDER_FEMALE = 'female';
  const GENDER_TRANSGENDER = 'transgender';
  const pareja = 'pareja';

  public static function CheckLogin($username, $password) {
    $check = UserModel::where('username', '=', $username)->where('passwordHash', '=', $password)->count();
    if ($check > 0) {
      //Session(["logined"=>Users::where('username','=',$username)->first()]);
      return true;
    } else {
      return false;
    }
  }

  public static function findMe($id) {
    $userData = UserModel::where('id', '=', $id)->first();
    return $userData;
  }

  public static function checkTokens($uid) {
    $userData = UserModel::select('tokens')->where('id', '=', $uid)->first();
    return $userData->tokens;
  }

  public static function sendTokens($userId, $data) {
    $tokens = $data['tokens'];
    $userData = UserModel::where('id', '=', $userId)->decrement('tokens', $tokens);
    if ($userData) {
      UserModel::where('id', '=', $data['roomId'])->increment('tokens', $tokens);
    }
    return $userData;
  }

  //Check User thumbnail
  public function checkThumb($thumb) {
    if ($thumb != NULL && file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/lib/images/upload/member/' . $thumb) === true) {
      $image = PATH_IMAGE . '/upload/member/' . $thumb;
    } else {
      $image = PATH_IMAGE . '/noimage.png';
    }
    return $image;
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param string $role User role
   * @package options
   * return Response
   *
   */
  public static function getUsersByRole($role = 'member', $options = array()) {
    $take = isset($options['take']) ? $options['take'] : LIMIT_PER_PAGE;
    $skip = isset($options['skip']) ? $options['skip'] : 0;
    return UserModel::where('role', $role)
        ->paginate($take);
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param string $role User role
   * @package options
   * return Response
   *
   */
  public static function getMembersByRole($role = 'member', $options = array()) {
    $take = isset($options['take']) ? $options['take'] : LIMIT_PER_PAGE;
    $skip = isset($options['skip']) ? $options['skip'] : 0;
    $search = isset($options['q']) ? $options['q'] : null;
    $studio = isset($options['studio']) ? $options['studio'] : null;
    
    $users = UserModel::select('users.*', DB::raw('(SELECT sum(p.tokens) FROM paymenttokens p WHERE p.ownerId = users.id) as totalTokens'), 'u1.username as manager', DB::raw("case users.role when 'model' then (SELECT SUM(c.streamingTime) FROM chatthreads c WHERE c.ownerId=users.id) when 'member' then (SELECT SUM(tu.streamingTime) FROM chatthreadusers tu WHERE tu.userId=users.id) END as streamingTime"))
      ->leftJoin('users as u1', 'u1.id', '=', 'users.parentId')
      ->where('users.role', $role);
    if ($search) {
      $users = $users->where('users.username', 'like', $search . '%');
    }
    if($studio){
      $users = $users->where('users.parentId', $studio);
    }
    if (isset($options['filter']) && $options['filter'] != null && in_array($options['filter'], ['username', 'email', 'status', 'createdAt', 'tokens'])) {
      $users = $users->orderBy($options['filter'], 'desc');
    }

    return $users->paginate($take);
  }

  /**
   * get total studio models
   * return int
   */
  public static function getTotalModels($id) {
    return UserModel::where('role', UserModel::ROLE_MODEL)
        ->where('parentId', $id)
        ->count();
  }

  
//   public function save(array $options = [])
//   {
//       $this->firstName = preg_replace('/\s+/', ' ',  $this->firstName);
//       $this->lastName = preg_replace('/\s+/', ' ',  $this->lastName);
//       $this->stateName = preg_replace('/\s+/', ' ',  $this->stateName);
//       $this->cityName = preg_replace('/\s+/', ' ',  $this->cityName);
//       $this->address1 = preg_replace('/\s+/', ' ',  $this->address1);
//       $this->address2 = preg_replace('/\s+/', ' ',  $this->address2);
//       $this->paypal = preg_replace('/\s+/', ' ',  $this->paypal);
//       $this->payoneer = preg_replace('/\s+/', ' ',  $this->payoneer);
//       $this->bankAccount = preg_replace('/\s+/', ' ',  $this->bankAccount);
//      // before save code 
//      parent::save();
//      // after save code
//   }
  
    public function getRouteKeyName() {
        return 'username';
    }
    
    public function videos(){
        return $this->hasMany(GalleryModel::class);
    }
   
    public function schedule(){
        return $this->hasOne(ScheduleModel::class, 'modelId');
    }
    
    public function performer(){
        return $this->hasOne(PerformerModel::class, 'user_id');
    }
    
    public function paymentTokens(){
        return $this->hasMany(PaymentTokensModel::class);
    }
    
    public function commission(){
        return $this->hasOne(EarningSettingModel::class);
    }
    public static function countByStudios($studioId){
      return UserModel::where('studio_id', $studioId)
              ->where('accountStatus', UserModel::ACCOUNT_ACTIVE)
              ->count();
    }
    public static function getPaymentInfo($userId, $paymentAccount){
      $userModel = UserModel::find($userId);      
      $paymentMethod = '';
      if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYPAL 
              || $paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_ISSUE_CHECK_US
              || $paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_WIRE){
        $paymentMethod = self::getBankTransferOptions($paymentAccount, $userModel->bankTransferOptions);
      }else if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_DEPOSIT){
        $paymentMethod = self::getDeposit($userModel->directDeposit);
      }else if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYONEER){
        $paymentMethod = self::getPaxum($userModel->paxum);
      }else if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_BITPAY){
        $paymentMethod = self::getPaxum($userModel->bitpay);
      }
      return $paymentMethod;
    }
    public static function getBankTransferOptions($paymentAccount, $data){
      if(!$data){
        return '';
      }
      $data = json_decode($data);
      $result = '';
      if(isset($data->withdrawCurrency)){
        $result .= trans('messages.withdrawCurrency').': ';
        if($data->withdrawCurrency === 'eurEuro'){
          $result .= trans('messages.eurEuro');
        }else{
          $result .= trans('messages.usdUnitedStatesDollars');
        }
        $result .= '<br>';
      }
      
      if(isset($data->taxPayer)){
        $result .= trans('messages.taxPayer').': '.$data->taxPayer.'<br>';
      }
      
      if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_WIRE){
        if(isset($data->bankName)){
          $result .= trans('messages.bankName').': '.$data->bankName.'<br>';
        }
        if(isset($data->bankAddress)){
          $result .= trans('messages.bankAddress').': '.$data->bankAddress.'<br>';
        }
        if(isset($data->bankCity)){
          $result .= trans('messages.bankCity').': '.$data->bankCity.'<br>';
        }
        if(isset($data->bankState)){
          $result .= trans('messages.bankState').': '.$data->bankState.'<br>';
        }
        if(isset($data->bankZip)){
          $result .= trans('messages.bankZip').': '.$data->bankZip.'<br>';
        }
        if(isset($data->bankCountry)){
          $result .= trans('messages.bankCountry').': '.$data->bankCountry.'<br>';
        }
        if(isset($data->bankAcountNumber)){
          $result .= trans('messages.bankAcountNumber').': '.$data->bankAcountNumber.'<br>';
        }
        if(isset($data->bankSWIFTBICABA)){
          $result .= trans('messages.bankSWIFTBICABA').': '.$data->bankSWIFTBICABA.'<br>';
        }
        if(isset($data->holderOfBankAccount)){
          $result .= trans('messages.holderOfBankAccount').': '.$data->holderOfBankAccount.'<br>';
        }
        if(isset($data->additionalInformation)){
          $result .= trans('messages.additionalInformation').': '.$data->additionalInformation.'<br>';
        }
      }else if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYPAL){
        if(isset($data->payPalAccount)){
          $result .= trans('messages.payPalAccount').': '.$data->payPalAccount.'<br>';
        }
      }else if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_ISSUE_CHECK_US){
        if(isset($data->checkPayable)){
          $result .= trans('messages.checkPayable').': '.$data->checkPayable.'<br>';
        }
      }      
      return $result;
    }
    
    public static function getDeposit($data){
      if(!$data){
        return '';
      }
      $data = json_decode($data);
      $result = '';
      if(isset($data->firstName)){
        $result .= trans('messages.firstname').': '.$data->firstName.'<br>';
      }
      if(isset($data->lastName)){
        $result .= trans('messages.lastname').': '.$data->lastName.'<br>';
      }
      if(isset($data->accountingEmail)){
        $result .= trans('messages.accountingEmail').': '.$data->accountingEmail.'<br>';
      }
      if(isset($data->bankName)){
        $result .= trans('messages.bankName').': '.$data->bankName.'<br>';
      }
      if(isset($data->accountType)){
        $result .= trans('messages.accountType').': ';
        if($data->accountType === 1){
          $result .= 'checking';
        }else{
          $result .= 'saving';
        }
        $result .= '<br>';
      }
      if(isset($data->accountNumber)){
        $result .= trans('messages.accountNumber').': '.$data->accountNumber.'<br>';
      }
      if(isset($data->routingNumber)){
        $result .= trans('messages.routingNumber').': '.$data->routingNumber.'<br>';
      }
      return $result;
    }
    
    public static function getPaxum($data){
      if(!$data){
        return '';
      }
      $data = json_decode($data);
      $result = '';
      if(isset($data->name)){
        $result .= trans('messages.name').': '.$data->name.'<br>';
      }
      if(isset($data->email)){
        $result .= trans('messages.email').': '.$data->email.'<br>';
      }
      if(isset($data->additionalInformation)){
        $result .= trans('messages.additionalInformation').': '.$data->additionalInformation.'<br>';
      }      
      
      return $result;
    }
    public function categories(){
        return $this->belongsToMany('App\Modules\Api\Models\CategoryModel','user_category','user_id','category_id');
    }
    public function multiCategoryName(){


    $userData = AppSession::getLoginData();


      $categories = CategoryModel::join('user_category as uc', 'uc.category_id', '=', 'categories.id')
      ->where('uc.user_id', $userData->id)
      ->get();


          $idioma = trans('messages.traduc24');

        if(empty($categories)){
            return '';
        }

        $nameArray= [];
       
        foreach($categories as $category){




          if($idioma=="EN"){
            $nameArray []= $category->name_en;

          }elseif ($idioma=="FR"){
            $nameArray []= $category->name_fr;

          }else{
            $nameArray []= $category->name;

          }
           
            


        }
        
        return implode(', ', $nameArray);
    }

    public static function getWeightList() {
      return [
        '99  lbs (44.8 kg)' => '99  lbs (44.8 kg)',
        '100 lbs (45.3 kg)' => '100 lbs (45.3 kg)',
        '101 lbs (45.8 kg)' => '101 lbs (45.8 kg)',
        '102 lbs (46.2 kg)' => '102 lbs (46.2 kg)',
        '103 lbs (46.7 kg)' => '103 lbs (46.7 kg)',
        '104 lbs (47.1 kg)' => '104 lbs (47.1 kg)',
        '105 lbs (47.6 kg)' => '105 lbs (47.6 kg)',
        '106 lbs (48.0 kg)' => '106 lbs (48.0 kg)',
        '107 lbs (48.5 kg)' => '107 lbs (48.5 kg)',
        '108 lbs (48.9 kg)' => '108 lbs (48.9 kg)',
        '109 lbs (49.4 kg)' => '109 lbs (49.4 kg)',
        '110 lbs (49.8 kg)' => '110 lbs (49.8 kg)',
        '111 lbs (50.3 kg)' => '111 lbs (50.3 kg)',
        '112 lbs (50.7 kg)' => '112 lbs (50.7 kg)',
        '113 lbs (51.2 kg)' => '113 lbs (51.2 kg)',
        '114 lbs (51.7 kg)' => '114 lbs (51.7 kg)',
        '115 lbs (52.1 kg)' => '115 lbs (52.1 kg)',
        '116 lbs (52.6 kg)' => '116 lbs (52.6 kg)',
        '117 lbs (53.0 kg)' => '117 lbs (53.0 kg)',
        '118 lbs (53.5 kg)' => '118 lbs (53.5 kg)',
        '119 lbs (53.9 kg)' => '119 lbs (53.9 kg)',
        '120 lbs (54.4 kg)' => '120 lbs (54.4 kg)',
        '121 lbs (54.8 kg)' => '121 lbs (54.8 kg)',
        '122 lbs (55.3 kg)' => '122 lbs (55.3 kg)',
        '123 lbs (55.7 kg)' => '123 lbs (55.7 kg)',
        '124 lbs (56.2 kg)' => '124 lbs (56.2 kg)',
        '125 lbs (56.6 kg)' => '125 lbs (56.6 kg)',
        '126 lbs (57.1 kg)' => '126 lbs (57.1 kg)',
        '127 lbs (57.5 kg)' => '127 lbs (57.5 kg)',
        '128 lbs (58.0 kg)' => '128 lbs (58.0 kg)',
        '129 lbs (58.5 kg)' => '129 lbs (58.5 kg)',
        '130 lbs (58.9 kg)' => '130 lbs (58.9 kg)',
        '131 lbs (59.4 kg)' => '131 lbs (59.4 kg)',
        '132 lbs (59.8 kg)' => '132 lbs (59.8 kg)',
        '133 lbs (60.3 kg)' => '133 lbs (60.3 kg)',
        '134 lbs (60.7 kg)' => '134 lbs (60.7 kg)',
        '135 lbs (61.2 kg)' => '135 lbs (61.2 kg)',
        '136 lbs (61.6 kg)' => '136 lbs (61.6 kg)',
        '137 lbs (62.1 kg)' => '137 lbs (62.1 kg)',
        '138 lbs (62.5 kg)' => '138 lbs (62.5 kg)',
        '139 lbs (63.0 kg)' => '139 lbs (63.0 kg)',
        '140 lbs (63.4 kg)' => '140 lbs (63.4 kg)',
        '141 lbs (63.9 kg)' => '141 lbs (63.9 kg)',
        '142 lbs (64.3 kg)' => '142 lbs (64.3 kg)',
        '143 lbs (64.8 kg)' => '143 lbs (64.8 kg)',
        '144 lbs (65.3 kg)' => '144 lbs (65.3 kg)',
        '145 lbs (65.7 kg)' => '145 lbs (65.7 kg)',
        '146 lbs (66.2 kg)' => '146 lbs (66.2 kg)',
        '147 lbs (66.6 kg)' => '147 lbs (66.6 kg)',
        '148 lbs (67.1 kg)' => '148 lbs (67.1 kg)',
        '149 lbs (67.5 kg)' => '149 lbs (67.5 kg)',
        '150 lbs (68.0 kg)' => '150 lbs (68.0 kg)',
        '151 lbs (68.4 kg)' => '151 lbs (68.4 kg)',
        '152 lbs (68.9 kg)' => '152 lbs (68.9 kg)',
        '153 lbs (69.3 kg)' => '153 lbs (69.3 kg)',
        '154 lbs (69.8 kg)' => '154 lbs (69.8 kg)',
        '155 lbs (70.2 kg)' => '155 lbs (70.2 kg)',
        '156 lbs (70.7 kg)' => '156 lbs (70.7 kg)',
        '157 lbs (71.2 kg)' => '157 lbs (71.2 kg)',
        '158 lbs (71.6 kg)' => '158 lbs (71.6 kg)',
        '159 lbs (72.1 kg)' => '159 lbs (72.1 kg)',
        '160 lbs (72.5 kg)' => '160 lbs (72.5 kg)',
        '161 lbs (73.0 kg)' => '161 lbs (73.0 kg)',
        '162 lbs (73.4 kg)' => '162 lbs (73.4 kg)',
        '163 lbs (73.9 kg)' => '163 lbs (73.9 kg)',
        '164 lbs (74.3 kg)' => '164 lbs (74.3 kg)',
        '165 lbs (74.8 kg)' => '165 lbs (74.8 kg)',
        '166 lbs (75.2 kg)' => '166 lbs (75.2 kg)',
        '167 lbs (75.7 kg)' => '167 lbs (75.7 kg)',
        '168 lbs (76.1 kg)' => '168 lbs (76.1 kg)',
        '169 lbs (76.6 kg)' => '169 lbs (76.6 kg)',
        '170 lbs (77.0 kg)' => '170 lbs (77.0 kg)',
        '171 lbs (77.5 kg)' => '171 lbs (77.5 kg)',
        '172 lbs (78.0 kg)' => '172 lbs (78.0 kg)',
        '173 lbs (78.4 kg)' => '173 lbs (78.4 kg)',
        '174 lbs (78.9 kg)' => '174 lbs (78.9 kg)',
        '175 lbs (79.3 kg)' => '175 lbs (79.3 kg)',
        '176 lbs (79.8 kg)' => '176 lbs (79.8 kg)',
        '177 lbs (80.2 kg)' => '177 lbs (80.2 kg)',
        '178 lbs (80.7 kg)' => '178 lbs (80.7 kg)',
        '179 lbs (81.1 kg)' => '179 lbs (81.1 kg)',
        '180 lbs (81.6 kg)' => '180 lbs (81.6 kg)',
        '181 lbs (82.0 kg)' => '181 lbs (82.0 kg)',
        '182 lbs (82.5 kg)' => '182 lbs (82.5 kg)',
        '183 lbs (82.9 kg)' => '183 lbs (82.9 kg)',
        '184 lbs (83.4 kg)' => '184 lbs (83.4 kg)',
        '185 lbs (83.9 kg)' => '185 lbs (83.9 kg)',
        '186 lbs (84.3 kg)' => '186 lbs (84.3 kg)',
        '187 lbs (84.8 kg)' => '187 lbs (84.8 kg)',
        '188 lbs (85.2 kg)' => '188 lbs (85.2 kg)',
        '189 lbs (85.7 kg)' => '189 lbs (85.7 kg)',
        '190 lbs (86.1 kg)' => '190 lbs (86.1 kg)',
        '191 lbs (86.6 kg)' => '191 lbs (86.6 kg)',
        '192 lbs (87.0 kg)' => '192 lbs (87.0 kg)',
        '193 lbs (87.5 kg)' => '193 lbs (87.5 kg)',
        '194 lbs (87.9 kg)' => '194 lbs (87.9 kg)',
        '195 lbs (88.4 kg)' => '195 lbs (88.4 kg)',
        '196 lbs (88.8 kg)' => '196 lbs (88.8 kg)',
        '197 lbs (89.3 kg)' => '197 lbs (89.3 kg)',
        '198 lbs (89.7 kg)' => '198 lbs (89.7 kg)',
        '199 lbs (90.2 kg)' => '199 lbs (90.2 kg)',
        '200 lbs (90.7 kg)' => '200 lbs (90.7 kg)',
        '201 lbs (91.1 kg)' => '201 lbs (91.1 kg)',
        '202 lbs (91.6 kg)' => '202 lbs (91.6 kg)',
        '203 lbs (92.0 kg)' => '203 lbs (92.0 kg)',
        '204 lbs (92.5 kg)' => '204 lbs (92.5 kg)',
        '205 lbs (92.9 kg)' => '205 lbs (92.9 kg)',
        '206 lbs (93.4 kg)' => '206 lbs (93.4 kg)',
        '207 lbs (93.8 kg)' => '207 lbs (93.8 kg)',
        '208 lbs (94.3 kg)' => '208 lbs (94.3 kg)',
        '209 lbs (94.7 kg)' => '209 lbs (94.7 kg)',
        '210 lbs (95.2 kg)' => '210 lbs (95.2 kg)',
        '211 lbs (95.6 kg)' => '211 lbs (95.6 kg)',
        '212 lbs (96.1 kg)' => '212 lbs (96.1 kg)',
        '213 lbs (96.5 kg)' => '213 lbs (96.5 kg)',
        '214 lbs (97.0 kg)' => '214 lbs (97.0 kg)',
        '215 lbs (97.5 kg)' => '215 lbs (97.5 kg)',
        '216 lbs (97.9 kg)' => '216 lbs (97.9 kg)',
        '217 lbs (98.4 kg)' => '217 lbs (98.4 kg)',
        '218 lbs (98.8 kg)' => '218 lbs (98.8 kg)',
        '219 lbs (99.3 kg)' => '219 lbs (99.3 kg)',
        '220 lbs (99.7 kg)' => '220 lbs (99.7 kg)',
        '221 lbs (100.2 kg)' => '221 lbs (100.2 kg)',
        '222 lbs (100.6 kg)' => '222 lbs (100.6 kg)',
        '223 lbs (101.1 kg)' => '223 lbs (101.1 kg)',
        '224 lbs (101.5 kg)' => '224 lbs (101.5 kg)',
        '225 lbs (102.0 kg)' => '225 lbs (102.0 kg)',
        '226 lbs (102.4 kg)' => '226 lbs (102.4 kg)',
        '227 lbs (102.9 kg)' => '227 lbs (102.9 kg)',
        '228 lbs (103.4 kg)' => '228 lbs (103.4 kg)',
        '229 lbs (103.8 kg)' => '229 lbs (103.8 kg)',
        '230 lbs (104.3 kg)' => '230 lbs (104.3 kg)',
        '231 lbs (104.7 kg)' => '231 lbs (104.7 kg)',
        '232 lbs (105.2 kg)' => '232 lbs (105.2 kg)',
        '233 lbs (105.6 kg)' => '233 lbs (105.6 kg)',
        '234 lbs (106.1 kg)' => '234 lbs (106.1 kg)',
        '235 lbs (106.5 kg)' => '235 lbs (106.5 kg)',
        '236 lbs (107.0 kg)' => '236 lbs (107.0 kg)',
        '237 lbs (107.4 kg)' => '237 lbs (107.4 kg)',
        '238 lbs (107.9 kg)' => '238 lbs (107.9 kg)',
        '239 lbs (108.3 kg)' => '239 lbs (108.3 kg)',
        '240 lbs (108.8 kg)' => '240 lbs (108.8 kg)',
        '241 lbs (109.2 kg)' => '241 lbs (109.2 kg)',
        '242 lbs (109.7 kg)' => '242 lbs (109.7 kg)',
        '243 lbs (110.2 kg)' => '243 lbs (110.2 kg)',
        '244 lbs (110.6 kg)' => '244 lbs (110.6 kg)',
        '245 lbs (111.1 kg)' => '245 lbs (111.1 kg)',
        '246 lbs (111.5 kg)' => '246 lbs (111.5 kg)',
        '247 lbs (112.0 kg)' => '247 lbs (112.0 kg)',
        '248 lbs (112.4 kg)' => '248 lbs (112.4 kg)',
        '249 lbs (112.9 kg)' => '249 lbs (112.9 kg)',
        '250 lbs (113.3 kg)' => '250 lbs (113.3 kg)',
        '251 lbs (113.8 kg)' => '251 lbs (113.8 kg)',
        '252 lbs (114.2 kg)' => '252 lbs (114.2 kg)',
        '253 lbs (114.7 kg)' => '253 lbs (114.7 kg)',
        '254 lbs (115.1 kg)' => '254 lbs (115.1 kg)',
        '255 lbs (115.6 kg)' => '255 lbs (115.6 kg)',
        '256 lbs (116.0 kg)' => '256 lbs (116.0 kg)',
        '257 lbs (116.5 kg)' => '257 lbs (116.5 kg)',
        '258 lbs (117.0 kg)' => '258 lbs (117.0 kg)',
        '259 lbs (117.4 kg)' => '259 lbs (117.4 kg)',
        '260 lbs (117.9 kg)' => '260 lbs (117.9 kg)',
        '261 lbs (118.3 kg)' => '261 lbs (118.3 kg)',
        '262 lbs (118.8 kg)' => '262 lbs (118.8 kg)',
        '263 lbs (119.2 kg)' => '263 lbs (119.2 kg)',
        '264 lbs (119.7 kg)' => '264 lbs (119.7 kg)',
        '265 lbs (120.1 kg)' => '265 lbs (120.1 kg)',
        '266 lbs (120.6 kg)' => '266 lbs (120.6 kg)',
        '267 lbs (121.0 kg)' => '267 lbs (121.0 kg)',
        '268 lbs (121.5 kg)' => '268 lbs (121.5 kg)',
        '269 lbs (121.9 kg)' => '269 lbs (121.9 kg)',
        '270 lbs (122.4 kg)' => '270 lbs (122.4 kg)',
        '271 lbs (122.9 kg)' => '271 lbs (122.9 kg)',
        '272 lbs (123.3 kg)' => '272 lbs (123.3 kg)',
        '273 lbs (123.8 kg)' => '273 lbs (123.8 kg)',
        '274 lbs (124.2 kg)' => '274 lbs (124.2 kg)',
        '275 lbs (124.7 kg)' => '275 lbs (124.7 kg)',
        '276 lbs (125.1 kg)' => '276 lbs (125.1 kg)',
        '277 lbs (125.6 kg)' => '277 lbs (125.6 kg)',
        '278 lbs (126.0 kg)' => '278 lbs (126.0 kg)',
        '279 lbs (126.5 kg)' => '279 lbs (126.5 kg)',
        '280 lbs (126.9 kg)' => '280 lbs (126.9 kg)',
        '281 lbs (127.4 kg)' => '281 lbs (127.4 kg)',
        '282 lbs (127.8 kg)' => '282 lbs (127.8 kg)',
        '283 lbs (128.3 kg)' => '283 lbs (128.3 kg)',
        '284 lbs (128.7 kg)' => '284 lbs (128.7 kg)',
        '285 lbs (129.2 kg)' => '285 lbs (129.2 kg)',
        '286 lbs (129.7 kg)' => '286 lbs (129.7 kg)',
        '287 lbs (130.1 kg)' => '287 lbs (130.1 kg)',
        '288 lbs (130.6 kg)' => '288 lbs (130.6 kg)',
        '289 lbs (131.0 kg)' => '289 lbs (131.0 kg)',
        '290 lbs (131.5 kg)' => '290 lbs (131.5 kg)',
        '291 lbs (131.9 kg)' => '291 lbs (131.9 kg)',
        '292 lbs (132.4 kg)' => '292 lbs (132.4 kg)',
        '293 lbs (132.8 kg)' => '293 lbs (132.8 kg)',
        '294 lbs (133.3 kg)' => '294 lbs (133.3 kg)',
        '295 lbs (133.7 kg)' => '295 lbs (133.7 kg)',
        '296 lbs (134.2 kg)' => '296 lbs (134.2 kg)',
        '297 lbs (134.6 kg)' => '297 lbs (134.6 kg)',
        '298 lbs (135.1 kg)' => '298 lbs (135.1 kg)',
        '299 lbs (135.6 kg)' => '299 lbs (135.6 kg)',
        '300 lbs (136.0 kg)' => '300 lbs (136.0 kg)',
        '301 lbs (136.5 kg)' => '301 lbs (136.5 kg)',
        '302 lbs (136.9 kg)' => '302 lbs (136.9 kg)',
        '303 lbs (137.4 kg)' => '303 lbs (137.4 kg)',
        '304 lbs (137.8 kg)' => '304 lbs (137.8 kg)',
        '305 lbs (138.3 kg)' => '305 lbs (138.3 kg)',
        '306 lbs (138.7 kg)' => '306 lbs (138.7 kg)',
        '307 lbs (139.2 kg)' => '307 lbs (139.2 kg)',
        '308 lbs (139.6 kg)' => '308 lbs (139.6 kg)',
        '309 lbs (140.1 kg)' => '309 lbs (140.1 kg)',
        '310 lbs (140.5 kg)' => '310 lbs (140.5 kg)',
        '311 lbs (141.0 kg)' => '311 lbs (141.0 kg)',
        '312 lbs (141.4 kg)' => '312 lbs (141.4 kg)',
        '313 lbs (141.9 kg)' => '313 lbs (141.9 kg)',
        '314 lbs (142.4 kg)' => '314 lbs (142.4 kg)',
        '315 lbs (142.8 kg)' => '315 lbs (142.8 kg)',
        '316 lbs (143.3 kg)' => '316 lbs (143.3 kg)',
        '317 lbs (143.7 kg)' => '317 lbs (143.7 kg)',
        '318 lbs (144.2 kg)' => '318 lbs (144.2 kg)',
        '319 lbs (144.6 kg)' => '319 lbs (144.6 kg)'
      ];
    }

    public static function getHeightList() {
      return [
        '4\'6" (137.16 cm)' => '4\'6" (137.16 cm)',
        '4\'7" (139.7 cm)' => '4\'7" (139.7 cm)',
        '4\'8" (142.24 cm)' => '4\'8" (142.24 cm)',
        '4\'9" (144.78 cm)' => '4\'9" (144.78 cm)',
        '4\'10"(147.32 cm)' => '4\'10"(147.32 cm)',
        '4\'11"(149.86 cm)' => '4\'11"(149.86 cm)',
        '5\'0" (152.4 cm)' => '5\'0" (152.4 cm)',
        '5\'1" (154.94 cm)' => '5\'1" (154.94 cm)',
        '5\'2" (157.48 cm)' => '5\'2" (157.48 cm)',
        '5\'3" (160.02 cm)' => '5\'3" (160.02 cm)',
        '5\'4" (162.56 cm)' => '5\'4" (162.56 cm)',
        '5\'5" (165.1 cm)' => '5\'5" (165.1 cm)',
        '5\'6" (167.64 cm)' => '5\'6" (167.64 cm)',
        '5\'7" (170.18 cm)' => '5\'7" (170.18 cm)',
        '5\'8" (172.72 cm)' => '5\'8" (172.72 cm)',
        '5\'9" (175.26 cm)' => '5\'9" (175.26 cm)',
        '5\'10"(177.8 cm)' => '5\'10"(177.8 cm)',
        '5\'11"(180.34 cm)' => '5\'11"(180.34 cm)',
        '6\'0" (182.88 cm)' => '6\'0" (182.88 cm)',
        '6\'1" (185.42 cm)' => '6\'1" (185.42 cm)',
        '6\'2" (187.96 cm)' => '6\'2" (187.96 cm)',
        '6\'3" (190.5 cm)' => '6\'3" (190.5 cm)',
        '6\'4" (193.04 cm)' => '6\'4" (193.04 cm)',
        '6\'5" (195.58 cm)' => '6\'5" (195.58 cm)'
      ];
    }
    
}
