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
 if(!ossn_loggedin_user()){
	 return;
 }
?>
<div class="newseed-uinfo">
   <!-- <img src="<?php echo ossn_loggedin_user()->iconURL()->small; ?>"/>-->

   <img src="<?php echo ossn_getimagenes(ossn_loggedin_user()->guid,'small'); ?>" width="50" height="50"/>

    <div class="name">
        <a href="<?php echo ossn_loggedin_user()->profileURL(); ?>"><?php echo ossn_loggedin_user()->username; ?></a>

<?php if (ossn_getrole()=='member'){
	$url_perfil = ossn_getbaseurl('members/account-settings');
 }else if(ossn_getrole()=='model'){
	$url_perfil = ossn_getbaseurl('models/dashboard/profile');
 }else if(ossn_getrole()=='studio'){
   $url_perfil = ossn_getbaseurl('studio/account-settings');
 }else if(ossn_getrole()=='admin'){
   $url_perfil = ossn_getbaseurl('admin');
 }


 ?>

        <a class="edit-profile holaa" href="<?php echo $url_perfil; ?>">
            <?php echo ossn_print('edit:profile'); ?></a>
    </div>
</div>
