@extends('admin-back-end')
@section('title', 'Estudio')
@section('breadcrumb', '<li><a href="/admin/manager/performerstudios"><i class="fa fa-dashboard"></i> Studios</a></li><li class="active">Estudio de edición</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Editar Estudio</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <form role="form" method="post" action="" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6">
            <div class="box-body">
          <div class="form-group hidden">
            <label for="gender">Género</label>
            <div class="input-group" id="gender-group">
              @include('render_gender_block', array('default' => old('gender', $user->gender)))
            </div>
            <label class="label label-danger">{{$errors->first('gender')}}</label>
          </div>

          <div class="form-group required">
              <label for="studioname" class="control-label">Nombre del estudio</label>
            <input type="text" class="form-control" name="studioName" id="studioname" placeholder="" maxlength="32" value="{{Request::old('studioName', $user->studioName)}}">
            <label class="label label-danger">{{$errors->first('studioName')}}</label>
          </div>
          <div class="form-group required">
              <label for="username" class="control-label">Nombre de usuario </label>
            <input type="text" class="form-control" id="username" placeholder="Ingrese Nombre de usuario" name="username" value="{{old('username', $user->username)}}">
            <label class="label label-danger">{{$errors->first('username')}}</label>
          </div>
          <div class="form-group required">
              <label for="email" class="control-label">Email </label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese email" value="{{$user->email}}" disabled="disabled">
            <label class="label label-danger">{{$errors->first('email')}}</label>
          </div>
          
          <div class="form-group" >
              <label for="passwordHash">Nueva contraseña </label>
            <span class="help-block">(cambio de contraseña: ingrese NUEVA contraseña)</span>
            <input type="password" class="form-control" id="passwordHash" name="passwordHash" placeholder="Password" value="{{old('passwordHash')}}">
            <label class="label label-danger">{{$errors->first('passwordHash')}}</label>
            
          </div>
          <div class="form-group" >
              <label for="tokens">Tokens </label>
              <input type="number" class="form-control" id="tokens" name="tokens" placeholder="Tokens" value="{{old('tokens', $user->tokens)}}">
            <label class="label label-danger">{{$errors->first('tokens')}}</label>
            
          </div>
          <div class="form-group">
            <label for="studioProff" class="control-label">Envíe el certificado de registro de su empresa</label>
            <input name="studioProff" id="studioProff" type="file" accept=".doc,.docx,.pdf"/>
            <label class="text-red">{{$errors->first('studioProff')}}</label>
            @if($document && $document->studioProff)
              <a class="btn btn-link" href="{{URL($document->studioProff)}}" target="_blank">Ver</a>
            @endif
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
          <button type="submit" class="btn btn-primary">Guardar cambios</button>&nbsp;&nbsp;
          <a class="btn btn-danger"  href="javascript:confirmDelete('¿Estás seguro de que quieres deshabilitar esta cuenta?', {{$user->id}})">inhabilitar</a>
        </div>
      </form>
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
