@extends('admin-back-end')
@section('title', 'Agregar paquete')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li><a href="/admin/manager/paymentsystems"> Configuración de pago</a></li><li><a href="/admin/manager/paymentpackages">Paquetes de pago</a></li><li><a>Agregar paquete</a></li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Agregar nuevo paquete</h3>
      </div><!-- /.box-header -->
      <!-- form start -->

      <form method="post" action="" role="form">
        <div class="box-body">
          
          <div class="form-group required">
              <label for="price" class="control-label">Precio</label>
            <input class="form-control" id="price" value="{{old('price')}}" autocomplete="off" name="price" placeholder="" type="text">
            <span class="text-red">{{$errors->first('price')}}</span>
          </div>
          <div class="form-group">
            <label for="description">Descripción</label>
            <input class="form-control" id="description" autocomplete="off" value="{{old('description')}}" name="description" placeholder="" type="text">
          </div>
          <div class="form-group required">
              <label for="tokens" class="control-label">Tokens </label>
            <input class="form-control" id="tokens" autocomplete="off" value="{{old('tokens')}}" name="tokens" type="number" placeholder="">
            <span class="text-red">{{$errors->first('tokens')}}</span>
          </div>
        

        </div>
        <div class="box-footer text-center">

          <button type="submit" class="btn btn-danger btn-lg">Agregar paquete</button>
        </div>
      </form>
    </div>
  </div><!-- /.box -->
</div>
@endsection