<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Detalle de la comisión')
@section('breadcrumb', '<li><a href="/admin/manager/commission"><i class="fa fa-dashboard"></i> Comisión</a></li><li class="active">Detalles</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"> Editar comisión</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <form method="post" action="" role="form">
        <div class="box-body">
          <div class="form-group">
            <label for="referredMember">Comisión %</label>
            <!--<input class="form-control" id="name" value="{{old('referredMember', $commission->referredMember)}}" autocomplete="off" name="referredMember" placeholder="" type="number">-->
            <input type="number" class="form-control" name="referredMember" min="0" max="100" value="{{old('referredMember', $commission->referredMember)}}">
             
            <span class="text-red">{{$errors->first('referredMember')}}</span>
          </div>
          <div class="form-group hidden">
            <label for="performerSiteMember">Miembro del sitio del artista (Performer Site Member) %</label>
            <!--<input class="form-control" id="performerSiteMember" value="{{old('performerSiteMember', $commission->performerSiteMember)}}" autocomplete="off" name="performerSiteMember" placeholder="" type="number">-->
            
            <input type="number" class="form-control" name="performerSiteMember" min="0" max="{{($commission->performer1 + $commission->performer2 > 0) ? (100 - ($commission->performer1+$commission->performer2)) : 100}}" value="{{old('performerSiteMember', $commission->performerSiteMember)}}">
              
            <span class="text-red">{{$errors->first('performerSiteMember')}}</span>
          </div>
          <div class="form-group hidden">
            <label for="otherMember">Otro miembro %</label>
            <!--<input class="form-control" id="otherMember" autocomplete="off" value="{{old('otherMember', $commission->otherMember)}}" name="otherMember" placeholder="" type="number">-->
            <input type="number" class="form-control" name="otherMember" min="0" max="{{($commission->other1 + $commission->other2 > 0) ? (100 - ($commission->other1 + $commission->other2)) : 100}}" value="{{old('otherMember', $commission->otherMember)}}">
            
            <span class="text-red">{{$errors->first('otherMember')}}</span>
          </div>
        </div>
        <div class="box-footer text-center">

          <button type="submit" class="btn btn-danger btn-lg">Actualizar</button>
        </div>
      </form>
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@stop
