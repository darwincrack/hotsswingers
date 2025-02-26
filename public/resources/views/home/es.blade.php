<?php
   use App\Helpers\Session as AppSession;
   use App\Helpers\Helper as AppHelper;
   
   $userLogin = AppSession::getLoginData();
   
   

   $experiencia =trans('messages.traduc19');
   
   $fisionomia = trans('messages.traduc20');
   
   $misexo = '["Hombre","Mujer","Transexual","Pareja"]';
   
   $misexotraduc = trans('messages.traduc22');
   $misexotraduc = json_decode($misexotraduc);
   
   $etnias = trans('messages.traduc21');
   
   $orientacion = '["hetero","Bi","H Bi"," M Bi"]';


   $Preferencias = $Preferencias[trans('messages.traduc24')];
   $gustos    = $gustos[trans('messages.traduc24')];

   ?>
<!DOCTYPE html>
<html lang="{!! App::getLocale()!!}" ng-app="matroshkiApp">
   <head>
      <meta charset="utf-8">
      <title> {{app('settings')->title}}</title>
      <meta name="Description" CONTENT="{{app('settings')->description}}">
      <meta name="keywords" CONTENT="{{app('settings')->keywords}}" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <link rel="shortcut icon" href="{{URL('uploads/'.app('settings')->favicon)}}" type="image/x-icon">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Bootstrap core CSS -->
      <link type="text/css" href="{{asset('assets/css/frontend.css')}}" rel="stylesheet">
      <link type="text/css" href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
      <link type="text/css" href="{{asset('assets/css/lib.css')}}" rel="stylesheet">
      <link type="text/css" href="{{asset('css/ossn-default.css')}}" rel="stylesheet">
      <script type="text/javascript" src="{{asset('lib/jquery/dist/jquery.min.js')}}"></script>
       <script src="{{asset('js/custom.js')}}"></script>
      @if(env('ANALYTICS_TRACKING_ID'))
      {!! Analytics::render() !!}  
      @endif
      {!! app('settings')->code_before_head_tag !!}
      <style type="text/css">


         input[type="checkbox"] {
           color: red;
         }

         .estil{
             width: 100% !important;
         }

         .ulSub3,.dInlineB,.dInlineB3,.marginAuto{
            padding: 2% 0% 0% 0% !important;
         }

         #regiration_form select, input{
               padding: 4%;
            }

         .estilosborde{
             box-shadow: 2px 3px 6px 2px black;
             padding: 7%;
             background: white;
                 margin-bottom: 15px;
         }

         .estiloerror2{
             background: red;
             width: 100%;
             padding: 1% 1% 1% 1%;
         }
         .validadoes
         {
         display: block;
         color: white;
         text-align: center;
         }
         #regiration_form fieldset:not(:first-of-type) {
         display: none;
         }
         .landingChbx span, .landingRadio span {
         position: relative;
         display: block;
         line-height: 62px;
         padding: 0 35px;
         border-radius: 6px;
         color: #505050;
         background: #fff;
         border: 1px solid #ececec;
         cursor: pointer;
         }
         .landingChbx input:checked+span, .landingRadio input:checked+span {
         background: #2a87a7;
         color: #fff;
         }
         .landingChbx input, .landingRadio input {
             position: absolute;
             top: 83px;
             left: 38px;
             z-index: -4;
         }
         .dInlineB, .media, :hover>.dHover, ol.dInlineB>li, ul.dInlineB>li {
         display: inline-grid;
         width: 100%;
         padding: 0% 10% 0% 10%;
         text-align: center;
         }
         .dInlineB3, .media, :hover>.dHover, ol.dInlineB3>li, ul.dInlineB3>li {
         display: inline-block;
         }
         .botonestil{
         padding: 3% 35% 3% 35%;
         background: #007aff;
         }
         .botonestil2{
            padding: 3% 15% 3% 15%;
            background: #cfd2d6;
         }
         .botonestil3{
         padding: 3% 15% 3% 15%;
         background: #007aff;
         }
         .ulSub3, .ulSub4 {
         display: inline-block;
         }
         .ulSub3 li, .ulSub4 li {
         display: inline;
         }
         .landingChbx span, .landingRadio span {
         position: relative;
         display: block;
         line-height: 62px;
         padding: 0 35px;
         border-radius: 6px;
         color: #505050;
         background: #fff;
         border: 1px solid #ececec;
         }

         .estil{
            width: 100% !important;
         }

 
      </style>
   </head>
   <body>

                        <div class="container">
                           <div class="row">


     
                                       <div class="col-md-6 home-left-contents" style="    padding-top: 20px;">

                                           <div class="logo" style="width: 100%">
                                             @if(app('settings')->logo)
                                             <img src="/uploads/{{app('settings')->logo}}" alt="{{app('settings')->siteName}}" style="height: 75px;">
                                             @endif
                                          </div>

                                          <div class="description" style="    padding-top: 72px;">
                                             @lang('messages.homedescription')          
                                          </div>

                                            
                                       </div>
                                       <div class="col-md-6" style="">
                                          <div class="form_block" style=" padding: 20px;">
                                             @if(session('msgError'))
                                             <div class=" alert alert-danger"><i class="fa fa-times-circle"></i> {{session('msgError')}}</div>
                                             @endif
                                             {{Form::open(array('method'=>'post', 'url'=>URL('auth/login'), 'class'=>'form-inline', 'autocomplete' => 'off' ))}}
                                             <div class="row">
                                                <div class="col-md-5 text-right" style="padding: 0% 1% 0% 0%;">
                                                   <div class="form-group ">
                                                      <input class="form-control" value="{{old('username')}}" id="email" name="username" type="text" placeholder="@lang('messages.username')" autocomplete="off">
                                                   </div>
                                                </div>
                                                <div class="col-md-4 text-right"  style="padding: 0% 1% 0% 0%;">
                                                   <div class="form-group ">
                                                      <input class="form-control" id="passw1" name="password" type="password" placeholder="@lang('messages.password')" autocomplete="off">
                                                   </div>
                                                </div>
                                                <div class="col-md-3 text-left" style="padding: 0% 0% 0% 3%;">
                                                   <button type="submit" class="btn btn-primary" style="    height: 34px;">@lang('messages.login')</button>
                                                </div>
                                             </div>
                                             <div class="form-group" style="width: 100%;     color: white; margin-bottom: 15px;">
                                                <div class="col-xs-6 col-sm-push-2">
                                                   <label class="checkbox-inline">
                                                   <input id="inlineCheckbox1" value="option1" checked="" type="checkbox"> @lang('messages.rememberMe')  
                                                   </label>
                                                </div>
                                                <div class="col-xs-5 col-sm-5 text-right f_pwd">
                                                   <a id="checkForgotPassword" href="javascript:void(0);" style="color:white;">@lang('messages.forgotPass')?</a>
                                                </div>
                                             </div>
                                             <div class="form-group" id="load-from-rest-pw" style="display: none; width: 100%;     margin-bottom: 10px;
                                                text-align: center;">
                                                <div class="col-sm-12 ">
                                                   <span id ="required" class="required label label-danger"></span>
                                                   <div class="input-group">
                                                      <input type="email" id="emailReset" name='emailReset' class="form-control" placeholder="@lang('messages.Enteremailaccount')" >
                                                      <span class="input-group-addon btn btn-primary" id="frm-reset-send" style="color:white;">@lang('messages.send')</span>
                                                   </div>
                                                </div>
                                             </div>
                                             {{Form::close()}}
                                             <div class="clearfix"></div>
                                          </div>
                                       </div>




                           </div>
                        </div>




      <!-- content   -->
         {{Form::open(array('id'=>'regiration_form','method'=>'post', 'url'=>URL('register'), 'class'=>'form-inline', 'autocomplete' => 'off' ))}}
         <fieldset style="display: block;" id="uno">
            <div class="opensource-socalnetwork">
               <div class="ossn-page-container">
                  <div class="ossn-inner-page">
                     <div class="ossn-layout-startup">
                        <div class="container">
                           <div class="row" style="    margin-top: -32px;">
                              <div class="ossn-system-messages">
                                 <div class="row">
                                    <div class="col-md-11">
                                       <div class="ossn-system-messages-inner">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="ossn-home-container">
                                 <div class="inner">
                                    <div class="row ossn-page-contents">
                                       <div class="col-md-6 home-left-contents">
                                         
                                          <ul class="some-icons">
                                             <li><i class="fa fa-users"></i></li>
                                             <li><i class="fa fa-comments-o"></i></li>
                                             <li><i class="fa fa-envelope"></i></li>
                                             <li><i class="fa fa-globe"></i></li>
                                             <li><i class="fa fa-picture-o"></i></li>
                                             <li><i class="fa fa-video-camera"></i></li>
                                             <li><i class="fa fa-map-marker"></i></li>
                                             <li><i class="fa fa-calendar"></i></li>
                                          </ul>
                                       </div>
                                       <div class="col-md-6">

                                          <div class="ossn-widget" style="padding: 11%;text-align: center;">
                                             <h1 style="font-size: 20px;">@lang('messages.traduc17')</h1>
                                             <h2 style="font-size: 18px;">@lang('messages.traduc18'):</h2>
                                             <div class="validadoes" style="display: none;">

                                                <b class="estiloerror2">* @lang('messages.Required_fields')</b>
                                             </div>
                                             <ul class="dInlineB w50">
                                                

                                                @foreach(json_decode($misexo) as $idsexo => $sexoes)

                                                 @php

                                                 $columna = $idsexo +1;

                                                 @endphp 
                                                <li id="{{$sexoes}}" class="w100 pad2"><label class="dBlock FS16 w100 landingChbx"><input type="radio" name="sexo" value="{{$columna}}"> <span data-valor="{{$idsexo}}" class="pad10_10">{{$misexotraduc[$idsexo]}}</span></label></li>
                                                @endforeach 
                                             </ul>
                                             <input type="button" name="" data-valor="uno" class="next btn btn-info botonestil" value="@lang('messages.traduc16')">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <script>$(window).ready(function(){$('body').addClass('ossn-layout-startup-background');}); </script>
                  </div>
               </div>
            </div>
            <!-- content 
               end-->
            </div>
         </fieldset>
         <!-- Segunda parte del formulario -->
         <fieldset style="display: none;" id="dos">
            <div class="row" style="margin-right: 0; margin-left: 0;">
               <div class="estilosborde col-xs-12 col-sm-12 col-md-6 col-md-offset-3 text-center">
                  <div>
                     <h1>@lang('messages.tusexual')</h1>
                      <p>@lang('messages.imfoact') </p>
                  </div>
                  <div class="validadoes" style="display: none;">
                     <b class="estiloerror2">* @lang('messages.Required_fields')</b>
                  </div>
                  <ul class="dInlineB w50 orientacionsexu">


                     @foreach(json_decode($orientacion) as $orientado)

                        <li class="w100 pad2" data-pareja="Pareja {{$orientado}}" data-mujer="Mujer {{$orientado}}" data-hombre="Hombre {{$orientado}}">
                           <label class="dBlock FS16 w100 landingChbx">
                              <input type="radio" name="orientacion" value="{{$orientado}}"> 
                              <span class="pad10_10">{{$orientado}}</span>
                           </label>
                        </li>

                     @endforeach 
                  </ul>
                  <input type="button" name="previous" data-valor="dos" class="previous btn btn-default botonestil2" value="@lang('messages.traduc23')">
                  <input type="button" name="next" data-valor="dos" class="next btn btn-info botonestil3" value="@lang('messages.traduc16')">
               </div>
            </div>
         </fieldset>
         <!-- tercera parte del formulario -->
         <fieldset style="display: none;" id="tres">
            <div class="row" style="margin-right: 0; margin-left: 0;">
               <div class="estilosborde col-xs-12 col-sm-12 col-md-8 col-md-offset-2 text-center">
                  <div>
                     <h1>@lang('messages.busk')</h1>
                     <p>@lang('messages.traduc1')</p>
                  </div>
                    <div class="validadoes" style="display: none;">
                     <b class="estiloerror2">* @lang('messages.Required_fields')</b>
                  </div>
                  <ul class="ulSub3" style="margin-bottom: 10%;">

                     @foreach($Preferencias as $sexuales_id => $sexuales)
                     <li class="MB5 pad2">
                        <label class="FS16  landingChbx" style="display: inline-table !important;"><input type="checkbox" class="tusbusquedas tusexualidad" name="buscar_{{str_replace(' ','_',$sexuales )}}" value="{{$sexuales_id}}"> 
                        <span>{{$sexuales}}</span>
                        </label>
                     </li>
                     @endforeach 
                  </ul>
                  <input type="hidden" name="todoslasbusquedas" id="todoslasbusquedas">
                  <input type="hidden" name="type" id="type" value="model">
                  <input type="button" name="previous" data-valor="tres" class="previous btn btn-default botonestil2" value="@lang('messages.traduc23')">
                  <input type="button" name="next" data-valor="tres" class="next btn btn-info botonestil3" value="@lang('messages.traduc16')">
               </div>
            </div>
         </fieldset>
         <!-- cuarta parte del formulario -->
         <fieldset style="display: none;" id="cuatro">
            <div class="row" style="margin-right: 0; margin-left: 0;">
               <div class="estilosborde col-xs-12 col-sm-12 col-md-8 col-md-offset-2 text-center">
                  <div>
                     <h1>@lang('messages.traduc2')</h1>
                     <p>@lang('messages.traduc3')</p>
                  </div>                  
                  <div class="validadoes" style="display: none;">
                     <b class="estiloerror2">* @lang('messages.Required_fields')</b>
                  </div>                  
                  <ul class="dInlineB3" style="margin-bottom: 10%;">
                     @foreach($gustos as $tusgustos_id => $tusgustos)
                     <li class="MB5 pad2">
                        <label class="FS16  landingChbx" style="display: inline-table !important;"><input class="tusgustos" type="checkbox" name="gustar_{{str_replace(' ','_',$tusgustos)}}" value="{{$tusgustos_id}}"> 
                        <span>{{$tusgustos}}</span>
                        </label>
                     </li>
                     @endforeach 
                  </ul>
                  <input type="hidden" name="todoslosgustos" id="gustosseleccionados">
                  <input type="button" name="previous" class="previous btn btn-default botonestil2" data-valor="cuatro" value="@lang('messages.traduc23')">
                  <input type="button" name="next" data-valor="cuatro" class="next btn btn-info botonestil3" value="@lang('messages.traduc16')">
               </div>
            </div>
         </fieldset>
         <!-- quinta parte del formulario -->
         <fieldset style="display: none;" id="cinco">
            <div class="row" style="margin-right: 0; margin-left: 0;">
               <div class="estilosborde col-xs-12 col-sm-12 col-md-6 col-md-offset-3 text-center">
                  <div>
                     <h1>@lang('messages.traduc4')</h1>
                     <p>@lang('messages.traduc5')</p>
                  </div>                  
                  <div class="validadoes" style="display: none;">
                     <b class="estiloerror2">* @lang('messages.Required_fields')</b>
                  </div>
                  <ul class="dInlineB w50">
                     @foreach(json_decode($experiencia) as $experto)
                     <li class="MB5 pad2">
                        <label class="FS16  landingChbx"><input type="radio" name="experiencias" value="{{str_replace(' ','_',$experto)}}"> 
                        <span>{{$experto}}</span>
                        </label>
                     </li>
                     @endforeach 
                  </ul>
                  <input type="button" data-valor="cinco" name="previous" class="previous btn btn-default botonestil2" value="@lang('messages.traduc23')">
                  <input type="button" name="next" data-valor="cinco" class="next btn btn-info botonestil3" value="@lang('messages.traduc16')">
               </div>
            </div>
         </fieldset>
         <!-- sesta parte del formulario -->
         <fieldset style="display: none;" id="seis" data-texto="@lang('messages.traduc7')">
            <div class="row" style="margin-right: 0; margin-left: 0;">
               <div class="estilosborde col-xs-12 col-sm-12 col-md-6 col-md-offset-3 text-center">
                  <div>
                     <h1 id="mitexto">@lang('messages.traduc6')</h1>
                     <p></p>
                  </div>                  
                  <div class="validadoes" style="display: none;">
                     <b class="estiloerror2">* @lang('messages.Required_fields')</b>
                  </div>


                  <div class="row" style="margin-bottom: 8%;margin-top: 6%;">

                     <div class="col-md-4 text-left" style="margin-bottom: 2%;">
                           <label class="dTCell vaM FS16 w30 txtAR padR15" for="date"><b>@lang('messages.traduc8')</b></label>
                     </div>
                     <div class="col-md-8 text-left" style="margin-bottom: 2%;">

                        <p class="dTableLF w100"> 
                           <span class="dTCell">
                              <select id="dia" name="ellanacimientodia" class="lafecha validaresto form-control" style="width: 31%;">
                                 <option value="0" selected="selected">@lang('messages.traduc9')</option>
                                 @for ($i = 1; $i <= 31; $i++)
                                 <option value="{{ $i }}">{{ $i }}</option>
                                 @endfor
                              </select>
                              <select id="mes" name="ellanacimientomes" class="lafecha validaresto form-control" style="width: 31%;">
                                 <option value="0" selected="selected">@lang('messages.traduc10')</option>
                                 @for ($i = 1; $i <= 12; $i++)
                                 <option value="{{ $i }}">{{ $i }}</option>
                                 @endfor
                              </select>
                              <select id="ano" name="ano" class="lafecha validaresto form-control" style="width: 31%;">
                                 <option value="0" selected="selected">@lang('messages.traduc11')</option>
                                 @for ($i = 2002; $i >= 1921; $i--)
                                 <option value="{{ $i }}">{{ $i }}</option>
                                 @endfor
                              </select>
                              <span class="padL10 vaM">
                              </span>
                           </span>
                        </p>
                     </div>

                        <div class="col-md-4 text-left" style="margin-bottom: 2%;">
                           <strong class="dTCell vaM FS16">@lang('messages.traduc12')</strong> 
                        </div>
                       <div class="col-md-8 text-left" style="margin-bottom: 2%;">
                           <select class="w100 validaresto form-control" name="ellacm" style="width: 96%;">
                                 <option value="">-- cm</option>
                                 @for ($e = 250; $e >= 120; $e--)
                                 <option value="{{ $e }}">{{ $e }}</option>
                                 @endfor
                              </select>
                        </div>
                       <div class="col-md-4 text-left" style="margin-bottom: 2%;">
                           <strong class="dTCell vaM FS16">@lang('messages.traduc13')</strong>
                        </div>
                       <div class="col-md-8 text-left" style="margin-bottom: 2%;">

                              <select class="w100 validaresto form-control" name="ellafionomia" style="width: 96%;">
                                 <option value="" selected="selected">- @lang('messages.traduc14') -</option>
                                 @foreach(json_decode($fisionomia) as $fisio)
                                 <option label="{{$fisio}}" value="{{$fisio}}">{{$fisio}}</option>
                                 @endforeach 
                              </select>
                           
                        </div>
                       <div class="col-md-4 text-left" style="margin-bottom: 2%;">
                           <strong class="dTCell vaM FS16 ">@lang('messages.traduc15')</strong>
                        </div>
                       <div class="col-md-8 text-left" style="margin-bottom: 2%;">
                           <select class="w100 validaresto form-control" name="ellaetnia" style="width: 96%;">
                                 <option value="" selected="selected">- @lang('messages.traduc14') -</option>
                                 @foreach(json_decode($etnias) as $etnia)
                                 <option label="{{$etnia}}" value="{{$etnia}}">{{$etnia}}</option>
                                 @endforeach 
                           </select>
                        </div>

                        
                     </div>

                  <input type="button" name="previous" data-valor="seis" class="previous btn btn-default botonestil2" value="@lang('messages.traduc23')">
                  <input type="button" name="next" data-valor="seis" class="next btn btn-info botonestil3" value="@lang('messages.traduc16')">

                  </div>
               </div>
            </div>
         </fieldset>
         <!-- septima parte del formulario -->
         <fieldset style="display: none;" id="siete">
            <div class="row" style="margin-right: 0; margin-left: 0;">
               <div class="estilosborde col-xs-12 col-sm-12 col-md-6 col-md-offset-3 text-center">
                  <div>
                     <h1>Él</h1>
                     <p></p>
                  </div>                  
                  <div class="validadoes" style="display: none;">
                     <b class="estiloerror2">* @lang('messages.Required_fields')</b>
                  </div>


                  <div class="row" style="margin-bottom: 8%;margin-top: 6%;">

                     <div class="col-md-4 text-left" style="margin-bottom: 2%;">
                           <label class="dTCell vaM FS16 w30 txtAR padR15" for="date"><b>@lang('messages.birthdate')</b></label>
                     </div>
                     <div class="col-md-8 text-left" style="margin-bottom: 2%;">

                        <p class="dTableLF w100"> 
                           <span class="dTCell">
                              <select id="diael" class="lafecha validaresto2 form-control" name="elnacimientodia" style="width: 31%;">
                                 <option value="0" selected="selected">@lang('messages.traduc9')</option>
                                 @for ($i = 1; $i <= 31; $i++)
                                 <option value="{{ $i }}">{{ $i }}</option>
                                 @endfor
                              </select>
                              <select id="mesel" class="lafecha validaresto2 form-control" name="elnacimientomes" style="width: 31%;">
                                 <option value="0" selected="selected">@lang('messages.traduc10')</option>
                                 @for ($i = 1; $i <= 12; $i++)
                                 <option value="{{ $i }}">{{ $i }}</option>
                                 @endfor
                              </select>
                              <select id="anoel" class="lafecha validaresto2 form-control" name="elnacimientoano" style="width: 31%;">
                                 <option value="0" selected="selected">@lang('messages.traduc11')</option>
                                 @for ($i = 2002; $i >= 1921; $i--)
                                 <option value="{{ $i }}">{{ $i }}</option>
                                 @endfor
                              </select>
                              <span class="padL10 vaM">
                              </span>
                           </span>
                        </p>
                     </div>

                        <div class="col-md-4 text-left" style="margin-bottom: 2%;">
                           <strong class="dTCell vaM FS16">@lang('messages.traduc12')</strong> 
                        </div>
                       <div class="col-md-8 text-left" style="margin-bottom: 2%;">
                           <select class="w100 validaresto2 form-control" name="elcm" style="width: 96%;">
                                 <option value="">-- cm</option>
                                 @for ($e = 250; $e >= 120; $e--)
                                 <option value="{{ $e }}">{{ $e }}</option>
                                 @endfor
                              </select>
                        </div>
                       <div class="col-md-4 text-left" style="margin-bottom: 2%;">
                           <strong class="dTCell vaM FS16">@lang('messages.traduc13')</strong>
                        </div>
                       <div class="col-md-8 text-left" style="margin-bottom: 2%;">

                              <select class="w100 validaresto2 form-control" name="elfisionomia" style="width: 96%;">
                                 <option value="" selected="selected">- @lang('messages.traduc14') -</option>
                                 @foreach(json_decode($fisionomia) as $fisio)
                                 <option label="{{$fisio}}" value="{{$fisio}}">{{$fisio}}</option>
                                 @endforeach 
                              </select>
                           
                        </div>
                       <div class="col-md-4 text-left" style="margin-bottom: 2%;">
                           <strong class="dTCell vaM FS16 ">@lang('messages.traduc15')</strong>
                        </div>
                       <div class="col-md-8 text-left" style="margin-bottom: 2%;">
                           <select class="w100 validaresto2 form-control" name="eletnia" style="width: 96%;">
                                 <option value="" selected="selected">- @lang('messages.traduc14') -</option>
                                 @foreach(json_decode($etnias) as $etnia)
                                 <option label="{{$etnia}}" value="{{$etnia}}">{{$etnia}}</option>
                                 @endforeach 
                           </select>
                        </div>

                        
                     </div>

                  <input type="hidden" name="birthdate" id="birthdate">
                  <input type="hidden" name="subirthdate" id="birthdate2">
                  <input type="button" name="previous" data-valor="siete" class="previous btn btn-default botonestil2" value="@lang('messages.traduc23')">
                  <input type="button" name="next" data-valor="siete" class="next btn btn-info botonestil3" value="@lang('messages.traduc16')">
               </div>
            </div>
         </fieldset>
         <!-- octava parte del formulario -->
         <fieldset style="display: none;" id="ocho">
            <div class="row" style="margin-right: 0; margin-left: 0;">
               <div class="estilosborde col-xs-12 col-sm-12 col-md-6 col-md-offset-3 text-center">
                  <div>
                     <h1>@lang('messages.Laststep')</h1>
                     <p>@lang('messages.wearepolishingyournewprofile')</p>
                  </div>                  
                  <div class="" id="validadoes1" style="font-size: 12pt;display: none;background: red;padding: 2%;color: white;">
                     <b class="estiloerror2">* @lang('messages.Required_fields')</b>
                  </div>
                  <div class="row" style="padding-top: 6%;">
                     <div class="col-md-6 text-left">
                        <strong class="dTCell vaM FS16">@lang('messages.Yourcity')</strong>

                     </div>                          
                     <div class="col-md-6" style="margin: 5px 0;">

                        {{Form::select('location', $countries, old('location'), array('class'=>'form-control estil','required'=>'required','name'=>'location', 'placeholder'=>@trans('messages.pleaseSelect')))}} 

                     </div>                     

                     <div class="col-md-6 text-left">
                        <strong class="dTCell vaM FS16">@lang('messages.firstname')</strong>

                     </div>                          
                     <div class="col-md-6" style="margin: 5px 0;">

                         <input class="validaresto4 w100 form-control" type="text" placeholder="@lang('messages.firstname')" pattern="^@?(\w){1,15}$"
                        title="{{$errors->first('firstName')}}" required="required" name="firstName" style="width: 100%">


                     </div> 


                     <div class="col-md-6 text-left">
                        <strong class="dTCell vaM FS16">@lang('messages.lastname')</strong>

                     </div>                          
                     <div class="col-md-6" style="margin: 5px 0;">

                         <input class="validaresto4 w100 form-control" type="text" placeholder="@lang('messages.lastname')" pattern="^@?(\w){1,15}$"
                        title="{{$errors->first('lastName')}}" required="required" name="lastName" style="width: 100%">


                     </div> 




                     <div class="col-md-6 text-left">
                        <strong class="dTCell vaM FS16">Usuario</strong>
                     </div>                          
                     <div class="col-md-6" style="margin: 5px 0;">
                       
                        <input class="validaresto4 w100 form-control" type="text" placeholder="Nick" pattern="^@?(\w){1,15}$"
       title="porfavor introduce un  nick valido" required="required" name="username" style="width: 100%">

                     </div> 


                     <div class="col-md-6 text-left">

                        <strong class="dTCell vaM FS16">@lang('messages.emailaddress')</strong>

                     </div>                          
                     <div class="col-md-6" style="margin: 5px 0;">
                       
                        <input class="w100 validaresto3 form-control" type="email" placeholder="su@email.com" required="required" name="email" id="correo1" style="width: 100%">

                     </div> 

                     <div class="col-md-6 text-left">

                        <strong class="dTCell vaM FS16" required="required">@lang('messages.Confirmemail')</strong>

                     </div>                          
                     <div class="col-md-6" style="margin: 5px 0;">
                       
                        <input class="w100 validaresto4 form-control" type="email"  placeholder="su@email.com" required="required" name="email2" id="correo2" style="width: 100%">

                     </div> 

                     <div class="col-md-6 text-left">

                        <strong class="dTCell vaM FS16">@lang('messages.password')</strong>

                     </div>                          
                     <div class="col-md-6" style="margin: 5px 0;">
                       
                        <input class="w100 validaresto4 form-control" placeholder="********" maxlength="30" type="password" style="width: 100%; background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACIUlEQVQ4EX2TOYhTURSG87IMihDsjGghBhFBmHFDHLWwSqcikk4RRKJgk0KL7C8bMpWpZtIqNkEUl1ZCgs0wOo0SxiLMDApWlgOPrH7/5b2QkYwX7jvn/uc//zl3edZ4PPbNGvF4fC4ajR5VrNvt/mo0Gr1ZPOtfgWw2e9Lv9+chX7cs64CS4Oxg3o9GI7tUKv0Q5o1dAiTfCgQCLwnOkfQOu+oSLyJ2A783HA7vIPLGxX0TgVwud4HKn0nc7Pf7N6vV6oZHkkX8FPG3uMfgXC0Wi2vCg/poUKGGcagQI3k7k8mcp5slcGswGDwpl8tfwGJg3xB6Dvey8vz6oH4C3iXcFYjbwiDeo1KafafkC3NjK7iL5ESFGQEUF7Sg+ifZdDp9GnMF/KGmfBdT2HCwZ7TwtrBPC7rQaav6Iv48rqZwg+F+p8hOMBj0IbxfMdMBrW5pAVGV/ztINByENkU0t5BIJEKRSOQ3Aj+Z57iFs1R5NK3EQS6HQqF1zmQdzpFWq3W42WwOTAf1er1PF2USFlC+qxMvFAr3HcexWX+QX6lUvsKpkTyPSEXJkw6MQ4S38Ljdbi8rmM/nY+CvgNcQqdH6U/xrYK9t244jZv6ByUOSiDdIfgBZ12U6dHEHu9TpdIr8F0OP692CtzaW/a6y3y0Wx5kbFHvGuXzkgf0xhKnPzA4UTyaTB8Ph8AvcHi3fnsrZ7Wore02YViqVOrRXXPhfqP8j6MYlawoAAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" required="required" name="password" id="clave1">

                     </div>

                     <div class="col-md-6 text-left">

                        <strong class="dTCell vaM FS16">@lang('messages.VerifyPassword')</strong>

                     </div>         



                     <div class="col-md-6" style="margin: 5px 0;">
                       
                        <input class="w100 validaresto4 form-control" placeholder="********" maxlength="30" type="password" style="width: 100%; background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACIUlEQVQ4EX2TOYhTURSG87IMihDsjGghBhFBmHFDHLWwSqcikk4RRKJgk0KL7C8bMpWpZtIqNkEUl1ZCgs0wOo0SxiLMDApWlgOPrH7/5b2QkYwX7jvn/uc//zl3edZ4PPbNGvF4fC4ajR5VrNvt/mo0Gr1ZPOtfgWw2e9Lv9+chX7cs64CS4Oxg3o9GI7tUKv0Q5o1dAiTfCgQCLwnOkfQOu+oSLyJ2A783HA7vIPLGxX0TgVwud4HKn0nc7Pf7N6vV6oZHkkX8FPG3uMfgXC0Wi2vCg/poUKGGcagQI3k7k8mcp5slcGswGDwpl8tfwGJg3xB6Dvey8vz6oH4C3iXcFYjbwiDeo1KafafkC3NjK7iL5ESFGQEUF7Sg+ifZdDp9GnMF/KGmfBdT2HCwZ7TwtrBPC7rQaav6Iv48rqZwg+F+p8hOMBj0IbxfMdMBrW5pAVGV/ztINByENkU0t5BIJEKRSOQ3Aj+Z57iFs1R5NK3EQS6HQqF1zmQdzpFWq3W42WwOTAf1er1PF2USFlC+qxMvFAr3HcexWX+QX6lUvsKpkTyPSEXJkw6MQ4S38Ljdbi8rmM/nY+CvgNcQqdH6U/xrYK9t244jZv6ByUOSiDdIfgBZ12U6dHEHu9TpdIr8F0OP692CtzaW/a6y3y0Wx5kbFHvGuXzkgf0xhKnPzA4UTyaTB8Ph8AvcHi3fnsrZ7Wore02YViqVOrRXXPhfqP8j6MYlawoAAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" required="required" name="password_confirmation" id="clave2">

                     </div> 


                     <div class="col-md-6 text-left">

                        @lang('messages.IconfirmthatIhavereadandaccept')

                     </div>                          
                     <div class="col-md-6">
                       <a href="/policies" target="_blank" class="txtUnderL colorTheme">@lang('messages.conditiondos') </a> <a href="" class="txtUnderL colorTheme">@lang('messages.cuantoalascookies')</a>.
                       <input type="checkbox" class="validaresto33 form-control" required="required" name="contrato">
                     </div> 


                  <input type="button" name="previous" data-valor="ocho" class="previous btn btn-default botonestil2" value="@lang('messages.traduc23')">
                  <button type="submit"  class="submit btn btn-success botonestil3" id="submit_data">@lang('messages.createAccount')</button>

                  </div>

               </div>
            </div>
         </fieldset>
      {{Form::close()}}
      <!-- content end-->


<iframe src="{{URL('livesHome')}}"  id="iframelives" width="100%" frameborder="0" scrolling="no" style="border:none;"></iframe>

 
      
      <footer class="text-center">
         <div class="col-md-12">
            <div class="footer-contents">
               <div class="ossn-footer-menu">
                  <a href="{{URL('/')}}">&COPY; COPYRIGHT {{app('settings')['siteName']}} </a>
                  @foreach( app('pages') as $page )
                  <a href="{{URL('page/'.$page->alias)}}">{{$page->title}}</a>
                  @endforeach
               </div>
            </div>
         </div>
         <div class="col-md-12" style="background: black; color: white; padding: 10px;">
            <ul class="estiloul" style="align-items: center;
               justify-content: center;">
               <li>
                  @lang('messages.Selectyourlanguage'): 
               </li>
               @if (config('locale.status') && count(config('locale.languages')) > 1)
               @foreach (array_keys(config('locale.languages')) as $lang)
               @if ($lang != App::getLocale())
               <li class="" style="margin-right: 10px; margin-left: 3px;">
                  <a class="back" href="{{ url('lang', [$lang]) }}"> <img width="30px" height="15px" src='{{URL("images/$lang.jpg")}}'>
                  </a>
               </li>
               @endif
               @endforeach
               @endif
            </ul>
         </div>
      </footer>
      <script type="text/javascript">
         window.appSettings = <?= json_encode([
            'SOCKET_URL' => env('SOCKET_URL'),
            'RTC_URL' => env('RTC_URL'),
            'CHAT_ROOM_ID' => isset($room) ? $room : null,
            'BASE_URL' => BASE_URL,
            'TOKEN' => ($userLogin) ? $userLogin->token : null,
            'LIMIT_PER_PAGE' => LIMIT_PER_PAGE,
            'USER' => !$userLogin ? null : ['id' => $userLogin->id, 'role' => $userLogin->role],
            'TIMEZONE'=> isset(app('userSettings')['timezone']) ? app('userSettings')['timezone'] : null,
            'registerImage' => isset(app('settings')['registerImage']) ? URL(app('settings')['registerImage']) : URL('images/welcome.png'),
            'IP' => $_SERVER['REMOTE_ADDR'],
            'placeholderAvatars' => []
            ]); ?>;
         <?php if(app('settings')->placeholderAvatar1){?>
           window.appSettings.placeholderAvatars.push('<?= app('settings')->placeholderAvatar1; ?>');
         <?php }?>
          <?php if(app('settings')->placeholderAvatar2){?>
           window.appSettings.placeholderAvatars.push('<?= app('settings')->placeholderAvatar2; ?>');
         <?php }?>
          <?php if(app('settings')->placeholderAvatar3){?>
           window.appSettings.placeholderAvatars.push('<?= app('settings')->placeholderAvatar3; ?>');
         <?php }?>
         window.appSettings.TURN_CONFIG = [{"url":"stun:<?= env('TURN_URL'); ?>"},{"url":"turn:<?= env('TURN_URL'); ?>?transport=tcp","username":"<?= env('TURN_USERNAME');?>","credential":"<?= env('TURN_CREDENTIAL');?>"},{"url":"turn:<?= env('TURN_URL'); ?>?transport=udp","username":"<?= env('TURN_USERNAME');?>","credential":"<?= env('TURN_CREDENTIAL');?>"}];
         window.appSettings.ICE_SERVER = {
           url: "<?= env('TURN_URL'); ?>",
           username: "<?= env('TURN_USERNAME');?>",
           credential:"<?= env('TURN_CREDENTIAL');?>"
         };
      </script>
      <script type="text/javascript"  src="{{asset('js/bootstrap.min.js')}}"></script>
      <script src="{{ asset('assets/js/angular.js') }}"></script>
      <script type="text/javascript" src="{{asset('lib/angularlazyimg/release/angular-lazy-img.js')}}"></script>
      <script src="{{ asset('assets/js/lib.js') }}"></script>
      <script src="{{ asset('assets/js/app.js') }}?v=<?= env('BUILD_VERSION');?>"></script>
      <script type="text/javascript" src="{{asset('app/filters/filter.js')}}?v=<?= env('BUILD_VERSION');?>"></script>
      <script src="{{ asset('assets/js/service.js') }}?v=<?= env('BUILD_VERSION');?>"></script>
      <script src="{{ asset('assets/js/controller.js') }}?v=<?= env('BUILD_VERSION');?>"></script>
      <script src="{{ asset('assets/js/directive.js') }}?v=<?= env('BUILD_VERSION');?>"></script>
      <script type="text/javascript" src="{{asset('lib/jquery/src/site.js')}}?v=<?= env('BUILD_VERSION');?>"></script>
      <script src="{{ asset('assets/js/modal.js') }}?v=<?= env('BUILD_VERSION');?>"></script>
      @yield('scripts')
      <script type="text/javascript">



         var namePattern = "^[a-z A-Z]{4,30}$";
         var emailPattern = "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$";
          
         function checkInput(idInput, pattern) {
         return $(idInput).val().match(pattern) ? true : false;
         }


         function enableSubmit (idForm) {
         $(idForm + " button.submit").removeAttr("disabled");
         }
          
         function disableSubmit (idForm) {
         $(idForm + " button.submit").attr("disabled", "disabled");
         }


         function checkForm (idForm) {


            var namePattern = "^[a-z A-Z]{4,30}$";
            var emailPattern = "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$";

            $(idForm + " *").on("change keydown", function() {
            

            if($("#correo1").val() != $("#correo2").val())
            {
               $("#validadoes1").css("display","block");
               $("#validadoes1").html("* @lang('messages.correovalid') ");
               /*disableSubmit(idForm);
               console.dir("los correos deben coincidir");*/
            }
            else{ 
               $("#validadoes1").hide();
               enableSubmit(idForm);
            }

            if($("#clave1").val() != $("#clave2").val())
            {
               $("#validadoes1").show();
               $("#validadoes1").html("* @lang('messages.clavesvalid') ");
               disableSubmit(idForm);
            }
            else{
               if($("#clave2").val() != "")
               {
                  $("#validadoes1").hide();
                  enableSubmit(idForm);   

               }
            }


            });

         }

         $(function() {
         checkForm("#regiration_form");
         });


           
            function removeItemFromArr ( arr, item ) {
             var i = arr.indexOf( item );

             if ( i !== -1 ) {
                 arr.splice( i, 1 );
             }
            }



            $( ".tusbusquedas" ).click(function() {

               text = $( this ).val();
               var dff = $( "#todoslasbusquedas" ).val();
               if ( dff === '') {
                     campos = new Array(text); 
                     campos[0] = text;
                     var tec = JSON.stringify(campos);
                    $( "#todoslasbusquedas" ).val( tec );
                     
               }
               else
               {
                  var as = JSON.parse(dff);
                  var datt = as.find(element => element == text );
                  if(Number.isInteger(parseInt(datt)))
                  {


                  removeItemFromArr( as, datt );


                  var tec = JSON.stringify(as);
                  $( "#todoslasbusquedas" ).val( tec );

                  }
                  else
                  {

                     as.push(text);
                     var tec = JSON.stringify(as);
                     $( "#todoslasbusquedas" ).val( tec );

                  }
                  


               }


            });





            $( ".tusgustos" ).click(function() {

               text = $( this ).val();
               var dff = $( "#gustosseleccionados" ).val();
               if ( dff === '') {
                  console.dir(dff);
                     campos = new Array(text); 
                     campos[0] = text;
                     var tec = JSON.stringify(campos);
                    $( "#gustosseleccionados" ).val( tec );
                     
               }
               else
               {
                  var as = JSON.parse(dff);
                  var datt = as.find(element => element == text );
                  console.dir("numero:");
                  console.dir(datt);
                  if(Number.isInteger(parseInt(datt)))
                  {


                  removeItemFromArr( as, datt );


                  var tec = JSON.stringify(as);
                  $( "#gustosseleccionados" ).val( tec );

                  }
                  else
                  {

                     as.push(text);
                     var tec = JSON.stringify(as);
                     $( "#gustosseleccionados" ).val( tec );

                  }
                  


               }


            });





            $( "#Mujer" ).click(function() {

               $("#mitexto").html($("#seis").data("texto"));
               $(".orientacionsexu li").each(function(){
                  mihtml = '<label class="dBlock FS16 w100 landingChbx"><input type="radio" name="inclinacion" value="3"><span class="pad10_10">'+$(this).data('mujer')+'</span></label>';
                $(this).html(mihtml);
            });

            });


            $( "#Hombre" ).click(function() {

               $("#mitexto").html($("#seis").data("texto"));
               $(".orientacionsexu li").each(function(){
                  mihtml = '<label class="dBlock FS16 w100 landingChbx"><input type="radio" name="inclinacion" value="3"><span class="pad10_10">'+$(this).data('hombre')+'</span></label>';
                $(this).html(mihtml);
               });
            });

            $( "#Pareja" ).click(function() {
               $("#mitexto").html("Ella");
               $(".orientacionsexu li").each(function(){
                  mihtml = '<label class="dBlock FS16 w100 landingChbx"><input type="radio" name="inclinacion" value="3"><span class="pad10_10">'+$(this).data('pareja')+'</span></label>';
                $(this).html(mihtml);
            });
            });

            $( "#Transexual" ).click(function() {
               $("#mitexto").html($("#seis").data("texto"));
            });






         $(document).ready(function () {




/*
            $('#regiration_form').submit(function(e) {


             e.preventDefault();  

               var camposRellenados = true;

                $(".validaresto33").find("input").each(function() {
                
                var $this = $(this);
                    if( $this.val().length <= 0 ) {
                        camposRellenados = false;
                        return false;
                    }
                });

                if(camposRellenados == false) {
                
                   $(".validadoes").show();
                   $(".validadoes").animate({"color":"#e8a010","font-size":"15pt"}, 1000);
                   $(".estiloerror2").animate({"padding-top":"2%","padding-bottom":"2%","padding-left":"16%","padding-right":"16%"}, 1000);

                }
                else {

                    var entre ="";
                    $('.validaresto33:checked').each(
                        function() {
                            entre = "yes";
                        }
                    );
               
                    if(entre == "yes"){

                     console.dir("deberia enviar");

                        $('#regiration_form').submit();
               
                    }
                    else
                    {
               
                      $(".validadoes").show();
                      $(".validadoes").animate({"color":"#e8a010","font-size":"15pt"}, 1000);
                      $(".estiloerror2").animate({"padding-top":"2%","padding-bottom":"2%","padding-left":"16%","padding-right":"16%"}, 1000);
               
                    }               

                }


            });*/

           $('.menu ul li a.menu-category').click(function () {
             $('.menu ul li ul').toggle();
           });
           $('.toggle-menu').click(function () {
             $('.menu').toggle();
             return false;
           });
           $('.button-login').click(function () {
             $('.login-top').toggle();
             return false;
           });
           $('.menu-left-account').click(function () {
             $('.menu-account ul').toggle();
             return false;
           });
           $('.left_nav button').click(function () {
             $('.left_nav .user_navigation.collapsed').toggle();
           });
           $('.btn-switch').hover(function(){
             $(this).parent().find('.btn-switch').addClass('btn-remove-background');
             $(this).removeClass('btn-remove-background');
             $(this).addClass('btn-active');
           }, function(){
             $(this).parent().find('.btn-switch').removeClass('btn-remove-background');
             $(this).parent().find('.btn-switch').removeClass('btn-active');
           });
           $('.btn-switch input').change(function(){
             var value = $(this).val();
             if(value === 'studio') {
               $('.register__studio-field').show();
               $('.register__user-field').hide();
             }else{
               $('.register__studio-field').hide();
               $('.register__user-field').show();
             }
           });
           $(".withdraw-studio-payee").change(function(){
             var withdrawType = $(this).val();
             $('.payee-payment-box-type').addClass('hidden');
             $('.'+withdrawType+'-payee-payment').removeClass('hidden');
           });
             $('input.tag-input').tagsinput({});
         });
      </script>
      <script type="text/javascript">

/*! iFrame Resizer (iframeSizer.min.js ) - v2.8.3 - 2015-01-29
 *  Desc: Force cross domain iframes to size to content.
 *  Requires: iframeResizer.contentWindow.min.js to be loaded into the target frame.
 *  Copyright: (c) 2015 David J. Bradshaw - dave@bradshaw.net
 *  License: MIT
 */

!function(){"use strict";function a(a,b,c){"addEventListener"in window?a.addEventListener(b,c,!1):"attachEvent"in window&&a.attachEvent("on"+b,c)}function b(){var a,b=["moz","webkit","o","ms"];for(a=0;a<b.length&&!A;a+=1)A=window[b[a]+"RequestAnimationFrame"];A||e(" RequestAnimationFrame not supported")}function c(){var a="Host page";return window.top!==window.self&&(a=window.parentIFrame?window.parentIFrame.getId():"Nested host page"),a}function d(a){return w+"["+c()+"]"+a}function e(a){C.log&&"object"==typeof window.console&&console.log(d(a))}function f(a){"object"==typeof window.console&&console.warn(d(a))}function g(a){function b(){function a(){k(F),i(),C.resizedCallback(F)}g("Height"),g("Width"),l(a,F,"resetPage")}function c(a){var b=a.id;e(" Removing iFrame: "+b),a.parentNode.removeChild(a),C.closedCallback(b),e(" --")}function d(){var a=E.substr(x).split(":");return{iframe:document.getElementById(a[0]),id:a[0],height:a[1],width:a[2],type:a[3]}}function g(a){var b=Number(C["max"+a]),c=Number(C["min"+a]),d=a.toLowerCase(),f=Number(F[d]);if(c>b)throw new Error("Value for min"+a+" can not be greater than max"+a);e(" Checking "+d+" is in range "+c+"-"+b),c>f&&(f=c,e(" Set "+d+" to min value")),f>b&&(f=b,e(" Set "+d+" to max value")),F[d]=""+f}function m(){var b=a.origin,c=F.iframe.src.split("/").slice(0,3).join("/");if(C.checkOrigin&&(e(" Checking connection is from: "+c),""+b!="null"&&b!==c))throw new Error("Unexpected message received from: "+b+" for "+F.iframe.id+". Message was: "+a.data+". This error can be disabled by adding the checkOrigin: false option.");return!0}function n(){return w===(""+E).substr(0,x)}function o(){var a=F.type in{"true":1,"false":1};return a&&e(" Ignoring init message from meta parent page"),a}function p(a){return E.substr(E.indexOf(":")+v+a)}function q(a){e(" MessageCallback passed: {iframe: "+F.iframe.id+", message: "+a+"}"),C.messageCallback({iframe:F.iframe,message:JSON.parse(a)}),e(" --")}function r(){if(null===F.iframe)throw new Error("iFrame ("+F.id+") does not exist on "+y);return!0}function s(a){var b=a.getBoundingClientRect();return h(),{x:parseInt(b.left,10)+parseInt(z.x,10),y:parseInt(b.top,10)+parseInt(z.y,10)}}function u(a){function b(){z=g,A(),e(" --")}function c(){return{x:Number(F.width)+d.x,y:Number(F.height)+d.y}}var d=a?s(F.iframe):{x:0,y:0},g=c();e(" Reposition requested from iFrame (offset x:"+d.x+" y:"+d.y+")"),window.top!==window.self?window.parentIFrame?a?parentIFrame.scrollToOffset(g.x,g.y):parentIFrame.scrollTo(F.width,F.height):f(" Unable to scroll to requested position, window.parentIFrame not found"):b()}function A(){!1!==C.scrollCallback(z)&&i()}function B(a){function b(a){var b=s(a);e(" Moving to in page link (#"+c+") at x: "+b.x+" y: "+b.y),z={x:b.x,y:b.y},A(),e(" --")}var c=a.split("#")[1]||"",d=decodeURIComponent(c),f=document.getElementById(d)||document.getElementsByName(d)[0];window.top!==window.self?window.parentIFrame?parentIFrame.moveToAnchor(c):e(" In page link #"+c+" not found and window.parentIFrame not found"):f?b(f):e(" In page link #"+c+" not found")}function D(){switch(F.type){case"close":c(F.iframe),C.resizedCallback(F);break;case"message":q(p(6));break;case"scrollTo":u(!1);break;case"scrollToOffset":u(!0);break;case"inPageLink":B(p(9));break;case"reset":j(F);break;case"init":b(),C.initCallback(F.iframe);break;default:b()}}var E=a.data,F={};n()&&(e(" Received: "+E),F=d(),!o()&&r()&&m()&&(D(),t=!1))}function h(){null===z&&(z={x:void 0!==window.pageXOffset?window.pageXOffset:document.documentElement.scrollLeft,y:void 0!==window.pageYOffset?window.pageYOffset:document.documentElement.scrollTop},e(" Get page position: "+z.x+","+z.y))}function i(){null!==z&&(window.scrollTo(z.x,z.y),e(" Set page position: "+z.x+","+z.y),z=null)}function j(a){function b(){k(a),m("reset","reset",a.iframe)}e(" Size reset requested by "+("init"===a.type?"host page":"iFrame")),h(),l(b,a,"init")}function k(a){function b(b){a.iframe.style[b]=a[b]+"px",e(" IFrame ("+a.iframe.id+") "+b+" set to "+a[b]+"px")}C.sizeHeight&&b("height"),C.sizeWidth&&b("width")}function l(a,b,c){c!==b.type&&A?(e(" Requesting animation frame"),A(a)):a()}function m(a,b,c){e("["+a+"] Sending msg to iframe ("+b+")"),c.contentWindow.postMessage(w+b,"*")}function n(){function b(){function a(a){1/0!==C[a]&&0!==C[a]&&(i.style[a]=C[a]+"px",e(" Set "+a+" = "+C[a]+"px"))}a("maxHeight"),a("minHeight"),a("maxWidth"),a("minWidth")}function c(a){return""===a&&(i.id=a="iFrameResizer"+s++,e(" Added missing iframe ID: "+a+" ("+i.src+")")),a}function d(){e(" IFrame scrolling "+(C.scrolling?"enabled":"disabled")+" for "+k),i.style.overflow=!1===C.scrolling?"hidden":"auto",i.scrolling=!1===C.scrolling?"no":"yes"}function f(){("number"==typeof C.bodyMargin||"0"===C.bodyMargin)&&(C.bodyMarginV1=C.bodyMargin,C.bodyMargin=""+C.bodyMargin+"px")}function g(){return k+":"+C.bodyMarginV1+":"+C.sizeWidth+":"+C.log+":"+C.interval+":"+C.enablePublicMethods+":"+C.autoResize+":"+C.bodyMargin+":"+C.heightCalculationMethod+":"+C.bodyBackground+":"+C.bodyPadding+":"+C.tolerance}function h(b){a(i,"load",function(){var a=t;m("iFrame.onload",b,i),!a&&C.heightCalculationMethod in B&&j({iframe:i,height:0,width:0,type:"init"})}),m("init",b,i)}var i=this,k=c(i.id);d(),b(),f(),h(g())}function o(a){if("object"!=typeof a)throw new TypeError("Options is not an object.")}function p(a){a=a||{},o(a);for(var b in D)D.hasOwnProperty(b)&&(C[b]=a.hasOwnProperty(b)?a[b]:D[b])}function q(){function a(a){if(!a.tagName)throw new TypeError("Object is not a valid DOM element");if("IFRAME"!==a.tagName.toUpperCase())throw new TypeError("Expected <IFRAME> tag, found <"+a.tagName+">.");n.call(a)}return function(b,c){switch(p(b),typeof c){case"undefined":case"string":Array.prototype.forEach.call(document.querySelectorAll(c||"iframe"),a);break;case"object":a(c);break;default:throw new TypeError("Unexpected data type ("+typeof c+").")}}}function r(a){a.fn.iFrameResize=function(a){return p(a),this.filter("iframe").each(n).end()}}var s=0,t=!0,u="message",v=u.length,w="[iFrameSizer]",x=w.length,y="",z=null,A=window.requestAnimationFrame,B={max:1,scroll:1,bodyScroll:1,documentElementScroll:1},C={},D={autoResize:!0,bodyBackground:null,bodyMargin:null,bodyMarginV1:8,bodyPadding:null,checkOrigin:!0,enablePublicMethods:!1,heightCalculationMethod:"offset",interval:32,log:!1,maxHeight:1/0,maxWidth:1/0,minHeight:0,minWidth:0,scrolling:!1,sizeHeight:!0,sizeWidth:!1,tolerance:0,closedCallback:function(){},initCallback:function(){},messageCallback:function(){},resizedCallback:function(){},scrollCallback:function(){return!0}};b(),a(window,"message",g),window.jQuery&&r(jQuery),"function"==typeof define&&define.amd?define([],q):"object"==typeof exports?module.exports=q():window.iFrameResize=q()}();
//# sourceMappingURL=iframeResizer.map


$( document ).ready(function() {
 $("#iframelives").iFrameResize({"scrolling":false},"iframe");

});


         $(document).ready(function(){
          /* var current = 1,current_step,next_step,steps;
           steps = $("fieldset").length;
           */



$(document).on('change', '#dia,#mes,#ano', function(event) {
     
   dia = $("#dia option:selected").val();
   mes = $("#mes option:selected").val();
   ano = $("#ano option:selected").val();

   if((dia != "0" & mes != "0") & ano != "0"){
      $("#birthdate").val(ano+'-'+mes+'-'+dia);
   }


});


$(document).on('change', '#diael,#mesel,#anoel', function(event) {
     
   dia = $("#diael option:selected").val();
   mes = $("#mesel option:selected").val();
   ano = $("#anoel option:selected").val();

   if((dia != "0" & mes != "0") & ano != "0"){
      $("#birthdate2").val(ano+'-'+mes+'-'+dia);
   }


});



//$("#birthdate").val();

           $(".next").click(function(){
             current_step = $(this).data("valor");
             if(current_step == "uno")
             {             
         
                  if($('input:radio[name=sexo]:checked').val())
                  {
                    $(".validadoes").hide();
                    $("#uno").toggle();
                    console.dir($('input:radio[name=sexo]:checked').val());
                    if($('input:radio[name=sexo]:checked').val() == "3")
                    {
                     $("#tres").toggle();
                     $("#tres").data("previo","uno");
                    }
                    else
                    {
                     $("#tres").data("previo","vacio");
                     $("#dos").toggle();

                    }
                    
                    
                 //   $(".esconder2").hide(); 
                    $(".validadoes").animate({"color":"#e8a010","font-size":"10pt"}, 1000);
                    $(".estiloerror2").animate({"padding":"0%"}, 1000);
                  }
                  else
                  {
                    $(".validadoes").show();
                    $(".validadoes").animate({"color":"#e8a010","font-size":"15pt"}, 1000);
                    $(".estiloerror2").animate({"padding":"2%"}, 1000);
                    
                  }
         
             }
             if(current_step == "dos")
             {

         
         
                  if($('input:radio[name=inclinacion]:checked').val())
                  {
                    $(".validadoes").hide();
                    $("#dos").toggle();
                    $("#tres").toggle();
                   // $(".esconder2").hide();  
                    $(".validadoes").animate({"color":"#e8a010","font-size":"10pt"}, 1000);
                    $(".estiloerror2").animate({"padding":"0%"}, 1000);                
                  }
                  else
                  {

                    $(".validadoes").show();
                    $(".validadoes").animate({"color":"#e8a010","font-size":"15pt"}, 1000);
                    $(".estiloerror2").animate({"padding-top":"2%","padding-bottom":"2%","padding-left":"16%","padding-right":"16%"}, 1000);
                    
                  }
         
         
             }
             if(current_step == "tres")
             {
              var entre ="";
              $('.tusexualidad:checked').each(
                  function() {
                      entre = "yes";
                  }
              );
         
              if(entre == "yes"){
                $(".validadoes").hide();
                $("#tres").toggle();
                $("#cuatro").toggle();
                $(".validadoes").animate({"color":"#e8a010","font-size":"10pt"}, 1000);
                $(".estiloerror2").animate({"padding":"0%"}, 1000);
         
              }
              else
              {
         
                $(".validadoes").show();
                $(".validadoes").animate({"color":"#e8a010","font-size":"15pt"}, 1000);
                $(".estiloerror2").animate({"padding-top":"2%","padding-bottom":"2%","padding-left":"16%","padding-right":"16%"}, 1000);
         
              }
         
         
             }
             if(current_step == "cuatro")
             {
         
         
                  var entre ="";
                  $('.tusgustos:checked').each(
                      function() {
                          entre = "yes";
                      }
                  );
         
                  if(entre == "yes"){
                    $(".validadoes").hide();
                    $("#cuatro").toggle();
                    $("#cinco").toggle();
                    $(".validadoes").animate({"color":"#e8a010","font-size":"10pt"}, 1000);
                    $(".estiloerror2").animate({"padding":"0%"}, 1000);
         
                  }
                  else
                  {
                    
                    $(".validadoes").show();
                    $(".validadoes").animate({"color":"#e8a010","font-size":"15pt"}, 1000);
                    $(".estiloerror2").animate({"padding-top":"2%","padding-bottom":"2%","padding-left":"16%","padding-right":"16%"}, 1000);
         
                  }
         
         
             }
             if(current_step == "cinco")
             {
         
         
         
                  if($('input:radio[name=experiencias]:checked').val())
                  {
                    $(".validadoes").hide();
                    $(".validadoes").animate({"color":"#e8a010","font-size":"10pt"}, 1000);
                    $(".estiloerror2").animate({"padding":"0%"}, 1000);
                    $("#cinco").toggle();
                    $("#seis").toggle();
                  
                  }
                  else
                  {
                    $(".validadoes").show();
                    $(".validadoes").animate({"color":"#e8a010","font-size":"15pt"}, 1000);
                    $(".estiloerror2").animate({"padding-top":"2%","padding-bottom":"2%","padding-left":"16%","padding-right":"16%"}, 1000);
                    
                  }
         
         
         
             }
             if(current_step == "seis")
             {
         
         
         
                var incompletos = false;
                $('.validaresto').find("option:selected").each(function() {
                  if ($(this).val().trim() == '') {
                    incompletos = true;
                  }
                });
         
         
                if(incompletos){
                    $(".validadoes").show();
                    $(".validadoes").animate({"color":"#e8a010","font-size":"15pt"}, 1000);
                    $(".estiloerror2").animate({"padding-top":"2%","padding-bottom":"2%","padding-left":"16%","padding-right":"16%"}, 1000);
                }
                else
                {

                  if($("#mitexto").html() == "Tu" || $("#mitexto").html() == "You")
                  {
                     $("#seis").toggle();  
                     $("#ocho").toggle();
                     $("#ocho").data("previo","seis");  

                  }
                  else
                  {
                      $("#seis").toggle();
                      $("#siete").toggle();
                      $("#ocho").data("previo","ninguno");

                  }
                   

                   $(".validadoes").hide();
                   $(".validadoes").animate({"color":"#e8a010","font-size":"10pt"}, 1000);
                   $(".estiloerror2").animate({"padding":"0%"}, 1000);
                
                }
         
         
             }
             if(current_step == "siete")
             {
         
         
                var incompletos = false;
                $('.validaresto2').find("option:selected").each(function() {
                  if ($(this).val().trim() == '') {
                    incompletos = true;
                  }
                });
         
         
                if(incompletos){
                    $(".validadoes").show();
                    $(".validadoes").animate({"color":"#e8a010","font-size":"15pt"}, 1000);
                    $(".estiloerror2").animate({"padding-top":"2%","padding-bottom":"2%","padding-left":"16%","padding-right":"16%"}, 1000);
                }
                else
                {
                         
                    $("#siete").toggle();
                    $("#ocho").toggle();
                    $(".validadoes").hide();
                    $(".validadoes").animate({"color":"#e8a010","font-size":"10pt"}, 1000);
                    $(".estiloerror2").animate({"padding":"0%"}, 1000);
                
                }
         
         
             }
         
           });
           $(".previous").click(function(){

            $(".validadoes").hide();
            $(".validadoes").animate({"color":"#e8a010","font-size":"10pt"}, 1000);
            $(".estiloerror2").animate({"padding":"0%"}, 1000);
         
             current_step = $(this).data("valor");
             if(current_step == "uno")
             {
             // $(".esconder2").hide();                  
              $("#uno").toggle();
              $("#dos").toggle();
             }
             if(current_step == "dos")
             {
             // $(".esconder2").show();                  
              $("#uno").toggle();
              $("#dos").toggle();
             }
             if(current_step == "tres")
             {

               if($("#tres").data("previo") == "uno")
               {
              //$(".esconder2").show(); 
              $("#uno").toggle();
              $("#tres").toggle();


               }
               else
               {

              $("#dos").toggle();
              $("#tres").toggle();

               }

             }
             if(current_step == "cuatro")
             {
              $("#tres").toggle();
              $("#cuatro").toggle();
             }
             if(current_step == "cinco")
             {
              $("#cuatro").toggle();
              $("#cinco").toggle();
             }
             if(current_step == "seis")
             {
                 $("#cinco").toggle();
                 $("#seis").toggle();
             }
             if(current_step == "siete")
             {
              $("#seis").toggle();
              $("#siete").toggle();
             }
             if(current_step == "ocho")
             {

               if($("#ocho").data("previo") == "seis")
               {
                  $("#seis").toggle();
                  $("#ocho").toggle();
               }
               else
               {

                 $("#siete").toggle();
                 $("#ocho").toggle();

               }
             }
         
            /* current_step = $(this).parent().parent().parent();
             next_step = $(this).parent().parent().parent().prev();
             next_step.show();
             current_step.hide();*/
           });
         });
      </script>
      {!! app('settings')->code_before_body_tag !!}
   </body>
   @include('alerts.index')
</html>