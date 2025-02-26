<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
define('OSSN_ALLOW_SYSTEM_START', TRUE);
require_once('system/start.php');
//page handler
$handler = input('h');
//page name
$page = input('p');




//check if there is no handler then load index page handler
if (empty($handler)) {

	if(!ossn_isLoggedin()){

		// unset cookies
		if (isset($_SERVER['HTTP_COOKIE'])) {
		    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		    foreach($cookies as $cookie) {
		        $parts = explode('=', $cookie);
		        $name = trim($parts[0]);
		        setcookie($name, '', time()-1000);
		        setcookie($name, '', time()-1000, '/');
		    }
		}

		setcookie('PHPSESSID', false);
		setcookie('laravel_session', false);

		$url =ossn_getbaseurl('models/logout');

		//$url= $Ossn->primaryurl;
		header("Location: {$url}");
	}

    $handler = 'index';
}



if(ossn_getrole()==""){
		$url =ossn_getbaseurl('models/logout');

		header("Location: {$url}");
}

echo ossn_load_page($handler, $page);


