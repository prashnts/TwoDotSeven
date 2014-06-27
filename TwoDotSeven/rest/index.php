<?php
namespace TwoDot7\REST;
#  _____                      _____                         
# /__   \__      _____       |___  |     ___  ______________
#   / /\/\ \ /\ / / _ \         / /     / _ \/ __/ __/_  __/
#  / /    \ V  V / (_) |  _    / /     / , _/ _/_\ \  / /   
#  \/      \_/\_/ \___/  (_)  /_/     /_/|_/___/___/ /_/    

/**
 * This Invokes and processes the AJAX api calls.
 * @author Prashant Sinha <prashantsinha@outlook.com>
 * @since 0.0
 */

require "../config.php";
require "../inc/cron.php";
require "../inc/database.php";
require "../inc/exceptions.php";
require "../inc/install.php";
require "../inc/mailer.php";
require "../inc/templatehandler.php";
require "../inc/user.php";
require "../inc/utility.php";
require "../inc/validator.php";
require "apiconfig.php";
require "__initAccount.php";

# Parse incoming URI and then process it.
$URI = preg_replace("/[\/]+/", "/", $_SERVER['REQUEST_URI']);
$URIparse = explode('/', $URI);

const BASE = 2;

switch(strtolower(isset($URIparse[BASE]) ? $URIparse[BASE] : False)) {
	case 'account':
		/**
		 * @internal	Parse URI template: DOMAIN/dev/account/[add, remove, verify, confirmEmail.]
		 */
		$_GET = array(
			'Function' => isset($URIparse[BASE+1]) ? $URIparse[BASE+1] : False);
		Account\init();
		break;
	/*
	case 'getqr':
		# Parse URI template: one.ducic.ac.in/dev/getqr/[Encrypted QR Data, padded under serialized array.]
		$_GET = array(
			'Content' => isset($URIparse[BASE+1]) ? $URIparse[BASE+1] : False,
			'Auth' => isset($URIparse[BASE+2]) ? $URIparse[BASE+2] : False);
		__initQR();
		break;

	case 'user':
		# Parse URI template: one.ducic.ac.in/dev/user/[username]/[getprofile/[public, private, mini], postprofile]
		$_GET = array(
			'UserName' => isset($URIparse[BASE+1]) ? $URIparse[BASE+1] : False);
			__initUser();
			break;

	case 'ajax':
		# Parse URI template: one.ducic.ac.in/dev/ajax/[function]
		$_GET = array(	'Function'		=>	isset($URIparse[BASE+2]) ? $URIparse[BASE+2] : false);
		__initAjax();
		break; */

	default:				
		http_response_code(400);
		header('API-Generated-By: The awesome TwoDotSeven API Engine.');
		header('API-Message: Just saying Hi. You have made a request that is incomplete. Please re-check it.');
		header('API-Author: Prashant Sinha');
		echo '<pre>';
		echo 'You made an incomplete request to TwoDotSeven api. Please consider reading the API documentation.';
		echo '</pre>';
}

?>