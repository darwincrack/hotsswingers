<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Detalle de la comisión')
@section('breadcrumb', '<li><a href="/admin/manager/commission"><i class="fa fa-dashboard"></i> Comisión</a></li><li class="active">Detalle</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-8">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{$commission->username}} Comisión</h3>
        <span class="pull-right"><a class="btn btn-warning btn-sm" href="{{URL('admin/manager/commission/edit/'.$commission->id)}}">Editar</a></span>
      </div><!-- /.box-header -->
      <!-- form start -->
      <div class="box-body">
        <table class="table table-bordered">
          <tr>
            <th style="width: 10px">#</th>
            <th>Username</th>
            <th>Rol</th>
            <th>Miembro referido</th>
            <th>Miembro del sitio del artista</th>
            <th>Otro miembro</th>
          </tr>
          <tr>
            <td>1.</td>
            <td>{{$commission->username}}</td>
            <td>
             Administrador del sitio
            </td>
            <td><span class="badge bg-red">{{$commission->referredMember}}%</span></td>
            <td><span class="badge bg-red">{{$commission->performerSiteMember}}%</span></td>
            <td><span class="badge bg-red">{{$commission->otherMember}}%</span></td>
          </tr>
          <tr>
            <td>2.</td>
            <td>{{$commission->studioName}}</td>
            <td>
              Studio
            </td>
            <td><span class="badge bg-yellow">{{$commission->studioReferredMember}}%</span></td>
            <td><span class="badge bg-yellow">{{$commission->studioPerformerSiteMember}}%</span></td>
            <td><span class="badge bg-yellow">{{$commission->studioOtherMember}}%</span></td>
          </tr>
          <tr>
            <td>3.</td>
            <td>{{$commission->modelName}}</td>
            <td>
              Modelo
            </td>
            <td><span class="badge bg-blue">{{$commission->modelReferredMember}}%</span></td>
            <td><span class="badge bg-blue">{{$commission->modelPerformerSiteMember}}%</span></td>
            <td><span class="badge bg-blue">{{$commission->modelOtherMember}}%</span></td>
          </tr>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
