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

$r = $_SERVER['REQUEST_URI']; 
$r = explode('/', $r);
?>

<div class="text-right">
	 <?php


	if($r[3] == ossn_loggedin_user()->username){
	echo ossn_plugin_view('output/url', array(
										'text' => 'Lista de bloqueados',
										'href' =>  '/dashboard/u/'.ossn_loggedin_user()->username.'/edit?section=blocking',
										'class' => 'userlink',
								));

	} ?>
</div>



<?php $users = $params['users'];
if ($users) {
    foreach ($users as $user) {

    	if ($user->username =="") continue;
      ?>
		<div class="row ossn-users-list-item ossn-lamvvmal-item">
            	<div class="col-md-2 col-sm-2 hidden-xs">
    	        		<img src="<?php echo ossn_getimagenes($user->guid,'large');?>" width="100" height="100"/>
				</div>

                <div class="col-md-10 col-sm-10 col-xs-12">
	    	        <div class="uinfo">
                        <?php
							echo ossn_plugin_view('output/url', array(
									'text' => $user->username,
									'href' =>  $user->profileURL(),
									'class' => 'userlink',
							));						
						?>
        	   		</div>
                    <div class="right users-list-controls">
	                    <?php
						if (ossn_isLoggedIn()) {
							if (ossn_loggedin_user()->guid !== $user->guid) {
                    			if (!ossn_user_is_friend(ossn_loggedin_user()->guid, $user->guid)) {
                        				if (ossn_user()->requestExists(ossn_loggedin_user()->guid, $user->guid)) {
												echo ossn_plugin_view('output/url', array(
													'text' => ossn_print('cancel:request'),
													'href' =>  ossn_site_url("action/friend/remove?cancel=true&user={$user->guid}", true),
													'class' => 'btn btn-danger',
												));
										} else {
												echo ossn_plugin_view('output/url', array(
													'text' => ossn_print('add:friend'),
													'href' =>  ossn_site_url("action/friend/add?user={$user->guid}", true),
													'class' => 'btn btn-primary',
												));		
										}
								} else {
									echo ossn_plugin_view('output/url', array(
													'text' => ossn_print('remove:friend'),
													'href' =>  ossn_site_url("action/friend/remove?user={$user->guid}", true),
													'class' => 'btn btn-danger',
									));	
				
								}
							}
						}
						?>		
                   </div>
               </div>         
        </div>
    <?php
    }

}?>
