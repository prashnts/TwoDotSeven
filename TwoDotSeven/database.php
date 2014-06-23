<?php
namespace TwoDot7\Database;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * Builds a Database Handler object. Requires Configuration NameSpace to Work.
 * Handler Takes care of SQL Best Practices and Prevetion of Injection attacks by itself.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20072014
 * @version	0.0
 */
class Handler {
	/**
	 * Contains the PDO Object.
	 * @var PDO \TwoDot7\Database\Handler\DbHandle
	 */
	private $DbHandle;

	/**
	 * Contains Count of Handle Objects Created.
	 * @var integer
	 */
	private static $Count = 0;

	/**
	 * Default Constructor. Constructs the Handle Object.
	 * @return	boolean
	 */
	function __construct() {
		$ConnectionString = "mysql:host=".\TwoDot7\Config\SQL_HOST.";dbname=".\TwoDot7\Config\SQL_DBNAME;
		$SqlUsername = \TwoDot7\Config\SQL_USERNAME;
		$SqlPassword = \TwoDot7\Config\SQL_PASSWORD;
		try {
			$this->DbHandle = new \PDO($ConnectionString, $SqlUsername, $SqlPassword);
			Handler::$Count++;
			return TRUE;
		}
		catch (\PDOException $E) {
			return FALSE;
		}
	}

	/**
	 * Executes a Query.
	 * @param string $Query Formed Query String.
	 * @param array $Arr Optional. Contains $Query parameters.
	 * @return \PDO Binding.
	 */
	public function Query($Query, $Arr = array()) {
		try {
			$this->DbHandle->beginTransaction();
			$Binding = $this->DbHandle->prepare($Query);
			$Binding->execute($Arr);
			$this->DbHandle->Commit();
			return ($Binding);
		}
		catch (PDOException $E) {
			afPutLogEntry ($E->getMessage(), DEBUG);
			$this->DbHandle->rollback();
			return FALSE;
		}
	}
}
?>