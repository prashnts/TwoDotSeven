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
 * @since	v0.0 27072014
 * @version	0.0
 */
function _Import($Name) {
	if (file_exists("TwoDotSeven/$Name")) {
		require "TwoDotSeven/$Name";
		return 1;
	}
	elseif (file_exists("TwoDotSeven/inc/$Name")) {
		require "TwoDotSeven/inc/$Name";
		return 2;
	}
	elseif (file_exists("../$Name")) {
		require "../$Name";
		return 3;
	}
	elseif (file_exists("../inc/$Name")) {
		require "../inc/$Name";
		return 4;
	}
	elseif (file_exists("../../inc/$Name")) {
		require "../../inc/$Name";
		return 5;
	}
	elseif (file_exists("$Name")) {
		require "$Name";
		return 6;
	}
	else {
		require $_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/login.signup.errors.php';
		\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
			'Call' => 'Error',
			'ErrorMessageHead' => 'Sorry, there was a Server Error',
			'ErrorMessageFoot' => 'Couldn\'t load some of the required files.',
			'ErrorCode' => 'ImportError: '.$Name,
			'Code' => 500,
			'Mood' => 'WHITE'));
		die();
		return 0;
	}
}

function _ImportAll() {

}

?>