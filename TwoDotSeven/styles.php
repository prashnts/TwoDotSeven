<?php
namespace TwoDot7\Admin\AssetServer\CSS;
use TwoDot7\Admin\AssetServer\Config as Config;

$Directory = array(
	'backgroundstyles' => 'BackgroundStyles');

function init() {
	global $Directory;
	if (array_key_exists($_GET['File'], $Directory)) {
		header('Content-Type: text/css');
		$Function = 'TwoDot7\\Admin\\AssetServer\\CSS\\'.$Directory[$_GET['File']];
		$Function();
		die();
	}
	elseif (file_exists("css/".$_GET['File'])) {
		header('Content-Type: text/css');
		print @file_get_contents("css/".$_GET['File']);
		die();
	}
	else {
		header('Content-Type: text/css');
		header('HTTP/1.0 404 Does not Exists.', true, 404);
		print $_GET['File']." Does not Exists.";
		die();
	}
}

function BackgroundStyles() {
	?>
	.BG-Primary {
		background: url('<?php echo Config\BackgroundImageRoot.Config\BackgroundImagePrimary;?>') no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		z-index: -100;
		position: fixed;
		width: 100%;
		height: 100%;
	}
	.BG-Secondary {
		background: url('<?php echo Config\BackgroundImageRoot.Config\BackgroundImageSecondary;?>') no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		z-index: -100;
		position: fixed;
		width: 100%;
		height: 100%;
		display: none;
	}
	.BG-Secondary-Red-Tint {
		background: url('<?php echo Config\TintRoot.Config\TintRed;?>'), url('<?php echo Config\BackgroundImageRoot.Config\BackgroundImageSecondary;?>') no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		z-index: -99;
		position: fixed;
		width: 100%;
		height: 100%;
		display: none;
	}
	.BG-Secondary-Blue-Tint {
		background: url('<?php echo Config\TintRoot.Config\TintBlue;?>'), url('<?php echo Config\BackgroundImageRoot.Config\BackgroundImageSecondary;?>') no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		z-index: -98;
		position: fixed;
		width: 100%;
		height: 100%;
		display: none;
	}
	.BG-Secondary-Green-Tint {
		background: url('<?php echo Config\TintRoot.Config\TintGreen;?>'), url('<?php echo Config\BackgroundImageRoot.Config\BackgroundImageSecondary;?>') no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		z-index: -97;
		position: fixed;
		width: 100%;
		height: 100%;
		display: none;
	}
	.BG-Secondary-No-Tint {
		background: url('<?php echo Config\BackgroundImageRoot.Config\BackgroundImageSecondary;?>') no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		z-index: -100;
		position: fixed;
		width: 100%;
		height: 100%;
		display: none;
	}
	<?php
}