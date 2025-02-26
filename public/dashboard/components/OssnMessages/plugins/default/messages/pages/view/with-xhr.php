<div class="message-with">
	<div class="message-inner" id="message-append-<?php echo $params['user']->guid; ?>" data-guid='<?php echo $params['user']->guid; ?>'  data-a='<?php  echo $params['admin'] == 1 ? '1' : '0'; ?>' data-u='<?php  echo $params['admin'] == 1 ? $params['guid'] : '0'; ?>'>
		<?php
			echo ossn_view_pagination($params['count'], 10, array(
										'offset_name' => 'offset_message_xhr_with',															 
			));
			if ($params['data']) {
			                foreach ($params['data'] as $message) {
			                    $user = ossn_user_by_guid($message->message_from);
								$deleted = false;
								$class = '';
								if(isset($message->is_deleted) && $message->is_deleted == true){
											$deleted = true;
											$class = ' ossn-message-deleted';
								}	

								if ($params['admin']== 1) {
									$user_login = $params['user_login'];

								}else{

									$user_login = ossn_loggedin_user()->guid;

								}


								if($user->guid == $user_login){
								?>
		<div class="row" id="message-item-<?php echo $message->id ?>">
			<div class="col-md-10 pull-right">
				<div class="message-box-sent text<?php echo $class;?>">
					<?php if($deleted){ ?>
					<span><i class="fa fa-times-circle"></i><?php echo ossn_print('ossnmessages:deleted');?></span>
					<a class="ossn-message-delete" data-id= '<?php echo $message->id;?>' data-href="<?php echo ossn_site_url("action/message/delete?id={$message->id}", true);?>"><i class="fa fa-ellipsis-h"></i></a>				                    
					<?php } else { ?>
					<span><?php echo ossn_call_hook('messages', 'message:smilify', null, ossn_message_print($message->message)); ?></span>
					<div class="time-created"><?php echo ossn_user_friendly_time($message->time);?></div>
					<a class="ossn-message-delete" data-id= '<?php echo $message->id;?>' data-href="<?php echo ossn_site_url("action/message/delete?id={$message->id}", true);?>"><i class="fa fa-ellipsis-h"></i></a>				
					<?php } ?>                                            
				</div>
			</div>
		</div>
		<?php	
			} else {
				?>
		<div class="row" id="message-item-<?php echo $message->id ?>">
			<div class="col-md-1">
				<img  class="user-icon" src="<?php echo ossn_getimagenes($user->guid,'small');?>" />
				
			</div>
			<div class="col-md-11 pull-left">
				<div class="message-box-recieved text <?php echo $class;?>">
					<?php if($deleted){ ?>
						<span><i class="fa fa-times-circle"></i><?php echo ossn_print('ossnmessages:deleted');?></span>
					<a class="ossn-message-delete" data-id= '<?php echo $message->id;?>' data-href="<?php echo ossn_site_url("action/message/delete?id={$message->id}", true);?>"><i class="fa fa-ellipsis-h"></i></a>				                                            
						<?php } else { ?>
						<span><?php echo ossn_call_hook('messages', 'message:smilify', null, ossn_message_print($message->message)); ?></span>
						<div class="time-created"><?php echo ossn_user_friendly_time($message->time);?></div>
					<a class="ossn-message-delete" data-id= '<?php echo $message->id;?>' data-href="<?php echo ossn_site_url("action/message/delete?id={$message->id}", true);?>"><i class="fa fa-ellipsis-h"></i></a>				                                            
					<?php } ?>
				</div>
			</div>
		</div>
		<?php
			}
		}
	}
?>
	</div>
</div>