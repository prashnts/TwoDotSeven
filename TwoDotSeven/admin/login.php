<?php
namespace TwoDot7\Admin\Login;

#  _____                      _____ 
# /__   \__      _____       |___  |      ___     __      _    
#   / /\/\ \ /\ / / _ \         / /      / _ |___/ /_ _  (_)__ 
#  / /    \ V  V / (_) |  _    / /      / __ / _  /  ' \/ / _ \
#  \/      \_/\_/ \___/  (_)  /_/      /_/ |_\_,_/_/_/_/_/_//_/

/**
 * init throws the actual Markup.
 * @param	$Data -array- Override Dataset.
 * @param	$Data['Call'] -string- REQUIRED. Specifies function call.
 * @return	null
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 28062014
 * @version	0.0
 */
function init() {
	if( \TwoDot7\User\Session::Exists()) {
		\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
			'Call' => 'Error',
			'ErrorMessageHead' => 'Wait. You\'re already logged In.',
			'ErrorMessageFoot' => 'You cannot access this page when logged in.',
			'ErrorCode' => 'UserError: Relogin Attempt',
			'Code' => 403,
			'Title' => '403 Unauthorized',
			'Mood' => 'RED'));
		die();
	}
	elseif( isset($_POST["UserName"]) && isset($_POST["Password"])) {
		$Response = \TwoDot7\User\Session::Login(array(
			'UserName' => $_POST['UserName'],
			'Password' => $_POST['Password']));
		if( $Response['Success']) {
			// Set Cookie
			setcookie(
				'Two_7User',
				$Response['UserName'],
				isset($_POST['Remember']) ? time()+(30*24*60*60) : 0,
				'/',
				'',
				False,
				False);
			setcookie(
				'Two_7Hash',
				$Response['Hash'],
				isset($_POST['Remember']) ? time()+(30*24*60*60) : 0,
				'/',
				'',
				False,
				True);
			header('Location: /');
		}
		else {
			\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
				'Title' => 'Please Login',
				'MetaDescription' => 'Login using your TwoDotSeven account to access admin panel.',
				'Call' => 'Login',
				'Brand' => 'Please Login to Proceed',
				'Messages' => $Response['Messages'],
				'Trailer' => 'Use your TwoDotSeven or CIC One account.',
				'Mood' => 'RED'));
		}
	}
	else {
		\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
			'Title' => 'Please Login',
			'MetaDescription' => 'Login using your TwoDotSeven account to access admin panel.',
			'Call' => 'Login',
			'Brand' => 'Please Login to Proceed',
			'Trailer' => 'Use your TwoDotSeven or CIC One account.'));
	}
}