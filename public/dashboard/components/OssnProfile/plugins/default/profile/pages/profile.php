<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

$user = $params['user'];
$cover = new OssnProfile;

$coverp = $cover->coverParameters($user->guid);
$cover = $cover->getCoverURL($user);

if(!empty($coverp[0])){
	$cover_top = "top:{$coverp[0]};";
}
if(!empty($coverp[1])){
	$cover_left = "left:{$coverp[1]};";
}
if (ossn_isLoggedIn()) {
    $class = 'ossn-profile';
} else {
    $class = 'ossn-profile ossn-profile-tn';
}
?>
<div class="ossn-profile container">
	<div class="row">
    	<div class="col-md-11">
			<div class="<?php echo $class; ?>">
				<div class="top-container">
					<div id="container" class="profile-cover">
						<?php if (ossn_loggedin_user()->guid == $user->guid) { ?>
						<div class="profile-cover-controls" style="display:none;cursor:pointer;">
							<a href="javascript:void(0);" onclick="Ossn.Clk('.coverfile');" class='btn-action change-cover'>
								<?php echo ossn_print( 'change:cover'); ?>
							</a>
							<a href="javascript:void(0);" id="reposition-profile-cover" class='btn-action reposition-cover'>
								<?php echo ossn_print( 'reposition:cover'); ?>
							</a>
						</div>
						<form id="upload-cover" style="display:none;" method="post" enctype="multipart/form-data">
							<input type="file" name="coverphoto" class="coverfile" onchange="Ossn.Clk('#upload-cover .upload');" />
							<?php echo ossn_plugin_view( 'input/security_token'); ?>
							<input type="submit" class="upload" />
						</form>
						<?php } ?>
						<img id="draggable" class="profile-cover-img" src="<?php echo $cover; ?>" style='<?php echo $cover_top; ?><?php echo $cover_left; ?>' data-top='<?php echo $coverp[0]; ?>' data-left='<?php echo $coverp[1]; ?>'/>
					</div>
					<div class="profile-photo">
						<?php if (ossn_loggedin_user()->guid == $user->guid) { ?>
						<!--<div class="upload-photo" style="display:none;cursor:pointer;">
							<span onclick="Ossn.Clk('.pfile');"><?php echo ossn_print('change:photo'); ?></span>

							<form id="upload-photo" style="display:none;" method="post" enctype="multipart/form-data">
								<input type="file" name="userphoto" class="pfile" onchange="Ossn.Clk('#upload-photo .upload');" />
								<?php echo ossn_plugin_view( 'input/security_token'); ?>
								<input type="submit" class="upload" />
							</form>
						</div> -->
						<?php } 
						//issues with ossn-viewer-comments #1411 (removed viewer)
						?>
						<img src="<?php echo ossn_getimagenes($user->guid,'medium'); ?>" width="170" height="170">
					</div>
					<div class="user-fullname"><?php echo $user->username; ?></div>
                    <?php echo ossn_plugin_view('profile/role', array('user' => $user)); ?>
					<div id='profile-hr-menu' class="profile-hr-menu visible-lg">
						<?php echo ossn_plugin_view('menus/user_timeline', array('menu_width' => 60)); ?>
					</div>
					<div id='profile-hr-menu' class="profile-hr-menu visible-md">
						<?php echo ossn_plugin_view('menus/user_timeline', array('menu_width' => 40)); ?>
					</div>
					<div id='profile-hr-menu' class="profile-hr-menu visible-sm">
						<?php echo ossn_plugin_view('menus/user_timeline', array('menu_width' => 25)); ?>
					</div>
					<div id='profile-hr-menu' class="profile-hr-menu visible-xs">
						<?php echo ossn_plugin_view('menus/user_timeline', array('menu_width' => 1)); ?>
					</div>

					<div id="profile-menu" class="profile-menu">
						<?php if (ossn_isLoggedIn()) { ?>
						<?php if (ossn_loggedin_user()->guid !== $user->guid) { if (!ossn_user_is_friend(ossn_loggedin_user()->guid, $user->guid)) { if (ossn_user()->requestExists(ossn_loggedin_user()->guid, $user->guid)) { ?>
						<a href="<?php echo ossn_site_url("action/friend/remove?cancel=true&user={$user->guid}", true); ?>" class='btn-action'>
                                <?php echo ossn_print('cancel:request'); ?>
                            </a>
						<?php } else { ?>
						<a href="<?php echo ossn_site_url("action/friend/add?user={$user->guid}", true); ?>" class='btn-action'>
                                <?php echo ossn_print('add:friend'); ?>
                         </a>
						<?php } } else { ?>
						<a href="<?php echo ossn_site_url("action/friend/remove?user={$user->guid}", true); ?>"  class='btn-action'>
                            <?php echo ossn_print('remove:friend'); ?>
                        </a>
						<?php } 
						if(com_is_active('OssnMessages')) { ?>
							<a href="<?php echo ossn_site_url("messages/message/{$user->username}"); ?>" id="profile-message" data-guid='<?php echo $user->guid; ?>' class='btn-action'>
							<?php echo ossn_print('message'); ?></a>
						<?php } ?>
						<div class="ossn-profile-extra-menu dropdown">
							<?php echo ossn_view_menu( 'profile_extramenu', 'profile/menus/extra'); ?>
						</div>
						<?php } }?>
					</div>
					<div id="cover-menu" class="profile-menu">
						<a href="javascript:void(0);" onclick="Ossn.repositionCOVER();" class='btn-action'>
							<?php echo ossn_print('save:position'); ?>
						</a>
					</div>
				</div>

			</div>   
          </div>   
    </div>
	<div class="row ossn-profile-bottom">
	 <?php if (isset($params['subpage']) && !empty($params[ 'subpage']) && ossn_is_profile_subapge($params['subpage'])) { 
 				if (ossn_is_hook( 'profile', 'subpage')) { 
							echo ossn_call_hook('profile', 'subpage', $params);
				}
			} else { ?>   
            <div class="col-md-7">

            	<?php

$user = $params['user'];

$getinfouser=ossn_getinfouser($user->guid);

$getpreferenciasuser=ossn_getpreferenciasuser($user->guid);

$getgustosuser=ossn_getgustosuser($user->guid);

$ossn_getallinfouser=ossn_getallinfouser($user->guid);

//DARWIN

/*echo "preferencias;";
echo "<br>----------------";
print_r($getpreferenciasuser);
echo "<br>----------------<br>";

echo "gustos;";
echo "<br>----------------";
print_r($getgustosuser);
echo "<br>----------------<br>";

echo "toda la info del user;";
echo "<br>----------------";
print_r($ossn_getallinfouser);
echo "<br>----------------<br>";


//print_r($getinfouser);
//echo $getinfouser->firstName;

//echo $user->guid;*/


if( $_SESSION['LANG'] == "en")
{
  $eyes = array('blue'=>'Blue', 'brown'=>'Brown', 'green'=>'Green', 'unknown'=>'Unknown');
  $cabello = array('brown'=>'Brown', 'blonde'=>'Blonde', 'black'=>'Black','red'=>'Red', 'unknown'=>'Unknown');
  $pubico = array('trimmed'=>'Trimmed', 'shaved'=>'Shaved', 'hairy'=>'Hairy', 'no_comment'=>'No Comment');


  $busto = array('large'=>'Large', 'medium'=>'Medium', 'small'=>'Small', 'no_comment'=>'No Comment');

  $genero = array('male'=>'Male', 'female'=>'Female', 'transgender'=>'Transgender','pareja'=>'Couple');

  $origenetnico =array("Caucasico(a)"=>"Caucasian","Afro"=>"Afro-American","Arabe"=>"Arab","Asiatico(a)"=>"Asian","Latino(a)"=>"Latin","Otro"=>"Other","No importa"=>"Does not matter","Caribeño(a)"=>"Caribbean");

$fisionomia = array("Delgada"=>"Slim","Atletica"=>"Athletic","Normal"=>"Normal","Kilos extras"=>"Extra kilos","Relleno(a)"=>"Filling");

$experiencia = array("Novato(a)"=>"Rookie","Ocasional"=>"Occasional","Experimentado(a)"=>"Experienced","Descubriendo"=>"Discovering");

}

if( $_SESSION['LANG']== "es" or $_SESSION['LANG'] == "")
{

    $cabello = array('brown'=>'marrón', 'blonde'=>'Rubia', 'black'=>'Negro','red'=>'Rojo', 'unknown'=>'Desconocida');
    $eyes = array('blue'=>'Azul', 'brown'=>'marrón', 'green'=>'Verde', 'unknown'=>'Desconocida');

    $pubico = array('trimmed'=>'Recortada', 'shaved'=>'Afeitado', 'hairy'=>'Peluda', 'no_comment'=>'Sin comentarios');

    $busto = array('large'=>'Grande', 'medium'=>'Medio', 'small'=>'Pequeño', 'no_comment'=>'Sin comentarios');

    $genero = array('male'=>'Hombre', 'female'=>'Mujer', 'transgender'=>'Transgenero','pareja'=>'Pareja');

    $origenetnico =array("Caucasico(a)"=>"Caucásico","Afro"=>"Afro","Arabe"=>"Arabe","Asiatico(a)"=>"Asiático","Latino(a)"=>"Latino","Otro"=>"Otro","No importa"=>"No importa","Caribeño(a)"=>"Caribeño");

    $fisionomia = array("Delgada"=>"Delgada","Atletica"=>"Atlética","Normal"=>"Normal","Kilos extras"=>"Kilos extras","Relleno(a)"=>"Relleno");

    $experiencia = array("Novato(a)"=>"Novato","Ocasional"=>"Ocasional","Experimentado(a)"=>"Experimentado","Descubriendo"=>"Descubriendo");



}

if( $_SESSION['LANG'] == "fr")
{

    $cabello = array('brown'=>'Marron', 'blonde'=>'Rubia', 'black'=>'nègre','red'=>'Rojo', 'unknown'=>'Desconocida');
    $eyes = array('blue'=>'Bleue', 'brown'=>'marron', 'green'=>'Verte', 'unknown'=>'Inconnue');

    $pubico = array('trimmed'=>'Paré', 'shaved'=>'Rasé', 'hairy'=>'Poilue', 'no_comment'=>'Sans commentaire');

    $busto = array('large'=>'Grande', 'medium'=>'Moyenne', 'small'=>'Petite', 'no_comment'=>'Sans commentaire');

    $genero = array('male'=>'Homme', 'female'=>'Femme', 'transgender'=>'transgenres','pareja'=>'couple');

    $origenetnico =array("Caucasico(a)"=>"caucasien","Afro"=>"Afro américain","Arabe"=>"Arabe","Asiatico(a)"=>"asiatique","Latino(a)"=>"Latin","Otro"=>"Autre","No importa"=>"N'a pas d'importance","Caribeño(a)"=>"Caraïbes");


    $fisionomia = array("Delgada"=>"Mince","Atletica"=>"Athlétique","Normal"=>"Ordinaire","Kilos extras"=>"Kilos supplémentairess","Relleno(a)"=>"Remplissage");

    $experiencia = array("Novato(a)"=>"Débutant","Ocasional"=>"Occasionnel","Experimentado(a)"=>"Expérimenté","Descubriendo"=>"Découvrir");

}



//$eyess[$model->eyes

            	 ?>


					<div class="ossn-profile-wall">







<div class="ossn-profile-modules">

	<div class="ossn-widget">
		<div class="widget-heading"><?php echo ossn_print('perfil:perfil')?></div>
		<div class="widget-contents">

			<table class="table perfil">
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:sexo')?></th>
			    <td ><?php echo $genero[$ossn_getallinfouser->gender];?></td>
			  </tr> 

			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:ubicacion')?>	</th>
			    <td><?php echo ($ossn_getallinfouser->city_name =="") ? "": trim($ossn_getallinfouser->city_name).",";?>
			    	<?php echo ($ossn_getallinfouser->state_name =="") ? "": trim($ossn_getallinfouser->state_name).",";?>
			        <?php echo $ossn_getallinfouser->name;?></td>
			  </tr> 


			</table>
			
		</div>
	</div>
</div>











<div class="ossn-profile-modules">

	<div class="ossn-widget">
		<div class="widget-heading"><?php echo ossn_print('perfil:busco')?></div>
		<div class="widget-contents wrap-preferencias" style="    overflow: hidden;">

			<ul class="user-activity ossn-wall-item preferencias">

				<?php foreach ($getpreferenciasuser as $preferencias){ ?>
					

					<?php if ( $_SESSION['LANG'] =='es' or $_SESSION['LANG']==""){ ?>
						<li class="item-preferencias"><?php echo $preferencias->descripcionES ?></li>
					<?php }?>

					<?php if ( $_SESSION['LANG'] =='en'){ ?>
						<li class="item-preferencias"><?php echo $preferencias->descripcionEN ?></li>
					<?php }?>

					<?php if ( $_SESSION['LANG'] =='fr'){ ?>
						<li class="item-preferencias"><?php echo $preferencias->descripcionFR ?></li>
					<?php }?>

				<?php }?>

			</ul>


			
		</div>
	</div>
</div>





<div class="ossn-profile-modules">

	<div class="ossn-widget">
		<div class="widget-heading"><?php echo ossn_print('perfil:descripcion')?></div>
		<div class="widget-contents">

				<?php echo $ossn_getallinfouser->about_me;?>
			
		</div>
	</div>
</div>


<div class="ossn-profile-modules">

	<div class="ossn-widget">
		<div class="widget-heading"><?php echo ossn_print('perfil:perfil')?></div>
		<div class="widget-contents">

			<table class="table table-striped perfil <?php if($ossn_getallinfouser->gender=='pareja'){ echo 'el';} ?>">


<?php if($ossn_getallinfouser->gender=='pareja'){ ?>

			<tr>
			    <th  colspan="2" scope="row" style="width: 100%" class="text-center"><?php echo ossn_print('perfil:el')?></th>
			</tr> 
<?php }?>
				
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:edad')?></th>
			    <td ><?php echo $ossn_getallinfouser->age;?></td>
			  </tr> 

			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:altura')?>	</th>
			    <td><?php echo $ossn_getallinfouser->ellacm;?></td>
			  </tr> 
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:origenetnico')?></th>
			    <td><?php echo $origenetnico[$ossn_getallinfouser->ellaetnia];?></td>
			  </tr> 
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:fisionomia')?></th>
			    <td><?php echo $fisionomia[$ossn_getallinfouser->ellafionomia];?></td>
			  </tr> 

			  			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:ojos')?></th>
			    <td ><?php echo  $eyes[$ossn_getallinfouser->eyes];?></td>
			  </tr> 

			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:cabello')?>	</th>
			    <td><?php echo  $cabello[$ossn_getallinfouser->hair];?></td>
			  </tr> 
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:peso')?></th>
			    <td><?php echo $ossn_getallinfouser->weight;?></td>
			  </tr> 
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:vellopubico')?></th>
			    <td><?php echo  $pubico[$ossn_getallinfouser->pubit];?></td>
			  </tr> 

			   <tr>
			    <th scope="row">

				<?php if($ossn_getallinfouser->gender !='pareja'){ ?>
						Busto
				<?php }?> 
			    </th>
			    <td><?php if($ossn_getallinfouser->gender !='pareja'){ 

			    	echo $busto[$ossn_getallinfouser->bust];
			    	
			    		} ?>
			    	
			    </td>
			  </tr> 

			</table>



<table class="table table-striped perfil <?php if($ossn_getallinfouser->gender=='pareja'){ echo 'ella';} ?>" style=" display: none;">

				<?php if($ossn_getallinfouser->gender=='pareja'){ ?>

							<tr>
							    <th  colspan="2" scope="row" style="width: 100%" class="text-center" ><?php echo ossn_print('perfil:ella')?></th>
							</tr> 
				<?php }?> 

			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:edad')?></th>
			    <td ><?php echo $ossn_getallinfouser->agellla;?></td>
			  </tr> 

			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:altura')?>	</th>
			    <td><?php echo $ossn_getallinfouser->elcm;?></td>
			  </tr> 
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:origenetnico')?></th>
			    <td><?php echo $origenetnico[$ossn_getallinfouser->eletnia];?></td>
			  </tr> 
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:fisionomia')?></th>
			    <td><?php echo $fisionomia[$ossn_getallinfouser->elfisionomia];?></td>
			  </tr> 

			<tr>
			    <th scope="row"><?php echo ossn_print('perfil:ojos')?></th>
			    <td ><?php echo $eyes[$ossn_getallinfouser->eyes_ella];?></td>
			  </tr> 

			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:cabello')?>	</th>
			    <td><?php echo $cabello[$ossn_getallinfouser->hair_ella];?></td>
			  </tr> 
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:peso')?></th>
			    <td><?php echo $ossn_getallinfouser->weight_ella;?></td>
			  </tr> 
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:vellopubico')?></th>
			    <td><?php echo $pubico[$ossn_getallinfouser->pubit_ella];?></td>
			  </tr> 

			   <tr>
			    <th scope="row"><?php echo ossn_print('perfil:busto')?></th>
			    <td><?php echo $busto[$ossn_getallinfouser->bust];?></td>
			  </tr> 


			</table>

<div style="clear: both;"></div>


			
		</div>
	</div>
</div>




<div class="ossn-profile-modules">

	<div class="ossn-widget">
		<div class="widget-heading"><?php echo ossn_print('perfil:gustos')?></div>
		<div class="widget-contents">

			<ul class="user-activity ossn-wall-item gustos"   style="    overflow: hidden;">

				<?php foreach ($getgustosuser as $gustos){ ?>

					<?php if ( $_SESSION['LANG'] =='es' or $_SESSION['LANG']==""){ ?>
						<li class="item-gustos"><?php echo $gustos->descripcionES ?></li>
					<?php }?>

					<?php if ( $_SESSION['LANG'] =='en'){ ?>
						<li class="item-preferencias"><?php echo $gustos->descripcionEN ?></li>
					<?php }?>

					<?php if ( $_SESSION['LANG'] =='fr'){ ?>
						<li class="item-preferencias"><?php echo $gustos->descripcionFR ?></li>
					<?php }?>

					 
				<?php }?>

			</ul>


			
		</div>
	</div>
</div>


<div class="ossn-profile-modules">

	<div class="ossn-widget">
		<div class="widget-heading"><?php echo ossn_print('perfil:sobre')?></div>
		<div class="widget-contents">

			<table class="table perfil">
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:experiencia')?></th>
			    <td ><?php echo   $experiencia[$ossn_getallinfouser->experiencias];?></td>
			  </tr> 

			 

			</table>
			
		</div>
	</div>
</div>


<div class="ossn-profile-modules">

	<div class="ossn-widget">
		<div class="widget-heading"><?php echo ossn_print('perfil:blog')?></div>
		<div class="widget-contents">

			<table class="table perfil">
			  <tr>
			    <th scope="row"><?php echo ossn_print('perfil:link')?> </th>
			    <td ><a href="<?php echo $ossn_getallinfouser->blog;?>" target="_blank" rel="nofollow"><?php echo $ossn_getallinfouser->blogname;?></a></td>
			  </tr> 

			 

			</table>
			
		</div>
	</div>
</div>


				
					</div>
         </div>      
		<div class="col-md-4">
			<div class="ossn-profile-sidebar hidden-xs">
 				<div class="ossn-profile-modules" >
					<?php if (ossn_is_hook( 'profile', 'modules')) { 
								$params[ 'user'] = $user; 
								$modules = ossn_call_hook('profile', 'modules', $params); 
								echo implode( '', $modules);
					} ?>

				</div>               
			</div>
		</div>
       <?php } ?>  
	</div>
</div>

