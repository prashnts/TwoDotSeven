<?php
namespace TwoDot7\Admin;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * This Invokes and processes the Admin Views.
 * @author Prashant Sinha <prashantsinha@outlook.com>
 * @since 0.0
 */
require "import.php";
_Import('config.php');
_Import('inc/database.php');
_Import('inc/exceptions.php');
_Import('inc/groups.php');
_Import('inc/validator.php');
_Import('inc/utility.php');
_Import('inc/install.php');
_Import('inc/user.php');
_Import('inc/cron.php');
_Import('inc/mailer.php');
_Import('inc/meta.php');
_Import('inc/bits.php');
_Import("admin/login.php");
_Import("admin/logout.php");
_Import("admin/register.php");
_Import("admin/bit.php");
_Import("admin/broadcast.php");
_Import("admin/group.php");
_Import("admin/profile.php");
_Import("admin/dashboard.php");
_Import("admin/administration.php");

_Import("../data/core/views/login.signup.errors.php");
_Import("../data/core/views/dash.broadcast.bits.php");

# Parse incoming URI and then process it.
$URI = preg_split('/[\/\?]/', preg_replace("/[\/]+/", "/", $_SERVER['REQUEST_URI']));

const BASE = 2;

switch(strtolower(isset($URI[BASE]) ? $URI[BASE] : False)) {
    case 'login':
    case 'signin':
    case 'signIn':
        Login\init();
        break;

    case 'logout':
        Logout\init();
        break;

    case 'signup':
    case 'signUp':
    case 'register':
        $_GET = array_merge($_GET, array(
            'Action' => isset($URI[BASE+1]) ? $URI[BASE+1] : False,
            'Target' => isset($URI[BASE+2]) ? $URI[BASE+2] : False,
            'Data' => isset($URI[BASE+3]) ? $URI[BASE+3] : False
            ));
        Register\init();
        break;

    case 'feed':
    case 'news':
    case 'broadcast':
    case 'broadcasts':
        Broadcast\init();
        break;

    case 'plugin':
    case 'bit':
    case 'bits':
        $_GET = array_merge($_GET, array(
            'Bit' => isset($URI[BASE+1]) ? $URI[BASE+1] : False,
            'BitAction' => isset($URI[BASE+2]) ? $URI[BASE+2] : 'init'
            ));
        Bit\init();
        break;

    case 'profile':
    case 'userprofile':
        $_GET = array_merge($_GET, array(
            'UserName' => isset($URI[BASE+1]) ? $URI[BASE+1] : False,
            'Action' => isset($URI[BASE+2]) ? $URI[BASE+2] : 'show'
            ));
        Profile\init();

    case 'administration':
    case 'management':
        $_GET = array_merge($_GET, array(
            'Action' => isset($URI[BASE+1]) ? $URI[BASE+1] : False,
            'SubAction' => isset($URI[BASE+2]) ? $URI[BASE+2] : False
            ));
        Administration\init();
        break;

    case 'group':
        $_GET = array_merge($_GET, array(
            'GroupID' => isset($URI[BASE+1]) ? $URI[BASE+1] : False,
            'Action' => isset($URI[BASE+2]) ? $URI[BASE+2] : 'show'
            ));
        Group\init();
        break;

    case 'dash':
    case 'dashboard':
    case 'overview':
    default:
        Dashboard\init();
}