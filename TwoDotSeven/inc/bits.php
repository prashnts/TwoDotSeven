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

/**
 * Registers a Bit into the system, and sets it up.
 * Implements Install, Register.
 * Implements Add, Escalate.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 26062014
 * @version	0.0
 */
class Register {
	public static function Install() {

	}
}

class Init {
	public function __construct($Bit, $ThrowOverride = False) {
		// Todo
		if (self::isRegistered($Bit)) {
			// Go on.
		}
		elseif ($ThrowOverride) {
			Util/Log('Could not ')
		}
	}

	/**
	 * Checks if the Bit token is properly registered.
	 */
	private function isRegistered(&$Bit) {
		// Todo
	}
	public function Broadcast() {
		// Todo
	}
	public function Dashboard() {
		//
	}
	public function API() {
		//
	}
}

class Setup {

}