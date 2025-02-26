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
//$sitename = ossn_site_settings('site_name');
$sitelanguage = ossn_site_settings('language');
/*if (isset($params['title'])) {
    $title = $params['title'] . ' : ' . $sitename;
} else {
    $title = $sitename;
}*/
if (isset($params['contents'])) {
    $contents = $params['contents'];
} else {
    $contents = '';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $sitelanguage; ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo ossn_getsettingsite()->title; ?></title>
    <meta name="Description" CONTENT="<?php echo ossn_getsettingsite()->description; ?>"/>
    <meta name="keywords" CONTENT="<?php echo ossn_getsettingsite()->keywords; ?>" />
    
    <link rel="shortcut icon" href="<?php echo ossn_getbaseurl('uploads/'.ossn_getsettingsite()->favicon); ?>" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	
    <?php echo ossn_fetch_extend_views('ossn/endpoint'); ?>
    <?php echo ossn_fetch_extend_views('ossn/site/head'); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo ossn_getbaseurl("css/custom.css");?>?v=13.0" />
    <script src="<?php echo ossn_getbaseurl("js/custom.js");?>?v=2"></script>

    <script>
        <?php echo ossn_fetch_extend_views('ossn/js/head'); ?>
    </script>
   
   <?php echo ossn_getsettingsite()->code_before_head_tag; ?>
   
</head>

<body>
	<div class="ossn-page-loading-annimation">
    		<div class="ossn-page-loading-annimation-inner">
            	<div class="ossn-loading"></div>
            </div>
    </div>

	<div class="ossn-halt ossn-light"></div>
	<div class="ossn-message-box"></div>
	<div class="ossn-viewer" style="display:none"></div>
    
    <div class="opensource-socalnetwork">
    	<?php echo ossn_plugin_view('theme/page/elements/sidebar');?>
    	 <div class="ossn-page-container">
			  <?php echo ossn_plugin_view('theme/page/elements/topbar');?>
          <div class="ossn-inner-page">    
  	  		  <?php echo $contents; ?>
          </div>    
		</div>
    </div>
    <div id="theme-config" class="hidden" data-desktop-cover-height="200" data-minimum-cover-image-width="1040"></div>	
    <?php echo ossn_fetch_extend_views('ossn/page/footer'); ?>     
    <?php echo ossn_getsettingsite()->code_before_body_tag; ?>      
</body>
</html>
