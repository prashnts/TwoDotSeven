<?php
namespace TwoDot7\Group;
use \TwoDot7\Util as Util;
use \TwoDot7\Mailer as Mailer;
use \TwoDot7\Database as Database;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

class Instance {
	private static $Count = 0;
	private $GroupID;
	private $Name;
	private $Meta;
	private $Type;
	private $Graph;

	function __construct($GroupID) {
		// Constructs the Group Instance. Caches for faster execution.
		$Query = "SELECT * FROM _group WHERE GroupID = :GroupID";
		
		$Response = Database\Handler::Exec($Query)->fetch();

		if (count($Response)) {
			$this->GroupID = $Response['GroupID'];
			$this->Name = $Response['Name'];
			$this->Meta = $Response['Meta'];
			$this->Type = $Response['Type'];
			$this->Graph = $Response['Graph'];
		}
	}

	public function GetUser($UserName) {
		// Returns user rights and checks if user is part of the group.
		// Used to show the User in the Node.
	}

	public function GetGraph() {
		// Returns user graph, including the Users in the Group.
	}

	public function GetBroadcast() {
		// Returns the Broadcasts targeted for this group.
	}
}

class User extends Instance {
	function 
}

class Setup {
	public static function Create($Data) {
		if (!isset($Data['GroupID']),
			!isset($Data['Type']),
			!isset($Data['']))
	}

	public static function Delete() {
		// Deletes the Group.
	}

	public static function Update() {
		// Updates the Group.
	}
}

?>