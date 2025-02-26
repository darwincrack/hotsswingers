<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Miembro')
@section('breadcrumb', '<li><a href="/admin/manager/members"><i class="fa fa-dashboard"></i> Miembros</a></li><li class="active">Agregar nueva miembro </li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Agregar nueva miembro</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      {!! Form::open(array('method'=>'post', 'role'=>'form')) !!}
        <div class="box-body">
          <div class="form-group required">
              <label for="gender" class="control-label">Género</label>
            <div class="input-group" id="gender-group">
              @include('render_gender_block')
            </div>
            <label class="text-red">{{$errors->first('gender')}}</label>
          </div>

          <div class="form-group required">
              <label for="firstname" class="control-label">Nombre</label>
            <input type="text" class="form-control" name="firstName" id="firstname" placeholder="" maxlength="32" value="{{Request::old('firstName')}}">
            <label class="text-red">{{$errors->first('firstName')}}</label>
          </div>
          <div class="form-group required">
              <label for="lastname" class="control-label">Apellido</label>
            <input type="text" class="form-control" id="lastname" name="lastName" placeholder="" maxlength="32" value="{{Request::old('lastName')}}">
            <label class="text-red">{{$errors->first('lastName')}}</label>
          </div>
          <div class="form-group required">
              <label for="username" class="control-label">Nombre de usuario </label>
            <input type="text" class="form-control" id="username" placeholder="Ingrese Nombre de usuario" name="username" value="{{Request::old('username')}}">
            <label class="text-red">{{$errors->first('username')}}</label>
          </div>
          <div class="form-group required">
              <label for="email" class="control-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese email" value="{{Request::old('email')}}">
            <label class="text-red">{{$errors->first('email')}}</label>
          </div>
          <div class="form-group required">
              <label for="password" class="control-label">Contraseña </label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" value="{{old('password')}}">
            <label class="text-red">{{$errors->first('password')}}</label>
          </div>
          <div class="form-group required">
              <label for="password_confirmation" class="control-label">Confirmar contraseña </label>
            <input type="password" class="form-control" id="confirmed" name="password_confirmation" placeholder="Confirmar contraseña" value="{{old('password_confirmation')}}">
            <label class="text-red">{{$errors->first('password_confirmation')}}</label>
          </div>
          <div class="form-group">
            <label for="tokens">Tokens</label>
            <input type="number" class="form-control" id="tokens" name="tokens" placeholder="tokens" value="{{old('tokens')}}">
            <label class="text-red">{{$errors->first('tokens')}}</label>
          </div>
          <div class="form-group required">
              <label for="location" class="control-label">Ubicación </label>
            {{Form::select('location', $countries, old('location'), array('class'=>'form-control ', 'placeholder' => 'Por favor seleccione...'))}}
            <label class="text-red">{{$errors->first('location')}}</label>
          </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
       {{Form::close()}}
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
