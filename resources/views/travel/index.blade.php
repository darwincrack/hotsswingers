@extends('frontend')
@section('title', \Lang::get('messages.quienestadonde') )
@section('content')
<div class="content">




  <div class="full-container" ng-controller="modelOnlineCtrl" ng-cloak ng-init="travel()" ng-cloak>
    <div class="banner m20">
            <div class="row">
        <div class="col-md-6 col-xs-12">
            @if(app('settings') && app('settings')->banner != '')
                <a href="{{app('settings')->bannerLink}}"><img src="{{URL(app('settings')->banner)}}?time={{time()}}" width="100%"></a>
            @endif
        </div>

        <div class="col-md-6 col-xs-12">
            @if(app('settings') && app('settings')->bannerdos != '')
                <a href="{{app('settings')->bannerLinkDos}}"><img src="{{URL(app('settings')->bannerdos)}}?time={{time()}}" width="100%"></a>
          @endif
        </div>
      </div>
    </div>     



<div class="row">
  <div class="col-sm-4 col-md-4 ">

    <div class="form-group">
        <label>@lang('messages.location'):</label>
        <input type="text" class="form-control" ng-model="textPlace" googleplace placeholder="@lang('messages.Ingresaunaciudad')..." ng-blur="clear()"/>
    </div>
  </div>




  <div class="col-sm-4 col-md-4 ">
                <div class="form-group">
                    <label for="@lang('messages.Desde')" class="control-label">@lang('messages.Desde') </label>
                    <div class="btn-group  btn-group-justified">
                      <input type="text" jqdatepicker  ng-model="Desde" required readonly />
                      <br/>
                    </div>
                </div>
  </div>



  <div class="col-sm-4 col-md-4">
    <br> 
    <p style="cursor: pointer; color: blue;" data-toggle="modal" data-target="#myModal" id="abrirmodal">
      <span><i class="fa fa-edit"></i></span>
      <span>@lang('messages.anadirunviaje')</span>
    </p>





  </div>



</div>
    <!-- Nav tabs -->
 
 
    <ul class="nav nav-tabs tabs-home" role="tablist">

      <li role="presentation" class="active"><a aria-controls="Everybody" role="tab" data-toggle="tab" ng-click="travel('todos')">@lang('messages.Everybody')</a></li>      <li role="presentation"><a aria-controls="females" role="tab" data-toggle="tab" ng-click="travel('female')">@lang('messages.females')</a></li>
      <li role="presentation"><a aria-controls="males" role="tab" data-toggle="tab" ng-click="travel('male')">@lang('messages.males')</a></li>
      <li role="presentation"><a aria-controls="couples" role="tab" data-toggle="tab" ng-click="travel('couple')">@lang('messages.couples')</a></li>
      <li role="presentation"><a aria-controls="transsexuals" role="tab" data-toggle="tab" ng-click="travel('transsexual')">@lang('messages.Transsexuals')</a></li>
      <li role="presentation"><a aria-controls="misviajes" role="tab" data-toggle="tab" ng-click="travel('misviajes')">@lang('messages.misviajes') ({{$countmisviajes}})</a></li>
    </ul>
  

     
    <!-- Tab panes --> 
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active">
        <ul class="list-model flex-container wrap" style="padding-top: 10px;">
          <li ng-style="styleModelItem" class="col-sm-4 col-md-1-8 flex-item" ng-repeat="(key, item) in users" >

 <a href="{{URL('dashboard/u')}}/<% item.username %>">
<div class="overlay">
    <p class="text"> <% item.descripcion %> </p>
    <p class="editar" id="editar" data-travelid= "<% item.travelid %>" data-lugar= "<% item.lugar %>" data-salida= "<% item.salida %>" data-llegada= "<% item.llegada %>"  data-descripcion= "<% item.descripcion %>" ng-show="item.userid=='{{  $userid }}'" title="@lang('messages.edit')"><i class="fa fa-edit"></i></p>


    <p class="delete" id="delete" data-traveldelete= "<% item.travelid %>" ng-show="item.userid=='{{  $userid }}'" title="@lang('messages.delete')"><i class="fa fa-times"></i></p>
  </div>

            <div class="box-model">
              <div class="img-model">

               
                  <img ng-src="<% item.avatar | avatar %>" alt="poster" ng-hide="item.lastCaptureImage" class="img-responsive" height="130px" fallback-src="{{URL('images/64x64.png')}}" />
                


              

              </div>
              <div class="text-box-model">

               <label class="ciudad text-viajes"> <% item.lugar | elipsis: 12 %> </label>
                  
                   <p class="text-viajes"> <% item.username | elipsis: 12 %> </p>
                   
                     <p class="text-viajes"> <% item.gender | elipsis: 12 %> </p>
                    <?php /*
                <div ng-show="item.isStreaming == 1">
                  <span><i class="fa fa-eye"></i> <% item.totalViewer %></span>
                </div>
                */ ?>
                <p class="text-viajes" >del <% item.salida %> </p>

                <p class="text-viajes" >al <% item.llegada %> </p>

              </div>
            </div>
            </a>
          </li>
        </ul>
        <p ng-show="users.length == 0">@lang('messages.textviajeprogramado')!</p>
        <nav class="text-center">
          <ul class="pagination">  </ul>
        </nav>
      </div>



    </div>

  </div>










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

#editar {
    margin: 0;
    position: absolute;
    bottom: 0;
    width: 50%;
    color: #d6d629;
    background: #2d2c2c;
    padding: 4px;
    padding-left: 8px;
}


#delete {
    margin: 0;
    position: absolute;
    bottom: 0;
    width: 55%;
    color: #d6d629;
    background: #2d2c2c;
    padding: 4px;
    right: 0;
    text-align: right;
}

@media (min-width: 768px){
  .modal-dialog {
    width: 450px;
}
}

p.text-viajes {
    line-height: 8px;
}
  .flex-item {
  position: relative;

}

.image {
  display: block;
  width: 100%;
  height: auto;
}

.overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
 
  background-color: #008CBA;
      z-index: 99;
      background: rgba(0,0,0,.7);
    transition: bottom .3s;
}

.flex-item:hover .overlay {
  opacity: 1;
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
   /* var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
        types: ['geocode'],
    });
        
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
        document.getElementById('loc_lat').value = near_place.geometry.location.lat();
        document.getElementById('loc_long').value = near_place.geometry.location.lng();
                
        document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
        document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
    });
*/






  $(document).on('submit','#ModalSubmit',function(e){
    e.preventDefault(); 
    // AJAX request 
    console.log($(this).serialize())
    $.ajax({
        method: 'post',
        url: "api/v1/traveladd",
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
        url: "api/v1/traveladd",
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
                    url: "api/v1/traveldelete",
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


/*$("#saveModal").on("click", function(){
  alert("The paragraph was clicked.");



$.ajax({
    method: 'post',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "route name or url",
    data: $(this).serialize(),
    success: function(msg) {
        console.log(msg);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log("some error");
    }
});


});*/


});


</script>


@endsection
