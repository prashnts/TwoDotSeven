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
 * @since	v0.0 26062014
 * @version	0.0
 */
class Account {
	/**
	 * Creates a User Account, in the _user Table. Fires up the Mailer class to send out verification email.
	 * @internal Requires Validation/.
	 * @param	$SignupData -array- Self Explanatory
	 * @param	$Method -bool- Not Implemented. From __future__
	 * @return	-array- Contains Success status, and Corresponding messages.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 26062014
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

					// Generate the Next Step URI, and Send an EMail.
					$ConfirmationCode = Util\Crypt::CodeGen($SignupData['UserName']);
					$EMailURI = BASEURI.'/twodot7/register/ConfirmEmail/'.$SignupData['UserName'].'/'.Util\Crypt::Encrypt(json_encode(array(
						'UserName' => $SignupData['UserName'],
						'ConfirmationCode' => $ConfirmationCode)));

					$NextURI = '/twodot7/register/ConfirmEmail/'.$SignupData['UserName'];

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
	 * @since	v0.0 03072014
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
	 * Changes the User's EMail ID.
	 * @param	$Data -array- Username, and ConfirmationCode.
	 * @return	-array- Contains Success status, and Corresponding messages.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 03072014
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


	public static function Escalate($UserName) {
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
 * Class wrapper for User Acess controls.
 * Implements Add, Check, Get, Revoke.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 01072014
 * @version	0.0
 */
class Access {
	/**
	 * This function Adds Access Token.
	 * @param	$Data -array- UserName and Domain token are sent to it.
	 * @return	-bool- Indicates success or failure.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 01072014
	 * @version	0.0
	 */
	public static function Add($Data) {
		if( isset($Data['UserName']) &&
			isset($Data['Domain'])) {
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
	 * @since	v0.0 01072014
	 * @version	0.0
	 */
	public static function Check($Data) {
		if( isset($Data['UserName']) &&
			isset($Data['Domain'])) {
			$TokensJSON = \TwoDot7\Database\Handler::Exec("SELECT * FROM _user WHERE UserName=:UserName", array(
				'UserName' => $Data['UserName']))->fetch()['Tokens'];
			return Util\Token::Exists(array(
				'JSON' => $TokensJSON ? $TokensJSON : False,
				'Token' => $Data['Domain']));
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
	 * @since	v0.0 01072014
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
	 * @since	v0.0 01072014
	 * @version	0.0
	 */
	public static function Revoke($Data) {
		if( isset($Data['UserName']) &&
			isset($Data['Domain'])) {
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
}

class Meta {
	//Todo
	//
}

class Preferences {
	// Todo
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

	function __construct() {
		$this->AUTH = True;
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

	public function EMailConfirmationCode($Data) {

		if( isset($Data['UserName'])) {

			if (!Validate\UserName($Data['UserName'])) {
				return array(
					'Success' => False,
					'Messages' => array(
						array(
							'Message' => 'The entry for UserName field is not correct. Please try again.', 
							'Class' => 'ERROR')));
			}

			$DBResponse = \TwoDot7\Database\Handler::Exec("SELECT * FROM _user WHERE UserName=:UserName", array(
				'UserName' => $Data['UserName']))->fetch();

			if($DBResponse) {
				/**
				 * @internal	This Block means that the UserName is valid and Existing. We'll update the Password now.
				 */
				# Generate a new Confirmation Code, and EMail it to the User.

				$ConfirmationCode = Util\Crypt::CodeGen($DBResponse['UserName']);
				$EMailURI = BASEURI.'/twodot7/register/ConfirmEmail/'.$DBResponse['UserName'].'/'.Util\Crypt::Encrypt(json_encode(array(
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
}

/**
 * Wrapper for the User Session Related functions.
 * Implemets Methods for Login, Logout, & Session Status.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 23062014
 * @version	0.0
 */
class Session {
	/**
	 * This function Authenticates and Handles Sign In process.
	 * @param	$Data -array- UserName and Password are sent to it.
	 * @return	-array- Contains Success status, Tokens and Status on successful authentication.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	IncompleteArgument Exception.
	 * @since	v0.0 29062014
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
	 * @since	v0.0 30062014
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
	 * @since	v0.0 29062014
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
	 * @since	v0.0 30062014
	 * @version	0.0
	 */
	public static function Exists() {
		return self::Status(array(
		'UserName' => isset($_COOKIE['Two_7User']) ? $_COOKIE['Two_7User'] : False,
		'Hash' => isset($_COOKIE['Two_7Hash']) ? $_COOKIE['Two_7Hash'] : False))['LoggedIn'];
	}
}

/**
 * Wrapper for the Account Status Management functions.
 * Implements Get, Set, Escalade, Revoke
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 23062014
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
	 * @since	v0.0 12072014
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
							'OldProfileStatus' => $PrettyStatus($OldProfileStatus));
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
	 * @since	v0.0 12072014
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
}
?>