<?php
namespace TwoDot7\REST\Config;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   
                                  
/**
 * This Configues some REST API Configurations.
 * @author Prashant Sinha <prashantsinha@outlook.com>
 * @since 0.0
 */

# Suppress all the Errors/Notices to prevent the 200 OK header being sent automatically.
# Comment it out in Development Environment, but don't forget to Un-Comment it before deploying.
#error_reporting(0);

# Deliberately slow down responses, to better see the changes in Development Environment.
# Comment it out in Production Environment.
sleep(1);

$ResponseHeaderMeta = array(
	'Served-By' => 'TwoDotSeven\'s Super Awesome REST engine!',
	'Server-Time' => time(),
	'API-Author' => 'Prashant Sinha');
?>
