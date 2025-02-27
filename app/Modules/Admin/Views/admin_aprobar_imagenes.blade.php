<?php 

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Lista de Galerías')

@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Artistas intérpretes o ejecutantes</li>')
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

            </div>
            <style>
                #page_grid td {
                    white-space: nowrap;
                }

                .fa{
                  font-size: 18px;
                }
            </style>
            {!! $grid !!}
            <div class="col-sm-12">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop