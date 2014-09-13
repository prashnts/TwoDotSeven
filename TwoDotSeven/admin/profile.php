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
	//$installer = new \TwoDot7\Install\Setup;
	//$installer->Navigation();
	//var_dump(\TwoDot7\Bit\Register::Install('in.ac.ducic.tabs'));
	\TwoDot7\Admin\Template\Dash_Broadcasts_Bits\_init(array(
		'Page' => 'PRE_BROADCAST',
		'Call' => 'Profile',
		//'NavbarMood' => 'bg-light dker',
		'Navigation' => \TwoDot7\Meta\Navigation::Get(array(
			'Page' => 'PRE_BROADCAST'
			))
		));
}