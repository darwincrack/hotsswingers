@extends('admin-back-end')
@section('title', 'Estudio')
@section('breadcrumb', '<li><a href="/admin/manager/performerstudios"><i class="fa fa-dashboard"></i> Studios</a></li><li class="active">Agregar nuevo estudio</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Agregar nuevo estudio</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      {!! Form::open(array('method'=>'post', 'role'=>'form','enctype' => 'multipart/form-data')) !!}
      <div class="row">
         <div class="col-md-6">
          <div class="box-body">
          <div class="form-group hidden">
            <label for="gender">Género</label>
            <div class="input-group" id="gender-group">
                @include('render_gender_block')
            </div>
            <label class="text-red">{{$errors->first('gender')}}</label>
          </div>

          <div class="form-group required">
              <label for="studioname" class="control-label">Nombre del estudio </label>
              <input type="text" class="form-control" name="studioName" id="studioname" placeholder="Enter studioname" maxlength="32" value="{{Request::old('studioName')}}">
              <label class="text-red">{{$errors->first('studioName')}}</label>
          </div>
          <div class="form-group required">
              <label for="username" class="control-label">Nombre de usuario </label>
            <input type="text" class="form-control" id="username" placeholder="Ingrese Nombre de usuario" name="username" value="{{Request::old('username')}}">
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
            <input type="password" class="form-control" id="confirmed" name="passwordHash_confirmation" placeholder="Confirmar Contraseña" value="{{old('passwordHash_confirmation')}}">
            <label class="text-red">{{$errors->first('passwordHash_confirmation')}}</label>
          </div>
          <div class="form-group">
              <label for="studioProff">Envíe el certificado de registro de su empresa</label>
              <input type="file" name="studioProff" id="studioProff" value="{{old('studioProff')}}" accept=".doc,.docx,.pdf">
              <p class="help-block">Extensiones permitidas: doc, docx, pdf</p>
              <label class="text-red">{{$errors->first('studioProff')}}</label>

          </div>
        </div><!-- /.box-body --> 
         </div>
         <div class="col-md-6">
           <div class="box-body">
             <div class="form-group">
                <label for="gender" class="control-label">Opciones de pago</label>
              </div>
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#paymentinfo" data-toggle="tab" aria-expanded="true">Información de pago</a></li>
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
           </div>
         </div>
      </div>
        

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
      {!!Form::close()!!}
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
