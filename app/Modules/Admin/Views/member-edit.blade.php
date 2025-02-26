<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'usuario')
@section('breadcrumb', '<li><a href="/admin/manager/members"><i class="fa fa-dashboard"></i> Miembros</a></li><li class="active">Editar usuario</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Editar usuario</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      {!! Form::open(array('method'=>'post', 'role'=>'form')) !!}
        <div class="box-body">
          <div class="form-group">
            <label for="gender">Género</label>
            <div class="input-group" id="gender-group">
              @include('render_gender_block', array('default' => old('gender', $user->gender)))
            </div>
            <label class="label label-danger">{{$errors->first('gender')}}</label>
          </div>

          <div class="form-group required">
              <label for="firstname" class="control-label">Nombre </label>
            <input type="text" class="form-control" name="firstName" id="firstname" placeholder="" maxlength="32" value="{{Request::old('firstName', $user->firstName)}}">
            <label class="label label-danger">{{$errors->first('firstName')}}</label>
          </div>
          <div class="form-group required">
              <label for="lastname" class="control-label">Apellido </label>
            <input type="text" class="form-control" id="lastname" name="lastName" placeholder="" maxlength="32" value="{{Request::old('lastName', $user->lastName)}}">
            <label class="label label-danger">{{$errors->first('lastName')}}</label>
          </div>
          <div class="form-group required">
              <label for="username" class="control-label">Nombre de usuario </label>
            <input type="text" class="form-control" id="username" placeholder="Ingresa Nombre de usuario" name="username" value="{{old('username', $user->username)}}">
            <label class="label label-danger">{{$errors->first('username')}}</label>
          </div>
          <div class="form-group required">
              <label for="email" class="control-label">Email </label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa email" value="{{$user->email}}" disabled="disabled">
            <label class="label label-danger">{{$errors->first('email')}}</label>
          </div>
          
          <div class="form-group">
            <label for="passwordHash">Contraseña</label>
            <span class="help-block">(cambio de contraseña: ingrese NUEVA contraseña)</span>
            <input type="password" class="form-control" id="passwordHash" name="passwordHash" placeholder="Password" value="{{old('passwordHash')}}">
            <label class="label label-danger">{{$errors->first('passwordHash')}}</label>
          </div>
            
          <div class="form-group">
            <label for="tokens">Tokens</label>
            <input type="number" class="form-control" id="tokens" name="tokens" placeholder="tokens" step="any" value="{{old('tokens', $user->tokens)}}">
            <label class="text-red">{{$errors->first('tokens')}}</label>
          </div>
            
          <div class="form-group required">
              <label for="location" class="control-label">Ubicación </label>
            {{Form::select('location', $countries, old('location', $user->location_id), array('class'=>'form-control ', 'placeholder' => 'Por favor seleccione ...'))}}
            <label class="label label-danger">{{$errors->first('location')}}</label>
          </div>
            
          <div class="form-group required">
              <label for="role" class="control-label">Role </label>
            {{Form::select('role', array('admin'=>'Admin'), old('role', $user->role), array('class'=>'form-control ', 'placeholder' => 'Por favor seleccione ...'))}}
            <label class="label label-danger">{{$errors->first('role')}}</label>
          </div>
            
          
          
        </div><!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Guardar cambios</button>&nbsp;&nbsp;
          <a class="btn btn-danger"  href="javascript:confirmDelete('¿Estás seguro de que quieres deshabilitar esta cuenta?', {{$user->id}})">inhabilitar</a>
        </div>
      {!!Form::close()!!}
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
