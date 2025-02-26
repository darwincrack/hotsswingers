@extends('admin-back-end')
@section('title', '5 post con Imagenes que contiene la mayor cantidad de likes')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Asignar premios por cantidad de likes obtenidos</li>')
@section('content')
<div class="row">
  <div class="col-sm-12">


<style>
	
.bootstrap-datetimepicker-widget.dropdown-menu {
  background-color: #30363b;
  border-color: #2b3135;
  width: 100%;
}
.bootstrap-datetimepicker-widget.dropdown-menu:after,
.bootstrap-datetimepicker-widget.dropdown-menu:before {
  display: none !important;
}
.bootstrap-datetimepicker-widget.dropdown-menu .arrow {
  display: none !important;
}
.bootstrap-datetimepicker-widget.dropdown-menu .arrow:after,
.bootstrap-datetimepicker-widget.dropdown-menu .arrow:before {
  display: none !important;
}
.bootstrap-datetimepicker-widget.dropdown-menu a span:hover,
.bootstrap-datetimepicker-widget.dropdown-menu a span:focus {
  background-color: #32aa62 !important;
  color: #fff !important;
}

.bootstrap-datetimepicker-widget .timepicker-minute, .bootstrap-datetimepicker-widget .timepicker-hour {
 
    color: white;
}

</style>

    <div class="box">
      <div class="box-body">

<form class="form-inline" action="" name="frmFilterPeriod" novalidate autocomplete="off">


      	<div class="col-sm-4" id="datepicker-12">
                  <div class="input-daterange input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" class="input-lg form-control" name="timePeriodStart" id="timePeriodStart" placeholder="@lang('messages.startDate')" value="{{Request::has('timePeriodStart') ? Request::get('timePeriodStart') : ''}}"/>
                  </div>
                </div>


        <div class="col-sm-4" id="datepicker-13">
                  <div class="input-daterange input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" class="input-lg form-control" name="timePeriodEnd" id="timePeriodEnd" placeholder="Fecha final" value="{{Request::has('timePeriodEnd') ? Request::get('timePeriodEnd') : ''}}"/>
                  </div>
                </div>

                <div class="col-sm-4">
                  <button class="btn btn-info btn-lg"><i class="fa fa-filter"></i>@lang('messages.filter')</button>
                </div>

            </form>
                <div style="clear: both;"></div>
      	<hr>
        <div class="table-responsive">
            <ng-form-submit>{!! $grid !!}</ng-form-submit>
        </div>
        
      </div>
    </div>
  </div>
</div>



<!-- Commission General model-->
<div class="modal fade" id="PremiosModal" tabindex="-1" role="dialog" aria-labelledby="PremiosModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="PremiosModal">Enviar Premio a <span id="premioUsernameTxt"></span></h4>
      </div>
      <div class="modal-body">









  <strong id="premiostokens-error"></strong>
<form action="{{ url('/post')}}" method="POST" id="formTokensPremios">
  {{ csrf_field() }}
  <div class="form-group">
    <label for="tokensPremios">Tokens</label>
    <input type="number" class="form-control" id="tokensPremios" placeholder="Tokens a enviar" name="tokensPremios"  min="1">


    <input type="hidden" name="userPremiosTokens" id="userPremiosTokens">
    <input type="hidden" name="userPremiosFechaInicio" id="userPremiosFechaInicio">
    <input type="hidden" name="userPremiosFechaFinal" id="userPremiosFechaFinal">
	<input type="hidden" name="tokensGanados" id="tokensGanados">


  </div>

 <div class="form-group">
 	<label for="txtPremiosTokens">Mensaje (mensaje que se enviara en el correo que le llega al usuario)</label>
 	<textarea class="form-control" name="txtPremiosTokens" id="txtPremiosTokens" rows="4" cols="50"> Felicitaciones te has ganado 1000 tokens!</textarea>
 </div>



</form>

<a href="{{ url('/admin/manager/premios/ganadorestokens')}}" target="_blank">Ir al listado de ganadores por tokens</a>

      </div>



      <div class="modal-footer">
      	<button type="button" onclick="formTokensPremiosSubmit()" class="btn btn-primary">Enviar Premio</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



@stop