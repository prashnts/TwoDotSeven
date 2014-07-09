<?php
namespace TwoDot7\Admin\Register;

#  _____                      _____ 
# /__   \__      _____       |___  |      ___     __      _    
#   / /\/\ \ /\ / / _ \         / /      / _ |___/ /_ _  (_)__ 
#  / /    \ V  V / (_) |  _    / /      / __ / _  /  ' \/ / _ \
#  \/      \_/\_/ \___/  (_)  /_/      /_/ |_\_,_/_/_/_/_/_//_/

/**
 * init throws the actual Markup.
 * @param	$Data -array- Override Dataset.
 * @param	$Data['Call'] -string- REQUIRED. Specifies function call.
 * @return	null
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 28062014
 * @version	0.0
 */
function init() {
	if (\TwoDot7\User\Session::Exists()) {
		\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
			'Call' => 'Error',
			'ErrorMessageHead' => 'Wait. You\'re logged In.',
			'ErrorMessageFoot' => 'This area is out-of-bound until you logout.',
			'ErrorCode' => 'UserError: Register while login Attempt',
			'Code' => 403,
			'Title' => '403 Unauthorized',
			'Mood' => 'RED'));
		die();
	}

	switch ($_GET['Action']) {
		case 'ConfirmEmail':
			if ($_GET['Target'] && $_GET['Data']) {
				# Do the Auto confirm.
				\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
					'Call' => 'OK',
					'Brand' => 'EMail ID successfully verified.',
					'Trailer' => 'You can proceed to login now.',
					'Title' => 'Logged Out',
					'Mood' => 'GREEN'));
				}
			elseif ($_GET['Target']) {
				# Enter the Code.
				$UserName = \TwoDot7\Validate\UserName($_GET['Target']);
				if (\TwoDot7\Util\Redundant::UserName($UserName)) {
					\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
						'Call' => 'EmailVerifyCode',
						'Title' => 'Confirm your Email ID',
						'Brand' => '<span style="text-transform:capitalize">'.$UserName.'</span>, Please confirm your Email ID.',
						'Trailer' => 'Please enter the confirmation code you\'ve recieved in your registered Email. Alternatively, you can click on the Link in Email.'));
				}
				else {
					\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
						'Call' => 'Error',
						'ErrorMessageHead' => 'No User called <small><kbd>'.htmlspecialchars($_GET['Target']).'</kbd></small> exists.',
						'ErrorMessageFoot' => 'Which means this UserName is available for registration! Please contact us if you think this is an error.',
						'ErrorCode' => 'UserError: Bad UserName/confirmation Page',
						'Code' => 404,
						'Title' => '404 UserName not found.',
						'Mood' => 'RED'));
				}
			}
			else {
				echo "LOL";
			}
			break;
		case 'Proceed':
			echo "Completed LOL?";
			break;
		default:
			\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
				'Call' => 'SignUp',
				'Brand' => 'Create an Account',
				'Trailer' => 'Please begin by filling the following info.'));
			die();
			break;
	}
}