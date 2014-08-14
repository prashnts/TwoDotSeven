<?php
namespace TwoDOt7\Bit\in_ac_ducic_tabs\Controller;

function init() {
	switch ($_GET['BitAction']) {
		case 'interface':
			return array(
				'Call' => '_Interface'
				);
		case 'manage':
			return array(
				'Call' => '_Manage'
				);
		default:
			return array(
				'Call' => 'FourOFour');
	 }
}

function Install() {
	$TableStr = 
		"CREATE TABLE IF NOT EXISTS `_bit_in.ac.ducic.tabs.addressbook` (".
		"  `ID` int(11) NOT NULL AUTO_INCREMENT,".
		"  `Name` varchar(128) NOT NULL,".
		"  `Email` varchar(255) NOT NULL,".
		"  `ChatName` varchar(128) NOT NULL,".
		"  `Organization` varchar(128) NOT NULL,".
		"  `NickName` varchar(128) NOT NULL,".
		"  `AdditionalEmail` varchar(128) NOT NULL,".
		"  `Department` varchar(128) NOT NULL,".
		"  `Title` varchar(128) NOT NULL,".
		"  `Mobile` varchar(128) NOT NULL,".
		"  `Pager` varchar(128) NOT NULL,".
		"  `Fax` varchar(128) NOT NULL,".
		"  `HomePhone` varchar(128) NOT NULL,".
		"  `WorkPhone` varchar(128) NOT NULL,".
		"  `Other` varchar(128) NOT NULL,".
		"  PRIMARY KEY (`ID`)".
		") ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	return (int)\TwoDot7\Database\Handler::Exec($TableStr)->errorInfo()[0] === 0 ;
}

?>