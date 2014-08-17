<?php
namespace TwoDOt7\Bit\in_ac_ducic_tabs\Controller;

function init() {
	switch ($_GET['BitAction']) {
		case 'interface':
			if (!\TwoDot7\User\Session::Exists()) {
				\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
					'Call' => 'Error',
					'ErrorMessageHead' => 'You need to Login First.',
					'ErrorMessageFoot' => 'You cannot access this page without Logging In.',
					'ErrorCode' => 'UserError: Restricted Area Access Attempt',
					'Code' => 403,
					'Title' => '403 Unauthorized',
					'Mood' => 'RED'));
				die();
			}
			if (!\TwoDot7\User\Access::Check(array(
				'UserName' => \TwoDot7\User\Session::Data()['UserName'],
				'Domain' => 'in.ac.ducic.tabs.usesssr'))) {

				\TwoDot7\Util\Log('User '.\TwoDot7\User\Session::Data()['UserName']. ' attempted acess to Bit TABS interface Page.', 'ALERT');

				\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
					'Call' => 'Error',
					'ErrorMessageHead' => 'Insufficient Privilege ',
					'ErrorMessageFoot' => 'You cannot access this page, as you do not have enough Access Privilege. <span class="label label-danger">This action has been Logged</span>',
					'ErrorCode' => 'UserError: Restricted Area Access Attempt - '.\TwoDot7\User\Session::Data()['UserName'],
					'Code' => 403,
					'Title' => '403 Unauthorized',
					'Mood' => 'RED'));
				die();
			}

			return array(
				'Call' => '_Interface',
				'testData' => Utils::addIntoAddressBook(array(
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
		$Values = array(
			'FirstName' => isset($Data['FirstName']) ? $Data['FirstName'] : '',
			'LastName' => isset($Data['LastName']) ? $Data['LastName'] : '',
			'DisplayName' => isset($Data['DisplayName']) ? $Data['DisplayName'] : '',
			'NickName' => isset($Data['NickName']) ? $Data['NickName'] : '',
			'PrimaryEmail' => isset($Data['PrimaryEmail']) ? $Data['PrimaryEmail'] : '',
			'SecondEmail' => isset($Data['SecondEmail']) ? $Data['SecondEmail'] : '',
			'_AimScreenName' => isset($Data['_AimScreenName']) ? $Data['_AimScreenName'] : '',
			'HomeAddress' => isset($Data['HomeAddress']) ? $Data['HomeAddress'] : '',
			'HomeAddress2' => isset($Data['HomeAddress2']) ? $Data['HomeAddress2'] : '',
			'HomeCity' => isset($Data['HomeCity']) ? $Data['HomeCity'] : '',
			'HomeState' => isset($Data['HomeState']) ? $Data['HomeState'] : '',
			'HomeZipCode' => isset($Data['HomeZipCode']) ? $Data['HomeZipCode'] : '',
			'HomeCountry' => isset($Data['HomeCountry']) ? $Data['HomeCountry'] : '',
			'HomePhone' => isset($Data['HomePhone']) ? $Data['HomePhone'] : '',
			'WorkAddress' => isset($Data['WorkAddress']) ? $Data['WorkAddress'] : '',
			'WorkAddress2' => isset($Data['WorkAddress2']) ? $Data['WorkAddress2'] : '',
			'WorkCity' => isset($Data['WorkCity']) ? $Data['WorkCity'] : '',
			'WorkState' => isset($Data['WorkState']) ? $Data['WorkState'] : '',
			'WorkZipCode' => isset($Data['WorkZipCode']) ? $Data['WorkZipCode'] : '',
			'WorkCountry' => isset($Data['WorkCountry']) ? $Data['WorkCountry'] : '',
			'WorkPhone' => isset($Data['WorkPhone']) ? $Data['WorkPhone'] : '',
			'JobTitle' => isset($Data['JobTitle']) ? $Data['JobTitle'] : '',
			'Department' => isset($Data['Department']) ? $Data['Department'] : '',
			'Company' => isset($Data['Company']) ? $Data['Company'] : '',
			'CellularNumber' => isset($Data['CellularNumber']) ? $Data['CellularNumber'] : '',
			'FaxNumber' =>isset($Data['FaxNumber']) ? $Data['FaxNumber'] : ''
			);
		$QueryString = 
			"INSERT INTO `_bit_in.ac.ducic.tabs.addressbook` ".
			"(FirstName, LastName, DisplayName, NickName, Pri".
			"maryEmail, SecondEmail, _AimScreenName, HomeAddr".
			"ess, HomeAddress2, HomeCity, HomeState, HomeZipC".
			"ode, HomeCountry, HomePhone, WorkAddress, WorkAd".
			"dress2, WorkCity, WorkState, WorkZipCode, WorkCo".
			"untry, WorkPhone, JobTitle, Department, Company,".
			" CellularNumber, FaxNumber) VALUES (:FirstName, ".
			":LastName, :DisplayName, :NickName, :PrimaryEmai".
			"l, :SecondEmail, :_AimScreenName, :HomeAddress, ".
			":HomeAddress2, :HomeCity, :HomeState, :HomeZipCo".
			"de, :HomeCountry, :HomePhone, :WorkAddress, :Wor".
			"kAddress2, :WorkCity, :WorkState, :WorkZipCode, ".
			":WorkCountry, :WorkPhone, :JobTitle, :Department".
			", :Company, :CellularNumber, :FaxNumber)";
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
		"   `FirstName` varchar(255) NOT NULL, ".
		"   `LastName` varchar(255) NOT NULL, ".
		"   `DisplayName` varchar(255) NOT NULL, ".
		"   `NickName` varchar(255) NOT NULL, ".
		"   `PrimaryEmail` varchar(255) NOT NULL, ".
		"   `SecondEmail` varchar(255) NOT NULL, ".
		"   `_AimScreenName` varchar(255) NOT NULL, ".
		"   `HomeAddress` varchar(255) NOT NULL, ".
		"   `HomeAddress2` varchar(255) NOT NULL, ".
		"   `HomeCity` varchar(255) NOT NULL, ".
		"   `HomeState` varchar(255) NOT NULL, ".
		"   `HomeZipCode` varchar(255) NOT NULL, ".
		"   `HomeCountry` varchar(255) NOT NULL, ".
		"   `HomePhone` varchar(255) NOT NULL, ".
		"   `WorkAddress` varchar(255) NOT NULL, ".
		"   `WorkAddress2` varchar(255) NOT NULL, ".
		"   `WorkCity` varchar(255) NOT NULL, ".
		"   `WorkState` varchar(255) NOT NULL, ".
		"   `WorkZipCode` varchar(255) NOT NULL, ".
		"   `WorkCountry` varchar(255) NOT NULL, ".
		"   `WorkPhone` varchar(255) NOT NULL, ".
		"   `JobTitle` varchar(255) NOT NULL, ".
		"   `Department` varchar(255) NOT NULL, ".
		"   `Company` varchar(255) NOT NULL, ".
		"   `CellularNumber` varchar(255) NOT NULL, ".
		"   `FaxNumber` varchar(255) NOT NULL, ".
		"  PRIMARY KEY (`ID`)".
		") ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	return (int)\TwoDot7\Database\Handler::Exec($TableStr)->errorInfo()[0] === 0 ;
}

?>