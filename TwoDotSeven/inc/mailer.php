<?php
namespace TwoDot7\Mailer;
use \TwoDot7\Util as Util;

#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

function Send($Data) {
	Util\Log(json_encode($Data));
}