@extends('admin-back-end')
@section('title', 'Páginas')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Páginas</li>')
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
        <div class="col-sm-12">
            <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
            <a class="btn btn-info btn-sm" href="{{URL('admin/page/new')}}">Agregar nueva página</a>
            <?php } ?>
          </div>
            <style>
                #page_grid td {
                    white-space: nowrap;
                }
            </style>
{!! $grid !!}
        </div>
      </div>
    </div>
  </div>
</div>
@stop
