<?php
   $misexo = '["Hombre","Mujer","Transexual","Pareja"]';
   $misexoid = json_decode('["male","female","transgender","pareja"]');
  
   $misexotraduc = trans('messages.traduc22');
   $misexotraduc = json_decode($misexotraduc);

   foreach ($misexoid as $key => $value) {
     
     if( $value == $user->gender )
     {
        unset($misexoid[$key]);
     }

   }


$clav   = json_decode('["male","female","transgender","pareja"]');
$espa   = json_decode('["Hombre","Mujer","Transexual","Pareja"]');
$franc  = json_decode('["Homme","Femme","Transsexuel","Partenaire"]');
$ingle  = json_decode('["Man","Woman","Transsexual","Partner"]');

$sex = array();
foreach ($clav as $key => $value) {

  $sex[$value]['ES'] = $espa[$key];
  $sex[$value]['EN'] = $ingle[$key];
  $sex[$value]['FR'] = $franc[$key];

}

$idioma = trans('messages.traduc24');

$fisionomia = trans('messages.traduc20');



/*etnia*/


$mietnia = json_decode('["Caucasico(a)","Afro","Arabe","Asiatico(a)","Latino(a)","Otro","No importa","Caribeño(a)"]');


$etniaid = json_decode('["Caucasico(a)","Afro","Arabe","Asiatico(a)","Latino(a)","Otro","No importa","Caribeño(a)"]');

$etniaid2 = json_decode('["Caucasico(a)","Afro","Arabe","Asiatico(a)","Latino(a)","Otro","No importa","Caribeño(a)"]');
  
   $etniatraduc = trans('messages.traduc21');
   $etniatraduc = json_decode($etniatraduc);
   foreach ($etniaid as $key => $value) {
     
     if( md5($value) == md5($user->eletnia) )
     {
      
        unset($etniaid[$key]);
     }

   }  

   foreach ($etniaid2 as $key => $value) {
     
     if( md5($value) == md5($user->ellaetnia) )
     {
        unset($etniaid2[$key]);
     }

   }

$clav2   = json_decode('["Caucasico(a)","Afro","Arabe","Asiatico(a)","Latino(a)","Otro","No importa","Caribeño(a)"]');
$espa2   = json_decode('["Caucasico(a)","Afro","Arabe","Asiatico(a)","Latino(a)","Otro","No importa","Caribeño(a)"]');
$franc2  = json_decode('["caucasien","Afro","Arabe","asiatique","Latino(a)","Autre","Ça ne fait rien","Caraïbes"]');
$ingle2  = json_decode('["Caucasian","Afro","Arab","Asian","Latin","Other","Never mind","Caribbean"]');

$etni = array();
foreach ($clav2 as $key => $value) {

  $etni[$value]['ES'] = $espa2[$key];
  $etni[$value]['EN'] = $ingle2[$key];
  $etni[$value]['FR'] = $franc2[$key];

}




$etni2 = array();
foreach ($clav2 as $key => $value) {

  $etni2[$value]['ES'] = $espa2[$key];
  $etni2[$value]['EN'] = $ingle2[$key];
  $etni2[$value]['FR'] = $franc2[$key];

}



/*Fisionomia*/



$mifionomia = json_decode('["Delgada","Atletica","Normal","Kilos extras","Relleno(a)"]');


$fisionomiaid = json_decode('["Delgada","Atletica","Normal","Kilos extras","Relleno(a)"]');

$fisionomiaid2 = json_decode('["Delgada","Atletica","Normal","Kilos extras","Relleno(a)"]');


  
   $fisionomiatraduc = trans('messages.traduc20');
   $fisionomiatraduc = json_decode($fisionomiatraduc);
   foreach ($fisionomiaid as $key => $value) {
     
     if( md5($value) == md5($user->elfisionomia) )
     {
      
        unset($fisionomiaid[$key]);
     }

   }  


   foreach ($fisionomiaid2 as $key => $value) {
     
     if( md5($value) == md5($user->ellafionomia) )
     {
        unset($fisionomiaid2[$key]);
     }

   }

$clav3   = json_decode('["Delgada","Atletica","Normal","Kilos extras","Relleno(a)"]');
$espa3   = json_decode('["Delgada","Atletica","Normal","Kilos extras","Relleno(a)"]');
$franc3  = json_decode('["Mince","Athlétique","Ordinaire","Kilos supplémentaires","Remplir (a)"]');
$ingle3  = json_decode('["Thin","Athletic","Normal","Extra kilos","Fill (a)"]');

$fisionomias = array();
foreach ($clav3 as $key => $value) {

  $fisionomias[$value]['ES'] = $espa3[$key];
  $fisionomias[$value]['EN'] = $ingle3[$key];
  $fisionomias[$value]['FR'] = $franc3[$key];

}




$fisionomias2 = array();
foreach ($clav3 as $key => $value) {

  $fisionomias2[$value]['ES'] = $espa3[$key];
  $fisionomias2[$value]['EN'] = $ingle3[$key];
  $fisionomias2[$value]['FR'] = $franc3[$key];

}


if(!empty($user->elfisionomia))
{
  $val = $fisionomias[$user->elfisionomia][$idioma];
}
else
{
  $val = "";
}
$val2="";

if(!empty($user->ellafionomia))
{
  $val2 = $fisionomias[$user->ellafionomia][$idioma];
}
else
{
  $val2 = "";
}

/*
print_r($user->ellacm);
die;*/

$fechaInicial = $user->birthdate;
$subirthdate = $user->subirthdate;

$fechaActual = date('Y-m-d'); // la fecha del ordenador
 
// Obtenemos la diferencia en milisegundos
$diff = abs(strtotime($fechaActual) - strtotime($fechaInicial));
$diff2 = abs(strtotime($fechaActual) - strtotime($subirthdate));
 
$yearsel  = floor($diff / (365*60*60*24));

$yearsel2 = floor($diff2 / (365*60*60*24));



if(!empty($performer->age))
{
  $edad = $performer->age;
}
else
{
$edad = $yearsel;
}

if(!empty($performer->agellla))
{
  $edad2 = $performer->agellla;
}
else
{
 $edad2 = $yearsel2;
}
/*
print_r($performer);
die;
*/


$cm = array();
for ($i=150; $i <= 220; $i++) { 
  $cm[$i] = $i;
}

$edaa = array();
for ($i=18; $i <= 100; $i++) { 
  $edaa[$i] = $i;
}


$elige =  trans('messages.pleaseSelectAnOption');

if( $idioma == "EN")
{

$eyess = array('blue'=>'Blue', 'brown'=>'Brown', 'green'=>'Green', 'unknown'=>'Unknown');
$cabello = array('brown'=>'Brown', 'blonde'=>'Blonde', 'black'=>'Black','red'=>'Red', 'unknown'=>'Unknown');
$pubico = array('trimmed'=>'Trimmed', 'shaved'=>'Shaved', 'hairy'=>'Hairy', 'no_comment'=>'No Comment');


$busto = array('large'=>'Large', 'medium'=>'Medium', 'small'=>'Small', 'no_comment'=>'No Comment');


$categoria = array('Uncategorised' => 'Uncategorised', 'Housewives' => 'Housewives', 'Huge Tits' => 'Huge Tits' , 'Latina' => 'Latina' , 'Leather' => 'Leather' , 'Lesbian' => 'Lesbian' , 'Mature' => 'Mature' , 'Medium Tits' => 'Medium Tits' , 'Petite Body' => 'Petite Body' , 'Pornstar' => 'Pornstar' , 'Redhead' => 'Redhead', 'Shaved Pussy' => 'Shaved Pussy' , 'Small Tits' => 'Small Tits' , 'Teen 18+' => 'Teen 18+' , 'Toys' => 'Toys' , 'Trimmed Pussy' => 'Trimmed Pussy' , 'Hairy Pussy' => 'Hairy Pussy' , 'Group Sex' => 'Group Sex' , 'Categories' => 'Categories' , 'Live Sex' => 'Live Sex' , 'Anal Sex' => 'anal sex', 'Asian' => 'Asian', 'Babes' => 'Babes' , 'BBW' => 'BBW' , 'Big Tits' => 'Big Tits', 'Blonde' => 'Blonde' , 'Bondage' => 'Bondage', 'Brunette' => 'Brunette' , 'College Girls' => 'College Girls', 'Couples' => 'Couples', 'Curvy' => 'Curvy' , 'Ebony' => 'Ebony' , 'Granny' => 'Granny' , 'White Girls' => 'White Girls' );


}

if( $idioma == "ES")
{



$categoria = array('Uncategorised' => 'Sin categorizar', 'Housewives' => 'Amas de casa', 'Huge Tits' => 'Enormes tetas' , 'Latina' => 'Latina' , 'Leather' => 'Cuero' , 'Lesbian' => 'Lesbianas' , 'Mature' => 'Madura' , 'Medium Tits' => 'Tetas Medianas' , 'Petite Body' => 'Cuerpo pequeño' , 'Pornstar' => 'Pornstar' , 'Redhead' => 'Pelirroja', 'Shaved Pussy' => 'Coño afeitado' , 'Small Tits' => 'Tetas pequeñas' , 'Teen 18+' => 'Adolescente 18+' , 'Toys' => 'Juguetes' , 'Trimmed Pussy' => 'Coño recortado' , 'Hairy Pussy' => 'Coño peludo' , 'Group Sex' => 'Sexo en grupo' , 'Categories' => 'Categories' , 'Live Sex' => 'Categorías' , 'Anal Sex' => 'Sexo anal', 'Asian' => 'Asiática', 'Babes' => 'Chicas' , 'BBW' => 'BBW' , 'Big Tits' => 'Tetas grandes', 'Blonde' => 'Rubia' , 'Bondage' => 'Esclavitud', 'Brunette' => 'Morena' , 'College Girls' => 'Chicas universitarias', 'Couples' => 'Parejas', 'Curvy' => 'Curvy' , 'Ebony' => 'Ebony' , 'Granny' => 'Abuelita' , 'White Girls' => 'Niñas blancas' );


$cabello = array('brown'=>'marrón', 'blonde'=>'Rubia', 'black'=>'Negro','red'=>'Rojo', 'unknown'=>'Desconocida');
$eyess = array('blue'=>'Azul', 'brown'=>'marrón', 'green'=>'Verde', 'unknown'=>'Desconocida');

$pubico = array('trimmed'=>'Recortada', 'shaved'=>'Afeitado', 'hairy'=>'Peluda', 'no_comment'=>'Sin comentarios');

$busto = array('large'=>'Grande', 'medium'=>'Medio', 'small'=>'Pequeña', 'no_comment'=>'Sin comentarios');

}

if( $idioma == "FR")
{



$categoria = array('Uncategorised' => 'Non catégorisé', 'Housewives' => 'femmes au foyer', 'Huge Tits' => 'Énormes seins' , 'Latina' => 'Latina' , 'Leather' => 'Cuir' , 'Lesbian' => 'Lesbiennes' , 'Mature' => 'Mature' , 'Medium Tits' => 'Seins moyens' , 'Petite Body' => 'Petit corps' , 'Pornstar' => 'Star du porno' , 'Redhead' => 'Rousse', 'Shaved Pussy' => 'Chatte rasée' , 'Small Tits' => 'Petits seins' , 'Teen 18+' => 'Ados 18+' , 'Toys' => 'Jouets' , 'Trimmed Pussy' => 'Chatte taillée' , 'Hairy Pussy' => 'Chatte poilue' , 'Group Sex' => 'Sexe en groupe' , 'Categories' => 'Categories' , 'Live Sex' => 'Sexe en direct' , 'Anal Sex' => 'Sexe anal', 'Asian' => 'asiatique', 'Babes' => 'Babes' , 'BBW' => 'BBW' , 'Big Tits' => 'Gros seins', 'Blonde' => 'Blond' , 'Bondage' => 'Esclavage', 'Brunette' => 'Brunette' , 'College Girls' => 'Collège filles', 'Couples' => 'Des couples', 'Curvy' => 'Courbée' , 'Ebony' => 'Ébène' , 'Granny' => 'Mamie' , 'White Girls' => 'Filles blanches' );


$cabello = array('brown'=>'Marron', 'blonde'=>'Rubia', 'black'=>'nègre','red'=>'Rojo', 'unknown'=>'Desconocida');
$eyess = array('blue'=>'Bleue', 'brown'=>'marron', 'green'=>'Verte', 'unknown'=>'Inconnue');

$pubico = array('trimmed'=>'Paré', 'shaved'=>'Rasé', 'hairy'=>'Poilue', 'no_comment'=>'Sans commentaire');

$busto = array('large'=>'Grande', 'medium'=>'Moyenne', 'small'=>'Petite', 'no_comment'=>'Sans commentaire');


}


?>

@extends('Model::model_dashboard')
@section('content_sub_model')


<div class="panel panel-default">
  <div class="panel-heading"> <h4>@lang('messages.yourProfileDetails')</h4></div>

<div class="right_cont panel-body"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">

      <div class="dashboard-long-item">

        <div class="dashboard_tabs_wrapper">
          <div class="dashboard_tabs">
                      <a class="btn btn-default" href="{{URL('models/dashboard/profile/view-images')}}">@lang('messages.profileImages')</a>
            <a class="btn btn-default" href="{{URL('models/dashboard/profile')}}">@lang('messages.myProfile')</a>
            <a class="btn btn-info active" href="{{URL('models/dashboard/profile/edit')}}">@lang('messages.editMyProfile')</a>
          </div>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="studio-cont panel-body"> <!--user's info-->
    <div class="cont_det">
      <div class="mod_shedule"> <!--user's info-->
          {{Form::open(array('method'=>'post', 'class'=>'form-horizontal'))}}
          <legend>@lang('messages.Yourpersonalinfo')</legend>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="firstName">@lang('messages.firstname')  </label>
            <div class="col-sm-9">
                {{Form::text('firstName', old('firstName', $user->firstName), array('class'=>'form-control input-md', 'placeholder'=>'First Name'))}}
                <span class="label label-danger">{{$errors->first('firstName')}}</span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="lastName">@lang('messages.lastname') </label>
            <div class="col-sm-9">
                {{Form::text('lastName', old('lastName', $user->lastName), array('class'=>'form-control input-md', 'placeholder'=>'Last Name'))}}
              <span class="label label-danger">{{$errors->first('lastName')}}</span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="gender">@lang('messages.gender') </label>
            <div class="col-sm-9">


              <select class="form-control input-md" name="gender" id="gender">
                <option value="{{ $user->gender }}">{{ $sex[$user->gender][$idioma] }}</option>

                  @foreach($misexoid as $idsexo => $sexoes)

                  <option value="{{$misexoid[$idsexo]}}">{{$misexotraduc[$idsexo]}}</option>
           
                  @endforeach 

                </select>

                <span class="label label-danger">{{$errors->first('gender')}}</span>




            </div>
          </div>
















          <div class="form-group text-center desactivosok">

            <label class="col-sm-6 control-label" for="ethnicity" style="text-align: center;">@lang('messages.traduc7') (@lang('messages.he'))</label>          
            <label class="col-sm-6 control-label text-center" for="ethnicity" style="text-align: center;" >@lang('messages.traduc26')</label>

          </div>




            <div class="form-group">
              <label class="col-sm-3 control-label" for="age"> @lang('messages.age') </label>
              <div class="col-sm-3 activarmodalidad">

              {{Form::select('age', $edaa, old('age', $edad), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
                <span class="label label-danger">{{$errors->first('age')}}</span>
              </div>
              <label class="col-sm-3 control-label desactivosok" for="age">@lang('messages.age') </label>
              <div class="col-sm-3 desactivosok">

               {{Form::select('agellla', $edaa, old('age', $edad2), array('class'=>'form-control input-md', 'placeholder' => $elige))}}

              </div>
            </div>


            <div class="form-group">
            <label class="col-sm-3 control-label" for="ethnicity">@lang('messages.ethnicity')</label>

            <div class="col-sm-3 activarmodalidad">


              <select class="w100 validaresto2 form-control" name="ethnicityellla" style="width: 96%;">



                <?php
                  $est = $user['ellaetnia'];
                  ?>  
                @if($est != "")

                <option value="{{ $etni2[$user->ellaetnia]['ES'] }}">
              

                {{ $etni2[$user->ellaetnia][$idioma] }}</option>

                @else

                  <option value="">@lang('messages.pleaseSelectAnOption') </option>

                @endif



                  @foreach($etniaid2 as $idetnia3 => $etniaes3)

                  <option value="{{$etniaid2[$idetnia3]}}">{{$etniatraduc[$idetnia3]}}</option>
           
                  @endforeach 
              </select>


             
              <span class="label label-danger">{{$errors->first('ethnicity')}}</span>

              

            </div> 

            <label class="col-sm-3 control-label desactivosok" for="ethnicity">@lang('messages.ethnicity')
  
            </label>

            <div class="col-sm-3 desactivosok">


              <select class="w100 validaresto2 form-control" name="ethnicity" style="width: 96%;">
                @if($user->eletnia != "")

                <option value="{{ $etni[$user->eletnia]['ES'] }}">
                  {{ $etni[$user->eletnia][$idioma] }}</option>
                
                @else

                <option value="">@lang('messages.pleaseSelectAnOption') </option>

                @endif

                  @foreach($etniaid as $idetnia2 => $etniaes2)

                  <option value="{{$etniaid[$idetnia2]}}">{{$etniatraduc[$idetnia2]}}</option>
           
                  @endforeach 

              </select>



            </div>

          </div>



          <div class="form-group">
            <label class="col-sm-3 control-label" for="height">@lang('messages.height')  </label>
            <div class="col-sm-3 activarmodalidad">
            {{Form::select('heightellla', $cm, old('heightellla', $user->ellacm), array('class'=>'form-control input-md', 'placeholder' => $elige))}}

              <span class="label label-danger">{{$errors->first('heightellla')}}</span>
            </div>            

            <label class="col-sm-3 control-label desactivosok" for="height">@lang('messages.height')  </label>
            <div class="col-sm-3 desactivosok">
               {{Form::select('height', $cm, old('height', $user->elcm), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              
              <span class="label label-danger">{{$errors->first('height')}}</span>
            </div>
          </div>



          <div class="form-group">
            <label class="col-sm-3 control-label" for="height">@lang('messages.traduc13')  </label>
            <div class="col-sm-3 activarmodalidad">


              <select class="w100 validaresto form-control" name="fionomiaellla" style="width: 96%;">

                @if ($val2 != "")

                  <option value="{{ $user->ellafionomia }}">{{ $val2 }}</option>
                @else

                  <option value="">@lang('messages.pleaseSelectAnOption') </option>

                @endif

                  @foreach($fisionomiaid2 as $idfisionomia => $fisionom)
                    
                  <option value="{{$fisionomiaid2[$idfisionomia]}}">{{$fisionomiatraduc[$idfisionomia]}}</option>
           
                @endforeach 

              </select>



              <span class="label label-danger">{{$errors->first('fionomia')}}</span>

            </div>            

            <label class="col-sm-3 control-label desactivosok" for="height">@lang('messages.traduc13')  </label>
            <div class="col-sm-3 desactivosok">



              <select class="w100 validaresto form-control" name="fionomia" style="width: 96%;">

                @if ($val != "")

                <option value="{{ $user->elfisionomia }}">{{ $val }}</option>

                @else

                  <option value="">@lang('messages.pleaseSelectAnOption') </option>                

                @endif


                  @foreach($fisionomiaid as $idfisionomia => $fisionom)
                    
                  <option value="{{$fisionomiaid[$idfisionomia]}}">{{$fisionomiatraduc[$idfisionomia]}}</option>
           
                  @endforeach 
              </select>


            </div>
          </div>












          <div class="form-group">
            <label class="col-sm-3 control-label" for="eyes">  @lang('messages.eyes')  </label>
            <div class="col-sm-3 activarmodalidad">
                {{Form::select('eyes', $eyess, old('eyes', $performer->eyes), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('eyes')}}</span>
            </div>

              <label class="col-sm-3 control-label desactivosok" for="eyes">  @lang('messages.eyes')  </label>
            <div class="col-sm-3 desactivosok">
                {{Form::select('eyes_ella', $eyess, old('eyes', $performer->eyes_ella), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('eyes')}}</span>
            </div>


          </div>


          <div class="form-group">
            <label class="col-sm-3 control-label" for="eyes">  @lang('messages.hair')  </label>
            <div class="col-sm-3 activarmodalidad">
                 {{Form::select('hair', $cabello, old('hair', $performer->hair), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('hair')}}</span>
            </div>

              <label class="col-sm-3 control-label desactivosok" for="eyes">  @lang('messages.hair')  </label>
            <div class="col-sm-3 desactivosok">
                {{Form::select('hair_ella', $cabello, old('hair', $performer->hair_ella), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('hair_ella')}}</span>
            </div>


          </div>




<div class="form-group">
            <label class="col-sm-3 control-label" for="weight">  @lang('messages.weight')  </label>
            <div class="col-sm-3 activarmodalidad">
                 {{Form::select('weight', $weightList, old('weight', $performer->weight), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('weight')}}</span>
            </div>

              <label class="col-sm-3 control-label desactivosok" for="weight">  @lang('messages.weight')  </label>
            <div class="col-sm-3 desactivosok">
                 {{Form::select('weight_ella', $weightList, old('weight_ella', $performer->weight_ella), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('weight_ella')}}</span>
            </div>


          </div>



<div class="form-group">
            <label class="col-sm-3 control-label" for="pubic_hair">  @lang('messages.pubicHair')  </label>
            <div class="col-sm-3 activarmodalidad">
                 {{Form::select('pubic', $pubico, old('pubic', $performer->pubic), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('pubic')}}</span>
            </div>

              <label class="col-sm-3 control-label desactivosok" for="pubic_hair">  @lang('messages.pubicHair')  </label>
            <div class="col-sm-3 desactivosok">
                 {{Form::select('pubit_ella', $pubico, old('pubit_ella', $performer->pubit_ella), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('pubit_ella')}}</span>
            </div>


          </div>



<div class="form-group">
            <label class="col-sm-3 control-label" for="bust">  

                <span class="wrap-bust">
                  
                      @lang('messages.bust') 
                </span>
                
             
            </label>
            <div class="col-sm-3 activarmodalidad">
                <span class="wrap-bust">
                 
                    {{Form::select('bust', $busto , old('bust', $performer->bust), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
                 <span class="label label-danger">{{$errors->first('bust')}}</span>
               
                </span>       
            
            </div>

              <label class="col-sm-3 control-label desactivosok" for="pubic_hair">  @lang('messages.bust')  </label>
            <div class="col-sm-3 desactivosok">
                   {{Form::select('bust', $busto , old('bust', $performer->bust), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('bust')}}</span>
            </div>


          </div>


          <div class="form-group required">
          <label class="col-sm-3 control-label" for="sexualPreference">@lang('messages.likes')  </label>

          <div class="col-sm-9">
              <div class="row">
                @foreach($allgustos2 as $aKey => $aSport)
                <div class="col-sm-4">
                  <div style="width: 50%;float: left;">
                  {{ $aSport['lang'][trans('messages.traduc24')] }}
                  </div>
                  <div style="width: 50%;float: right;">
                  <input type="checkbox" name={{ $aSport['lang']['id'] }} {{ $aSport['lang']['marcar'] }} value={{ $aSport['lang']['valor'] }} > 
                  </div>
                </div>
                @endforeach
                </div>
            </div>
          </div>          

          <div class="form-group required">
          <label class="col-sm-3 control-label" for="sexualPreference">@lang('messages.sexualPreference')  </label>

          <div class="col-sm-9">
              <div class="row">
                @foreach($allpreferencia2 as $aKey => $aSport2)
                <div class="col-sm-4">
                  <div style="width: 50%;float: left;">
                  {{ $aSport2['lang'][trans('messages.traduc24')] }}
                  </div>
                  <div style="width: 50%;float: right;">
                  <input type="checkbox" name={{ $aSport2['lang']['id'] }} {{ $aSport2['lang']['marcar'] }}  value={{ $aSport2['lang']['valor'] }}> 
                  </div>
                </div>
                @endforeach
                </div>
            </div>
          </div>

         <!-- <div class="form-group">
            <label class="col-sm-3 control-label" for="eyes">  @lang('messages.eyes')  </label>
            <div class="col-sm-9">
                {{Form::select('eyes', $eyess, old('eyes', $performer->eyes), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('eyes')}}</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="hair">@lang('messages.hair')</label>
            <div class="col-sm-9">
             {{Form::select('hair', $cabello, old('hair', $performer->hair), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('hair')}}</span>
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-3 control-label" for="weight">@lang('messages.weight') </label>
            <div class="col-sm-9">
                {{Form::select('weight', $weightList, old('weight', $performer->weight), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
              <span class="label label-danger">{{$errors->first('weight')}}</span>
            </div>
          </div> -->

          <div class="form-group required">
            <label class="col-sm-3 control-label" for="weight">@lang('messages.experiencia') </label>
            <div class="col-sm-9">
                {{Form::select('experiencias', array('Novato(a)'=>'Novato(a)', 'Ocasional'=>'Ocasional', 'Experimentado(a)'=>'Experimentado(a)', 'Descubriendo'=>'Descubriendo'), old('experiencias', $user->experiencias), array('class'=>'form-control', 'placeholder' => 'por favor seleccione'))}}
              <span class="label label-danger">{{$errors->first('experiencias')}}</span>
            </div>
          </div> 


          <div class="form-group required">
            <label class="col-sm-3 control-label" for="category">@lang('messages.category') </label>
            <div class="col-sm-9">
                <select multiple="multiple" name="category[]" class="form-control input-md js-example-basic-multiple">
                @foreach($categories as $aKey => $aSport)
                  <option value="{{$aKey}}" @if(array_search($aKey, $cat) !== false)selected="selected"@endif>{{  $aSport   }}</option>
                @endforeach
                </select>
              <span class="label label-danger">{{$errors->first('category')}}</span>
            </div>
          </div>


        <!--  <div class="form-group">
            <label class="col-sm-3 control-label" for="pubic">@lang('messages.pubicHair')</label>
            <div class="col-sm-9">
               {{Form::select('pubic', $pubico, old('pubic', $performer->pubic), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-3 control-label" for="bust">@lang('messages.bust')</label>
            <div class="col-sm-9">
              {{Form::select('bust', $busto , old('bust', $performer->bust), array('class'=>'form-control input-md', 'placeholder' => $elige))}}
            <span class="label label-danger">{{$errors->first('bust')}}</span>
            </div>
          </div> -->

          <div class="form-group">
            <label class="col-sm-3 control-label" for="languages">@lang('messages.languages')</label>
            <div class="col-sm-9">

                <input type="text" name="languages" value="{{old('languages', $performer->languages)}}" data-role="tagsinput" id="tagsinput" class="form-control input-md"/>
                <label class="help-block">@lang('messages.inputlanguagesare5')</label>
              <span class="label label-danger">{{$errors->first('languages')}}</span>

            </div>
          </div>

          <div class="form-group">
              <label class="col-sm-3 control-label">@lang('messages.tags')</label>
              <div class="col-sm-9">
                  <input type="text" name="tags" value="{{old('tags', $performer->tags)}}"
                         data-role="tagsinput" id="tagsinput" class="form-control input-md tag-input"/>
                  <label class="help-block">@lang('messages.tagHelpBlock')</label>
                  <span class="label label-danger">{{$errors->first('tags')}}</span>
              </div>
          </div>


          <legend>@lang('messages.yourlocationpublic') </legend>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="country">@lang('messages.country') </label>
            <div class="col-sm-9">
                 {{Form::select('country', $countries, old('country', $user->countryId), array('class'=>'form-control ', 'placeholder' => $elige))}}
                <span class="label label-danger">{{$errors->first('country')}}</span>
            </div>
          </div>

          <div class="form-group ">
            <label class="col-sm-3 control-label" for="state_name">@lang('messages.state') @lang('messages.name') </label>
            <div class="col-sm-9">
                {{Form::text('state_name', old('state_name', $performer->state_name), array('class'=>'form-control input-md'))}}
                <span class="label label-danger">{{$errors->first('state_name')}}</span>
            </div>
          </div>
          <div class="form-group ">
            <label class="col-sm-3 control-label" for="city_name">@lang('messages.city') @lang('messages.name') </label>
            <div class="col-sm-9">
                {{Form::text('city_name', old('city_name', $performer->city_name), array('class'=>'form-control input-md'))}}
                <span class="label label-danger">{{$errors->first('city_name')}}</span>
            </div>
          </div>
          <legend>@lang('messages.WordsAboutYou')</legend>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="about_me">@lang('messages.aboutMe')</label>
            <div class="col-sm-9">
              {{Form::textarea('about_me', old('about_me', $performer->about_me), array('class'=>'form-control input-md', 'cols'=>'30', 'rows'=>'4'))}}
                <span class="label label-danger">{{$errors->first('about_me')}}</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="status">@lang('messages.status')</label>
            <div class="col-sm-9">
                 {{Form::text('status', old('status', $performer->status), array('class'=>'form-control input-md'))}}
                <span class="label label-danger">{{$errors->first('status')}}</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="blogname">Blog @lang('messages.name')</label>
            <div class="col-sm-9">
                 {{Form::text('blogname', old('blogname', $performer->blogname), array('class'=>'form-control input-md'))}}
                <span class="label label-danger">{{$errors->first('blogname')}}</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="blog">Blog Link</label>
            <div class="col-sm-9">
                 {{Form::text('blog', old('blog', $performer->blog), array('class'=>'form-control input-md'))}}
                <span class="label label-danger">{{$errors->first('blog')}}</span>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-9 text-center">
               {{Form::submit(Lang::get('messages.saveChanges'), array('class'=>'btn btn-rose btn-lg btn-block'))}}
            </div>
          </div>
        {{Form::close()}}
      </div>
    </div> <!--user's info end-->
  </div>
</div>
</div>
@section('scripts')

<style type="text/css">
  span.select2.select2-container.select2-container--default {
    width: 100% !important;
}
</style>
<script>
 jQuery(document).ready(function($) {
 $('.js-example-basic-multiple').select2({
      placeholder: 'Please select'
 });


$("#gender").change(function(){
if($("#gender").val() == "pareja")
{
  $(".wrap-bust").css("display","none");
  $(".desactivosok").css("display","block");
  $(".activarmodalidad").removeClass( "col-sm-9" ).addClass( "col-sm-3" );
}
else
{
  $(".wrap-bust").css("display","block");
  $(".desactivosok").css("display","none");
  $(".desactivosok").val("");
  $(".activarmodalidad").removeClass( "col-sm-3" ).addClass( "col-sm-9" );
}
})


if($("#gender").val() == "pareja")
{
  $(".wrap-bust").css("display","none");
  $(".desactivosok").css("display","block");
  $(".activarmodalidad").removeClass( "col-sm-9" ).addClass( "col-sm-3" );
}
else
{
   $(".wrap-bust").css("display","block");
  $(".desactivosok").css("display","none");
  $(".desactivosok").val("");
  $(".activarmodalidad").removeClass( "col-sm-3" ).addClass( "col-sm-9" );
}


});
</script>
@stop

@endsection
