<?php 

use App\Helpers\Helper as AppHelper;
?>
@extends('Model::model_dashboard')
@section('content_sub_model')


<style>
  

</style>

<div class="panel panel-default"> <!--all left-->
  <div class="panel-heading"><h4>@lang('messages.GEOBlocking')</h4></div>
  <div class="mod_wall_cont">
    <div class="mod_chat_settings_cont">
      <div class="bg tablescroll" style="padding: 10px;">


<form action="{{ url('/models/dashboard/geo-blocking/store/')}}" method="POST" id="formGeoBlocking">
  {{ csrf_field() }}

  <div class="form-group">
              <label for="category" class="control-label">Paises </label>
                <select  name="pais" class="form-control input-md js-example-basic-multiple" style="width: 100%">
                  <option value = "0">--Seleccione un páis--</option>
                @foreach($paises as $aKey => $aSport)
                  <option value="{{$aSport->country_code}}" >{{$aSport->country_name}}</option>
                @endforeach
                </select>
              <label class="label label-danger">{{$errors->first('category')}}</label>
            </div>



 <div class="form-group">
              <label for="ciudad" class="control-label">Provincias</label>       
              
                <select name="ciudad" id="ciudad"  class="form-control">
                    <option value="0">-- Seleccione provincia (Opcional)--</option>
                </select>
              
            </div> 


</form>
<button id="guardarGeoBlocking" class="btn btn-success btn-lg  m10  guardarGeoBlocking" onclick="guardarGeoBlocking()"> Guardar</button>
<hr>

<h3>Restricciones por IP añadidas:</h3>

<div id="banned_regions_container">
  

    @foreach($geoblockings as $geoblocking)

      <button class="btn tag delete_region_button atv_restricted_region" data-region_id="{{$geoblocking->id}}" title="Eliminar restricción">
        <span class="atv_wholerestriction tag-text">
                        <span class="atv_countryname">{{$geoblocking->country_name}}</span> - <span class="atv_regionname">

                          @if($geoblocking->city_name == null)

                              Todo el país
                          @else
                              {{$geoblocking->city_name}}

                          @endif

                        </span>
                </span>
        <i class="fa fa-trash "></i>
    </button>


    @endforeach


</div>

      </div>
    </div>


  </div>
</div>
<div class="clearfix"></div>


<script>
  
jQuery(document).ready(function($) {


    $('.js-example-basic-multiple').select2({
        placeholder: 'Por favor seleccione',
        width: 'resolve'
    });


    var $eventLog = $(".js-event-log");
    var $eventSelect = $(".js-example-basic-multiple");

    $eventSelect.select2();
    $eventSelect.on("change", function(e) {




        $('.js-example-basic-multiple').on("select2:select", function(event) {

            $.ajax({
                url: appSettings.BASE_URL + 'models/dashboard/geo-blocking/code/' + $('.js-example-basic-multiple').val(),

                type: 'GET',
                cache: false,
                contentType: 'application/json; charset=utf-8',
                dataType: "json",
                success: function(result) {
                    var markup;
                    var dbSelect = $('#ciudad');
                    dbSelect.empty();
                    dbSelect.append($('<option/>', {
                        value: "0",
                        text: "-- Seleccione provincia (Opcional)--"
                    }));
                    for (var i = 0; i < result.length; i++) {
                        dbSelect.append($('<option/>', {
                            value: result[i].city_name,
                            text: result[i].city_name
                        }));
                    }
                    $('#ciudad').select2();

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });



    });



    $(document).on("click", 'button.btn.tag.delete_region_button.atv_restricted_region', function(event) {




        var element = $(this);




        $.ajax({
            url: appSettings.BASE_URL + 'models/dashboard/geo-blocking/code/remove/' + $(this).data("region_id"),

            type: 'GET',
            cache: false,
            contentType: 'application/json; charset=utf-8',
            dataType: "json",
            success: function(data) {

                if (data.success) {
                    alertify.success(data.message);
                    element.remove();
                } else {
                    alertify.warning(data.message);

                }


            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });




    });




});




function guardarGeoBlocking() {


    if ($(".js-example-basic-multiple").val() == 0) {
        alertify.error("Debe escribir un país");
        return;

    }

    var registerForm = $("#formGeoBlocking");
    var formData = registerForm.serialize();
    var datos = "";

    $("#banned_regions_container").append("por favor espere...");




    $.ajax({
        url: appSettings.BASE_URL + 'models/dashboard/geo-blocking/store',
        type: 'POST',
        data: formData,
        success: function(data) {

            if (data.errors) {
                if (data.errors) {
                    alertify.error(data.errors.pais[0]);
                }

            }
            if (data.success) {

                $("#banned_regions_container").empty();
                alertify.success(data.message);

                data.data.forEach(function(datos, index) {
                    if (datos.city_name == null) {

                        txt_ciudad = "Todo el país ";
                    } else {
                        txt_ciudad = datos.city_name;
                    }
                    datos = "<button class='btn tag delete_region_button atv_restricted_region' data-region_id='" + datos.id + "' title='Eliminar restricción'><span class='atv_wholerestriction tag-text'><span class='atv_countryname'>" + datos.country_name + "</span> - <span class='atv_regionname'>" + txt_ciudad + "</span></span><i class='fa fa-trash'></i></button>";

                    $("#banned_regions_container").append(datos);
                });


            } else {
                alertify.warning(data.message);

            }


        }

    });

}

</script>


@endsection