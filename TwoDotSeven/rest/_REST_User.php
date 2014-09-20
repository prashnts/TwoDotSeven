<?php
namespace TwoDot7\REST\User;
#  _____                      _____   
# /__   \__      _____       |___  |     ___  ______________
#   / /\/\ \ /\ / / _ \         / /     / _ \/ __/ __/_  __/
#  / /    \ V  V / (_) |  _    / /     / , _/ _/_\ \  / /   
#  \/      \_/\_/ \___/  (_)  /_/     /_/|_/___/___/ /_/    

function init() {

	$UserProfile = new \TwoDot7\User\Profile($_GET['UserName']);
	if ($UserProfile->Success) switch ($_GET['Function']) {
		case 'updateProfile':
		case 'updateMeta':
			if (!isset($_POST['ProfileUpdateValue'])) {
				echo "Error";
			}
			switch ($_GET['SubAction']) {
				case 'FirstName':
					$Success = $UserProfile->FirstName($_POST['ProfileUpdateValue']);
					break;
				case 'LastName':
					$Success = $UserProfile->LastName($_POST['ProfileUpdateValue']);
					break;
				case 'Gender':
					$Success = $UserProfile->Gender($_POST['ProfileUpdateValue']);
					break;
				case 'Designation':
					$Success = $UserProfile->Designation($_POST['ProfileUpdateValue']);
					break;
				case 'Course':
					$Success = $UserProfile->Course($_POST['ProfileUpdateValue']);
					break;
				case 'Year':
					$Success = $UserProfile->Year($_POST['ProfileUpdateValue']);
					break;
				case 'DOB':
					$Success = $UserProfile->DOB($_POST['ProfileUpdateValue']);
					break;
				case 'Mobile':
					$Success = $UserProfile->Mobile($_POST['ProfileUpdateValue']);
					break;
				case 'Address':
					$Success = $UserProfile->Address($_POST['ProfileUpdateValue']);
					break;
				case 'Bio':
					$Success = $UserProfile->Bio($_POST['ProfileUpdateValue']);
					break;
			}
			var_dump($UserProfile->)
			break;
		case 'profile':
		default:
			echo json_encode($UserProfile->Get());
			die();
	} else {
		echo "No Such User Exists";
		die();
	}

	switch ($_GET['Function']) {
		case 'profile':
			$Error = array(
				'Params' => array(
					array("Action", "GET", \TwoDot7\Util\REST::PARAMREQUIRED),
					array("UserName", "POST", \TwoDot7\Util\REST::PARAMOPTIONAL),
					array("Password", "POST", \TwoDot7\Util\REST::PARAMDEPENDS),
					array("UserLegacyAuthHash", "POST", \TwoDot7\Util\REST::PARAMDEPENDS)
				),
				'Usage' => "/dev/broadcast/post/[checkSession, login, logout]",
				'SessionError' => !\TwoDot7\User\Session::Exists()
			);
			if ($_GET['ActionHook']) switch ($_GET['ActionHook']) {
				//
			}

			break;

		default:
			header('HTTP/1.0 450 Invalid Request.', true, 450);
			echo "<pre>";
			echo "usage /dev/account/[add, remove, verify, confirmEmail]\n";
			echo "Incomplete Request. Please read the Documentation.\n";
			echo "</pre>";
	}
}