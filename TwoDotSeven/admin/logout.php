<?php
namespace TwoDot7\Admin\Logout;

#  _____                      _____ 
# /__   \__      _____       |___  |      ___     __      _    
#   / /\/\ \ /\ / / _ \         / /      / _ |___/ /_ _  (_)__ 
#  / /    \ V  V / (_) |  _    / /      / __ / _  /  ' \/ / _ \
#  \/      \_/\_/ \___/  (_)  /_/      /_/ |_\_,_/_/_/_/_/_//_/

/**
 * init processes and throws the actual Markup.
 * @param	$Data -array- Override Dataset.
 * @param	$Data['Call'] -string- REQUIRED. Specifies function call.
 * @return	null
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 28072014
 * @version	0.0
 */
function init() {
	if(!\TwoDot7\User\Session::Status(array(
		'UserName' => isset($_COOKIE['Two_7User']) ? $_COOKIE['Two_7User'] : False,
		'Hash' => isset($_COOKIE['Two_7Hash']) ? $_COOKIE['Two_7Hash'] : False))['LoggedIn']) {
		\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
			'Call' => 'Error',
			'ErrorMessageHead' => 'You need to Login First.',
			'ErrorMessageFoot' => 'You cannot access this page without Logging In.',
			'ErrorCode' => 'UserError: Restricted Area Access Attempt',
			'Code' => 403,
			'Title' => '403 Unauthorized',
			'Mood' => 'RED'));
		die();
	}
	else {
		if(\TwoDot7\User\Session::Logout(array(
			'UserName' => isset($_COOKIE['Two_7User']) ? $_COOKIE['Two_7User'] : False,
			'Hash' => isset($_COOKIE['Two_7Hash']) ? $_COOKIE['Two_7Hash'] : False))['Success']) {
			setcookie(
				'Two_7User',
				'Del',
				0,
				'/',
				'',
				False,
				False);
			setcookie(
				'Two_7Hash',
				'Del',
				0,
				'/',
				'',
				False,
				False);
			\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
				'Call' => 'OK',
				'Brand' => 'Successfully Logged Out.',
				'Trailer' => 'You can proceed to login or go back to Home Page.',
				'Title' => 'Logged Out',
				'Mood' => 'GREEN'));
			die();
		}
		else {
			\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
				'Call' => 'Error',
				'ErrorMessageHead' => 'Sorry, there was a Server Error.',
				'ErrorMessageFoot' => 'Please try again.',
				'ErrorCode' => 'ServerError: Logout Failure',
				'Code' => 500,
				'Title' => '500 Server Error',
				'Mood' => 'RED'));
			die();
		}
	}
}