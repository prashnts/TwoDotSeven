<?php
namespace TwoDot7\REST\Account;
#  _____                      _____   
# /__   \__      _____       |___  |     ___  ______________
#   / /\/\ \ /\ / / _ \         / /     / _ \/ __/ __/_  __/
#  / /    \ V  V / (_) |  _    / /     / , _/ _/_\ \  / /   
#  \/      \_/\_/ \___/  (_)  /_/     /_/|_/___/___/ /_/    

function init() {
	switch ($_GET['Function']) {
		case 'add':
			$Data = array(
				'UserName' => isset($_POST['UserName']) ? $_POST['UserName'] : False,
				'EMail' => isset($_POST['EMail']) ? $_POST['EMail'] : False,
				'Password' => isset($_POST['Password']) ? $_POST['Password'] : False,
				'ConfPass' => isset($_POST['ConfPass']) ? $_POST['ConfPass'] : False);
			$Response = \TwoDot7\User\Account::Add($Data);

			if($Response['Success']) {
				header('HTTP/1.0 251 Operation completed successfully.', true, 251);
				header('Content-Type: application/json');
				echo json_encode($Response);
			}
			else {
				header('HTTP/1.0 261 Bad Request. Operation cannot be completed.', true, 261);
				header('Content-Type: application/json');
				echo json_encode($Response);
			}
			break;
		case 'confirmEmail':
			$Data = array(
				'UserName' => isset($_POST['UserName']) ? $_POST['UserName'] : False,
				'ConfirmationCode' => isset($_POST['ConfirmationCode']) ? $_POST['ConfirmationCode'] : False);

			$Response = \TwoDot7\User\Account::ConfirmEmail($Data);

			if($Response['Success']) {
				header('HTTP/1.0 251 Operation completed successfully.', true, 251);
				header('Content-Type: application/json');
				echo json_encode($Response);
			}
			else {
				header('HTTP/1.0 261 Bad Request. Operation cannot be completed.', true, 261);
				header('Content-Type: application/json');
				echo json_encode($Response);
			}
			break;
		case 'generateConfirmationCode':
			$Data = array(
				'UserName' => isset($_POST['UserName']) ? $_POST['UserName'] : False);

			$RecoveryHandle = new \TwoDot7\User\Recover;

			$Response = $RecoveryHandle->EMailConfirmationCode($Data);

			if($Response['Success']) {
				header('HTTP/1.0 251 Operation completed successfully.', true, 251);
				header('Content-Type: application/json');
				echo json_encode($Response);
			}
			else {
				header('HTTP/1.0 261 Bad Request. Operation cannot be completed.', true, 261);
				header('Content-Type: application/json');
				echo json_encode($Response);
			}
			break;
		default:
			header('HTTP/1.0 450 Invalid Request.', true, 450);
			header('Generator: TwoDot7 REST Engine.');
			echo "<pre>";
			echo "usage /dev/account/[add, remove, verify, confirmEmail]\n";
			echo "Incomplete Request. Please read the Documentation.\n";
			echo "</pre>";
	}
}