<?php
namespace TwoDot7\REST\Direction;
#  _____                      _____   
# /__   \__      _____       |___  |     ___  ______________
#   / /\/\ \ /\ / / _ \         / /     / _ \/ __/ __/_  __/
#  / /    \ V  V / (_) |  _    / /     / , _/ _/_\ \  / /   
#  \/      \_/\_/ \___/  (_)  /_/     /_/|_/___/___/ /_/    

function init() {
	switch ($_GET['Function']) {
		case 'userToken':
			\TwoDot7\User\REST::AUTH(array(
				'Token' => 'ADMIN',
				));
			if (isset($_POST['Do']) &&
				isset($_POST['UserName']) &&
				isset($_POST['Tag'])) {
				if ($_POST['Do'] === 'ADD') {

					# Prevent User from adding SYSADMIN tag.
					if ($_POST['Tag'] === 'SYSADMIN') {
						header('HTTP/1.0 4 406 Not Acceptable.', true, 406);
						header('Content-Type: application/json');
						echo json_encode(array(
							'Success' => False,
							'Error' => 'You cannot add a SYSADMIN Tag.'));
						die();
					}

					if (\TwoDot7\User\Access::Add(array(
						'UserName' => $_POST['UserName'],
						'Domain' => $_POST['Tag']))) {
						header('HTTP/1.0 251 Operation completed successfully.', true, 251);
						header('Content-Type: application/json');
						echo json_encode(array(
							'Success' => True));
					}
					else {
						header('HTTP/1.0 261 Bad Request. Operation cannot be completed.', true, 261);
						header('Content-Type: application/json');
						echo json_encode(array(
							'Success' => False));
					}
				}
				elseif ($_POST['Do'] === 'REMOVE') {

					# Prevent User from removing their own ADMIN tag.
					if ($_POST['UserName'] === \TwoDot7\User\Session::Data()['UserName'] &&
						$_POST['Tag'] === 'ADMIN' ||
						$_POST['Tag'] === 'SYSADMIN') {
						header('HTTP/1.0 4 406 Not Acceptable.', true, 406);
						header('Content-Type: application/json');
						echo json_encode(array(
							'Success' => False,
							'Error' => 'You cannot remove your own ADMIN Tag.'));
						die();
					}

					if (\TwoDot7\User\Access::Revoke(array(
						'UserName' => $_POST['UserName'],
						'Domain' => $_POST['Tag']))) {
						header('HTTP/1.0 251 Operation completed successfully.', true, 251);
						header('Content-Type: application/json');
						echo json_encode(array(
							'Success' => True));
					}
					else {
						header('HTTP/1.0 261 Bad Request. Operation cannot be completed.', true, 261);
						header('Content-Type: application/json');
						echo json_encode(array(
							'Success' => False));
					}
				}
				else {
					header('HTTP/1.0 261 Bad Request. Operation cannot be completed.', true, 261);
					header('Content-Type: application/json');
					echo json_encode(array(
						'Success' => False,
						'Error' => 'Please Specify Action.'));
				}
			}
			else {
				header('HTTP/1.0 450 Invalid Request.', true, 450);
				echo "<pre>";
				echo "usage /dev/direction/userToken/[POST Do, POST UserName, POST Tag]\n";
				echo "Incomplete Request. Please read the Documentation.\n";
				echo "</pre>";
			}
			die();

		case 'userPasswordOverride':
			\TwoDot7\User\REST::AUTH(array(
				'Token' => 'ADMIN',
				));
			if (isset($_POST['UserName']) &&
				isset($_POST['NewPassword']) &&
				isset($_POST['ConfNewPassword'])) {
				
				# This automatically Deauthorizes all the Session Cookies and Logs out the User.
				$Recovery = new \TwoDot7\User\Recover;
				$Response = $Recovery->Password(array(
					'UserName' => $_POST['UserName'],
					'New_Password' => $_POST['NewPassword'],
					'Conf_Password' => $_POST['ConfNewPassword'],
					'Deauthorize' => True));

				if ($Response['Success']) {
					header('HTTP/1.0 251 Operation completed successfully.', true, 251);
					header('Content-Type: application/json');
					echo json_encode(array(
						'Success' => True));
				}
				else {
					header('HTTP/1.0 4 406 Not Acceptable.', true, 406);
					header('Content-Type: application/json');
					echo json_encode(array(
						'Success' => False,
						'Error' => 'There is some problem with your input.'));
					die();
				}
			}
			else {
				header('HTTP/1.0 450 Invalid Request.', true, 450);
				echo "<pre>";
				echo "usage /dev/direction/userPasswordOverride/[POST UserName, POST NewPassword, POST ConfNewPassword]\n";
				echo "Incomplete Request. Please read the Documentation.\n";
				echo "</pre>";
			}
			die();

		case 'userEMailOverride':
			
			\TwoDot7\User\REST::AUTH(array(
				'Token' => 'ADMIN',
				));

			if (isset($_POST['UserName']) &&
				isset($_POST['NewEMail'])) {
				
				# This automatically Deauthorizes all the Session Cookies and Logs out the User.
				$Recovery = new \TwoDot7\User\Recover;
				$Response = $Recovery->EMail(array(
					'UserName' => $_POST['UserName'],
					'New_EMail' => $_POST['NewEMail']
					));

				if ($Response['Success']) {
					header('HTTP/1.0 251 Operation completed successfully.', true, 251);
					header('Content-Type: application/json');
					echo json_encode(array(
						'Success' => True));
				}
				else {
					header('HTTP/1.0 4 406 Not Acceptable.', true, 406);
					header('Content-Type: application/json');
					echo json_encode(array(
						'Success' => False,
						'Error' => 'There is some problem with your input.'));
					die();
				}
			}
			else {
				header('HTTP/1.0 450 Invalid Request.', true, 450);
				echo "<pre>";
				echo "usage /dev/direction/userEMailOverride/[POST UserName, POST NewEMail]\n";
				echo "Incomplete Request. Please read the Documentation.\n";
				echo "</pre>";
			}
			die();

		case 'userEmailValidate':
			\TwoDot7\User\REST::AUTH(array(
				'Token' => 'ADMIN',
				));

			if (isset($_POST['UserName']) &&
				isset($_POST['Do'])) {
				
				$StatusNumber = ($_POST['Do'] == 'UNVERIFY') ? 0 : 1;

				$Response = \TwoDot7\User\Status::EMail($_POST['UserName'], array(
					'Action' => 'SET',
					'Status' => $StatusNumber
					));

				if ($Response['Success']) {
					header('HTTP/1.0 251 Operation completed successfully.', true, 251);
					header('Content-Type: application/json');
					echo json_encode(array(
						'Success' => True));
				}
				else {
					header('HTTP/1.0 406 Not Acceptable.', true, 406);
					header('Content-Type: application/json');
					echo json_encode(array(
						'Success' => False,
						'Error' => 'There is some problem with your input.'));
					die();
				}
			}
			else {
				header('HTTP/1.0 450 Invalid Request.', true, 450);
				echo "<pre>";
				echo "usage /dev/direction/userEmailValidate/[POST UserName]\n";
				echo "Incomplete Request. Please read the Documentation.\n";
				echo "</pre>";
			}
			die();

		case 'userProfileValidate':
			
			\TwoDot7\User\REST::AUTH(array(
				'Token' => 'ADMIN',
				));

			if (isset($_POST['UserName']) &&
				isset($_POST['Do'])) {
				
				$StatusNumber = ($_POST['Do'] == 'UNVERIFY') ? 0 : 1;

				$Response = \TwoDot7\User\Status::Profile($_POST['UserName'], array(
					'Action' => 'SET',
					'Status' => $StatusNumber
					));

				if ($Response['Success']) {
					header('HTTP/1.0 251 Operation completed successfully.', true, 251);
					header('Content-Type: application/json');
					echo json_encode(array(
						'Success' => True));
				}
				else {
					header('HTTP/1.0 4 406 Not Acceptable.', true, 406);
					header('Content-Type: application/json');
					echo json_encode(array(
						'Success' => False,
						'Error' => 'There is some problem with your input.'));
					die();
				}
			}
			else {
				header('HTTP/1.0 450 Invalid Request.', true, 450);
				echo "<pre>";
				echo "usage /dev/direction/userProfileValidate/[POST UserName]\n";
				echo "Incomplete Request. Please read the Documentation.\n";
				echo "</pre>";
			}
			die();

		case '_markup_getUserList':

			\TwoDot7\User\REST::AUTH(array(
				'Token' => 'ADMIN',
				));

			$Response = \TwoDot7\Direction\User::GetAll($_GET['Page']);
			$Markup = array();
			
			$Markup['Table'] = '';
			foreach ($Response['Table'] as $Meta) {
				$MetaAdjustments = array();

				if ($Meta['EMailStatus'] == 0) {
					$MetaAdjustments['EMail'] = array(
						'icon' => 'fa fa-times-circle',
						'color' => 'text-danger',
						'msg' => 'Unverified');
				}
				elseif ($Meta['EMailStatus'] == 1) {
					$MetaAdjustments['EMail'] = array(
						'icon' => 'fa fa-check-circle',
						'color' => 'text-success',
						'msg' => 'Verified');
				}
				elseif ($Meta['EMailStatus'] == 2) {
					$MetaAdjustments['EMail'] = array(
						'icon' => 'fa fa-exclamation-circle',
						'color' => 'text-warning',
						'msg' => 'EMail Updated');
				}
				else {
					$MetaAdjustments['EMail'] = array(
						'icon' => 'fa fa-exclamation-circle',
						'color' => 'text-danger',
						'msg' => 'Unknown');
				}

				$EMailChecked = ($Meta['EMailStatus'] == 1) ? 'checked' : '';
				$ProfileChecked = ($Meta['ProfileStatus'] == 1) ? 'checked' : '';

				if ($Meta['ProfileStatus'] == 0) {
					$MetaAdjustments['ProfileStatus'] = array(
						'icon' => 'fa fa-times-circle',
						'color' => 'text-danger',
						'msg' => 'Unverified');
				}
				elseif ($Meta['ProfileStatus'] == 1) {
					$MetaAdjustments['ProfileStatus'] = array(
						'icon' => 'fa fa-check-circle',
						'color' => 'text-success',
						'msg' => 'Verified');
				}
				elseif ($Meta['ProfileStatus'] == 2) {
					$MetaAdjustments['ProfileStatus'] = array(
						'icon' => 'fa fa-exclamation-circle',
						'color' => 'text-warning',
						'msg' => 'Profile Updated');
				}
				else {
					$MetaAdjustments['ProfileStatus'] = array(
						'icon' => 'fa fa-exclamation-circle',
						'color' => 'text-danger',
						'msg' => 'Unknown');
				}

				$Markup['Table'] .= "<tr id=\"TableToggle{$Meta['ID']}\">";
				$Markup['Table'] .= "    <td>{$Meta['ID']}</td>";
				$Markup['Table'] .= "    <td>";
				$Markup['Table'] .= "		<span class=\"thumb-sm avatar pull-left m-r-sm\">";
				$Markup['Table'] .= "			<img src=\"/assetserver/userNameIcon/{$Meta['UserName'][0]}\">";
				$Markup['Table'] .= "		</span>";
				$Markup['Table'] .= "		<strong>{$Meta['UserName']}</strong>{$Meta['UserNameExtra']}";
				$Markup['Table'] .= "		<p>{$Meta['EMail']}</p>";
				$Markup['Table'] .= "		<div class=\"line line-dashed b-b pull-in\"></div>";
				$Markup['Table'] .= '		<div class="row padder">';
				$Markup['Table'] .= "			<a class=\"accordion-toggle\" data-toggle=\"collapse\" href=\"#UserOverrideID{$Meta['ID']}UserName{$Meta['UserName']}\">";
				$Markup['Table'] .= '				<span class="text-primary">Quick Edit <i class="fa fa-angle-down"></i></span>';
				$Markup['Table'] .= '			</a> |';
				$Markup['Table'] .= '			<a href="#">';
				$Markup['Table'] .= '				<span class="text-success">View Profile</span>';
				$Markup['Table'] .= '			</a> |';
				$Markup['Table'] .= '			<a href="#">';
				$Markup['Table'] .= '				<span class="text-warning">Send Message</span>';
				$Markup['Table'] .= '			</a> |';
				$Markup['Table'] .= '			<a href="#">';
				$Markup['Table'] .= '				<span class="text-danger">Delete</span>';
				$Markup['Table'] .= '			</a>';
				$Markup['Table'] .= '		</div>';
				$Markup['Table'] .= "		<div id=\"UserOverrideID{$Meta['ID']}UserName{$Meta['UserName']}\" class=\"collapse padder m-t-sm\">";
				$Markup['Table'] .= '			<div class="row b-t b-light">';
				$Markup['Table'] .= '				<div class="col-sm-3 text-right  m-t-sm ">';
				$Markup['Table'] .= '					<h5>Override Password</h5>';
				$Markup['Table'] .= '				</div>';
				$Markup['Table'] .= '				<div class="form-inline col-sm-9  m-t-sm ">';
				$Markup['Table'] .= '					<div class="form-group">';
				$Markup['Table'] .= "						<input type=\"password\" class=\"form-control input-sm\" id=\"UserPswdOI{$Meta['ID']}U{$Meta['UserName']}NewPswd\" placeholder=\"Enter New Password\">";
				$Markup['Table'] .= '					</div>';
				$Markup['Table'] .= '					<div class="form-group">';
				$Markup['Table'] .= "						<input type=\"password\" class=\"form-control input-sm\" id=\"UserPswdOI{$Meta['ID']}U{$Meta['UserName']}ConfPswd\" placeholder=\"Confirm Password\">";
				$Markup['Table'] .= '					</div>';
				$Markup['Table'] .= "					<a class=\"btn btn-sm btn-primary\" href=\"#\" id=\"UserPswdOI{$Meta['ID']}U{$Meta['UserName']}\" onclick=\"ExecutePswdOA(this.id)\" data-username=\"{$Meta['UserName']}\">Execute Action</button></a>";
				$Markup['Table'] .= '				</div>';
				$Markup['Table'] .= '			</div>';
				$Markup['Table'] .= '			<div class="row b-b b-light">';
				$Markup['Table'] .= '				<div class="col-sm-3 text-right  m-t-sm ">';
				$Markup['Table'] .= '					<h5>Override Email</h5>';
				$Markup['Table'] .= '				</div>';
				$Markup['Table'] .= '				<div class="form-inline col-sm-9  m-t-sm  m-b-xs">';
				$Markup['Table'] .= '					<div class="form-group">';
				$Markup['Table'] .= "						<input type=\"email\" class=\"form-control input-sm\" id=\"UserEMailOI{$Meta['ID']}U{$Meta['UserName']}NewEMail\" placeholder=\"Enter New Email\">";
				$Markup['Table'] .= '					</div>';
				$Markup['Table'] .= "					<a class=\"btn btn-sm btn-primary\" href=\"#\" id=\"UserEMailOI{$Meta['ID']}U{$Meta['UserName']}\" onclick=\"ExecuteEMailOA(this.id)\" data-username=\"{$Meta['UserName']}\">Execute Action</button></a>";
				$Markup['Table'] .= '				</div>';
				$Markup['Table'] .= '			</div>';
				$Markup['Table'] .= '			<div class="row b-b b-light">';
				$Markup['Table'] .= '				<div class="col-sm-3 text-right  m-t-sm ">';
				$Markup['Table'] .= '					<h6>Add or Remove User Access Tokens</h6>';
				$Markup['Table'] .= '				</div>';
				$Markup['Table'] .= '				<div class="col-sm-9  m-t-sm  m-b-xs">';
				$Markup['Table'] .= '					<input type="text" name="tags" placeholder="Enter a Token to Add" class="input-sm form-control tm-input" id="'."UserTokenOverrideTagID{$Meta['ID']}UserName{$Meta['UserName']}".'"/>';
				$Markup['Table'] .= '				</div>';
				$Markup['Table'] .= '			</div>';
				$Markup['Table'] .= '			<div class="row b-b b-light">';
				$Markup['Table'] .= '				<div class="col-sm-3 text-right m-t-sm">';
				$Markup['Table'] .= '					<h6>Verify Email</h6>';
				$Markup['Table'] .= '				</div>';
				$Markup['Table'] .= '				<div class="form-inline col-sm-3 m-t-sm m-b-xs">';
				$Markup['Table'] .= '					<label class="switch">';
				$Markup['Table'] .= '						<input type="checkbox" '.$EMailChecked.'>';
				$Markup['Table'] .= '						<span id="'."UserEMailVerifyID{$Meta['ID']}UserName{$Meta['UserName']}".'" onclick="VerifyEMail(this.id)" data-username="'.$Meta['UserName'].'"></span> ';
				$Markup['Table'] .= '					</label>';
				$Markup['Table'] .= '				</div>';
				$Markup['Table'] .= '				<div class="col-sm-3 text-right m-t-sm">';
				$Markup['Table'] .= '					<h6>Verify Profile</h6>';
				$Markup['Table'] .= '				</div>';
				$Markup['Table'] .= '				<div class="form-inline col-sm-3 m-t-sm m-b-xs">';
				$Markup['Table'] .= '					<label class="switch">';
				$Markup['Table'] .= '						<input type="checkbox" '.$ProfileChecked.' >';
				$Markup['Table'] .= '						<span id="'."UserProfileVerifyID{$Meta['ID']}UserName{$Meta['UserName']}".'" onclick="VerifyProfile(this.id)" data-username="'.$Meta['UserName'].'"></span> ';
				$Markup['Table'] .= '					</label>';
				$Markup['Table'] .= '				</div>';
				$Markup['Table'] .= '			</div>';
				$Markup['Table'] .= '		</div>';
				$Markup['Table'] .= '	</td>';
				$Markup['Table'] .= '	<td>';
				$Markup['Table'] .= "		<strong class=\"text-default\"><i class=\"fa fa-envelope-square\"></i> Email</strong>: <span class=\"{$MetaAdjustments['EMail']['color']}\"><i class=\"{$MetaAdjustments['EMail']['icon']}\"></i> {$MetaAdjustments['EMail']['msg']} </span><br>";
				$Markup['Table'] .= "		<strong class=\"text-default\"><i class=\"fa fa-user\"></i> Profile</strong>: <span class=\"{$MetaAdjustments['ProfileStatus']['color']}\"><i class=\"{$MetaAdjustments['ProfileStatus']['icon']}\"></i> {$MetaAdjustments['ProfileStatus']['msg']} </span><br>";
				$Markup['Table'] .= "		<strong class=\"text-default\"><i class=\"fa fa-power-off\"></i> Active Sessions</strong>: <span class=\"text-success\">{$Meta['SessionCount']}</span><br>";
				$Markup['Table'] .= '	</td>';
				$Markup['Table'] .= '</tr>';
				$Markup['Table'] .= '<script type="text/javascript">';
				$Markup['Table'] .= '	var '."UserTokenOverrideVar{$Meta['ID']}UserName{$Meta['UserName']}".' = $("#'."UserTokenOverrideTagID{$Meta['ID']}UserName{$Meta['UserName']}".'").tagsManager({';
				$Markup['Table'] .= '		prefilled: '.json_encode($Meta['AccessTokens']).',';
				$Markup['Table'] .= "		tagClass: 'tm-tag-success',";
				$Markup['Table'] .= "		deleteTagsOnBackspace: false,";
				$Markup['Table'] .= "		fillInputOnTagRemove: true,";
				$Markup['Table'] .= "		enableAjaxPush: true,";
				$Markup['Table'] .= "		enableAjaxPull: true,";
				$Markup['Table'] .= "		pushAjax: '/dev/direction/userToken',";
				$Markup['Table'] .= "		pushAjaxParameter: {";
				$Markup['Table'] .= "			Do: 'ADD',";
				$Markup['Table'] .= "			UserName: '{$Meta['UserName']}'";
				$Markup['Table'] .= "		},";
				$Markup['Table'] .= "		pullAjax: '/dev/direction/userToken',";
				$Markup['Table'] .= "		pullAjaxParameter: {";
				$Markup['Table'] .= "			Do: 'REMOVE',";
				$Markup['Table'] .= "			UserName: '{$Meta['UserName']}'";
				$Markup['Table'] .= "		}";
				$Markup['Table'] .= "	});";
				$Markup['Table'] .= '</script>';
			}
			
			$Markup['Pagination'] = '<ul class="pagination pagination-sm m-t-none m-b-none">';
			$Markup['Pagination'] .= '<li><a href="#" data-next="'.$Response['Previous'].'" name="Pagination"><i class="fa fa-chevron-left"></i></a></li>';
			for ($Page = 1; $Page <= $Response['PageMax']; $Page++) {
				if ($Page == $Response['Page']) {
					$Markup['Pagination'] .= "<li class=\"active\"><a data-next=\"{$Page}\" href=\"#\" name=\"Pagination\">{$Page}</a></li>";
				}
				else {
					$Markup['Pagination'] .= "<li><a data-next=\"{$Page}\" href=\"#\" name=\"Pagination\">{$Page}</a></li>";
				}
			}
			$Markup['Pagination'] .= '<li><a href="#" data-next="'.$Response['Next'].'" name="Pagination"><i class="fa fa-chevron-right"></i></a></li>';
			$Markup['Pagination'] .= '</ul>';
			
			$Markup['PageLocation'] = 'Page '.$Response['Page'].' of '.$Response['PageMax'];

			header('HTTP/1.0 200 OK', True, 200);
			header('Content-Type: application/json');
			print json_encode($Markup, JSON_PRETTY_PRINT);
			die();
		
		default:
			header('HTTP/1.0 450 Invalid Request.', true, 450);
			echo "<pre>";
			echo "usage /dev/direction/[getUserList]\n";
			echo "Incomplete Request. Please read the Documentation.\n";
			echo "</pre>";
	}
}