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
$friends = $params['user']->getFriends(false, array(
		'limit' => 9
));
echo '<div class="ossn-profile-module-friends">';
if($friends) {
		foreach($friends as $friend) {
				$url       = ossn_getimagenes($friend->guid,'small');
				$profile   = $friend->profileURL();
				$user_name = $friend->username;
				echo "<a href='{$profile}'>
          <div class='user-image'>
            <img src='{$url}' title='{$friend->username}'/>
			<div class='user-name'>{$user_name}</div>
		   </div>
       </a>";
		}
} else {
		echo '<h3>' . ossn_print('no:friends') . '</h3>';
}
echo '</div>';
