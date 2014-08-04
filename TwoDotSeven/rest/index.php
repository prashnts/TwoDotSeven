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

require "../../import.php";
_Import('direction.php');
_Import('config.php');
_Import('database.php');
_Import('exceptions.php');
_Import('validator.php');
_Import('utility.php');
_Import('install.php');
_Import('user.php');
_Import('cron.php');
_Import('mailer.php');
require "_REST_Config.php";
require "_REST_Account.php";
require "_REST_Direction.php";
require "_REST_Redundant.php";

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
	*/
	case 'direction':
		$_GET = array(
			'Function' => isset($URIparse[BASE+1]) ? $URIparse[BASE+1] : False,
			'Page' => isset($URIparse[BASE+2]) ? $URIparse[BASE+2] : 1
			);
		Direction\init();
		break;
	case 'echo':
		$Response = array(
			'_POST' => $_POST,
			'_GET' => $_GET,
			'_COOKIES' => $_COOKIE,
			'_SERVER' => $_SERVER,
			'_REQUEST' => $_REQUEST);
			header('HTTP/1.0 200 OK', true, 200);
			header('Content-Type: application/json');
			echo json_encode($Response);
			\TwoDot7\Util\Log(json_encode($Response));
		break;
	case 'redundant':
		/**
		 * @internal	Parse URI template: DOMAIN/dev/exists/[Email, Username]
		 */
		$_GET = array(
			'Function' => isset($URIparse[BASE+1]) ? $URIparse[BASE+1] : False
			);
		Redundant\init();
		break;

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