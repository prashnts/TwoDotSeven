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
_Import('bits.php');
require "_REST_Config.php";
require "_REST_Account.php";
require "_REST_Direction.php";
require "_REST_Redundant.php";

# Parse incoming URI and then process it.
$URI = preg_split('/[\/\?]/', preg_replace("/[\/]+/", "/", $_SERVER['REQUEST_URI']));

const BASE = 2;

switch(strtolower(isset($URI[BASE]) ? $URI[BASE] : False)) {
	case 'account':
		/**
		 * @internal	Parse URI template: DOMAIN/dev/account/[add, remove, verify, confirmEmail.]
		 */
		$_GET = array(
			'Function' => isset($URI[BASE+1]) ? $URI[BASE+1] : False);
		Account\init();
		break;

	case 'bit':
	case 'plugin':

		$_GET = array_merge($_GET, array(
			'Bit' => isset($URI[BASE+1]) ? $URI[BASE+1] : False,
			'BitAction' => isset($URI[BASE+2]) ? $URI[BASE+2] : 'init'
			));

		$BitID = $_GET['Bit'];
		try {

			$Bit = new \TwoDot7\Bit\Init($BitID);
			$AutoTokenResponse = $Bit->AutoToken();
			$BiTControllerResponse = $Bit->REST();

			die();
		} catch (\TwoDot7\Exception\InvalidBit $e) {
			header('HTTP/1.0 404 Not Found.', true, 404);
			echo "<pre>";
			echo "This Bit ID is not registered.\n";
			echo "Please contact the Developer.\n";
			echo "</pre>";
			die();
		}

		break;


	case 'direction':
		$_GET = array(
			'Function' => isset($URI[BASE+1]) ? $URI[BASE+1] : False,
			'Page' => isset($URI[BASE+2]) ? $URI[BASE+2] : 1
			);
		Direction\init();
		break;
	case 'echo':
		$Response = array(
			'_POST' => $_POST,
			'_GET' => $_GET,
			'_COOKIES' => $_COOKIE,
			//'_SERVER' => $_SERVER,
			'_REQUEST' => $_REQUEST);

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');
		header('HTTP/1.0 200 OK', true, 200);
		echo json_encode($Response, JSON_PRETTY_PRINT);
		\TwoDot7\Util\Log(json_encode($Response));
		break;
	case 'redundant':
		/**
		 * @internal	Parse URI template: DOMAIN/dev/exists/[Email, Username]
		 */
		$_GET = array(
			'Function' => isset($URI[BASE+1]) ? $URI[BASE+1] : False
			);
		Redundant\init();
		break;

	default:				
		http_response_code(400);
		echo '<pre>';
		echo 'You made an incomplete request to TwoDotSeven api. Please consider reading the API documentation.';
		echo '</pre>';
}

?>