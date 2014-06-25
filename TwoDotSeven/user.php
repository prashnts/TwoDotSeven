<?php
namespace TwoDot7\User;
use \TwoDot7\Validate as Validate;
use \TwoDot7\Util as Util;
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
/*
	function __construct($UserName) {
		if(TwoDot7\Validate\Username($UserName)) {
			$DatabaseHandle = new TwoDot7\Database\Handler;
			$UserQuery = "SELECT * FROM 'TwoDot_User' WHERE 'UserName' = :UserName";
			$DatabaseHandle->Query($UserQuery, array('UserName' => $UserName));
		}
		else {
			throw new Exception\BadUserName();
		}
	}*/
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
}

/**
 * Class wrapper for Account Management functions.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 26072014
 * @version	0.0
 */
class Account {
	/**
	 * This function Validates and adds the User.
	 * @internal Requires Validation/.
	 * @param	$SignupData -array- Self Explanatory
	 * @param	$Method -bool- Not Implemented. From __future__
	 * @return	-array- Contains Success status, and Corresponding messages.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 26072014
	 * @version	0.0
	 */
	public static function Add($SignupData, $Method=False) {
		if (isset($SignupData['UserName']) &&
			isset($SignupData['EMail'])	&& 
			isset($SignupData['Password']) &&
			isset($SignupData['ConfPass'])) {

			$Validate = array( 'Success' => True, 'Messages' => array());

			/**
			 * @internal	These checks the validity of the input data.
			 */
			if(!Validate\UserName($SignupData['UserName'], False)) {
				$Validate['Success'] = False;
				array_push($Validate['Messages'], array(
					'Message' => 'The entry for UserName field is not correct. Please try again.', 
					'MessageMode' => 'Error'));
			}
			if(!Validate\EMail($SignupData['EMail'], False)) {
				$Validate['Success'] = False;
				array_push($Validate['Messages'], array(
					'Message' => 'The entry for EMail field is not correct. Please try again.', 
					'MessageMode' => 'Error'));
			}
			if (!Validate\Password($SignupData['Password']) ||
				!Validate\Password($SignupData['ConfPass']) ||
				!($SignupData['Password'] === $SignupData['ConfPass'])) {
				$Validate['Success'] = False;
				array_push($Validate['Messages'], array(
					'Message' => 'The entry for Password fields are not correct. Please try again.', 
					'MessageMode' => 'Error'));
			}

			/**
			 * @internal	These checks the redundancy of the input data.
			 */
			if (Util\Redundant::EMail($SignupData['EMail'])) {
				$Validate['Success']=FALSE;
				array_push($Validate['Messages'], array(
					'Message' => 'The EMail ID is already there in the DataBase, please enter a different one.', 
					'MessageMode' => 'Error'));
			}
			if (Util\Redundant::UserName($SignupData['UserName'])) {
				$Validate['Success']=FALSE;
				array_push($Validate['Messages'], array(
					'Message' => 'The UserName you supplied is taken, please choose a different one.', 
					'MessageMode' => 'Error'));
			}

			if (!$Validate['Success']){
				/**
				 * @internal	Can't add the User Account, Validation error. Stop here.
				 */
				Util\Log("Failed to Add the Account. POST data: ".json_encode($SignupData), "TRACK");
				return $Validate;
			}
			else {
				/**
				 * @internal	Status Cheat: {
				 * 					(-2, Banned Permanently),
				 * 					(-1, Banned Temporarily and Flagged),
				 * 					(0, Never Reviewed),
				 * 					(1, Currently Flagged for Review),
				 * 					(2, Verified But some crutial changes have been made),
				 * 					(4, Verified),
				 * 					(9, Verified + All area access)}
				 * @internal	This adds the User in the Database.
				 */

				$DatabaseHandle = new \TwoDot7\Database\Handler;

				$Query1 = "INSERT INTO _user (UserName, Password, EMail, Hash, Tokens, Status) VALUES (:UserName, :Password, :EMail, :Hash, :Tokens, :Status)";
				$Query2 = "INSERT INTO _usermeta (UserName, Name, Clearance, Meta, MetaAlerts, MetaInfo) VALUES (:UserName, :Name, :Clearance, :Meta, :MetaAlerts, :MetaInfo)";

				$Response = $DatabaseHandle->Query($Query1, array(
					'UserName' => $SignupData['UserName'],
					'Password' => \TwoDot7\Util\PBKDF2::CreateHash($SignupData['Password']),
					'EMail' => $SignupData['EMail'],
					'Hash' => 'NULL',
					'Tokens' => json_encode(array()),
					'Status' => 0))->rowCount();

				$Response += $DatabaseHandle->Query($Query2, array(
					'UserName' => $SignupData['UserName'],
					'Name' => '#',
					'Clearance' => 0,
					'Meta' => json_encode(array()),
					'MetaAlerts' => json_encode(array(
						array(
							'AlertType'	=> 'Info',
							'ID' => md5(strtolower('This is your Notification Panel. It contains everything important, that you need to know.')),
							'Header' => 'Welcome',
							'Content' => 'This is your Notification Panel. It contains everything important, that you need to know.',
							'Dismissed' => False))),
					'MetaInfo' => json_encode(array(
						'Hubs' => array(),
						'Groups' => array()))))->rowCount();

				if ($Response) {
					Util\Log("User Account: ".$SignupData['UserName']." added.");
					// Adding temporary sign-up tracking in Encrypted Log.
					Util\Log("User Account: ".json_encode($SignupData)." added", "TRACK");
					return array(
						'Success' => True, 
						'Messages' => array(
							array(
								'Message' => 'Successfully Completed Sign Up. Please Check your EMail to proceed.',
								'MessageMode' => 'Success')));
				}
				else {
					Util\Log("Failed to Add the Account. 500. POST data: ".json_encode($SignupData), "TRACK");
					return array(
						'Success' => False, 
						'Messages' => array(
							array(
								'Message' => 'Internal Error 500.', 
								'MessageMode' => 'Error')));
				}
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Account::Add");
		}
	}

	public static function Meta($Username, $Mode) {
	}

	public static function Escalate($UserName) {
	}

	public static function RecoverPassword($Data) {
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