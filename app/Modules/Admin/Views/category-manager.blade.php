@extends('admin-back-end')
@section('title', 'Categorías')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Categorías</li>')
@section('content')
<?php 
use App\Helpers\Session as AppSession;
$adminData = AppSession::getLoginData();
?>
<div class="row" ng-controller="categoryManagerCtrl" ng-cloak>
  <div class="col-sm-12">
    <div class="box">
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody><tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Nombre Ingles</th>
                <th>Nombre Frances</th>
                <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
                <th>Acción</th>
                <?php } ?>
              </tr>
              <tr ng-repeat="(key, category) in categories">
                <td><% category . id %></td>
                <td><input ng-model="category.name" class="form-control" ng-required="true"></td>
                <td><input ng-model="category.name_en" class="form-control" ng-required="true"></td>
                 <td><input ng-model="category.name_fr" class="form-control" ng-required="true"></td>
  
                <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
                <td><a class="btn btn-success" ng-click="updateCategory(key, category)">Actualizar</a>&nbsp;|&nbsp;<button class="btn btn-danger" ng-click="deleteCategory(key, category)">Eliminar</button></td>
                <?php }?>
              </tr>
              <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
              <tr>
                <td></td>
                <td><input ng-model="category.name" class="form-control" ng-required='true'></td>
                <td><input ng-model="category.name_en" class="form-control" ng-required='true'></td>
                <td><input ng-model="category.name_fr" class="form-control" ng-required='true'></td>

                <td><a class="btn btn-success" ng-click="addCategory(category.name,category.name_en,category.name_fr)">Agregar</a></td>
              </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>

    </div>

  </div>

</div>
@endsection
