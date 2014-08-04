<?php
namespace TwoDot7\Admin\Register;

#  _____                      _____ 
# /__   \__      _____       |___  |      ___     __      _    
#   / /\/\ \ /\ / / _ \         / /      / _ |___/ /_ _  (_)__ 
#  / /    \ V  V / (_) |  _    / /      / __ / _  /  ' \/ / _ \
#  \/      \_/\_/ \___/  (_)  /_/      /_/ |_\_,_/_/_/_/_/_//_/

/**
 * init throws the Markup, and handels User Interaction.
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
		case 'validateEmail':
		case 'verifyEmail':
		case 'ConfirmEmail':
		case 'confirmEmail':
			if ($_GET['Target'] && $_GET['Data']) {
				# Do the Auto confirm.
				$Data = json_decode(\TwoDot7\Util\Crypt::Decrypt($_GET['Data']), true);

				$UserName = $Data ? \TwoDot7\Validate\UserName($Data['UserName']) : False;
				$StatusTest = \TwoDot7\User\Status::EMail($UserName);

				if ($StatusTest['Success'] && ($StatusTest['Response'] == 1)) {
					# EMail Already confirmed.
					\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
						'Call' => 'OK',
						'Brand' => $Data['UserName'].', Your EMail ID was already verified successfully.',
						'Trailer' => 'You can proceed to login.',
						'Title' => 'Verification Already Complete',
						'Mood' => 'GREEN'));
					die();
				}

				$Response = $Data ? \TwoDot7\User\Account::ConfirmEmail($Data) : array(
					'Success' => False);

				if ($Response['Success']) {
					\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
						'Call' => 'OK',
						'Brand' => $Data['UserName'].', Your EMail ID was verified successfully.',
						'Trailer' => 'You can proceed to login now.',
						'Title' => 'Verification Complete',
						'Mood' => 'GREEN'));
				}
				else {
					\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
						'Call' => 'Error',
						'ErrorMessageHead' => 'This Auto Action URL is Invalid.',
						'ErrorMessageFoot' => 'Which means that either you clicked a mal-formed URL, or this URL is expired. You can get more info in <kbd>Recovery</kbd> section. Please contact us if you think this is an error.',
						'ErrorCode' => 'UserError: ExpiredURL/AutoConfirmation',
						'Code' => 403,
						'Title' => '403 Expired URL',
						'Mood' => 'RED'));
				}
			}
			elseif ($_GET['Target']) {
				# Enter the Code.
				$UserName = \TwoDot7\Validate\UserName($_GET['Target']);
				$StatusTest = \TwoDot7\User\Status::EMail($UserName);

				if ($StatusTest['Success']) {
					if ($StatusTest['Response'] == 1) {
						# EMail Already confirmed.
						\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
							'Call' => 'OK',
							'Brand' => $UserName.', Your EMail ID is already verified.',
							'Trailer' => 'You can proceed to login.',
							'Title' => 'Verification Already Complete',
							'Mood' => 'BLUE'));
						die();
					}
				}

				if (\TwoDot7\Util\Redundant::UserName($UserName)) {
					\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
						'Call' => 'EmailVerifyCode',
						'Title' => 'Please Confirm your Email ID',
						'UserName' => $UserName,
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
				\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
					'Call' => 'EmailVerify',
					'Title' => 'Confirm your Email ID',
					'Brand' => 'Please confirm your Email ID.',
					'Trailer' => 'Please enter your UserName and the Confirmation code you\'ve recieved in your registered Email. Alternatively, you can click on the Link in Email.'));
			}
			die();
			break;
		case 'account':
		case 'user':
		default:
			\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
				'Call' => 'SignUp',
				'Brand' => 'Create an Account',
				'Trailer' => 'Please begin by filling the following info.'));
			die();
			break;
	}
}