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

/**
 * The notification object.
 */
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

    /**
     * Contains the Error info, if it happens to be.
     * @var boolean
     */
    public $Error = False;

    /**
     * Creates the Notification object.
     * @param   Mixed                     $Hook       Determines the type of Notification object.
     *                                                There are two types of notification objects, the
     *                                                New Notification, and the Existing notification.
     *                                                The only difference between them is that while
     *                                                creating New notification, you provide the Other
     *                                                parameters, and pass this parameter a NULL, or
     *                                                True, or False. If you want to fetch a
     *                                                notification from the Database, simply supply
     *                                                the Notification ID (int).
     * @param   Const                     $OriginType The type of the originator, who has emitted the 
     *                                                notification.
     * @param   String                    $Origin     The UserName, or BitID, or GroupID, or the
     *                                                SubSystem.
     * @param   String                    $Target     The UserName of person for which the
     *                                                notification object is created.
     * @param   Const                     $Active     Whether the notification is read or unread.
     * @param   \TwoDot7\Util\Dictionary  $Data       The Notification data. Should be the TwoDot7
     *                                                Dictionary Object.
     * @return  Boolean
     * @throws  \TwoDot7\Exception\InvalidArgument If $Hook is not either (int, bool, null).
     */
    function __construct($Hook, $OriginType = NULL, $Origin = NULL, $Target = NULL, $Active = NULL, $Data = NULL) {
        if (is_bool($Hook) || is_null($Hook)) {

            if (!$Data instanceof \TwoDot7\Util\Dictionary) throw new \TwoDot7\Exception\InvalidArgument("\$Data is not a valid argument of type Dictionary.");

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
            if ((int)$Response->errorCode()[0] === 0) {

                $this->Mode = False;

                $ResponseData = $Response->fetch(\PDO::FETCH_ASSOC);

                $this->ID = $ResponseData['ID'];
                $this->OriginType = $ResponseData['OriginType'];
                $this->Origin = $ResponseData['Origin'];
                $this->Target = $ResponseData['Target'];
                $this->Active = $ResponseData['Active'];
                $this->Data = new \TwoDot7\Util\Dictionary($ResponseData['Data']);
                $this->Timestamp = $ResponseData['Timestamp'];

                $this->Error = False;

            } else $this->Error = True;
        } else throw new \TwoDot7\Exception\InvalidArgument("ID is not a valid argument.");
    }

    /**
     * Pushes the notification object into the Database.
     * IMPORTANT: This method is not valid for Existing Notification objects.
     * @return Boolean Whether "pushed" or not.
     * @throws \TwoDot7\InvalidMethod If This object is Existing notification.
     */
    public function Push() {
        if (!$this->Mode) throw new \TwoDot7\Exception\InvalidMethod("Push is not a valid Method for objects of this type.");
        return (int)\TwoDot7\Database\Handler::Exec(
            "INSERT INTO _activity (OriginType, Origin, Target, Active, Data, Timestamp) VALUES (:OriginType, :Origin, :Target, :Active, :Data, :Timestamp)",
            array(
                'OriginType' => $this->OriginType,
                'Origin' => $this->Origin,
                'Target' => $this->Target,
                'Active' => $this->Active,
                'Data' => $this->Data->get(False, True),
                'Timestamp' => $this->Timestamp
            ))->errorInfo()[0] === 0;
    }

    /**
     * Returns the Notification object as a TwoDot7 dictionary.
     * @return \TwoDot7\Util\Dictionary
     */
    public function Get() {
        return new \TwoDot7\Util\Dictionary(array(
                'ID' => $this->ID,
                'OriginType' => $this->OriginType,
                'Origin' => $this->Origin,
                'Target' => $this->Target,
                'Active' => $this->Active,
                'Data' => $this->Data,
                'Timestamp' => $this->Timestamp
            ));
    }
}

/**
 * Creates the Notification.
 */
class Create {

    /**
     * Creates a notification ORIGINATING from the User.
     * @param \TwoDot7\Util\_List       $Target TwoDot7 list of UserNames.
     * @param \TwoDot7\Util\Dictionary  $Data   TwoDot7 dictionary containing fields, 
     *                                          and the relevant data. Cannot be HTML.
     * @return Boolean
     */
    public static function User($Target, $Data) {
        if (!\TwoDot7\User\Session::Exists()) return False;

        $Origin = \TwoDot7\User\Session::Data()['UserName'];

        $Response = True;
        foreach ($Target->get() as $Target) {
            $Notification = new Notification(
                True,
                USER,
                $Origin,
                $Target,
                UNREAD,
                $Data
            );
            $Response = $Response && $Notification->Push();
        }
        return $Response;
    }

    /**
     * Creates a notification ORIGINATING from the Bit.
     * @param \TwoDot7\Util\_List       $Target TwoDot7 list of UserNames.
     * @param String                    $BitID  The ID of Bit from where the notification is originating.
     * @param \TwoDot7\Util\Dictionary  $Data   TwoDot7 dictionary containing fields, 
     *                                          and the relevant data. Cannot be HTML.
     * @return Boolean
     */
    public static function Bit($Target, $BitID, $Data) {
        $Response = True;
        foreach ($Target->get() as $Target) {
            $Notification = new Notification(
                True,
                BIT,
                $BitID,
                $Target,
                UNREAD,
                $Data
            );
            $Response = $Response && $Notification->Push();
        }
        return $Response;
    }

    /**
     * Creates a notification ORIGINATING from the Group.
     * @param \TwoDot7\Util\_List       $Target     TwoDot7 list of UserNames.
     * @param String                    $GroupID    The ID of Group.
     * @param \TwoDot7\Util\Dictionary  $Data       TwoDot7 dictionary containing fields, 
     *                                              and the relevant data. Cannot be HTML.
     * @return Boolean
     */
    public static function Group($Target, $GroupID, $Data) {
        $Response = True;
        foreach ($Target->get() as $Target) {
            $Notification = new Notification(
                True,
                GROUP,
                $GroupID,
                $Target,
                UNREAD,
                $Data
            );
            $Response = $Response && $Notification->Push();
        }
        return $Response;
    }

    /**
     * Creates a notification ORIGINATING from the System.
     * @param \TwoDot7\Util\_List       $Target     TwoDot7 list of UserNames.
     * @param String                    $SystemName The Name of system subprocess.
     * @param \TwoDot7\Util\Dictionary  $Data       TwoDot7 dictionary containing fields, 
     *                                              and the relevant data. Cannot be HTML.
     * @return Boolean
     */
    public static function System($Target, $SystemName, $Data) {
        $Response = True;
        foreach ($Target->get() as $Target) {
            $Notification = new Notification(
                True,
                SYSTEM,
                $SystemName,
                $Target,
                UNREAD,
                $Data
            );
            $Response = $Response && $Notification->Push();
        }
        return $Response;
    }
}

class Service {
    public static function GetAll() {
        //
    }

    public static function GetNew() {
        //
    }

    public static function Get() {
        //
    }

    public static function SetRead($ID) {
        $Response = \TwoDot7\Database\Handler::Exec(
            "UPDATE _activity SET Active=:Active WHERE ID=:ID;",
            array(
                'ID' => $ID,
                'Active' => READ
            )
        );
        return (bool)((int)((int)$Response->errorCode()[0] === 0) + $Response->rowCount());
    }

    public static function SetUnread($ID) {
        $Response = \TwoDot7\Database\Handler::Exec(
            "UPDATE _activity SET Active=:Active WHERE ID=:ID;",
            array(
                'ID' => $ID,
                'Active' => UNREAD
            )
        );
        return (bool)((int)((int)$Response->errorCode()[0] === 0) + $Response->rowCount());
    }

    public static function Delete($ID) {
        $Response = \TwoDot7\Database\Handler::Exec(
            "DELETE FROM _activity WHERE ID=:ID;",
            array('ID' => $ID));
        return (bool)((int)((int)$Response->errorCode()[0] === 0) + $Response->rowCount());
    }

    public static function DeleteAll($Critaria) {
        // PROPOSED. Not to be implemented before the "Fuzzy" logic.
    }

    public static function EMail() {
        // PROPOSED. Not to be implemented anytime soon.
    }
}