@extends('admin-back-end')
@section('title', 'Conversaciones')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Comisión</li>')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box">
      <div class="box-body">
        <div class="table-responsive">
            <ng-form-submit>{!! $grid !!}</ng-form-submit>
        </div>
        
      </div>
    </div>
  </div>
</div>

@stop