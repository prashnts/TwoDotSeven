<?php
namespace TwoDot7\Exception;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * Exception Classes.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20072014
 * @version	0.0
 */

class BadUserName extends \Exception {
	protected $message = "The User Name provided is not Valid";
}

class AuthError extends \Exception {
	protected $message = "Authentication Failure.";
}

function RenderError() {
	echo "Nope. Database Errors";
	die();
}