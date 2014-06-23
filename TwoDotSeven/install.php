<?php
namespace TwoDot7\Install;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * Sets Up the Environment for Setting up the Website.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20072014
 * @version	0.0
 */
class Installer {
	private $DatabaseHandle;
	function __construct() {
		$this->DatabaseHandle = new \TwoDot7\Database\Handler;
	}

	/**
	 * Sets up the Tables in SQL.
	 * @param boolean $CLI Toggles echo Mode;
	 */
	public function BuildTables() {
		var_dump($this->DatabaseHandle->query(self::Queries('_user')));
	}

	private static function Queries($Key) {
		switch ($Key) {
			case "_user"	:	return 	"CREATE TABLE IF NOT EXISTS `_user` (
											`ID` int(11) NOT NULL AUTO_INCREMENT,
											`userlogin` varchar(64) NOT NULL,
											`passwd` varchar(128) NOT NULL,
											`email` varchar(255) NOT NULL,
											`hash` text NOT NULL,
											`tokens` text NOT NULL,
											`status` int(11) NOT NULL,
											PRIMARY KEY (`ID`),
											UNIQUE KEY `userlogin` (`userlogin`)
										) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		}
	}

}
?>