<?php
namespace TwoDot7\Admin;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * This Invokes and processes the Admin Views.
 * @author Prashant Sinha <prashantsinha@outlook.com>
 * @since 0.0
 */
require "../../import.php";
_Import('config.php');
_Import('database.php');
_Import('exceptions.php');
_Import('validator.php');
_Import('utility.php');
_Import('install.php');
_Import('user.php');
_Import('cron.php');
_Import('mailer.php');
_Import('meta.php');
_Import('bits.php');
require "login.php";
require "logout.php";
require "register.php";
require "bit.php";
require "broadcast.php";
require "administration.php";

require "views/login.signup.errors.php";
require "views/dash.broadcast.bits.php";

# Parse incoming URI and then process it.
$URI = preg_split('/[\/\?]/', preg_replace("/[\/]+/", "/", $_SERVER['REQUEST_URI']));

const BASE = 2;

switch(strtolower(isset($URI[BASE]) ? $URI[BASE] : False)) {
	case 'login':
	case 'signin':
	case 'signIn':
		Login\init();
		break;

	case 'logout':
		Logout\init();
		break;

	case 'signup':
	case 'signUp':
	case 'register':
		$_GET = array_merge($_GET, array(
			'Action' => isset($URI[BASE+1]) ? $URI[BASE+1] : False,
			'Target' => isset($URI[BASE+2]) ? $URI[BASE+2] : False,
			'Data' => isset($URI[BASE+3]) ? $URI[BASE+3] : False
			));
		Register\init();
		break;

	case 'feed':
	case 'news':
	case 'broadcast':
	case 'broadcasts':
		Broadcast\init();
		break;

	case 'plugin':
	case 'bit':
	case 'bits':
		$_GET = array_merge($_GET, array(
			'Bit' => isset($URI[BASE+1]) ? $URI[BASE+1] : False,
			'BitAction' => isset($URI[BASE+2]) ? $URI[BASE+2] : 'init'
			));
		Bit\init();
		break;

	case 'administration':
	case 'management':
		$_GET = array_merge($_GET, array(
			'Action' => isset($URI[BASE+1]) ? $URI[BASE+1] : False,
			'SubAction' => isset($URI[BASE+2]) ? $URI[BASE+2] : False
			));
		Administration\init();
		break;
	default:
		echo "404";
}