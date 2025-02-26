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

$pais          = ossn_localizaciones();
$preferencias  = ossn_preferencias();
$gustos        = ossn_gustos();

$fisionomia = ossn_print('ossn:fisionomia');
$laexperiencia = ossn_print('ossn:laexperiencia');
$fili = json_decode('["Delgada","Atletica","Normal","Kilos extras","Relleno(a)"]');
$exper = json_decode('["Novato(a)","Ocasional","Experimentado(a)","Descubriendo"]');
/*
foreach(json_decode($fisionomia) as $fisio) {
echo $fisio;
}
die("sicorrr");*/
$menus = $params['menu'];
echo "<div class='ossn-menu-search'>";
?>


<form  action="/dashboard/search" method="get" id="form22" >

	<div style="position: relative;width: 100%;height: 6%;background: #333333;">
	   <div class="botonesbuscador" style="width: 30%;">
	   <div class="botonesbuscador3" id="principal" style="margin-top: 23px;">
	   <i class="fa fa-search" style="font-size: 27px;width: 100%;"></i>
	   	<?php
		echo ossn_print('ossn:principalcriterio');
		?>
	   </div>
	   <div class="botonesbuscador3" id="losgustos">
	<i class="fa fa-heartbeat" style="font-size: 27px;width: 100%;"></i>

	<?php
		echo ossn_print('ossn:gustos');
	?>

	</div>
	   <div class="botonesbuscador3" id="originetnia">
	<i class="fa fa-venus" style="font-size: 25px;width: 100%;"></i>
	

	<?php
		echo ossn_print('ossn:etnia');
	?>
	   

	</div>
	   <div class="botonesbuscador3" id="ubicacion" style="margin-bottom: 23% !important;">
	<i class="fa fa-location-arrow" style="font-size: 25px;width: 100%;"></i>
	

	<?php
		echo ossn_print('ossn:ubicacion');
	?>
	

	</div>
	   </div>
	   <div class="botonesbuscador2" id="principal-opt" style="width: 70%;height: 523px;overflow-y: overlay;">
	      


	<div class="accordion" id="accordionExample">

			<button id="limpiar" style="width: 90%;margin-bottom: 4%;margin-top: 4%;background: #0b769c;color: white;">

					               	<?php


			               	        $valido['ES'] = "Limpiar";
									$valido['EN'] = "Clean";
									$valido['FR'] = "Nettoyer";
									$idioma =  ossn_print('ossn:mostraridioma');
									echo $valido[$idioma];
							?>


		</button>
	  

	           <ul class="FS13" style="margin-top: 7%;">
	            <li class="pad10 borderBot MB10" >
	               <div class="borderWhiteBox w100 dTable LH30 focused" ng-class="{focused: focused.pseudo}">
	                  <label class="dTCell w100 vaM pRelative" style="width: 95%;">
	                     <input type="text" placeholder="Nick?" name="q" id="q" style="width: 95%;font-weight: 300;">
	                  </label>
	                  <p class="dTCell pad5_5 vaM">
	                     <!-- ngIf: search.pseudo.length > 2 -->
	                  </p>
	               </div>
	            </li>
	            <li class="pad10_10 LH30" >
	               <div class="switch-button">
	                  <label for="" class="submenues" style='font-weight: 100;'>
						<?php
						$valido['ES'] = "En linea";
						$valido['EN'] = "Online";
						$valido['FR'] = "en ligne";
						$idioma =  ossn_print('ossn:mostraridioma');
						echo $valido[$idioma];
						?>						
						</label>
	                  <!-- Checkbox -->
	                  <input type="checkbox" name="online" id="online" class="switch-button__checkbox">
	                  <!-- Botón -->
	                  <label for="online" class="switch-button__label"></label>
	               </div>
	            </li>	            
	            <li class="pad10_10 LH30" >
	               <div class="switch-button">
	                  <label for="" class="submenues" style='font-weight: 100;'>
						<?php
						$valido['ES'] = "Validado";
						$valido['EN'] = "Validated";
						$valido['FR'] = "validé";
						$idioma =  ossn_print('ossn:mostraridioma');
						echo $valido[$idioma];
						?>						
						</label>
	                  <!-- Checkbox -->
	                  <input type="checkbox" name="validado" id="validado" class="switch-button__checkbox">
	                  <!-- Botón -->
	                  <label for="validado" class="switch-button__label"></label>
	               </div>
	            </li>
	            <li class="pad10_10 LH30" >
	               <div class="switch-button">
	                  <label for="" class="submenues" style='font-weight: 100;'>
	                  	
	                  	<?php

	                  	$valido['ES'] = "Foto";
						$valido['EN'] = "Photo";
						$valido['FR'] = "Photo";
						$idioma =  ossn_print('ossn:mostraridioma');
						echo $valido[$idioma];

						?>

					</label>
	                  <!-- Checkbox -->
	                  <input type="checkbox" name="foto" id="foto" class="switch-button__checkbox">
	                  <!-- Botón -->
	                  <label for="foto" class="switch-button__label"></label>
	               </div>
	            </li>
	         </ul>


	  <div class="card" id="prime">



	    <div class="card-header" id="wrap_gender">
	      <h2 class="mb-0">
	        <button class="btn btn-link collapsed estilotituloes" type="button" data-toggle="collapse" data-target="#collapseThree3" aria-expanded="false" aria-controls="collapseThree" >
	                      	<?php echo ossn_print('gender'); ?>
						
	        </button>
	      </h2>



					<div class='funkyradio-info'>
	                     <input type='checkbox' name='gender1' id='gender1'/>
	                     <label style='font-weight: 100;'><?php echo ossn_print('male'); ?></label>
	                </div>
	                <div class='funkyradio-info'>
	                     <input type='checkbox' name='gender2' id='gender2'/>
	                     <label style='font-weight: 100;'><?php echo ossn_print('female'); ?></label>
	                </div>
	                 <div class='funkyradio-info'>
	                     <input type='checkbox' name='gender3' id='gender3'/>
	                     <label style='font-weight: 100;'><?php echo ossn_print('transexual'); ?></label>
	                </div>
	                <div class='funkyradio-info'>
	                     <input type='checkbox' name='gender4' id='gender4'/>
	                     <label style='font-weight: 100;'><?php echo ossn_print('pareja'); ?></label>
	                 </div>
	                


	      


	      </div>








	    <div class="card-header" id="preferenci">
	      <h2 class="mb-0">
	        <button class="btn btn-link collapsed estilotituloes" type="button" data-toggle="collapse" data-target="#collapseThree3" aria-expanded="false" aria-controls="collapseThree" >
	                      	<?php echo ossn_print('ossn:tupreferencia'); ?>
						
	        </button>
	      </h2>
	      </div>
	      <div id="collapseThree" class="collapsep" aria-labelledby="preferenciq" data-parent="#accordionExample">
	      <div class="card-body">



	      <div>


	            <?php
				   $idioma =  ossn_print('ossn:mostraridioma');
	               foreach($preferencias as $estasson) {

						               	
					$texto['EN'] = $estasson->descripcionEN;
					$texto['ES'] = $estasson->descripcionES;
					$texto['FR'] = $estasson->descripcionFR;

	                  echo "<div class='funkyradio-info'>
	                     <input type='checkbox' name='preferencia$estasson->Preferencias_id' id='preferencia$estasson->Preferencias_id'/>
	                     <label for='preferencia$estasson->Preferencias_id' style='font-weight: 100;'>$texto[$idioma]</label>
	                  </div>";
	               }

	            ?>

	      </div>




	      </div>
	    </div>
	  </div>

	  <div class="card" id="gusto">
	     <div class="card-header" id="buscandito3">
	      <h2 class="mb-0" style="display: none;">
	        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#buscandito2" aria-expanded="false" aria-controls="buscandito2" style="text-decoration: none;background: #fff;font-size: 13px;color: #0b769c;width: 88%;font-weight: bold;text-decoration-line: underline;">
	          			<?php
							echo ossn_print('ossn:quebuscas');
						?>
	        </button>
	      </h2>
	      </div>
	      <div id="buscandito2" class="collapsep" aria-labelledby="buscandito2" data-parent="#buscandito2">

	      <div class="card-body">



			      <div>

			         <h2 class="mb-0 valorint">
			        	<?php
							echo ossn_print('ossn:gustos');
						?>
					</h2>


			            <?php
			               $idioma =  ossn_print('ossn:mostraridioma');

			               foreach($gustos as $misgustos) {


							$texto2['EN'] = $misgustos->descripcionEN;
							$texto2['ES'] = $misgustos->descripcionES;
							$texto2['FR'] = $misgustos->descripcionFR;


			                  echo "<div class='funkyradio-info'>
			                     <input type='checkbox' name='gustos$misgustos->gustos_id' id='gustos$misgustos->gustos_id'/>
			                     <label style='font-weight: 100;' for='gustos$misgustos->gustos_id'>$texto2[$idioma]</label>
			                  </div>";
			               }

			            ?>





			             <div>

			         <h2 class="mb-0 valorint">
			        	<?php
							echo ossn_print('ossn:experiencia');
						?>
					</h2>


			            <?php
			               $idioma =  ossn_print('ossn:mostraridioma');

			               foreach(json_decode($laexperiencia) as $indi => $expe) {
			               	$text = $exper[$indi];
			               	$text2 = str_replace("(", "", $text);
			               	$text2 = str_replace(")", "", $text2);
			               	$text2 = str_replace(" ", "", $text2);
			                  echo "<div class='funkyradio-info'>
			                     <input type='checkbox' name='$text2' id='$text2' value='$text'/>
			                     <label style='font-weight: 100;' for='$text2'>$expe</label>
			                  </div>";

			               }

			            ?>

			      </div>


			      </div>
	      </div>
	    </div>

	  </div>





	  <div class="card" id="origenitnico">



	    <div class="card-header" id="headingTwo">



















			         <ul class="FS13">
			            <!-- end ngIf: search.components.form.theirseek --><!-- ngIf: search.components.form.womanage -->
			            <li class="MB10">
			            	<h2 class="mb-0 valorint">
			               <span class="cBleuBG LH30 padL10 txtUp" style="" ><strong style="/*font-weight: 100;*/" class="Bold FS13">
			               	<?php


			               	        $valido['ES'] = "Edad";
									$valido['EN'] = "Age";
									$valido['FR'] = "Âge";
									$idioma =  ossn_print('ossn:mostraridioma');
									echo $valido[$idioma];
							?>
			               		
			               	</strong> <b class="colorTheme2 txtUp" style="/*font-weight: 100;*/"> <?php echo ossn_print('ossn:ella'); ?> </b></span>

			               </h2>
			               <p class="pad10 borderTop w100 txtAR" spaceless="" style="margin-top: 7%;">
			                  <b class="dInlineB w30 txtAL" style="color: black;font-weight: 100;"><?php echo ossn_print('ossn:entre'); ?></b>
			                  <label class="borderWhiteBox LH0 dInlineB w25">
			                     <select style="color: black;" name="rangoellamenos" id="rangoellamenos">
			                        <option value="" selected="selected">--</option>
			                        <?php

			                        for ($i = 18; $i <= 99; $i++) {
			                           $ano = date("Y");
			                           $ano = $ano - $i;
			                           echo "<option label='$i' value='$ano'>$i</option>";
			                        }
			                        ?>
			                     </select>
			                  </label>
			                  <b class="dInlineB w20 center" style="font-weight: 100;color: black;">
							
							<?php
			               	        $valido['ES'] = "y";
									$valido['EN'] = "And";
									$valido['FR'] = "Oui";
									$idioma =  ossn_print('ossn:mostraridioma');
									echo $valido[$idioma];

			                 ?>

			              </b>
			                  <label class="borderWhiteBox LH0 dInlineB w25">
			                     <select style="color: black;" name="rangoellamas" id="rangoellamas">
			                        <option value="" selected="selected">--</option>
			                        
			                        <?php
			                        for ($i = 18; $i <= 99; $i++) {
			                        $ano = date("Y");
			                        $ano = $ano - $i;
			                            echo "<option label='$i' value='$ano'>$i</option>";
			                        }

			                        ?>
			                        
			                     </select>
			                  </label>
			               </p>
			            </li>
			            <!-- end ngIf: search.components.form.womanage --><!-- ngIf: search.components.form.manage -->
			            <li class="MB10">
			            	<h2 class="mb-0 valorint">
			               <span class="cBleuBG LH30 padL10 txtUp" style="/*color: black;*/"><strong class="Bold FS13" style='/*font-weight: 100;*/'>			        	<?php


			               	        $valido['ES'] = "Edad";
									$valido['EN'] = "Age";
									$valido['FR'] = "Âge";
									$idioma =  ossn_print('ossn:mostraridioma');
									echo $valido[$idioma];

			                 ?>
							
						</strong> <b class="cBleuBG txtUp" style='/*font-weight: 100;*/'><?php echo ossn_print('ossn:el'); ?>  </b></span>
						</h2>
			               <p class="pad10 borderTop w100 txtAR" spaceless="" style="margin-top: 7%;">
			                  <b class="dInlineB w30 txtAL" style='font-weight: 100;color: black;' ><?php echo ossn_print('ossn:entre'); ?>
			              </b>
			                  <label style='font-weight: 100;' class="borderWhiteBox LH0 dInlineB w25" ng-class="{'focused':focused.age0Min}">
			                     <select style="color: black;" name="rangoelmenos" id="rangoelmenos">
			                        <option value="" selected="selected">--</option>
			                        
			                        <?php

			                        for ($i = 18; $i <= 99; $i++) {
			                           $ano = date("Y");
			                           $ano = $ano - $i;
			                            echo "<option label='$i' value='$ano'>$i</option>";
			                        }

			                        ?>
			                        
			                     </select>
			                  </label>
			                  <b class="dInlineB w20 center" style="font-weight: 100;color: black;">
			                 							
							<?php
			               	        $valido['ES'] = "y";
									$valido['EN'] = "And";
									$valido['FR'] = "Oui";
									$idioma =  ossn_print('ossn:mostraridioma');
									echo $valido[$idioma];

			                 ?>
			                 
			              </b>
			                  <label class="borderWhiteBox LH0 dInlineB w25"  style="font-weight: 100 !important;">
			                     <select style="color: black;font-weight: 100 !important;" name="rangoelmas" id="rangoelmas">
			                        <option value="" selected="selected" >--</option>
			                        
			                        <?php

			                        for ($i = 18; $i <= 99; $i++) {
			                           $ano = date("Y");
			                           $ano = $ano - $i;
			                            echo "<option label='$i' value='$ano'>$i</option>";
			                        }

			                        ?>

			                     </select>
			                  </label>
			               </p>
			            </li>
			         </ul>











			         <ul class="FS13">
			            <!-- end ngIf: search.components.form.theirseek --><!-- ngIf: search.components.form.womanage -->
			            <li class="MB10">
			            	<h2 class="mb-0 valorint">
			               <span class="cBleuBG LH30 padL10 txtUp" style="" ><strong style="/*font-weight: 100;*/" class="Bold FS13">
							<?php echo ossn_print('ossn:altura'); ?>
			               	</strong> <b class="colorTheme2 txtUp" style="/*font-weight: 100;*/"> <?php echo ossn_print('ossn:ella'); ?> </b></span>

			               </h2>
			               <p class="pad10 borderTop w100 txtAR" spaceless="" style="margin-top: 7%;">
			                  <b class="dInlineB w30 txtAL" style="color: black;font-weight: 100;"><?php echo ossn_print('ossn:entre'); ?></b>
			                  <label class="borderWhiteBox LH0 dInlineB w25">
			                     <select style="color: black;" name="alturamenosella" id="alturamenosella">
			                        <option value="" selected="selected">--</option>
			                        <?php

			                        for ($i = 130; $i <= 250; $i++) {
			                           echo "<option label='$i' value='$i'>$i</option>";
			                        }
			                        ?>
			                     </select>
			                  </label>
			                  <b class="dInlineB w20 center" style="font-weight: 100;color: black;">
							
							<?php
			               	        $valido['ES'] = "y";
									$valido['EN'] = "And";
									$valido['FR'] = "Oui";
									$idioma =  ossn_print('ossn:mostraridioma');
									echo $valido[$idioma];

			                 ?>

			              </b>
			                  <label class="borderWhiteBox LH0 dInlineB w25">
			                     <select style="color: black;" name="alturamasella" id="alturamasella">
			                        <option value="" selected="selected">--</option>
			                        
			                        <?php
			                        for ($i = 130; $i <= 250; $i++) {
			                            echo "<option label='$i' value='$i'>$i</option>";
			                        }

			                        ?>
			                        
			                     </select>
			                  </label>
			               </p>
			            </li>
			            <!-- end ngIf: search.components.form.womanage --><!-- ngIf: search.components.form.manage -->
			            <li class="MB10">
			            	<h2 class="mb-0 valorint">
			               <span class="cBleuBG LH30 padL10 txtUp" style="/*color: black;*/"><strong class="Bold FS13" style='/*font-weight: 100;*/'>	

			               	<?php echo ossn_print('ossn:altura'); ?>
							
						</strong> <b class="cBleuBG txtUp" style='/*font-weight: 100;*/'><?php echo ossn_print('ossn:el'); ?>  </b></span>
						</h2>
			               <p class="pad10 borderTop w100 txtAR" spaceless="" style="margin-top: 7%;">
			                  <b class="dInlineB w30 txtAL" style='font-weight: 100;color: black;' ><?php echo ossn_print('ossn:entre'); ?>
			              </b>
			                  <label style='font-weight: 100;' class="borderWhiteBox LH0 dInlineB w25" ng-class="{'focused':focused.age0Min}">
			                     <select style="color: black;" name="alturamenosel" id="alturamenosel">
			                        <option value="" selected="selected">--</option>
			                        
			                        <?php

			                        for ($i = 130; $i <= 250; $i++) {
			                            echo "<option label='$i' value='$i'>$i</option>";
			                        }

			                        ?>
			                        
			                     </select>
			                  </label>
			                  <b class="dInlineB w20 center" style="font-weight: 100;color: black;">

			                  	  <?php
			               	        $valido['ES'] = "y";
									$valido['EN'] = "And";
									$valido['FR'] = "Oui";
									$idioma =  ossn_print('ossn:mostraridioma');
									echo $valido[$idioma];

			                 ?>
			                
			                 
			              </b>
			                  <label class="borderWhiteBox LH0 dInlineB w25"  style="font-weight: 100 !important;">
			                     <select style="color: black;font-weight: 100 !important;" name="alturamasel" id="alturamasel">
			                        <option value="" selected="selected" >--</option>
			                        
			                        <?php

			                        for ($i = 130; $i <= 250; $i++) {
			                            echo "<option label='$i' value='$i'>$i</option>";
			                        }

			                        ?>

			                     </select>
			                  </label>
			               </p>
			            </li>
			         </ul>

















	      <h2 class="mb-0">
	        <button class="btn btn-link collapsed estilotituloes" type="button" data-toggle="collapse" data-target="#collapseTwow" aria-expanded="false" aria-controls="collapseTwo">
	          		<?php
							echo ossn_print('ossn:ficionimia');
							echo " ";
							echo ossn_print('ossn:el');
						?>
	        </button>
	      </h2>


	     <div id="collapsetres" class="collapsep" aria-labelledby="headingtres" data-parent="#headingtres">
	      <div class="card-body">

       		<div>
	       		
		            
	            <?php
	            foreach(json_decode($fisionomia) as $ind => $fisio) {
	            $tex = $fili[$ind];
	            $fisio2 = str_replace(" ", "", $tex);
	            $fisio2 = str_replace("(", "", $fisio2);
	            $fisio2 = str_replace(")", "", $fisio2);

	            

				echo '<div class="funkyradio-info">';
				echo "<input type='checkbox' name='el$fisio2' id='el$fisio2'/>";
				echo "<label for='el$fisio2' style='font-weight: 100;'>$fisio</label>";
				echo '</div>';
				}

	            ?>      
	 
		         
	         </div>
	         </div>
	        </div>





	      <h2 class="mb-0">
	        <button class="btn btn-link collapsed estilotituloes" type="button" data-toggle="collapse" data-target="#collapseTwos" aria-expanded="false" aria-controls="collapseTwo">
	          		<?php
							echo ossn_print('ossn:ficionimia');
							echo " ";
							echo ossn_print('ossn:ella');
						?>
	        </button>
	      </h2>


	     <div id="collapsetres" class="collapsep" aria-labelledby="headingtres" data-parent="#headingtres">
	      <div class="card-body">

       		<div>
	       		
		            
	            <?php
	            foreach(json_decode($fisionomia) as $un => $fisio) {
	            $tex = $fili[$un];
	            $fisio2 = str_replace(" ", "", $tex);
	            $fisio2 = str_replace("(", "", $fisio2);
	            $fisio2 = str_replace(")", "", $fisio2);
				echo '<div class="funkyradio-info">';
				echo "<input type='checkbox' name='ella$fisio2' id='ella$fisio2'/>";
				echo "<label for='ella$fisio2' style='font-weight: 100;'>$fisio</label>";
				echo '</div>';
				}

	            ?>      
	 
		         
	         </div>
	         </div>
	        </div>






	      <h2 class="mb-0">
	        <button class="btn btn-link collapsed estilotituloes" type="button" data-toggle="collapse" data-target="#collapseTwodd" aria-expanded="false" aria-controls="collapseTwo">
	          		<?php
							echo ossn_print('ossn:origienetnia');
						?>
	        </button>
	      </h2>
	     </div>
	     <div id="collapseTwo" class="collapsep" aria-labelledby="headingTwo" data-parent="#accordionExample">
	      <div class="card-body">

	      <div >
	         <div class="funkyradio-info">
	            <input type="checkbox" name="etnico1" id="etnico1"/>
	            <label for="etnico1" style='font-weight: 100;'><?php	echo ossn_print('ossn:afro'); ?></label>
	         </div>
	         <div class="funkyradio-info">
	            <input type="checkbox" name="etnico2" id="etnico2"/>
	            <label for="etnico2" style='font-weight: 100;'><?php	echo ossn_print('ossn:arabe'); ?></label>
	         </div>
	         <div class="funkyradio-info">
	            <input type="checkbox" name="etnico3" id="etnico3"/>
	            <label for="etnico3" style='font-weight: 100;'><?php	echo ossn_print('ossn:asiatico'); ?></label>
	         </div>
	         <div class="funkyradio-info">
	            <input type="checkbox" name="etnico4" id="etnico4"/>
	            <label for="etnico4" style='font-weight: 100;'><?php	echo ossn_print('ossn:caribeno');	?></label>
	         </div>
	         <div class="funkyradio-info">
	            <input type="checkbox" name="etnico5" id="etnico5"/>
	            <label for="etnico5" style='font-weight: 100;'><?php	echo ossn_print('ossn:caucasico');	?></label>
	         </div>
	         <div class="funkyradio-info">
	            <input type="checkbox" name="etnico6" id="etnico6"/>
	            <label for="etnico6" style='font-weight: 100;'><?php	echo ossn_print('ossn:latino');	?></label>
	         </div>
	         <div class="funkyradio-info">
	            <input type="checkbox" name="etnico7" id="etnico7"/>
	            <label for="etnico7" style='font-weight: 100;'><?php	echo ossn_print('ossn:otro');	?></label>
	         </div>
	      </div>


	      </div>
	    </div>
	  </div>






	  <div class="card" id="mipais">
	    <div class="card-header" id="headingOne">
	      <h2 class="mb-0">
	        <button class="btn btn-link estilotituloes" type="button" data-toggle="collapse" data-target="#collapseOneii" aria-expanded="true" aria-controls="collapseOne">
	           		<?php
							echo ossn_print('ossn:ubicacion');
						?>
	        </button>
	      </h2>
	     </div>

	     <div id="collapseOne" class="collapsep" aria-labelledby="headingOne" data-parent="#accordionExample">
	      <div class="card-body">
	      
	      <div >

	         <select name="pais" id="pais" style="width: 88%; color: black;padding: 3%;">
	            <option value="0">
	            	<?php

	                  	$valido['ES'] = "Elige";
						$valido['EN'] = "Choose";
						$valido['FR'] = "Choisir";
						$idioma =  ossn_print('ossn:mostraridioma');
						echo $valido[$idioma];

					?>			
				</option>
	            <?php

	               foreach($pais as $aqui) {

	                  echo "<option value='$aqui->id'>$aqui->name</option>";

	               }

	            ?>
	         </select>
	         
	      </div>


	        
	      </div>
	    </div>

	    
	  </div>



	  </div>


	   </div>
	</div>

</form>






<script type="text/javascript">


$(".botonesbuscador3").click(function(){

	$(".botonesbuscador3").removeClass("estilboton");
	sessionStorage.setItem('opcion', $(this)[0].id);
	
	$(this).addClass("estilboton");
})



$("#limpiar").click(function(event){
	event.preventDefault();
	sessionStorage.setItem('botones', '');
	$('select option[value="0"]').attr("selected", true);
	$(".funkyradio-info [type=checkbox]").prop("checked", false);
	$("#validado").prop("checked", false);
	$("#foto").prop("checked", false);
	$("#q").val("");
	$('#form22').submit();
})




$("#q").keypress(function(e) {
       if(e.which == 13) {
			
			event.preventDefault();
       	   function removeItemFromArr ( arr, item ) {
		        var i = arr.indexOf( item );
		        if ( i !== -1 ) {
		            arr.splice( i, 1 );
		        }
		   }
		   



			info = $(this)[0].name;
			infovalor = $(this).val();
			console.dir(infovalor);
			var botones = sessionStorage.getItem('botones');

			if(botones === null || botones == "")
			{
				botones = [];
				botones.push(info);
				sessionStorage.setItem('botones', JSON.stringify(botones));
				sessionStorage.setItem(info, infovalor);
				$('#form22').submit();
			}
			else
			{

				console.dir("entre2");
				botones = JSON.parse(botones);
				var datt = botones.find(element => element == info );
				sessionStorage.setItem(info, infovalor);


				if(datt !== undefined )
		        {
		        	if($(this)[0].type !== 'text' ) {

		        		switch ($(this).val()) {
						  case "0":
						  	    removeItemFromArr( botones, datt );
								sessionStorage.setItem('botones', JSON.stringify(botones));
								sessionStorage.setItem(info, infovalor);
						    
						    break;
						  case "on":
						    	removeItemFromArr( botones, datt );
								sessionStorage.setItem('botones', JSON.stringify(botones));
								sessionStorage.setItem(info, infovalor);
						    break;
						}

		        	}

		        }
		        else
		        { 	
					botones.push(info);
					sessionStorage.setItem('botones', JSON.stringify(botones));
					sessionStorage.setItem(info, infovalor);

		        }

		        //console.dir(botones);
		        $('#form22').submit();
			}

       }
});



$("#form22 input[type=checkbox],#form22 input[type=text],#form22 select").change(function(){

//if($(this).prop('checked')){



   function removeItemFromArr ( arr, item ) {
        var i = arr.indexOf( item );
        if ( i !== -1 ) {
            arr.splice( i, 1 );
        }
   }
   



	info = $(this)[0].name;
	infovalor = $(this).val();
	var botones = sessionStorage.getItem('botones');

	if(botones === null || botones == "")
	{
		botones = [];
		botones.push(info);
		sessionStorage.setItem('botones', JSON.stringify(botones));
		sessionStorage.setItem(info, infovalor);
		$('#form22').submit();
	}
	else
	{

		console.dir("entre2");
		botones = JSON.parse(botones);
		var datt = botones.find(element => element == info );
		sessionStorage.setItem(info, infovalor);


		if(datt !== undefined )
        {
        	if($(this)[0].type !== 'text' ) {

        		switch ($(this).val()) {
				  case "0":
				  	    removeItemFromArr( botones, datt );
						sessionStorage.setItem('botones', JSON.stringify(botones));
						sessionStorage.setItem(info, infovalor);
				    
				    break;
				  case "on":
				    	removeItemFromArr( botones, datt );
						sessionStorage.setItem('botones', JSON.stringify(botones));
						sessionStorage.setItem(info, infovalor);
				    break;
				}

        	}

        }
        else
        { 	
			botones.push(info);
			sessionStorage.setItem('botones', JSON.stringify(botones));
			sessionStorage.setItem(info, infovalor);

        }

        //console.dir(botones);
        $('#form22').submit();
	}




})



	//onclick="document.getElementById('form22').submit();"
   


      $( "#principal" ).click(function() {

         $("#prime").show();
         $("#gusto").show();
         $("#origenitnico").show();
         $("#mipais").show();
      });
      
      $( "#losgustos" ).click(function() {
         $("#gusto").show();
         $("#prime").hide();
         $("#mipais").hide();
         $("#origenitnico").hide();
      });

      $( "#originetnia" ).click(function() {
         $("#gusto").hide();
         $("#prime").hide();
         $("#mipais").hide();
         $("#origenitnico").show();
      });

      $( "#ubicacion" ).click(function() {
         $("#mipais").show();
         $("#gusto").hide();
         $("#prime").hide();
         $("#origenitnico").hide();
      });


   document.addEventListener('DOMContentLoaded', function () {


	var opcion = sessionStorage.getItem('opcion');
		  
	if(opcion !== null){

		$("#"+opcion).addClass("estilboton");   

	}




	var botones = sessionStorage.getItem('botones');

	if(botones !== null || botones != "")
	{
		botones = JSON.parse(botones);

		$.each(botones, function( index, value ) {
			var valores = sessionStorage.getItem(value);

        		switch ($("#"+value)[0].type) {
				  case "checkbox":

				  		$("#"+value).prop("checked", valores);
				    
				    break;
				  case "select-one":
				  		$("#"+value+' option[value="'+valores+'"]').attr("selected", true);
				    break;				  
				    case "text":
				    	$("#"+value).val(valores);
				    break;
				}			
		});
	}






   
      /*
       var el = document.getElementById("principal"); 
       var eldos = document.getElementById("segunda"); 
   
      el.addEventListener("click", function(){
         let valor;
         valor = document.getElementById("principal-opt").classList.toggle("mystyle");
   
         if(valor){
            document.getElementById("principal-opt").style.display = 'none';     
         }
         else
         {
            document.getElementById("principal-opt").style.display = 'block';
         }
   
      }, false); 
   
   
   
      eldos.addEventListener("click", function(){
   
         let valor;
         valor = document.getElementById("segunda-opt").classList.toggle("mystyle");
   
         if(valor){
            document.getElementById("segunda-opt").style.display = 'none';    
         }
         else
         {
            document.getElementById("segunda-opt").style.display = 'block';
         }
   
      }, false); 
   */
   
   
   });
</script>
<style type="text/css">


.estilotituloes{
	text-decoration: none;
    background: #fff;
    font-size: 13px;
    color: #0b769c;
    width: 88%;
    font-weight: bold;
    text-align: left;
    padding: 4px 0px !important;
    border-bottom: solid 1px #dadada;
    width: 100%;
    height: 25px;
}


.estilboton{
background: #1b6a87;
padding:  16% 5% 16% 5%;
font-size: 12px;
}


   .funkyradio-info,.pad10_10
   {
     color: black;
   }



.ossn-menu-search li:hover {
   background: #fff !important;
}

   .botonesbuscador3:hover{
   color: #fff;
   cursor: pointer;
   }
   .botonesbuscador{
   background: #0b769c;
   position: relative;
   text-align: center;
   float: left;
   }
   .botonesbuscador2{
   background: #fff;
   position: relative;
   text-align: justify;
   float: left;
   padding: 0% 0% 0% 4%;
   }   
   .botonesbuscador3{
    color: white;
    font-size: 13px;
    margin-top: 50%;
   }
   .mystyle {
   color: red;
   }
   /*estilo de on y off*/
   :root {
   --color-green: #00a878;
   --color-red: #fe5e41;
   --color-button: #fdffff;
   --color-black: #000;
   }
   .switch-button {
   display: inline-block;
   }
   .switch-button .switch-button__checkbox {
   display: none;
   }
   .switch-button .switch-button__label {
   background-color: var(--color-red);
   width: 2.3rem;
   height: 1.5rem;
   border-radius: 3rem;
   display: inline-block;
   position: relative;
   margin-bottom: -3px;
   }
   .switch-button .switch-button__label:before {
   transition: .2s;
   display: block;
   position: absolute;
   width: 1.5rem;
   height: 1.5rem;
   background-color: var(--color-button);
   content: '';
   border-radius: 50%;
   box-shadow: inset 0px 0px 0px 1px var(--color-black);
   }
   .switch-button .switch-button__checkbox:checked + .switch-button__label {
   background-color: var(--color-green);
   }
   .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
   transform: translateX(1rem);
   }
   .estilolabel, .submenues{
   width: 143px;
   text-align: justify;
   }
   .FS13{
   padding-left: 0px;
   }
   /*estilo cheke*/
   input[type=checkbox], input[type=radio] {
   width: 14px;
   height: 14px;
   margin-right: 4px;
   }

   .ossn-page-contents{
      padding: 0% !important;
   }


 .ossn-layout-media .content, .ossn-page-contents {
    border: 0px solid #eee !important;
 }


 .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
    padding-right: 0px !important;
}


.ossn-users-list-item .users-list-controls {
    margin-top: 0px !important;
}

.ossn-lamvvmal-item{
	padding: 2%;
}

::-webkit-scrollbar {
    width: 4px !important;
}


.valorint{
    font-size: 13px;
    color: #0b769c;
    width: 88%;
    font-weight: bold;
    text-align: center;
    text-align: left;
    border-bottom: solid 1px #dadada;
    width: 100%;
    height: 25px;
}


.btn-link:focus, .btn-link:hover {
    text-decoration: none !important;
}

</style>

<?php
echo '</div>';