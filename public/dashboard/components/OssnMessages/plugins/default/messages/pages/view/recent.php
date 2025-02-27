 	<div id="get-recent" style="display:none;"></div>


        <div class="messages-from">
            <div class="inner">
                <?php

                if ($params['recent']) {
                    if($params['admin']){

                        $loggedin_guid = $params['guid'];

                    }else{

                        $loggedin_guid = ossn_loggedin_user()->guid;
                    }
                    
			foreach ($params['recent'] as $message){
			$yes_replied = false;
						
			$actual_to = $message->message_to;
			$actual_from = $message->message_from;

			if($message->message_from == $loggedin_guid){
				$message->message_from = $actual_to;
				$yes_replied = true;
			}
			//if answered and is message from loggedin user 
			//as of 5.3 it shows message form owner too so old logic need to be changed
                        if ($message->answered && $message->message_from == $loggedin_guid || $yes_replied) {
                            $user = ossn_user_by_guid($message->message_from);
                            $text = ossn_call_hook('messages', 'message:smilify', null, strl($message->message, 32));
							$replied = ossn_print('ossnmessages:replied:you', array($text));
							if($message->is_deleted == true){
								$replied = ossn_print('ossnmessages:deleted');	
							}
                            $replied = "<i class='fa fa-reply'></i><div class='reply-text'>{$replied}</div>";
                        } else {
                            $user = ossn_user_by_guid($message->message_from);
                            $text = ossn_call_hook('messages', 'message:smilify', null, strl($message->message, 32));
							if($message->is_deleted == true){
								$text = ossn_print('ossnmessages:deleted');	
							}							
                            $replied = "<div class='reply-text-from'>{$text}</div>";
                        }
                        if ($message->viewed == 0 && $actual_from !== $loggedin_guid) {
                            $new = 'message-new';
                        } else {
                            $new = '';
                        }
                        ?>
                        <div class="row user-item <?php echo $new; ?>">

                            <?php if($params['admin']){ ?>

                                <div onclick="Ossn.redirect('messages/userchatsolo/<?php echo $loggedin_guid; ?>/<?php echo $user->username; ?>');">

                            <?php }else{ ?>

                            <div onclick="Ossn.redirect('messages/message/<?php echo $user->username; ?>');">


                           <?php  }?>
                        	
								<div class="col-md-2">
 		                               <img class="image" src="<?php echo ossn_getimagenes($user->guid,'small'); ?>"/>

                                       
                         	   </div>    
                         	   <div class="col-md-10 data">
                         	       <div class="name"><?php echo strl($user->username, 17); ?></div>
                         	       <div class="time time-created"><?php echo ossn_user_friendly_time($message->time); ?> </div>
                         	       <div class="reply"><?php echo $replied; ?></div>
                            	</div>
                            </div>    
                        </div>
                    <?php
                    }

                }
		echo ossn_view_pagination($params['count_recent'], 10, array(
			'offset_name' => 'offset_message_xhr_recent',															 
		));
		?>		    
            </div>
        </div>
