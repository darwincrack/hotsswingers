<?php 

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Administrar mensajes de chat')

@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Chat modelo</li>')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box">

      <div class="box-body">
        
        <div class="table-responsive">
            <style>
                #page_grid td {
                    white-space: nowrap;
                }
            </style>
            <ng-form-submit>{!! $grid->render() !!}</ng-form-submit>
            <div class="col-sm-12">
            <button class="btn btn-danger btn-sm" onclick="deleteAllChatMessages()">Eliminar todos</button>&nbsp;&nbsp;<span class="processing-event"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop