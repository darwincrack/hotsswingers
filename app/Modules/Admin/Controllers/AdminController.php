<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Model\Models\PerformerPayoutRequest;
use Illuminate\Http\Request;
use App\Helpers\Session as AppSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\SettingModel;
use Redirect;
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
use App\Modules\Api\Models\EarningSettingModel;

class AdminController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index(Request $req) {
    $userLogin = AppSession::getLoginData();
    if (!$userLogin) {
      return Redirect('admin/login');
    }
    return Redirect('admin/dashboard');
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
	public function dashboard() {
		$userInfo = UserModel::select(DB::raw("(SELECT COUNT(u1.id) FROM users u1 WHERE u1.role='member') AS totalMember"), DB::raw("(SELECT COUNT(u2.id) FROM users u2 WHERE u2.role = 'model') AS totalModel"), DB::raw("(SELECT COUNT(u3.id) FROM users u3 WHERE u3.role = 'studio') AS totalStudio"))->first();
		$pendingModel = $this->getModelPending();
		$pendingStudio = $this->getStudioPending();
		$highestEarnModel = $this->getModelHighestEarn();
		$payoutRequest = $this->payoutRequest();
		$getModelPendingContrato = $this->getModelPendingContrato();
		return view("Admin::index", array(
			'pendingModel' => $pendingModel,
			'pendingStudio' => $pendingStudio,
			'highestEarnModel' => $highestEarnModel,
			'payoutRequest' => $payoutRequest,
			'getModelPendingContrato' => $getModelPendingContrato,

		))->with('userInfo', $userInfo);
	}

		public function getModelPendingContrato(){
		$query = UserModel
			::leftJoin('countries as c', 'users.countryId', '=', 'c.id')

			->select('users.*', 'users.id as check', 'users.id as action')
			->addSelect('c.name')
			->join('documents', 'documents.ownerId', '=', 'users.id')
			->where('users.role', UserModel::ROLE_MODEL)
			->where('documents.contrato', 1)
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
					$url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Suspend account'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
				}
				$url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/image-gallery/' . $val) . "' title='Galerías de imágenes'><span class='fa fa-picture-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/video-gallery/' . $val) . "' title='Video galerias'><span class='fa fa-video-camera'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/identification/' . $val) . "' title='Validar identificación'><span class='fa fa-file-text-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/model/chat/' . $val) . "' title='Administrar mensajes de chat'><span class='fa fa-comments-o' aria-hidden='true'></span></a>";
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
										->setFileName('my_report' . date('d/m/Y'))
									,
									(new ExcelExport())
										->setFileName('Models-'.  date('d/m/Y'))->setSheetName('Excel sheet'),
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
		return $grid->render();
	}

	public function getModelPending(){
		$query = UserModel
			::leftJoin('countries as c', 'users.countryId', '=', 'c.id')
			->select('users.*', 'users.id as check', 'users.id as action')
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
					$url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Suspend account'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
				}
				$url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/image-gallery/' . $val) . "' title='Galerías de imágenes'><span class='fa fa-picture-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/video-gallery/' . $val) . "' title='Video galerias'><span class='fa fa-video-camera'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/identification/' . $val) . "' title='Validar identificación'><span class='fa fa-file-text-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/model/chat/' . $val) . "' title='Administrar mensajes de chat'><span class='fa fa-comments-o' aria-hidden='true'></span></a>";
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
										->setFileName('my_report' . date('d/m/Y'))
									,
									(new ExcelExport())
										->setFileName('Models-'.  date('d/m/Y'))->setSheetName('Excel sheet'),
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
		return $grid->render();
	}

	public function getModelHighestEarn(){
		$query = EarningModel::select([
			DB::raw('sum(earnings.tokens) as totalEarning'),
			'u.*',
		])->join('users as u', 'u.id', '=', 'earnings.payTo')
			->where('u.role', UserModel::ROLE_MODEL)
			->groupBy('u.id');
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
			(new FieldConfig)
				->setName('email')
				->setLabel('Email')
				->setSortable(true)
				->setCallback(function ($val) {
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
				->setName('totalEarning')
				->setLabel('Total Token')
				->setSortable(true)
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
				$val = $item['id'];
				$url = "<a href='" . URL('admin/manager/model-profile/' . $val) . "' title='Editar cuenta'><span class='fa fa-pencil'></span></a>&nbsp;&nbsp;<a title='Borrar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres eliminar esta cuenta?')\" href='" . URL('admin/manager/profile/delete/' . $val) . "'><span class='fa fa-trash'></span></a>";
				if($item->accountStatus != UserModel::ACCOUNT_ACTIVE){
					$url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/approve/' . $val)."' title='Aprobar cuenta'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
				}
				if($item->accountStatus != UserModel::ACCOUNT_DISABLE){
					$url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/disable/' . $val) . "' title='Deshabilitar cuenta' onclick=\"return confirm('¿Estás seguro de que quieres deshabilitar esta cuenta?')\"><span class='fa fa-ban'></span></a>";
				}
				if($item->accountStatus == UserModel::ACCOUNT_ACTIVE){
					$url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Suspend account'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
				}
				$url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/image-gallery/' . $val) . "' title='Galerías de imágenes'><span class='fa fa-picture-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/video-gallery/' . $val) . "' title='Video galerias'><span class='fa fa-video-camera'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/identification/' . $val) . "' title='Validar identificación'><span class='fa fa-file-text-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/model/chat/' . $val) . "' title='Administrar mensajes de chat'><span class='fa fa-comments-o' aria-hidden='true'></span></a>";
				return $url;

			})
			->setSortable(false);
		}
		$grid = new Grid(
			(new GridConfig)
				->setDataProvider(
					new EloquentDataProvider($query)
				)
				->setName('EarnModels')
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
										->setFileName('my_report' . date('d/m/Y'))
									,
									(new ExcelExport())
										->setFileName('Models-'.  date('d/m/Y'))->setSheetName('Excel sheet'),
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
		return $grid->render();
	}

	public function getStudioPending() {
		$query = UserModel
			::leftJoin('countries as c', 'users.countryId', '=', 'c.id')
			->select('users.*', 'users.id as check', 'users.id as action')
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
				 ->setCallback(function($val){  
              		return $this->genero($val);
          		})
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
				->setName('Studio')
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
										->setFileName('my_report' . date('d/m/Y'))
									,
									(new ExcelExport())
										->setFileName('Studio-'.  date('d/m/Y'))->setSheetName('Excel sheet'),
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
		return $grid->render();
	}

	public function payoutRequest() {
		$query = PerformerPayoutRequest::join('performer as p', 'p.id', '=', 'performer_payout_requests.performerId')
	    ->join('users as u', 'p.user_id', '=', 'u.id')
	    ->select('performer_payout_requests.*', 'u.email as email', 'u.username as username', 'performer_payout_requests.id as action', 'performer_payout_requests.status as status')
			->where('studioRequestId', 0);
			$columns = [
				(new FieldConfig)
				->setName('id')
				->setLabel('ID')
				->setSortable(true)
				->setSorting(Grid::SORT_ASC)
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
				),
				(new FieldConfig)
				->setName('email')
				->setLabel('Email')
				->setSortable(true)
				->addFilter(
					(new FilterConfig)
					->setFilteringFunc(function($val, EloquentDataProvider $dp) {
						/** @var Illuminate\Database\Eloquent\Builder $builder */
						$builder = $dp->getBuilder();
						$builder->where('u.email', 'like', "%$val%");
					})
				),
				(new FieldConfig)
				->setName('dateFrom')
				->setLabel('Fecha de')
				->setSortable(true)
				->setCallback(function($val){
					$d = new \DateTime($val);
					return $d->format('d/m/Y');
				}),
				(new FieldConfig)
				->setName('dateTo')
				->setLabel('Fecha hasta')
				->setSortable(true)
				->setCallback(function($val){
					$d = new \DateTime($val);
					return $d->format('d/m/Y');
				}),
				(new FieldConfig)
				->setName('status')
				->setLabel('Status')
				->setSortable(true)
				->addFilter(
					(new SelectFilterConfig)
					->setName('status')
					->setOptions([
						'pending' => 'Pending',
						'approved' => 'Approved',
						'canecelled' => 'Cancelled',
						'done' => 'Done'
					])
					->setFilteringFunc(function($val, EloquentDataProvider $dp) {
						/** @var Illuminate\Database\Eloquent\Builder $builder */
						$builder = $dp->getBuilder();
						$builder->where('performer_payout_requests.status', $val);
					})
				),
				(new FieldConfig)
				->setName('createdAt')
				->setLabel('Fecha de solicitud')
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
						//$item = $row->getSrc();
						return "<a title='View' href='" . URL('admin/requestpayout/' . $val) . "'><span class='fa fa-eye'></span></a>"
										. "<a title='View' href='" . URL('admin/requestpayout/' . $val . '/delete') . "' onclick=\"return window.confirm('estas seguro?')\">"
										. "<span class='fa fa-trash'></span>"
										. "</a>";
					})
				->setSortable(false);
			}
	    $grid = new Grid(
	      (new GridConfig)
	        ->setDataProvider(
	          new EloquentDataProvider($query)
	        )
	        ->setName('PayoutRequest')
	        ->setPageSize(20)
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
	                100
	              ]),
	              new ColumnsHider,
	              (new CsvExport)
	              ->setFileName('my_report' . date('d/m/Y'))
	              ,
	              (new ExcelExport())
	              ->setFileName('Request-'.  date('d/m/Y'))->setSheetName('Excel sheet'),
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

		return $grid->render();

	}

  /**
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getSettings() {
    $settings = SettingModel::first();

    return view('Admin::admin_settings')->with('settings', $settings);
  }

  /**
   * @param int $modelDefaultReferredPercent 
   * @param int $studioDefaultReferredPercent 
   * @param int $modelDefaultPerformerPercent
   * @param int $modelDefaultPerformerPercent
   * @param int $studioDefaultPerformerPercent 
   * @param int $modelDefaultOtherPercent
   * @param int $modelDefaultOtherPercent 
   * @param int $memberJoinBonus  
   * @param string $fb_client_id 
   * @param string $fb_client_secret 
   * @param string $google_client_id 
   * @param string $google_client_secret 
   * @param string $tw_client_id 
   * @param string $tw_client_secret 
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function updateSettings() {
    
      $validator = Validator::make(Input::all(), [
        'modelDefaultReferredPercent' => 'Integer|Max:100|Min:0',
        'studioDefaultReferredPercent' => 'Integer|Max:100|Min:0',
        'modelDefaultPerformerPercent' => 'Integer|Max:100|Min:0',
        'modelDefaultPerformerPercent' => 'Integer|Max:100|Min:0',
        'studioDefaultPerformerPercent' => 'Integer|Max:100|Min:0',
        'modelDefaultOtherPercent' => 'Integer|Max:100|Min:0',
        'studioDefaultOtherPercent' => 'Integer|Max:100|Min:0',
        'memberJoinBonus' => 'Integer|Min:0',
        'private_price' => 'Required|Integer|Min:0',
        'group_price' => 'Required|Integer|Min:0',
        'min_tip_amount' => 'Required|Integer|Min:1',
        'conversionRate' => 'Required|Numeric|Min:0',
        'private_price' => 'Required|Integer|Min:0',
        'premiosUserConectados' => 'Integer|Min:0',
        'premiosTokens' => 'Integer|Min:0',
        'registerImage' => 'mimes:jpeg,bmp,png,gif',
        'banner' => 'mimes:jpeg,bmp,png,gif',
        'bannerdos' => 'mimes:jpeg,bmp,png,gif',
        'offlineImage' => 'mimes:jpeg,bmp,png,gif',
        'privateImage' => 'mimes:jpeg,bmp,png,gif',
        'groupImage' => 'mimes:jpeg,bmp,png,gif',
        //'bannerLink' => 'url',
        'placeholderAvatar1' => 'mimes:jpeg,bmp,png,gif',
        'placeholderAvatar2' => 'mimes:jpeg,bmp,png,gif',
        'placeholderAvatar3' => 'mimes:jpeg,bmp,png,gif',
        'TextEs' => 'Max:1000',
        'TextEn' => 'Max:1000',
        'TextFr' => 'Max:1000',
            'BannerHomeUno' => 'mimes:jpeg,bmp,png,gif',
        'BannerHomeDos' => 'mimes:jpeg,bmp,png,gif',
        'BannerHomeTres' => 'mimes:jpeg,bmp,png,gif',
        'BannerHomeCuatro' => 'mimes:jpeg,bmp,png,gif',
        'BannerHomeCinco' => 'mimes:jpeg,bmp,png,gif',
        'BannerHomeSeis' => 'mimes:jpeg,bmp,png,gif',
        'BannerHomeSiete' => 'mimes:jpeg,bmp,png,gif',
        'BannerHomeOcho' => 'mimes:jpeg,bmp,png,gif',
                'BannerHomeTextEs' => 'Max:80',
        'BannerHomeTextEn' => 'Max:80',
        'BannerHomeTextFr' => 'Max:80',

    ]);
    $validator->after(function ($validator) {
    	if (Input::file('tipSound')) {
	    	$tipExtension = Input::file('tipSound')->getClientOriginalExtension(); 
		    if($tipExtension !== 'mp3'){
		    	$validator->errors()->add('tipSound', "El sonido de la sugerencia debe ser un archivo de tipo: audio/mp3");	
		    }
		}
	});

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
      
    $modelReferred = (Input::has('modelDefaultReferredPercent')) ? Input::get('modelDefaultReferredPercent') : 0;
    $studioReferred = (Input::has('studioDefaultReferredPercent')) ? Input::get('studioDefaultReferredPercent') : 0;
    $modelPerformer = (Input::has('modelDefaultPerformerPercent')) ? Input::get('modelDefaultPerformerPercent') : 0;
    $studioPerformer = (Input::has('studioDefaultPerformerPercent')) ? Input::get('studioDefaultPerformerPercent') : 0;
    $modelOther = (Input::has('modelDefaultOtherPercent')) ? Input::get('modelDefaultOtherPercent') : 0;
    $studioOther = (Input::has('studioDefaultOtherPercent')) ? Input::get('studioDefaultOtherPercent') : 0;

    $message = null;
    // if ($modelReferred + $studioReferred > 100) {
    //   $message .= 'Total referred member percent of model and studio have to less than 100%';
    // }
    // if ($modelPerformer + $studioPerformer > 100) {
    //   $message .= '<br>Total Performer member percent of model and studio have to less than 100%';
    // }
    // if ($modelOther + $studioOther > 100) {
    //   $message .= '<br>Total Other member percent of model and studio have to less than 100%';
    // }
    if (!$message) {
      $settings = SettingModel::first();//(Input::has('id')) ? SettingModel::find(Input::get('id')) : new SettingModel;
      $settings->modelDefaultReferredPercent = $modelReferred;
      $settings->studioDefaultReferredPercent = $modelReferred;

      $settings->modelDefaultPerformerPercent = $modelReferred;
      $settings->studioDefaultPerformerPercent = $modelReferred;

      $settings->modelDefaultOtherPercent = $modelReferred;
      $settings->studioDefaultOtherPercent = $modelReferred;









      $settings->memberJoinBonus = (Input::has('memberJoinBonus')) ? Input::get('memberJoinBonus') : 0;
      $settings->private_price = (Input::has('private_price')) ? Input::get('private_price') : 0;
      $settings->group_price = (Input::has('group_price')) ? Input::get('group_price') : 0;
      $settings->min_tip_amount = (Input::has('min_tip_amount')) ? Input::get('min_tip_amount') : 10;
      $settings->conversionRate = Input::get('conversionRate');
      $settings->bannerLink = Input::get('bannerLink');
      $settings->bannerLinkDos = Input::get('bannerLinkDos');
       $settings->bannerLink = Input::get('bannerLink');
      $settings->premiosUserConectados = Input::get('premiosUserConectados');
      $settings->premiosTokens = Input::get('premiosTokens');
      $settings->bannerLinkHomePage = Input::get('bannerLinkHomePage');
      $settings->TextEs = Input::get('TextEs');
      $settings->TextEn = Input::get('TextEn');
      $settings->TextFr = Input::get('TextFr');
      $settings->referidosTokens = Input::get('referidosTokens');
      $settings->BannerHomeUnoLink = Input::get('BannerHomeUnoLink');
      $settings->BannerHomeDosLink = Input::get('BannerHomeDosLink');
      $settings->BannerHomeTresLink = Input::get('BannerHomeTresLink');
      $settings->BannerHomeCuatroLink = Input::get('BannerHomeCuatroLink');
      $settings->BannerHomeCincoLink = Input::get('BannerHomeCincoLink');
      $settings->BannerHomeSeisLink = Input::get('BannerHomeSeisLink');
      $settings->BannerHomeSieteLink = Input::get('BannerHomeSieteLink');
      $settings->BannerHomeOchoLink = Input::get('BannerHomeOchoLink');


      $settings->BannerHomeTextEs = Input::get('BannerHomeTextEs');
      $settings->BannerHomeTextEn = Input::get('BannerHomeTextEn');
      $settings->BannerHomeTextFr = Input::get('BannerHomeTextFr');
      if (Input::file('banner')) {
        
        
        $extension = Input::file('banner')->getClientOriginalExtension(); // getting image extension
        $banner = 'banner.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$banner)) {
         \File::Delete(public_path('images').'/'.$banner);
        }
        Input::file('banner')->move(public_path('images'), $banner); // uploading file to given path
        // sending back with message
       
        $settings->banner = 'images/' . $banner;
      }



  if (Input::file('BannerHomeUno')) {
        
        $extension = Input::file('BannerHomeUno')->getClientOriginalExtension(); // getting image extension
        $BannerHomeUno = 'BannerHomeUno.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$BannerHomeUno)) {
         \File::Delete(public_path('images').'/'.$BannerHomeUno);
        }
        Input::file('BannerHomeUno')->move(public_path('images'), $BannerHomeUno); // uploading file to given path
        // sending back with message
       
        $settings->BannerHomeUno = 'images/' . $BannerHomeUno;
      }



  if (Input::file('BannerHomeDos')) {
        
        $extension = Input::file('BannerHomeDos')->getClientOriginalExtension(); // getting image extension
        $BannerHomeDos = 'BannerHomeDos.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$BannerHomeDos)) {
         \File::Delete(public_path('images').'/'.$BannerHomeDos);
        }
        Input::file('BannerHomeDos')->move(public_path('images'), $BannerHomeDos); // uploading file to given path
        // sending back with message
       
        $settings->BannerHomeDos = 'images/' . $BannerHomeDos;
      }

  if (Input::file('BannerHomeTres')) {
        
        $extension = Input::file('BannerHomeTres')->getClientOriginalExtension(); // getting image extension
        $BannerHomeTres = 'BannerHomeTres.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$BannerHomeTres)) {
         \File::Delete(public_path('images').'/'.$BannerHomeTres);
        }
        Input::file('BannerHomeTres')->move(public_path('images'), $BannerHomeTres); // uploading file to given path
        // sending back with message
       
        $settings->BannerHomeTres = 'images/' . $BannerHomeTres;
      }



  if (Input::file('BannerHomeCuatro')) {
        
        $extension = Input::file('BannerHomeCuatro')->getClientOriginalExtension(); // getting image extension
        $BannerHomeCuatro = 'BannerHomeCuatro.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$BannerHomeCuatro)) {
         \File::Delete(public_path('images').'/'.$BannerHomeCuatro);
        }
        Input::file('BannerHomeCuatro')->move(public_path('images'), $BannerHomeCuatro); // uploading file to given path
        // sending back with message
       
        $settings->BannerHomeCuatro = 'images/' . $BannerHomeCuatro;
      }




  if (Input::file('BannerHomeCinco')) {
        
        $extension = Input::file('BannerHomeCinco')->getClientOriginalExtension(); // getting image extension
        $BannerHomeCinco = 'BannerHomeCinco.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$BannerHomeCinco)) {
         \File::Delete(public_path('images').'/'.$BannerHomeCinco);
        }
        Input::file('BannerHomeCinco')->move(public_path('images'), $BannerHomeCinco); // uploading file to given path
        // sending back with message
       
        $settings->BannerHomeCinco = 'images/' . $BannerHomeCinco;
      }


  if (Input::file('BannerHomeSeis')) {
        
        $extension = Input::file('BannerHomeSeis')->getClientOriginalExtension(); // getting image extension
        $BannerHomeSeis = 'BannerHomeSeis.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$BannerHomeSeis)) {
         \File::Delete(public_path('images').'/'.$BannerHomeSeis);
        }
        Input::file('BannerHomeSeis')->move(public_path('images'), $BannerHomeSeis); // uploading file to given path
        // sending back with message
       
        $settings->BannerHomeSeis = 'images/' . $BannerHomeSeis;
      }


  if (Input::file('BannerHomeSiete')) {
        
        $extension = Input::file('BannerHomeSiete')->getClientOriginalExtension(); // getting image extension
        $BannerHomeSiete = 'BannerHomeSiete.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$BannerHomeSiete)) {
         \File::Delete(public_path('images').'/'.$BannerHomeSiete);
        }
        Input::file('BannerHomeSiete')->move(public_path('images'), $BannerHomeSiete); // uploading file to given path
        // sending back with message
       
        $settings->BannerHomeSiete = 'images/' . $BannerHomeSiete;
      }


  if (Input::file('BannerHomeOcho')) {
        
        $extension = Input::file('BannerHomeOcho')->getClientOriginalExtension(); // getting image extension
        $BannerHomeOcho = 'BannerHomeOcho.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$BannerHomeOcho)) {
         \File::Delete(public_path('images').'/'.$BannerHomeOcho);
        }
        Input::file('BannerHomeOcho')->move(public_path('images'), $BannerHomeOcho); // uploading file to given path
        // sending back with message
       
        $settings->BannerHomeOcho = 'images/' . $BannerHomeOcho;
      }



  if (Input::file('bannerdos')) {
        
        $extension = Input::file('bannerdos')->getClientOriginalExtension(); // getting image extension
        $bannerdos = 'bannerdos.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$bannerdos)) {
         \File::Delete(public_path('images').'/'.$bannerdos);
        }
        Input::file('bannerdos')->move(public_path('images'), $bannerdos); // uploading file to given path
        // sending back with message
       
        $settings->bannerdos = 'images/' . $bannerdos;
      }

      if (Input::file('offlineImage')) {
        $extension = Input::file('offlineImage')->getClientOriginalExtension(); // getting image extension
        $offline = 'offline-image.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$offline)) {
          \File::Delete(public_path('images').'/'.$offline);
        }
        Input::file('offlineImage')->move(public_path('images'), $offline); // uploading file to given path
        // sending back with message
        
        $settings->offlineImage = 'images/' . $offline;
      }
      if (Input::file('privateImage')) {
        $extension = Input::file('privateImage')->getClientOriginalExtension(); // getting image extension
        $private = 'private-image.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$private)) {
          \File::Delete(public_path('images').'/'.$private);
        }
        Input::file('privateImage')->move(public_path('images'), $private); // uploading file to given path
        // sending back with message
        
        $settings->privateImage = 'images/' . $private;
      }
      if (Input::file('groupImage')) {
        $extension = Input::file('groupImage')->getClientOriginalExtension(); // getting image extension
        $group = 'group-image.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$group)) {
          \File::Delete(public_path('images').'/'.$group);
        }
        Input::file('groupImage')->move(public_path('images'), $group); // uploading file to given path
        // sending back with message
        
        $settings->groupImage = 'images/'.$group;
      }
      if (Input::file('registerImage')) {
        $extension = Input::file('registerImage')->getClientOriginalExtension(); // getting image extension
        $registerImage = 'register-image.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$registerImage)) {
          \File::Delete(public_path('images').'/'.$registerImage);
        }
        Input::file('registerImage')->move(public_path('images'), $registerImage); // uploading file to given path
        
        $settings->registerImage = 'images/'.$registerImage;
      }

      if (Input::file('tipSound')) {
        
        $extension = Input::file('tipSound')->getClientOriginalExtension(); // getting image extension
        $tipSound = 'received_message.' . $extension; // renameing image
        if (file_exists(public_path('sounds').'/'.$tipSound)) {
         \File::Delete(public_path('sounds').'/'.$tipSound);
        }
        Input::file('tipSound')->move(public_path('sounds'), $tipSound); // uploading file to given path
        // sending back with message
       
        $settings->tipSound = 'sounds/' . $tipSound;
      }

      if (Input::file('placeholderAvatar1')) {
        
        $extension = Input::file('placeholderAvatar1')->getClientOriginalExtension(); // getting image extension
        $placeholderAvatar1 = 'avatar1.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$placeholderAvatar1)) {
         \File::Delete(public_path('images').'/'.$placeholderAvatar1);
        }
        Input::file('placeholderAvatar1')->move(public_path('images'), $placeholderAvatar1); // uploading file to given path
        $settings->placeholderAvatar1 = 'images/' . $placeholderAvatar1;
      }
      if (Input::file('placeholderAvatar2')) {
        $extension = Input::file('placeholderAvatar2')->getClientOriginalExtension(); // getting image extension
        $placeholderAvatar2 = 'avatar2.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$placeholderAvatar2)) {
         \File::Delete(public_path('images').'/'.$placeholderAvatar2);
        }
        Input::file('placeholderAvatar2')->move(public_path('images'), $placeholderAvatar2); // uploading file to given path
        $settings->placeholderAvatar2 = 'images/' . $placeholderAvatar2;
        
      }
      if (Input::file('placeholderAvatar3')) {
        $extension = Input::file('placeholderAvatar3')->getClientOriginalExtension(); // getting image extension
        $placeholderAvatar3 = 'avatar3.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$placeholderAvatar3)) {
         \File::Delete(public_path('images').'/'.$placeholderAvatar3);
        }
        Input::file('placeholderAvatar3')->move(public_path('images'), $placeholderAvatar3); // uploading file to given path
        $settings->placeholderAvatar3 = 'images/' . $placeholderAvatar3;
      }

      if(Input::get('deleteImg')){
        foreach (Input::get('deleteImg') as $value){
          if (file_exists(public_path('images') . $settings->$value)) {
              \File::Delete(public_path('images') . '/' . $settings->$value);
          }
          $settings->$value = null;
      }
    }
      
      if ($settings->save()) {

			$affected = DB::table('earningsettings')->update(array('referredMember' =>$modelReferred,'performerSiteMember' => $modelReferred,'otherMember' => $modelReferred));


			return Redirect::to('admin/dashboard/settings')->with('msgInfo', 'La configuración se actualizó correctamente.');

		 
      }
      $message = 'System error.';
    }
    return Back()->withInput()->with('msgError', $message);
  }

  /**
   * @return response 
   * 
   */
  public function getSeoSettings() {
    $settings = SettingModel::first();
    
    return view('Admin::admin_seo_settings')->with('settings', $settings);
  }

  /**
   * @param string $Title
   * @param string $Description
   * @param String $Keywords
   * @param file $logo
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function updateSeoSettings() {
    $this->validate(request(), [
        'title' => 'Required|Max:160',
        'siteName' => 'Required|Max:100',
        'description' => 'Max:160',
        'keywords' => 'Max:160',
        'logo' => 'Max:1000|Mimes:jpg,jpeg,png',
        'favicon' => 'Max:1000|Mimes:jpg,jpeg,png',
    ]);

    $settings = SettingModel::first();//(Input::has('id')) ? SettingModel::find(Input::get('id')) : new SettingModel;
    $settings->title = Input::get('title');
    $settings->siteName = Input::get('siteName');
    $settings->description = Input::get('description');

    $settings->keywords = Input::get('keywords');

    if (Input::file('logo')) {
      // checking file is valid.
      if (!Input::file('logo')->isValid()) {
        return Back()->with('msgInfo', 'el archivo cargado no es válido');
      }
      $destinationPath = PATH_UPLOAD; // upload path
      $extension = Input::file('logo')->getClientOriginalExtension(); // getting image extension
      $fileName = 'logo-' . rand(11111, 99999) . '.' . $extension; // renameing image
      if (file_exists($destinationPath . '/' . $settings->logo)) {
        \File::Delete($destinationPath . '/' . $settings->logo);
      }
      Input::file('logo')->move($destinationPath, $fileName); // uploading file to given path
      // sending back with message
      
      $settings->logo = $fileName;
    }
      if (Input::file('favicon')) {
          // checking file is valid.
          if (!Input::file('favicon')->isValid()) {
              return Back()->with('msgInfo', 'el archivo cargado no es válido');
          }
          $destinationPath = PATH_UPLOAD; // upload path
          $extension = Input::file('favicon')->getClientOriginalExtension(); // getting image extension
          $fileName = 'favicon-' . rand(11111, 99999) . '.' . $extension; // renameing image
          if (file_exists($destinationPath . '/' . $settings->favicon)) {
              \File::Delete($destinationPath . '/' . $settings->favicon);
          }
          Input::file('favicon')->move($destinationPath, $fileName); // uploading file to given path
          // sending back with message
          
          $settings->favicon = $fileName;
      }
      if(Input::get('deleteImg')){
        foreach (Input::get('deleteImg') as $value){
            $destinationPath = PATH_UPLOAD;
            if (file_exists($destinationPath . '/' . $settings->$value)) {
                \File::Delete($destinationPath . '/' . $settings->$value);
            }
            $settings->$value = null;
        }
      }
    $settings->code_before_head_tag = Input::get('code_before_head_tag');
    $settings->code_before_body_tag = Input::get('code_before_body_tag');
    if ($settings->save()) {
      return Back()->with('msgInfo', 'La configuración se actualizó correctamente');
    }

    return Back()->withInput()->with('msgError', 'Error del sistema.');
  }


 private function genero($str){

 	$genero = array('male'=>'Hombre','female'=>'Mujer', 'transgender' => 'transgenero','pareja' => 'pareja');
    return $genero[$str];
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

}
