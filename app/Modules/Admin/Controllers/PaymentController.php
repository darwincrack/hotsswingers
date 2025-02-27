<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Api\Models\PaymentSettingModel;
use App\Modules\Api\Models\PaymentPackageModel;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\PaymentsModel;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DB;
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
use App\Modules\Model\Models\PerformerProductTracking;
use App\Modules\Model\Models\PerformerProductTrackingComment;

class PaymentController extends Controller {

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response payment system settings
   */
  public function getSettings() {
//    echo MD5('20.0015840W48fdD1nLQbhKQjG7ARaAQWH');
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }

    $paymentSettings = PaymentSettingModel::first();

    return view('Admin::admin_payment_systems')->with('payment', $paymentSettings);
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response payment system settings
   */
  public function postSettings() {
    
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }
    $id = (Input::has('id')) ? Input::get('id') : null;
    
    $validator = Validator::make(Input::all(), [
      'formName' => 'Required',
      'url_entorno' => 'Required',
      'signature' => 'Required',
      'api_key' => 'Required',
      'service' => 'Required',
    ]);
    
    if ($validator->fails()) {
      return Back()->withErrors($validator)->withInput();
    }
    $payment = PaymentSettingModel::find($id);


    $payment->formName = Input::get('formName');
    $payment->url_entorno = Input::get('url_entorno');
    $payment->signature = Input::get('signature');
    $payment->api_key = Input::get('api_key');
    $payment->service = Input::get('service');


    
    if ($payment->save()) {
      return Back()->with('msgInfo', 'La configuración se cambió con éxito.');
    }
    return Back()->with('msgError', 'Guardar error de categoría. Inténtalo de nuevo.')->withInput();
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response payment packages
   */
  public function getPackages() {
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }

    $packages = PaymentPackageModel::paginate(LIMIT_PER_PAGE);

    return view('Admin::admin_list_packages')->with('listPackages', $packages);
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response 
   */
  public function addPackage() {
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }

    return view('Admin::admin_add_package');
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response payment package
   */
  public function postPackage() {
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }

    $validator = Validator::make(Input::all(), [
        'price' => 'Required|Numeric|Unique:paymentpackages|Min:3',
        'tokens' => 'Required|Integer|Min:1'
    ]);
    if ($validator->fails()) {
      return Back()->withErrors($validator)->withInput();
    }
    $package = new PaymentPackageModel;
    $package->price = Input::get('price');
    $package->description = (Input::has('description')) ? Input::get('description') : '';
    $package->tokens = (Input::has('tokens')) ? Input::get('tokens') : '';
    if ($package->save()) {
      return Back()->with('msgInfo', 'El paquete se agregó correctamente.');
    }
    return Back()->with('msgError', 'Guardar error de categoría. Inténtalo de nuevo.')->withInput();
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response 
   */
  public function editPackage($id) {
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }
    $package = PaymentPackageModel::find($id);
    if (!$package) {
      return Back()->with('msgError', 'El paquete no existe.');
    }

    return view('Admin::admin_edit_package')->with('package', $package);
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response payment package
   */
  public function updatePackage($id) {
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }

    $validator = Validator::make(Input::all(), [
        'price' => 'Required|Numeric|Unique:paymentpackages,price,'.$id.'|Min:1',
        'tokens' => 'Required|Integer|Min:1'
    ]);
    if ($validator->fails()) {
      return Back()->withErrors($validator)->withInput();
    }
    $package = PaymentPackageModel::find($id);
    $package->price = Input::get('price');
    $package->description = (Input::has('description')) ? Input::get('description') : '';
    $package->tokens = Input::get('tokens');
    if ($package->save()) {
      return Back()->with('msgInfo', 'El paquete se cambió correctamente.');
    }
    return Back()->with('msgError', 'Error del sistema.')->withInput();
  }

  /**
   * @param int $id package id
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function deletePackage($id) {
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }

    //TODO check package in use.
    $package = PaymentPackageModel::find($id);
    if (!$package) {
      return Back()->with('msgError', 'El paquete no existe.');
    }
    if ($package->delete()) {
      return Back()->with('msgInfo', 'El paquete se eliminó correctamente.');
    }
    return Back()->with('msgError', 'Error del sistema.');
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response list payment videos 
   */
  public function getPaymentVideos(Request $req) {
  
    $query = PaymentTokensModel::select("paymenttokens.*", 'v.title', 'v.fullMovie', 'paymenttokens.id as check', 'paymenttokens.id as action')
      ->join('videos as v', 'v.id', '=', 'paymenttokens.itemId')
      ->join('users as u', 'u.id', '=', 'paymenttokens.ownerId')
      ->join('users as model', 'model.id', '=', 'paymenttokens.modelId')
      ->where('item', PaymentTokensModel::ITEM_VIDEO)
      ->addSelect('u.username as membername')
      ->addSelect('model.username as modelname');
   

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Videos')
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
          ->setName('title')
          ->setLabel('Video')
          ->setCallback(function ($val) {
              return $val;
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('membername')
          ->setLabel('Cliente')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setName('u.username')
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('modelname')
          ->setLabel('Usuario')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setName('model.username')
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('tokens')
          ->setLabel('Tokens')
        
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('status')
          ->setLabel('Status')
        
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('paymenttokens.status')
            ->setOptions(['approved'=>'Approved','processing'=>'Processing','reject'=>'Reject'])
          ),
          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Fecha')
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
              
              $url = '';
              if($item->status == PaymentTokensModel::STATUS_APPROVED){
                  $url = '<a class="btn btn-danger btn-sm" onclick="rejectPayment('.$val.')">Rechazar</a>';
              }else if($item->status != PaymentTokensModel::STATUS_REJECT && $item->status != PaymentTokensModel::STATUS_APPROVED){
                  $url = '<a class="btn btn-info btn-sm" onclick="approvePayment('.$val.')">Aprobar</a>';
              }
              
              return $url . '&nbsp;&nbsp;<a onclick="showCommissionDetail(\''.$item->item.'\', '.$val.')" class="btn btn-info btn-sm">Detalle</a>'.
                      '&nbsp;&nbsp;<a class="btn btn-warning" title="Eliminar elemento" onclick="return confirm(\'¿Estás seguro de que quieres eliminar esto?\')" href="' . URL('admin/manager/payments/delete/' . $val) . '"><span class="fa fa-trash"></span></a>';
                                  
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
              ->setFileName('Videos-'.date('Y-m-d'))->setSheetName('Excel sheet'),
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
    return view('Admin::admin_payment_videos', compact('grid'));
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response list payment galleries 
   */
  public function getPaymentGalleries(Request $req) {
    $query = PaymentTokensModel::select("paymenttokens.*", 'g.name', 'paymenttokens.id as check', 'paymenttokens.id as action')
      ->join('galleries as g', 'g.id', '=', 'paymenttokens.itemId')
      ->join('users as u', 'u.id', '=', 'paymenttokens.ownerId')
      ->join('users as model', 'model.id', '=', 'paymenttokens.modelId')
      ->where('item', PaymentTokensModel::ITEM_IMAGE)
      ->addSelect('u.username as membername')
      ->addSelect('model.username as modelname');
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Galleries')
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
          ->setName('name')
          ->setLabel('Galería')
          ->setCallback(function ($val) {
              return $val;
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('membername')
          ->setLabel('Cliente')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setName('u.username')
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('modelname')
          ->setLabel('Usuario')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setName('model.username')
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('tokens')
          ->setLabel('Tokens')
        
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('status')
          ->setLabel('Status')
        
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('paymenttokens.status')
            ->setOptions(['approved'=>'Approved','processing'=>'Processing','reject'=>'Reject'])
          ),
          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Fecha')
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
              
              $url = '';
              if($item->status == PaymentTokensModel::STATUS_APPROVED){
                  $url = '<a class="btn btn-danger btn-sm" onclick="rejectPayment('.$val.')">Rechazar</a>';
              }else if($item->status != PaymentTokensModel::STATUS_REJECT && $item->status != PaymentTokensModel::STATUS_APPROVED){
                  $url = '<a class="btn btn-info btn-sm" onclick="approvePayment('.$val.')">Aprobar</a>';
              }
              
              return $url . '&nbsp;&nbsp;<a onclick="showCommissionDetail(\''.$item->item.'\', '.$val.')" class="btn btn-info btn-sm">Detalle</a>'.
                      '&nbsp;&nbsp;<a class="btn btn-warning" title="Eliminar elemento" onclick="return confirm(\'¿Estás seguro de que quieres eliminar esto??\')" href="' . URL('admin/manager/payments/delete/' . $val) . '"><span class="fa fa-trash"></span></a>';
                                  
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
              ->setFileName('Galleries-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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
            
    return view('Admin::admin_payment_galleries', compact('grid'));
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response list payment premium or tip
   */
  public function getPaymentOthers(Request $req) {
    
    $query = PaymentTokensModel::select("paymenttokens.*", 'paymenttokens.id as check', 'paymenttokens.id as action')
      ->join('users as u', 'u.id', '=', 'paymenttokens.ownerId')
      ->join('users as model', 'model.id', '=', 'paymenttokens.modelId')
      ->where('item', '<>', PaymentTokensModel::ITEM_VIDEO)
      ->where('item', '<>', PaymentTokensModel::ITEM_IMAGE)
      ->where('item', '<>', PaymentTokensModel::ITEM_PERFORMER_PRODUCT)
      ->addSelect('u.username as membername')
      ->addSelect('model.username as modelname');
   

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Payments')
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
          ->setName('item')
          ->setLabel('Item')
          ->setCallback(function ($val) {
              return $val;
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('membername')
          ->setLabel('Cliente')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setName('u.username')
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('modelname')
          ->setLabel('usuario')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setName('model.username')
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('tokens')
          ->setLabel('Tokens')
        
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('status')
          ->setLabel('Status')
        
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('paymenttokens.status')
            ->setOptions(['approved'=>'Approved','processing'=>'Processing','reject'=>'Reject'])
          ),
          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Fecha')
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
              
              $url = '';
              if($item->status == PaymentTokensModel::STATUS_APPROVED){
                  $url = '<a class="btn btn-danger btn-sm" onclick="rejectPayment('.$val.')">Rechazar</a>';
              }else if($item->status != PaymentTokensModel::STATUS_REJECT && $item->status != PaymentTokensModel::STATUS_APPROVED){
                  $url = '<a class="btn btn-info btn-sm" onclick="approvePayment('.$val.')">Aprobar</a>';
              }
              
              return $url . '&nbsp;&nbsp;<a onclick="showCommissionDetail(\''.$item->item.'\', '.$val.')" class="btn btn-info btn-sm">Detalle</a>'.
                      '&nbsp;&nbsp;<a class="btn btn-warning" title="Eliminar elemento" onclick="return confirm(\'¿Estás seguro de que quieres eliminar esto??\')" href="' . URL('admin/manager/payments/delete/' . $val) . '"><span class="fa fa-trash"></span></a>';
                                  
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
                ->setFileName('excel-report-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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

    return view('Admin::admin_payment_others', compact('grid'));
  }

  /**
   * @param int $id payment token id
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return response 
   */
  public function rejectPayment($id) {
    $userData = AppSession::getLoginData();
    
    $payment = PaymentTokensModel::where('id',$id)->where('status', PaymentTokensModel::STATUS_APPROVED)->first();
    
    if (!$payment) {
      return Back()->with('msgError', 'Payment not found.');
    }
    
    //
    
//    if ($payment->save()) {
//      TODO increment member tokens.
      $member = UserModel::find($payment->ownerId);
      if($member){
          $member->increment('tokens', $payment->tokens);
          if(!$member->save()){
              return Back()->with('msgError', 'Reembolsar tokens por error de miembro. Por favor, inténtelo de nuevo más tarde.');
          }
        //TODO reject earning
        if($payment->status == PaymentTokensModel::STATUS_APPROVED){
            $earnings = EarningModel::where('itemId', $payment->id)->update(array(
                'status' => PaymentTokensModel::STATUS_REJECT
            ));
            
            //reduce manager tokens
            $earnings = EarningModel::where('itemId', $payment->id)->get();

            if (count($earnings) > 0) {
              foreach ($earnings as $item) {
                  $manager = UserModel::find($item->payTo);
                  if($manager){
                      $manager->decrement('tokens', $item->tokens);
                      $manager->save();
                  }
              }
            }
        }
      }
      $payment->status = PaymentTokensModel::STATUS_REJECT;
      if($payment->save()){
          return Back()->with('msgInfo', 'El pago se rechazó correctamente.');
      }
      
      
//    }
    return Back()->with('msgError', 'Error del sistema.');
  }

  /**
   * @param int $id payment id
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return response 
   */
  public function approvePayment($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('/admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }
  
    $response = PaymentTokensModel::approvePayment($id);
    if(!$response['success']){
      return back()->with('msgError', $response['message']);
    }

    return back()->with('msgInfo', $response['message']);
  }


  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response 
   */
  public function getMemberTransactions(Request $req) {
//    $transactions = PaymentsModel::select('payments.*', 'u.username')
//      ->join('users as u', 'u.id', '=', 'payments.memberId');
//    if ($req->has('q')) {
//      $transactions = $transactions->where('u.username', 'like', $req->get('q') . '%');
//    }
//    $transactions = $transactions->paginate(LIMIT_PER_PAGE);
    $query = PaymentsModel::join('users as u', 'u.id', '=', 'payments.memberId')
      ->select('payments.*')
      // Column alias 'country_name' used to avoid naming conflicts, suggest that customers table also has 'name' column.
      ->addSelect('u.username');
//      ->where('users.role', UserModel::ROLE_MEMBER);

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Users')
        ->setPageSize(10)
        ->setColumns([
          (new FieldConfig)
          ->setName('id')
          ->setLabel('ID')
          ->setSortable(true)
          
          ,
          (new FieldConfig)
          ->setName('parameters')
          ->setLabel('Transacción Id')
          ->setCallback(function ($val) {
            if (!$val) return '';
            $params = json_decode($val);
            if (property_exists($params, 'subscriptionId')) {
              return $params->subscriptionId;
            }
            if (property_exists($params, 'subscription_id')) {
              return $params->subscription_id;
            }
            return '';
              // return AppHelper::getJsonDecode($val, 'subscriptionId');
          })
          ->setSortable(true)
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
          ),
          (new FieldConfig)
          ->setName('parameters')
          ->setLabel('Email')
          ->setSortable(true)
          ->setCallback(function ($val) {
            return AppHelper::getJsonDecode($val, 'email');
            })
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ,
          (new FieldConfig)
          ->setName('parameters')
          ->setLabel('Precio')
          ->setSortable(true)
          ->setCallback(function ($val, $row) {
            if (!$val) return '';
            $params = json_decode($val);
            if (property_exists($params, 'accountingRecurringPrice')) {
              return $params->accountingRecurringPrice;
            }
            if (property_exists($params, 'initialFormattedPrice')) {
              return $params->initialFormattedPrice;
            }
            if (property_exists($params, 'price')) {
              return $params->price;
            }
            return '';
            // return AppHelper::getJsonDecode($val, 'priceDescription');
          })
          ,
          (new FieldConfig)
          ->setName('price')
          ->setLabel('Tokens')
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('status')
          ->setLabel('Status')
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('payments.status')
            ->setOptions(['approved'=>'Approved','denial'=>'Denial','rejected'=>'Rejected','error'=>'Error'])
          )
          ,
          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Fecha')
          ->setSortable(true)
          ->setCallback(function ($val) {
            return date('d/m/Y', strtotime($val));  
            })
          ->setSorting(Grid::SORT_DESC)
          ,
          (new FieldConfig)
          ->setName('id')
          ->setLabel('Acciones')
              
          ->setCallback(function ($val, $row) {
               $src = $row->getSrc();
                $buttons = '';
              if($src->status == PaymentsModel::STATUS_REJECTED){
                $buttons .= '<button class="btn btn-success btn-sm" ng-click="approveTransaction('.$val.')" >Aprobar</button>';
              }else if($src->status == PaymentsModel::STATUS_APPROVED){
                $buttons .= '<button class="btn btn-danger btn-sm" ng-click="rejectTransaction('.$val.')" >Rechazar</button>';
              }
              return $buttons . "&nbsp;&nbsp;<button class='btn btn-info btn-sm' ng-click='showTransactionDetail({$val})'>Detalles</button>";
           
            })
          ->setSortable(false)
          
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
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('Transaction-'.date('Y-m-d'))->setSheetName('Excel sheet'),
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
    return view('Admin::admin-transactions-manager')->with('grid', $grid->render());
  }

  /**
   * @param int $id payment id
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function rejectTransaction($id) {

    //check member token
    $transaction = UserModel::join('payments as p', 'p.memberId', '=', 'users.id')
      ->where('p.id', $id)
      ->where('p.status', PaymentsModel::STATUS_APPROVED)
      ->first();
    if (!$transaction) {
      return Back()->with('msgError', 'La transacción no existe o es rechazada.');
    }
    if ($transaction->tokens < $transaction->price) {
      return Back()->with('msgError', 'Los tokens de miembros no son suficientes para reembolsar.');
    }

    $member = UserModel::find($transaction->memberId);
    if (!$member) {
      return Back()->with('msgError', 'El miembro no existe.');
    }


    $member->decrement('tokens', $transaction->price);
    if ($member->save()) {
      $payment = PaymentsModel::find($id);
      $payment->status = PaymentsModel::STATUS_REJECTED;
      if ($payment->save()) {
        return Redirect('admin/manager/members/transactions')->with('msgInfo', 'La transacción fue rechazada con éxito.');
      }
      $member->increment('tokens', $transaction->price);
      if ($member->save()) {
        return Back()->with('msgError', 'Error del sistema.');
      }
      return Back()->with('msgError', 'Error del sistema, se han deducido los tokens de miembro, pero el proceso de rechazo es defectuoso');
    }
    return Back()->with('msgError', 'Error del sistema');
  }

  /**
   * @param int $id payment id
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function approveTransaction($id) {

    //check member token
    $transaction = UserModel::join('payments as p', 'p.memberId', '=', 'users.id')
      ->where('p.id', $id)
      ->where('p.status', PaymentsModel::STATUS_REJECTED)
      ->first();
    if (!$transaction) {
      return Back()->with('msgError', 'La transacción no existe o no está aprobada.');
    }

    $member = UserModel::find($transaction->memberId);
    if (!$member) {
      return Back()->with('msgError', 'El miembro no existe.');
    }


    $member->increment('tokens', $transaction->price);
    if ($member->save()) {
      $payment = PaymentsModel::find($id);
      $payment->status = PaymentsModel::STATUS_APPROVED;
      if ($payment->save()) {
        return Redirect('admin/manager/members/transactions')->with('msgInfo', 'La transacción se aprobó correctamente.');
      }
      $member->decrement('tokens', $transaction->price);
      if ($member->save()) {
        return Back()->with('msgError', 'Error del sistema.');
      }
      return Back()->with('msgError', 'Errores del sistema, se han agregado tokens de miembro a la cuenta, pero el estado del cambio es defectuoso');
    }
    return Back()->with('msgError', 'Error del sistema.');
  }
  
  public function processPaymentAction($type){
      if(!Input::has('checklist') || count(Input::get('checklist')) == 0){
          return back()->with('msgError', 'Seleccione al menos 1 elemento.');
      }
      if(!Input::has('action') || empty(Input::get('action'))){
          return back()->with('Seleccione una acción.');
      }
      
      
      if(Input::get('action') == 'reject'){
        $payment = PaymentTokensModel::whereIn('id',Input::get('checklist'))->where('status', PaymentTokensModel::STATUS_APPROVED)->get();
    
        if (!$payment || count($payment) == 0) {
          return Back()->with('msgError', 'No se encontró el elemento de aprobación de pago.');
        }
        $error = false;
        foreach ($payment as $item){
          $member = UserModel::find($item->ownerId);
          if($member){
              $member->increment('tokens', $item->tokens);
              if(!$member->save()){
                $error = true;
                continue;
              }
            //TODO reject earning
            if($item->status == PaymentTokensModel::STATUS_APPROVED){
                $earnings = EarningModel::where('itemId', $item->id)->update(array(
                    'status' => PaymentTokensModel::STATUS_REJECT
                ));

                //reduce manager tokens
                $earnings = EarningModel::where('itemId', $item->id)->get();

                if (count($earnings) > 0) {
                  foreach ($earnings as $eitem) {
                      $manager = UserModel::find($eitem->payTo);
                      if($manager){
                          $manager->decrement('tokens', $eitem->tokens);
                          $manager->save();
                      }
                  }
                }
            }
          }
          $item->status = PaymentTokensModel::STATUS_REJECT;
          $item->save();

        }
        if($error)
            return Back()->with('msgError', 'Algunos artículos no se pueden procesar.');
        return Back()->with('msgInfo', 'Todos los artículos fueron rechazados con éxito.');
        
        
      }else if(Input::get('action') == 'approve'){
        $payment = PaymentTokensModel::whereIn('id',Input::get('checklist'))->where('status', PaymentTokensModel::STATUS_PROCESSING)->get();

        if (!$payment || count($payment) == 0) {
          return Back()->with('msgError', 'No se encontró el elemento de procesamiento de pago.');
        }
        $error = false;
        foreach ($payment as $item){
        $member = UserModel::find($item->ownerId);
        if(!$member){
            $error = true;die;
            continue;
        }

        $commission = UserModel::select(
              'p.id as paymentId', 'p.ownerId as payFrom', 'p.item as paymentItem', 'p.tokens as paymentTokens', 'users.id as modelId', 'u1.id as studioId', 'u2.id as adminId', 
          DB::raw("(SELECT CASE u3.role WHEN '" . UserModel::ROLE_MODEL . "' THEN es.performerSiteMember WHEN '" . UserModel::ROLE_MEMBER . "' THEN es.referredMember ELSE otherMember END FROM earningsettings es, users u3 WHERE es.userId = users.id and u3.id=users.id) as modelPercent"), 
          DB::raw("(SELECT CASE u4.role WHEN '" . UserModel::ROLE_MODEL . "' THEN es1.performerSiteMember WHEN '" . UserModel::ROLE_MEMBER . "' THEN es1.referredMember ELSE otherMember END FROM earningsettings es1, users u4 WHERE es1.userId = u1.id and u4.id=users.id) as studioPercent"), 
          DB::raw("(SELECT CASE u5.role WHEN '" . UserModel::ROLE_MODEL . "' THEN es2.performerSiteMember WHEN '" . UserModel::ROLE_MEMBER . "' THEN es2.referredMember ELSE otherMember END FROM earningsettings es2, users u5 WHERE es2.userId = u2.id and u5.id=users.id) as adminPercent"),
          DB::raw("(SELECT CASE u6.role WHEN '" . UserModel::ROLE_MODEL . "' THEN '" . EarningModel::PERFORMERSITEMEMBER . "' WHEN '" . UserModel::ROLE_MEMBER . "' THEN '" . EarningModel::REFERREDMEMBER . "' ELSE '" . EarningModel::OTHERMEMBER . "' END FROM users u6 WHERE u6.id=p.ownerId) as type")
            )
            ->leftJoin('users as u1', 'u1.id', '=', 'users.parentId')
            ->leftJoin('users as u2', 'u2.id', '=', 'u1.parentId')
            ->join('paymenttokens as p', 'p.itemId', '=', DB::raw("CASE WHEN p.item = '".PaymentTokensModel::ITEM_VIDEO."' THEN (SELECT v.id FROM videos v WHERE v.ownerId=users.id AND v.id=p.itemId) WHEN p.item = '".PaymentTokensModel::ITEM_IMAGE."' THEN (SELECT g.id FROM galleries g WHERE g.ownerId=users.id AND g.id=p.itemId) ELSE users.id END"))
            ->where('users.id', DB::raw("CASE WHEN p.item = '".PaymentTokensModel::ITEM_VIDEO."' OR p.item='".PaymentTokensModel::ITEM_IMAGE."' THEN users.id ELSE p.itemId END"))
            ->where('users.role', 'model')
            ->where('p.status', 'processing')
            ->where('p.id', $item->id)
            ->whereNotIn('p.id', function($q) {
              $q->select('itemId')->distinct()->from('earnings');
            })->first();
            if(!$commission){
                $error = true;

                continue;
            }

            $error = false;

            if ($commission->modelId) {
              $model = UserModel::find($commission->modelId);
              if($model){
                $model->increment('tokens', (intval($commission->modelPercent) / 100) * $commission->paymentTokens);
                if ($model->save()) {
                  $earning = new EarningModel;
                  $earning->item = $commission->paymentItem;
                  $earning->itemId = $commission->paymentId;
                  $earning->payFrom = $commission->payFrom;
                  $earning->payTo = $commission->modelId;
                  $earning->tokens = ((intval($commission->modelPercent) / 100) * $commission->paymentTokens);
                  $earning->percent = intval($commission->modelPercent);
                  $earning->type = $commission->type;
                  if (!$earning->save()) {
                    //TODO process error here  
                    $error = true;
                  }
                }
              }
            }
            if ($commission->studioId && !$error) {
              //studio tokens 
              $studio = UserModel::find($commission->studioId);
              if($studio){
                $studio->increment('tokens', ((100 - (intval($commission->adminPercent) + intval($commission->modelPercent))) / 100) * $commission->paymentTokens);
                if ($studio->save()) {
                  $earning = new EarningModel;
                  $earning->item = $commission->paymentItem;
                  $earning->itemId = $commission->paymentId;
                  $earning->payFrom = $commission->payFrom;
                  $earning->payTo = $commission->studioId;
                  $earning->tokens = ((100 - (intval($commission->adminPercent) + intval($commission->modelPercent))) / 100) * $commission->paymentTokens;
                  $earning->percent = 100 - (intval($commission->adminPercent) + intval($commission->modelPercent));
                  $earning->type = $commission->type;
                  if (!$earning->save()) {
                    //TODO process error here  
                    $error = true;
                  }
                }
              }
            }
            if ($commission->adminId && !$error) {

              //admin site tokens
              $admin = UserModel::find($commission->adminId);
              if($admin){
                $admin->increment('tokens', (intval($commission->adminPercent) / 100) * $commission->paymentTokens);
                if ($admin->save()) {
                  $earning = new EarningModel;
                  $earning->item = $commission->paymentItem;
                  $earning->itemId = $commission->paymentId;
                  $earning->payFrom = $commission->payFrom;
                  $earning->payTo = $commission->adminId;
                  $earning->tokens = ((intval($commission->adminPercent) / 100) * $commission->paymentTokens);
                  $earning->percent = intval($commission->adminPercent);
                  $earning->type = $commission->type;
                  if (!$earning->save()) {
                    //TODO process error here  
                    $error = true;
                  }
                }
              }
            }
            if(!$error){
            //change payment status to approved

              $item->status = PaymentTokensModel::STATUS_APPROVED;
              $item->save();
            }else{
                EarningModel::where('item', $commission->paymentItem)
                      ->where('itemId', $commission->paymentId)
                      ->delete();

            }
        }
        if(!$error)
            return back()->with('msgInfo', 'Todo cambio ha sido aprobado');
        return back()->with('msgError', "Todos los elementos se aprobaron correctamente, pero algunos elementos tienen errores.");
      }
  }
  
  public function deletePayment($id){
    $payment = PaymentTokensModel::find($id);
    if (!$payment) {
        return Back()->with('msgError', '¡El pago no existe!');
    }
    if ($payment->delete()) {
        return Back()->with('msgInfo', 'El usuario fue eliminado correctamente');
    }
    return Back()->with('msgError', 'Error del sistema.');
  }

  public function getPaymentProducts(){
    $query = PerformerProductTracking::join('performer_products as pp', 'performer_product_tracking.productId', '=', 'pp.id')
      ->join('performer as p', 'p.id', '=', 'performer_product_tracking.performerId')
      ->join('users as u', 'performer_product_tracking.userId', '=', 'u.id')
      ->join('users as u1', 'p.user_id', '=', 'u1.id')
      ->select('performer_product_tracking.id', 'pp.name as name', 'u.username as username', 'u1.username as performerName',
              'performer_product_tracking.id as action', 'performer_product_tracking.status as status', 'performer_product_tracking.shippingStatus as shippingStatus');

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Transactions')
        ->setPageSize(10)
        ->setColumns([
          (new FieldConfig)
          ->setName('id')
          ->setLabel('ID')
          ->setSortable(true)
          ->setSorting(Grid::SORT_ASC)
          ,
          (new FieldConfig)
          ->setName('name')
          ->setLabel('Product')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ,
          (new FieldConfig)
          ->setName('username')
          ->setLabel('Username')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setFilteringFunc(function($val, EloquentDataProvider $dp) {
              /** @var Illuminate\Database\Eloquent\Builder $builder */
              $builder = $dp->getBuilder();
              $builder->where('u.username', 'like', "%$val%");
            })
          )

          ,
          (new FieldConfig)
          ->setName('performerName')
          ->setLabel('
            usuario')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            //->setOperator(FilterConfig::OPERATOR_LIKE)
            ->setFilteringFunc(function($val, EloquentDataProvider $dp) {
              /** @var Illuminate\Database\Eloquent\Builder $builder */
              $builder = $dp->getBuilder();
              $builder->where('u1.username', 'like', "%$val%");
            })
          )
          ,

          (new FieldConfig)
          ->setName('token')
          ->setLabel('Token')
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('status')
          ->setLabel('Status')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            //->setOperator(FilterConfig::OPERATOR_LIKE)
            ->setFilteringFunc(function($val, EloquentDataProvider $dp) {
              /** @var Illuminate\Database\Eloquent\Builder $builder */
              $builder = $dp->getBuilder();
              $builder->where('performer_product_tracking.status', $val);
            })
          ),
          (new FieldConfig)
          ->setName('shippingStatus')
          ->setLabel('Estado del envío')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            //->setOperator(FilterConfig::OPERATOR_LIKE)
            ->setFilteringFunc(function($val, EloquentDataProvider $dp) {
              /** @var Illuminate\Database\Eloquent\Builder $builder */
              $builder = $dp->getBuilder();
              $builder->where('performer_product_tracking.shippingStatus', $val);
            })
          )
          ,
          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Fecha')
          ->setSortable(true)
          ->setCallback(function($val){
            $d = new \DateTime($val);
            return $d->format('d/m/Y');
          }),

          (new FieldConfig)
          ->setName('action')
          ->setLabel('Acciones')
          ->setCallback(function ($val, $row) {
              //$item = $row->getSrc();
              return "<a title='View' href='" . URL('admin/manager/payments/products/' . $val) . "'><span class='fa fa-eye'></span></a>";
            })
          ->setSortable(false)
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
                100
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

    if (isset($_GET['Transactions']) && (isset($_GET['Transactions']['csv']) || isset($_GET['Transactions']['xls']))) {
      return $grid;
    }
    return view('Admin::admin_payment_products')->with('grid', $grid);
  }
  public function getPaymentProductsDetail($id){
    $item = PerformerProductTracking::where([
      'id' => $id
    ])
    ->with('product')
    ->with('performer')
    ->first();

    if (!$item) {
      throw new Exception('Not found', 404);
    }

    //get comments
    $comments = PerformerProductTrackingComment::where(['orderId' => $id])->with('sender')->get();

    return view('Admin::admin_payment_product_detail')
          ->with('item', $item)
          ->with('comments', $comments);
  }
  public function refundPaymentProduct($id){
    $item = PerformerProductTracking::where([
      'id' => $id
    ])
    ->first();

    if (!$item) {
      throw new Exception('Not found', 404);
    }

    $user = UserModel::where(['id' => $item->userId])->first();
    if (!$item) {
      throw new Exception('Not found', 404);
    }

    $user->tokens = $user->tokens + $item->token;
    $user->save();
    $item->status = 'refunded';
    $item->save();

    return Redirect::to('admin/manager/payments/products')->with('msgInfo', 'Refunded successfully');
  }
}
