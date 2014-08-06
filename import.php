<?php
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * This file finds and Imports the Submodules.
 * @author Prashant Sinha <prashantsinha@outlook.com>
 * @author Tarun Khajuria <tarunkhajuria42@gmail.com>
 * @since 0.0
 */

/**
 * Function _Import imports selective files.
 * @param	$Name -string- The Module filename.
 * @return	-int- Level where the file was found.
 * @throws	-recovers- Shows the Fatal Error page instead.
 * @author	Prashant Sinha <prashantsinha@outlook.com>
 * @since	v0.0 27062014
 * @version	0.0
 */
function _Import($Name) {
	if (file_exists("TwoDotSeven/$Name")) {
		require_once "TwoDotSeven/$Name";
		return 1;
	}
	elseif (file_exists("TwoDotSeven/inc/$Name")) {
		require_once "TwoDotSeven/inc/$Name";
		return 2;
	}
	elseif (file_exists("../$Name")) {
		require_once "../$Name";
		return 3;
	}
	elseif (file_exists("../inc/$Name")) {
		require_once "../inc/$Name";
		return 4;
	}
	elseif (file_exists("../../inc/$Name")) {
		require_once "../../inc/$Name";
		return 5;
	}
	elseif (file_exists("$Name")) {
		require_once "$Name";
		return 6;
	}
	else {
		require_once $_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php';
		\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
			'Call' => 'Error',
			'ErrorMessageHead' => 'Sorry, there was a Server Error',
			'ErrorMessageFoot' => 'Couldn\'t load some or all the required files.',
			'ErrorCode' => 'ImportError: '.$Name,
			'Code' => 500,
			'Mood' => 'RED'));
		die();
		return 0;
	}
}

function _ImportAll() {

}

?>