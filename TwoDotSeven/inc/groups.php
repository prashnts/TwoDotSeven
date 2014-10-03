<?php
namespace TwoDot7\Group;
use \TwoDot7\Util as Util;
use \TwoDot7\Mailer as Mailer;
use \TwoDot7\Database as Database;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

class Instance {
    private static $Count = 0;
    private $GroupID;
    private $Meta;
    private $Admin;
    private $Graph;

    function __construct($GroupID) {
        // Constructs the Group Instance. Caches for faster execution.
        $Query = "SELECT * FROM _group WHERE GroupID = :GroupID";
        
        $Response = Database\Handler::Exec($Query)->fetch();

        if (count($Response)) {
            $this->GroupID = $Response['GroupID'];
            $this->Name = $Response['Name'];
            $this->Meta = $Response['Meta'];
            $this->Type = $Response['Type'];
            $this->Graph = $Response['Graph'];
        }
    }

    public function GetUser($UserName) {
        // Returns user rights and checks if user is part of the group.
        // Used to show the User in the Node.
    }

    public function GetGraph() {
        // Returns user graph, including the Users in the Group.
    }

    public function GetBroadcast() {
        // Returns the Broadcasts targeted for this group.
    }

    public static function ListAll() {
        // Lists all the group.
    }
}

class Setup {
    /**
     * Creates the Group, and returns the Generated GroupID.
     */
    public static function Create() {
        if (\TwoDot7\User\Session::Exists() &&
            \TwoDot7\User\Access::Check(array(
                'UserName' => \TwoDot7\User\Session::Data()['UserName'],
                'Domain' => array(
                    'SYSADMIN',
                    'ADMIN',
                    'in.ac.ducic.grpadmin'
                    )
                )) &&
            \TwoDot7\User\Status::Correlate(11, \TwoDot7\User\Status::Get(\TwoDot7\User\Session::Data()['UserName']))) {
            $DatabaseHandler = new \TwoDot7\Database\Handler;

            ########   TODO: Refactor to check the Generated GroupID for collisions.

            $Meta = new \TwoDot7\Util\Dictionary;
            $Graph = new \TwoDot7\Util\_List;

            $Defaults = array(
                'GroupID' => self::UniqueGroupID(),
                'Meta' => $Meta->get(False, True),
                'Admin' => \TwoDot7\User\Session::Data()['UserName'],
                'Graph' => $Graph->get(True)
            );

            $Query = "INSERT INTO _group (GroupID, Meta, Admin, Graph) VALUES (:GroupID, :Meta, :Admin, :Graph);";
            $Response = (int) $DatabaseHandler->Query($Query, $Defaults)->errorCode() === 0;
            if ($Response) return $Defaults['GroupID'];
            else return $Response;
        } else throw new \TwoDot7\Exception\AuthError("User not authenticated, or not authorized to perform this operation.");
    }

    public static function Delete($GroupID) {
        if (\TwoDot7\User\Session::Exists() &&
            \TwoDot7\User\Access::Check(array(
                'UserName' => \TwoDot7\User\Session::Data()['UserName'],
                'Domain' => array(
                    'SYSADMIN',
                    'ADMIN',
                    'in.ac.ducic.grpadmin'
                    )
                )) &&
            \TwoDot7\User\Status::Correlate(11, \TwoDot7\User\Status::Get(\TwoDot7\User\Session::Data()['UserName']))) {
            $Query = "DELETE FROM _group WHERE GroupID = :GroupID;";
            $Response = \TwoDot7\Database\Handler::Exec($Query, array(
                'GroupID' => $GroupID));
            return ((int) $Response->errorCode() === 0) && ((bool) $Response->rowCount());
        } else throw new \TwoDot7\Exception\AuthError("User not authenticated, or not authorized to perform this operation.");
    }

    private static $IterCount = 0;
    private static function UniqueGroupID() {
        self::$IterCount++;
        if (self::$IterCount>32) throw new \TwoDot7\Exception\GaveUp("Cannot generate a Unique ID in given time");
        $ID = "grp_".substr(\TwoDot7\Util\Crypt::RandHash(), 0, 16);
        if (\TwoDot7\Util\Redundant::Group($ID)) {
            return self::UniqueGroupID();
        } else return $ID;
    }
}
