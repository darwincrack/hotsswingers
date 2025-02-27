<?php 

use App\Helpers\Helper as AppHelper
?>
@extends('admin-back-end')
@section('title', 'Pago de videos')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Videos</li>')
@section('content')
<script type="text/javascript" src="{{PATH_LIB}}/jquery/src/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key = "6rm7LKq8lGG9cLQNtZGQgXG29NtTNwSPgusQMA==";</script>
<div class="row">
  <div class="col-sm-12">
    <div class="box">
      <div class="box-body">
        <div class="table-responsive">
            <style>
                #videos_item td {
                    white-space: nowrap;
                }
            </style>
            {!! $grid !!}
            <div class="col-sm-12">
                {{Form::hidden('action', URL('admin/manager/payments/others'))}}
            <button class="btn btn-success btn-sm" onclick="approveOrRejectPayment('approve')">Aprobar todo</button>&nbsp;&nbsp;<button class="btn btn-danger btn-sm" onclick="approveOrRejectPayment('reject')">Rechazar todo</button>&nbsp;&nbsp;<span class="processing-event"></span>
          </div>
        </div>
      </div>
    </div><!-- /.box -->
  </div>
</div>

<div class="modal fade" id="commissionModal" tabindex="-1" role="dialog" aria-labelledby="voteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="panel-title" id="voteLabel"><span class="glyphicon glyphicon-arrow-right"></span> Detalle de la comisión</h4>
      </div>
      <div class="modal-body">
        <table class='table'>
          <thead>
            <tr>
              <th>Username</th>
              <th>Item</th>
              <th>Tokens</th>
              <th>Porcentaje</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="voteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div id="video-player-popup"></div>
    </div>
</div>
@endsection