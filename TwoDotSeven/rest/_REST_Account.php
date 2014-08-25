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

			$StatusTest = \TwoDot7\User\Status::EMail($Data['UserName']);

			if ($StatusTest['Success'] && ($StatusTest['Response'] == 1)) {
				# EMail Already confirmed.
				header('HTTP/1.0 250 Repeated Operation Not Executed.', true, 250);
				header('Content-Type: application/json');
				echo json_encode(array(
					'Success' => True));
				die();
			}

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
		
		case 'oauth':
		case 'signin':
			if (!isset($_GET['Host']) || !\TwoDot7\Validate\EMail($_GET['Host'], False)) {
				header('HTTP/1.0 450 Invalid Request.', true, 450);
				echo "<pre>";
				echo "usage /dev/account/oauth\n";
				echo "Incomplete Request. Please include following in your request:\n";
				echo "GET: Host (<span style=\"color: #F00\">Required</span>) Your (the Developer's) Email ID.\n";
				echo "GET: HostDisplayName (<span style=\"color: #00F\">Optional</span>) Override Default Name.\n";
				echo "GET: ReturnEmail (<span style=\"color: #00F\">Optional</span>) Specify to also get User's Email ID.\n";
				echo "</pre>";
				die();
			}
			if (\TwoDot7\User\Session::Exists()) {
				if (\TwoDot7\User\Preferences::ExternalApp($_GET['Host'])) {
					$_ProceedArray = array(
						'AppName' => isset($_GET['HostDisplayName']) ? strip_tags($_GET['HostDisplayName']) : $_GET['Host'],
						'Token' => \TwoDot7\Util\BriefURI::Create(600),
						isset($_GET['HTMLProceed']) ? 'HTMLProceed' : 'Umm' => True
					);
					$Location = "/dev/account/oauthProceed?".http_build_query($_ProceedArray);
					header("Location: {$Location}");
					die();
				} else {
					$AppName = isset($_GET['HostDisplayName']) ? strip_tags($_GET['HostDisplayName']) : $_GET['Host'];
					$AppPermissions = "Log you in into their system using your TwoDot7 account";
					$AppPermissions .= isset($_GET['ReturnEmail']) ? ", and see your EMail ID." : ".";

					$_ProceedArray = array(
						'Host' => $_GET['Host'],
						'Token' => \TwoDot7\Util\BriefURI::Create(600),
						isset($_GET['HTMLProceed']) ? 'HTMLProceed' : 'Umm' => True
					);

					$BtnURI = "/dev/account/oauthAddHost?".http_build_query($_ProceedArray);

					_Import($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/views/login.signup.errors.php');

					\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
						'Call' => 'Permission',
						'Title' => 'Consent Required',
						'AppInfo' => $AppName,
						'AppPermissions' => $AppPermissions,
						'ProceedButtonURI' => $BtnURI,
						'Mood' => 'BLUE'));
					die();
				}

			} else {
				$_GET['NextURI'] = "/dev/account/oauth";
				$Location = "/twodot7/login?".http_build_query($_GET);
				header("Location: {$Location}");
				die();
			}

		case 'oauthAddHost':
			if (!isset($_GET['Host']) ||
				!\TwoDot7\Validate\EMail($_GET['Host'], False) ||
				!isset($_GET['Token']) ||
				!\TwoDot7\Util\BriefURI::Verify($_GET['Token']) ||
				!\TwoDot7\User\Session::Exists()) {
				header('HTTP/1.0 450 Invalid Request.', true, 450);
				echo "<pre>";
				echo "usage /dev/account/oauthAddHost\n";
				echo "Incomplete Request. Please include following in your request:\n";
				echo "GET: Token (<span style=\"color: #F00\">Required</span>) The auto-generated URI Token.\n";
				echo "GET: Host (<span style=\"color: #F00\">Required</span>) Your (the Developer's) Email ID.\n";
				echo json_encode($_GET);
				echo "</pre>";
				die();
			} else {
				if (\TwoDot7\User\Preferences::ExternalApp($_GET['Host'], "ADD")) {
					if (isset($_GET['HTMLProceed'])) {
						$_ProceedArray = array(
							'Token' => \TwoDot7\Util\BriefURI::Create(600),
							'HTMLProceed' => True
							);
						$Location = "/dev/account/oauthProceed?".http_build_query($_ProceedArray);
						header("Location: {$Location}");
						die();
					} else {
						header('HTTP/1.0 251 Operation completed successfully.', true, 251);
						header('Content-Type: application/json');
						echo json_encode(array('Success' => True));
						die();
					}
				}
				else {
					header('HTTP/1.0 261 Bad Request. Operation cannot be completed.', true, 261);
					header('Content-Type: application/json');
					echo json_encode(array('Success' => False));
					die();
				}
			}
			break;
		case 'oauthProceed':
			if (isset($_GET['Token']) &&
				\TwoDot7\Util\BriefURI::Verify($_GET['Token'])) {
				$Response = array(
					'Success' => \TwoDot7\User\Session::Exists(),
					'UserName' => \TwoDot7\User\Session::Data()['UserName'],
					'AccessToken' => \TwoDot7\Util\Crypt::Encrypt(\TwoDot7\User\Session::Data()['Hash'])
					);
				if (isset($_GET['HTMLProceed'])) {
					?>
					<!DOCTYPE html>
					<html>
					<head>
						<title>Redirecting | TwoDot7</title>
					</head>
					<body>
							Success. Going back to the app.
							<script type="text/javascript">
								try {
									window.opener.postMessage(JSON.parse(<?php echo "'".json_encode($Response)."'";?>), "*");
									window.setTimeout(function(){
										window.close();
									}, 1000);
								} catch (e) {
									document.write(e.getMessage()+"sja");
								}
							</script>
					</body>
					</html>
					<?php
					die();
				} else {
					header('HTTP/1.0 251 Operation completed successfully.', true, 251);
					header('Content-Type: application/json');
					echo json_encode($Response, JSON_PRETTY_PRINT);
					die();
				}
			} else {
				header('HTTP/1.0 450 Invalid Request.', true, 450);
				echo "<pre>";
				echo "usage /dev/account/oauthProceed\n";
				echo "Incomplete Request. Please include following in your request:\n";
				echo "GET: Token (<span style=\"color: #F00\">Required</span>) The auto-generated URI Token.\n";
				echo "User Login is required.\n";
				echo "</pre>";
				die();
			}

		default:
			header('HTTP/1.0 450 Invalid Request.', true, 450);
			echo "<pre>";
			echo "usage /dev/account/[add, remove, verify, confirmEmail]\n";
			echo "Incomplete Request. Please read the Documentation.\n";
			echo "</pre>";
	}
}