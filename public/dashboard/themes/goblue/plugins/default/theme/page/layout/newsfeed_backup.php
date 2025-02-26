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
 
//unused pagebar skeleton when ads are disabled #628 
if(ossn_is_hook('newsfeed', "sidebar:right")) {
    $newsfeed_right = ossn_call_hook('newsfeed', "sidebar:right", NULL, array());
    $sidebar = implode('', $newsfeed_right);
    $isempty = trim($sidebar);
}
//show center:top div only when there is something otherwise on phone it results empty div with padding/whitebg.
if(ossn_is_hook('newsfeed', "center:top")) {
    $newsfeed_center_top = ossn_call_hook('newsfeed', "center:top", NULL, array());
    $newsfeed_center_top = implode('', $newsfeed_center_top);
    $isempty_top         = trim($newsfeed_center_top);
}
?>
<div class="container-fluid">
    <div class="row">
        <?php echo ossn_plugin_view('theme/page/elements/system_messages'); ?>    
        <div class="ossn-layout-newsfeed">
            <div class="col-md-7">
                <?php if(!empty($isempty_top)){ ?>
                <div class="newsfeed-middle-top">
                    <?php echo $newsfeed_center_top; ?>
                </div>
                 <?php } ?>
                <div class="newsfeed-middle">
                    <?php echo $params['content']; ?>
                </div>
            </div>
            <div class="col-md-4">
                


<div class="ossn-layout-module" style="min-height: auto; margin-top: 0;">
    <div class="module-title">
                <div class="title"><?php echo ossn_print('basic:lives'); ?></div>
                <div class="controls"></div>
            </div>
<iframe src="<?php echo ossn_getbaseurl('livesmin')?>"  id="iframelives" width="100%" frameborder="0" scrolling="no" style="border:none;"></iframe>


<a id="lives-btn" href="<?php echo ossn_getbaseurl('lives') ?>"> <?php echo ossn_print('basic:alllives'); ?></a>

</div>





            
                        <?php if(!empty($isempty)){ ?>
                <div class="newsfeed-right">




                    <?php
                        echo $sidebar;
                        ?>                            
                </div>
                        <?php } ?>


<?php $data = ossn_getsettingsite(); ?>
<div class="ossn-widget">

<?php if ($_SESSION['LANG'] =='es'):?>
        <div class="widget-heading"><?php echo $data->BannerHomeTextEs; ?> </div>
<?php  endif; ?>

<?php if ($_SESSION['LANG'] =='en'):?>
        <div class="widget-heading"><?php echo $data->BannerHomeTextEn; ?> </div>
<?php  endif; ?>

<?php if ($_SESSION['LANG'] =='fr'):?>
        <div class="widget-heading"><?php echo $data->BannerHomeTextFr; ?> </div>
<?php  endif; ?>


    <div class="widget-contents">
        
   <div class="row wrap-banner-home">

                    
                    <div class="col-md-6 item">
                        <?php echo ($data->BannerHomeUnoLink != "" ? "<a href='".$data->BannerHomeUnoLink."'  >" : ''); ?> 
                    
                                
                            <?php echo ($data->BannerHomeUno != "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeUno."'  class='img-responsive'>" : ''); ?> 



                        <?php echo ($data->BannerHomeUnoLink != "" ? "</a>" : ''); ?>       
                    </div>

                    <div class="col-md-6 item">
                        <?php echo ($data->BannerHomeDosLink != "" ? "<a href='".$data->BannerHomeDosLink."'  >" : ''); ?> 
                    
                                
                            <?php echo ($data->BannerHomeDos != "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeDos."'  class='img-responsive'>" : ''); ?> 



                        <?php echo ($data->BannerHomeDosLink != "" ? "</a>" : ''); ?>       
                    </div>


                    <div class="col-md-6 item">
                        <?php echo ($data->BannerHomeTresLink != "" ? "<a href='".$data->BannerHomeTresLink."'  >" : ''); ?> 
                    
                                
                            <?php echo ($data->BannerHomeTres!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeTres."'  class='img-responsive' >" : ''); ?> 



                        <?php echo ($data->BannerHomeTresLink != "" ? "</a>" : ''); ?>      
                    </div>


                    <div class="col-md-6 item">
                        <?php echo ($data->BannerHomeCuatroLink != "" ? "<a href='".$data->BannerHomeCuatroLink."'  >" : ''); ?> 
                    
                                
                            <?php echo ($data->BannerHomeCuatro!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeCuatro."'  class='img-responsive' >" : ''); ?> 



                        <?php echo ($data->BannerHomeCuatroLink != "" ? "</a>" : ''); ?>        
                    </div>

                    <div class="col-md-6 item">
                        <?php echo ($data->BannerHomeCincoLink != "" ? "<a href='".$data->BannerHomeCincoLink."'  >" : ''); ?> 
                    
                                
                            <?php echo ($data->BannerHomeCinco!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeCinco."'  class='img-responsive' >" : ''); ?> 



                        <?php echo ($data->BannerHomeCincoLink != "" ? "</a>" : ''); ?>         
                    </div>



                    <div class="col-md-6 item">
                        <?php echo ($data->BannerHomeSeisLink != "" ? "<a href='".$data->BannerHomeSeisLink."'  >" : ''); ?> 
                    
                                
                            <?php echo ($data->BannerHomeSeis!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeSeis."'  class='img-responsive' >" : ''); ?> 



                        <?php echo ($data->BannerHomeSeisLink != "" ? "</a>" : ''); ?>      
                    </div>


                    <div class="col-md-6 item">
                        <?php echo ($data->BannerHomeSieteLink != "" ? "<a href='".$data->BannerHomeSieteLink."'  >" : ''); ?> 
                    
                                
                            <?php echo ($data->BannerHomeSiete!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeSiete."'  class='img-responsive' >" : ''); ?> 



                        <?php echo ($data->BannerHomeSieteLink != "" ? "</a>" : ''); ?>         
                    </div>


                    <div class="col-md-6 item">
                        <?php echo ($data->BannerHomeOchoLink != "" ? "<a href='".$data->BannerHomeOchoLink."'  >" : ''); ?> 
                    
                                
                            <?php echo ($data->BannerHomeOcho!= "" ? "<img src='".ossn_getbaseurl().$data->BannerHomeOcho."'  class='img-responsive' >" : ''); ?> 



                        <?php echo ($data->BannerHomeOchoLink != "" ? "</a>" : ''); ?>      
                    </div>




                </div>


    </div>





            </div>
        </div>
    </div>
    <?php echo ossn_plugin_view('theme/page/elements/footer');?>
</div>
