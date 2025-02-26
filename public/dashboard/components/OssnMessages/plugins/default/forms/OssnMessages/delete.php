<div class="ossn-privacy">
<?php




	if($params["admin"] == 1){
		$guid	=	$guid;
		$options = array(
			'all' => ossn_print('ossnmessages:delete:all') . ' ('. ossn_print('ossnmessages:delete:all:note').')');
	}else{
		$guid	=	ossn_loggedin_user()->guid;
		$options = array(
			    'all' => ossn_print('ossnmessages:delete:all') . ' ('. ossn_print('ossnmessages:delete:all:note').')',		   
			    'me' =>  ossn_print('ossnmessages:delete:me') . ' ('. ossn_print('ossnmessages:delete:me:note').')',		   
		);
	}

	if($params['message']->message_to == $guid){
			unset($options['all']);
	}
	if(isset($params['message']->is_deleted) && $params['message']->is_deleted == true){
			unset($options['all']);
	}
	echo ossn_plugin_view('input/radio', array(
			'name' => 'type',
			'value' => 'me',
			'options' => $options,
	));



?>
<input type="hidden" name="id" value="<?php echo $params['message']->id;?>" />
<input type="hidden" name="a" value="<?php echo $params["admin"];?>" />
<input type="hidden" name="u" value="<?php echo $params["guid"];?>" />
<input type="submit" class="hidden" value="<?php echo ossn_print('save');?>" id="ossn-md-edit-save"/>
</div>
