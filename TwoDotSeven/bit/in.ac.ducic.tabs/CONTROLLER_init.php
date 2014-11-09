<?php
namespace TwoDot7\Bit\in_ac_ducic_tabs\Controller;
use \TwoDot7\Bit\in_ac_ducic_tabs as Node;
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

			$AdminFlag = \TwoDot7\User\Access::Check(
				array(
					'UserName' => \TwoDot7\User\Session::Data()['UserName'],
					'Domain' => 'in.ac.ducic.tabs.admin'
					)
				);

			$UserFlag = \TwoDot7\User\Access::Check(
				array(
					'UserName' => \TwoDot7\User\Session::Data()['UserName'],
					'Domain' => 'in.ac.ducic.tabs.user'
					)
				);

			$SuperUserFlag = \TwoDot7\User\Access::Check(
				array(
					'UserName' => \TwoDot7\User\Session::Data()['UserName'],
					'Domain' => 'in.ac.ducic.tabs.superuser'
					)
				);

			if (!($AdminFlag || $UserFlag || $SuperUserFlag)) {

				\TwoDot7\Util\Log('User '.\TwoDot7\User\Session::Data()['UserName']. ' attempted access to Bit TABS interface Page.', 'ALERT');

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

			$ShowOptions = array(
				'AddButton' => false,
				'DeleteButtons' => false,
				'UpdateButtons' => false
				);

			$Contacts = Utils::getArray();

			return array(
				'Call' => '_Interface',
				'AddressBookData' => Utils::getArray(),
				'Buttons' => array(
					'Add' => ($AdminFlag || $SuperUserFlag),
					'Delete' => $AdminFlag,
					'Update' => $AdminFlag
					),
				'View' => "Grid"
				);

		default:
			return array(
				'Call' => 'FourOFour');
	 }
}

class Utils {
	public static function addIntoAddressBook($Data = array()) {

		if (!isset($Data['FirstName']) ||
			!isset($Data['PrimaryEmail'])) {
			return False;
		}

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
	public static function getArray() {
		$QueryString = "SELECT * FROM `_bit_in.ac.ducic.tabs.addressbook`";
		$Response = \TwoDot7\Database\Handler::Exec($QueryString)->fetchAll();
		return $Response;
	}
	public static function getCardByID($ID) {

		if (!is_numeric($ID)) return False;

		$QueryString = "SELECT * FROM `_bit_in.ac.ducic.tabs.addressbook` WHERE ID=:ID";
		$Response = \TwoDot7\Database\Handler::Exec($QueryString, array('ID' => $ID))->fetchAll();
		return $Response;
	}
	public static function deleteCardByID($ID) {
		//
		$QueryString = "DELETE FROM `_bit_in.ac.ducic.tabs.addressbook` WHERE ID = :ID";
		$Response = \TwoDot7\Database\Handler::Exec($QueryString, array(
			'ID' => $ID
			))->rowCount();
		return (bool)$Response;
	}
	public static function updateCardByID($ID, $Data=array()) {

		if (!isset($Data['FirstName']) ||
			!isset($Data['PrimaryEmail']) ||
			!isset($ID)) {
			return False;
		}

		if (!is_numeric($ID)) return False;

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
			'FaxNumber' =>isset($Data['FaxNumber']) ? $Data['FaxNumber'] : '',
			'ID' => $ID
			);
		$QueryString = 
			"UPDATE `_bit_in.ac.ducic.tabs.addressbook` SET F".
			"irstName = :FirstName, LastName = :LastName, Dis".
			"playName = :DisplayName, NickName = :NickName, P".
			"rimaryEmail = :PrimaryEmail, SecondEmail = :Seco".
			"ndEmail, _AimScreenName = :_AimScreenName, HomeA".
			"ddress = :HomeAddress, HomeAddress2 = :HomeAddre".
			"ss2, HomeCity = :HomeCity, HomeState = :HomeStat".
			"e, HomeZipCode = :HomeZipCode, HomeCountry = :Ho".
			"meCountry, HomePhone = :HomePhone, WorkAddress =".
			" :WorkAddress, WorkAddress2 = :WorkAddress2, Wor".
			"kCity = :WorkCity, WorkState = :WorkState, WorkZ".
			"ipCode = :WorkZipCode, WorkCountry = :WorkCountr".
			"y, WorkPhone = :WorkPhone, JobTitle = :JobTitle,".
			" Department = :Department, Company = :Company, C".
			"ellularNumber = :CellularNumber, FaxNumber = :Fa".
			"xNumber WHERE ID = :ID ";

		$Response = \TwoDot7\Database\Handler::Exec($QueryString, $Values)->rowCount();
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