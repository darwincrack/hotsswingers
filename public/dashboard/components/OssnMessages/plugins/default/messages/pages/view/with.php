<script>
	Ossn.SendMessage(<?php echo $params['user']->guid;?>);
	        $(document).ready(function () {
	            setInterval(function () {
	                Ossn.getMessages('<?php echo $params['user']->username;?>', '<?php echo $params['user']->guid;?>');
	                //Ossn.getRecent('<?php echo $params['user']->guid;?>');
	            }, 5000);
	           	Ossn.message_scrollMove(<?php echo $params['user']->guid;?>);
	  });
</script>
<div class="message-with">
	<div class="message-inner" id="message-append-<?php echo $params['user']->guid; ?>" data-guid='<?php echo $params['user']->guid; ?>' data-a='<?php  echo $params['admin'] == 1 ? '1' : '0'; ?>' data-u='<?php  echo $params['admin'] == 1 ? $params['guid'] : '0'; ?>'>
		<?php
			if(isset($params['countm'])){
					$params['count'] = $params['countm'];	
			}
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

			 					if($params['admin']){

			                        $loggedin_guid = $params['guid'];

			                    }else{

			                        $loggedin_guid = ossn_loggedin_user()->guid;
			                    }

								if($user->guid == $loggedin_guid){
								?>
		<div class="row" id="message-item-<?php echo $message->id ?>">
			<div class="col-md-10 pull-right">
				<div class="message-box-sent text<?php echo $class;?> daaaaaa">
					<?php if($deleted){ ?>

					<span><i class="fa fa-times-circle"></i><?php echo ossn_print('ossnmessages:deleted');?></span>
					

						<?php if($params['admin']){ ?>

							<a class="ossn-message-delete" data-id= '<?php echo $message->id;?>' data-a= '1' data-u= '<?php echo $loggedin_guid;?>'  data-href="<?php echo ossn_site_url("action/message/delete?id={$message->id}&a=1&u=".$loggedin_guid, true);?>"><i class="fa fa-ellipsis-h"></i></a>	

						<?php } else { ?>

							<a class="ossn-message-delete" data-id= '<?php echo $message->id;?>' data-a= '0' data-u= '0' data-href="<?php echo ossn_site_url("action/message/delete?id={$message->id}&a=0&u=0", true);?>"><i class="fa fa-ellipsis-h"></i></a>	

						<?php }?>


								                    
					<?php } else { ?>
					<span><?php echo ossn_call_hook('messages', 'message:smilify', null, ossn_message_print($message->message)); ?></span>
					<div class="time-created"><?php echo ossn_user_friendly_time($message->time);?></div>


					<?php if($params['admin']){ ?>
					<a class="ossn-message-delete" data-id= '<?php echo $message->id;?>' data-a= '1' data-u= '<?php echo $loggedin_guid;?>' data-href="<?php echo ossn_site_url("action/message/delete?id={$message->id}&a=1&u=".$loggedin_guid, true);?>"><i class="fa fa-ellipsis-h"></i></a>	

					<?php } else{ ?>

					<a class="ossn-message-delete" data-id= '<?php echo $message->id;?>' data-a= '0' data-u= '0' data-href="<?php echo ossn_site_url("action/message/delete?id={$message->id}&a=0&u=0", true);?>"><i class="fa fa-ellipsis-h"></i></a>	
					<?php }?>
								
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
					
						<?php if($params['admin']){ ?>

							

						<?php } else{ ?>

							<a class="ossn-message-delete" data-id= '<?php echo $message->id;?>' data-a= '0' data-u= '0' data-href="<?php echo ossn_site_url("action/message/delete?id={$message->id}&a=0&u=0", true);?>"><i class="fa fa-ellipsis-h"></i></a>

						<?php }?>


									                                            
						<?php } else { ?>

						<span><?php echo ossn_call_hook('messages', 'message:smilify', null, ossn_message_print($message->message)); ?></span>
						<div class="time-created"><?php echo ossn_user_friendly_time($message->time);?></div>
					


							<?php if($params['admin']){ ?>

								

							<?php } else{ ?>

								<a class="ossn-message-delete" data-id= '<?php echo $message->id;?>' data-a= '0' data-u= '0' data-href="<?php echo ossn_site_url("action/message/delete?id={$message->id}&a=0&u=0", true);?>"><i class="fa fa-ellipsis-h"></i></a>	

							<?php }?>



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
<?php

	if(!$params['admin']){

		echo ossn_view_form('send', array(
	'component' => 'OssnMessages',
	'class' => 'message-form-form',
	'id' => "message-send-{$params['user']->guid}",
	'params' => $params
), false);

	}


