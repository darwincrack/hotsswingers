@extends('admin-back-end')
@section('title', 'Paquetes de pago')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li><a href="/admin/manager/paymentsystems"> Configuración de pago</a></li><li class="active">Paquetes de pago</li>')
@section('content')
<?php 
use App\Helpers\Session as AppSession;
$adminData = AppSession::getLoginData();
?>
<div class="row">
  <div class="col-sm-12">
    <div class="box">


      <div class="box-body">
        <div class="box-header"> 
          <h3 class="box-title">
            <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
              <a href="{{URL('admin/manager/paymentpackage/add')}}" class="btn btn-success">Agregar paquete</a>
            <?php } ?>
          </h3>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>Id</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Tokens</th>
                <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
                <th>Acciónes</th>
                <?php } ?>
              </tr>
              @foreach($listPackages as $package)
              <tr>
                <td>{{$package->id}}</td>
                <td>{{$package->price}}</td>
                <td>{{$package->description}}</td>
                <td>{{$package->tokens}}</td>
                <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
                <td><a class="btn btn-warning btn-sm" href="{{URL('admin/manager/paymentpackage/edit/'.$package->id)}}">Editar</a>&nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="javascript:deletePackage({{$package->id}})">Borrar</a></td>
                <?php } ?>
              </tr>
              @endforeach

            </tbody>
          </table>
          
          <nav class="text-center">
            <ul class="pagination"> {{ $listPackages->links() }} </ul>
          </nav>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection