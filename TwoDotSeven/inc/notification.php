<?php
namespace TwoDot7\Notification;
use \TwoDot7\Mailer as Mailer;
use \TwoDot7\Util as Util;
#   _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * Origin Type User
 */
const USER = 1;

/**
 * Origin Type Bit
 */
const BIT = 2;

/**
 * Origin Type Group
 */
const GROUP = 3;

/**
 * Origin Type System
 */
const SYSTEM = 4;

/**
 * Notification state Read
 */
const READ = 1;

/**
 * Notification state Unread
 */
const UNREAD = 2;

class Notification {
    private $ID;
    private $OriginType;

    function __construct() {
        //
    }
}

/**
 * Creates the Notification.
 */
class Create {

    /**
     * Creates a notification originating from the User.
     * @param \TwoDot7\Util\_List       $Target TwoDot7 list of UserNames.
     * @param \TwoDot7\Util\Dictionary  $Data   TwoDot7 dictionary containing fields, 
     *                                          and the relevant data. Cannot be HTML.
     * @return Boolean
     */
    public static function User($Target, $Data) {
        $OriginType = USER;
        $Origin = \TwoDot7\User\Session\Data()['UserName'];

        if (!$Origin) return False;

        foreach ($Target->get() as $Target) {
            $Notification = new Notification();
        }

        return True;
    }
}