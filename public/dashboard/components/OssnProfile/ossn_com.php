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
define('__OSSN_PROFILE__', ossn_route()->com . 'OssnProfile/');
require_once(__OSSN_PROFILE__ . 'classes/OssnProfile.php');
/**
 * Initialize Profile Component
 *
 * @return void;
 * @access private
 */
function ossn_profile() {
		//pages
		ossn_register_page('u', 'profile_page_handler');
		ossn_register_page('avatar', 'avatar_page_handler');
		ossn_register_page('cover', 'cover_page_handler');
		//css and js
		ossn_extend_view('css/ossn.default', 'css/profile');
		ossn_extend_view('js/opensource.socialnetwork', 'js/OssnProfile');
		//actions
		if(ossn_isLoggedin()) {
				ossn_register_action('profile/photo/upload', __OSSN_PROFILE__ . 'actions/photo/upload.php');
				ossn_register_action('profile/cover/upload', __OSSN_PROFILE__ . 'actions/cover/upload.php');
				ossn_register_action('profile/cover/reposition', __OSSN_PROFILE__ . 'actions/cover/reposition.php');
				ossn_register_action('profile/edit', __OSSN_PROFILE__ . 'actions/edit.php');
				

				/*ossn_register_menu_item('topbar_dropdown', array(
						'name' => 'account_settings',
						'text' => ossn_print('account:settings'),
						'href' => ossn_loggedin_user()->profileURL('/edit')
				));*/
				
		}
		//callback
		ossn_register_callback('page', 'load:search', 'ossn_search_users_link');
		ossn_register_callback('page', 'load:profile', 'ossn_profile_load_event');
		ossn_register_callback('delete', 'profile:photo', 'ossn_profile_delete_photo_wallpost');
		ossn_register_callback('delete', 'profile:cover:photo', 'ossn_profile_delete_photo_wallpost');
		//show viewallcomments link #871
		ossn_register_callback('comment', 'entityextra:menu', 'ossn_profile_images_allcomments');
		
		//hooks
		ossn_add_hook('newsfeed', "sidebar:left", 'profile_photo_newsefeed', 1);
		ossn_add_hook('profile', 'subpage', 'profile_user_friends');
		ossn_add_hook('search', 'type:users', 'profile_search_handler');
		ossn_add_hook('profile', 'subpage', 'profile_edit_page');
		ossn_add_hook('profile', 'modules', 'profile_modules');
		ossn_add_hook('wall:template', 'profile:photo', 'ossn_wall_profile_photo');
		ossn_add_hook('wall:template', 'cover:photo', 'ossn_wall_profile_cover_photo');
		
		//notifications
		ossn_add_hook('notification:view', 'like:entity:file:profile:photo', 'ossn_notification_like_profile_photo');
		ossn_add_hook('notification:view', 'comments:entity:file:profile:photo', 'ossn_notification_like_profile_photo');
		ossn_add_hook('notification:view', 'like:entity:file:profile:cover', 'ossn_notification_like_profile_cover');
		ossn_add_hook('notification:view', 'comments:entity:file:profile:cover', 'ossn_notification_like_profile_cover');
		
		//subpages of profile
		ossn_profile_subpage('friends');
		ossn_profile_subpage('edit');
		
		if(ossn_isLoggedin()) {


				$user_loggedin = ossn_loggedin_user();
				$icon          = ossn_site_url('components/OssnProfile/images/friends.png');
				ossn_register_sections_menu('newsfeed', array(
						'name' => 'friends',
						'text' => ossn_print('user:friends'),
						'url' => $user_loggedin->profileURL('/friends'),
						'parent' => 'links',
						'icon' => $icon
				));
				


				if (ossn_getrole()=='member'){

				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'accountSettings',
							'href' => ossn_getbaseurl('members/account-settings'),
							'text' => ossn_print('basic:accountsettings'),
				));	

				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'messages',
							'href' => ossn_getbaseurl('messages'),
							'text' => ossn_print('basic:messageswebcam'),
				));	

				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'myfavorites',
							'href' => ossn_getbaseurl('members/favorites'),
							'text' => ossn_print('basic:myfavorites'),
				));

				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'fundsOrTokens',
							'href' => ossn_getbaseurl('members/funds-tokens'),
							'text' => ossn_print('basic:fundsortokens'),
				));


					
				}
			else if(ossn_getrole()=='model'){

				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'profile',
							'href' => ossn_getbaseurl('models/dashboard/profile'),
							'text' => ossn_print('basic:profile'),
				));	

				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'accountSettings',
							'href' => ossn_getbaseurl('models/dashboard/account-settings?action=commissions'),
							'text' => ossn_print('basic:accountsettings'),
				));	

				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'messages',
							'href' => ossn_getbaseurl('models/dashboard/messages'),
							'text' => ossn_print('basic:messageswebcam'),
				));

				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'chatSettings',
							'href' => ossn_getbaseurl('models/dashboard/chat-settings'),
							'text' => ossn_print('basic:chatsettings'),
				));


				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'myfavorites',
							'href' => ossn_getbaseurl('members/favorites'),
							'text' => ossn_print('basic:myfavorites'),
				));

				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'fundsOrTokens',
							'href' => ossn_getbaseurl('members/funds-tokens'),
							'text' => ossn_print('basic:fundsortokens'),
				));



					
				}


				else if(ossn_getrole()=='studio'){

				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'accountSettings',
							'href' => ossn_getbaseurl('studio/account-settings'),
							'text' => ossn_print('basic:accountsettings'),
				));	
					
				}

				else if(ossn_getrole()=='admin'){

				ossn_register_menu_item('topbar_dropdown', array(
							'name' => 'admindashboard',
							'href' => ossn_getbaseurl('admin'),
							'text' => ossn_print('basic:admindashboard'),
				));	
					
				}



		}
}
/**
 * Add users link in search page
 *
 * @return void;
 * @access private
 */
function ossn_search_users_link($event, $type, $params) {
		$url = OssnPagination::constructUrlArgs(array(
				'type'
		));
		ossn_register_menu_link('users', 'search:users', "search?type=users{$url}", 'search');
}
/**
 * Add a timeline, friends tab in profile
 *
 * @return void;
 * @access private;
 */
function ossn_profile_load_event($event, $type, $params) {
		$owner = ossn_user_by_guid(ossn_get_page_owner_guid());
		
		$url   = ossn_site_url();
		ossn_register_menu_link('timeline', 'timeline', $owner->profileURL(), 'user_timeline');
		ossn_register_menu_link('friends', 'friends', $owner->profileURL('/friends'), 'user_timeline');



}
/**
 * Add profile subpage
 *
 * @param string $page Page name
 *
 * @return void;
 */
function ossn_profile_subpage($page) {
		global $VIEW;
		return $VIEW->pagePush[] = $page;
}
/**
 * Check if is in profile sub page
 *
 * @param string $page Page name
 *
 * @return void;
 */
function ossn_is_profile_subapge($page) {
		global $VIEW;
		if(in_array($page, $VIEW->pagePush)) {
				return true;
		}
		return false;
}
/**
 * Add profile friends page
 *
 * @return mixed data
 */
function profile_user_friends($hook, $type, $return, $params) {
		$page = $params['subpage'];
		if($page == 'friends') {
				$user['user'] = $params['user'];
				$friends      = ossn_plugin_view('profile/pages/friends', $user);
				echo ossn_set_page_layout('module', array(
						'title' => ossn_print('friends'),
						'content' => $friends
				));
		}
}

/**
 * Add profile edit page
 *
 * @return mixed data;
 */
function profile_edit_page($hook, $type, $return, $params) {
		$page = $params['subpage'];
		if($page == 'edit') {
				$section 	  = input('section', '', 'basic');
				$user['user'] = $params['user'];
				if($user['user']->guid !== ossn_loggedin_user()->guid) {
						redirect(REF);
				}
				$params = array(
						'action' => ossn_site_url() . 'action/profile/edit',
						'component' => 'OssnProfile',
						'class' => 'ossn-edit-form',
						'params' => $user
				);
				$form   = ossn_view_form('edit', $params, false);
				$params['section']  = $section;
				
				$args['user']    = $user['user'];
				$args['section'] = $section;
				$params['contents'] = ossn_call_hook('profile', 'edit:section', $args, $form);
				echo ossn_plugin_view('profile/edit', $params);
		}
}
/**
 * Add profile search page handler
 *
 * @return string data;
 */

function etnia($params){

	$etniaes[1] = "Afro";
	$etniaes[2] = "Árabe";
	$etniaes[3] = "Asiático";
	$etniaes[4] = "Caribeño(a)";
	$etniaes[5] = "Caucásico(a)";
	$etniaes[6] = "Latino(a)";
	$etniaes[7] = "Otro";
	$consulta = "";
	$condicion = true;
	foreach ($params['etnia'] as $key => $value) {
		if($value == 'on')
		{
			if($condicion)
			{
				$condicional = "";
				$condicion = false;
			}
			else
			{
				$condicional = " and";
			}

			$consul = $etniaes[$key];
			$consulta .= "$condicional (ellaetnia LIKE '$consul%') and (eletnia LIKE '$consul%')";	
		}
	}

	return $consulta;
}


function porpais($params)
{
	$consulta = "";
	$elpais = $params['localidad'];
	if($elpais != 0)
	{

		return $consulta = "(location_id LIKE '$elpais%')";	

	}

	return $consulta;

}



function porfecha($params)
{

	$consulta = "";
	$condicional = "";
	if($params['rangoedad'][1] != "" && $params['rangoedad'][2] != "" ){
		$ano1 = $params['rangoedad'][1];
		$ano2 = $params['rangoedad'][2];
		$consulta .= " ( birthdate BETWEEN '$ano2-01-01' AND '$ano1-12-31')";	
		$condicional = " and ";

	}


	if($params['rangoedad'][1] != "" && $params['rangoedad'][2] == "" ){
		$ano1 = $params['rangoedad'][1];
		$consulta .= "$condicional birthdate < '$ano1-01-01' ";	
		$condicional = " and ";
	}

	if($params['rangoedad'][1] == "" && $params['rangoedad'][2] != "" ){
		$ano2 = $params['rangoedad'][2];
		$consulta .= "$condicional birthdate > '$ano2-12-31' ";	
		$condicional = " and ";
	}


	if($params['rangoedad'][3] != "" && $params['rangoedad'][4] != "" ){
		$ano3 = $params['rangoedad'][3];
		$ano4 = $params['rangoedad'][4];
		$consulta .= "$condicional ( subirthdate BETWEEN '$ano4-01-01' AND '$ano3-12-31')";	
		$condicional = " and ";
	}

	if($params['rangoedad'][3] != "" && $params['rangoedad'][4] == "" ){
		$ano3 = $params['rangoedad'][3];
		$consulta .= "$condicional subirthdate < '$ano3-01-01'";	
		$condicional = " and ";
	}

	if($params['rangoedad'][3] == "" && $params['rangoedad'][4] != "" ){
		$ano4 = $params['rangoedad'][4];
		$consulta .= "$condicional subirthdate > '$ano4-12-31'";	
	}




/*
echo $consulta;
die;*/
	return $consulta;

}

function confoto($params){
	
	$consulta = "";
	if($params['foto'] == 'on'){
	$consulta = "u.smallAvatar IS NOT NULL  and u.avatar IS NOT NULL";	
	}

	return $consulta;
	
}

function estatus($params){
	
	$consulta = "";
	if($params['validado'] == 'on'){
	$consulta = "u.accountStatus = 1";	
	}
	return $consulta;
	
}


function online($params){
	
	$consulta = "";
	if($params['online'] == 'on'){
	$time             = time();
	$intervals = 100;
	$consulta = "last_activity > {$time} - {$intervals}";	
	}

	return $consulta;
	
}


function preferencia($params){
	

	$condicion = true;
	$consulta = "";

	foreach ($params['preferencia'] as $key => $value) {
		
		if($value == 'on')
		{
			if($condicion)
			{
				$condicional = "";
				$condicion = false;
			}
			else
			{
				$condicional = " and";
			}

			$consulta .= "$condicional  PreferenciasPersonas.Preferencias_id = $key ";		

		}

	}


	return $consulta;

	
}


function gustos($params){
	

	$condicional = true;
	$consulta = "";
	foreach ($params['gustos'] as $key => $value) {
		if($value == 'on')
		{
			if($condicional)
			{
				$condicion = "";
				$condicional = false;
			}
			else
			{
				$condicion = " and";
			}

			$consulta .= "$condicion  gustos_personas.gustos_id = $key ";		
		}
	}

	return $consulta;

}

function fisionomiaella($params){

	$fisionomia[1] = "Delgada";
	$fisionomia[2] = "Atletica";
	$fisionomia[3] = "Normal";
	$fisionomia[4] = "Kilos extras";
	$fisionomia[5] = "Relleno(a)";


	$params['fisionomiaella'] = array_filter($params['fisionomiaella']);


	$condicional = true;
	$consulta = "";
	foreach ($params['fisionomiaella'] as $key => $value) {
		if($value == 'on')
		{
			if($condicional)
			{
				$condicion = "";
				$condicional = false;
			}
			else
			{
				$condicion = " and";
			}
			$consulta .= "$condicion  u.ellafionomia = '".$fisionomia[$key]."' ";		
		}
	}

	return $consulta;

	
}

function gender($params){

	
	$condicion = true;
	$consulta = "";

	$gender[1] = "male";
	$gender[2] = "female";
	$gender[3] = "transgender";
	$gender[4] = "pareja";


	foreach ($params['gender'] as $key => $value) {
		
		if($value == 'on')
		{
			if($condicion)
			{
				$condicional = "";
				$condicion = false;
			}
			else
			{
				$condicional = " or";
			}

			$consulta .= "$condicional  u.gender = $key ";		

		}

	}

//die($value);
	return $consulta;
}

function fisionomiael($params){





	$fisionomia[1] = "Delgada";
	$fisionomia[2] = "Atletica";
	$fisionomia[3] = "Normal";
	$fisionomia[4] = "Kilos extras";
	$fisionomia[5] = "Relleno(a)";


	$params['fisionomiael'] = array_filter($params['fisionomiael']);


	$condicional = true;
	$consulta = "";
	foreach ($params['fisionomiael'] as $key => $value) {
		if($value == 'on')
		{
			if($condicional)
			{
				$condicion = "";
				$condicional = false;
			}
			else
			{
				$condicion = " and";
			}
			$consulta .= "$condicion  u.elfisionomia = '".$fisionomia[$key]."' ";		
		}
	}

	return $consulta;

	
}


function experiencia($params){



	$fisionomia[1] = "Delgada";
	$fisionomia[2] = "Atletica";
	$fisionomia[3] = "Normal";
	$fisionomia[4] = "Kilos extras";
	$fisionomia[5] = "Relleno(a)";


	$params['experiencia'] = array_filter($params['experiencia']);


	$condicional = true;
	$consulta = "";
	foreach ($params['experiencia'] as $key => $value) {

		if($value != '')
		{
			if($condicional)
			{
				$condicion = "";
				$condicional = false;
			}
			else
			{
				$condicion = " and";
			}

			$consulta .= "$condicion  u.experiencias = '".$value."' ";		
		}
	}

	return $consulta;

	
}


function alturaella($params){	



	$condicional = true;
	$consulta = "";

	$params['alturaella'] = array_filter($params['alturaella']);
	switch (count($params['alturaella'])) {
	    
	    case 1:
	        $consulta .= "$condicion  u.ellacm >= '".$params['alturaella'][1]." '";
	    break;
	    
	    case 2:
			$consulta .= "$condicion  u.ellacm >= '".$params['alturaella'][1]." '";
			$consulta .= " AND $condicion  u.ellacm <= '".$params['alturaella'][2]." '";
	    break;

	}

	return $consulta;
	
}


function alturael($params){	
	$condicional = true;
	$consulta = "";

	$params['alturael'] = array_filter($params['alturael']);
	switch (count($params['alturael'])) {
	    
	    case 1:
	        $consulta .= "$condicion  u.elcm >= '".$params['alturaella'][1]." '";
	    break;
	    
	    case 2:
			$consulta .= "$condicion  u.elcm >= '".$params['alturaella'][1]." '";
			$consulta .= " AND $condicion  u.elcm <= '".$params['alturaella'][2]." '";
	    break;

	}

	return $consulta;
	
}



function mesclar($consult){

	$condicional = true;
	$sentencia =	"";

	foreach ($consult as $key => $value) {
		
		if(!empty($value))
		{
			if($condicional)
			{
				$condicion = "";
				$condicional = false;
			}
			else
			{
				$condicion = " and";
			}

			$sentencia .= $condicion." ".$value;
		}
	}

return $sentencia;

}



function profile_search_handler($hook, $type, $return, $params) {

	/*aquiiii*/

	
		$consult[1]	 =  etnia($params);
		$consult[2]	 =	porpais($params);
		$consult[3]	 =	porfecha($params);
		$consult[4]	 =	confoto($params);
		$consult[5]	 =	estatus($params);
		$consult[6]  =	preferencia($params);
		$consult[7]  =	gustos($params);
		$consult[8]  =	alturaella($params);

		$consult[9]  =	alturael($params);
		$consult[10] =	fisionomiaella($params);
		$consult[11] =	fisionomiael($params);
		$consult[12] =	online($params);
		$consult[13] =	experiencia($params);
		$consult[14]  =	gender($params);
		$consultacompleta = mesclar($consult);	

		$Pagination    = new OssnPagination;
		$users         = new OssnUser;

 
  

		$data          = $users->searchUsers(array(
				'wheres' => "(CONCAT(u.firstName, ' ', u.lastName, ' ',u.username) LIKE '%{$params['q']}%') $consulta $elpais ",
				'condicionaldos' => $consultacompleta,				
				'condicionalseis' => $consult[7],
				'condicionalcinco' => $consult[6]
		));



		$count         = $users->searchUsers(array(
				'wheres' => "(CONCAT(u.firstName, ' ', u.lastName) LIKE '%{$params['q']}%') $consulta $elpais",
				'count' => true,
				'condicionaldos' => $consultacompleta,
				'condicionalseis' => $consult[7],
				'condicionalcinco' => $consult[6]
		));
		$user['users'] = $data;
		$search        = ossn_plugin_view('output/users', $user);
		$search .= ossn_view_pagination($count);
		if(empty($data)) {
				return ossn_print('ossn:search:no:result');
		}
		return $search;
}
/**
 * Add modules to profile page
 *
 * @return modules;
 */
function profile_modules($h, $t, $module, $params) {
		$user['user'] = $params['user'];
		
		// didn't part of initial release , so in next release we will add
		/*$content = ossn_view("components/OssnProfile/modules/about", $user);
		$modules[] = ossn_view_widget('profile/widget', 'ABOUT', $content);*/
		
		$content = ossn_plugin_view("profile/modules/friends", $user);
		$title   = ossn_print('friends');
		
		$modules[] = ossn_view_widget(array(
				'title' => $title,
				'contents' => $content
		));
		
		return $modules;
}
/**
 * Add user profile picture on sidebar of newsfeed
 *
 * @return mixed data;
 */
function profile_photo_newsefeed($hook, $type, $return) {
		$return[] = ossn_plugin_view('profile/newsfeed/info');
		return $return;
}
/**
 * Profile page handler
 *
 * @return false|null data;
 */
function profile_page_handler($page) {
		$user = ossn_user_by_username($page[0]);
		if(empty($user->guid)) {
				ossn_error_page();
		}
		ossn_set_page_owner_guid($user->guid);
		ossn_trigger_callback('page', 'load:profile');
		
		$params['user'] = $user;
		$params['page'] = $page;
		if(isset($page[1])) {
				$params['subpage'] = $page[1];
		} else {
				$params['subpage'] = '';
		}
		if(!ossn_is_profile_subapge($params['subpage']) && !empty($params['subpage'])) {
				return false;
		}
		$title               = $user->username;
		$vars                = array(
				'user' => $user
		);
		$content             = ossn_plugin_view('profile/pages/profile', $params);
		$contents['content'] = ossn_call_hook('profile', 'load:content', $vars, $content);
		$content             = ossn_set_page_layout('contents', $contents);
		echo ossn_view_page($title, $content);
}
/**
 * Get user default profile photo guid
 *
 * @return bool
 */
function get_profile_photo_guid($guid) {
		$photo             = new OssnFile;
		$photo->owner_guid = $guid;
		$photo->type       = 'user';
		$photo->subtype    = 'profile:photo';
		$photos            = $photo->getFiles();
		if(isset($photos->{0}->guid)) {
				return $photos->{0}->guid;
		}
		return false;
}
/**
 * Get user profile photo
 *
 * @return mixed data;
 */
function get_profile_photo($user, $size) {
		if(!$user instanceof OssnUser) {
				return false;
		}
		
		if(isset($size) && array_key_exists($size, ossn_user_image_sizes())) {
				$isize = "{$size}_";
		}
		
		$photo = $user->getProfilePhoto();
		$etag  = $photo->guid . $photo->time_created;
		
		if(isset($photo->time_created)) {
				header("Last-Modified: " . gmdate('D, d M Y H:i:s \G\M\T', $photo->time_created));
		}
		header("Etag: $etag");
		
		if(isset($photo->guid) && isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
				header("HTTP/1.1 304 Not Modified");
				exit;
		}
		
		if(isset($photo->value) && !empty($photo->value)) {
				$datadir = ossn_get_userdata("user/{$user->guid}/{$photo->value}");
				if(!empty($size)) {
						$image   = str_replace('profile/photo/', '', $photo->value);
						$datadir = ossn_get_userdata("user/{$user->guid}/profile/photo/{$isize}{$image}");
				}
		} else {
				$datadir = ossn_default_theme() . "images/nopictures/users/{$size}.jpg";
		}
		$datadir  = ossn_call_hook('profile', 'load:picture', array(
				'user' => $user,
				'size' => $size
		), $datadir);
		$filesize = filesize($datadir);
		header("Content-type: image/jpeg");
		header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
		header("Pragma: public");
		header("Cache-Control: public");
		header("Content-Length: $filesize");
		header("ETag: \"$etag\"");
		readfile($datadir);
		return;
}
/**
 * Get user default cover photo
 *
 * @return string|null data;
 */
function get_cover_photo($user, $params = array()) {
		
		if(!$user instanceof OssnUser) {
				return false;
		}
		$photo = $user->getProfileCover();
		$etag  = $photo->guid . $photo->time_created;
		
		if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
				header("HTTP/1.1 304 Not Modified");
				exit;
		}
		
		if(isset($photo->value)) {
				header("Content-type: image/jpeg");
				header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
				header("Pragma: public");
				header("Cache-Control: public");
				header("ETag: \"$etag\"");
				if(!empty($params[1]) && $params[1] == 1) {
						$datadir = ossn_get_userdata("user/{$user->guid}/{$photo->value}");
						echo ossn_resize_image($datadir, 170, 170, true);
				} else {
						$datadir  = ossn_get_userdata("user/{$user->guid}/{$photo->value}");
						$filesize = filesize($datadir);
						header("Content-Length: $filesize");
						readfile($datadir);
						
				}
				return;
		} else {
				redirect('components/OssnProfile/images/transparent.png');
		}
}
/**
 * Cover page handler
 *
 * @return image
 */
function cover_page_handler($cover) {
		if($cover[0] == 'err1') {
				echo ossn_plugin_view('output/ossnbox', array(
						'title' => ossn_print('profile:cover:err1'),
						'contents' => ossn_print('profile:cover:err1:detail'),
						'callback' => false
				));
				return true;
		}
		if(isset($cover[0])) {
				$user = ossn_user_by_username($cover[0]);
				if(!empty($user->guid)) {
						get_cover_photo($user, $cover);
				}
		} else {
				ossn_error_page();
		}
}
/**
 * Avatar page handler
 *
 * @return image;
 */
function avatar_page_handler($avatar) {
		if(isset($avatar[0])) {
				if(!isset($avatar[1]) && empty($avatar[1])) {
						$avatar[1] = '';
				}
				$user = ossn_user_by_username($avatar[0]);
				if(!empty($user->guid)) {
						get_profile_photo($user, $avatar[1]);
				} else {
						ossn_error_page();
				}
		}
}
/**
 * Template for profile photo like/comment
 *
 * @return string data;
 */
function ossn_notification_like_profile_photo($hook, $type, $return, $params) {
		$notif          = $params;
		$baseurl        = ossn_site_url();
		$user           = ossn_user_by_guid($notif->poster_guid);
		$user->username = "<strong>{$user->username}</strong>";
		$iconURL        = $user->iconURL()->small;
		
		$img = "<div class='notification-image'><img src='".ossn_getimagenes($user->guid,'small')."' /></div>";
		if(preg_match('/like/i', $notif->type)) {
				$type = 'like';
		}
		if(preg_match('/comments/i', $notif->type)) {
				$type = 'comment';
		}
		$type = "<div class='ossn-notification-icon-{$type}'></div>";
		if($notif->viewed !== NULL) {
				$viewed = '';
		} elseif($notif->viewed == NULL) {
				$viewed = 'class="ossn-notification-unviewed"';
		}
		$url               = ossn_site_url("photos/user/view/{$notif->subject_guid}");
		$notification_read = "{$baseurl}notification/read/{$notif->guid}?notification=" . urlencode($url);
		return "<a href='{$notification_read}'>
	       <li {$viewed}> {$img} 
		   <div class='notfi-meta'> {$type}
		   <div class='data'>" . ossn_print("ossn:notifications:{$notif->type}", array(
				$user->username
		)) . '</div>
		   </div></li></a>';
}
function ossn_notification_like_profile_cover($hook, $type, $return, $params) {
		$notif          = $params;
		$baseurl        = ossn_site_url();
		$user           = ossn_user_by_guid($notif->poster_guid);
		$user->username = "<strong>{$user->username}</strong>";
		$iconURL        = $user->iconURL()->small;
		
		$img = "<div class='notification-image'><img src='".ossn_getimagenes($user->guid,'small')."' /></div>";
		if(preg_match('/like/i', $notif->type)) {
				$type = 'like';
		}
		if(preg_match('/comments/i', $notif->type)) {
				$type = 'comment';
		}
		$type = "<div class='ossn-notification-icon-{$type}'></div>";
		if($notif->viewed !== NULL) {
				$viewed = '';
		} elseif($notif->viewed == NULL) {
				$viewed = 'class="ossn-notification-unviewed"';
		}
		$url               = ossn_site_url("photos/cover/view/{$notif->subject_guid}");
		$notification_read = "{$baseurl}notification/read/{$notif->guid}?notification=" . urlencode($url);
		return "<a href='{$notification_read}'>
	       <li {$viewed}> {$img} 
		   <div class='notfi-meta'> {$type}
		   <div class='data'>" . ossn_print("ossn:notifications:{$notif->type}", array(
				$user->username
		)) . '</div>
		   </div></li></a>';
}
/**
 * Template for profile photo created wallpost
 *
 * @return mixed data;
 */
function ossn_wall_profile_photo($hook, $type, $return, $params) {
		return ossn_plugin_view("profile/wall/profile/photo", $params);
}
/**
 * Template for profile cover photo created by ossnwall
 *
 * @return mixed data;
 */
function ossn_wall_profile_cover_photo($hook, $type, $return, $params) {
		return ossn_plugin_view("profile/wall/cover/photo", $params);
}
/**
 * Get profile photo url for wall
 *
 * @return string;
 */
function ossn_profile_photo_wall_url($photo) {
		if($photo) {
				$imagefile = str_replace(array(
						'profile/photo/'
				), '', $photo->value);
				$image     = ossn_site_url("album/getphoto/{$photo->owner_guid}/{$imagefile}?type=1");
				return $image;
		}
		return false;
}
/**
 * Get profile photo url for wall
 *
 * @return string;
 */
function ossn_profile_coverphoto_wall_url($photo) {
		if($photo) {
				$imagefile = str_replace(array(
						'profile/cover/'
				), '', $photo->value);
				$image     = ossn_site_url("album/getcover/{$photo->owner_guid}/{$imagefile}");
				return $image;
		}
		return false;
}
/**
 * Delete wall post if profile photo is deleted
 *
 * @return void;
 */
function ossn_profile_delete_photo_wallpost($callback, $type, $params) {
		$params['photo'] = arrayObject($params['photo']);
		if(isset($params['photo']->guid) && !empty($params['photo']->guid)) {
				$profile = new OssnProfile;
				$profile->deletePhotoWallPost($params['photo']->guid);
		}
}
/** 
 * Show view all comments menu on profile image and cover
 *
 * @param string $callback Name of callback
 * @param string $type A callback type
 * @param array  $params A option values
 * 
 * @return boolean|void
 */
function ossn_profile_images_allcomments($callback, $type, $params) {
		if(class_exists('OssnComments')) {
				ossn_unregister_menu('commentall', 'entityextra');
				switch($params['entity']->subtype) {
						case 'file:profile:photo':
								$url = ossn_site_url("photos/user/view/{$params['entity']->guid}/all_comments");
								break;
						case 'file:profile:cover':
								$url = ossn_site_url("photos/cover/view/{$params['entity']->guid}/all_comments");
								break;
						case 'file:ossn:aphoto':
								$url = ossn_site_url("photos/view/{$params['entity']->guid}/all_comments");
								break;
				}
				$comment = new OssnComments;
				if($comment->countComments($params['entity']->guid, 'entity') > 5 && !$params['full_view']) {
						ossn_register_menu_item('entityextra', array(
								'name' => 'commentall',
								'href' => $url,
								'text' => ossn_print('comment:view:all')
						));
				}
		}
}
ossn_register_callback('ossn', 'init', 'ossn_profile');
