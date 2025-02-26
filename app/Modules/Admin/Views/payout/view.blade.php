<?php

use App\Helpers\Helper as AppHelper;
use App\Modules\Model\Models\PerformerPayoutRequest;
use App\Modules\Api\Models\UserModel;
?>
@extends('admin-back-end')
@section('title', 'Pago solicitado')
@section('breadcrumb', '<li><a href="/admin/request-payout/listing"><i class="fa fa-dashboard"></i> Pago solicitado</a></li><li class="active">Listing</li>')
@section('content')
<div ng-controller="ModelRequestPayoutViewCrl" ng-init="init({{json_encode($item)}})">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4>Detalles del pago solicitado</h4>
    </div>
    <div class="right_cont panel-body">
      <div class="row">
        <div class="col-md-6">
          <h4>Información requerida</h4>

          <p>
            <strong>A partir de la fecha: </strong> {{$item->dateFrom}}
          </p>
          <p>
            <strong>Hasta la fecha: </strong> {{$item->dateTo}}
          </p>
          <p>
            <strong>A la información de la cuenta: </strong> 
            <?php 
            $paymentMethod = '';
            if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYPAL){
              $paymentMethod = trans('messages.paypal');
            }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_ISSUE_CHECK_US){
              $paymentMethod = trans('messages.checkTransfer');
            }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_WIRE){
              $paymentMethod = trans('messages.bankTransfer');
            }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_DEPOSIT){
              $paymentMethod = trans('messages.directDeposit');
            }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYONEER){
              $paymentMethod = trans('messages.paxum');
            }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_BITPAY){
              $paymentMethod = trans('messages.bitpay');
            }             
            echo $paymentMethod;
            ?>
            <br>
            <?php echo UserModel::getPaymentInfo($userModel->id, $item->paymentAccount)?>
          </p>
          <?php 
          if(count($performers)){
            ?>
          <p>
            <strong>Modelos: </strong>

            @foreach ($performers as $performer)
            <a>{{$performer->username}}</a>
            @endforeach
          </p>
          <?php 
          }
          ?>
          <div>
            <strong>Comentario: </strong> {!! $item->comment !!}
          </div>
          <div class="clearfix"></div>
          <p>
            <strong>Solicitado el: </strong> {{$item->createdAt}}
          </p>
          <p>
            <strong>Ganancias para la fecha seleccionada: </strong>  €{{$item->payout}}
          </p>
          <p>
            <strong>Pago anterior: </strong>  €{{$item->previousPayout}}
          </p>
          <p>
            <strong>Ganancias pendientes en la cuenta: </strong> ${{$item->pendingBalance}} (estos serán los ingresos después de la fecha de solicitud  {{$item->dateTo}})
          </p>
        </div>
        <div class="col-md-6">
          <h4>Confirmar información</h4>

          <div class="form-group">
            <label>Status</label>
            <select ng-model="status" class="form-control">
              <option value="pending">Pendiente</option>
              <option value="approved">Aprobar</option>
              <option value="cancelled">Cancelar</option>
            </select>
          </div>
          <div class="form-group">
            <label>Nota</label>
            <textarea class="form-control" ng-model="note"></textarea>
          </div>
          <div class="form-group">
            <label>&nbsp;</label>
            <button class="btn btn-primary" type="button" ng-click="updateStatus()">Actualizar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4>Comentarios</h4>
    </div>
    <div class="right_cont panel-body">
      <ul class="comment-list">
        <li ng-repeat="comment in comments track by $index">
          <div>
            <p><strong><% comment.sender.username %>: </strong> <small><% comment.createdAt|date:'short' %></small></p>
            <p><% comment.text %></p>
          </div>
        </li>
      </ul>
      <hr/>
      <form ng-submit="comment()">
        <div class="form-group">
          <label>Nuevo comentario</label>
          <textarea class="form-control" ng-model="newComment" required></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
