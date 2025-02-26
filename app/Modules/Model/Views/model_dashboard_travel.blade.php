@extends('Model::model_dashboard')
@section('content_sub_model')
<?php use App\Helpers\Helper as AppHelper;?>
<div class="right_cont"> <!--all left-->


  <div class="mod_shedule"> <!--user's info-->
    <!--Jan/26/2016 00:42-->
  <table class="table table-hover">
    <thead>
      <tr>
        <th>@lang('messages.lugar')</th>
        <th>@lang('messages.salida')</th>
        <th>@lang('messages.vuelta')</th>
        <th>@lang('messages.description')</th>
        <th>@lang('messages.action')</th>
      </tr>
    </thead>
    <tbody>

<?php foreach ($travel as $travel) {?>

      <tr>
        <td><?php echo $travel["lugar"] ?></td>
        <td><?php echo $travel["salida"] ?></td>
        <td><?php echo $travel["llegada"] ?></td>
        <td><?php echo $travel["descripcion"] ?></td>
        <td>
          <label class="editar" id="editar" data-travelid= "<?php echo $travel["travelid"] ?>" data-lugar= "<?php echo $travel["lugar"] ?>" data-salida= "<?php echo $travel["salida"] ?>" data-llegada= "<?php echo $travel["llegada"] ?>"  data-descripcion= "<?php echo $travel["descripcion"] ?>"  title="@lang('messages.edit')" style="cursor: pointer;"><i class="fa fa-edit"></i></label>&nbsp;&nbsp;

           <label class="delete" id="delete" data-traveldelete= "<?php echo $travel["travelid"] ?>" title="@lang('messages.delete')" style="cursor: pointer;"><i class="fa fa-times"></i></label>


        </td>
      </tr>
<?php } ?>

    </tbody>
  </table>
   
  </div> <!--user's info end-->
</div>




<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

<form id="ModalSubmit">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> @lang('messages.anadirunviaje')</h4>
      </div>
      <div class="modal-body">
            <div class="form-group">
        <label>@lang('messages.lugar'):</label>
        <input type="text" class="form-control" name="lugar" ng-model="textLugar" googleplacetext placeholder="@lang('messages.Ingresaunaciudad')..."/>
    </div>

<p style="font-weight: bold;">@lang('messages.date')</p>
 <div class="form-group col-md-6" style="padding:0;">
                    <label for="@lang('messages.Desde')" class="control-label" style="font-weight: normal;">@lang('messages.del') </label>
                    <div class="btn-group  btn-group-justified">
                      <input type="text" jqdatepickersimple  name="salida" ng-model="textDesde" required readonly />
                      <br/>
                    </div>
                </div>


 <div class="form-group col-md-6" style="padding:0;">
                    <label for="@lang('messages.Hasta')" class="control-label"  style="font-weight: normal;">@lang('messages.al') </label>
                    <div class="btn-group  btn-group-justified">
                      <input type="text" jqdatepickersimple  name="llegada" ng-model="textHasta" required readonly />
                      <br/>
                    </div>
                </div>


 <div class="form-group">
    <label for="@lang('messages.description')">@lang('messages.description')</label>
    <textarea class="form-control" name="descripcion" id="descripcion" rows="3" ng-model="textDescription"></textarea>
  </div>

{{ csrf_field() }}


<input type="hidden" name="t" value="">

<input type="hidden" name="estado" value="">

      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
        <button type="submit" class="btn btn-primary"  id="saveModal">@lang('messages.crear')</button>
      </div>
    </div>

  </form>

  </div>
</div>

<style>






@media (min-width: 768px){
  .modal-dialog {
    width: 450px;
}
}

p.text-viajes {
    line-height: 8px;
}



.text {
  color: white;
  font-size: 14px;
  position: absolute;
  padding: 10px;
}

.ciudad{
  font-size: 18px;
}


.modal{
  z-index: 1000;
}

#ui-datepicker-div {
    z-index: 1000 !important;
}
</style>

 

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyC6vegb9nTCzs25eUR48c4smfm2MPoXemc"></script>



<link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet"/>




<script>
  var searchInput = 'search_input';

$(document).ready(function () {

  $(document).on('submit','#ModalSubmit',function(e){
    e.preventDefault(); 
    // AJAX request 
    console.log($(this).serialize())
    $.ajax({
        method: 'post',
        url: "../../api/v1/traveladd",
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $(this).serialize(),





         success: function (data) {
            if (data.success == true) {
              
              alertify.success(data.message, '15');
              setTimeout(function(){
                location = ''
              },2000);


            }
            if (data.success == false) {
              alertify.error("Error!. " + data.message, '15');
              setTimeout(function(){
                location = ''
              },2000)
            }
          },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("some error");
        }
    });
  });




  $(document).on('click','#editar',function(e){

       e.preventDefault(); 

      

    $('input[name ="estado"]').val("edit");
    $('input[name ="t"]').val($(this).data("travelid"));
    $('input[name ="lugar"]').val($(this).data("lugar"));
    $('input[name ="salida"]').val($(this).data("salida"));
    $('input[name ="llegada"]').val($(this).data("llegada"));
    $('#descripcion').html($(this).data("descripcion"));

    $('#saveModal').text(" {!! \Lang::get('messages.update') !!}");

    $('#myModal').modal('show'); 

    // AJAX request 
   // console.log($(this).serialize())
    $.ajax({
        method: 'post',
        url: "../../api/v1/traveladd",
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $(this).serialize(),





         success: function (data) {
            if (data.success == true) {
              
              alertify.success(data.message, '15');
              setTimeout(function(){
                location = ''
              },2000);


            }
            if (data.success == false) {
              alertify.error("Error!. " + data.message, '15');
              setTimeout(function(){
                location = ''
              },2000)
            }
          },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("some error");
        }
    });
  });



  $(document).on('click','#delete',function(e){

       e.preventDefault(); 
      var traveldelete = $(this).data("traveldelete");

      alertify.confirm("{!! \Lang::get('messages.Quieresrealmente') !!}",
              function () {

                $.ajax({
                    method: 'post',
                    url: "../../api/v1/traveldelete",
                     headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { "t": traveldelete},

                     success: function (data) {
                        if (data.success == true) {
                          
                          alertify.success(data.message, '15');
                          setTimeout(function(){
                            location = ''
                          },2000);


                        }
                        if (data.success == false) {
                          alertify.error("Error!. " + data.message, '15');
                          setTimeout(function(){
                            location = ''
                          },2000)
                        }
                      },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("some error");
                    }
                });





              }).set('title', '{!! \Lang::get("messages.confirm") !!}');


  });



  $(document).on('click','#abrirmodal',function(e){
    $('input[name ="estado"]').val("");
    $('input[name ="t"]').val("");
    $('input[name ="lugar"]').val("");
    $('input[name ="salida"]').val("");
    $('input[name ="llegada"]').val("");
    $('#descripcion').html("");
    $('#saveModal').text(" {!! \Lang::get('messages.crear') !!}");

  });




});


</script>



@endsection