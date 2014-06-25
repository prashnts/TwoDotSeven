<?php
namespace TwoDot7\REST;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   
                                  
/**
 * This Invokes and processes the AJAX api calls. 
 * @author Prashant Sinha <prashantsinha@outlook.com>
 * @since 0.0
 */

require_once "apiconfig.php";
require_once "../config.php";
require_once "../inc/cron.php";
require_once "../inc/database.php";
require_once "../inc/exceptions.php";
require_once "../inc/install.php";
require_once "../inc/templatehandler.php";
require_once "../inc/user.php";
require_once "../inc/utility.php";
require_once "../inc/validator.php";

# Parse incoming URI and then process it.
$URI = preg_replace("/[\/]+/", "/", $_SERVER['REQUEST_URI']);
$URIparse = explode('/', $URI);

switch(strtolower(isset($URIparse[2]) ? $URIparse[2] : False)) {
	case 'getqr':
		# Parse URI template: one.ducic.ac.in/dev/getqr/[Encrypted QR Data, padded under serialized array.]
		$_GET = array(
			'Content' => isset($URIparse[3]) ? $URIparse[3] : False,
			'Auth' => isset($URIparse[4]) ? $URIparse[4] : False);
		__initQR();
		break;

	case 'user':
		# Parse URI template: one.ducic.ac.in/dev/user/[username]/[getprofile/[public, private, mini], postprofile]
		$_GET = array(
			'UserName' => isset($URIparse[3]) ? $URIparse[3] : False);
			__initUser();
			break;

	case 'ajax':
		# Parse URI template: one.ducic.ac.in/dev/ajax/[function]
		$_GET = array(	'Function'		=>	isset($URIparse[4]) ? $URIparse[4] : false);
		__initAjax();
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