<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Modelo')
@section('breadcrumb', '<li><a href="/admin/manager/performers"><i class="fa fa-dashboard"></i> Modelos</a></li><li class="active">Agregar nuevo modelo</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Agregar nuevo modelo</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
        {!! Form::open(array('method'=>'post', 'role'=>'form', 'enctype' => 'multipart/form-data')) !!}
        <div class="row">
          <div class="col-md-6">
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
                <input type="text" class="form-control" id="username" placeholder="Ingrese nombre de usuario" name="username" value="{{Request::old('username')}}">
                <label class="text-red">{{$errors->first('username')}}</label>
              </div>
              <div class="form-group required">
                  <label for="email" class="control-label">Email </label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese email" value="{{Request::old('email')}}">
                <label class="text-red">{{$errors->first('email')}}</label>
              </div>
              <div class="form-group required">
                  <label for="passwordHash" class="control-label">Contraseña </label>
                <input type="password" class="form-control" id="passwordHash" name="passwordHash" placeholder="Contraseña" value="{{old('passwordHash')}}">
                <label class="text-red">{{$errors->first('passwordHash')}}</label>
              </div>
              <div class="form-group required">
                  <label for="passwordHash_confirmation" class="control-label">Confirmar Contraseña </label>
                <input type="password" class="form-control" id="confirmed" name="passwordHash_confirmation" placeholder="Confirm Password" value="{{old('passwordHash_confirmation')}}">
                <label class="text-red">{{$errors->first('passwordHash_confirmation')}}</label>
              </div>
              <div class="form-group required">
                  <label for="country" class="control-label">Ubicación </label>
                {{Form::select('country', $countries, old('countryId'), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}
                
                <label class="text-red">{{$errors->first('country')}}</label>
              </div>
              <div class="form-group">
                <label for="manager">Studio</label>
                {{Form::select('manager', $manager, old('manager'), array('class'=>'form-control ', 'placeholder' => 'Por favor seleccione...'))}}
                
                <label class="text-red">{{$errors->first('manager')}}</label>
              </div>
              <div class="form-group required">
                <label for="stateName" class="control-label">Estado</label>
                <input type="text" class="form-control" id="stateName" name="stateName" placeholder="" maxlength="32" value="{{old('stateName')}}">
                <label class="text-red">{{$errors->first('stateName')}}</label>
              </div>
              <div class="form-group required">
                <label for="cityName" class="control-label">Ciudad</label>
                <input type="text" class="form-control" id="cityName" name="cityName" placeholder="" maxlength="32" value="{{old('cityName')}}">
                <label class="text-red">{{$errors->first('cityName')}}</label>
              </div>
              <div class="form-group required">
                <label for="zip" class="control-label">Codigo postal</label>
                <input type="text" class="form-control" id="zip" name="zip" placeholder="" maxlength="32" value="{{old('zip')}}">
                <label class="text-red">{{$errors->first('zip')}}</label>
              </div>
              <div class="form-group required">
                <label for="address1" class="control-label">Dirección 1</label>
                <input type="text" class="form-control" id="address1" name="address1" placeholder="" maxlength="32" value="{{old('address1')}}">
                <label class="text-red">{{$errors->first('address1')}}</label>
              </div>
              <div class="form-group required">
                <label for="address2" class="control-label">Dirección 2</label>
                <input type="text" class="form-control" id="address2" name="address2" placeholder="" maxlength="32" value="{{old('address2')}}">
                <label class="text-red">{{$errors->first('address2')}}</label>
              </div>
              <div class="form-group required">
                <label for="mobilePhone" class="control-label">Teléfono móvil</label>
                <input type="text" class="form-control" id="mobilePhone" name="mobilePhone" placeholder="" maxlength="32" value="{{old('mobilePhone')}}">
                <label class="text-red">{{$errors->first('mobilePhone')}}</label>
              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="col-md-6">
            <div class="box-body">
              <div class="form-group">
                <label for="gender" class="control-label">Foto de perfil</label>
                <input name="myFiles" id="myFiles" type="file" />
                <label class="text-red">{{$errors->first('myFiles')}}</label>
              </div>
              <div class="form-group">
                <label for="gender" class="control-label">Imagen de identificación</label>
                <input name="idImage" id="idImage" type="file" />
                <label class="text-red">{{$errors->first('idImage')}}</label>
              </div>

              <div class="form-group">
                <label for="gender" class="control-label">Imagen de identificación 2</label>
                <input name="idImage2" id="idImage2" type="file" />
                <label class="text-red">{{$errors->first('idImage2')}}</label>
              </div>
              <div class="form-group">
                <label for="gender" class="control-label">Imagen de Face ID</label>
                <input name="faceId" id="faceId" type="file" />
                <label class="text-red">{{$errors->first('faceId')}}</label>
              </div>
              <div class="form-group">
                <label for="gender" class="control-label">Forma de liberación</label>
                <input name="releaseForm" id="releaseForm" type="file" />
                <label class="text-red">{{$errors->first('releaseForm')}}</label>
              </div>
              <div class="form-group">
                <label for="gender" class="control-label">Opciones de pago</label>
              </div>
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#paymentinfo" data-toggle="tab" aria-expanded="true">Payment Info</a></li>
                  <li><a href="#directdeposit" data-toggle="tab" aria-expanded="true">Deposito directo</a></li>
                  <li><a href="#paxumpayonee" data-toggle="tab" aria-expanded="true">@lang('messages.paxum')</a></li>
                  <li><a href="#bitpay" data-toggle="tab" aria-expanded="true">Bitpay</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="paymentinfo">
                    @include('Studio::payeeForm', ['bankTransferOptions' => $bankTransferOptions])
                  </div>
                  <div class="tab-pane" id="directdeposit">
                    @include('Studio::directDepositForm', ['directDeposit' => $directDeposit])
                  </div>
                  <div class="tab-pane" id="paxumpayonee">
                    @include('Studio::paxumForm', ['paxum' => $paxum])
                  </div>
                  <div class="tab-pane" id="bitpay">
                    @include('Studio::bitpayForm', ['bitpay' => $bitpay])
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="gender" class="control-label">Aprobar transacciones automáticamente</label><br>
                <input name="autoApprovePayment" id="autoApprovePayment" type="checkbox" value="1" checked="" />
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">
          {{Form::submit('Submit', array('class'=>'btn btn-primary'))}}
        </div>
      {!!Form::close()!!}
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
