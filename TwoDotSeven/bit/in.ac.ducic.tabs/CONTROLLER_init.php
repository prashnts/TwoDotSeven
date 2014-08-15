<?php
namespace TwoDOt7\Bit\in_ac_ducic_tabs\Controller;

function init() {
	switch ($_GET['BitAction']) {
		case 'interface':
			Utils::deleteFromAddressBook(1);
			return array(
				'Call' => '_Interface',
				'testData' => Utils::addIntoAddressBook(array(
					'Fax' => 901122,
					'Name' => 'prashant sinha',
					'Email' => 'prashantsinha@outlook.com'
					))
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

class Utils {
	public static function addIntoAddressBook($Data = array()) {
		$Defaults = array(
			'Name' => "Leo Waldez",
			'Email' => "waldez@camphalfblood.com",
			'ChatName' => "",
			'Organization' => "",
			'NickName' => "",
			'AdditionalEmail' => "",
			'Department' => "",
			'Title' => "",
			'Mobile' => "",
			'Pager' => "",
			'Fax' => "",
			'HomePhone' => "",
			'WorkPhone' => "",
			'Other' => json_encode(array())
			);
		$Values = array_merge($Defaults, $Data);
		$QueryString = 
			"INSERT INTO `_bit_in.ac.ducic.tabs.addressbook`".
			"(Name, Email, ChatName, Organization, NickName, AdditionalEmail, Department, ".
			"Title, Mobile, Pager, Fax, HomePhone, WorkPhone, Other) VALUES (:Name, :Email".
			", :ChatName, :Organization, :NickName, :AdditionalEmail, :Department, :Title,".
			" :Mobile, :Pager, :Fax, :HomePhone, :WorkPhone, :Other)";
		$Response = \TwoDot7\Database\Handler::Exec($QueryString, $Values)->rowCount();
		return (bool)$Response;
	}
	public static function deleteFromAddressBook($ID) {
		//
		$QueryString = "DELETE FROM `_bit_in.ac.ducic.tabs.addressbook` WHERE ID = :ID";
		$Response = \TwoDot7\Database\Handler::Exec($QueryString, array(
			'ID' => $ID
			))->rowCount();
		return (bool)$Response;
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