<?php
namespace TwoDot7\Bit;
use \TwoDot7\Validate as Validate;
use \TwoDot7\Util as Util;
use \TwoDot7\Mailer as Mailer;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

function ROOT_DIR() {
	return $_SERVER['DOCUMENT_ROOT']."/TwoDotSeven/bit";
}

/**
 * Registers a Bit into the system, and sets it up.
 * Implements Install, Register.
 * Implements Add, Escalate.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 26062014
 * @version	0.0
 */
class Register {
	public static function InstallPreview($Installable) {
		//
	}
	public static function Install($Installable) {
		// 1. Check if is_dir.
		// 2. Check if file_exists: $Installable/install.json
		// 3. Read and parse the install script, and register components.
		// 4. Check if already installed.
		// 5.1 Register into DB
		// 5.2 Register the Navigation
		// 5.3 Register the Broadcast and Dashboard.
		// 6. Add userToken and adminToken to the Installing user.
		// Done. (For now!)
		
		$BaseDir = \TwoDot7\Bit\ROOT_DIR().'/'.$Installable;

		if (!is_dir($BaseDir)) {
			return array(
				'Success' => False,
				'Error' => 'Bit Installation Files not found.'
				);
		}
		if (!file_exists($BaseDir.'/install.json')) {
			return array(
				'Success' => False,
				'Error' => 'Bit Installation Files not found.'
				);
		}
		if (Util\Redundant::Bit($Installable)) {
			return array(
				'Success' => False,
				'Error' => 'Bit already Installed.'
				);
		}
		$InstallMeta = json_decode(file_get_contents($BaseDir.'/install.json'), True);
		if (!self::ValidateInstall($Installable, $InstallMeta)) {
			//
		}
		# 5.1:
		$Processed = array();
		$Query = "INSERT INTO _bit (ID, Name, Tokens, Meta) VALUES (:ID, :Name, :Tokens, :Meta)";
		$Processed['1'] = (bool)(\TwoDot7\Database\Handler::Exec($Query, array(
			'ID' => $InstallMeta['bitInfo']['id'],
			'Name' => $InstallMeta['bitMeta']['name'],
			'Tokens' => json_encode(array(
				'adminToken' => $InstallMeta['bitInfo']['adminToken'],
				'userToken' => $InstallMeta['bitInfo']['userToken'],
				'autoToken' => $InstallMeta['bitInfo']['autoToken'],
				'autoTokenUserLevel' => $InstallMeta['bitInfo']['autoTokenUserLevel']
				)),
			'Meta' => json_encode(array(
				'Description' => $InstallMeta['bitMeta']['description'],
				'Icon' => $InstallMeta['bitMeta']['icon'],
				'TileColor' => $InstallMeta['bitMeta']['tileColor'],
				'Broadcasts' => $InstallMeta['registerIntoBroadcast']
				))
			))->rowCount());
		# 5.2:
		$Processed['2'] = (\TwoDot7\Meta\Navigation::Add(
					$InstallMeta['bitInfo']['id'],
					$InstallMeta['navigation']
					)['Success']);
		# 5.3 : Skipped

		$Processed['5'] = \TwoDot7\User\Access::Add(array(
			'UserName' => \TwoDot7\User\Session::Data()['UserName'],
			'Domain' => $InstallMeta['bitInfo']['adminToken']
			));
		$Processed['6'] = \TwoDot7\User\Access::Add(array(
			'UserName' => \TwoDot7\User\Session::Data()['UserName'],
			'Domain' => $InstallMeta['bitInfo']['userToken']
			));

		$Processed['7'] = \TwoDot7\User\Access::Add(array(
			'UserName' => \TwoDot7\User\Access::SysAdmin()['UserName'],
			'Domain' => $InstallMeta['bitInfo']['adminToken']
			));
		$Processed['8'] = \TwoDot7\User\Access::Add(array(
			'UserName' => \TwoDot7\User\Access::SysAdmin()['UserName'],
			'Domain' => $InstallMeta['bitInfo']['userToken']
			));

		return $Processed;
	}
	private static function ValidateInstall($Installable, $InstallMeta) {
		return true;
	}
}

class Init {
	private $Bit;
	private $AdminToken;
	private $UserToken;
	private $AutoToken;

	public function __construct($Bit, $ThrowOverride = False) {
		if (self::isRegistered($Bit)) {
			// Go on.
		}
		elseif ($ThrowOverride) {
			Util\Log('Could not ');
		}
	}

	/**
	 * Checks if the Bit token is properly registered.
	 */
	private function isRegistered($Bit) {
		# 1. Check if it is in the _bit
		# 2. Check if the Registered Files are there.
		# 3. Ok!
	}
	public function Broadcast() {
		// Todo
	}
	public function Dashboard() {
		//
	}
	public function REST() {
		//
	}

	public static function GetTile() {
		//
	}
}

class Setup {

}