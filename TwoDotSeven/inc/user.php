<?php
namespace TwoDot7\User;
use \TwoDot7\Validate as Validate;
use \TwoDot7\Util as Util;
use \TwoDot7\Mailer as Mailer;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * Class wrapper for Account Management functions.
 * Implements Add, Escalate.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20140626
 * @version	0.0
 */
class Account {
	/**
	 * Creates a User Account, in the _user Table. Fires up the Mailer class to send out verification email.
	 * @internal Requires Validation/.
	 * @param	$SignupData array Self Explanatory
	 * @param	$Method bool Not Implemented. From __future__
	 * @return	array Contains Success status, and Corresponding messages.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140626
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
					'Class' => 'ERROR'));
			}
			if(!Validate\EMail($SignupData['EMail'], False)) {
				$Validate['Success'] = False;
				array_push($Validate['Messages'], array(
					'Message' => 'The entry for EMail field is not correct. Please try again.', 
					'Class' => 'ERROR'));
			}
			if (!Validate\Password($SignupData['Password']) ||
				!Validate\Password($SignupData['ConfPass']) ||
				!($SignupData['Password'] === $SignupData['ConfPass'])) {
				$Validate['Success'] = False;
				array_push($Validate['Messages'], array(
					'Message' => 'The entry for Password fields are not correct. Please try again.', 
					'Class' => 'ERROR'));
			}

			/**
			 * @internal	These checks the redundancy of the input data.
			 */
			if (Util\Redundant::EMail($SignupData['EMail'])) {
				$Validate['Success']=FALSE;
				array_push($Validate['Messages'], array(
					'Message' => 'The EMail ID is already there in the DataBase, please enter a different one.', 
					'Class' => 'ERROR'));
			}
			if (Util\Redundant::UserName($SignupData['UserName'])) {
				$Validate['Success']=FALSE;
				array_push($Validate['Messages'], array(
					'Message' => 'The UserName you supplied is taken, please choose a different one.', 
					'Class' => 'ERROR'));
			}

			if (!$Validate['Success']){
				/**
				 * @internal	Can't add the User Account, Validation error. Stop here.
				 */
				Util\Log("Failed to Add the Account. POST data: ".json_encode($SignupData), "TRACK");
				return $Validate;
			}
			else {

				$DatabaseHandle = new \TwoDot7\Database\Handler;

				$Query1 = "INSERT INTO _user (UserName, Password, EMail, Hash, Tokens, Status, Preferences) VALUES (:UserName, :Password, :EMail, :Hash, :Tokens, :Status, :Preferences)";

				$Response = $DatabaseHandle->Query($Query1, array(
					'UserName' => $SignupData['UserName'],
					'Password' => \TwoDot7\Util\PBKDF2::CreateHash($SignupData['Password']),
					'EMail' => $SignupData['EMail'],
					'Hash' => json_encode(array()),
					'Tokens' => json_encode(array()),
					'Status' => 0,
					'Preferences' => json_encode(array())
					)
				)->rowCount();
				
				if ($Response) {
					Util\Log("User Account: ".$SignupData['UserName']." added.");
					// Adding temporary sign-up tracking in Encrypted Log.
					Util\Log("User Account: ".json_encode($SignupData)." added", "TRACK");

					// Generate the Next Step URI, and Send an EMail.
					$ConfirmationCode = Util\Crypt::CodeGen($SignupData['UserName']);
					$EMailURI = BASEURI.'/twodot7/register/confirmEmail/'.$SignupData['UserName'].'/'.Util\Crypt::Encrypt(json_encode(array(
						'UserName' => $SignupData['UserName'],
						'ConfirmationCode' => $ConfirmationCode)));

					$NextURI = '/twodot7/register/confirmEmail/'.$SignupData['UserName'];

					Mailer\Send(array(
						'To' => $SignupData['EMail'],
						'From' => 'Account',
						'TemplateID' => 'ConfirmEmail',
						'Data' => array(
							'UserName' => $SignupData['UserName'],
							'ConfirmationCode' => $ConfirmationCode,
							'EMailURI' => $EMailURI)));

					return array(
						'Success' => True, 
						'Messages' => array(
							array(
								'Message' => 'Successfully Completed Sign Up. Please Check your EMail to proceed.',
								'MessageMode' => 'Success')),
						'Next' => $NextURI);
				}
				else {
					Util\Log("Failed to Add the Account. 500. POST data: ".json_encode($SignupData), "TRACK");
					return array(
						'Success' => False, 
						'Messages' => array(
							array(
								'Message' => 'Internal Error 500.', 
								'Class' => 'ERROR')));
				}
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Account::Add");
		}
	}

	/**
	 * Changes the User's Password.
	 * @param	$Data -array- Old Password, New Password, Confirm New Password.
	 * @return	-array- Contains Success status, and Corresponding messages.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140703
	 * @version	0.0
	 */
	public static function ChangePassword($Data) {
		if( isset($Data['UserName']) &&
			isset($Data['Old_Password']) &&
			isset($Data['New_Password']) &&
			isset($Data['Conf_Password'])) {

			if (!Validate\Password($Data['New_Password']) ||
				!Validate\Password($Data['Conf_Password']) ||
				!($Data['New_Password'] === $Data['Conf_Password'])) {
				return array(
					'Success' => False,
					'Messages' => array(
						array(
							'Message' => 'The entry for Password fields are not correct. Please try again.', 
							'Class' => 'ERROR')));
			}

			$DatabaseHandle = new \TwoDot7\Database\Handler;
			$DBResponse = $DatabaseHandle->Query("SELECT * FROM _user WHERE UserName=:UserName", array(
				'UserName' => $Data['UserName']))->fetch();

			if($DBResponse) {
				/**
				 * @internal	This Block means that the UserName is valid and Existing. We'll check for Password now.
				 */
				if(\TwoDot7\Util\PBKDF2::ValidatePassword($Data['Old_Password'], $DBResponse['Password'])) {
					$DatabaseHandle->Query("UPDATE _user SET Password=:Password WHERE UserName=:UserName", array(
						'Password' => \TwoDot7\Util\PBKDF2::CreateHash($Data['New_Password']),
						'UserName' => $Data['UserName']));
					return array(
						'Success' => True);
				}
				else {
					return array(
						'Success' => False,
						'Messages' => array(
							array(
								'Message' => 'Invalid UserName or Password.',
								'Class' => 'ERROR')));
				}
			}
			else {
				return array(
					'Success' => False);
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Access::Add");
		}
	}

	/**
	 * Confirms the User's EMail ID.
	 * @param	$Data -array- Username, and ConfirmationCode.
	 * @return	-array- Contains Success status, and Corresponding messages.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140703
	 * @version	0.0
	 */
	public static function ConfirmEmail($Data) {
		if( isset($Data['UserName']) &&
			isset($Data['ConfirmationCode'])) {

			if (!Validate\UserName($Data['UserName'])) {
				return array(
					'Success' => False,
					'Messages' => array(
						array(
							'Message' => 'The entry for UserName field is not correct. Please try again.', 
							'Class' => 'ERROR')));
			}

			if (Util\Crypt::EagerCompare(
				$Data['ConfirmationCode'],
				Util\Crypt::CodeGen($Data['UserName']))) {

				$Response = Status::EMail($Data['UserName'], array(
					'Action' => 'SET',
					'Status' => 1)); // Confirms the Email ID.

				$Hook = $Response['Success'];

				if ($Hook)
					return array(
						'Success' => True,
						'Message' => array(
							array(
								'Message' => 'Action Completed Succesfully.',
								'Class' => 'INFO')));
				else
					return array(
						'Success' => False,
						'Message' => array(
							array(
								'Message' => 'Couldn\'t Complete the action.',
								'Class' => 'INFO')));
			}
			else {
				return array(
					'Success' => False,
					'Messages' => array(
						array(
							'Message' => 'Invalid Confirmation Code. Please try again.',
							'Class' => 'ERROR')));
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Access::ConfirmEmail");
		}	
	}

	/**
	 * Deletes a User Account.
	 * @param	$UserName -string- The Username.
	 * @return	Boolean Success Status.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140815
	 * @version	0.0
	 */
	public static function Remove($UserName) {
		if (isset($UserName)) {

			if (Access::Check(array(
				'UserName' => $UserName,
				'Domain' => 'SYSADMIN'
				))) {
				return False;
			}

			$DatabaseHandle = new \TwoDot7\Database\Handler;
			$DBResponse = $DatabaseHandle->Query("DELETE FROM _user WHERE UserName=:UserName", array(
				'UserName' =>$UserName
				))->rowCount();

			return (bool)$DBResponse;
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Account::Remove");
		}
	}
}

/**
 * TODO
 */
class Activity {
	// TODO!
	public static function Add() {
		// TODO.
	}
	public static function DetectUnusualActivity() {
		// Todo. Will Ask for CAPTCHA validation. Will Inform the User.
	}
	public static function Find() {
		// TODO.
	}
	public static function Modify() {
		// TODO.
	}
	public static function Remove() {
		// TODO.
	}
}

/**
 * Class wrapper for User Access controls.
 * Implements Add, Check, Get, Revoke.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20140701
 * @version	0.0
 */
class Access {
	/**
	 * Caches the Token data, upon first call of any function.
	 */
	private static $TokenCache = False;

	/**
	 * Caches the UserName of Last call. Helps validate $TokenCache.
	 */
	private static $LastUser = False;

	/**
	 * This function Adds Access Token.
	 * @param	$Data -array- UserName and Domain token are sent to it.
	 * @return	-bool- Indicates success or failure.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140701
	 * @version	0.0
	 */
	public static function Add($Data) {
		if( isset($Data['UserName']) &&
			isset($Data['Domain'])) {

			/**
			 * @internal	This deletes the Cache. Cache is re-generated when the ::Check() is called.
			 */ 
			self::$TokenCache = False;
			self::$LastUser = False;

			$Data['Domain'] = preg_replace('/[^A-Za-z0-9_\-\+.]/', "", $Data['Domain']);

			$DatabaseHandle = new \TwoDot7\Database\Handler;
			$DBResponse = $DatabaseHandle->Query("SELECT * FROM _user WHERE UserName=:UserName", array(
				'UserName' => $Data['UserName']))->fetch();
			if($DBResponse) {
				/**
				 * @internal	This Block means that the UserName is valid and Existing.
				 */
				if(Util\Token::Exists(array(
					'JSON' => $DBResponse['Tokens'] ? $DBResponse['Tokens'] : False,
					'Token' => $Data['Domain']))) {
					/**
					 * @internal	Key Already exists. Saves additional DB Query.
					 */
					return True;
				}
				// Else
				if($DatabaseHandle->Query("UPDATE _user SET Tokens=:Tokens WHERE UserName=:UserName;", array(
					'Tokens' => Util\Token::Add(array(
						'JSON' => $DBResponse['Tokens'] ? $DBResponse['Tokens'] : False,
						'Token' => $Data['Domain'])),
					'UserName' => $Data['UserName']))) {
					return True;
				}
				else {
					return False;
				}
			}
			else {
				return False;
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Access::Add");
		}
	}

	/**
	 * This function Checks for existence of Access Token.
	 * @param	$Data -array- UserName and Domain token are sent to it.
	 * @return	-bool- Indicates success or failure.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140701
	 * @version	0.0
	 */
	public static function Check($Data) {
		if( isset($Data['UserName']) &&
			isset($Data['Domain'])) {
			if( self::$TokenCache && $Data['UserName'] === self::$LastUser) {
				return Util\Token::Exists(array(
					'JSON' => self::$TokenCache ? self::$TokenCache : False,
					'Token' => $Data['Domain']));
			}
			else {
				$TokensJSON = \TwoDot7\Database\Handler::Exec("SELECT * FROM _user WHERE UserName=:UserName", array(
					'UserName' => $Data['UserName']))->fetch()['Tokens'];
				
				self::$TokenCache = $TokensJSON;
				self::$LastUser = $Data['UserName'];

				return Util\Token::Exists(array(
					'JSON' => $TokensJSON ? $TokensJSON : False,
					'Token' => $Data['Domain']));
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Access::Check");
		}
	}

	/**
	 * This function returns the full token array.
	 * @param	$Data -array- UserName is sent to it.
	 * @return	-array- Token Array.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140701
	 * @version	0.0
	 */
	public static function Get($Data) {
		if( isset($Data['UserName'])) {
			$TokensJSON = \TwoDot7\Database\Handler::Exec("SELECT * FROM _user WHERE UserName=:UserName", array(
				'UserName' => $Data['UserName']))->fetch()['Tokens'];
			return Util\Token::Get(array(
				'JSON' => $TokensJSON ? $TokensJSON : False));
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Access::Get");
		}
	}

	/**
	 * This function Removes Access Token.
	 * @param	$Data -array- UserName and Domain token are sent to it.
	 * @return	-bool- Indicates success or failure.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140701
	 * @version	0.0
	 */
	public static function Revoke($Data) {
		if( isset($Data['UserName']) &&
			isset($Data['Domain'])) {

			/**
			 * @internal	This deletes the Cache. Cache is re-generated when the ::Check() is called.
			 */ 
			self::$TokenCache = False;
			self::$LastUser = False;

			$DatabaseHandle = new \TwoDot7\Database\Handler;
			$DBResponse = $DatabaseHandle->Query("SELECT * FROM _user WHERE UserName=:UserName", array(
				'UserName' => $Data['UserName']))->fetch();
			if($DBResponse) {
				/**
				 * @internal	This Block means that the UserName is valid and Existing.
				 */
				if(!Util\Token::Exists(array(
					'JSON' => $DBResponse['Tokens'] ? $DBResponse['Tokens'] : False,
					'Token' => $Data['Domain']))) {
					/**
					 * @internal	Key Doesnt Exists. Saves additional DB Query.
					 */
					return True;
				}
				// Else
				if($DatabaseHandle->Query("UPDATE _user SET Tokens=:Tokens WHERE UserName=:UserName;", array(
					'Tokens' => Util\Token::Remove(array(
						'JSON' => $DBResponse['Tokens'] ? $DBResponse['Tokens'] : False,
						'Token' => $Data['Domain'])),
					'UserName' => $Data['UserName']))) {
					return True;
				}
				else {
					return False;
				}
			}
			else {
				return False;
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Access::Revoke");
		}
	}

	/**
	 * This function Finds the SysAdmin. Best case: O(1), Worst Case: O(2n)
	 * @return	mixed Contains Username, Email and User ID.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 20140806
	 * @version	0.0
	 */
	public static function SysAdmin() {
		# 1. UserID 1 should be the Super User.
		# 2. Don't give up if 1 is not the Super User. Check ALL the users until Super User is found.

		$SysAdminCandidate = \TwoDot7\Database\Handler::Exec("SELECT * FROM _user WHERE ID=1 LIMIT 1")->fetch();

		if (self::Check(array(
			'UserName' => $SysAdminCandidate['UserName'],
			'Domain' => 'SYSADMIN'))) {
			return array(
				'ID' => 1,
				'UserName' => $SysAdminCandidate['UserName'],
				'EMail' => $SysAdminCandidate['EMail'],
				);
		}
		else {
			$Hook = \TwoDot7\Database\Handler::Exec("SELECT * FROM _user");
			while (True) {
				$SysAdminCandidate = $Hook->fetch();
				if (!is_array($SysAdminCandidate)) break;
				if (self::Check(array(
					'UserName' => $SysAdminCandidate['UserName'],
					'Domain' => 'SYSADMIN'))) {
					return array(
						'ID' => $SysAdminCandidate['ID'],
						'UserName' => $SysAdminCandidate['UserName'],
						'EMail' => $SysAdminCandidate['EMail'],
						);
				}
			}
			Util\Log('NO SUPER USER FOUND!', 'ALERT');
			if (!function_exists('\TwoDot7\Admin\Template\Login_SignUp_Error\_init')) {
				require_once $_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php';
				\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
					'Call' => 'Error',
					'ErrorMessageHead' => 'Sorry, there was a Server Error',
					'ErrorMessageFoot' => 'SysAdmin Account not found or DB error.',
					'ErrorCode' => 'Fatal: SysAdmin not found.',
					'Code' => 500,
					'Mood' => 'RED'
					));
				die();
			}
			else {
				\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
					'Call' => 'Error',
					'ErrorMessageHead' => 'Sorry, there was a Server Error',
					'ErrorMessageFoot' => 'SysAdmin Account not found or DB error.',
					'ErrorCode' => 'ImportError: '.$Name,
					'Code' => 500,
					'Mood' => 'RED'
					));
				die();
			}
		}
	}
}

class Meta {

	function __construct($UserName = False) {
		// Pseudo 
	}

	public static function User() {
		return array('');
	}

	public static function Get () {

	}
}

/**
 * Class wrapper for User specific Preferences.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20140701
 * @version	0.0
 */
class Preferences {

	/**
	 * Stores the current instance of Preference.
	 */
	private static $Preferences = False;

	/**
	 * Stores the name of External apps, Using TwoDot7 as a OAUTH login.
	 * @param	String $App Required. Name of the External App.
	 * @param	String $Action Optional. Specifies the Action to be taken. Must be one of these values:
	 *			"GET" - Default. Checks if an App is already used by the User.
	 *			"ADD" - Adds an External App.
	 *			"REMOVE" - Removes the External App.
	 * @return	Boolean
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 20140824
	 * @version	0.0
	 */
	public static function ExternalApp($App, $Action = "GET") {
		if (!Session::Exists()) return False;
		if (!self::UnpackPreferences(Session::Data()['UserName'])) return False;
		if (!isset(self::$Preferences['ExternalApp'])) self::$Preferences['ExternalApp'] = array();
		if ($Action === "GET") {
			return in_array($App, self::$Preferences['ExternalApp']);
		} elseif ($Action === "ADD") {
			if (in_array($App, self::$Preferences['ExternalApp'])) return True;
			array_push(self::$Preferences['ExternalApp'], $App);
			return self::PackPreferences(Session::Data()['UserName']);
		} elseif ($Action === "REMOVE") {
			if (!in_array($App, self::$Preferences['ExternalApp'])) return True;
			self::$Preferences['ExternalApp'] = array_merge(array_diff(self::$Preferences['ExternalApp'], array($App)));
			return self::PackPreferences(Session::Data()['UserName']);
		}
	}

	/**
	 * Fetches and decodes the User Preferences.
	 * @param	String $UserName Required. Username of the target user.
	 * @return	Array
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 20140824
	 * @version	0.0
	 */
	private static function UnpackPreferences($UserName) {
		$Response = \TwoDot7\Database\Handler::Exec(
			"SELECT * FROM _user WHERE UserName=:UserName",
			array("UserName" => $UserName))->fetch();
		if (!$Response) return False;
		self::$Preferences = json_decode($Response['Preferences'], True);
		return True;
	}

	/**
	 * Encodes and puts the Modified user preferences.
	 * @param	String $UserName Required. Username of the target user.
	 * @return	Boolean
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 20140824
	 * @version	0.0
	 */
	private static function PackPreferences($UserName) {
		return (bool)\TwoDot7\Database\Handler::Exec(
			"UPDATE _user SET Preferences=:Preferences WHERE UserName=:UserName",
			array(
				'UserName' => $UserName,
				'Preferences' => json_encode(self::$Preferences)
				))->rowCount();
	}
}

/**
 * Wrapper for the User Account Recovery Related functions.
 * Implemets Methods for Password, EMail.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 23062014
 * @version	0.0
 */
class Recover {
	private $AUTH;

	function __construct($Options = array()) {
		$Options = array_merge(array(
			'Token' => False,
			'Abort' => True
			), $Options);

		$this->AUTH = False;

		/**
		 * @internal Checks the Cookie, against the Database.
		 */
		if (Session::Exists()) {
			if ($Options['Token']) {
				$this->AUTH = Access::Check(array(
					'UserName' => Session::Data()['UserName'],
					'Domain' => $Options['Token']));
			}
			else {
				$this->AUTH = True;
			}
		}
		else {
			$this->AUTH = False;
		}
	}

	public function Password($Data) {

		if(!$this->AUTH) {
			/**
			 * @internal This block means this object didn't recieve correct Authentication.
			 */
			Util\Log("Recovery AUTH failed. Function Called: Recover::Password. Trace: ".json_encode($Data), 'TRACK');
			return array(
				'Success' => False,
				'Messages' => array(
					array(
						'Message' => 'AUTH Failure.',
						'Class' => 'ERROR')));
		}

		if( isset($Data['UserName']) &&
			isset($Data['Deauthorize']) &&
			isset($Data['New_Password']) &&
			isset($Data['Conf_Password'])) {

			if (!Validate\Password($Data['New_Password']) ||
				!Validate\Password($Data['Conf_Password']) ||
				!($Data['New_Password'] === $Data['Conf_Password'])) {
				return array(
					'Success' => False,
					'Messages' => array(
						array(
							'Message' => 'The entry for Password fields are not correct. Please try again.', 
							'Class' => 'ERROR')));
			}

			$DatabaseHandle = new \TwoDot7\Database\Handler;
			$DBResponse = $DatabaseHandle->Query("SELECT * FROM _user WHERE UserName=:UserName", array(
				'UserName' => $Data['UserName']))->fetch();

			if($DBResponse) {
				/**
				 * @internal	This Block means that the UserName is valid and Existing. We'll update the Password now.
				 */
				$DatabaseHandle->Query("UPDATE _user SET Password=:Password, Hash=:Hash WHERE UserName=:UserName", array(
					'Password' => \TwoDot7\Util\PBKDF2::CreateHash($Data['New_Password']),
					'Hash' => $Data['Deauthorize'] ? '[]' : $DBResponse['Hash'],
					'UserName' => $Data['UserName']));
				
				Util\Log("Administrator ".Session::Data()['UserName']." Accessed: ".json_encode($Data), 'TRACK');

				Mailer\Send(array(
					'To' => $DBResponse['EMail'],
					'From' => 'Account',
					'TemplateID' => 'PasswordOverriden',
					'Data' => array(
						'UserName' => $DBResponse['UserName'],
						'NewPassword' => $Data['New_Password']
						)
					));

				return array(
					'Success' => True);
			}
			else {
				return array(
					'Success' => False);
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Recovery::Password");
		}
	}

	public function EMailConfirmationCode($Data) {

		if( isset($Data['UserName'])) {

			if (!Validate\UserName($Data['UserName'])) {
				return array(
					'Success' => False,
					'Error' => 'The entry for UserName field is not correct. Please try again.'
					);
			}

			$DBResponse = \TwoDot7\Database\Handler::Exec("SELECT * FROM _user WHERE UserName=:UserName", array(
				'UserName' => $Data['UserName']))->fetch();

			if($DBResponse) {
				/**
				 * @internal	This Block means that the UserName is valid and Existing. We'll update the Password now.
				 */
				# Generate a new Confirmation Code, and EMail it to the User.

				$ConfirmationCode = Util\Crypt::CodeGen($DBResponse['UserName']);
				$EMailURI = BASEURI.'/twodot7/register/confirmEmail/'.$DBResponse['UserName'].'/'.Util\Crypt::Encrypt(json_encode(array(
					'UserName' => $DBResponse['UserName'],
					'ConfirmationCode' => $ConfirmationCode)));

				Mailer\Send(array(
					'To' => $DBResponse['EMail'],
					'From' => 'Recovery',
					'TemplateID' => 'ResendConfirmEmail',
					'Data' => array(
						'UserName' => $DBResponse['UserName'],
						'ConfirmationCode' => $ConfirmationCode,
						'EMailURI' => $EMailURI)));

				return array(
					'Success' => True);
			}
			else {
				return array(
					'Success' => False);
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Access::Add");
		}
	}

	public function EMail($Data) {

		if(!$this->AUTH) {
			/**
			 * @internal This block means this object didn't recieve correct Authentication.
			 */
			Util\Log("Recovery AUTH failed. Function Called: Recover::EMail. Trace: ".json_encode($Data), 'TRACK');
			return array(
				'Success' => False,
				'Error' => 'AUTH Failure.'
				);
		}

		if( isset($Data['UserName']) &&
			isset($Data['New_EMail'])) {

			if (!Validate\EMail($Data['New_EMail']) ||
				Util\Redundant::EMail($Data['New_EMail'])) {
				return array(
					'Success' => False,
					'Error' => 'The entry for Password fields are not correct. Please try again.');
			}

			$DatabaseHandle = new \TwoDot7\Database\Handler;
			$DBResponse = $DatabaseHandle->Query("SELECT * FROM _user WHERE UserName=:UserName", array(
				'UserName' => $Data['UserName']))->fetch();

			if($DBResponse) {
				/**
				 * @internal	This Block means that the UserName is valid and Existing. We'll update the Email now.
				 */
				$DatabaseHandle->Query("UPDATE _user SET EMail=:EMail WHERE UserName=:UserName", array(
					'EMail' => $Data['New_EMail'],
					'UserName' => $Data['UserName']));
				
				Util\Log("Administrator ".Session::Data()['UserName']." Accessed: ".json_encode($Data), 'TRACK');
				
				Status::EMail($DBResponse['UserName'], array(
					'Action' => 'SET',
					'Status' => 2
					));

				Mailer\Send(array(
					'To' => "{$Data['New_EMail']}, {$DBResponse['EMail']}",
					'From' => 'Recovery',
					'TemplateID' => 'EMailOverriden',
					'Data' => array(
						'UserName' => $DBResponse['UserName'],
						'NewEMail' => $Data['New_EMail'],
						'OldEMailStatus' => $DBResponse['EMail']
						)
					));

				return array(
					'Success' => True);
			}
			else {
				return array(
					'Success' => False);
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Recovery::EMail");
		}
	}
}

/**
 * Wrapper for the High Level - REST interface of User Namespace.
 * Implemets Methods for AUTH.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20140801
 * @version	0.0
 */
class REST {

	/**
	 * Returns AUTH status.
	 * @param	-array- $Options Optional Parameters and Overrides
	 * @Options string Token Specify if the particular token must be present.
	 * @return	-array- Contains UserName and their session Hash.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 18072014
	 * @version	0.0
	 */
	public static function AUTH($Options = False) {
		$Options = array_merge(array(
			'Token' => False,
			'API_KEY_OVERRIDE' => (isset($_POST['API_KEY']) && isset($_POST['UserName'])),
			'Abort' => True
			), $Options);

		$Success = False;
		$ErrorMessage = False;

		if ($Options['API_KEY_OVERRIDE']) {
			// Not Implemented.
			$Success = False;
		}
		else {
			/**
			 * @internal Checks the Cookie, against the Database.
			 */
			if (Session::Exists()) {
				if ($Options['Token']) {
					$Success = Access::Check(array(
						'UserName' => Session::Data()['UserName'],
						'Domain' => $Options['Token']));
					$ErrorMessage = "User Privilege Insufficient.";
				}
				else {
					$Success = True;
				}
			}
			else {
				$ErrorMessage = "User Authentication Required.";
				$Success = False;
			}
		}

		if (!$Success && $Options['Abort']) {
			header('HTTP/1.0 401 Unauthorized.', true, 401);
			print "<pre>";
			print "{$ErrorMessage}\n";
			print "Requires [UserName, Hash] or [API_KEY_ID, UserName].\n";
			print "Request Aborted.\n";
			print "REQUEST DATA:\n";
			print "==BEGIN==\n";
			print "Post: ".json_encode($_POST, JSON_PRETTY_PRINT)."\n";
			print "Get: ".json_encode($_GET, JSON_PRETTY_PRINT)."\n";
			print "Cookie: ".json_encode($_COOKIE, JSON_PRETTY_PRINT)."\n";
			print "Header: ".json_encode(Util\RequestHeaders(), JSON_PRETTY_PRINT)."\n";
			print "===END===\n";
			die();
		}
		else {
			return $Success;
		}
	}
}

/**
 * Wrapper for the User Session Related functions.
 * Implements Methods for Login, Logout, & Session Status.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20140623
 * @version	0.0
 */
class Session {
	/**
	 * Caches the Session status in the current runtime,
	 * when checking the session existence by ::Exists() Method.
	 * Prevents multiple database calls in case of multiple calls.
	 */
	public static $Status = False;

	/**
	 * Returns current session data.
	 * @return	-array- Contains UserName and their session Hash.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 20140718
	 * @version	0.0
	 */
	public static function Data() {
		return array(
			'UserName' => isset($_COOKIE['Two_7User']) ? $_COOKIE['Two_7User'] : False,
			'Hash' => isset($_COOKIE['Two_7Hash']) ? $_COOKIE['Two_7Hash'] : False
			);
	}

	/**
	 * This function Authenticates and Handles Sign In process.
	 * @param	$Data -array- UserName and Password are sent to it.
	 * @return	-array- Contains Success status, Tokens and Status on successful authentication.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140629
	 * @version	0.0
	 */
	public static function Login($Data) {
		if(!Validate\UserName($Data['UserName'], False)) {
			return array(
				'Success' => False,
				'Messages' => array(
					array(
						'Message' => 'Invalid UserName or Password.',
						'Class' => 'ERROR')));
		}
		$DatabaseHandle = new \TwoDot7\Database\Handler;
		$DBResponse = $DatabaseHandle->Query("SELECT * FROM _user WHERE UserName=:UserName", array(
			'UserName' => $Data['UserName']))->fetch();
		if($DBResponse) {
			/**
			 * @internal	This Block means that the UserName is valid and Existing.
			 */
			if(\TwoDot7\Util\PBKDF2::ValidatePassword($Data['Password'], $DBResponse['Password'])) {
				/**
				 * @internal	Valid User. Execute Login.
				 */
				$HashGen = Util\Crypt::RandHash();
				$Hash = Util\Token::Add(array(
					'JSON' => $DBResponse['Hash'],
					'Token' => $HashGen), True);
				$DatabaseHandle->Query("UPDATE _user SET Hash=:Hash WHERE UserName=:UserName;", array(
					'Hash' => $Hash,
					'UserName' => $Data['UserName']));
				$Expire=time()+(300*24*60*60);
				return array(
					'Success' => True,
					'Hash' => $HashGen,
					'UserName' => $Data['UserName']);
			}
			else {
				return array(
					'Success' => False,
					'Messages' => array(
						array(
							'Message' => 'Invalid UserName or Password.',
							'Class' => 'ERROR')));
			}
		}
		else {
			return array(
				'Success' => False,
				'Messages' => array(
					array(
						'Message' => 'Invalid UserName or Password.',
						'Class' => 'ERROR')));
		}
	}

	/**
	 * This function Checks Session and Destroys it.
	 * @param	$Data -array- UserName and Hash are sent to it.
	 * @return	-array- Contains Success status.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140630
	 * @version	0.0
	 */
	public static function Logout($Data) {
		if( isset($Data['UserName']) &&
			isset($Data['Hash'])) {
			$DatabaseHandle = new \TwoDot7\Database\Handler;
			$DBResponse = $DatabaseHandle->Query("SELECT * FROM _user WHERE UserName=:UserName", array(
				'UserName' => $Data['UserName']))->fetch();
			if(Util\Token::Exists(array(
				'JSON' => isset($DBResponse['Hash']) ? $DBResponse['Hash'] : False,
				'Token' => $Data['Hash']))) {
				$DatabaseHandle->Query("UPDATE _user SET Hash=:Hash WHERE UserName=:UserName;", array(
					'Hash' => Util\Token::Remove(array(
						'JSON' => $DBResponse['Hash'],
						'Token' => $Data['Hash'])),
					'UserName' => $Data['UserName']));
				return array (
					'Success' => True,
					'UserName' => $Data['UserName']);
			}
			else {
				Util\Log("Failed to Logout User Session. Data: ".json_encode($Data), "TRACK");
				return array(
					'Success' => False);
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Login::UserStatus");
		}
	}

	/**
	 * This function Authenticates and Check the session status of user.
	 * @param	$Data -array- UserName and Hash are sent to it.
	 * @return	-array- Contains Success status, Tokens and Status on successful authentication.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140629
	 * @version	0.0
	 */
	public static function Status($Data) {
		if( isset($Data['UserName']) &&
			isset($Data['Hash'])) {
			//
			$Query = "SELECT * FROM _user WHERE UserName=:UserName";
			$DBResponse = \TwoDot7\Database\Handler::Exec($Query, array('UserName' => $Data['UserName']))->fetch();
			if(Util\Token::Exists(array(
				'JSON' => isset($DBResponse['Hash']) ? $DBResponse['Hash'] : False,
				'Token' => $Data['Hash']))) {
				self::$Status = True;
				return array (
					'Success' => True,
					'LoggedIn' => True,
					'UserName' => $Data['UserName'],
					'Hash' => $DBResponse['Hash'],
					'Tokens' => $DBResponse['Tokens'],
					'Status' => $DBResponse['Status']);
			}
			else {
				Util\Log("Failed to Verify Session. Data: ".json_encode($Data), "TRACK");
				return array(
					'Success' => False,
					'LoggedIn' => False,
					'UserName' => False);
			}
		}
		else {
			throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\User\\Login::UserStatus");
		}
	}

	/**
	 * This function Provides an interface to Session::Status() function because cookies needs
	 * to be checked quite a lot of times.
	 * @return	-bool- True if a Valid session exists.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 20140630
	 * @version	0.0
	 */
	public static function Exists() {
		if (self::$Status) {
			return True;
		}
		return self::Status(self::Data())['LoggedIn'];
	}
}

/**
 * Wrapper for commonly used procedures.
 * Implements Methods for Detecting System Admin, Admin.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20140822
 * @version	0.0
 */
class Shortcut {

	/**
	 * Checks if the User has Admin Privileges.
	 * @return	Boolean
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 20140822
	 * @version	0.0
	 */
	public static function IsAdmin() {
		if (Session::Exists() &&
			Access::Check(array(
				'UserName' => Session::Data()['UserName'],
				'Domain' => 'ADMIN'))) {
			return True;
		}
		else {
			return False;
		}
	}

	/**
	 * Checks if the User has SysAdmin Privileges.
	 * @return	Boolean
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 20140822
	 * @version	0.0
	 */
	public static function IsSysAdmin() {
		if (Session::Exists() &&
			Access::Check(array(
				'UserName' => Session::Data()['UserName'],
				'Domain' => 'SYSADMIN'))) {
			return True;
		}
		else {
			return False;
		}
	}
}

/**
 * Wrapper for the Account Status Management functions.
 * Implements Get, Set, Escalate, Revoke
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20140623
 * @version	0.0
 */
class Status {
	/**
	 * @internal 1. Profile Status.
	 * @internal 1.1 0: Unverified Profile
	 * @internal 1.2 1: Regular Profile
	 * @internal 1.3 2: Verified Profile
	 * @internal 2. EMail Status.
	 * @internal 2.1 0: Unconfirmed EMail ID
	 * @internal 2.2 1: Confirmed EMail ID
	 * @internal 2.3 2: EMail ID Updated - but unconfirmed.
	 * @internal 3. Free Space. -todo-
	 */

	/**
	 * Gets or Sets the Profile Status Number.
	 * @param	$UserName -string- UserName.
	 * @param	$Override -array- Action and New Status.
	 * @return	-array- Contains response.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @throws	InvalidArgument Exception.
	 * @since	v0.0 20140712
	 * @version	0.0
	 */
	public static function Profile($UserName, $Override = array(
		'Action' => 'GET')) {

		switch ($Override['Action']) {
			case 'GET':
				$DBResponse = \TwoDot7\Database\Handler::Exec("SELECT * FROM _user WHERE UserName=:UserName", array(
					'UserName' => $UserName))->fetch();
				if ($DBResponse) {
					$Status = $DBResponse['Status'];
					if (is_numeric($Status)) {
						# Proceed. In all normal cases, this block should be the one executing.
						$ProfileStatus = $Status%10;
						$PrettyStatus = function() use (&$ProfileStatus) {
							switch ($ProfileStatus) {
								case 0:
									return 'Unverified Profile';
								case 1:
									return 'Regular User';
								case 2:
									return 'Verified User';
								default:
									return 'Huh';
							}
						};
						return array(
							'Success' => True,
							'Response' => $ProfileStatus,
							'ResponseText' => $PrettyStatus());
					}
					else {
						Util\Log("Invalid Data stored in DB. UserMeta = \"".json_encode($DBResponse)."\" Function User/Status/Profile", "TRACK");
						Util\Log("Invalid Data Error Fired. \User\Status\Profile. Check Track Log.");
						# Stop Execution.
						if (file_exists($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php')) {
							require_once $_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php';
							\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
								'Call' => 'Error',
								'ErrorMessageHead' => 'Sorry, there was a Server Error',
								'ErrorMessageFoot' => 'Invalid User Status Code.',
								'ErrorCode' => 'DataBase Error. Invalid Data. Fatal.',
								'Code' => 503,
								'Mood' => 'RED'));
							die();
						}
						else {
							echo "<pre><h1>Two Dot 7 Database Error.</h1>";
							echo "<h2>Invalid Status Code in DB.</h2>";
							echo "<h3>If you are a User, apologies. Please Contact the support. If you're a developer, please check the Info/Tracking Logs.</h3>";
							echo "<h4>Additionally, a 404 error occured, while trying to find the Error interface.";
							die();
						}
					}
				}
				else {
					return array(
						'Success' => False,
						'Messages' => array(
							array(
								'Message' => 'Specified User Doesnt exists.',
								'Class' => 'ERROR')));
				}
				break;
			case 'SET':
				$DatabaseHandle = new \TwoDot7\Database\Handler;
				$DBResponse = $DatabaseHandle->Query("SELECT * FROM _user WHERE UserName=:UserName", array(
					'UserName' => $UserName))->fetch();
				if ($DBResponse) {
					$Status = $DBResponse['Status'];
					if (is_numeric($Status)) {
						# Proceed. In all normal cases, this block should be the one executing.
						$OldProfileStatus = $Status%10;
						$PrettyStatus = function($Status) {
							switch ($Status) {
								case 0:
									return 'Unverified Profile';
								case 1:
									return 'Regular User';
								case 2:
									return 'Verified User';
								default:
									return 'Huh';
							}
						};

						# Validate the new Status:
						if (!in_array($Override['Status'], array(0, 1 , 2))) {
							# Error. 
							throw new \TwoDot7\Exception\InvalidArgument("Invalid Override 'Status' in function User\Status\Profile.");
						}

						# Fine. Push it on the Unit's place.
						$NewStatus = (int)($Status/10)*10+$Override['Status'];

						$NewProfileStatus = $NewStatus%10;

						# Push status in the DB.
						$DatabaseHandle->Query("UPDATE _user SET Status=:Status WHERE UserName=:UserName;", array(
							'UserName' => $UserName,
							'Status' => $NewStatus));

						return array(
							'Success' => True,
							'SuccessText' => 'Updated the Profile Status',
							'Response' => $NewProfileStatus,
							'ResponseText' => $PrettyStatus($NewProfileStatus),
							'OldProfileStatus' => $PrettyStatus($OldProfileStatus)
							);
					}
					else {
						Util\Log("Invalid Data stored in DB. UserMeta = \"".json_encode($DBResponse)."\" Function User/Status/Profile", "TRACK");
						Util\Log("Invalid Data Error Fired. \User\Status\Profile. Check Track Log.");
						# Stop Execution.
						if (file_exists($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php')) {
							require_once $_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php';
							\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
								'Call' => 'Error',
								'ErrorMessageHead' => 'Sorry, there was a Server Error',
								'ErrorMessageFoot' => 'Invalid User Status Code.',
								'ErrorCode' => 'DataBase Error. Invalid Data. Fatal.',
								'Code' => 503,
								'Mood' => 'RED')
							);
							die();
						}
						else {
							echo "<pre><h1>Two Dot 7 Database Error.</h1>";
							echo "<h2>Invalid Status Code in DB.</h2>";
							echo "<h3>If you are a User, apologies. Please Contact the support. If you're a developer, please check the Info/Tracking Logs.</h3>";
							echo "<h4>Additionally, a 404 - not found error occured, while trying to find the Error interface.";
							die();
						}
					}
				}
				else {
					return array(
						'Success' => False,
						'Messages' => array(
							array(
								'Message' => 'Specified User Doesnt exists.',
								'Class' => 'ERROR')));
				}
				break;
			default:
				throw new \TwoDot7\Exception\InvalidArgument("Invalid Override in function User\Status\Profile.");
			
		}
	}

	/**
	 * Gets or Sets the EMail Status Number.
	 * @param	$UserName -string- UserName.
	 * @param	$Override -array- Action and New Status.
	 * @return	-array- Contains response.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @throws	InvalidArgument Exception.
	 * @since	v0.0 20140712
	 * @version	0.0
	 */
	public static function EMail($UserName, $Override = array(
		'Action' => 'GET')) {

		switch ($Override['Action']) {
			case 'GET':
				$DBResponse = \TwoDot7\Database\Handler::Exec("SELECT * FROM _user WHERE UserName=:UserName", array(
					'UserName' => $UserName))->fetch();
				if ($DBResponse) {
					$Status = $DBResponse['Status'];
					if (is_numeric($Status)) {
						# Proceed. In all normal cases, this block should be the one executing.
						$EMailStatus = (int)(($Status%100)/10);
						$PrettyStatus = function() use (&$EMailStatus) {
							switch ($EMailStatus) {
								case 0:
									return 'Unconfirmed EMail ID';
								case 1:
									return 'Confirmed EMail ID';
								case 2:
									return 'EMail ID Updated - but unconfirmed.';
								default:
									return 'Huh';
							}
						};
						return array(
							'Success' => True,
							'Response' => $EMailStatus,
							'ResponseText' => $PrettyStatus());
					}
					else {
						Util\Log("Invalid Data stored in DB. UserMeta = \"".json_encode($DBResponse)."\" Function User/Status/EMail", "TRACK");
						Util\Log("Invalid Data Error Fired. \User\Status\EMail. Check Track Log.");
						# Stop Execution.
						if (file_exists($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php')) {
							require_once $_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php';
							\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
								'Call' => 'Error',
								'ErrorMessageHead' => 'Sorry, there was a Server Error',
								'ErrorMessageFoot' => 'Invalid User Status Code.',
								'ErrorCode' => 'DataBase Error. Invalid Data. Fatal.',
								'Code' => 503,
								'Mood' => 'RED'));
							die();
						}
						else {
							echo "<pre><h1>Two Dot 7 Database Error.</h1>";
							echo "<h2>Invalid Status Code in DB.</h2>";
							echo "<h3>If you are a User, apologies. Please Contact the support. If you're a developer, please check the Info/Tracking Logs.</h3>";
							echo "<h4>Additionally, a 404 error occured, while trying to find the Error interface.";
							die();
						}
					}
				}
				else {
					return array(
						'Success' => False,
						'Messages' => array(
							array(
								'Message' => 'Specified User Doesnt exists.',
								'Class' => 'ERROR')));
				}
				break;
			case 'SET':
				$DatabaseHandle = new \TwoDot7\Database\Handler;
				$DBResponse = $DatabaseHandle->Query("SELECT * FROM _user WHERE UserName=:UserName", array(
					'UserName' => $UserName))->fetch();
				if ($DBResponse) {
					$Status = $DBResponse['Status'];
					if (is_numeric($Status)) {
						# Proceed. In all normal cases, this block should be the one executing.
						$OldEMailStatus = $Status%10;
						$PrettyStatus = function($Status) {
							switch ($Status) {
								case 0:
									return 'Unconfirmed EMail ID';
								case 1:
									return 'Confirmed EMail ID';
								case 2:
									return 'EMail ID Updated - but unconfirmed.';
								default:
									return 'Huh';
							}
						};

						# Validate the new Status:
						if (!in_array($Override['Status'], array(0, 1 , 2))) {
							# Error. 
							throw new \TwoDot7\Exception\InvalidArgument("Invalid Override 'Status' in function User\Status\Profile.");
						}

						# Fine. Push it on the Unit's place.
						$NewStatus = (int)($Status/100)*100+($Override['Status']*10+$Status%10);

						if ($NewStatus === (int)$Status) {
							return array(
								'Success' => True,
								'SuccessText' => 'No changes has been made.');
						}

						$NewEMailStatus = $NewStatus%10;

						# Push status in the DB.
						$DatabaseHandle->Query("UPDATE _user SET Status=:Status WHERE UserName=:UserName;", array(
							'UserName' => $UserName,
							'Status' => $NewStatus));

						Mailer\Send(array(
							'To' => $DBResponse['EMail'],
							'From' => 'Account',
							'TemplateID' => 'ConfirmEmailSuccess',
							'Data' => array(
								'UserName' => $UserName)));

						return array(
							'Success' => True,
							'SuccessText' => 'Updated the EMail Status',
							'Response' => $NewEMailStatus,
							'ResponseText' => $PrettyStatus($NewEMailStatus),
							'OldEMailStatus' => $PrettyStatus($OldEMailStatus));
					}
					else {
						Util\Log("Invalid Data stored in DB. UserMeta = \"".json_encode($DBResponse)."\" Function User/Status/Profile", "TRACK");
						Util\Log("Invalid Data Error Fired. \User\Status\EMail. Check Track Log.");
						# Stop Execution.
						if (file_exists($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php')) {
							require_once $_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php';
							\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
								'Call' => 'Error',
								'ErrorMessageHead' => 'Sorry, there was a Server Error',
								'ErrorMessageFoot' => 'Invalid User Status Code.',
								'ErrorCode' => 'DataBase Error. Invalid Data. Fatal.',
								'Code' => 503,
								'Mood' => 'RED'));
							die();
						}
						else {
							echo "<pre><h1>Two Dot 7 Database Error.</h1>";
							echo "<h2>Invalid Status Code in DB.</h2>";
							echo "<h3>If you are a User, apologies. Please Contact the support. If you're a developer, please check the Info/Tracking Logs.</h3>";
							echo "<h4>Additionally, a 404 error occured, while trying to find the Error interface.";
							die();
						}
					}
				}
				else {
					return array(
						'Success' => False,
						'Messages' => array(
							array(
								'Message' => 'Specified User Doesnt exists.',
								'Class' => 'ERROR')));
				}
				break;
			default:
				throw new \TwoDot7\Exception\InvalidArgument("Invalid Override in function User\Status\EMail.");
			
		}
	}

	/**
	 * Get the Bare status code.
	 * @param	string $UserName UserName.
	 * @param	mixed $Override Action and New Status.
	 * @return	boolean Contains response.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	InvalidArgument Exception.
	 * @since	v0.0 20150808
	 * @version	0.0
	 */
	public static function Get($UserName = False) {
		$DBResponse = \TwoDot7\Database\Handler::Exec(
			"SELECT * FROM _user WHERE UserName=:UserName", 
			array(
				'UserName' => $UserName ? $UserName : Session::Data()['UserName']
				))->fetch();

		if ($DBResponse) {
			$Status = $DBResponse['Status'];
			if (is_numeric($Status)) {
				return (int)$Status;
			}
			else {
				Util\Log("Invalid Data stored in DB. UserMeta = \"".json_encode($DBResponse)."\" Function User/Status/Profile", "TRACK");
				Util\Log("Invalid Data Error Fired. \User\Status\Profile. Check Track Log.");
				# Stop Execution.
				if (file_exists($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php')) {
					require_once $_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php';
					\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
						'Call' => 'Error',
						'ErrorMessageHead' => 'Sorry, there was a Server Error',
						'ErrorMessageFoot' => 'Invalid User Status Code.',
						'ErrorCode' => 'DataBase Error. Invalid Data. Fatal.',
						'Code' => 503,
						'Mood' => 'RED'));
					die();
				}
				else {
					echo "<pre><h1>Two Dot 7 Database Error.</h1>";
					echo "<h2>Invalid Status Code in DB.</h2>";
					echo "<h3>If you are a User, apologies. Please Contact the support. If you're a developer, please check the Info/Tracking Logs.</h3>";
					echo "<h4>Additionally, a 404 error occured, while trying to find the Error interface.";
					die();
				}
			}
		}
		else {
			return 0;
		}
	}

	/**
	 * Correlates the User Statuses. Checks for minimum user status requirement.
	 * @param	string $Candidate Candidate Status.
	 * @param	string $Subject Subject Status.
	 * @return	boolean Contains response.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	InvalidArgument Exception.
	 * @since	v0.0 20150808
	 * @version	0.0
	 */
	public static function Correlate($Candidate, $Subject) {
		if (!is_numeric($Candidate) &&
			!is_numeric($Subject)) {
			throw new \TwoDot7\Exception\InvalidArgument("Subject and Candidate must be Numeric.");
		}
		
		$Subject_Digit = strlen($Subject);
		$Candidate_Digit = strlen($Candidate);

		$Iteration_Limit = $Subject_Digit < $Candidate_Digit ? $Candidate_Digit : $Subject_Digit;

		for ($i = 0; $i < $Iteration_Limit; $i++) {
			if ($Candidate % 10 > $Subject % 10) return False;
			$Candidate = (int)($Candidate/10);
			$Subject = (int)($Subject/10);
		}

		return True;
	}
}
?>