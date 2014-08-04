<?php
namespace TwoDot7\Admin\Administration;

#  _____                      _____ 
# /__   \__      _____       |___  |      ___     __      _    
#   / /\/\ \ /\ / / _ \         / /      / _ |___/ /_ _  (_)__ 
#  / /    \ V  V / (_) |  _    / /      / __ / _  /  ' \/ / _ \
#  \/      \_/\_/ \___/  (_)  /_/      /_/ |_\_,_/_/_/_/_/_//_/

/**
 * init throws the Markup.
 * @return	null
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 18072014
 * @version	0.0
 */
function init() {

	# Agenda:
	# Check Session.
	# Check ADMIN Token:
	## No? 403
	## Yea? Check Target

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
	if (!\TwoDot7\User\Access::Check(array(
		'UserName' => \TwoDot7\User\Session::Data()['UserName'],
		'Domain' => 'ADMIN'))) {

		\TwoDot7\Util\Log('User '.\TwoDot7\User\Session::Data()['UserName']. ' attempted acess to Administration Section.', 'ALERT');

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
	
	switch ($_GET['Action']) {
		case 'user':
			\TwoDot7\Admin\Template\Dash_Broadcasts_Bits\_init(array(
				'Page' => 'Bit',
				'Call' => 'UserManagement',
				'Navigation' => \TwoDot7\Meta\Navigation::Get(array(
					'Page' => 'PRE_ADMIN'
					))
				));
			break;
		
		default:
			echo '404';
			break;
	}

}