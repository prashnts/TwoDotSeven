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
	$Bit = new \TwoDot7\Bit\Init($BitID);

	var_dump($Bit);
	/*\TwoDot7\Admin\Template\Dash_Broadcasts_Bits\_init(array(
		'Page' => 'Bit',
		'Navigation' => \TwoDot7\Meta\Navigation::Get(array(
			'Page' => 'Bit'
			))
		));*/
}