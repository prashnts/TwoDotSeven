<?php
namespace TwoDot7\REST\Broadcast;
#  _____                      _____   
# /__   \__      _____       |___  |     ___  ______________
#   / /\/\ \ /\ / / _ \         / /     / _ \/ __/ __/_  __/
#  / /    \ V  V / (_) |  _    / /     / , _/ _/_\ \  / /   
#  \/      \_/\_/ \___/  (_)  /_/     /_/|_/___/___/ /_/    

function init() {
	switch ($_GET['Action']) {
		case 'post':
			if (!(isset($_GET['OriginType']) && $_GET['OriginType']) ||
				!isset($_POST['TargetType'])) {
				header('HTTP/1.0 450 Invalid Request.', true, 450);
				echo "<pre>";
				echo "usage /dev/broadcast/post/[OriginType]/[Origin]\n";
				echo "Incomplete Request. Please include following in your request:\n";
				echo "GET: OriginType (<span style=\"color: #F00\">Required</span>)\n";
				echo "GET: Origin (<span style=\"color: #0A6\">Depends on OriginType</span>)\n";
				echo "POST: TargetType (<span style=\"color: #F00\">Required</span>)\n";
				echo "POST: Target (<span style=\"color: #0A6\">Depends on TargetType</span>)\n";
				echo "</pre>";
				die();
			}

			switch (strtolower($_GET['OriginType'])) {
				case 'user':
				case \TwoDot7\Broadcast\USER:

					// check the target.
					switch (strtolower($_POST['TargetType'])) {
						case 'user':
						case \TwoDot7\Broadcast\USER:
							$_POST['TargetType'] = \TwoDot7\Broadcast\USER;
							$_POST['Target'] = preg_split("/[&]/", isset($_POST['Target']) ? $_POST['Target'] : "");
							break;

						case 'group':
						case \TwoDot7\Broadcast\GROUP:
							$_POST['TargetType'] = \TwoDot7\Broadcast\USER;
							$_POST['Target'] = preg_split("/[&]/", isset($_POST['Target']) ? $_POST['Target'] : "");
							break;
							
						case 'custom':
						case \TwoDot7\Broadcast\CUSTOM:
							$_POST['TargetType'] = \TwoDot7\Broadcast\CUSTOM;
							$_POST['Target'] = False;
							break;

						case 'default':
						case \TwoDot7\Broadcast\_DEFAULT:
						default:
							$_POST['TargetType'] = \TwoDot7\Broadcast\_DEFAULT;
							$_POST['Target'] = False;
					}

					$OriginOverride = isset($_POST['OverrideUserName']) && \TwoDot7\User\Shortcut::IsSysAdmin() && isset($_POST['Origin']);

					$_POST['Visible'] = isset($_POST['Visible']) ? $_POST['Visible'] : 0;

					$AddRequest = array(
						'OriginType' => \TwoDot7\Broadcast\USER,
						'Origin' => $OriginOverride ? $_POST['Origin'] : \TwoDot7\User\Session::Data()['UserName'],
						'TargetType' => $_POST['TargetType'],
						'Target' => $_POST['Target'],
						'Visible' => $_POST['Visible'],
						'Data' => array('BroadcastText' => $_POST['BroadcastText'])
						);

					$Response = \TwoDot7\Broadcast\Action::Add($AddRequest);

					if ($Response['Success']) {
						header('HTTP/1.0 251 Operation completed successfully.', true, 251);
						header('Content-Type: application/json');
						echo json_encode($Response);
					} else {
						header('HTTP/1.0 261 Bad Request. Operation cannot be completed.', true, 261);
						header('Content-Type: application/json');
						echo json_encode('NOPE');
					}
					die();
					break;
				
				default:
					break;
			}
			break;
		default:
			header('HTTP/1.0 450 Invalid Request.', true, 450);
			echo "<pre>";
			echo "usage /dev/broadcast/[add]\n";
			echo "Incomplete Request. Please read the Documentation.\n";
			echo "</pre>";
	}
}