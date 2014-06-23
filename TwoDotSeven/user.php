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
/**
 * Wrapper for the User Login Related functions.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 23072014
 * @version	0.0
 */
class Login {
	static function User() {
		//
	}
	static function UserStatus() {
		//
	}
	/**
	 * Validates all the Authorization in Login, API calls.
	 * @param	Method: Authorization Method; Either Token, API Key, or Combination of UserName + Password.
	 * @return	Boolean: Authorization status.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 23072014
	 * @version	0.0
	 */
	static function AUTH($Method) {
		
		$Handle = new DatabaseHandle;
		$Query = "SELECT * FROM oneusers WHERE UserName=:UserName";
		$DbResult = $Handle->qQuery(, array('UserName'=>$_COOKIE["UserNameCookie"]))->fetch();
	}
}
function fSetCookie($__Arg="Default") {

	/*
	**	Description: User Authorization.
	**	API Level: Not Applicable. Function for the Web-App only.
	**	Authorization: Not Required, Not an option.
	**	Clearance: Top / Not Vulnerable.
	**	Authored: prashant@ducic.ac.in
	**	Package: CIC One API
	**	First Commit: 03-24-2014
	**	Arguments:	$__Arg: Optional, Defines Return-type.
	*/

	if ( isset($_COOKIE["UserNameCookie"]) && 
		 isset($_COOKIE["UserHashCookie"])) {

		$Handle = new DatabaseHandle;
		$DbResult = $Handle->qQuery("SELECT * FROM oneusers WHERE UserName=:UserName", array('UserName'=>$_COOKIE["UserNameCookie"]))->fetch();
		
		if ($DbResult["Hash"]==$_COOKIE["UserHashCookie"]) {
			if ($__Arg=="Default") {
				return 1;
			}
			elseif ($__Arg=="Clearance") {
				return $DbResult["Clearance"];
			}
			elseif ($__Arg=="UserName") {
				return $DbResult["UserName"];
			}
			else {
				afPutLogEntry ("Bad Argument in function fSetCookie.", DEBUG);
				return 0;
			}
		}
		else {
			afPutLogEntry ("Failed User Query, Bad Cookie. User: ".$_COOKIE["UserNameCookie"], ALERT);
			setcookie("UserNameCookie", "", 1, '/');
			setcookie("UserHashCookie", "", 1, '/');
			return 0;
		}
	}
	else {
		return 0;
	}
}
?>