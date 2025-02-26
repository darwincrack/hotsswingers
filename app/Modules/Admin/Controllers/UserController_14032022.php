<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use App\Modules\Model\Models\PerformerTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\PerformerModel;
use App\Modules\Api\Models\CategoryModel;
use App\Events\AddModelPerformerChatEvent;
use App\Events\AddModelScheduleEvent;
use App\Events\AddEarningSettingEvent;
use App\Events\AddModelPerformerEvent;
use App\Modules\Api\Models\CountryModel;
use App\Events\MakeChatRoomEvent;
use App\Modules\Api\Models\PerformerChatModel;
use App\Modules\Api\Models\AttachmentModel;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\FavoriteModel;
use App\Modules\Api\Models\MessageReplyModel;
use App\Modules\Api\Models\MessageConversationModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\ScheduleModel;
use App\Modules\Api\Models\EarningSettingModel;
use App\Modules\Api\Models\GustosGente;
use App\Modules\Api\Models\Gustos;
use App\Modules\Api\Models\Preferencias;
use App\Modules\Api\Models\PreferenciasPersonas;
use App\Jobs\DeleteGalleryByOwner;
use App\Jobs\deleteAttachmentByOwner;
use App\Modules\Api\Models\OssnRelationshipsModel;
use App\Modules\Api\Models\OssnEntitiesModel;
use App\Modules\Api\Models\OssnAnnotationsModel;
use DB;
use HTML;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\ShowingRecords;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\SelectFilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use App\Modules\Api\Models\DocumentModel;
use App\Helpers\MediaHelper;

class UserController extends Controller {

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response members
   */



  public function getMyProfile() {
    $adminData = AppSession::getLoginData();
    if(env('DISABLE_EDIT_ADMIN') && !$adminData->isSuperAdmin) {
      return redirect('admin/dashboard')->with('msgError', 'No se puede acceder a esta pagina'); 
    }
    $userData = AppSession::getLoginData();

    return view('Admin::admin_profile')->with('profile', $userData);
  }

  /**
   * @param post $params user data
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response
   */
  public function updateMyProfile() {
    $adminData = AppSession::getLoginData();
    if(env('DISABLE_EDIT_ADMIN') && !$adminData->isSuperAdmin) {
      return redirect('admin/dashboard')->with('msgError', 'No se puede acceder a esta pagina'); 
    }
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect::to('admin/login')->with('tu sesión ha expirado');
    }
    Validator::extend('hashmatch', function($attribute, $value, $parameters) {
//      return Hash::check($value, AuthController::user()->$parameters[0]);
      return AuthController::checkPassword($attribute, $value, $parameters);
//      var_dump($attribute,$value, $parameters);
    });

    $messages = array(
      'hashmatch' => 'Su contraseña actual debe coincidir con la contraseña de su cuenta.'
    );
    $validator = Validator::make(Input::all(), [
        'email' => 'Required|Between:3,64|Email|Unique:users,email,' . $userData->id,
        'firstName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
        'lastName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
        'password' => 'Required|hashmatch:passwordHash',
        'newPassword' => 'Between:6,32|Confirmed',
        'newPassword_confirmation' => 'Between:6,32'
        ], $messages);
    //check current password

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    $profile = UserModel::find($userData->id);
    if (!$profile) {
      AppSession::getLogout();
      return Redirect::to('admin/login')->with('msgError', 'No se encontró su cuenta.');
    }
    $profile->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $profile->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $profile->email = Input::get('email');
    if (Input::has('newPassword')) {
      $profile->passwordHash = md5(Input::get('newPassword'));
    }
    if ($profile->save()) {
      $userData->firstName = $profile->firstName;
      $userData->lastName = $profile->lastName;
      $userData->email = $profile->email;
      AppSession::setLogin($userData);
      return Back()->with('msgInfo', 'Su cuenta se actualizó correctamente.');
    }
    return Back()->with('msgError', 'System error.');
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response members
   */
  public function getMemberUsers($role = 'model') {
    $adminData = AppSession::getLoginData();
    $query = UserModel
      ::leftJoin('countries as c', 'users.location_id', '=', 'c.id')
      ->select('users.*', 'users.id as check', 'users.id as action', DB::raw('(SELECT sum(p.tokens) FROM paymenttokens p WHERE p.ownerId = users.id) as spendTokens'), DB::raw("case users.role when 'model' then (SELECT SUM(c.streamingTime) FROM chatthreads c WHERE c.ownerId=users.id) when 'model' then (SELECT SUM(tu.streamingTime) FROM chatthreadusers tu WHERE tu.userId=users.id) END as streamingTime"))
      // Column alias 'country_name' used to avoid naming conflicts, suggest that customers table also has 'name' column.
      ->addSelect('c.name')
      ->whereRaw('(users.role = "'.UserModel::ROLE_ADMIN.'" OR users.role = "'.UserModel::ROLE_MEMBER.'")');
    $columns = [
      (new FieldConfig)
      ->setName('check')
      ->setLabel('<input type="checkbox" name="checklist[]" class="check-all">')
      ->setCallback(function ($val) {
          return '<input type="checkbox" name="checklist[]" class="case" value="' . $val . '">';
        })
      ->setSortable(false)
      ,
      (new FieldConfig)
      ->setName('id')
      ->setLabel('ID')
      ->setSortable(true)
      ->setSorting(Grid::SORT_ASC)
      ,
      (new FieldConfig)
      ->setName('username')
      ->setLabel('Username')
      ->setCallback(function ($val) {
          return "<span class='glyphicon glyphicon-user'></span>{$val}";
        })
      ->setSortable(true)
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ,
      (new FieldConfig)
      ->setName('email')
      ->setLabel('Email')
      ->setSortable(true)
      ->setCallback(function ($val) {
          $icon = '<span class="glyphicon glyphicon-envelope"></span>&nbsp;';
          return
            '<small>'
            . $icon
            . HTML::link("mailto:$val", $val)
            . '</small>';
        })
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      ),
      (new FieldConfig)
      ->setName('role')
      ->setLabel('Role')
      ->setSortable(true)
      ->addFilter(
        (new SelectFilterConfig)
        ->setName('role')
        ->setOptions(['admin' => 'Admin'])
      )
      ,
      (new FieldConfig)
      ->setName('gender')
      ->setLabel('Genero')
      ->setSortable(true)
      ->addFilter(
        (new SelectFilterConfig)
        ->setName('gender')
        ->setOptions(['male' => 'Hombre', 'female' => 'Mujer', 'transgender' => 'Transgenero', 'pareja'=>'Pareja'])
      )
      ,
      (new FieldConfig)
      ->setName('spendTokens')
      ->setLabel('gastar')
      ->setSortable(true)
      ,
      (new FieldConfig)
      ->setName('tokens')
      ->setLabel('Tokens')
      ->setSortable(true)
      ,
      (new FieldConfig)
      ->setName('accountStatus')
      ->setLabel('Status')
      ->setSortable(true)
      ->addFilter(
        (new SelectFilterConfig)
        ->setName('accountStatus')
        ->setOptions(['active'=>'Activo','suspend'=>'suspendido','notConfirmed'=>'Sin confirmar','disable'=>'Deshabilitado','waiting'=>'Pendiente'])
      )
      ->setCallback(function($val){
          $return = '';
          switch ($val){
              case UserModel::ACCOUNT_ACTIVE: $return = 'Activo';
                  break;
              case UserModel::ACCOUNT_DISABLE: $return = 'Deshabilitado';
                  break;
              case UserModel::ACCOUNT_NOTCONFIRMED: $return = 'Sin confirmar';
                  break;
              case UserModel::ACCOUNT_SUSPEND: $return = 'Suspendido';
                  break;
              case UserModel::ACCOUNT_WAITING: $return = 'Pendiente';
                  break;
              default: $return = '';
                  break;
          }
          return $return;
      }),

      (new FieldConfig)
      ->setName('streamingTime')
      ->setLabel('Tiem. viendo')
      ->setSortable(true)
      ->setCallback(function ($val){

        return AppHelper::convertToHoursMins($val, '%02d hours %02d minutes');
      })
      ,
      (new FieldConfig)
      ->setName('mobilePhone')
      ->setLabel('Teléfono')
      ->setSortable(true)
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ,
      (new FieldConfig)
      ->setName('name')
      ->setLabel('País')
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ->setSortable(true)
      ,
      (new FieldConfig)
      ->setName('createdAt')
      ->setLabel('Fecha Reg')
      ->setSortable(true)
      ->setCallback(function ($val) {
        return date('d/m/Y', strtotime($val));
        })
    ];
    if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) {
      $columns[] = (new FieldConfig)
    ->setName('action')
    ->setLabel('Acciones')
    ->setCallback(function ($val, $row) {
      /*<a class="btn btn-info btn-sm" ng-click="addToAdmin({{$user->id}})">Add to admin</a>&nbsp;&nbsp;<a class="btn btn-success btn-sm" ng-click="setAccountStatus({{$user->id}})">Change</a>&nbsp;&nbsp;<a class="btn btn-warning btn-sm" href="{{URL('admin/manager/member-profile/'.$user->id)}}">Edit</a>*/
        $item = $row->getSrc();
        $url = "<a title='Editar cuenta' href='" . URL('admin/manager/member-profile/' . $val) . "'><span class='fa fa-pencil'></span></a>&nbsp;&nbsp;<a title='Borrar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres eliminar esta cuenta?')\" href='" . URL('admin/manager/profile/delete/' . $val) . "'><span class='fa fa-trash'></span></a>";  
        if($item->accountStatus != UserModel::ACCOUNT_ACTIVE){
            $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/approve/' . $val)."' title='Aprobar cuenta'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
        }
        if($item->accountStatus != UserModel::ACCOUNT_DISABLE){
            $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/disable/' . $val) . "' title='Deshabilitar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres deshabilitar esta cuenta?')\"><span class='fa fa-ban'></span></a>";
        }
        if($item->accountStatus == UserModel::ACCOUNT_ACTIVE){
            $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Cuenta suspendida'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
        }
        
        return $url;
      })
    ->setSortable(false);
    }
    
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Users')
        ->setPageSize(10)
        ->setColumns($columns)
        ->setComponents([
          (new THead)
          ->setComponents([
            (new ColumnHeadersRow),
            (new FiltersRow)
            ,
            (new OneCellRow)
            ->setRenderSection(RenderableRegistry::SECTION_END)
            ->setComponents([
              (new RecordsPerPage)
              ->setVariants([
                10,
                20,
                30,
                40,
                50,
                100,
                200,
                300,
                400,
                500
              ]),
               # Control to show/hide rows in table
              (new ColumnsHider)
                  ->setHiddenByDefault([
                      'email',
                      'name',
                      'mobilePhone',
                  ])
              ,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('Users-' . date('Y-m-d'))->setSheetName('Excel sheet'),
              (new HtmlTag)
              ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filtrar')
              ->setTagName('button')
              ->setRenderSection(RenderableRegistry::SECTION_END)
              ->setAttributes([
                'class' => 'btn btn-success btn-sm',
                'id' => 'formFilter'
              ])
            ])
          ])
          ,
          (new TFoot)
          ->setComponents([
            (new OneCellRow)
            ->setComponents([
              new Pager,
              (new HtmlTag)
              ->setAttributes(['class' => 'pull-right'])
              ->addComponent(new ShowingRecords)
              ,
            ])
          ])
        ])
    );

    return view('Admin::member-manager')->with('title', 'List Members')->with('grid', $grid->render());
  }
    /**
    * Borrar cuenta
    * @param int $id model id
    */
   public function deleteAccount($id) {
      $adminData = AppSession::getLoginData();
       $user = UserModel::find($id);
       if (!$user) {
           return Back()->with('msgError', '¡No existe ese usuario!');
       }
       if(env('DISABLE_EDIT_ADMIN') && !$adminData->isSuperAdmin)
          return redirect('admin/manager/members')->with('msgError', 'No se puede accceder a esta pagina'); 

       //TODO delete earning

       EarningModel::whereRaw("(payFrom = {$user->id} OR payTo = {$user->id})")->delete();

       //TODO delete all user payment

       PaymentTokensModel::where('ownerId', $user->id)->delete();


       //borrar todos los datos del usuario de la red social

    OssnRelationshipsModel::where('relation_from', $user->id)->delete();
    OssnRelationshipsModel::where('relation_to', $user->id)->delete();
    OssnEntitiesModel::where('owner_guid', $user->id)->delete();
    OssnAnnotationsModel::where('owner_guid', $user->id)->delete();
       //TODO delete all favorites

       FavoriteModel::where('ownerId', $user->id)->delete();


       //TODO delete all messages
       MessageReplyModel::whereRaw("(userId={$user->id} OR receivedId = {$user->id})")->delete();
       MessageConversationModel::whereRaw("userOne={$user->id} OR userTwo={$user->id}")->delete();

       //TODO DELETE all profile image
       if ($user->role == UserModel::ROLE_MEMBER && AppHelper::is_serialized($user->avatar)) {
           //delete file
           $avatar = unserialize($user->avatar);
           foreach ($avatar as $key => $value) {
               if (file_exists(public_path($value))) {
                   \File::Delete(public_path($value));
               }
           }
       }
       if ($user->role == UserModel::ROLE_MODEL) {
           //Delete model profiles
           $job = (new deleteAttachmentByOwner($user->id, AttachmentModel::TYPE_PROFILE));
           $this->dispatch($job);
           //delete image gallery
           $imageGalleryJob = (new DeleteGalleryByOwner($user->id, GalleryModel::IMAGE));
           $this->dispatch($imageGalleryJob);
           //Delete video gallery
           $videoGalleryJob = (new DeleteGalleryByOwner($user->id, GalleryModel::VIDEO));
           $this->dispatch($videoGalleryJob);

           //TODO delete model schedule
           ScheduleModel::where('modelId', $user->id)->delete();
           //TODO delete performer and performer chat settings
           PerformerModel::where('user_id', $user->id)->delete();
           //TODO delete earning settings
           EarningSettingModel::where('userId', $user->id)->delete();
           //DELETE performer chat settings.
           $performerChat = PerformerChatModel::where('model_id', $user->id)->first();
           if($performerChat){
               if($performerChat->thumbnail){
                   $thumbnail = AttachmentModel::find($performerChat->thumbnail);
                   if($thumbnail){
                       if(file_exists(public_path($thumbnail->path))){
                         \File::Delete(public_path($thumbnail->path));
                       }
                       $thumbnail->delete();
                   }

               }
               $performerChat->delete();
           }
       }


       if ($user->delete()) {
           return Back()->with('msgInfo', 'El usuario fue eliminado correctamente');
       }
       return Back()->with('msgError', 'System error.');
   }
   /**
   * Deshabilitar cuenta
   * @param int $id model id
   */
  public function disableAccount($id) {
    $user = UserModel::find($id);
    if (!$user) {
      return Back()->with('msgError', 'User not exist!');
    }
    $user->accountStatus = UserModel::ACCOUNT_DISABLE;
    if ($user->save()) {
        return Back()->with('msgInfo', 'El usuario fue deshabilitado exitosamente');

    }
    return Back()->with('msgError', 'System error.');
  }

  /**
   * approval account
   * @param int $id model id
   */
  public function approveAccount($id) {
    $user = UserModel::find($id);
    $adminData = AppSession::getLoginData();
    if (!$user) {
      return Back()->with('msgError', 'User not exist!');
    }
    if(env('DISABLE_EDIT_ADMIN') && !$adminData->isSuperAdmin)
      return redirect('admin/manager/members')->with('msgError', '¡No se puede acceder a esta página!');
    if ($user->accountStatus == UserModel::ACCOUNT_ACTIVE) {
      return Back()->with('msgWarning', 'El usuario ya ha aprobado');
    }
    $userStatus = $user->accountStatus;

    $user->accountStatus = UserModel::ACCOUNT_ACTIVE;
    $user->emailVerified = UserModel::EMAIL_VERIFIED;
    if ($user->save()) {
      if ($userStatus == UserModel::ACCOUNT_WAITING) {
        $username = $user->username;
        $email = $user->email;
        //send mail here
        $send = \Mail::send('email.approve', array('username' => $username, 'email' => $email), function($message) use($email) {
            $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($email)->subject('Cuenta aprobada | '. app('settings')->siteName);
          });
        if ($send) {
          return Back()->with('msgInfo', '¡Se ha enviado un correo electrónico al usuario!');
        } else {
          return Back()->with('msgError', 'Error de correo enviado.');
        }
      }else{
        return Back()->with('msgInfo', 'La cuenta se activó correctamente.');
      }

    }
    return Back()->with('msgError', 'System error.');
  }

  /**
   * Cuenta suspendida
   * @param int $id model id
   */
  public function suspendAccount($id) {
    $user = UserModel::find($id);
    $adminData = AppSession::getLoginData();
    if (!$user) {
      return Back()->with('msgError', '¡No existe ese usuario!');
    }
    if(env('DISABLE_EDIT_ADMIN') && !$adminData->isSuperAdmin) 
      return redirect('admin/manager/members')->with('msgError', '¡No se puede acceder a esta página!');
    $user->accountStatus = UserModel::ACCOUNT_SUSPEND;
    if ($user->save()) {
      return Back()->with('msgInfo', 'El usuario fue suspendido con éxito');
    }
    return Back()->with('msgError', 'Error del sistema.');
  }

  /**
   * @return view add member view
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function addMember() {
    $countries = CountryModel::orderBy('name')->lists('name', 'id')->all();
    return view('Admin::add-member', compact('countries'));
  }

  /**
   * @return view add member view
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function addMemberProcess() {


    $validator = Validator::make(Input::all(), [
        'username' => 'unique:users|Between:3,64|required',
        'email' => 'Required|Between:3,64|Email|Unique:users',
        'firstName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
        'lastName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
        'location' => 'Required',
        'password' => 'Required|Between:6,32|Confirmed',
        'password_confirmation' => 'Required|Between:6,32',
        'tokens'    => 'Integer',
        'gender'    => 'Required|in:'.UserModel::GENDER_MALE.','.UserModel::GENDER_FEMALE.','.UserModel::GENDER_TRANSGENDER
    ]);

    if ($validator->fails()) {
      return back()
          ->withErrors($validator)
          ->withInput();
    }
    $userData = Input::all();

    $newMember = new UserModel ();
    $newMember->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $newMember->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    if (!empty($userData['gender'])) {
      $newMember->gender = $userData['gender'];
    }
    $newMember->username = $userData['username'];
    $newMember->email = $userData['email'];
    $newMember->passwordHash = md5($userData['password']);
    $newMember->location_id = $userData['location'];
    $newMember->emailVerified = 1;
    $newMember->accountStatus = UserModel::ACCOUNT_ACTIVE;
    $newMember->role = UserModel::ROLE_MEMBER;
    $newMember->tokens = $userData['tokens'];


    if ($newMember->save()) {

      UserModel::where( 'id', $newMember->id )
                ->update(['guid' => $newMember->id ] );


      return redirect('admin/manager/member-profile/' . $newMember->id)->with('msgInfo', 'Usuario creado con éxito!');
    } else {
      return redirect()->back()->withInput()->with('msgError', 'Error del sistema.');
    }
  }

  /**
   * @return view member view
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function updateMemberProcess($id) {

    $validator = Validator::make(Input::all(), [
        'username' => 'Required|Between:3,32|Unique:users,username,' . $id,
        'firstName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
        'lastName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
        'location' => 'Required',
        'passwordHash' => 'AlphaNum|Between:6,32',
        'tokens'    => 'Integer|Min:0',
        'gender'    => 'Required|in:'.UserModel::GENDER_MALE.','.UserModel::GENDER_FEMALE.','.UserModel::GENDER_TRANSGENDER,
        'role'      => 'Required|in:'.UserModel::ROLE_ADMIN.','.UserModel::ROLE_MEMBER
    ]);

    if ($validator->fails()) {
      return back()
          ->withErrors($validator)
          ->withInput();
    }
    $userData = Input::all();

    $member = UserModel::find($id);
    if (!$member)
      return redirect('admin/manager/members')->with('msgError', '¡No existe ese usuario!');
    $member->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $member->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));

    $member->gender = $userData['gender'];
    $member->role = $userData['role'];

    if (Input::has('passwordHash') && !empty($userData['passwordHash'])) {
      $member->passwordHash = md5($userData['passwordHash']);
    }
    $member->username = $userData['username'];
    $member->location_id = $userData['location'];
    $member->tokens = $userData['tokens'];

    if ($member->save()) {
      return back()->with('msgInfo', '¡Actualizado correctamente!');
    } else {
      return redirect()->back()->withInput()->with('msgError', 'Error del sistema.');
    }
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param integer $id member id
   * @return view
   */
  public function getMemberProfile($id) {
    $adminData = AppSession::getLoginData();
    $user = UserModel::where('id', $id)
      ->whereRaw('(users.role = "'.UserModel::ROLE_ADMIN.'" OR users.role = "'.UserModel::ROLE_MEMBER.'")')
      ->first();
    if (!$user)
      return redirect('admin/manager/members')->with('msgInfo', '¡No existe ese usuario!');
    if(env('DISABLE_EDIT_ADMIN') && !$adminData->isSuperAdmin) 
      return redirect('admin/manager/members')->with('msgError', '¡No se puede acceder a esta página!');

    $countries = CountryModel::orderBy('name')->lists('name', 'id')->all();
    return view('Admin::member-edit', compact('countries', 'user'));
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response models
   */
  public function getModelUsers($role = 'model') {



      $query = UserModel
      ::leftJoin('countries as c', 'users.countryId', '=', 'c.id')
      ->select('users.*', 'users.id as check', 'users.id as action')
      // Column alias 'country_name' used to avoid naming conflicts, suggest that customers table also has 'name' column.
      ->addSelect('c.name')

      ->where('users.role', UserModel::ROLE_MODEL)
      ->orderBy('id', 'DESC');
      $studios = UserModel::where('role', UserModel::ROLE_STUDIO)->get();
      $dropdownStudios = [];
      foreach($studios as $studio) {
        $dropdownStudios[$studio->id] = $studio->username;
      }
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Models')
        ->setPageSize(10)
        ->setColumns([
          (new FieldConfig)
          ->setName('check')
          ->setLabel('<input type="checkbox" name="checklist[]" class="check-all">')
          ->setCallback(function ($val) {
              return '<input type="checkbox" name="checklist[]" class="case" value="' . $val . '">';
            })
          ->setSortable(false)
          ,
          (new FieldConfig)
          ->setName('id')
          ->setLabel('ID')
          ->setSortable(true)
          ->setSorting(Grid::SORT_ASC)
          ,
          (new FieldConfig)
          ->setName('username')
          ->setLabel('Username')
          ->setCallback(function ($val) {
              return "{$val}";
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          /* ,
         (new FieldConfig)
          ->setName('parentId')
          ->setLabel('Estudio')
          ->setCallback(function ($val) {
            if(!$val || $val === 1){
              return '';
            }
            $user = UserModel::findMe($val);
            return $user->username;
          })
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('parentId')
            ->setOptions($dropdownStudios)
          )*/
          ,
          (new FieldConfig)
          ->setName('email')
          ->setLabel('Email')
          ->setSortable(true)
          ->setCallback(function ($val) {
              $icon = '<span class="glyphicon glyphicon-envelope"></span>&nbsp;';
              return
                '<small>'
                . HTML::link("mailto:$val", $val)
                . '</small>';
            })
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ,
          (new FieldConfig)
          ->setName('tokens')
          ->setLabel('Tokens')
          ->setSortable(true)
          ,

          (new FieldConfig)
          ->setName('minPayment')
          ->setLabel('Pago mínimo')
          ->setSortable(true)
          ->setCallback(function($val){
              return $val . '€';
          })
          ,

          (new FieldConfig)
          ->setName('gender')
          ->setLabel('Género')
          ->setCallback(function($val){  
              return $this->genero($val);
          })
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('gender')
            ->setOptions(['male'=>'Hombre','female'=>'Mujer', 'transgender' => 'Transgenero','pareja' => 'Pareja'])
          )
          ,
          (new FieldConfig)
          ->setName('accountStatus')
          ->setLabel('Status')
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('accountStatus')
            ->setOptions(['active'=>'Active','suspend'=>'Suspend','notConfirmed'=>'Not Confirmed','disable'=>'Disable','waiting'=>'Pending'])
          )
          ->setCallback(function($val){
              $return = '';
              switch ($val){
                  case UserModel::ACCOUNT_ACTIVE: $return = 'Active';
                      break;
                  case UserModel::ACCOUNT_DISABLE: $return = 'Disable';
                      break;
                  case UserModel::ACCOUNT_NOTCONFIRMED: $return = 'Not Confirmed';
                      break;
                  case UserModel::ACCOUNT_SUSPEND: $return = 'Suspend';
                      break;
                  case UserModel::ACCOUNT_WAITING: $return = 'Pending';
                      break;
                  default: $return = '';
                      break;
              }
              return $return;
          }),
            (new FieldConfig)
            ->setName('suspendReason')
            ->setLabel('Razon de la suspensión')
          ,
          (new FieldConfig)
          ->setName('mobilePhone')
          ->setLabel('Teléfono')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ,
          (new FieldConfig)
          ->setName('name')
          ->setLabel('País')
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ->setSortable(true)
          ,


(new FieldConfig)
        ->setName('referral_code')
        ->setLabel('Cod. Referido')
        ->addFilter(
          (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
        )
        ->setSortable(true)
      ,

        (new FieldConfig)
        ->setName('referred_by')
        ->setLabel('Referido por')
        ->addFilter(
          (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
        )
        ->setSortable(true)
      ,


          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Creado en')
          ->setSortable(true)
          ->setCallback(function($val){
            $d = new \DateTime($val);
            return $d->format('d/m/Y');
          })
          ,
          (new FieldConfig)
          ->setName('action')
          ->setLabel('Acciones')
          ->setCallback(function ($val, $row) {
              $item = $row->getSrc();
              $url = "<a href='" . URL('admin/manager/model-profile/' . $val) . "' title='Editar cuenta'><span class='fa fa-pencil'></span></a>&nbsp;&nbsp;<a title='Borrar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres eliminar esta cuenta?')\" href='" . URL('admin/manager/profile/delete/' . $val) . "'><span class='fa fa-trash'></span></a>";
              if($item->accountStatus != UserModel::ACCOUNT_ACTIVE){
                  $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/approve/' . $val)."' title='Aprobar cuenta'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
              }
              if($item->accountStatus != UserModel::ACCOUNT_DISABLE){
                  $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/disable/' . $val) . "' title='Deshabilitar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres deshabilitar esta cuenta?')\"><span class='fa fa-ban'></span></a>";
              }
              if($item->accountStatus == UserModel::ACCOUNT_ACTIVE){
                  $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Cuenta suspendida'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
              }
              $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/image-gallery/' . $val) . "' title='Galerías de imágenes'><span class='fa fa-picture-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/video-gallery/' . $val) . "' title='Galerías de video'><span class='fa fa-video-camera'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/identification/' . $val) . "' title='Identificación del usuario'><span class='fa fa-file-text-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/model/chat/' . $val) . "' title='Administrar mensajes de chat'><span class='fa fa-comments-o' aria-hidden='true'></span></a>";
              return $url;

            })
          ->setSortable(false)
          ,
        ])
        ->setComponents([
          (new THead)
          ->setComponents([
            (new ColumnHeadersRow),
            (new FiltersRow)
            ,
            (new OneCellRow)
            ->setRenderSection(RenderableRegistry::SECTION_END)
            ->setComponents([
              (new RecordsPerPage)
              ->setVariants([
                10,
                20,
                30,
                40,
                50,
                100,
                200,
                300,
                400,
                500
              ]),
              new ColumnsHider,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('usuarios-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
              (new HtmlTag)
              ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filtrar')
              ->setTagName('button')
              ->setRenderSection(RenderableRegistry::SECTION_END)
              ->setAttributes([
                'class' => 'btn btn-success btn-sm',
                'id' => 'formFilter'
              ])
            ])
          ])
          ,
          (new TFoot)
          ->setComponents([
            (new OneCellRow)
            ->setComponents([
              new Pager,
              (new HtmlTag)
              ->setAttributes(['class' => 'pull-right'])
              ->addComponent(new ShowingRecords)
              ,
            ])
          ])
        ])
    );
    $grid = $grid->render();

    return view('Admin::model-manager', compact('grid'))->with('title', 'Lista de usuarios');
  }
  public function getModelPending(){
    $query = UserModel
      ::leftJoin('countries as c', 'users.countryId', '=', 'c.id')
      ->select('users.*', 'users.id as check', 'users.id as action')
      // Column alias 'country_name' used to avoid naming conflicts, suggest that customers table also has 'name' column.
      ->addSelect('c.name')
      ->where('users.role', UserModel::ROLE_MODEL)
      ->where('accountStatus', 'waiting')
      ->orderBy('id', 'DESC');
      $studios = UserModel::where('role', UserModel::ROLE_STUDIO)->get();
      $dropdownStudios = [];
      foreach($studios as $studio) {
        $dropdownStudios[$studio->id] = $studio->username;
      }
    $columns = [
      (new FieldConfig)
      ->setName('check')
      ->setLabel('<input type="checkbox" name="checklist[]" class="check-all">')
      ->setCallback(function ($val) {
          return '<input type="checkbox" name="checklist[]" class="case" value="' . $val . '">';
        })
      ->setSortable(false)
      ,
      (new FieldConfig)
      ->setName('id')
      ->setLabel('ID')
      ->setSortable(true)
      ->setSorting(Grid::SORT_ASC)
      ,
      (new FieldConfig)
      ->setName('username')
      ->setLabel('Username')
      ->setCallback(function ($val) {
          return "{$val}";
        })
      ->setSortable(true)
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ,
     /* (new FieldConfig)
      ->setName('parentId')
      ->setLabel('Estudio')
      ->setCallback(function ($val) {
        if(!$val || $val === 1){
          return '';
        }
        $user = UserModel::findMe($val);
        return $user->username;
      })
      ->setSortable(true)
      ->addFilter(
        (new SelectFilterConfig)
        ->setName('parentId')
        ->setOptions($dropdownStudios)
      )
      ,*/
      (new FieldConfig)
      ->setName('email')
      ->setLabel('Email')
      ->setSortable(true)
      ->setCallback(function ($val) {
          $icon = '<span class="glyphicon glyphicon-envelope"></span>&nbsp;';
          return
            '<small>'
            . HTML::link("mailto:$val", $val)
            . '</small>';
        })
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ,
      (new FieldConfig)
      ->setName('tokens')
      ->setLabel('Tokens')
      ->setSortable(true)
      ,

      (new FieldConfig)
      ->setName('minPayment')
      ->setLabel('Pago mínimo')
      ->setSortable(true)
      ->setCallback(function($val){
          return $val . '€';
      })
      ,

      (new FieldConfig)
      ->setName('gender')
      ->setLabel('Genero')
      ->setSortable(true)
      ->addFilter(
        (new SelectFilterConfig)
        ->setName('gender')
        ->setOptions(['male'=>'Male','female'=>'Female', 'transgender' => 'Transgender'])
      )
      ,
      (new FieldConfig)
      ->setName('suspendReason')
      ->setLabel('Razón de suspensión')
      ,
      (new FieldConfig)
      ->setName('mobilePhone')
      ->setLabel('Teléfono')
      ->setSortable(true)
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ,
      (new FieldConfig)
      ->setName('name')
      ->setLabel('País')
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ->setSortable(true),

      (new FieldConfig)
        ->setName('referral_code')
        ->setLabel('Cod. Referido')
        ->addFilter(
          (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
        )
        ->setSortable(true)
      ,

        (new FieldConfig)
        ->setName('referred_by')
        ->setLabel('Referido por')
        ->addFilter(
          (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
        )
        ->setSortable(true)
      ,
      
      (new FieldConfig)
      ->setName('createdAt')
      ->setLabel('reg. Fecha')
      ->setSortable(true)
      ->setCallback(function($val){
        $d = new \DateTime($val);
        return $d->format('d/m/Y');
      })
      
    ];
    $adminData = AppSession::getLoginData();
    if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) {
      $columns[] = (new FieldConfig)
      ->setName('action')
      ->setLabel('Acciones')
      ->setCallback(function ($val, $row) {
          $item = $row->getSrc();
          $url = "<a href='" . URL('admin/manager/model-profile/' . $val) . "' title='Editar cuenta'><span class='fa fa-pencil'></span></a>&nbsp;&nbsp;<a title='Borrar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres eliminar esta cuenta?')\" href='" . URL('admin/manager/profile/delete/' . $val) . "'><span class='fa fa-trash'></span></a>";
          if($item->accountStatus != UserModel::ACCOUNT_ACTIVE){
              $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/approve/' . $val)."' title='Aprobar cuenta'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
          }
          if($item->accountStatus != UserModel::ACCOUNT_DISABLE){
              $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/disable/' . $val) . "' title='Deshabilitar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres deshabilitar esta cuenta?')\"><span class='fa fa-ban'></span></a>";
          }
          if($item->accountStatus == UserModel::ACCOUNT_ACTIVE){
              $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Cuenta suspendida'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
          }
          $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/image-gallery/' . $val) . "' title='Galerías de imágenes'><span class='fa fa-picture-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/video-gallery/' . $val) . "' title='Galerías de video'><span class='fa fa-video-camera'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/identification/' . $val) . "' title='Identificación del usuario'><span class='fa fa-file-text-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/model/chat/' . $val) . "' title='Administrar mensajes de chat'><span class='fa fa-comments-o' aria-hidden='true'></span></a>";
          return $url;

        })
      ->setSortable(false);
    }
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Models')
        ->setPageSize(10)
        ->setColumns($columns)
        ->setComponents([
          (new THead)
          ->setComponents([
            (new ColumnHeadersRow),
            (new FiltersRow)
            ,
            (new OneCellRow)
            ->setRenderSection(RenderableRegistry::SECTION_END)
            ->setComponents([
              (new RecordsPerPage)
              ->setVariants([
                10,
                20,
                30,
                40,
                50,
                100,
                200,
                300,
                400,
                500
              ]),
              new ColumnsHider,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('usuarios-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
              (new HtmlTag)
              ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filtrar')
              ->setTagName('button')
              ->setRenderSection(RenderableRegistry::SECTION_END)
              ->setAttributes([
                'class' => 'btn btn-success btn-sm',
                'id' => 'formFilter'
              ])
            ])
          ])
          ,
          (new TFoot)
          ->setComponents([
            (new OneCellRow)
            ->setComponents([
              new Pager,
              (new HtmlTag)
              ->setAttributes(['class' => 'pull-right'])
              ->addComponent(new ShowingRecords)
              ,
            ])
          ])
        ])
    );
    $grid = $grid->render();

    return view('Admin::model-pending-manager', compact('grid'))->with('title', 'Lista de usuarios');
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response models
   */
  public function getModelOnline() {
    $search = (Input::has('q')) ? Input::get('q') : null;
    $page = (Input::has('page')) ? Input::get('page') : 1;
    $options = array(
      'take' => LIMIT_PER_PAGE,
      'skip' => ($page - 1) * LIMIT_PER_PAGE,
      'q' => $search,
      'filter' => (Input::has('filter')) ? Input::get('filter') : null
    );
    $users = UserModel::select('users.id', 'users.username', 'users.email', 't.lastStreamingTime', DB::raw("(SELECT COUNT(tu.id) FROM chatthreadusers as tu WHERE tu.threadId=t.id AND tu.isStreaming=1 AND tu.userId!=0) as totalWatching"), DB::raw("(SELECT COUNT(tu.id) FROM chatthreadusers as tu WHERE tu.threadId=t.id AND tu.isStreaming=1 AND tu.userId=0) as totalGuestWatching"), 't.id as roomId', 't.type as streamType')
      ->join('chatthreads as t', 't.ownerId', '=', 'users.id')
      ->where('users.role', UserModel::ROLE_MODEL)
      ->where('t.isStreaming', true);
    if ($search) {
      $users = $users->where('users.username', 'like', $search . '%');
    }
    if (isset($options['filter']) && $options['filter'] != null && in_array($options['filter'], ['username', 'email', 'status', 'createdAt', 'tokens'])) {
      $users = $users->orderBy($options['filter'], 'desc');
    }

    $users = $users->paginate(LIMIT_PER_PAGE);

    return view('Admin::model-online-manager')->with('title', 'usuario en vivo')->with('users', $users);
  }

  /**
   * get watching users
   * @param int $threadId
   * @return response
   */
  public function getWatching($threadId) {
    $watching = UserModel::select('users.id', 'users.username', 'users.email', 'tu.lastStreamingTime')
      ->join('chatthreadusers as tu', 'tu.userId', '=', 'users.id')
      ->where('tu.threadId', $threadId)
      ->paginate(LIMIT_PER_PAGE);
    return view('Admin::model-watching-manager')->with('watching', $watching);
  }

  /**
   * @return add model view
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function addModel() {
    $manager = UserModel::where('role', UserModel::ROLE_STUDIO)->where('accountStatus', UserModel::ACCOUNT_ACTIVE)->orderBy('username')->lists('username', 'id');
    $countries = CountryModel::orderBy('name')->lists('name', 'id')->all();
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
    $directDeposit = (object)[
      'depositFirstName' => '',
      'depositLastName' => '',
      'accountingEmail' => '',
      'directBankName' => '',
      'accountType' => '',
      'accountNumber' => '',
      'routingNumber' => ''
    ];
    $paxum = (object)[
      'paxumName' => '',
      'paxumEmail' => '',
      'paxumAdditionalInformation' => ''
    ];
    $bitpay = (object)[
      'bitpayName' => '',
      'bitpayEmail' => '',
      'bitpayAdditionalInformation' => ''
    ];
    return view('Admin::add-model', compact('manager', 'countries', 'bankTransferOptions', 'directDeposit', 'paxum', 'bitpay'));
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param integer $id member id
   * @return view
   */
  public function getModelProfile($id) {

    $user = UserModel::where('id', $id)
      ->where('role', UserModel::ROLE_MODEL)
      ->first();
    if (!$user)
      return redirect('admin/manager/performers')->with('msgInfo', '¡El usuario no existe!');
    $managers = UserModel::where('role', UserModel::ROLE_STUDIO)->where('accountStatus', UserModel::ACCOUNT_ACTIVE)->lists('username', 'id')->all();
    $performer = PerformerModel::where('user_id', '=', $id)->first();
    if (!$performer) {
      $performer = new PerformerModel;
      $performer->user_id = $user->id;
      $performer->sex = $user->gender;
      if (!$performer->save()) {
        return redirect('admin/manager/performers')->with('msgError', '¡Error de configuración del ejecutante!');
      }
    }
    $categories = CategoryModel::orderBy('name')->lists('name', 'id')->all();
    $countries = CountryModel::orderBy('name')->lists('name', 'id')->all();
    $cat = $user->categories->pluck('id')->toArray();

    $heightList = UserModel::getHeightList();
    $weightList = UserModel::getWeightList();
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
    $directDeposit = (object)[
      'depositFirstName' => '',
      'depositLastName' => '',
      'accountingEmail' => '',
      'directBankName' => '',
      'accountType' => '',
      'accountNumber' => '',
      'routingNumber' => ''
    ];
    $paxum = (object)[
      'paxumName' => '',
      'paxumEmail' => '',
      'paxumAdditionalInformation' => ''
    ];
    $bitpay = (object)[
      'bitpayName' => '',
      'bitpayEmail' => '',
      'bitpayAdditionalInformation' => ''
    ];
    if($user->bankTransferOptions){
      $bankTransferOptions = json_decode($user->bankTransferOptions);
    }
    if($user->directDeposit){
      $directDeposit = json_decode($user->directDeposit);
    }
    if($user->paxum){
      $paxum = json_decode($user->paxum);
    }
    if($user->bitpay){
      $bitpay = json_decode($user->bitpay);
    }
    $document = DocumentModel::where('ownerId', $id)->first();





    /*Gustos y Preferencias*/




    $gustosperson = GustosGente::where('users_id', '=', $user->id )->get();
    $preferenciaperson = PreferenciasPersonas::where('users_id', '=', $user->id )->get();
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

      if(!empty($elgusta)){

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

      if(!empty($elpreferencia)){     

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


/*fin de Gustos y Preferencias*/



    return view('Admin::model-edit')
      ->with('user', $user)->with('managers', $managers)
      ->with('categories', $categories)
      ->with('performer', $performer)
      ->with('heightList', $heightList)
      ->with('weightList', $weightList)
      ->with('countries', $countries)
      ->with('bankTransferOptions', $bankTransferOptions)
      ->with('directDeposit', $directDeposit)
      ->with('paxum', $paxum)
      ->with('bitpay', $bitpay)
      ->with('document', $document)
      ->with('cat', $cat)
      ->with('allgustos2', $allgustos2)
      ->with('allpreferencia2', $allpreferencia2);
  }

  /**
   * @param object $object model field
   * @return Response
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function updateModelProcess($id) {


    $adminData = AppSession::getLoginData();
    if (!$adminData) {
      return Redirect('admin/login')->with('msgError', 'Tu sesión expiró.');
    }
    $rules = [
      'username' => 'Required|Between:3,32|alphaNum|Unique:users,username,' . $id,
      'passwordHash' => 'Between:6,32',
      'firstName' => ['Required', 'Min:2', 'Max:32' ],
      'lastName' => ['Required', 'Min:2', 'Max:32'],
      'country' => 'Required',
      'manager' => 'Exists:users,id,role,studio',
      'tokens'    => 'Integer|Min:0',
      'tokens_ganancias'    => 'Integer|Min:0',
      //'gender'    => 'Required|in:'.UserModel::GENDER_MALE.','.UserModel::GENDER_FEMALE.','.UserModel::GENDER_TRANSGENDER,
      'gender'    => 'Required',
    /*  'age' => 'Required',*/
      /*'category' => 'required',*/
      'idImage' => 'Max:2000|Mimes:jpg,jpeg,png',
      'idImage2' => 'Max:2000|Mimes:jpg,jpeg,png',
      'faceId' => 'Max:2000|Mimes:jpg,jpeg,png',
      'releaseForm' => 'Max:2000|Mimes:doc,docx,pdf',
      'tags' => 'string',
      'stateName' => 'String|Max:100',
      'cityName' => 'String|Max:32',
      'zip' => 'String|Max:10',
      'address1' => 'String',
      'address2' => 'String',
      'mobilePhone' => 'Max:15|phone',
      'myFiles' => 'Max:2000|Mimes:jpg,jpeg,png',
       'usernameContrato' => 'Max:32',
    ];

    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    $user = UserModel::find($id);
    if (!$user)
      return redirect('/admin/manager/performers')->with('msgError', '¡El usuario no existe!');

    $userData = Input::all();
    $user->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $user->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $user->gender = $userData['gender'];
    $user->username = $userData['username'];
    $user->countryId = $userData['country']; 
    $user->location_id = $userData['country'];
    $user->parentId = Input::get('manager', 0);
    $user->tokens = intval(Input::get('tokens'));
    $user->stateName = $userData['stateName'];
    $user->cityName = $userData['cityName'];
    $user->zip = $userData['zip'];
    $user->address1 = $userData['address1'];
    $user->address2 = $userData['address2'];
    $user->mobilePhone = $userData['mobilePhone'];
    $user->tokens = $userData['tokens'];
    //$user->tokens_ganacias = $userData['tokens_ganancias'];


    $user->elfisionomia       = preg_replace('/\s+/', ' ',  Input::get('fionomia'));
    $user->ellafionomia       = preg_replace('/\s+/', ' ',  Input::get('fionomiaellla'));
    $user->eletnia            = preg_replace('/\s+/', ' ',  Input::get('ethnicity'));
    $user->ellaetnia          = preg_replace('/\s+/', ' ',  Input::get('ethnicityellla'));
    $user->elcm               = preg_replace('/\s+/', ' ',  Input::get('height'));
    $user->ellacm             = preg_replace('/\s+/', ' ',  Input::get('heightellla'));


      if (Input::has('experiencias')) {
        $user->experiencias = $userData['experiencias'];
      }

      if (Input::has('tokens_ganancias')) {

        $tokens_ganancias = $userData['tokens_ganancias'];



              if($tokens_ganancias>0){
             $payment = new PaymentTokensModel;
              $payment->ownerId = 1;
              $payment->item = 'tip';
              $payment->itemId = 2;
              $payment->modelId = $id;
              $payment->tokens = $tokens_ganancias;
              $payment->status = 'approved';
              $payment->modelCommission = 100;
              $payment->afterModelCommission = $tokens_ganancias;
              $payment->nocontab = 1;
            if ($payment->save()) { 
                    $earning = new EarningModel;
                    $earning->item = 'tip';
                    $earning->itemId = $payment->id;
                    $earning->payFrom = 1;
                    $earning->payTo = $id;
                    $earning->tokens =  $tokens_ganancias;
                    $earning->percent = 100;
                    $earning->type = EarningModel::PERFORMERSITEMEMBER;
                    $earning->save();    
            }
      }






      }



    
    $user->autoApprovePayment = (isset($userData['autoApprovePayment'])) ? $userData['autoApprovePayment'] : null;
    if(Input::get('manager', 0)) {
      $earningSettingModel = EarningSettingModel::where('userId', $user->id)->first();
      $earninSettingStudio = EarningSettingModel::where('userId', Input::get('manager', 0))->first();     
      if($earningSettingModel->referredMember > $earninSettingStudio->referredMember) {
        $earningSettingModel->referredMember = $earninSettingStudio->referredMember;
        $earningSettingModel->save();
      }  
    }
    if (Input::has('passwordHash') && !empty($userData['passwordHash'])) {
      $user->passwordHash = md5($userData['passwordHash']);
    }
    
    if(Input::get('isRemovedAvatar')) {
      $user->avatar = null;
       $user->smallAvatar = null;
    }
    if ($user->save()) {







      $identityDocument = DocumentModel::where('ownerId', $user->id)->first();
      if(!$identityDocument){
        $identityDocument = new DocumentModel;
        $identityDocument->ownerId = $user->id;
      }
      if(Input::get('deleteImg')){
        foreach (Input::get('deleteImg') as $value){
            if (file_exists(PUBLIC_PATH . '/' . $identityDocument->$value)) {
                \File::Delete(PUBLIC_PATH . '/' . $identityDocument->$value);
            }
            $identityDocument->$value = null;
        }
      }
      $destinationPath = 'uploads/models/identity/';
      if (Input::file('idImage')) {
        if (!Input::file('idImage')->isValid()) {
          return Back()->with('msgInfo', 'el archivo cargado no es válido');
        }
        $image = Input::file('idImage');
        $filename = $user->username . uniqid() .'.' . $image->getClientOriginalExtension();
        $idPath = $destinationPath . 'id-images/' . $filename;
        Input::file('idImage')->move($destinationPath . 'id-images', $filename);
        $identityDocument->idImage = $idPath;
      }

       if (Input::file('idImage2')) {
        if (!Input::file('idImage2')->isValid()) {
          return Back()->with('msgInfo', 'el archivo cargado no es válido');
        }
        $image = Input::file('idImage2');
        $filename = $user->username . uniqid() .'.' . $image->getClientOriginalExtension();
        $idPath = $destinationPath . 'id-images2/' . $filename;
        Input::file('idImage2')->move($destinationPath . 'id-images2', $filename);
        $identityDocument->idImage2 = $idPath;
      }
      if (Input::file('faceId')) {
        if (!Input::file('faceId')->isValid()) {
          return Back()->with('msgInfo', 'el archivo cargado no es válido');
        }
        $image = Input::file('faceId');
        $filename = $user->username. uniqid()  . '.' . $image->getClientOriginalExtension();
        $faceId = $destinationPath . 'face-ids/' . $filename;
        Input::file('faceId')->move($destinationPath . 'face-ids', $filename);
        $identityDocument->faceId = $faceId;
      }
      if (Input::file('releaseForm')) {
        if (!Input::file('releaseForm')->isValid()) {
          return Back()->with('msgInfo', 'el archivo cargado no es válido');
        }
        $image = Input::file('releaseForm');
        $filename = $user->username. uniqid()  . '.' . $image->getClientOriginalExtension();
        $releaseForm = $destinationPath . 'release-forms/' . $filename;
        Input::file('releaseForm')->move($destinationPath . 'release-forms', $filename);
        $identityDocument->releaseForm = $releaseForm;
      }

            $identityDocument->usernameContrato = Input::get('usernameContrato');
      $identityDocument->fechaNacimientoContrato = Input::get('fechaNacimientoContrato');
      $identityDocument->fechaFirmaContrato = Input::get('fechaFirmaContrato');
      $identityDocument->save();

      $performer = PerformerModel::where('user_id', '=', $id)->first();
      if (!$performer) {
        $performer = new PerformerModel;
      }
      if (Input::has('category')) {
         $user->categories()->sync(Input::get('category'));
      }

     
      $performer->sex = $userData['gender'];
     // $performer->sexualPreference = $userData['sexualPreference'];

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

      // $performer->category_id = $userData['category'];




      if (Input::has('pubic')) {
        $performer->pubic = $userData['pubic'];
      }
        $performer->age = Input::get('age');
        $performer->agellla = Input::get('agellla');

      $performer->tags = Input::get('tags');

      if (Input::has('eyes_ella')) {
        $performer->eyes_ella = $userData['eyes_ella'];
      }

      if (Input::has('hair_ella')) {
        $performer->hair_ella = $userData['hair_ella'];
      }

      if (Input::has('weight_ella')) {
        $performer->weight_ella = $userData['weight_ella'];
      }

          if (Input::has('pubic_ella')) {
        $performer->pubic_ella = $userData['pubic_ella'];
      }

      if ($performer->save()) {

          PerformerTag::updateTags($performer->id, $performer->tags);


/*guardando preferencias y gustos*/




$gustose = GustosGente::where('users_id', '=', $user->id)->get();


GustosGente::where( 'users_id', $user->id )->delete();

//aqui1

$contente = array();  
$contente[0] = UserController::guardarextras(Input::get('22'),$user->id,'GUSTOS');
$contente[1] = UserController::guardarextras(Input::get('BDSM'),$user->id,'GUSTOS');
$contente[2] = UserController::guardarextras(Input::get('Candaulismo'),$user->id,'GUSTOS');
$contente[3] = UserController::guardarextras(Input::get('Chat'),$user->id,'GUSTOS');
$contente[4] = UserController::guardarextras(Input::get('Dúo'),$user->id,'GUSTOS');
$contente[5] = UserController::guardarextras(Input::get('Exhibición'),$user->id,'GUSTOS');
$contente[6] = UserController::guardarextras(Input::get('Extremo'),$user->id,'GUSTOS');
$contente[7] = UserController::guardarextras(Input::get('Fetichismo'),$user->id,'GUSTOS');
$contente[8] = UserController::guardarextras(Input::get('Fotos'),$user->id,'GUSTOS');
$contente[9] = UserController::guardarextras(Input::get('Gangbang'),$user->id,'GUSTOS');  
$contente[10] = UserController::guardarextras(Input::get('Hard'),$user->id,'GUSTOS');
$contente[11] = UserController::guardarextras(Input::get('Intercambiocompleto'),$user->id,'GUSTOS');
$contente[12] = UserController::guardarextras(Input::get('Intercambiosuave'),$user->id,'GUSTOS');
$contente[13] = UserController::guardarextras(Input::get('Juegosderol'),$user->id,'GUSTOS');
$contente[14] = UserController::guardarextras(Input::get('Lives'),$user->id,'GUSTOS');
$contente[15] = UserController::guardarextras(Input::get('Mimitos'),$user->id,'GUSTOS');
$contente[16] = UserController::guardarextras(Input::get('Sensación'),$user->id,'GUSTOS');
$contente[17] = UserController::guardarextras(Input::get('Sincontactofisico'),$user->id,'GUSTOS');
$contente[18] = UserController::guardarextras(Input::get('Suave'),$user->id,'GUSTOS');
$contente[19] = UserController::guardarextras(Input::get('Trio'),$user->id,'GUSTOS');
$contente[20] = UserController::guardarextras(Input::get('Videos'),$user->id,'GUSTOS');
$contente[21] = UserController::guardarextras(Input::get('Voyerismo'),$user->id,'GUSTOS');
  


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
$contente[0] = UserController::guardarextras(Input::get('Mujerhetero'),$user->id,'Preferencias');
$contente[1] = UserController::guardarextras(Input::get('MujerBi'),$user->id,'Preferencias');
$contente[2] = UserController::guardarextras(Input::get('Lesbiana'),$user->id,'Preferencias');
$contente[3] = UserController::guardarextras(Input::get('Hombrehetero'),$user->id,'Preferencias');
$contente[4] = UserController::guardarextras(Input::get('HombreBi'),$user->id,'Preferencias');
$contente[5] = UserController::guardarextras(Input::get('Gay'),$user->id,'Preferencias');
$contente[6] = UserController::guardarextras(Input::get('Parejahetero'),$user->id,'Preferencias');
$contente[7] = UserController::guardarextras(Input::get('ParejaHBi'),$user->id,'Preferencias');
$contente[8] = UserController::guardarextras(Input::get('ParejaMBi'),$user->id,'Preferencias');
$contente[9] = UserController::guardarextras(Input::get('ParejaBi'),$user->id,'Preferencias');  
$contente[10] = UserController::guardarextras(Input::get('CrossDresser'),$user->id,'Preferencias');
$contente[11] = UserController::guardarextras(Input::get('Transexual'),$user->id,'Preferencias');
  


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


/*fin de guardando preferencias y gustos*/

      }

      if ($performer->save()) {
        UserController::postPayeeInfo($user->id, Input::all());
        UserController::postDirectDeposit($user->id, Input::all());
        UserController::postPaxum($user->id, Input::all());
        UserController::postBitpay($user->id, Input::all());
        if(Input::file('myFiles')) {
          $uploadResponse = MediaHelper::upload($user, Input::file('myFiles'), 'profile', 0, $user->id);
          if($uploadResponse['success']){
            $setProfileResponse = MediaHelper::setProfileImage($user, $uploadResponse['file']->id);  
          }
        }
        return back()->with('msgInfo', '¡El usuario se actualizó correctamente!');
      }
    }
    return Back()->withInput()->with('msgError', 'Error del sistema.');
  }



  /**
   * @param object $object model field
   * @return Response
   * @author Phong Le <pt.hongphong@gmail.com>
   */



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



/**
   * @param object $object model field
   * @return Response
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function addModelProcess() {


    $adminData = AppSession::getLoginData();
    if (!$adminData) {
      return Redirect('admin/login')->with('msgError', 'Tu sesión expiró.');
    }
    $validator = Validator::make(Input::all(), [
        'username' => 'unique:users|Between:3,64|required',
        'email' => 'Required|Between:3,64|Email|Unique:users',
        'firstName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
        'lastName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
        'passwordHash' => 'Required|AlphaNum|Between:6,32|Confirmed',
        'passwordHash_confirmation' => 'Required|AlphaNum|Between:6,32',
        'country' => 'Required',
        'gender'    => 'Required|In:'.UserModel::GENDER_MALE.','.UserModel::GENDER_FEMALE.','.UserModel::GENDER_TRANSGENDER,
        'manager' => 'Exists:users,id,role,studio',
        'idImage' => 'Max:2000|Mimes:jpg,jpeg,png',
        'idImage2' => 'Max:2000|Mimes:jpg,jpeg,png',
        'faceId' => 'Max:2000|Mimes:jpg,jpeg,png',
        'releaseForm' => 'Max:2000|Mimes:doc,docx,pdf',
        'stateName' => 'Required|String|Max:100',
        'cityName' => 'Required|String|Max:32',
        'zip' => 'Required|String|Max:10',
        'address1' => 'Required|String',
        'address2' => 'String',
        'mobilePhone' => 'Required|Max:15|phone',
        'myFiles' => 'Max:2000|Mimes:jpg,jpeg,png'
    ]);
    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
//    var_dump($validator->passes());
//    die();
    $userData = Input::all();

    $newMember = new UserModel ();
    $newMember->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $newMember->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $newMember->gender = (Input::has('gender')) ? $userData['gender'] : null;
    $newMember->username = $userData['username'];
    $newMember->email = $userData['email'];
    $newMember->passwordHash = md5($userData['passwordHash']);
    $newMember->countryId = (Input::has('country')) ? $userData['country'] : 0;
    $newMember->emailVerified = 1;
    $newMember->accountStatus = UserModel::ACCOUNT_ACTIVE;
    $newMember->parentId = (Input::has('manager')) ? $userData['manager'] : $adminData->id;
    $newMember->role = UserModel::ROLE_MODEL;
    $newMember->stateName = $userData['stateName'];
    $newMember->cityName = $userData['cityName'];
    $newMember->zip = $userData['zip'];
    $newMember->address1 = $userData['address1'];
    $newMember->address2 = $userData['address2'];
    $newMember->mobilePhone = $userData['mobilePhone'];
    $newMember->autoApprovePayment = (isset($userData['autoApprovePayment'])) ? $userData['autoApprovePayment'] : null;

    if ($newMember->save()) {

      UserModel::where( 'id', $newMember->id )
                ->update(['guid' => $newMember->id ] );

      \Event::fire(new AddModelPerformerChatEvent($newMember));
      \Event::fire(new AddModelScheduleEvent($newMember));
      \Event::fire(new AddEarningSettingEvent($newMember));
      \Event::fire(new AddModelPerformerEvent($newMember));
      \Event::fire(new MakeChatRoomEvent($newMember));

      // upload model's documents
      if(Input::file('idImage') || Input::file('faceId') || Input::file('releaseForm')){
        $identityDocument = new DocumentModel;
        $identityDocument->ownerId = $newMember->id;
        $destinationPath = 'uploads/models/identity/';
        if (Input::file('idImage')) {
          if (!Input::file('idImage')->isValid()) {
            return Back()->with('msgInfo', 'el archivo cargado no es válido');
          }
          $image = Input::file('idImage');
          $filename = $newMember->username . '.' . $image->getClientOriginalExtension();
          $idPath = $destinationPath . 'id-images/' . $filename;
          Input::file('idImage')->move($destinationPath . 'id-images', $filename);
          $identityDocument->idImage = $idPath;
        }

          if (Input::file('idImage2')) {
          if (!Input::file('idImage2')->isValid()) {
            return Back()->with('msgInfo', 'el archivo cargado no es válido');
          }
          $image = Input::file('idImage2');
          $filename = $newMember->username . '.' . $image->getClientOriginalExtension();
          $idPath = $destinationPath . 'id-images2/' . $filename;
          Input::file('idImage2')->move($destinationPath . 'id-images2', $filename);
          $identityDocument->idImage2 = $idPath;
        }

        if (Input::file('faceId')) {
          if (!Input::file('faceId')->isValid()) {
            return Back()->with('msgInfo', 'el archivo cargado no es válido');
          }
          $image = Input::file('faceId');
          $filename = $newMember->username . '.' . $image->getClientOriginalExtension();
          $faceId = $destinationPath . 'face-ids/' . $filename;
          Input::file('faceId')->move($destinationPath . 'face-ids', $filename);
          $identityDocument->faceId = $faceId;
        }
        if (Input::file('releaseForm')) {
          if (!Input::file('releaseForm')->isValid()) {
            return Back()->with('msgInfo', 'el archivo cargado no es válido');
          }
          $image = Input::file('releaseForm');
          $filename = $newMember->username . '.' . $image->getClientOriginalExtension();
          $releaseForm = $destinationPath . 'release-forms/' . $filename;
          Input::file('releaseForm')->move($destinationPath . 'release-forms', $filename);
          $identityDocument->releaseForm = $releaseForm;
        }
        $identityDocument->save();
      }
      UserController::postPayeeInfo($newMember->id, Input::all());
      UserController::postDirectDeposit($newMember->id, Input::all());
      UserController::postPaxum($newMember->id, Input::all());
      UserController::postBitpay($newMember->id, Input::all());
      if(Input::file('myFiles')) {
        $uploadResponse = MediaHelper::upload($newMember, Input::file('myFiles'), 'profile', 0, $newMember->id);
        if($uploadResponse['success']){
          $setProfileResponse = MediaHelper::setProfileImage($newMember, $uploadResponse['file']->id);  
        }
      }
      return redirect('admin/manager/performers')->with('msgInfo', '¡El usuario fue creado con éxito!');
    } else {
      return Back()->withInput()->with('msgError', 'Error del sistema.');
    }
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response models
   */
  public function getStudioUsers($role = 'studio') {
    $query = UserModel
      ::leftJoin('countries as c', 'users.countryId', '=', 'c.id')
      ->select('users.*', 'users.id as check', 'users.id as action')
      // Column alias 'country_name' used to avoid naming conflicts, suggest that customers table also has 'name' column.
      ->addSelect('c.name')

      ->where('users.role', UserModel::ROLE_STUDIO);
    $columns = [
      (new FieldConfig)
      ->setName('check')
      ->setLabel('<input type="checkbox" name="checklist[]" class="check-all">')
      ->setCallback(function ($val) {
          return '<input type="checkbox" name="checklist[]" class="case" value="' . $val . '">';
        })
      ->setSortable(false)
      ,
      (new FieldConfig)
      ->setName('id')
      ->setLabel('ID')
      ->setSortable(true)
      ->setSorting(Grid::SORT_ASC)
      ,
      (new FieldConfig)
      ->setName('username')
      ->setLabel('Username')
      ->setCallback(function ($val) {
          return "{$val}";
        })
      ->setSortable(true)
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ,
      (new FieldConfig)
      ->setName('email')
      ->setLabel('Email')
      ->setSortable(true)
      ->setCallback(function ($val) {
          $icon = '<span class="glyphicon glyphicon-envelope"></span>&nbsp;';
          return
            '<small>'
            . HTML::link("mailto:$val", $val)
            . '</small>';
        })
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ,
      (new FieldConfig)
      ->setName('tokens')
      ->setLabel('Tokens')
      ->setSortable(true)

      ,

      (new FieldConfig)
      ->setName('minPayment')
      ->setLabel('Pago mínimo')
      ->setSortable(true)
      ->setCallback(function($val){
          return $val . '€';
      })
      ,
      (new FieldConfig)
      ->setName('gender')
      ->setLabel('Género')
      ->setCallback(function($val){  
              return $this->genero($val);
          })
      ->setSortable(true)
      ->addFilter(
        (new SelectFilterConfig)
        ->setName('gender')
          ->setOptions(['male'=>'Hombre','female'=>'Mujer', 'transgender' => 'Transgenero','pareja' => 'Pareja'])
      )
      ,
      (new FieldConfig)
      ->setName('accountStatus')
      ->setLabel('Status')
      ->setSortable(true)
      ->addFilter(
        (new SelectFilterConfig)
        ->setName('accountStatus')
        ->setOptions(['active'=>'Active','suspend'=>'Suspend','notConfirmed'=>'Not Confirmed','disable'=>'Disable','waiting'=>'Pending'])
      )
      ->setCallback(function($val){
          $return = '';
          switch ($val){
              case UserModel::ACCOUNT_ACTIVE: $return = 'Active';
                  break;
              case UserModel::ACCOUNT_DISABLE: $return = 'Disable';
                  break;
              case UserModel::ACCOUNT_NOTCONFIRMED: $return = 'Not Confirmed';
                  break;
              case UserModel::ACCOUNT_SUSPEND: $return = 'Suspend';
                  break;
              case UserModel::ACCOUNT_WAITING: $return = 'Pending';
                  break;
              default: $return = '';
                  break;
          }
          return $return;
      }),
      (new FieldConfig)
      ->setName('mobilePhone')
      ->setLabel('Teléfono')
      ->setSortable(true)
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ,
      (new FieldConfig)
      ->setName('name')
      ->setLabel('País')
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ->setSortable(true)
      ,
      (new FieldConfig)
      ->setName('createdAt')
      ->setLabel('reg. Fecha')
      ->setSortable(true)
      ->setCallback(function($val){
        $d = new \DateTime($val);
        return $d->format('d/m/Y');
      })
    ];
    $adminData = AppSession::getLoginData();
    if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) {
      $columns[] = (new FieldConfig)
      ->setName('action')
      ->setLabel('Acciones')
      ->setCallback(function ($val, $row) {
           $item = $row->getSrc();
          $url = "<a title='Editar cuenta' href='" . URL('admin/manager/studio-profile/' . $val) . "'><span class='fa fa-pencil'></span></a>&nbsp;&nbsp;<a title='Borrar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres eliminar esta cuenta?')\" href='" . URL('admin/manager/profile/delete/' . $val) . "'><span class='fa fa-trash'></span></a>";
          if($item->accountStatus != UserModel::ACCOUNT_ACTIVE){
              $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/approve/' . $val)."' title='Aprobar cuenta'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
          }
          if($item->accountStatus != UserModel::ACCOUNT_DISABLE){
              $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/disable/' . $val) . "' title='Deshabilitar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres deshabilitar esta cuenta?')\"><span class='fa fa-ban'></span></a>";
          }
          if($item->accountStatus == UserModel::ACCOUNT_ACTIVE){
              $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Cuenta suspendida'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
          }
          return $url;
        })
      ->setSortable(false);
    }
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Models')
        ->setPageSize(10)
        ->setColumns($columns)
        ->setComponents([
          (new THead)
          ->setComponents([
            (new ColumnHeadersRow),
            (new FiltersRow)
            ,
            (new OneCellRow)
            ->setRenderSection(RenderableRegistry::SECTION_END)
            ->setComponents([
              (new RecordsPerPage)
              ->setVariants([
                10,
                20,
                30,
                40,
                50,
                100,
                200,
                300,
                400,
                500
              ]),
              new ColumnsHider,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('Studio-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
              (new HtmlTag)
              ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filtrar')
              ->setTagName('button')
              ->setRenderSection(RenderableRegistry::SECTION_END)
              ->setAttributes([
                'class' => 'btn btn-success btn-sm',
                'id' => 'formFilter'
              ])
            ])
          ])
          ,
          (new TFoot)
          ->setComponents([
            (new OneCellRow)
            ->setComponents([
              new Pager,
              (new HtmlTag)
              ->setAttributes(['class' => 'pull-right'])
              ->addComponent(new ShowingRecords)
              ,
            ])
          ])
        ])
    );
        $grid = $grid->render();


    return view('Admin::studio-manager', compact('grid'));
  }

  public function getStudioPending($role = 'studio') {
    $query = UserModel
      ::leftJoin('countries as c', 'users.countryId', '=', 'c.id')
      ->select('users.*', 'users.id as check', 'users.id as action')
      // Column alias 'country_name' used to avoid naming conflicts, suggest that customers table also has 'name' column.
      ->addSelect('c.name')
      ->where('users.role', UserModel::ROLE_STUDIO)
      ->where('accountStatus', 'waiting');
    $columns = [
      (new FieldConfig)
      ->setName('check')
      ->setLabel('<input type="checkbox" name="checklist[]" class="check-all">')
      ->setCallback(function ($val) {
          return '<input type="checkbox" name="checklist[]" class="case" value="' . $val . '">';
        })
      ->setSortable(false)
      ,
      (new FieldConfig)
      ->setName('id')
      ->setLabel('ID')
      ->setSortable(true)
      ->setSorting(Grid::SORT_ASC)
      ,
      (new FieldConfig)
      ->setName('username')
      ->setLabel('Username')
      ->setCallback(function ($val) {
          return "{$val}";
        })
      ->setSortable(true)
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ,
      (new FieldConfig)
      ->setName('email')
      ->setLabel('Email')
      ->setSortable(true)
      ->setCallback(function ($val) {
          $icon = '<span class="glyphicon glyphicon-envelope"></span>&nbsp;';
          return
            '<small>'
            . HTML::link("mailto:$val", $val)
            . '</small>';
        })
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ,
      (new FieldConfig)
      ->setName('tokens')
      ->setLabel('Tokens')
      ->setSortable(true)

      ,

      (new FieldConfig)
      ->setName('minPayment')
      ->setLabel('Pago mínimo')
      ->setSortable(true)
      ->setCallback(function($val){
          return $val . '€';
      })
      ,
      (new FieldConfig)
      ->setName('gender')
      ->setLabel('Género')
      ->setCallback(function($val){  
              return $this->genero($val);
          })
      ->setSortable(true)
      ->addFilter(
        (new SelectFilterConfig)
        ->setName('gender')
           ->setOptions(['male'=>'Hombre','female'=>'Mujer', 'transgender' => 'Transgenero','pareja' => 'Pareja'])
      )
      ,
      (new FieldConfig)
      ->setName('mobilePhone')
      ->setLabel('Teléfono')
      ->setSortable(true)
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ,
      (new FieldConfig)
      ->setName('name')
      ->setLabel('País')
      ->addFilter(
        (new FilterConfig)
        ->setOperator(FilterConfig::OPERATOR_LIKE)
      )
      ->setSortable(true)
      ,
      (new FieldConfig)
      ->setName('createdAt')
      ->setLabel('reg. Fecha')
      ->setSortable(true)
      ->setCallback(function($val){
        $d = new \DateTime($val);
        return $d->format('d/m/Y');
      })
    ];
    $adminData = AppSession::getLoginData();
    if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) {
      $columns[] = (new FieldConfig)
      ->setName('action')
      ->setLabel('Acciones')
      ->setCallback(function ($val, $row) {
           $item = $row->getSrc();
          $url = "<a title='Editar cuenta' href='" . URL('admin/manager/studio-profile/' . $val) . "'><span class='fa fa-pencil'></span></a>&nbsp;&nbsp;<a title='Borrar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres eliminar esta cuenta?')\" href='" . URL('admin/manager/profile/delete/' . $val) . "'><span class='fa fa-trash'></span></a>";
          if($item->accountStatus != UserModel::ACCOUNT_ACTIVE){
              $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/approve/' . $val)."' title='Aprobar cuenta'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
          }
          if($item->accountStatus != UserModel::ACCOUNT_DISABLE){
              $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/disable/' . $val) . "' title='Deshabilitar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres deshabilitar esta cuenta?')\"><span class='fa fa-ban'></span></a>";
          }
          if($item->accountStatus == UserModel::ACCOUNT_ACTIVE){
              $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Cuenta suspendida'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
          }
          return $url;
        })
      ->setSortable(false);
    }
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Models')
        ->setPageSize(10)
        ->setColumns([
          (new FieldConfig)
          ->setName('check')
          ->setLabel('<input type="checkbox" name="checklist[]" class="check-all">')
          ->setCallback(function ($val) {
              return '<input type="checkbox" name="checklist[]" class="case" value="' . $val . '">';
            })
          ->setSortable(false)
          ,
          (new FieldConfig)
          ->setName('id')
          ->setLabel('ID')
          ->setSortable(true)
          ->setSorting(Grid::SORT_ASC)
          ,
          (new FieldConfig)
          ->setName('username')
          ->setLabel('Username')
          ->setCallback(function ($val) {
              return "{$val}";
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ,
          (new FieldConfig)
          ->setName('email')
          ->setLabel('Email')
          ->setSortable(true)
          ->setCallback(function ($val) {
              $icon = '<span class="glyphicon glyphicon-envelope"></span>&nbsp;';
              return
                '<small>'
                . HTML::link("mailto:$val", $val)
                . '</small>';
            })
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ,
          (new FieldConfig)
          ->setName('tokens')
          ->setLabel('Tokens')
          ->setSortable(true)

          ,

          (new FieldConfig)
          ->setName('minPayment')
          ->setLabel('Pago mínimo')
          ->setSortable(true)
          ->setCallback(function($val){
              return $val . '€';
          })
          ,
          (new FieldConfig)
          ->setName('gender')
          ->setLabel('Género')
          ->setCallback(function($val){  
              return $this->genero($val);
          })
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('gender')
               ->setOptions(['male'=>'Hombre','female'=>'Mujer', 'transgender' => 'Transgenero','pareja' => 'Pareja'])
          )
          ,
          (new FieldConfig)
          ->setName('mobilePhone')
          ->setLabel('Teléfono')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ,
          (new FieldConfig)
          ->setName('name')
          ->setLabel('País')
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('reg. Fecha')
          ->setSortable(true)
          ->setCallback(function($val){
            $d = new \DateTime($val);
            return $d->format('d/m/Y');
          })
          ,
          (new FieldConfig)
          ->setName('action')
          ->setLabel('Actions')
          ->setCallback(function ($val, $row) {
               $item = $row->getSrc();
              $url = "<a title='Editar cuenta' href='" . URL('admin/manager/studio-profile/' . $val) . "'><span class='fa fa-pencil'></span></a>&nbsp;&nbsp;<a title='Borrar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres eliminar esta cuenta?')\" href='" . URL('admin/manager/profile/delete/' . $val) . "'><span class='fa fa-trash'></span></a>";
              if($item->accountStatus != UserModel::ACCOUNT_ACTIVE){
                  $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/approve/' . $val)."' title='Aprobar cuenta'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
              }
              if($item->accountStatus != UserModel::ACCOUNT_DISABLE){
                  $url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/disable/' . $val) . "' title='Deshabilitar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres deshabilitar esta cuenta?')\"><span class='fa fa-ban'></span></a>";
              }
              if($item->accountStatus == UserModel::ACCOUNT_ACTIVE){
                  $url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Cuenta suspendida'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
              }
              return $url;
            })
          ->setSortable(false)
          ,
        ])
        ->setComponents([
          (new THead)
          ->setComponents([
            (new ColumnHeadersRow),
            (new FiltersRow)
            ,
            (new OneCellRow)
            ->setRenderSection(RenderableRegistry::SECTION_END)
            ->setComponents([
              (new RecordsPerPage)
              ->setVariants([
                10,
                20,
                30,
                40,
                50,
                100,
                200,
                300,
                400,
                500
              ]),
              new ColumnsHider,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('Studio-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
              (new HtmlTag)
              ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filtrar')
              ->setTagName('button')
              ->setRenderSection(RenderableRegistry::SECTION_END)
              ->setAttributes([
                'class' => 'btn btn-success btn-sm',
                'id' => 'formFilter'
              ])
            ])
          ])
          ,
          (new TFoot)
          ->setComponents([
            (new OneCellRow)
            ->setComponents([
              new Pager,
              (new HtmlTag)
              ->setAttributes(['class' => 'pull-right'])
              ->addComponent(new ShowingRecords)
              ,
            ])
          ])
        ])
    );
        $grid = $grid->render();


    return view('Admin::studio-manager-pending', compact('grid'));
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response list categories
   */
  public function getPerformerCategories() {
    return view('Admin::category-manager');
  }

  /**
   * @return view add studio view
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function addStudio() {
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
    $directDeposit = (object)[
      'depositFirstName' => '',
      'depositLastName' => '',
      'accountingEmail' => '',
      'directBankName' => '',
      'accountType' => '',
      'accountNumber' => '',
      'routingNumber' => ''
    ];
    $paxum = (object)[
      'paxumName' => '',
      'paxumEmail' => '',
      'paxumAdditionalInformation' => ''
    ];
    $bitpay = (object)[
      'bitpayName' => '',
      'bitpayEmail' => '',
      'bitpayAdditionalInformation' => ''
    ];
    return view('Admin::add-studio', compact('bankTransferOptions', 'directDeposit', 'paxum', 'bitpay'));
  }

  /**
   * @return view add member view
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function addStudioProcess() {
    $admin = AppSession::getLoginData();
    if (!$admin) {
      return Redirect('/admin/login')->with('msgError', 'Tu sesión expiró');
    }
    $messages = array(
      'studioProff.max' => 'El archivo no puede tener más de 2000 kilobytes',
      'studioProff.mimes' => 'El archivo debe ser un archivo de tipo: doc, docx, pdf'
    );
    $validator = Validator::make(Input::all(), [
        'username' => 'unique:users|Between:3,32|required',
        'email' => 'Required|Between:3,64|Email|Unique:users',
        'studioName' => ['Required', 'Min:2', 'Max:32'],
        'passwordHash' => 'Required|AlphaNum|Between:6,32|Confirmed',
        'passwordHash_confirmation' => 'Required|AlphaNum|Between:6,32',
        // 'gender'    => 'in:'.UserModel::GENDER_MALE.','.UserModel::GENDER_FEMALE.','.UserModel::GENDER_TRANSGENDER,
        'studioProff' => 'Max:2000|Mimes:doc,docx,pdf',
    ], $messages);

    if ($validator->fails()) {
      return back()
          ->withErrors($validator)
          ->withInput();
    }
    if (Input::file('studioProff')) {
       if (!Input::file('studioProff')->isValid()) {
           return Back()->with('msgInfo', 'el archivo cargado no es válido');
       }
    }
    $userData = Input::all();

    $newMember = new UserModel ();
    $newMember->studioName = preg_replace('/\s+/', ' ',  Input::get('studioName'));
    if (Input::has('gender') && !empty($userData['gender'])) {
      $newMember->gender = $userData['gender'];
    }
    $newMember->username = $userData['username'];
    $newMember->email = $userData['email'];
    $newMember->passwordHash = md5($userData['passwordHash']);

    $newMember->emailVerified = 1;
    $newMember->accountStatus = UserModel::ACCOUNT_ACTIVE;
    $newMember->role = UserModel::ROLE_STUDIO;
    $newMember->parentId = $admin->id;
    if ($newMember->save()) {
        if (Input::file('studioProff')) {
            $identityDocument = new DocumentModel;
            $identityDocument->ownerId = $newMember->id;
            $destinationPath = 'uploads/studios/proff/';
            $image = Input::file('studioProff');
            $filename = $newMember->username . '.' . $image->getClientOriginalExtension();
            $studioProff = $destinationPath . $filename;
            Input::file('studioProff')->move($destinationPath, $filename);
            $identityDocument->studioProff = $studioProff;
            $identityDocument->save();
        }
      \Event::fire(new AddEarningSettingEvent($newMember));
      UserController::postPayeeInfo($newMember->id, Input::all());
      UserController::postDirectDeposit($newMember->id, Input::all());
      UserController::postPaxum($newMember->id, Input::all());
      UserController::postBitpay($newMember->id, Input::all());
      return redirect('admin/manager/studio-profile/'.$newMember->id)->with('msgInfo', '¡Studio fue creado con éxito!');
    } else {
      return redirect()->back()->withInput()->with('msgError', 'Error del sistema.');
    }
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param integer $id member id
   * @return view
   */
  public function getStudioProfile($id) {
    $user = UserModel::where('id', $id)
      ->where('role', USerModel::ROLE_STUDIO)
      ->first();
    if (!$user){
      return redirect('admin/manager/performerstudios')->with('msgInfo', '¡No existe ese usuario!');
    }
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
    $directDeposit = (object)[
      'depositFirstName' => '',
      'depositLastName' => '',
      'accountingEmail' => '',
      'directBankName' => '',
      'accountType' => '',
      'accountNumber' => '',
      'routingNumber' => ''
    ];
    $paxum = (object)[
      'paxumName' => '',
      'paxumEmail' => '',
      'paxumAdditionalInformation' => ''
    ];
    $bitpay = (object)[
      'bitpayName' => '',
      'bitpayEmail' => '',
      'bitpayAdditionalInformation' => ''
    ];
    if($user->bankTransferOptions){
      $bankTransferOptions = json_decode($user->bankTransferOptions);
    }
    if($user->directDeposit){
      $directDeposit = json_decode($user->directDeposit);
    }
    if($user->paxum){
      $paxum = json_decode($user->paxum);
    }
    if($user->bitpay){
      $bitpay = json_decode($user->bitpay);
    }
    $document = DocumentModel::where('ownerId', $id)->first();
    return view('Admin::studio-edit')->with('user', $user)->with('bankTransferOptions', $bankTransferOptions)->with('directDeposit', $directDeposit)->with('paxum', $paxum)->with('bitpay', $bitpay)->with('document', $document);
  }

  /**
   * @return view member view
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function updateStudioProcess($id) {
    $messages = array(
      'studioProff.max' => 'El archivo no puede tener más de 2000 kilobytes',
      'studioProff.mimes' => 'El archivo debe ser un archivo de tipo: doc, docx, pdf'
    );
    $validator = Validator::make(Input::all(), [
        'username' => 'Required|Between:3,32|alphaNum|Unique:users,username,' . $id,
        'studioName' => ['Required', 'Min:2', 'Max:32'],
        'passwordHash' => 'AlphaNum|Between:6,32',
        'tokens'    => 'Integer|Min:0',
        // 'gender'    => 'in:'.UserModel::GENDER_MALE.','.UserModel::GENDER_FEMALE.','.UserModel::GENDER_TRANSGENDER,
        'studioProff' => 'Max:2000|Mimes:doc,docx,pdf',
    ], $messages);

    if ($validator->fails()) {
      return back()
          ->withErrors($validator)
          ->withInput();
    }
    if (Input::file('studioProff')) {
      if (!Input::file('studioProff')->isValid()) {
         return Back()->with('msgInfo', 'el archivo cargado no es válido');
      }
    }
    $userData = Input::all();

    $member = UserModel::find($id);
    if (!$member)
      return redirect('admin/manager/performerstudios')->with('msgError', 'Estudio no existe!');
    $member->studioName = preg_replace('/\s+/', ' ',  Input::get('studioName'));
    if (Input::has('gender') && !empty($userData['gender'])) {
      $member->gender = $userData['gender'];
    }
    if (Input::has('passwordHash') && !empty($userData['passwordHash'])) {
      $member->passwordHash = md5($userData['passwordHash']);
    }
    $member->username = $userData['username'];
    $member->tokens = intval(Input::get('tokens'));

    if ($member->save()) {
        if (Input::file('studioProff')) {
            $identityDocument = DocumentModel::where('ownerId', $member->id)->first();
            if (!$identityDocument) {
                $identityDocument = new DocumentModel;
                $identityDocument->ownerId = $member->id;
            }
            $destinationPath = 'uploads/studios/proff/';
            $image = Input::file('studioProff');
            $filename = $member->username . uniqid() . '.' . $image->getClientOriginalExtension();
            $studioProff = $destinationPath . $filename;
            Input::file('studioProff')->move($destinationPath, $filename);
            $identityDocument->studioProff = $studioProff;
            $identityDocument->save();
        }
      UserController::postPayeeInfo($member->id, Input::all());
      UserController::postDirectDeposit($member->id, Input::all());
      UserController::postPaxum($member->id, Input::all());
      UserController::postBitpay($member->id, Input::all());
      return back()->with('msgInfo', 'Studio se actualizó correctamente.');
    } else {
      return redirect()->back()->withInput()->with('msgError', 'System error.');
    }
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

    $user = UserModel::find($id);
    if (!$user) {
      return Back()->with('msgError', 'User not exist!');
    }
    $user->accountStatus = UserModel::ACCOUNT_DISABLE;
    if ($user->save()) {
      switch ($user->role) {
        case 'model': return Redirect('admin/manager/performers')->with('msgInfo', 'El usuario se deshabilitó con éxito');
          break;
        case 'studio': return Redirect('admin/manager/performerstudios')->with('msgInfo', 'Studio fue deshabilitado exitosamente');
          break;
        case 'member': return Redirect('admin/manager/members')->with('msgInfo', 'El usuario se inhabilitó con éxito');
          break;
      }
    }
    return Back()->with('msgError', 'Error del sistema.');
//check connect table and user manage
  }

  public static function postPayeeInfo($id, $options){
    $data = [
      'withdraw'  => $options['withdraw'],
      'withdrawCurrency' => $options['withdrawCurrency'],
      'taxPayer' => $options['taxPayer'],
      'bankName' => $options['bankName'],
      'bankAddress' => $options['bankAddress'],
      'bankCity' => $options['bankCity'],
      'bankState' => $options['bankState'],
      'bankZip' => $options['bankZip'],
      'bankCountry' => $options['bankCountry'],
      'bankAcountNumber' => $options['bankAcountNumber'],
      'bankSWIFTBICABA' => $options['bankSWIFTBICABA'],
      'holderOfBankAccount' => $options['holderOfBankAccount'],
      'additionalInformation' => $options['additionalInformation'],
      'payPalAccount' => $options['payPalAccount'],
      'checkPayable' => $options['checkPayable']
    ];
    $model = UserModel::find($id);
    $model->bankTransferOptions = json_encode($data);
    $model->save();
  }

  public static function postDirectDeposit($id, $options){
    $data = [
      'depositFirstName' => $options['depositFirstName'],
      'depositLastName' => $options['depositLastName'],
      'accountingEmail' => $options['accountingEmail'],
      'directBankName' => $options['directBankName'],
      'accountType' => $options['accountType'],
      'accountNumber' => $options['accountNumber'],
      'routingNumber' => $options['routingNumber']
    ];

    $model = UserModel::find($id);
    $model->directDeposit = json_encode($data);
    $model->save();
  }

  public static function postPaxum($id, $options){
    $data = [
      'paxumName' => $options['paxumName'],
      'paxumEmail' => $options['paxumEmail'],
      'paxumAdditionalInformation' => $options['paxumAdditionalInformation']
    ];
    $model = UserModel::find($id);
    $model->paxum = json_encode($data);
    $model->save();
  }
  public static function postBitpay($id, $options){
    $data = [
      'bitpayName' => $options['bitpayName'],
      'bitpayEmail' => $options['bitpayEmail'],
      'bitpayAdditionalInformation' => $options['bitpayAdditionalInformation']
    ];
    $model = UserModel::find($id);
    $model->bitpay = json_encode($data);
    $model->save();
  }

  private function genero($str){


 $genero = array('male'=>'Hombre','female'=>'Mujer', 'transgender' => 'transgenero','pareja' => 'pareja');


    return @$genero[$str];
  }

}
