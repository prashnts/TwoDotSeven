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
    /**
     * Notification Field
     * @var Integer
     */
    private $ID;

    /**
     * Notification Field
     * @var Integer
     */
    private $OriginType;

    /**
     * Notification Field
     * @var Mixed
     */
    private $Origin;

    /**
     * Notification Field
     * @var String
     */
    private $Target;

    /**
     * Notification Field
     * @var Integer
     */
    private $Active;

    /**
     * Notification Field
     * @var Mixed
     */
    private $Data;

    /**
     * Notification Field
     * @var Integer
     */
    private $Timestamp;

    /**
     * The mode of the Object created. Can be either a pre-existing Notification, or a New Notification.
     * In case of New Notification, it is True, else, it is False.
     * @var Boolean
     */
    private $Mode;
    public $Error = False;

    function __construct($Hook, $OriginType = NULL, $Origin = NULL, $Target = NULL, $Active = NULL, $Data = NULL) {
        if (is_bool($Hook) || is_null($Hook)) {

            $this->Mode = True;

            $this->OriginType = $OriginType;
            $this->Origin = $Origin;
            $this->Target = $Target;
            $this->Active = $Active;
            $this->Data = $Data;
            $this->Timestamp = time();
            $this->Error = False;
        } elseif (is_numeric($Hook)) {
            $Response = \TwoDot7\Database\Handler::Exec("SELECT * FROM _activity WHERE ID=:ID;", array("ID" => $Hook));
            if ((int)$Response->errorCode() === 0) {

                $this->Mode = False;

                $ResponseData = $Response->fetch(\PDO::FETCH_ASSOC);

                $this->ID = $ResponseData['ID'];
                $this->OriginType = $ResponseData['OriginType'];
                $this->Origin = $ResponseData['Origin'];
                $this->Target = $ResponseData['Target'];
                $this->Active = $ResponseData['Active'];
                $this->Data = $ResponseData['Data'];
                $this->Timestamp = $ResponseData['Timestamp'];

                $this->Error = False;
            } else $this->Error = True;
        } else throw new \TwoDot7\Exception\InvalidArgument("ID is not a valid argument.");
    }

    public function Push() {
        if (!$this->Mode) throw new \TwoDot7\Exception\InvalidMethod("Push is not a valid Method for objects of this type.");
        return (int)\TwoDot7\Database\Handler::Exec(
            "INSERT INTO _activity (OriginType, Origin, Target, Active, Data, Timestamp) VALUES (:OriginType, :Origin, :Target, :Active, :Data, :Timestamp)",
            array(
                'OriginType' => $this->OriginType,
                'Origin' => $this->Origin,
                'Target' => $this->Target,
                'Active' => $this->Active,
                'Data' => $this->Data,
                'Timestamp' => $this->Timestamp
            ))->errorInfo() === 0;
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