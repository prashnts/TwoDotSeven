<?php
namespace TwoDot7\Database;

/**
 * 
 */
class Handler {
	function __construct() {
		$ConnectionString = "mysql:host=".\TwoDot7\Config\SQL_HOST.";dbname=".\TwoDot7\Config\SQL_DBNAME;
		$SqlUsername = \TwoDot7\Config\SQL_USERNAME;
		$SqlPassword = \TwoDot7\Config\SQL_PASSWORD;
		try {
			$this->DbHandle = new PDO($ConnectionString, $SqlUsername, $SqlPassword);
			return TRUE;
		}
		catch (PDOException $E) {
			return FALSE;
		}
	}
}
?>