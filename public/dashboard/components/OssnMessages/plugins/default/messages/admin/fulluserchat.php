<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */?>


<div class="row ossn-messages">
	<div class="messages-recent">
		<div class="col-md-12">
			<div class="widget-contents">
				<div class="messages-from">
					<div class="inner">
					<?php foreach ($params['data'] as $user){

						 $user = ossn_user_by_guid($user->id);?> 

						  <div class="row user-item">
                        	<div onclick="Ossn.redirect('messages/userchat/<?php echo $user->username; ?>');">
								<div class="col-md-2">
 		                               <img class="image" src="<?php echo ossn_getimagenes($user->guid,'small'); ?>"/>

                                       
                         	   </div>    
                         	   <div class="col-md-10 data">
                         	       <div class="name"><?php echo strl($user->username, 17); ?></div>
                            	</div>
                            </div>    
                        </div>

					<?php }?>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>