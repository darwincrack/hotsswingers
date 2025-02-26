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
if (isset($params['user']->guid)) { 


	if($params['admin']==1){?>

	<h4 style="text-align: center">Conversaciones de <strong><?php echo ossn_user_by_guid($params['guid'])->username?></strong> </h4>


	<?php }?>

	
<div class="row ossn-messages">


			<div class="col-md-5">
            	      <?php

						if($params['admin']==1){

							$loggedin_user= $params['guid'];
						}else{
							$loggedin_user= ossn_loggedin_user()->guid;

						}

	  					echo ossn_plugin_view('widget/view', array(
							'title' => ossn_print('inbox').' ('.OssnMessages()->countUNREAD(ossn_loggedin_user()->guid).')',
							'href' => ossn_site_url('messages/all'),
							'contents' => ossn_plugin_view('messages/pages/view/recent', $params),
							'class' => 'messages-recent',
												   
						));
						?>
            </div>
            <div class="col-md-7">
            	      <?php
	  					echo ossn_plugin_view('widget/view', array(
							'title' => $params['user']->username,
							'id' => 'message-with-user-widget',
							'data-guid' => $params['user']->guid,							
							'contents' => ossn_plugin_view('messages/pages/view/with', $params),
							'class' => 'messages-with',
						));
						?>
            </div>            
</div>    
<?php } ?>	
