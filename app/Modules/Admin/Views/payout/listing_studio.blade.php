@extends('admin-back-end')
@section('title', 'Solicitud de Pago')
@section('breadcrumb', '<li><a href="/admin/request-payout/listing"><i class="fa fa-dashboard"></i> Request payout</a></li><li class="active">Listado</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Lista de todas las solicitudes</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        {!! $grid !!}
      </div>
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
