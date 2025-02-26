

<style>
li {
    list-style: none outside none;
}
</style>
<footer>
    <div class="col-md-11">
        <div class="footer-contents">
           <!-- <div class="ossn-footer-menu">
                <?php //echo ossn_view_menu('footer'); ?>
            </div>
            <?php //echo ossn_fetch_extend_views('ossn/page/footer/contents'); ?>
        </div> -->

<?php if ( $_SESSION['LANG'] =='es' or $_SESSION['LANG']==""){
  $idioma  ='';
}else{
 $idioma = $_SESSION['LANG']."/";
}?>

			<div class="ossn-footer-menu">
               <!-- <a class="menu-footer-a_copyrights" href="<?php echo ossn_getbaseurl(''); ?>">© COPYRIGHT implik-2.com</a>
                <a class="menu-footer-about" href="<?php echo ossn_getbaseurl($idioma.'page/acercade'); ?>"><?php echo ossn_print('site:about'); ?></a> 


                <a class="menu-footer-site" href="<?php echo ossn_getbaseurl($idioma.'page/terminosycondiciones'); ?>"><?php echo ossn_print('site:terms'); ?></a>
               
                <a class="menu-footer-privacy" href="<?php echo ossn_getbaseurl($idioma.'page/privacidad'); ?>"><?php echo ossn_print('site:privacy'); ?></a>-->

                <a class="menu-footer-powered" href="https://www.opensource-socialnetwork.org/" style="color:rgb(128, 125, 125) !important;">Powered by the Open Source Social Network.</a>
                            </div>

    </div>
</div>


                            <div class="col-md-12" style="background: #333; color: white; padding: 10px;">
                              
                              <ul class="estiloul darww" style="align-items: center;
                                  justify-content: center; display: flex;
								  flex-direction: inherit;">
                                 
                                   <li>
                                   	<?php echo ossn_print('site:seleccionalenguaje').':'; ?>
                                     
                                   </li>

<?php if ( $_SESSION['LANG'] !='es'):?>

	                               <li class="" style="margin-right: 10px; margin-left: 8px;">
	                                     <a class="back" href="<?php echo ossn_getbaseurl('lang/es'); ?>">
	                                      <img width="30px" height="15px" src='<?php echo ossn_getbaseurl('images/es.jpg'); ?>'>
	                                     </a>
	                              </li>
<?php endif; ?>

<?php if ( $_SESSION['LANG'] !='en'):?>
	                               <li class="" style="margin-right: 10px; margin-left: 8px;">
	                                     <a class="back" href="<?php echo ossn_getbaseurl('lang/en'); ?>">
	                                      <img width="30px" height="15px" src='<?php echo ossn_getbaseurl('images/en.jpg'); ?>'>
	                                     </a>
	                              </li>
<?php endif; ?>
<?php if ( $_SESSION['LANG'] !='fr'):?>
	                               <li class="" style="margin-right: 10px; margin-left: 8px;">
	                                     <a class="back" href="<?php echo ossn_getbaseurl('lang/fr'); ?>">
	                                      <img width="30px" height="15px" src='<?php echo ossn_getbaseurl('images/fr.jpg'); ?>'>
	                                     </a>
	                              </li>
  <?php endif; ?>
                              </ul>
                            </div>


</footer>
