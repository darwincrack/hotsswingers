<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Gestionar transacciones')
@section('breadcrumb', '<li><a href="/admin/manager/members"><i class="fa fa-dashboard"></i> Miembros</a></li><li class="active">Transacciones</li>')
@section('content')

<div class="row">
  <div class="col-sm-12" ng-controller="paymentCtrl">
    <div class="box">

      <div class="box-body">
        
        <div class="table-responsive">
            <style>
                #page_grid td {
                    white-space: nowrap;
                }
            </style>
            <ng-form-submit>{!! $grid !!}</ng-form-submit>
            <div class="col-sm-12">
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop