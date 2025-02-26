<?php 

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Ajustes del sistema')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li><a>Configuraciones</a></li>')
@section('content')
<?php 
use App\Helpers\Session as AppSession;
$adminData = AppSession::getLoginData();
?>
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">

      <!-- form start -->

        <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>    
          {!! Form::open(array('method'=>'post', 'role'=>'form', 'novalidate', 'files'=>true)) !!}
        <?php } ?>
        <div class="box-body">



      <div class="form-group">
            <label for="referidosTokens">Cantidad de tokens por referido</label>
            <input type="number" class="form-control" name="referidosTokens" id="referidosTokens" placeholder=""  value="{{Request::old('referidosTokens', $settings->referidosTokens)}}">
            <label class="label label-danger">{{$errors->first('referidosTokens')}}</label>
          </div>






          <div class="form-group">
            <label for="modelDefaultReferredPercent">Modelo predeterminado %</label>
            <input type="number" class="form-control" name="modelDefaultReferredPercent" id="modelDefaultReferredPercent" placeholder="" maxlength="2" value="{{Request::old('modelDefaultReferredPercent', $settings->modelDefaultReferredPercent)}}">
            <label class="label label-danger">{{$errors->first('modelDefaultReferredPercent')}}</label>
          </div>
          <div class="form-group hidden">
            <label for="modelDefaultPerformerPercent">Porcentaje de pago predeterminado del miembro ejecutante</label>
            <input type="number" class="form-control" name="modelDefaultPerformerPercent" id="modelDefaultPerformerPercent" placeholder="" maxlength="2" value="{{Request::old('modelDefaultPerformerPercent',$settings->modelDefaultPerformerPercent)}}">
            <label class="label label-danger">{{$errors->first('modelDefaultPerformerPercent')}}</label>
          </div>
          <div class="form-group hidden">
            <label for="modelDefaultOtherPercent">Porcentaje de pago predeterminado para otros miembros</label>
            <input type="number" class="form-control" name="modelDefaultOtherPercent" id="modelDefaultOtherPercent" placeholder="" maxlength="2" value="{{Request::old('modelDefaultOtherPercent', $settings->modelDefaultOtherPercent)}}">
            <label class="label label-danger">{{$errors->first('modelDefaultOtherPercent')}}</label>
          </div>

         <!-- <div class="form-group">
            <label for="studioDefaultReferredPercent">Estudio predeterminado %</label>
            <input type="number" class="form-control" name="studioDefaultReferredPercent" id="studioDefaultReferredPercent" placeholder="" maxlength="2" value="{{Request::old('studioDefaultReferredPercent', $settings->studioDefaultReferredPercent)}}">
            <label class="label label-danger">{{$errors->first('studioDefaultReferredPercent')}}</label>
          </div> -->
          <div class="form-group hidden">
            <label for="studioDefaultPerformerPercent">Porcentaje de pago predeterminado del miembro ejecutante (Default Performer Member Payout Percent)</label>
            <input type="number" class="form-control" name="studioDefaultPerformerPercent" id="studioDefaultPerformerPercent" placeholder="" maxlength="2" value="{{Request::old('studioDefaultPerformerPercent',$settings->studioDefaultPerformerPercent)}}">
            <label class="label label-danger">{{$errors->first('studioDefaultPerformerPercent')}}</label>
          </div>
          <div class="form-group hidden">
            <label for="studioDefaultOtherPercent">Porcentaje de pago predeterminado para otros miembros</label>
            <input type="number" class="form-control" name="studioDefaultOtherPercent" id="studioDefaultOtherPercent" placeholder="" maxlength="2" value="{{Request::old('studioDefaultOtherPercent', $settings->studioDefaultOtherPercent)}}">
            <label class="label label-danger">{{$errors->first('studioDefaultOtherPercent')}}</label>
          </div>

         
          <div class="form-group">
            <label for="memberJoinBonus">Bonificación por unirse a miembros</label>
            <input type="number" class="form-control" id="memberJoinBonus" placeholder="Enter bonus tokens" name="memberJoinBonus" value="{{Request::old('memberJoinBonus', $settings->memberJoinBonus)}}">
            <label class="label label-danger">{{$errors->first('memberJoinBonus')}}</label>
          </div>
          
          <div class="box-header with-border">
            <h3 class="box-title">Configuración de chat</h3>
          </div><!-- /.box-header -->
          <div class="form-group">
            <label for="group_price">Precio de chat grupal predeterminado / minuto</label>
            <input type="number" class="form-control" id="group_price" placeholder="Enter tokens" name="group_price" value="{{Request::old('group_price', $settings->group_price)}}">
            <label class="label label-danger">{{$errors->first('group_price')}}</label>
          </div>
          <div class="form-group">
            <label for="private_price">Precio de chat privado predeterminado / minuto</label>
            <input type="number" class="form-control" id="private_price" placeholder="Enter tokens" name="private_price" value="{{Request::old('private_price', $settings->private_price)}}">
            <label class="label label-danger">{{$errors->first('private_price')}}</label>
          </div>

          <div class="form-group">
            <label for="min_tip_amount">Precio de propina mínimo predeterminado</label>
            <input type="number" class="form-control" id="min_tip_amount" placeholder="Enter tokens" name="min_tip_amount" value="{{Request::old('min_tip_amount', $settings->min_tip_amount)}}">
            <label class="label label-danger">{{$errors->first('min_tip_amount')}}</label>
          </div>
          <div class="form-group">
            <label for="conversionRate">Tasa de conversión</label>
            <div class="help-block">1 tokens = X EUROS</div>
            <input type="text" class="form-control" id="conversionRate" placeholder="" name="conversionRate" value="{{Request::old('conversionRate', $settings->conversionRate)}}" maxlength="10">
            <label class="label label-danger">{{$errors->first('conversionRate')}}</label>
          </div>


   <h3 class="box-title">Premios</h3>


          <div class="form-group">
            <label for="premiosUserConectados">Cantidad de usuario conectados</label>
            <input type="text" class="form-control" id="premiosUserConectados"  name="premiosUserConectados" value="{{Request::old('premiosUserConectados', $settings->premiosUserConectados)}}">
            <label class="label label-danger">{{$errors->first('premiosUserConectados')}}</label>
          </div>

          <div class="form-group">
            <label for="premiosTokens">Cantidad de tokens a entregar</label>
            <input type="text" class="form-control" id="premiosTokens" name="premiosTokens" value="{{Request::old('premiosTokens', $settings->premiosTokens)}}">
            <label class="label label-danger">{{$errors->first('premiosTokens')}}</label>
          </div>


   <h3 class="box-title">Textos Home</h3>

          <div class="form-group">
            <label for="TextEs">Texto español</label>
            <input type="text" class="form-control" id="TextEs"  name="TextEs" value="{{Request::old('TextEs', $settings->TextEs)}}">
            <label class="label label-danger">{{$errors->first('TextEs')}}</label>
          </div>


          <div class="form-group">
            <label for="TextEn">Texto Ingles</label>
            <input type="text" class="form-control" id="TextEn"  name="TextEn" value="{{Request::old('TextEn', $settings->TextEn)}}">
            <label class="label label-danger">{{$errors->first('TextEn')}}</label>
          </div>

          <div class="form-group">
            <label for="TextFr">Texto Frances</label>
            <input type="text" class="form-control" id="TextFr"  name="TextFr" value="{{Request::old('TextFr', $settings->TextFr)}}">
            <label class="label label-danger">{{$errors->first('TextFr')}}</label>
          </div>



             <h3 class="box-title">Banners</h3>
         
          <div class="form-group">
            {{Form::label('banner', 'Banner Izquierda (Ancho recomendado 460px)')}}
            @if($settings->banner)
              <a href="" onclick="deleteImg(this)" type="banner" img_id="settings_banner" style="margin-left: 15px;">Eliminar</a>
            @endif
            {{Form::file('banner', array('class'=>'form-control'))}}
            @if($settings->banner)
            <img src="{{URL($settings->banner)}}?time={{time()}}" class="img-responsive" id ="settings_banner">
            @endif
            <span class="label label-danger">{{$errors->first('banner')}}</span>
          </div> 
          <div class="form-group">
            {{Form::label('bannerLink', 'Enlace de banner izquierda')}}
            {{Form::url('bannerLink', old('bannerLink', $settings->bannerLink), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('bannerLink')}}</span>
          </div>



 <div class="form-group">
            {{Form::label('bannerdos', 'Banner Derecha (Ancho recomendado 460px)')}}
            @if($settings->bannerdos)
              <a href="" onclick="deleteImg(this)" type="banner" img_id="settings_banner" style="margin-left: 15px;">Eliminar</a>
            @endif
            {{Form::file('bannerdos', array('class'=>'form-control'))}}
            @if($settings->bannerdos)
            <img src="{{URL($settings->bannerdos)}}?time={{time()}}" class="img-responsive" id ="settings_bannerdos">
            @endif
            <span class="label label-danger">{{$errors->first('bannerdos')}}</span>
          </div> 
          <div class="form-group">
            {{Form::label('bannerLinkDos', 'Enlace de banner derecha')}}
            {{Form::url('bannerLinkDos', old('bannerLinkDos', $settings->bannerLinkDos), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('bannerLinkDos')}}</span>
          </div>




          
          <div class="form-group">
            {{Form::label('registerImage', 'Banner homepage (Ancho maximo recomendado 528px)')}}
            @if($settings->registerImage)
              <a href="" onclick="deleteImg(this)" type="registerImage" img_id="settings_registerImage" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('registerImage', array('class'=>'form-control'))}}
            @if($settings->registerImage)
            <img src="{{URL($settings->registerImage)}}?time={{time()}}" class="img-responsive" id ="settings_registerImage">
            @endif
            <span class="label label-danger">{{$errors->first('registerImage')}}</span>
          </div>

          <div class="form-group">
            {{Form::label('bannerLinkHomePage', 'Enlace de banner Homepage')}}
            {{Form::url('bannerLinkHomePage', old('bannerLinkHomepage', $settings->bannerLinkHomePage), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('bannerLinkHomePage')}}</span>
          </div>





          <h3 class="box-title">Imágenes de transmisión en vivo</h3>
         
          <div class="form-group">
            {{Form::label('privateImage', 'Imagen privado(880x670)')}}
            @if($settings->privateImage)
              <a href="" onclick="deleteImg(this)" type="privateImage" img_id="settings_privateImage" style="margin-left: 15px;">Borrar</a>
            @endif
            {{Form::file('privateImage', array('class'=>'form-control'))}}
            @if($settings->privateImage)
            <img src="{{URL($settings->privateImage)}}?time={{time()}}" class="img-responsive" id ="settings_privateImage">
            @endif
            <span class="label label-danger">{{$errors->first('privateImage')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('groupImage', 'Imagen de grupo (880x670)')}}
            @if($settings->groupImage)
              <a href="" onclick="deleteImg(this)" type="groupImage" img_id="settings_groupImage" style="margin-left: 15px;">Borrar</a>
            @endif
            {{Form::file('groupImage', array('class'=>'form-control'))}}
            @if($settings->groupImage)
            <img src="{{URL($settings->groupImage)}}?time={{time()}}" class="img-responsive" id ="settings_groupImage">
            @endif
            <span class="label label-danger">{{$errors->first('groupImage')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('offlineImage', 'Imagen sin conexión (880x670)')}}
            @if($settings->offlineImage)
              <a href="" onclick="deleteImg(this)" type="offlineImage" img_id="settings_offlineImage" style="margin-left: 15px;">Borrar</a>
            @endif
            {{Form::file('offlineImage', array('class'=>'form-control'))}}
            @if($settings->offlineImage)
            <img src="{{URL($settings->offlineImage)}}?time={{time()}}" class="img-responsive" id="settings_offlineImage">
            @endif
            <span class="label label-danger">{{$errors->first('offlineImage')}}</span>
          </div>


  <h3 class="box-title">Banner home</h3>

          <div class="form-group">
            {{Form::label('BannerHomeTextEs', 'Banner home texto en español')}}
            {{Form::url('BannerHomeTextEs', old('BannerHomeTextEs', $settings->BannerHomeTextEs), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('BannerHomeTextEs')}}</span>
          </div>

          <div class="form-group">
            {{Form::label('BannerHomeTextEn', 'Banner home texto en ingles')}}
            {{Form::url('BannerHomeTextEn', old('BannerHomeTextEn', $settings->BannerHomeTextEn), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('BannerHomeTextEn')}}</span>
          </div>

          <div class="form-group">
            {{Form::label('BannerHomeTextFr', 'Banner home texto en frances')}}
            {{Form::url('BannerHomeTextFr', old('BannerHomeTextFr', $settings->BannerHomeTextFr), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('BannerHomeTextFr')}}</span>
          </div>






          <div class="form-group">
            {{Form::label('BannerHomeUno', 'Banner #1')}}
            @if($settings->BannerHomeUno)
              <a href="" onclick="deleteImg(this)" type="BannerHomeUno" img_id="settings_BannerHomeUno" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('BannerHomeUno', array('class'=>'form-control'))}}
            @if($settings->BannerHomeUno)
            <img src="{{URL($settings->BannerHomeUno)}}?time={{time()}}" class="img-responsive" id ="settings_BannerHomeUno">
            @endif
            <span class="label label-danger">{{$errors->first('BannerHomeUno')}}</span>
          </div>

          <div class="form-group">
            {{Form::label('BannerHomeUnoLink', 'Enlace de Banner #1')}}
            {{Form::url('BannerHomeUnoLink', old('BannerHomeUnoLink', $settings->BannerHomeUnoLink), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('BannerHomeUnoLink')}}</span>
          </div>


          <div class="form-group">
            {{Form::label('BannerHomeDos', 'Banner #2')}}
            @if($settings->BannerHomeDos)
              <a href="" onclick="deleteImg(this)" type="BannerHomeDos" img_id="settings_BannerHomeDos" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('BannerHomeDos', array('class'=>'form-control'))}}
            @if($settings->BannerHomeDos)
            <img src="{{URL($settings->BannerHomeDos)}}?time={{time()}}" class="img-responsive" id ="settings_BannerHomeDos">
            @endif
            <span class="label label-danger">{{$errors->first('BannerHomeDos')}}</span>
          </div>

          <div class="form-group">
            {{Form::label('BannerHomeDosLink', 'Enlace de Banner #2')}}
            {{Form::url('BannerHomeDosLink', old('BannerHomeDosLink', $settings->BannerHomeDosLink), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('BannerHomeDosLink')}}</span>
          </div>

            <div class="form-group">
            {{Form::label('BannerHomeTres', 'Banner #3')}}
            @if($settings->BannerHomeTres)
              <a href="" onclick="deleteImg(this)" type="BannerHomeTres" img_id="settings_BannerHomeTres" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('BannerHomeTres', array('class'=>'form-control'))}}
            @if($settings->BannerHomeTres)
            <img src="{{URL($settings->BannerHomeTres)}}?time={{time()}}" class="img-responsive" id ="settings_BannerHomeTres">
            @endif
            <span class="label label-danger">{{$errors->first('BannerHomeTres')}}</span>
          </div>



          <div class="form-group">
            {{Form::label('BannerHomeTresLink', 'Enlace de Banner #3')}}
            {{Form::url('BannerHomeTresLink', old('BannerHomeTresLink', $settings->BannerHomeTresLink), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('BannerHomeTresLink')}}</span>
          </div>


          <div class="form-group">
            {{Form::label('BannerHomeCuatro', 'Banner #4')}}
            @if($settings->BannerHomeCuatro)
              <a href="" onclick="deleteImg(this)" type="BannerHomeCuatro" img_id="settings_BannerHomeTres" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('BannerHomeCuatro', array('class'=>'form-control'))}}
            @if($settings->BannerHomeCuatro)
            <img src="{{URL($settings->BannerHomeCuatro)}}?time={{time()}}" class="img-responsive" id ="settings_BannerHomeCuatro">
            @endif
            <span class="label label-danger">{{$errors->first('BannerHomeCuatro')}}</span>
          </div>


          <div class="form-group">
            {{Form::label('BannerHomeCuatroLink', 'Enlace de Banner #4')}}
            {{Form::url('BannerHomeCuatroLink', old('BannerHomeCuatroLink', $settings->BannerHomeCuatroLink), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('BannerHomeCuatroLink')}}</span>
          </div>


         <div class="form-group">
            {{Form::label('BannerHomeCinco', 'Banner #5')}}
            @if($settings->BannerHomeCinco)
              <a href="" onclick="deleteImg(this)" type="BannerHomeCinco" img_id="settings_BannerHomeCinco" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('BannerHomeCinco', array('class'=>'form-control'))}}
            @if($settings->BannerHomeCinco)
            <img src="{{URL($settings->BannerHomeCinco)}}?time={{time()}}" class="img-responsive" id ="settings_BannerHomeCinco">
            @endif
            <span class="label label-danger">{{$errors->first('BannerHomeCinco')}}</span>
          </div>


          <div class="form-group">
            {{Form::label('BannerHomeCincoLink', 'Enlace de Banner #5')}}
            {{Form::url('BannerHomeCincoLink', old('BannerHomeCincoLink', $settings->BannerHomeCincoLink), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('BannerHomeCincoLink')}}</span>
          </div>


          <div class="form-group">
            {{Form::label('BannerHomeSeis', 'Banner #6')}}
            @if($settings->BannerHomeSeis)
              <a href="" onclick="deleteImg(this)" type="BannerHomeSeis" img_id="settings_BannerHomeSeis" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('BannerHomeSeis', array('class'=>'form-control'))}}
            @if($settings->BannerHomeSeis)
            <img src="{{URL($settings->BannerHomeSeis)}}?time={{time()}}" class="img-responsive" id ="settings_BannerHomeSeis">
            @endif
            <span class="label label-danger">{{$errors->first('BannerHomeSeis')}}</span>
          </div>



          <div class="form-group">
            {{Form::label('BannerHomeSeisLink', 'Enlace de Banner #6')}}
            {{Form::url('BannerHomeSeisLink', old('BannerHomeSeisLink', $settings->BannerHomeSeisLink), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('BannerHomeSeisLink')}}</span>
          </div>

          <div class="form-group">
            {{Form::label('BannerHomeSiete', 'Banner #7')}}
            @if($settings->BannerHomeSiete)
              <a href="" onclick="deleteImg(this)" type="BannerHomeSiete" img_id="settings_BannerHomeSiete" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('BannerHomeSiete', array('class'=>'form-control'))}}
            @if($settings->BannerHomeSiete)
            <img src="{{URL($settings->BannerHomeSiete)}}?time={{time()}}" class="img-responsive" id ="settings_BannerHomeSiete">
            @endif
            <span class="label label-danger">{{$errors->first('BannerHomeSiete')}}</span>
          </div>


                    <div class="form-group">
            {{Form::label('BannerHomeSieteLink', 'Enlace de Banner #7')}}
            {{Form::url('BannerHomeSieteLink', old('BannerHomeSieteLink', $settings->BannerHomeSieteLink), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('BannerHomeSieteLink')}}</span>
          </div>


          <div class="form-group">
            {{Form::label('BannerHomeOcho', 'Banner #8')}}
            @if($settings->BannerHomeOcho)
              <a href="" onclick="deleteImg(this)" type="BannerHomeOcho" img_id="settings_BannerHomeOcho" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('BannerHomeOcho', array('class'=>'form-control'))}}
            @if($settings->BannerHomeOcho)
            <img src="{{URL($settings->BannerHomeOcho)}}?time={{time()}}" class="img-responsive" id ="settings_BannerHomeOcho">
            @endif
            <span class="label label-danger">{{$errors->first('BannerHomeOcho')}}</span>
          </div>


          <div class="form-group">
            {{Form::label('BannerHomeOchoLink', 'Enlace de Banner #8')}}
            {{Form::url('BannerHomeOchoLink', old('BannerHomeOchoLink', $settings->BannerHomeOchoLink), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('BannerHomeOchoLink')}}</span>
          </div>



          <div class="form-group">
            {{Form::label('tipSound', 'Sonido Tip')}}
            {{Form::file('tipSound', array('class'=>'form-control'))}}
            @if($settings->tipSound)
            <a href="{{URL($settings->tipSound).'?v='.time()}}" target="_blank">Ver archivo</a>
            @endif
            <br />
            <span class="label label-danger">{{$errors->first('tipSound')}}</span>
          </div>
          
       <!--   <div class="form-group">
            {{Form::label('placeholderAvatars', 'Placeholder Avatars')}}
            {{Form::file('placeholderAvatar1', array('class'=>'form-control', 'accept' => 'image/*'))}}
            @if($settings->placeholderAvatar1)
            <img src="{{URL($settings->placeholderAvatar1)}}" class="img-responsive" id="settings_placeholderAvatar1">
            <a href="" onclick="deleteImg(this)" type="placeholderAvatar1" img_id="settings_placeholderAvatar1" style="margin-left: 15px;">Borrar</a>
            @endif
            <span class="label label-danger">{{$errors->first('placeholderAvatar1')}}</span>
          </div>
          <div class="form-group">
            {{Form::file('placeholderAvatar2', array('class'=>'form-control', 'accept' => 'image/*'))}}
            @if($settings->placeholderAvatar2)
            <img src="{{URL($settings->placeholderAvatar2)}}" class="img-responsive" id="settings_placeholderAvatar2">
            <a href="" onclick="deleteImg(this)" type="placeholderAvatar2" img_id="settings_placeholderAvatar2" style="margin-left: 15px;">Borrar</a>
            @endif
            <span class="label label-danger">{{$errors->first('placeholderAvatar2')}}</span>
          </div>
          <div class="form-group">
            {{Form::file('placeholderAvatar3', array('class'=>'form-control', 'accept' => 'image/*'))}}
            @if($settings->placeholderAvatar3)
            <img src="{{URL($settings->placeholderAvatar3)}}" class="img-responsive" id="settings_placeholderAvatar3">
             <a href="" onclick="deleteImg(this)" type="placeholderAvatar3" img_id="settings_placeholderAvatar3" style="margin-left: 15px;">Borrar</a>
            @endif
            <span class="label label-danger">{{$errors->first('placeholderAvatar3')}}</span>
          </div>-->
      <?php if(!env('DISABLE_EDIT_ADMIN') || $adminData->isSuperAdmin) { ?>
          <div class="box-footer">
            <input type="hidden" name="id" value="{{$settings->id}}">
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </div>
      {!!Form::close()!!}
      <?php }?>

    </div>
  </div>
  <script type="application/javascript">
      function deleteImg(that) {
          var img_id = $(that).attr('img_id');
          $('#'+ img_id).hide();
          $(that).parent().append("<input type='hidden' name='deleteImg[]' value='"+$(that).attr('type')+"'>");
          $(that).hide();
      }
  </script>
  @endsection