<?php
namespace TwoDot7\User;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * Builds a User Handler object. Requires Configuration NameSpace, Database Namespace to Work.
 * Handler is Dynamic and can add Any Attibute dynamically.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20072014
 * @version	0.0
 */
class Handler {
	private $UserCredentials;
	private $UserData;

	function __construct() {
		$DatabaseHandle = new TwoDot7\Database\Handler;
		$UserQuery = "SELECT * FROM 'TwoDot_User'";
		$DatabaseHandle->Query($UserQuery);
		$UserData = pass;
	}

	function __construct($UserName) {
		if(TwoDot7\Validator\UserName($UserName)) {
			$DatabaseHandle = new TwoDot7\Database\Handler;
			$UserQuery = "SELECT * FROM 'TwoDot_User' WHERE 'UserName' = :UserName";
			$DatabaseHandle->Query($UserQuery, array('UserName' => $UserName));
		}
		else {
			throw new \TwoDot7\Exception\BadUserName();
		}
	}
}

class Login {
	static function User() {
		//
	}
	static function UserStatus() {
		//
	}
}

?>