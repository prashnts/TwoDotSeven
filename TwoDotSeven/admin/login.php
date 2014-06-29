<?php
namespace TwoDot7\Admin\Login;

#  _____                      _____ 
# /__   \__      _____       |___  |      ___     __      _    
#   / /\/\ \ /\ / / _ \         / /      / _ |___/ /_ _  (_)__ 
#  / /    \ V  V / (_) |  _    / /      / __ / _  /  ' \/ / _ \
#  \/      \_/\_/ \___/  (_)  /_/      /_/ |_\_,_/_/_/_/_/_//_/

require "views/login.signup.errors.php";

/**
 * init throws the actual Markup.
 * @param	$Data -array- Override Dataset.
 * @param	$Data['Call'] -string- REQUIRED. Specifies function call.
 * @return	null
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 28072014
 * @version	0.0
 */
function init() {
	if()
	\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
		'Title' => 'Please Login',
		'MetaDescription' => 'Login using your TwoDotSeven account to access admin panel.',
		'Call' => 'Login',
		'Brand' => 'Please Login to Proceed',
		'Trailer' => 'Use your TwoDotSeven or CIC One account.'));
}