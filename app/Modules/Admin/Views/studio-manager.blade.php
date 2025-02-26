@extends('admin-back-end')
@section('title', 'Administrar estudios')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Estudios</li>')
@section('content')
<?php 
use App\Helpers\Session as AppSession;
$adminData = AppSession::getLoginData();
?>
<div class="row">
  <div class="col-sm-12">
    <div class="box">

      <div class="box-body">
        <div class="table-responsive">
            <div class="col-sm-12 form-filter">
            <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
              <a class="btn btn-info btn-sm" href="{{URL('admin/manager/studio/add')}}">Agregar nuevo</a>
            <?php } ?>
            </div>
            <style>
                #page_grid td {
                    white-space: nowrap;
                }
            </style>
            {!! $grid !!}
          <div class="col-sm-12">
          <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
            <button class="btn btn-danger btn-sm" onclick="changeAllAccountStatus('disable')">Desactivar todo</button>&nbsp;&nbsp;<button class="btn btn-success btn-sm" onclick="changeAllAccountStatus('active')">Aprobar todo</button>&nbsp;&nbsp;<button class="btn btn-warning btn-sm" onclick="changeAllAccountStatus('suspend')">Suspender todo</button>&nbsp;&nbsp;<span class="processing-event"></span>
          <?php }?>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
@stop
