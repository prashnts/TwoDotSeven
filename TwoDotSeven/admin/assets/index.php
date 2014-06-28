<?php
namespace TwoDot7\Admin\AssetServer;
#  _____                      _____                         
# /__   \__      _____       |___  |    ___               __    ____                    
#   / /\/\ \ /\ / / _ \         / /    / _ | ___ ___ ___ / /_  / __/__ _____  _____ ____
#  / /    \ V  V / (_) |  _    / /    / __ |(_-<(_-</ -_) __/ _\ \/ -_) __/ |/ / -_) __/
#  \/      \_/\_/ \___/  (_)  /_/    /_/ |_/___/___/\__/\__/ /___/\__/_/  |___/\__/_/   

/**
 * This serves the dynamic styles, JS and images.
 * @author Prashant Sinha <prashantsinha@outlook.com>
 * @since 0.0
 */

require "serverconfig.php";
require "styles.php";

# Parse incoming URI and then process it.
$URI = explode('/', preg_replace("/[\/]+/", "/", $_SERVER['REQUEST_URI']));

const BASE = 2;

switch(strtolower(isset($URI[BASE]) ? $URI[BASE] : False)) {
	case 'css':
		$_GET = array(
			'File' => isset($URI[BASE+1]) ? $URI[BASE+1] : False);
		CSS\init();
		break;
}