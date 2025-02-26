@extends('admin-back-end')
@section('title', 'Configuración de pago')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Configuración de pago</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Actualizar la información de pago de PaynoPain</h3>
      </div><!-- /.box-header -->
      
        {!! Form::open(array('method'=>'post', 'role'=>'form', 'novalidate')) !!}
        <div class="box-body">
         <!-- <div class="form-group">
            {!!Form::label('name', 'Name')!!}
            {{Form::text('name', old('name', $payment->name), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Payment Name'))}}
            <span class="text-red">{{$errors->first('name')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('shortname', 'Short name')}}
            {{Form::text('shortname', old('shortname', $payment->shortname), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Short Name'))}}
            <span class="text-red">{{$errors->first('shortname')}}</span>
          </div>
          <div class="form-group">
            <label for="description">Descripción</label>
            <input class="form-control" id="description" autocomplete="off" value="{{old('description', $payment->description)}}" name="description" placeholder="Description" type="text">
          </div>-->



        <div class="form-group">
            <label for="description">url entorno</label>
            <input class="form-control" id="url_entorno" autocomplete="off" value="{{old('url_entorno', $payment->url_entorno)}}" name="url_entorno" placeholder="url_entorno" type="text">
          </div>

<div class="form-group">
            <label for="description">Signature</label>
            <input class="form-control" id="signature" autocomplete="off" value="{{old('signature', $payment->signature)}}" name="signature" placeholder="signature" type="text">
          </div>

        <div class="form-group">
            <label for="description">Api key (El sistema convierte este valor a base64 automaticamente)</label>
            <input class="form-control" id="api_key" autocomplete="off" value="{{old('api_key', $payment->api_key)}}" name="api_key" placeholder="api_key" type="text">
          </div>
          

        <div class="form-group">
            <label for="description">Service</label>
            <input class="form-control" id="service" autocomplete="off" value="{{old('service', $payment->service)}}" name="service" placeholder="service" type="text">
          </div>

          <div class="form-group">
            {{Form::label('formName', 'Nombre del formulario (template_uuid)')}}
            {{Form::text('formName', old('formName', $payment->formName), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Nombre del formulario'))}}
            <span class="text-red">{{$errors->first('formName')}}</span>
          </div>



        <!--  <div class="form-group">
            {{Form::label('accountNumber', 'Número de cuenta')}}
            {{Form::text('accountNumber', old('accountNumber', $payment->accountNumber), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Número de cuenta'))}}
            <span class="text-red">{{$errors->first('accountNumber')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('subAccount', 'Sub-cuenta')}}
            {{Form::text('subAccount', old('subAccount', $payment->subAccount), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Sub-cuenta'))}}
            <span class="text-red">{{$errors->first('subAccount')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('formName', 'Nombre del formulario')}}
            {{Form::text('formName', old('formName', $payment->formName), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Nombre del formulario'))}}
            <span class="text-red">{{$errors->first('formName')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('currencyCode', 'Código de moneda')}}
            {{Form::text('currencyCode', old('currencyCode', $payment->currencyCode), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Código de moneda'))}}
            <span class="text-red">{{$errors->first('currencyCode')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('saltKey', 'Salt key (Póngase en contacto con CCBill Support para obtenerlo.)')}}
            {{Form::text('saltKey', old('saltKey', $payment->saltKey), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Salt key'))}}
            <span class="text-red">{{$errors->first('saltKey')}}</span>
          </div> -->
        <p> <a href="https://paylands.docs.apiary.io/" rel="nofollow" target="_blank">Ver documentación de Paylands</a> </p>
        <p> <a href="https://backend.paylands.com/login" rel="nofollow" target="_blank">Backend de Paylands</a> </p>
         
        </div>
        <div class="box-footer text-left">
          <input type="hidden" name="id" value="{{$payment->id}}">
          <button type="submit" class="btn btn-info btn-lg">Guardar cambios</button>
          <a href="{{URL('admin/manager/paymentpackages')}}" class="btn btn-success btn-lg">Gestión de paquetes</a>
        </div>
      {!!Form::close()!!}
    </div>
  </div>
</div>
@endsection