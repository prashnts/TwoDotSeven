<?php
namespace TwoDot7\REST\User;
#  _____                      _____   
# /__   \__      _____       |___  |     ___  ______________
#   / /\/\ \ /\ / / _ \         / /     / _ \/ __/ __/_  __/
#  / /    \ V  V / (_) |  _    / /     / , _/ _/_\ \  / /   
#  \/      \_/\_/ \___/  (_)  /_/     /_/|_/___/___/ /_/    

function init() {
	$UserProfile = new \TwoDot7\User\Profile($_GET['UserName']);

	$ERR_SHOW = function ($Message = False) {
		header('HTTP/1.0 450 Invalid Request.', true, 450);
		echo "<pre>";
		echo " ______            ____\n";
		echo "/_  __/    _____  /_  /\n";
		echo " / / | |/|/ / _ \_ / / \n";
		echo "/_/  |__,__/\___(_)_/  \n\n";
		echo "usage <strong>/dev/user/[UserName]/[action]/[subaction]</strong>\n";
		echo "ERROR: ".($Message ? $Message."\n" : "None\n");
		echo "<strong>Response Headers:</strong>\n";
		echo "\t<span style=\"color: #A60\">HTTP/1.0 Status: 450 Invalid Request</span>\n";
		foreach (headers_list() as $key => $value) {
			echo "\t$value\n";
		}
		die();
	};

	if ($UserProfile->Success) switch ($_GET['Function']) {
		case 'updateProfile':
		case 'updateMeta':
			$Success = False;
			if (!$UserProfile->Self() ||
				!isset($_POST['ProfileUpdateValue'])) {
				$ERR_SHOW("ProfileUpdateValue not specified, or Unauthorized User.");
			}
			switch ($_GET['SubAction']) {
				case 'FirstName':
					if (!\TwoDot7\Validate\Alphanumeric($_POST['ProfileUpdateValue'])) $ERR_SHOW("ProfileUpdateValue for FirstName is Invalid.");
					$Success = $UserProfile->FirstName($_POST['ProfileUpdateValue']);
					break;
				case 'LastName':
					if (!\TwoDot7\Validate\Alphanumeric($_POST['ProfileUpdateValue'])) $ERR_SHOW("ProfileUpdateValue for LastName is Invalid.");
					$Success = $UserProfile->LastName($_POST['ProfileUpdateValue']);
					break;
				case 'Gender':
					if (!\TwoDot7\Validate\Alphanumeric($_POST['ProfileUpdateValue'])) $ERR_SHOW("ProfileUpdateValue for Gender is Invalid.");
					$Success = $UserProfile->Gender($_POST['ProfileUpdateValue']);
					break;
				case 'Designation':
					if (!\TwoDot7\Validate\Alphanumeric($_POST['ProfileUpdateValue'])) $ERR_SHOW("ProfileUpdateValue for Designation is Invalid.");
					$Success = $UserProfile->Designation($_POST['ProfileUpdateValue']);
					break;
				case 'Course':
					if (!\TwoDot7\Validate\Alphanumeric($_POST['ProfileUpdateValue'])) $ERR_SHOW("ProfileUpdateValue for Course is Invalid.");
					$Success = $UserProfile->Course($_POST['ProfileUpdateValue']);
					break;
				case 'Year':
					if (!\TwoDot7\Validate\Alphanumeric($_POST['ProfileUpdateValue'])) $ERR_SHOW("ProfileUpdateValue for Year is Invalid.");
					$Success = $UserProfile->Year($_POST['ProfileUpdateValue']);
					break;
				case 'DOB':
					if (!\TwoDot7\Validate\Alphanumeric($_POST['ProfileUpdateValue'])) $ERR_SHOW("ProfileUpdateValue for DOB is Invalid.");
					$Success = $UserProfile->DOB($_POST['ProfileUpdateValue']);
					break;
				case 'Mobile':
					if (!\TwoDot7\Validate\Alphanumeric($_POST['ProfileUpdateValue'])) $ERR_SHOW("ProfileUpdateValue for Mobile is Invalid.");
					$Success = $UserProfile->Mobile($_POST['ProfileUpdateValue']);
					break;
				case 'Address':
					if (!\TwoDot7\Validate\Alphanumeric($_POST['ProfileUpdateValue'])) $ERR_SHOW("ProfileUpdateValue for Address is Invalid.");
					$Success = $UserProfile->Address($_POST['ProfileUpdateValue']);
					break;
				case 'Bio':
					$Success = $UserProfile->Bio(strip_tags($_POST['ProfileUpdateValue']));
					break;
				default:
					$ERR_SHOW();
					break;
			}
			if ($Success) {
				//
			} else {
				//
			}
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