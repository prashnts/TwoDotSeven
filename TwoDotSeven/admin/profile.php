<?php
namespace TwoDot7\Admin\Profile;

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
	$_GET['UserName'] = $_GET['UserName'] ? $_GET['UserName'] : \TwoDot7\User\Session::Data()['UserName'];
	$UserProfile = new \TwoDot7\User\Profile($_GET['UserName']);
	if ($UserProfile->Success) switch ($_GET['Action']) {
		case 'edit':
			if (!$UserProfile->Self()) {
				\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
					'Call' => 'Error',
					'ErrorMessageHead' => 'Wait.',
					'ErrorMessageFoot' => 'You cannot Edit other people\'s Profile! <kbd>This action has been logged</kbd>.',
					'ErrorCode' => 'UserError: Invalid UserName.',
					'Code' => 403,
					'Mood' => 'RED'
				));
				die();
			}
			\TwoDot7\Admin\Template\Dash_Broadcasts_Bits\_init(array(
				'Page' => 'PRE_PROFILE',
				'Call' => 'Profile',
				'EditMode' => True,
				'Meta' => $UserProfile->Get(),
				'Navigation' => \TwoDot7\Meta\Navigation::Get(array(
					'Page' => 'PRE_PROFILE'
					))
				));
			die();
			break;
		case 'view':
		default:
			\TwoDot7\Admin\Template\Dash_Broadcasts_Bits\_init(array(
				'Page' => 'PRE_PROFILE',
				'Call' => 'Profile',
				'Meta' => $UserProfile->Get(),
				'Navigation' => \TwoDot7\Meta\Navigation::Get(array(
					'Page' => 'PRE_PROFILE'
					))
				));
	} else {
		\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
			'Call' => 'Error',
			'ErrorMessageHead' => 'No one is here.',
			'ErrorMessageFoot' => 'No user called '.(strlen($_GET['UserName'])>1? $_GET['UserName'] : "<kbd>UNSPECIFIED</kbd>"). ' exists.',
			'ErrorCode' => 'UserError: Invalid UserName.',
			'Code' => 404,
			'Mood' => 'RED'));
	}
}