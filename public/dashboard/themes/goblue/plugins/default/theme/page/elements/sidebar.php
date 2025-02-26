<?php
	if(!ossn_isLoggedin()){
		return;
	}
?>
        <div class="sidebar ">
            <div class="sidebar-contents">

           		 <?php
          			  if (ossn_is_hook('newsfeed', "sidebar:left")) {
                			$newsfeed_left = ossn_call_hook('newsfeed', "sidebar:left", NULL, array());
               				 echo implode('', $newsfeed_left);
            		}
					echo ossn_view_form('search', array(
								'component' => 'OssnSearch',
								'class' => 'ossn-search',
								'autocomplete' => 'off',
								'method' => 'get',
								'security_tokens' => false,
								'action' => ossn_site_url("search"),
					), false);
           		 ?> 




                <div class="row wrap-banner-home visible-xs visible-sm" style="    ">

					<?php $data = ossn_getsettingsite(); ?>
        			<div class="col-md-12 item">
        				<?php echo ($data->BannerHomeUnoLink != "" ? "<a href='".$data->BannerHomeUnoLink."'  >" : ''); ?> 
        			
        						
							<?php echo ($data->BannerHomeUno != "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeUno."'  class='img-responsive' >" : ''); ?> 



        				<?php echo ($data->BannerHomeUnoLink != "" ? "</a>" : ''); ?> 		
        			</div>

         			<div class="col-md-12 item">
        				<?php echo ($data->BannerHomeDosLink != "" ? "<a href='".$data->BannerHomeDosLink."'  >" : ''); ?> 
        			
        						
							<?php echo ($data->BannerHomeDos != "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeDos."'  class='img-responsive' >" : ''); ?> 



        				<?php echo ($data->BannerHomeDosLink != "" ? "</a>" : ''); ?> 		
        			</div>


         			<div class="col-md-12 item">
        				<?php echo ($data->BannerHomeTresLink != "" ? "<a href='".$data->BannerHomeTresLink."'  >" : ''); ?> 
        			
        						
							<?php echo ($data->BannerHomeTres!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeTres."'  class='img-responsive' >" : ''); ?> 



        				<?php echo ($data->BannerHomeTresLink != "" ? "</a>" : ''); ?> 		
        			</div>


         			<div class="col-md-12 item">
        				<?php echo ($data->BannerHomeCuatroLink != "" ? "<a href='".$data->BannerHomeCuatroLink."'  >" : ''); ?> 
        			
        						
							<?php echo ($data->BannerHomeCuatro!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeCuatro."'  class='img-responsive' >" : ''); ?> 



        				<?php echo ($data->BannerHomeCuatroLink != "" ? "</a>" : ''); ?> 		
        			</div>

         			<div class="col-md-12 item">
        				<?php echo ($data->BannerHomeCincoLink != "" ? "<a href='".$data->BannerHomeCincoLink."'  >" : ''); ?> 
        			
        						
							<?php echo ($data->BannerHomeCinco!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeCinco."'  class='img-responsive' >" : ''); ?> 



        				<?php echo ($data->BannerHomeCincoLink != "" ? "</a>" : ''); ?> 		
        			</div>



         			<div class="col-md-12 item">
        				<?php echo ($data->BannerHomeSeisLink != "" ? "<a href='".$data->BannerHomeSeisLink."'  >" : ''); ?> 
        			
        						
							<?php echo ($data->BannerHomeSeis!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeSeis."'  class='img-responsive' >" : ''); ?> 



        				<?php echo ($data->BannerHomeSeisLink != "" ? "</a>" : ''); ?> 		
        			</div>


         			<div class="col-md-12 item">
        				<?php echo ($data->BannerHomeSieteLink != "" ? "<a href='".$data->BannerHomeSieteLink."'  >" : ''); ?> 
        			
        						
							<?php echo ($data->BannerHomeSiete!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeSiete."'  class='img-responsive' >" : ''); ?> 



        				<?php echo ($data->BannerHomeSieteLink != "" ? "</a>" : ''); ?> 		
        			</div>


         			<div class="col-md-12 item">
        				<?php echo ($data->BannerHomeOchoLink != "" ? "<a href='".$data->BannerHomeOchoLink."'  >" : ''); ?> 
        			
        						
							<?php echo ($data->BannerHomeOcho!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeOcho."'  class='img-responsive' >" : ''); ?> 



        				<?php echo ($data->BannerHomeOchoLink != "" ? "</a>" : ''); ?> 		
        			</div>




    			</div>



     <div class="text-center" style="    margin-top: 10px;">
          <?php echo ossn_print('site:seleccionalenguaje').':'; ?>
     </div>

		     <ul class="estiloul" style="align-items: center;
                                  justify-content: center; display: flex;
								  flex-direction: inherit;">

					<?php if ($_SESSION['LANG'] !='es'):?>

						                               <li class="" style="margin-right: 10px; margin-left: 8px;">
						                                     <a class="back" href="<?php echo ossn_getbaseurl('lang/es'); ?>">
						                                      <img width="30px" height="15px" src='<?php echo ossn_getbaseurl('images/es.jpg'); ?>'>
						                                     </a>
						                              </li>
					<?php endif; ?>

					<?php if ($_SESSION['LANG'] !='en'):?>
						                               <li class="" style="margin-right: 10px; margin-left: 8px;">
						                                     <a class="back" href="<?php echo ossn_getbaseurl('lang/en'); ?>">
						                                      <img width="30px" height="15px" src='<?php echo ossn_getbaseurl('images/en.jpg'); ?>'>
						                                     </a>
						                              </li>
					<?php endif; ?>

					<?php if ($_SESSION['LANG'] !='fr'):?>
						                               <li class="" style="margin-right: 10px; margin-left: 8px;">
						                                     <a class="back" href="<?php echo ossn_getbaseurl('lang/fr'); ?>">
						                                      <img width="30px" height="15px" src='<?php echo ossn_getbaseurl('images/fr.jpg'); ?>'>
						                                     </a>
						                              </li>
					  <?php endif; ?>


			</ul>





            </div>
        </div>