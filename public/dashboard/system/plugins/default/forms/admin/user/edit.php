<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$user = $params['user'];
?>
<div>
	<label> <?php echo ossn_print('first:name'); ?> </label>
	<input type='text' name="firstname" value="<?php echo $user->firstName; ?>"/>
</div>
<div>
	<label> <?php echo ossn_print('last:name'); ?> </label>
	<input type='text' name="lastname" value="<?php echo $user->lastName; ?>"/>
</div>
<div>
	<label> <?php echo ossn_print('username'); ?>  </label>
	<input type='text' name="username" value="<?php echo $user->username; ?>" style="background:#E8E9EA;" readonly="readonly"/>
</div>
<div>
	<label> <?php echo ossn_print('email'); ?> </label>
	<input type='text' name="email" value="<?php echo $user->email; ?>"/>
</div>
<div>
	<label> <?php echo ossn_print('password'); ?>  </label>
	<input type='password' name="password" value=""/>
</div>
<?php
$fields = ossn_prepare_user_fields($user);
if($fields){
			$vars	= array();
			$vars['items'] = $fields;
			$vars['label'] = true;
			echo ossn_plugin_view('user/fields/item', $vars);
}
?>
<div>
	<label> <?php echo ossn_print('type'); ?> </label>
	<select name="type">
    <?php
    if ($user->type == 'normal') {
        $normal = 'selected';
        $admin = '';
    }
    if ($user->type == 'admin') {
        $admin = 'selected';
        $normal = '';
    }
    ?>
    	<option value="normal" <?php echo $normal; ?>> <?php echo ossn_print('normal'); ?></option>
    	<option value="admin" <?php echo $admin; ?>> <?php echo ossn_print('admin'); ?> </option>
	</select>
</div>

<div>
	<input type="hidden" value="<?php echo $user->username; ?>" name="username"/>
	<input type="submit" class="btn btn-success btn-sm" value="<?php echo ossn_print('save'); ?>"/>
</div>
