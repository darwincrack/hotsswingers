<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Modules\Api\Models\UserModel;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\PremiosGanadoresModel;
use App\Modules\Api\Models\PremiosModel;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\OssnLikesModel;
use Redirect;
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
use Illuminate\Support\Facades\Validator;
use Response;
use App\Modules\Api\Models\EarningModel;
use Illuminate\Support\Facades\Mail;

class PremiosController extends Controller {




  public function getModelsPremios(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }
    $query =  PremiosGanadoresModel::select('premiosganadores.*', 'users.username')
      ->join('users', 'users.id', '=', 'premiosganadores.user_id')
      ->orderBy('createdAt','desc');

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Users')
        ->setPageSize(50)
        ->setColumns([
          
          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Fecha')

           ->setCallback(function ($val) {
              return date('d/m/Y', strtotime($val));
            })
          ->setSortable(true)
         ,
          
          (new FieldConfig)
          ->setName('username')
          ->setLabel('Username')
          
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('tokens')
          ->setLabel('Tokens ganados')
          ->setCallback(function ($val) {
              return $val;
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )

          ,
          (new FieldConfig)
          ->setName('totalviewer')
          ->setLabel('Usuarios conectados para el premio')
          ->setCallback(function ($val) {
              return $val;
            }),

        
          
          
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
    
                50,
                100,
                200,
                300,
                400,
                500
              ])
             
              ,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('premios-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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










\App::setLocale(session('lang'));

    return view('Admin::admin_premiosganadores_model')->with('title', 'List Members')->with('grid', $grid->render());
    
  }



  public function getPremiosTokens(Request $req){


    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }
    $query =  PaymentTokensModel::select('paymenttokens.*',DB::raw("SUM(paymenttokens.afterModelCommission) as tokensGanados"), 'users.username')
      ->join('users', 'users.id', '=', 'paymenttokens.modelId')

      ->whereIn('item', ['tip', 'private'])
      ->where('paymenttokens.status', PaymentTokensModel::STATUS_APPROVED)
      ->whereNull('paymenttokens.nocontab');






 if ($req->has('timePeriodStart') && !$req->has('timePeriodEnd')) {
          $query->where('paymenttokens.createdAt', '>=', date_format(date_create($req->get('timePeriodStart').':00'),"Y/m/d H:i:s"));

    } else if ($req->has('timePeriodEnd') && !$req->has('timePeriodStart')) {


       $query->where('paymenttokens.createdAt', '<=', date_format(date_create($req->get('timePeriodEnd').':59'),"Y/m/d H:i:s"));

    } else if ($req->has('timePeriodStart') && $req->has('timePeriodEnd')) {



$query->whereBetween('paymenttokens.createdAt', [date_format(date_create($req->get('timePeriodStart').':00'),"Y/m/d H:i:s"), date_format(date_create($req->get('timePeriodEnd').':59'),"Y/m/d H:i:s")]);
      
 //$query->where(DB::raw("paymenttokens.createdAt"), '<=', date_format(date_create($req->get('timePeriodEnd').':59'),"Y/m/d H:i:s"));



    }else{
         $query->where(DB::raw("DATE_FORMAT(paymenttokens.createdAt, '%Y-%m-%d')"),date('Y-m-d') );

    }





      
      $query->groupBy('paymenttokens.modelId');
      $query->orderBy('tokensGanados','desc');

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('paymenttokens')
        ->setPageSize(10)
        ->setColumns([
          
          (new FieldConfig)
          ->setName('username')
          ->setLabel('Username')
          ->setSortable(true)
         ,
          
          (new FieldConfig)
          ->setName('tokensGanados')
          ->setLabel('Tokens')
          
          ->setSortable(true)
          ,

             (new FieldConfig)
          ->setName('action')
          ->setLabel('Acciones')
          ->setCallback(function ($val,$row) {
            $item = $row->getSrc();
          



 return '&nbsp;&nbsp;<a onclick="showFormPremiosTokens(\''.$item->modelId.'\',\''.$item->username.'\',\''.$item->tokensGanados.'\')" class="btn btn-info btn-sm">Enviar premio</a>';



            })
          ->setSortable(false),

        
          
          
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
    
                50,
                100,
                200,
                300,
                400,
                500
              ])
             
              ,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('premios-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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














    \App::setLocale(session('lang'));

    return view('Admin::admin_premiostokens_model')->with('title', 'List Members')->with('grid', $grid->render());

  }



  public function setPremiosTokens(Request $request){

    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }


 $validator = Validator::make($request->all(), [
            'tokensPremios' => 'required',
        ]);

        $input = $request->all();

        if ($validator->passes()) {

            // Store your user in database 









     $payment = new PaymentTokensModel;
      $payment->ownerId = 1;
      $payment->item = 'tip';
      $payment->itemId = 2;
      $payment->modelId = $request->input('userPremiosTokens');
      $payment->tokens = $request->input('tokensPremios');
      $payment->status = 'approved';
      $payment->modelCommission = 100;
      $payment->afterModelCommission = $request->input('tokensPremios');
      
      

      if ($payment->save()) { 





          $earning = new EarningModel;
          $earning->item = 'tip';
          $earning->itemId = $payment->id;
          $earning->payFrom = 1;
          $earning->payTo = $request->input('userPremiosTokens');
          $earning->tokens =  $request->input('tokensPremios');
          $earning->percent = 100;
          $earning->type = EarningModel::PERFORMERSITEMEMBER;
          if ($earning->save()) {
            

                $user = UserModel::find($request->input('userPremiosTokens'));
               // $user->increment('tokens', $request->input('tokensPremios'));
              
               $premios = new PremiosModel;

                $premios->user_id           =   $request->input('userPremiosTokens');
                $premios->tokens            =   $request->input('tokensPremios');

                if($request->input('userPremiosFechaInicio')){

                  $premios->datetime_inicio   =   date_format(date_create($request->input('userPremiosFechaInicio')),"Y-m-d H:i:s");
                }else{

                  $premios->datetime_inicio   = date("Y-m-d H:i").':00';
                }

                if($request->input('userPremiosFechaFinal')){

                  $premios->datetime_final   =   date_format(date_create($request->input('userPremiosFechaFinal')),"Y-m-d H:i:s").'59';
                }else{

                  $premios->datetime_final   = date("Y-m-d H:i").':59';
                }

                $premios->tokens_acumulados =   $request->input('tokensGanados');
                $premios->msn               =   $request->input('txtPremiosTokens');


                if (!$premios->save()) { 
                  return Response()->json(array('success' => false, 'message' => "Error al guardar, intente de nuevo por favor" ));
                }
          }

      }

     





  $data = PremiosModel::where(['id' => $premios->id])->first();
  $sendTo = $user->email;

 Mail::send('email.premio_tokens', [
        'data' => $data,
        'request' => $this,
        'user' =>$user

      ], function($message) use ($sendTo,$request,$user){
        $siteName = app('settings')->siteName;
        $message
          ->from(env('FROM_EMAIL') , app('settings')->siteName)
          ->to($sendTo)
          ->subject($user->username.', '.trans('messages.premiouno'). ' '.$request->input('tokensPremios')." tokens | {$siteName}");
      });

                  return Response()->json(array('success' => true, 'message' => "Premio enviado con éxito" ));
                


        }
        
        return Response::json(['errors' => $validator->errors()]);
    }






  public function ListGanadoresPremiosTokens(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }
    $query =  PremiosModel::select('premiosganadores_tokens.*', 'users.username')
      ->join('users', 'users.id', '=', 'premiosganadores_tokens.user_id')
      ->orderBy('createdAt','desc');

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Users')
        ->setPageSize(50)
        ->setColumns([
          
          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Fecha entrega de premio')

           ->setCallback(function ($val) {
              return date('d/m/Y', strtotime($val));
            })
          ->setSortable(true)
         ,
          
          (new FieldConfig)
          ->setName('username')
          ->setLabel('Username')
          
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('tokens')
          ->setLabel('Tokens acreditados')
          ->setCallback(function ($val) {
              return $val;
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),




        (new FieldConfig)
          ->setName('datetime_inicio')
          ->setLabel('Fecha de inicio')

           ->setCallback(function ($val) {
              return date('d/m/Y H:i', strtotime($val));
            })
          ->setSortable(true),

        (new FieldConfig)
          ->setName('datetime_final')
          ->setLabel('Fecha final')

           ->setCallback(function ($val) {
              return date('d/m/Y H:i', strtotime($val));
            })
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('tokens_acumulados')
          ->setLabel('Total Acumulados')
           ->setSortable(true)
          ->setCallback(function ($val) {
              return $val;
            }),

        
          
          
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
    
                50,
                100,
                200,
                300,
                400,
                500
              ])
             
              ,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('premios-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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










\App::setLocale(session('lang'));

    return view('Admin::admin_premiosganadorestokens_model')->with('title', 'List Members')->with('grid', $grid->render());
    
  }








  public function getPremiosLikes(Request $req){


    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('admin/login')->with('msgError', 'Inicie sesión con rol de administrador');
    }
    $query =  OssnLikesModel::select('ossn_object.guid as id_post', 'ossn_object.owner_guid as id_ownerpost', 'users.username', DB::raw("DATE_FORMAT(ossn_likes.created_at, '%d-%m-%Y %T') AS fecha"), DB::raw("count(subject_id) AS totallikes"),'users.id as id_users')
      

      ->join('ossn_object', 'ossn_object.guid', '=', 'ossn_likes.subject_id')
      ->join('users', 'users.id', '=', 'ossn_object.owner_guid')
      ->join('ossn_entities', 'ossn_object.guid', '=', 'ossn_entities.owner_guid')

      ->where('ossn_likes.type', 'post')
      ->where('ossn_entities.subtype', 'file:wallphoto')
      ->whereIn('ossn_likes.subtype', ['like', 'love','haha','wow']);




 if ($req->has('timePeriodStart') && !$req->has('timePeriodEnd')) {

      $dateStart = date_create($req->get('timePeriodStart').':00');
      $dateStart = date_format($dateStart,"Y-m-d H:i:s");


      $query->where('ossn_likes.created_at', '>=', $dateStart);
      $query->where(DB::raw("DATE_FORMAT(from_unixtime(ossn_object.time_created), '%Y-%m-%d %T')"), '>=', $dateStart);

    } else if ($req->has('timePeriodEnd') && !$req->has('timePeriodStart')) {

      $dateEnd=date_create($req->get('timePeriodEnd').':00');
      $dateEnd = date_format($dateEnd,"Y-m-d H:i:s");

      $query->where('ossn_likes.created_at', '<=', $dateEnd);

      $query->where(DB::raw("DATE_FORMAT(from_unixtime(ossn_object.time_created), '%Y-%m-%d %T')"), '<=', $dateEnd);


    } else if ($req->has('timePeriodStart') && $req->has('timePeriodEnd')) {


      $dateStart=date_create($req->get('timePeriodStart').':00');
      $dateStart = date_format($dateStart,"Y-m-d H:i:s");


      $dateEnd=date_create($req->get('timePeriodEnd').':00');
      $dateEnd = date_format($dateEnd,"Y-m-d H:i:s");

      $query->where('ossn_likes.created_at', '>=', $dateStart);
      $query->where('ossn_likes.created_at', '<=', $dateEnd);


      $query->where(DB::raw("DATE_FORMAT(from_unixtime(ossn_object.time_created), '%Y-%m-%d %T')"),'>=', $dateStart);

     $query->where(DB::raw("DATE_FORMAT(from_unixtime(ossn_object.time_created), '%Y-%m-%d %T')"),'<=', $dateEnd);

    }else{
         $query->where(DB::raw("DATE_FORMAT(ossn_likes.created_at, '%Y-%m-%d')"),date('Y-m-d') );
        $query->where(DB::raw("DATE_FORMAT(from_unixtime(ossn_object.time_created), '%Y-%m-%d')"),date('Y-m-d') );

    }





      
      $query->groupBy('subject_id');
      $query->orderBy('totallikes','desc');
      $query->limit(5);
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('ossn_likes')
        ->setPageSize(5)
        ->setColumns([
          
        (new FieldConfig)
          ->setName('id_post')
          ->setLabel('Ver post')
          ->setCallback(function ($val,$row) {
            $item = $row->getSrc();
          



           return '&nbsp;&nbsp;<a href="'.url("/dashboard/post/view/{$item->id_post}").'" class="btn btn-info btn-sm" target="_blank" title="'.url("/dashboard/post/view/{$item->id_post}").'"><span class="fa fa-eye" ></span> Ver post</a>';



            })
          ->setSortable(false),




          (new FieldConfig)
          ->setName('username')
          ->setLabel('Username')
          ->setSortable(true)
         ,



          
          (new FieldConfig)
          ->setName('totallikes')
          ->setLabel('Total likes')
          
          ->setSortable(true)
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
    
                5,
              ])
             
              ,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('premios-tokens'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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
          
        ])
    );

    \App::setLocale(session('lang'));

    return view('Admin::admin_premioslikes_model')->with('title', 'List Members')->with('grid', $grid->render());

  }




public function setReferidos(){


$user = UserModel::all();


foreach($user as $row) {
    $row->referral_code = str_random(8);
    $row->save();
}


return "hecho";


}





 }