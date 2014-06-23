<?php
/*	  ______________  ____  _  ______
	 / ___/  _/ ___/ / __ \/ |/ / __/
	/ /___/ // /__  / /_/ /    / _/  
	\___/___/\___/  \____/_/|_/___/  
	
	>CIC One< Base Library.
	<api/lib.php>
	For documentation, please write to the author.
	Written for CIC One, by Prashant Sinha <prashantsinha@outlook.com>
*/

#error_reporting(E_ALL);

/**
 **	@internal: 	Base Library. 
 **	@internal:	General Functions:		f<Function Name>()
 **	@internal:	Auxilary Functions:		af<Functopn Name>()
 **	@internal:	UI Functions:			t<Function Name>()
 ** @internal:	Auxilary UI Functions:	atf<Function Name()
 **	@internal:	Classes:				<Class Name>
 **	@author:	Prashant Sinha <prashantsinha@outlook.com>
 **	@package:	CIC One API
 **	@since:		v0 20140214
**/

# afPutLog() constants.
define("SILENT"		,	0);
define("DEBUG"		,	1);
define("ALERT"		,	2);
define("DIE"		,	3);

class DatabaseHandle {

	/**
	 **	@internal:	All the Database handles are defined in here.
	 **	@internal:	Please Read Formatting/Indentation guide before pushing any changes.
	 **	@internal:	Class Hirarchy:	Base
	 **	@internal:	Authorization:	Not applicable. Depends on function in which Instance has been created.
	 **	@internal:	Clearance:	Top
	 **	@internal:	DEBUG Information: Check if MySQL is running before running Debug Codes.
	 **	@author:	Prashant Sinha <prashantsinha@outlook.com>
	 **	@package:	CIC One API
	 **	@since:		v1 20140323
	 **	@todo:		Under Development, Status: Nearing Completion.
	**/

	private $DbHandle;
	private static $Count=0;

	function __construct() {

		/**
		 **	@internal:	Constructor function. Builds the Handle object.
		 ** @author: 	Prashant Sinha <prashantsinha@outlook.com>
		 **	@package:	CIC One API
		 **	@param:		No Arguments.
		 **	@return:	Bool, corresponding to whether PDO object was created or not.
		 **	@since:		v1.1 20140323
		 **	@version:	v1
		 **	@todo:		Status- Complete.
		**/

		try {
			$this->DbHandle = new PDO("mysql:host=".SqlHost.";dbname=".SqlDbName, SqlUsername, SqlPassword);
			DatabaseHandle::$Count++;
			return TRUE;
		}
		catch (PDOException $E) {
			afPutLogEntry ($E->getMessage(), DEBUG);
			return FALSE;
		}
	}

	public function qUserRegister ($Insert, $__Arg) {

		/**
		 **	@internal:	Supportive Function to the function fRegisterAccount.
		 **	@internal:	Please Read Formatting/Indentation guide before pushing any changes.
		 ** @author: 	Prashant Sinha <prashantsinha@outlook.com>
		 **	@package:	CIC One API
		 **	@param:		$Insert- Insertion Array.
		 **	@param:		$__Arg- Mode.
		 **	@return:	Changes in database. Or, Boolean.
		 **	@since:		v1.1 23.March.2014
		 **	@version:	v1
		 **	@todo:		Status- Complete.
		**/
		
		// Designation Cheat: {	(0, Unconfirmed User), 
		//						(1, Student), 
		//						(2, Faculty), 
		//						(3, Staff), 
		//						(4, Student Admin), 
		//						(5, Faculty Admin), 
		//						(6, Staff Admin)}
		
		// Status Cheat: {	(-2, Banned Permanently),
		//					(-1, Banned Temporarily and Flagged),
		//					(0, Never Reviewed),
		//					(1, Currently Flagged for Review),
		//					(2, Verified But some crutial changes have been made),
		//					(4, Verified),
		//					(9, Verified + All area access)}
		
		switch ($__Arg) {
			case 'UserRegStep1':	
				try {
					$BindingOne = $this->DbHandle->prepare("INSERT INTO oneusers (UserName, Password, Clearance, Hash, AcInfo, Status) VALUES (:UserName, :Password, :Clearance, :Hash, :AcInfo, :Status)");
					$BindingTwo = $this->DbHandle->prepare("INSERT INTO oneusermeta (UserName, Name, Designation, DesignationMeta, EMail, Misc, MetaAlerts, MetaInfo) VALUES (:UserName, :Name, :Designation, :DesignationMeta, :EMail, :Misc, :MetaAlerts, :MetaInfo)");
					$BindingOne->execute(array( 'UserName'	=>	$Insert['UserName'],
												'Password'	=>	$Insert['PassSalt'],
												'Clearance'	=>	serialize(array(	'Code'			=> 	0,
																					'PrettyCode'	=>	'Account Not Configured',
																					'UIClass'		=>	'danger',
																					'Message'		=>	'Please complete your registration.')),
												'Hash'		=>	'Not Set',
												'AcInfo'	=>	serialize(array(	'LoginCount' 	=>	0,
																					'TimeStamp' 	=>	time(),
																					'LastLoginIP'	=>	'0.0.0.0',
																					'LastLogoutIP'	=>	'0.0.0.0',
																					'ExtraVar'		=>	array(	'Confirmed'			=>	FALSE,
																												'Verified'			=>	FALSE,
																												'VerifiedBy'		=>	"Unknown",
																												'ConfirmationCode'	=>	substr(md5(strtolower($Insert['UserName'])), 0,5)))),
												'Status'	=>	0));
					$BindingTwo->execute(array( 'UserName'			=>	$Insert['UserName'], 
												'EMail'				=>	$Insert['EMail'],
												'Name'				=>	'-',
												'Designation'		=>	0,
												'DesignationMeta'	=>	serialize(array(	'Custom'		=>	FALSE,
																							'Code'/*RN,ID*/	=>	FALSE,
																							'Title'			=>	FALSE,
																							'Course'		=>	FALSE,
																							'Semester'		=>	FALSE,
																							'Designation'	=>	FALSE)),
												'Misc'				=>	serialize(array(	'DateOfBirth'	=>	FALSE,
																							'CellPhone'		=>	FALSE,
																							'Gender'		=>	FALSE,
																							'Address'		=>	FALSE,
																							'DPLocation'	=>	'ui/images/UserPic.png',
																							'CoverPic'		=>	'ui/images/CoverDefault.jpg',
																							'ExtraVar'		=>	array())),
												'MetaAlerts'		=>	serialize(array(	array(	'AlertType'	=>	'Info',
																									'ID'		=>	md5(strtolower('This is your Notification Panel. It contains everything important, that you need to know.')),
																									'Header'	=>	'Welcome',
																									'Content'	=>	'This is your Notification Panel. It contains everything important, that you need to know.',
																									'Dismissed'	=>	FALSE))),
												'MetaInfo'			=>	serialize(array(	'Hubs'		=>	array(),
																							'Groups'	=>	array()))));
		
					return ($BindingOne->rowCount() + $BindingTwo->rowCount());
				}
				catch (PDOException $E) {
					afPutLogEntry ($E->getMessage(), DEBUG);
					return FALSE;
				}
				break; #Not needed, because the Return Event has been called.
			case 'UserRegStep2':
				$UserName=$Insert['UserName'];
				if ($Insert['ConfirmationCode']==afNames($UserName, "ConfirmationCode")) {
					try {
						$BindingOne = $this->DbHandle->prepare("UPDATE oneusers SET AcInfo=:AcInfo WHERE UserName=:UserName");
						$AcInfo=unserialize($this->qQuery("SELECT * FROM oneusers WHERE UserName=:UserName", array('UserName'=>$UserName))->fetch()['AcInfo']);
						$AcInfo['ExtraVar']['Confirmed']=TRUE;
						$AcInfo=serialize($AcInfo);
						$BindingOne->execute(array('AcInfo'=>$AcInfo,'UserName'=>$UserName));
						afPutLogEntry ("User $UserName successfully confirmed their EMail account. No action required.", SILENT);
						return TRUE;
					}
					catch(PDOException $E) {
						afPutLogEntry ($E->getMessage(), DEBUG);
						return FALSE;
					}
				}

				else {
					afPutLogEntry ("User $UserName could not confirm their EMail account. Action may be required.", ALERT);
					return FALSE;
				}
				break;
		}
	}

	public function qQuery ($Query, $Arr) {

		/**
		 **	@internal	Does the General Queries. Returns PDO Query Object.
		 ** @author 	Prashant Sinha <prashantsinha@outlook.com>
		 **	@package	CIC One API
		 **	@param		$Query: Insertion Binding.
		 **	@param:		$Arr: Placeholder Data.
		 **	@return		Changes in database. Or, Boolean.
		 **	@since		v1.1 20140324
		 **	@version	v2.0 20140422: Added proper Binding, to prevent possible SQL layer One Injection.
		 **	@todo		Status- Complete.
		**/

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

	public function strQuote($String) { 
		return $this->DbHandle->quote($String);
	}
}

class UserMeta {

	/**
	 **	@internal	Uses the DataBase handle to gather information about the user, using only the username.
	 **	@internal	Please Read Formatting/Indentation guide before pushing any changes.
	 **	@internal	Class Hirarchy:	Base.
	 **	@internal	Authorization:	Not applicable. Depends on function in which Instance has been created.
	 **	@internal	Clearance:	Top
	 **	@internal	DEBUG Information: Check if MySQL is running before running Debug Codes.
	 **	@author		Prashant Sinha <prashantsinha@outlook.com>
	 **	@package	CIC One API
	 **	@since		v1 06.April.2014
	 **	@todo		Under Development, Status: Nearing Completion.
	**/

	private $UserData;
	private $Clearance;
	private $AcInfo;
	private $UserName;
	private $Status;

	function __construct($UserNameIn) {

		/**
		 **	@internal	Constructor function. Builds the User object.
		 ** @author 	Prashant Sinha <prashantsinha@outlook.com>
		 **	@package	CIC One API
		 **	@param		No Arguments.
		 **	@return		None.
		 **	@throws		Bad User Exception.
		 **	@since		v1.1 20140406
		 **	@version	v1 20140413
		 **	@todo		Status- Complete.
		**/
		
		if($UserNameIn=="Guest") {
			# Populate Guest Friendly Variables.
			$this->afPopulateGuestUserData();
		}
		else {
			# Check If user exists
			if(!fCheckRedundant($UserNameIn, 'UserName', 'oneusers')) {
				throw new Exception("No such User exists.", 1);
			}

			# Create Database Handle.
			$Handle				=	new DatabaseHandle;
			$this->UserName		=	$UserNameIn;

			# Get Data.
			$this->UserData		=	$Handle->qQuery("SELECT * FROM oneusermeta WHERE UserName=:UserName", array('UserName'=>$UserNameIn))->fetch();
			$this->Clearance	=	unserialize($Handle->qQuery("SELECT Clearance FROM oneusers WHERE UserName=:UserName", array('UserName'=>$UserNameIn))->fetch()['Clearance']);
			$this->AcInfo		=	unserialize($Handle->qQuery("SELECT AcInfo FROM oneusers WHERE UserName=:UserName", array('UserName'=>$UserNameIn))->fetch()['AcInfo']);
			$this->Status		=	$Handle->qQuery("SELECT Status FROM oneusers WHERE UserName=:UserName", array('UserName'=>$UserNameIn))->fetch()['Status'];

			# Explode and Replace Data.
			$this->UserData['Misc']				=	unserialize($this->UserData['Misc']);
			$this->UserData['DesignationMeta']	=	unserialize($this->UserData['DesignationMeta']);
		}
	}
	public function GetData($__Arg, $Auth=FALSE) {
		switch($__Arg) {
			case 'Public':		return array(	'Depth'				=> 'Public',
												'UserName'			=> $this->UserName,
												'UIClass'			=> $this->afGetUIClass(),
												'Name'				=> $this->UserData['Name'],
												'Bio'				=> $this->afGetTitle(),
												'Designation'		=> $this->UserData['Designation'],
												'DesignationMeta'	=> $this->UserData['DesignationMeta'],
												'EMail'				=> $this->UserData['EMail'],
												'DPLocation'		=> $this->UserData['Misc']['DPLocation'],
												'CoverLocation'		=> $this->UserData['Misc']['CoverPic'],
												'Badge'				=> ($this->Status==0 || $this->Status==1)? FALSE : TRUE);
								break;
			case 'Private':		return array(	'Depth'				=> 'Private',
												'UserName'			=> $this->UserName,
												'UIClass'			=> $this->afGetUIClass(),
												'Name'				=> $this->UserData['Name'],
												'Bio'				=> $this->afGetTitle(),
												'Designation'		=> $this->UserData['Designation'],
												'DesignationMeta'	=> $this->UserData['DesignationMeta'],
												'EMail'				=> $this->UserData['EMail'],
												'Gender'			=> $this->UserData['Misc']['Gender'],
												'DPLocation'		=> $this->UserData['Misc']['DPLocation'],
												'CoverLocation'		=> $this->UserData['Misc']['CoverPic'],
												'DateOfBirth'		=> $this->UserData['Misc']['DateOfBirth'],
												'CellPhone'			=> $this->UserData['Misc']['CellPhone'],
												'Address'			=> $this->UserData['Misc']['Address'],
												'Badge'				=> ($this->Status==0 || $this->Status==1)? FALSE : TRUE);
								break;
			case 'Clearance':	return $this->Clearance;
			case 'Mini':		return array(	'Depth'				=> 'Mini',
												'UserName'			=> $this->UserName,
												'UIClass'			=> $this->afGetUIClass(),
												'Name'				=> $this->UserData['Name'],
												'Bio'				=> $this->afGetTitle(),
												'DPLocation'		=> $this->UserData['Misc']['DPLocation'],
												'CoverLocation'		=> $this->UserData['Misc']['CoverPic'],
												'Badge'				=> ($this->Status==0 || $this->Status==1)? FALSE : TRUE);
		}
	}
	private function afGetBio() {
		switch ($this->UserData['Designation']) {
			// Pass
		}
	}
	private function afGetTitle() {
		switch ($this->UserData['Designation']) {
			case 0	:	# Unconfirmed Person
						return "Someone";
			case 1	:	# Student
			case 4	:	# Student Admin
						$Minion = $this->UserData['DesignationMeta']['Semester'];
						$Sem = $Minion.substr(date('jS', mktime(0,0,0,1,($Minion%10==0?9:($Minion%100>20?$Minion%10:$Minion%100)),2000)),-2);
						$Title	=	(strlen($this->UserData['DesignationMeta']['Custom'])>1)	?	$this->UserData['DesignationMeta']['Custom']	.	". "	: "";
						$Title	.=	(((int)($this->UserData['Designation']) >= 4) && ((int)$this->Status >= 2)) ? 'Administrator. ' : '';
						$Title	.=	(strlen($this->UserData['DesignationMeta']['Course'])>1)	?	$this->UserData['DesignationMeta']['Course']	.	". "	: "";
						$Title	.=	(strlen($Sem)>1)											?	$Sem											.	" Sem."	: "";
						return $Title;
			case 2	:	# Faculty.
			case 5	:	# Faculty Admin.
						$Title	=	(strlen($this->UserData['DesignationMeta']['Custom'])>1)		?	$this->UserData['DesignationMeta']['Custom']		.	". "	: "";
						$Title	.=	(strlen($this->UserData['DesignationMeta']['Designation'])>1)	?	$this->UserData['DesignationMeta']['Designation']	.	". "	: "";
						$Title	.=	(((int)($this->UserData['Designation']) >= 4) && ((int)$this->Status >= 2)) ? 'Administrator.' : '';
						return $Title;
			case 3	:	# Staff.
			case 6	:	# Staff Admin.
						$Title	=	(strlen($this->UserData['DesignationMeta']['Custom'])>1)	?	$this->UserData['DesignationMeta']['Custom']	.	". "	: "";
						$Title	.=	(strlen($this->UserData['DesignationMeta']['Title'])>1)		?	$this->UserData['DesignationMeta']['Title']		.	". "	: "";
						$Title	.=	(((int)($this->UserData['Designation']) >= 4) && ((int)$this->Status >= 2)) ? 'Administrator.' : '';
						return $Title;
			default	:	# Default Case. Should NEVER reach here. But in rare cases, when it might:
						afPutLog("Wrong Case reached. function UserMeta::afGetTitle() Dump:".json_encode($UserName).json_encode($this->UserData), DEBUG);
						return "null";
		}
	}
	public function PutMeta($Data) {
		$Handle = new DatabaseHandle;

		# Build the Update String.
		# Raw Containers.
		$QueryString		=	'UPDATE oneusermeta SET '; # .. UPDATE oneusermeta SET Name=:Name, Designation=:Designation, DesignationMeta=:DesignationMeta, Misc=:Misc WHERE UserName=:UserName;
		$QueryArray			=	array();
		$VerifyStr			=	'UPDATE oneusers SET ';
		$VerifyArray		=	array();

		# BEHOLD! AWESOMENESS AHEAD!.

		# Find out if Meta::Name was changed. if yes, concat it to query string.
		$FlagName			=	isset($Data['Name']) && (((strtolower($this->UserData['Name'])!=strtolower($Data['Name']))) ? TRUE : FALSE);
		$QueryString		.=	$FlagName ? 'Name=:Name' : '';
		$FlagName			?	($QueryArray['Name'] = htmlspecialchars($Data['Name'])) : TRUE;

		# Find out if Meta::Designation was changed. If true, un-verify the user, and concat it to query string.
		$FlagDesignation 	=	isset($Data['Designation']) && ($this->UserData['Designation'] != $Data['Designation']) ? TRUE : FALSE;
		$QueryString		.=	$FlagDesignation && $FlagName ? ', ' : '';
		$QueryString		.=	$FlagDesignation ? 'Designation=:Designation' : '';
		$FlagDesignation	?	($QueryArray['Designation'] = htmlspecialchars($Data['Designation'])) : TRUE;

		# Find out if any field in Meta::DesignationMeta was changed. If yes, FLUSH all the previous data with new one.
		$TestMeta1			=	(isset($Data['DesignationMeta']) && isset($Data['DesignationMeta']['Code']) ) && ($this->UserData['DesignationMeta']['Code']					!= $Data['DesignationMeta']['Code']);				# Roll Number or ID.
		$TestMeta2			=	(isset($Data['DesignationMeta']) && isset($Data['DesignationMeta']['Title']) ) && ($this->UserData['DesignationMeta']['Title']				!= $Data['DesignationMeta']['Title']);				# Title
		$TestMeta3			=	(isset($Data['DesignationMeta']) && isset($Data['DesignationMeta']['Course']) ) && ($this->UserData['DesignationMeta']['Course']				!= $Data['DesignationMeta']['Course']);				# Course
		$TestMeta4			=	(isset($Data['DesignationMeta']) && isset($Data['DesignationMeta']['Semester']) ) && ($this->UserData['DesignationMeta']['Semester']			!= $Data['DesignationMeta']['Semester']);			# Semester
		$TestMeta5			=	(isset($Data['DesignationMeta']) && isset($Data['DesignationMeta']['Designation']) ) && ($this->UserData['DesignationMeta']['Designation']	!= $Data['DesignationMeta']['Designation']);		# Designation
		$TestMeta6			=	(isset($Data['DesignationMeta']) && isset($Data['DesignationMeta']['Custom']) ) && ($this->UserData['DesignationMeta']['Custom']				!= $Data['DesignationMeta']['Custom']);				# Custom
		
		# Decide if we need to update the Meta::DesignationMeta and Append the Query Strings and the Query Array.
		$FlagDMeta			=	$TestMeta1 | $TestMeta2 | $TestMeta3 | $TestMeta4 | $TestMeta5 | $TestMeta6;
		$QueryString		.=	$FlagDMeta && ($FlagDesignation || $FlagName) ? ', ' : '';
		$QueryString		.=	$FlagDMeta ? 'DesignationMeta=:DesignationMeta ' : '' ;
		$FlagDMeta			?	($QueryArray['DesignationMeta'] = serialize(array(	'Code'			=>	$TestMeta1 ? htmlspecialchars($Data['DesignationMeta']['Code'])			:	$this->UserData['DesignationMeta']['Code'],
																					'Title'			=>	$TestMeta2 ? htmlspecialchars($Data['DesignationMeta']['Title'])		:	$this->UserData['DesignationMeta']['Title'],
																					'Course'		=>	$TestMeta3 ? htmlspecialchars($Data['DesignationMeta']['Course'])		:	$this->UserData['DesignationMeta']['Course'],
																					'Semester'		=>	$TestMeta4 ? htmlspecialchars($Data['DesignationMeta']['Semester'])		:	$this->UserData['DesignationMeta']['Semester'],
																					'Designation'	=>	$TestMeta5 ? htmlspecialchars($Data['DesignationMeta']['Designation'])	:	$this->UserData['DesignationMeta']['Designation'],
																					'Custom'		=>	$TestMeta6 ? htmlspecialchars($Data['DesignationMeta']['Custom'])		:	$this->UserData['DesignationMeta']['Custom']))) : TRUE;

		#Now let's see if we need to un-verify the User.
		# Process: See if this is the first time the user has entered the info, That is, Status == 0. Then change Status <= 1. Else, change Status <= 2
		$PrevStatus			=	(int)$this->Status;
		$NewStatus			=	( ($PrevStatus == 0) || ($PrevStatus == 1) ) ? 1 : ( ($PrevStatus >= 2 && $PrevStatus < 9) ? 2 : (($PrevStatus == 9) ? 9 : 0) );
		$FlagVerify			=	$FlagDesignation;
		$VerifyStr			.=	$FlagVerify ? ' Status=:Status' : '';
		$FlagVerify			?	($VerifyArray['Status'] = $NewStatus) : TRUE;

		# Find out if any field in Meta::Misc was changed. If yes, FLUSH all the previous data with new one.
		$TestMisc1			=	(isset($Data['Misc']) && isset($Data['Misc']['DateOfBirth'])) && ($this->UserData['Misc']['DateOfBirth']	!= $Data['Misc']['DateOfBirth']);				# Roll Number or ID.
		$TestMisc2			=	(isset($Data['Misc']) && isset($Data['Misc']['CellPhone'])) && ($this->UserData['Misc']['CellPhone']		!= $Data['Misc']['CellPhone']);					# Title
		$TestMisc3			=	(isset($Data['Misc']) && isset($Data['Misc']['Gender'])) && ($this->UserData['Misc']['Gender']			!= $Data['Misc']['Gender']);					# Course
		$TestMisc4			=	(isset($Data['Misc']) && isset($Data['Misc']['Address'])) && ($this->UserData['Misc']['Address']			!= $Data['Misc']['Address']);					# Semester
		
		# Decide if we need to update the Meta::Misc and Append the Query Strings and the Query Array.
		$FlagMisc			=	$TestMisc1 | $TestMisc2 | $TestMisc3 | $TestMisc4;
		$QueryString		.=	$FlagMisc && ($FlagDMeta || $FlagDesignation || $FlagName) ? ', ' : '';
		$QueryString		.=	$FlagMisc ? 'Misc=:Misc' : '' ;

		$FlagMisc			?	($QueryArray['Misc'] = serialize(array(	'DateOfBirth'	=>	$TestMisc1 ? htmlspecialchars($Data['Misc']['DateOfBirth'])	:	$this->UserData['Misc']['DateOfBirth'],
																		'CellPhone'		=>	$TestMisc2 ? htmlspecialchars($Data['Misc']['CellPhone'])	:	$this->UserData['Misc']['CellPhone'],
																		'Gender'		=>	$TestMisc3 ? htmlspecialchars($Data['Misc']['Gender'])		:	$this->UserData['Misc']['Gender'],
																		'Address'		=>	$TestMisc4 ? htmlspecialchars($Data['Misc']['Address'])		:	$this->UserData['Misc']['Address'],
																		'DPLocation'	=>	$this->UserData['Misc']['DPLocation'],	# These three from the Previously saved values.
																		'CoverPic'		=>	$this->UserData['Misc']['CoverPic'],
																		'ExtraVar'		=>	$this->UserData['Misc']['ExtraVar']))) : TRUE;

		# Complete the Query Strings:
		$QueryString		.=	' WHERE UserName=:UserName;';
		$QueryArray['UserName']	= $this->UserName;
		$VerifyStr			.=	' WHERE UserName=:UserName;';
		$VerifyArray['UserName']= $this->UserName;

		# NOT SO FAST!
		# Validate the data now.
		# Reason: It'd have been a pain to first check if the data has been updated. If not, then no need to validate as well.

		$ValidName			=	$FlagName			?	afValidateInput($Data['Name'], 'AlphaNumTimesWhite', 2, 128) 				: TRUE;
		$ValidDesignation	=	$FlagDesignation	?	afValidateInput($Data['Designation'], 'Designation')						: TRUE;
		$ValidMeta1			=	$TestMeta1			?	afValidateInput($Data['DesignationMeta']['Code'], 'AlphaNumWhite')			: TRUE;
		$ValidMeta2			=	$TestMeta2			?	afValidateInput($Data['DesignationMeta']['Title'], 'AlphaNumWhite') 		: TRUE;
		$ValidMeta3			=	$TestMeta3			?	afValidateInput($Data['DesignationMeta']['Course'], 'AlphaNumWhite') 		: TRUE;
		$ValidMeta4			=	$TestMeta4			?	afValidateInput($Data['DesignationMeta']['Semester'], 'AlphaNumWhite') 		: TRUE;
		$ValidMeta5			=	$TestMeta5			?	afValidateInput($Data['DesignationMeta']['Designation'], 'AlphaNumWhite') 	: TRUE;
		$ValidMeta6			=	$TestMeta6			?	afValidateInput($Data['DesignationMeta']['Custom'], 'AlphaNumWhite') 		: TRUE;
		$ValidMisc1			=	$TestMisc1			?	afValidateInput($Data['Misc']['DateOfBirth'], 'Date')						: TRUE;	
		$ValidMisc2			=	$TestMisc2			?	afValidateInput($Data['Misc']['CellPhone'], 'Tel')							: TRUE;	
		$ValidMisc3			=	$TestMisc3			?	afValidateInput($Data['Misc']['Gender'], 'AlphaNum')						: TRUE;	
		$ValidMisc4			=	$TestMisc4			?	afValidateInput($Data['Misc']['Address'], 'Address')						: TRUE;	

		# Gather Flags:

		$ShowdownFlags		=	$FlagName || $FlagDesignation || $FlagDMeta || $FlagMisc;
		$ShowdownValids		=	$ValidName && $ValidDesignation && 
								$ValidMeta1 && $ValidMeta2 && $ValidMeta3 && $ValidMeta4 && $ValidMeta5 && $ValidMeta6 && 
								$ValidMisc1 && $ValidMisc2 && $ValidMisc3 && $ValidMisc4;

		$ShallIDoIt			=	$ShowdownFlags & $ShowdownValids;

		# Generate Raw Response.
		$ResposeRaw	=	array(	'isValid'		=>	array(	'Name'							=>	$ValidName,
															'Desigation'					=>	$ValidDesignation,
															'DesignationMetaCode'			=>	$ValidMeta1,
															'DesignationMetaTitle'			=>	$ValidMeta2,
															'DesignationMetaCourse'			=>	$ValidMeta3,
															'DesignationMetaSemester'		=>	$ValidMeta4,
															'DesignationMetaDesignation'	=>	$ValidMeta5,
															'DesignationMetaCustom'			=>	$ValidMeta6,
															'MiscDateOfBirth'				=>	$ValidMisc1,
															'CellPhone'						=>	$ValidMisc2,
															'Gender'						=>	$ValidMisc3,
															'Address'						=>	$ValidMisc4),
								'PrevStatus'	=>	$PrevStatus,
								'NewStatus'		=>	$NewStatus,
								'Data'			=>	$Data,
								'hasChanged'	=>	array(	'Name'							=>	$FlagName,
															'Desigation'					=>	$FlagDesignation,
															'DesignationMetaCode'			=>	$TestMeta1,
															'DesignationMetaTitle'			=>	$TestMeta2,
															'DesignationMetaCourse'			=>	$TestMeta3,
															'DesignationMetaSemester'		=>	$TestMeta4,
															'DesignationMetaDesignation'	=>	$TestMeta5,
															'DesignationMetaCustom'			=>	$TestMeta6,
															'MiscDateOfBirth'				=>	$TestMisc1,
															'CellPhone'						=>	$TestMisc2,
															'Gender'						=>	$TestMisc3,
															'Address'						=>	$TestMisc4));

		# That's all folks! Done. :) Make Queries now.

		$DataBaseHandle = new DatabaseHandle;

		$Success1 = FALSE;
		$Success2 = FALSE;

		$Success1 = $FlagVerify ? ($Handle->qQuery($VerifyStr, $VerifyArray)->rowCount()) ? TRUE : FALSE : TRUE;
		$Success2 = $ShallIDoIt ? ($Handle->qQuery($QueryString, $QueryArray)->rowCount()) ? TRUE : FALSE : TRUE;

		$ResposeRaw['Success'] = (bool)$ShallIDoIt;
		$ResposeRaw['TimeStamp'] = time();
		$ResposeRaw['VerificationStatusChanged'] = $FlagVerify;

		return $ResposeRaw;
	}
	private function afGetUIClass() {
		switch ($this->UserData['Designation']) {
			case 0:		return 'ColorUndefined';	# Unspecified User.
			case 1:		return 'ColorStudent';		# Student.
			case 2:		return 'ColorFaculty';		# Faculty.
			case 3:		return 'ColorStaff';		# Staff.
			case 4:									# Admin - Student.
			case 5:									# Admin - Faculty.
			case 6:		return 'ColorAdmin';		# Admin - Staff.
			default:	header('location: error.php'); die();
		}
	}
	private function afPopulateGuestUserData() {
		# Populate Fake Variables
		$this->UserData		=	array(	'UserName'			=>	'Guest',
										'Name'				=>	'Guest',
										'EMail'				=>	'Guest@Example.com',
										'Designation'		=>	0,
										'DesignationMeta'	=>	array(	'Custom'		=> FALSE,
																		'Code'			=>	0,
																		'Title'			=>	'Some Unknown User',
																		'Course'		=>	'No Idea!',
																		'Semester'		=>	0,
																		'Designation'	=>	'Visitor'),
										'Misc'				=>	array(	'DateOfBirth'	=>	FALSE,
																		'CellPhone'		=>	'9999900000',
																		'Address'		=>	FALSE,
																		'DPLocation'	=>	'ui/images/UserPic.png',
																		'CoverPic'		=>	'ui/images/CoverDefault.jpg'));
		$this->Clearance	=	array(	'Code'				=>	0,
										'PrettyCode'		=>	'Unregistered User',
										'UIClass'			=>	'warning',
										'Message'			=> 	'Please register an account for personalized experience.');
		$this->AcInfo		=	array(	'LoginCount'		=>	0,
										'TimeStamp'			=>	time(),
										'LastLoginIP'		=>	'0.0.0.0',
										'LastLogoutIP'		=>	'0.0.0.0',
										'ExtraVar'			=>	array(	'Confirmed'			=>	TRUE,
																		'Verified'			=>	TRUE,
																		'VerifiedBy'		=>	'Code',
																		'ConfirmationCode'	=>	'LOLL')); 
		$this->Status		=	0;
	}
}

class UserMessages extends UserMeta {
	// TODO
}

class UserFeeds extends UserMeta {
	// TODO
}

class BroadCast {
	//
	private $Handle;
	function __construct() {
		$this->Handle = new DatabaseHandle;
	}
	public function pushBroadCast() {

	}
	public function pullBroadCast() {
		$Clearance = fSetCookie("Clearance");
	}
}



function fSetCookie($__Arg="Default") {

	/*
	**	Description: User Authorization.
	**	API Level: Not Applicable. Function for the Web-App only.
	**	Authorization: Not Required, Not an option.
	**	Clearance: Top / Not Vulnerable.
	**	Authored: prashant@ducic.ac.in
	**	Package: CIC One API
	**	First Commit: 03-24-2014
	**	Arguments:	$__Arg: Optional, Defines Return-type.
	*/

	if ( isset($_COOKIE["UserNameCookie"]) && 
		 isset($_COOKIE["UserHashCookie"])) {

		$Handle = new DatabaseHandle;
		$DbResult = $Handle->qQuery("SELECT * FROM oneusers WHERE UserName=:UserName", array('UserName'=>$_COOKIE["UserNameCookie"]))->fetch();
		
		if ($DbResult["Hash"]==$_COOKIE["UserHashCookie"]) {
			if ($__Arg=="Default") {
				return 1;
			}
			elseif ($__Arg=="Clearance") {
				return $DbResult["Clearance"];
			}
			elseif ($__Arg=="UserName") {
				return $DbResult["UserName"];
			}
			else {
				afPutLogEntry ("Bad Argument in function fSetCookie.", DEBUG);
				return 0;
			}
		}
		else {
			afPutLogEntry ("Failed User Query, Bad Cookie. User: ".$_COOKIE["UserNameCookie"], ALERT);
			setcookie("UserNameCookie", "", 1, '/');
			setcookie("UserHashCookie", "", 1, '/');
			return 0;
		}
	}
	else {
		return 0;
	}
}

function afNames($Var, $__Arg="Salt") {

	/*
	**	Description: Returns a Good-Looking name. (Auxilary-Function-Names)
	**	API Level: Not Applicable. Auxilary function.
	**	Authorization: Not Required, Not an option.
	**	Clearance: Not Applicable.
	**	Authored: prashant@ducic.ac.in
	**	Package: CIC One API
	**	First Commit: 03-24-2014
	**	Arguments:	$__Arg: Optional, Defines Return-type.
	**				$Var: Required.
	*/

	global $SaltKey, $SaltTimes;

	if ($__Arg=="Salt") {
		$Var="$Var";
		for ($i=0; $i<$SaltTimes; $i++)
			$Var.=$SaltKey;
		return md5($Var);
	}
	elseif ($__Arg=="FileName") {
		return md5($Var);
	}
	elseif ($__Arg== "RandomHash") {
		$Var=str_shuffle("$Var");
		$Var.=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15);
		return md5($Var);
	}
	elseif ($__Arg== "ConfirmationCode") {
		return substr(md5(strtolower($Var)), 0,5);
	}
	else {
		afPutLogEntry ("Bad Argument in function fProcessNames.", DEBUG);
	}
}

function fCredentials($UserName, $Password, $__Arg="Check") {

	/*
	**	Description: Checks the Credentials supplied, against the Database, and returns accordingly. 
	**	API Level: Not Applicable. Auxilary function.
	**	Authorization: Not Required, Not an option.
	**	Clearance: Not Required, only does the Checks.
	**	Authored: prashant@ducic.ac.in
	**	Package: CIC One API
	**	First Commit: 03-24-2014
	**	Arguments:	$__Arg: Optional, Defines Return-type.
	**				$UserName: Required, SIA.
	**				$Password: Required, SIA.
	*/

	$Handle = new DatabaseHandle;
	$DbResult = $Handle->qQuery("SELECT * FROM oneusers WHERE UserName=:UserName", array('UserName'=>$UserName))->fetch();

	if(!$DbResult) {
		# No Matching User Found.
		return 0;
	}
	else {
		# User Matched, Verifying the Password.

		$DbPassword=$DbResult['Password'];
		$DbAcInfo=unserialize($DbResult['AcInfo']);

		if ($DbPassword==afNames($Password, "Salt")) {
			if ($__Arg=="Login") {
				if($DbAcInfo['LoginCount']>MAXIMUMCONCURRENTLOGINS | $DbAcInfo['LoginCount']==0) {
					# If Number of simultaneous logins exceeds MaximumConcurrentLogins, or, first-time login Discard previous hash, and re-login.
					$LoginHash=afNames($UserName, "RandomHash");
					$DbAcInfo['LoginCount']=1;
					$DbAcInfo['TimeStamp']=time();
					$DbAcInfo['LastLoginIP']=$_SERVER['REMOTE_ADDR'];

					$AcInfo=serialize($DbAcInfo);

					$LoginQuery="UPDATE oneusers SET Hash=:LoginHash, AcInfo=:AcInfo WHERE UserName=:UserName;";
					$ArQuery=array(	'LoginHash'		=>	$LoginHash, 
									'AcInfo'	=>	$AcInfo,
									'UserName'	=>	$UserName);
					$Handle->qQuery($LoginQuery, $ArQuery);

					return $LoginHash;
				}
				else {
					# Do nothing, just update last login and IP.
					$DbAcInfo['LoginCount']+=1;
					$DbAcInfo['TimeStamp']=time();
					$DbAcInfo['LastLoginIP']=$_SERVER['REMOTE_ADDR'];

					$AcInfo=serialize($DbAcInfo);

					$LoginQuery="UPDATE oneusers SET AcInfo=:AcInfo WHERE UserName=:UserName;";
					$ArQuery=array(	'AcInfo'	=>	$AcInfo,
									'UserName'	=>	$UserName);
					$Handle->qQuery($LoginQuery, $ArQuery);

					return $DbResult['Hash'];
				}
			}
			elseif ($__Arg=="Check") {
				return 1;
			}
		}
		else {
			afPutLogEntry("Bad Credentials supplied for user '$UserName'.", ALERT);
			return 0;
		}
	}
}

function fLogInOut($__Arg="Login") {

	/*
	**	Description: Logs User In-Out, depending on Argument. 
	**	API Level: Core.
	**	Authorization: Not Required, Not an option.
	**	Clearance: Not Required.
	**	Authored: prashant@ducic.ac.in
	**	Package: CIC One API
	**	First Commit: 03-25-2014
	**	Arguments:	$__Arg: Optional, Defines Process.
	*/

	/*
	** API is NOT FUNCTIONAL yet.
	** -Prashant Sinha
	** (Author)
	*/

	if ($__Arg=="Login") {

		/*
		**	Description: Logs user In.
		*/

		$LoginHash=fCredentials($_POST["UserName"], $_POST["Password"], "Login") ;

		if ( $LoginHash ){
			if(isset($_POST["Remember"])) {
				$Expire=time()+(30*24*60*60);
				setcookie("UserNameCookie", $_POST["UserName"], $Expire, '/');
				setcookie("UserHashCookie", $LoginHash, $Expire, '/');
			}
			else {
				setcookie("UserNameCookie", $_POST["UserName"], time()+(24*60*60), '/');
				setcookie("UserHashCookie", $LoginHash, time()+(24*60*60),'/');
			}
			afPutLogEntry("User '".$_POST["UserName"]."' successfully logged in.", SILENT);
			return 1;
		}
		else {
			afPutLogEntry("Failed Login for User '".$_POST["UserName"]."'.", ALERT);
			return 0;
		}
	}
	
	elseif ($__Arg=="Logout") {

		/*
		**	Description: Logs Out the user, and updates the database.
		*/

		$UserName=$_COOKIE["UserNameCookie"];
		$Hash=$_COOKIE["UserHashCookie"];
		setcookie("UserNameCookie", "", 1, '/');
		setcookie("UserHashCookie", "", 1, '/');

		$Handle=new DatabaseHandle;

		$UpdateQuery="SELECT AcInfo FROM oneusers WHERE UserName=:UserName";
		$AcInfo=$Handle->qQuery($UpdateQuery, array('UserName' => $UserName))->fetch()['AcInfo'];

		$DbAcInfo=unserialize($AcInfo);

		$DbAcInfo['LoginCount']-=1;
		$DbAcInfo['TimeStamp']=time();
		$DbAcInfo['LastLogoutIP']=$_SERVER['REMOTE_ADDR'];

		$AcInfo=serialize($DbAcInfo);

		$LogOutQuery="UPDATE oneusers SET AcInfo='$AcInfo' WHERE UserName=:UserName;";
		$AffectedRows=$Handle->qQuery($LogOutQuery, array('UserName' => $UserName))->rowCount();

		if($AffectedRows){
			afPutLogEntry("User '$UserName' successfully logged out.", SILENT);
			return 1;
		}
		else {
			return 0;
		}
	}
	else {
		afPutLogEntry("Failed Login for User '$UserName'.", ALERT);
		return 0;
	}
}

function fRegisterAccount($Step, $Response="JSON") {

	/*
	**	Description: User Account Registration Script.
	**	API Level: Core
	**	Authorization: Required, Fatal, Done in the Calling Script, IMPORTANT!
	**	Clearance: Top
	**	Authored: prashant@ducic.ac.in
	**	Package: CIC One API
	**	First Commit: 03-20-2014
	**	Arguments:	$AuthKey: Required, Private Key
	**				$AuthPrivate: Required, Private Key
	**				$Step: Required, Registration Step
	**				$Response: Optional, Determines Response Data Forma, Default is JSON
	*/

	/*
	** $Response is NOT FUNCTIONAL yet.
	** -Prashant Sinha
	** (Author)
	*/

	$Handle = new DatabaseHandle;

	switch ($Step) {
		case 1 	:	# Getting Posted variable's data.
					$Post = array(	'UserName'	=> $_POST["UserName"],
									'EMail'		=> $_POST["EMail"],
									'Password'	=> $_POST["Password"],
									'ConfPass'	=> $_POST["ConfPass"],
									'PassSalt'	=> NULL );
					
					$Validate=array('Success' => TRUE, 'Messages'=>array());

					if (!afValidateInput($Post['UserName'], "UserName") | !afValidateInput($Post['EMail'], "EMail")) {
						# True, if Bad Inputs are present.
						$Validate['Success']=FALSE;
						array_push($Validate['Messages'], array(	'Message' => 'The entries you made for fields are not correct. Please try again.', 
																	'MessageMode' => 'Error', 
																	'UIClass' => 'alert alert-danger alert-block'));
					}
					if (fCheckRedundant($Post['UserName'], "UserName", "oneusers")) {
						# True, if the Redundancy is Found.
						#return fResponse("","" );
						$Validate['Success']=FALSE;
						array_push($Validate['Messages'], array(	'Message' => 'The <strong>UserName</strong> you supplied is taken, <em>please choose a different one</em>.', 
																	'MessageMode' => 'Error', 
																	'UIClass' => 'alert alert-danger alert-block'));
					}
					if (fCheckRedundant($Post['EMail'], "EMail", "oneusermeta")) {
						$Validate['Success']=FALSE;
						array_push($Validate['Messages'], array(	'Message' => 'The <strong>EMail ID</strong> you supplied is already in our DataBase, please try again.', 
																	'MessageMode' => 'Error', 
																	'UIClass' => 'alert alert-danger alert-block'));
					}	# No Redundancy
					if ($Post['Password']!=$Post['ConfPass']|strlen($Post['Password'])<=5) {
						$Validate['Success']=FALSE;
						array_push($Validate['Messages'], array(	'Message' => 'Your <strong>Password</strong> seems wrong, please try again.', 
																	'MessageMode' => 'Error', 
																	'UIClass' => 'alert alert-danger alert-block'));
					}
					if (!$Validate['Success']) {
						#Break, now!
						return $Validate;
					}

					else {
						$Post['PassSalt']= afNames($Post['Password'], "Salt");
						$Response=$Handle->qUserRegister($Post, "UserRegStep1");
						if ($Response) {
							afPutLogEntry ("Successful Registration. Step 1. UserName: ".$Post['UserName']."; IP:".(string)$_SERVER['REMOTE_ADDR'].". No action required.", SILENT);
							return array( 	'Success' => TRUE, 
											'Messages' => array(
																array(
																		'Message' => 'Successfully Completed Step 1. Please Check your EMail and enter the code you have recieved.', 
																		'MessageMode' => 'Success', 
																		'UIClass' => 'alert alert-warning alert-block')));
						}
						else {
							afPutLogEntry ("Unsuccessful Registration. Step 1. Posted Data: ".json_encode($Post)."; IP:".(string)$_SERVER['REMOTE_ADDR'].".", ALERT);
							return array(	'Success' => FALSE, 
											'Messages' => array(
																array(
																		'Message' => 'Internal Error 500.', 
																		'MessageMode' => 'Error', 
																		'UIClass' => 'alert alert-danger alert-block'
																	),
																array(
																		'Message' => 'Cannot process your request.<br>Please try again later.', 
																		'MessageMode' => 'Error', 
																		'UIClass' => 'alert alert-warning alert-block'
																	),
																array(
																		'Message' => 'If this error persists, please contact us on: <a href="mailto:one@ducic.ac.in">one@ducic.ac.in</a>', 
																		'MessageMode' => 'Error', 
																		'UIClass' => 'alert alert-info alert-block')));
						}
					}
					break; # Break Not Needed, because RETURN event is called.
		case 2	:	
				/*	$UserName=unserialize(fCrypt($_GET['Arg'], "DECRYPT"))['UserName'];
					$Post = array(	'UserName' => $UserName,
									'ConfirmationCode' => $_POST["ConfirmationCode"] );
					*/
					if( $Handle->qUserRegister($_POST, "UserRegStep2") ) {
						return array(	'Success' => TRUE, 
										'Messages' => array(array(	'Message' => 'You have successfully confirmed your registration. Before your account is activated, you need to complete your Profile. Please click proceed to do it right now.',
																	'MessageMode' => 'Success',
																	'UIClass' => 'alert alert-success alert-block')));
					}
					else {
						return array(	'Success' => FALSE, 
										'Messages' => array(array(	'Message' => 'Wrong confirmation code entered. Please try again. Please contact us, if you are having trouble.',
																	'MessageMode' => 'Error',
																	'UIClass' => 'alert alert-danger alert-block')));
					}
	}
}

function fCheckRedundant($Var,$Field,$Table="oneusers") {

	/*
	**	Description: Checks for Already-Existing copies of stuffs.
	**	API Level: Not Applicable.
	**	Authorization: Not Applicable.
	**	Clearance: Top
	**	Authored: prashant@ducic.ac.in
	**	Package: CIC One API
	**	First Commit: 03-24-2014
	**	Arguments:	$Var: Required, 
	**				$AuthPrivate: Required, Private Key
	**				$Step: Required, Registration Step
	**				$Response: Optional, Determines Response Data Forma, Default is JSON
	*/

	$Handle = new DatabaseHandle;
	$Query="SELECT count(*) AS count FROM $Table WHERE $Field=:Var";
	$QueryResult=$Handle->qQuery($Query, array(	'Var'	=>	$Var))->fetch()['count'];
	if (!$QueryResult)
		return 0;
	else
		return 1;
}

function afPutLogEntry($Message, $__Arg=0) {

	/**
	 **	@internal	Maintains a System Log File.
	 ** @author 	Prashant Sinha <prashantsinha@outlook.com>
	 **	@package	CIC One API
	 **	@param		$Message- The Message to be stored in log file.
	 **	@param		$__Arg- Log file category.
	 **	@return		None.
	 **	@since		v0 20140324
	 **	@version	v1 20140505
	 **	@todo		Status- Complete.
	**/

	# Time Offset puts the Local Time, as stored in Config File.
	$UTC			=	time();
	$FormattedTime	=	date("{D,d-M-Y, H:i:s}",$UTC+TIMEOFFSET);

	# This finds the Log folder, and eliminates the multiple Log File locations.
	$AbsPath		=	$_SERVER['DOCUMENT_ROOT'];
	$AbsPath		.=	is_dir($AbsPath."/api/logs") ? "/api/logs" : is_dir($AbsPath."/".ROOTDIR."/api/logs") ? "/".ROOTDIR."/api/logs" : "" ;

	switch ($__Arg) {
		case SILENT	: fWrite(fopen("$AbsPath/InfoLog.log",	"a+"),	"$FormattedTime ($UTC)\t$Message\n");			break;
		case DEBUG	: fWrite(fopen("$AbsPath/DebugLog.log",	"a+"),	"$FormattedTime ($UTC)\t$Message\n");			break;
		case ALERT	: fWrite(fopen("$AbsPath/AlertLog.log",	"a+"),	"$FormattedTime ($UTC)\t$Message\n");			break;
		case DIE	: fWrite(fopen("$AbsPath/FatalLog.log",	"a+"),	"$FormattedTime ($UTC)\t$Message\n"); die();	break;
		default		: fWrite(fopen("$AbsPath/DebugLog.log",	"a+"),	"$FormattedTime ($UTC)\tBad Usage of function afPutLogEntry. Bad Argument\n");
	}
}

function fCrypt($String, $__Event, $__Arg=FALSE) {

	/*
	**	Description: Encrypts and Decrypts the Argumented string. The Keys are set in the Configuration File.
	**	API Level: Core
	**	Authorization: Not Required for event 'ENCRYPT', required for event 'DECRYPT'
	**	Clearance: Top
	**	Authored: prashant@ducic.ac.in
	**	Package: CIC One API
	**	First Commit: 03-27-2014
	**	Arguments:	$String: Required. String to be Encrypted or Decrypted.
	**				$__Event: Required. Specifies the Event.
	**				$__Arg: Optional: Defines the return Type.
	**				$PrivateKey: Optional. Overrides the Configured key. Not Functional Yet.
	*/

	global $PrivateKey, $InitialVector;

	$Method = "AES-256-CBC";

	$Key = hash('sha256', $PrivateKey);
	$Vector = substr(hash('sha256', $InitialVector), 0, 16);

	if($__Event == 'ENCRYPT') {
		return base64_encode(openssl_encrypt($String, $Method, $Key, 0, $Vector));
	}
	elseif($__Event == 'DECRYPT' ){
		return openssl_decrypt(base64_decode($String), $Method, $Key, 0, $Vector);
	}
}

function afCrypticStrCmp($Str1, $Str2) {
	$Diff = strlen($Str1) ^ strlen($Str2);
	for ($i=0; $i < strlen($Str1) && $i < strlen($Str2) ; $i++) { 
		$Diff |= ord($Str1[$i]) ^ ord($Str2[$i]);
	}
	return $Diff === 0;
}

function fAuth($Method, $Keys) {
	// Auth Method Cheat:	1. User Cookie.
	//						2. API Keys.
}

function fAPIKey($Data, $Action="Keygen") {
	switch($Action) {
		case "Keygen":		# Generate, and associate the key with user.
							$Depth	=	$Data[''];
							$Key	=	fCrypt(serialize(array(	'UserName'	=>	'',
																'EMail'		=>	'',
																'Auth'		=>	array(	'Item1',
																						'Item2'))), "ENCRYPT");
							return $Key;
	}
}

function afValidateInput($Candidate, $Action="AlphaNum", $MAX=0, $MIN=0) {

	/**
	 **	EMail RegEx pattern 
	 **	Copyright © Michael Rushton 2009-10 http://squiloople.com/
	 **	Taken From http://lxr.php.net/xref/PHP_5_4/ext/filter/logical_filters.c#501
	 **	Modified to span in multiple lines.
	**/

	$PatternEMail = 
	'/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?))'.
	'{255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?))'.
	'{65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|'.
	'(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|'.
	'(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:'.
	'[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22'.
	'(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F])'.
	')*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126})'.
	'{1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:'.
	'(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]'.
	'{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|'.
	'(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:)'.
	'{5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}'.
	'(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|'.
	'(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9])'.
	')){3}))\\]))$/iD';
	
	$PatternAlphaNumLim = "/^[A-Za-z0-9_~-]{".(($MIN > $MAX) ? $MAX : $MIN).",".(($MIN > $MAX) ? $MIN : $MAX)."}$/";	# Compensates for the Type Errors, Possible.
	$PatternAlphaNumWhiteLim = "/^[A-Za-z0-9_~ -]{".(($MIN > $MAX) ? $MAX : $MIN).",".(($MIN > $MAX) ? $MIN : $MAX)."}$/";	# Compensates for the Type Errors, Possible.
	#$PatternTel = "/^[0-9+-]{".(($MIN > $MAX) ? $MAX : $MIN).",".(($MIN > $MAX) ? $MIN : $MAX)."}$/"; TODO
	

	/**
	 ** Taken from http://stackoverflow.com/a/15504877/3680826
	 ** No Author Specified.
	**/
	$PatternDate =	"^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)".
					"(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)".
					"0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:".
					"(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)".
					"(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$";

	afPutLogEntry("afValidateInput", DEBUG);
	switch($Action) {
		case "EMail"				:	return (bool)(preg_match($PatternEMail, $Candidate));
		case "Date"					:	#TODO
		case "Tel"					:	#TODO
		case "AlphaNum"				:	return (bool)(preg_match("/^[A-Za-z0-9_~-]+$/", $Candidate));
		case "AlphaNumWhite"		:	return (bool)(preg_match("/^[A-Za-z0-9_~ -]+$/", $Candidate));
		case "Address"				:	return TRUE;	# TODO
		case "AlphaNumTimes"		:	return (bool)(preg_match($PatternAlphaNumLim, $Candidate));
		case "AlphaNumTimesWhite"	:	return (bool)(preg_match($PatternAlphaNumWhiteLim, $Candidate));
		case "UserName"				:	return (bool)(preg_match("/^[A-Za-z0-9_~-]{5,32}$/", $Candidate));
		case "Numeric"				:	return (bool)(preg_match($MAX > 0 ? "/^[0-9]{$MAX}$/" : "/^[0-9]+$/", $Candidate));
		case "Designation"			:	return (bool)(is_numeric($Candidate) && ($Candidate >= 0 && $Candidate <= 6));
		default						:	afPutLogEntry("Bad usage of function afValidate().", DEBUG); return FALSE;
	}
}

function fURIDataParser() {

	/**
	 **	@internal	Parses Incoming URI Data
	 ** @author 	Prashant Sinha <prashantsinha@outlook.com>
	 **	@package	CIC One API
	 **	@param		None.
	 **	@return		URI Data as Array or Boolean False.
	 **	@throws		None.
	 **	@since		v1.1 20140406
	 **	@version	v1 20140514
	 **	@todo		Status- Complete.
	**/

	$InURI		=	isset($_GET['Dat']) ? $_GET['Dat'] : "";
	$URIData	=	unserialize(fCrypt($InURI, "DECRYPT"));

	# Use non-short-circuit operator, just in case!
	# \(-.-)/
	# Anyone, who's reading this code and thinks it's freaking awesome, increment following counter, else ignore!
	# 4 ++

	if (is_array($URIData) & isset($URIData['Action'])) {
		# Encoded data is un-serializable (Which is a good thing!) and has proper content.
		return $URIData;
	}
	else {
		return FALSE;
	}

}

function fUpload($Type, $PostName, $TargetName="NONE", $__Arg="Check", $TargetPath="assets/database/uploads" ) {
	if ($Type=="Image") {
		if( ($_FILES[$PostName]["type"] == "image/gif"  ||
			 $_FILES[$PostName]["type"] == "image/jpeg" ||
			 $_FILES[$PostName]["type"] == "image/jpg"  ||
			 $_FILES[$PostName]["type"] == "image/png"  ||
			 $_FILES[$PostName]["type"] == "image/bmp") &&
			($_FILES[$PostName]["size"]  < 2000000) ) {
			if( $_FILES[$PostName]["error"] > 0 ) {
				afPutLogEntry("ERR:	".date("{D,d-M-Y, H:i:s}",time()+19800)." Unsuccesful upload due to bad transmission.");
				return 0;
			}
			else{
				if( file_exists("$TargetPath/$TargetName") ) {
					afPutLogEntry("ERR:	".date("{D,d-M-Y, H:i:s}",time()+19800)." Unsuccesful upload due to redundant copy of file.");
					return 0;
				}
				else{
					if( $__Arg=="Check" )
						return 1;
	
					elseif ( $__Arg=="Upload" ) {
						move_uploaded_file($_FILES[$PostName]["tmp_name"], "$TargetPath/$TargetName");
						afPutLogEntry("INFO:	".date("{D,d-M-Y, H:i:s}",time()+19800)." Successful Upload of File at Location: $TargetPath/$TargetName");
						return 1;
					}
	
					else {
						afPutLogEntry("DEBUG:	".date("{D,d-M-Y, H:i:s}",time()+19800)." Bad Argument in function fUpload.");
						return 0;
					}
				}
			}
		}
		else {
			afPutLogEntry("DEBUG:	".date("{D,d-M-Y, H:i:s}",time()+19800)." Bad File Uploaded.");
			return 0;
		}
	}
}

function fMailer( $To, $Data, $__Arg) {
	$Body=""; $Subject="";
	global  $EmailSender, $EmailPrettySender;
	switch($__Arg) {
		case 'UserReg1':
			$Body ='<body><div style="border:solid 1px; padding: 10px; border-radius:5px; background: #000; color:#FFF"><img src="http://localhost/cicone/assets/images/logo.png" style="height:25px;"></div><br><div style="border:solid 1px; padding: 10px; border-radius:5px;"><p>Dear '.$Data['UserName'].',<br>We have recieved your request for creation of an account on CIC One.<br>To proceed, you require to confirm that you are the owner of this EMail ID.<p>Confirmation is easy, just enter this code in the prompt:<span style="border: dashed 1px; padding: 2px; background: #DEF2FF; border-radius:5px;">'.$Data['ConfirmationCode'].'</span></p><p>Alternatively, you can also click on this link:</p><p><a href="'.DOMAIN.'/'.$Data['URI'].'">'.DOMAIN.'/'.$Data['URI'].'</a></p><p>Thanks,<br>Team.<br><a href="http://one.ducic.ac.in">http://one.ducic.ac.in</a></p><p>PS: In case of any problem, you can reply to this email.</p></div></body>';
			$Subject  = "Action required to confirm your CIC One account.";
			break;
		case 'UserReg2':
			$Body ='<body><div style="border:solid 1px; padding: 10px; border-radius:5px; background: #000; color:#FFF"><img src="http://localhost/cicone/assets/images/logo.png" style="height:25px;"></div><br><div style="border:solid 1px; padding: 10px; border-radius:5px;"><p>Dear '.$Data['UserName'].',<br>You have successfully confirmed your EMail ID. You can now proceed to create your User Account</p><p>Thanks,<br>Team.<br><a href="http://one.ducic.ac.in">http://one.ducic.ac.in</a></p><p>PS: In case of any problem, you can reply to this email.</p></div></body>';
			$Subject  = "Your CIC One account has been Confirmed.";
			break;
	}

	$Headers  = 'From: '.$EmailPrettySender .' <'.$EmailSender.'>' . "\r\n";
	$Headers .= "MIME-Version: 1.0\r\n";
	$Headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	mail($To, $Subject, $Body, $Headers);
	return TRUE;
}

?>