<?php
namespace TwoDot7\Admin\Template\Generic;
use TwoDot7\Admin\Template\Generic as Node;

#  _____                      _____ 
# /__   \__      _____       |___  |     _   ___              
#   / /\/\ \ /\ / / _ \         / /     | | / (_)__ _    _____
#  / /    \ V  V / (_) |  _    / /      | |/ / / -_) |/|/ (_-<
#  \/      \_/\_/ \___/  (_)  /_/       |___/_/\__/|__,__/___/

function Head($Data = array()) {
	?>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?php echo (isset($Data['Title']) ? $Data['Title'].' | ' : '').('TwoDotSeven'); ?></title>

	<link rel="shortcut icon" href="/TwoDotSeven/admin/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon-precomposed" href="/TwoDotSeven/admin/assets/images/2.7/apple-touch-icon-precomposed.png" type="image/png" />

	<meta name="msapplication-TileImage" content="/TwoDotSeven/admin/assets/images/2.7/icon-Windows8-tile.png"/>
	<meta name="msapplication-TileColor" content="#343434"/>

	<meta name="description" content="<?php echo (isset($Data['MetaDescription']) ? $Data['MetaDescription'] : 'TwoDotSeven'); ?>" />
	<meta name="robots" content="index, follow" />
	<meta name="google" content="notranslate" />
	<meta name="generator" content="TwoDotSeven" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<link rel="stylesheet" href="/TwoDotSeven/admin/assets/css/base.css" type="text/css" />
	<link rel="stylesheet" href="/TwoDotSeven/admin/assets/css/style.css" type="text/css" />
	<link rel="stylesheet" href="/assetserver/css/backgroundstyles" type="text/css" />


	<!--[if lt IE 9]>	
		<script src="/TwoDotSeven/admin/assets/js/ie/html5shiv.js"></script>
		<script src="/TwoDotSeven/admin/assets/js/ie/respond.min.js"></script>
		<script src="/TwoDotSeven/admin/assets/js/ie/excanvas.js"></script>
	<![endif]-->
	<?php
}
?>