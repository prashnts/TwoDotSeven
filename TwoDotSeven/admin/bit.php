<?php
namespace TwoDot7\Admin\Bit;

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
	# Determine which module it is.
	# Pull its meta data.
	# Check Session.
	# Check Priviledge (Token)
	# Check Bit's target page. Require Bit's stuff.

	$BitID = $_GET['Bit'];
	try {
		$Bit = new \TwoDot7\Bit\Init($BitID);
		$AutoTokenResponse = $Bit->AutoToken();
		$BiTControllerResponse = $Bit->InterFaceController();
		$ViewVar = $Bit->CreateView($BiTControllerResponse);

		\TwoDot7\Admin\Template\Dash_Broadcasts_Bits\_init(array(
			'Page' => $BitID,
			'Call' => 'Bit',
			'Navigation' => \TwoDot7\Meta\Navigation::Get(array('Page' => $BitID)),
			'ViewData' => $BiTControllerResponse,
			'View' => $ViewVar
			));

		die();
	} catch (\TwoDot7\Exception\InvalidBit $e) {

	\TwoDot7\Admin\Template\Login_SignUp_Error\_init(array(
		'Call' => 'Error',
		'ErrorMessageHead' => 'Invalid Bit ID.',
		'ErrorMessageFoot' => 'The ID specified in the URL was not found in current setup. Are you trying to install it? Please contact the support if this error persists.',
		'ErrorCode' => 'UserError: Invalid Bit specified.',
		'Code' => 404,
		'HideBottomErrorNav' => True,
		'Mood' => 'GREEN'));
	
	die();
	}
}