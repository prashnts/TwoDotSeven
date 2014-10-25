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

/**
 * Creates the Instance of a group. It automatically creates a Graph and Meta object internally.
 * @see \TwoDot7\Group\Graph
 * @see \TwoDot7\Group\Meta
 * @author Prashant Sinha <firstname><lastname>@outlook.com
 * @since v0.1 20141005
 * @version 0.2
 */
class Instance {

    /**
     * Holds the (supplied) group ID.
     * @var String
     */
    private $GroupID;

    /**
     * Holds the Meta Class object.
     * @var Object
     */
    private $Meta;

    /**
     * Holds the Group Admin UserName.
     * @var String
     */
    private $Admin;

    /**
     * Holds the Graph Class object.
     * @var Object
     */
    private $Graph;

    /**
     * Reflects if the group, whose instance is being created, exists and the object has been
     * created successfully.
     * @var Boolean
     */
    public $Success;

    /**
     * Constructs the Group Instance object.
     * @param String $GroupID Required. The GroupID.
     */
    function __construct($GroupID) {
        $Query = "SELECT * FROM _group WHERE GroupID = :GroupID";
        
        $Response = Database\Handler::Exec($Query, array('GroupID' => $GroupID))->fetch(\PDO::FETCH_ASSOC);

        if (is_array($Response)) {
            $this->GroupID = $Response['GroupID'];
            $this->Meta = new \TwoDot7\Group\Meta($this->GroupID, True, $Response);
            $this->Admin = $Response['Admin'];
            $this->Graph = new \TwoDot7\Group\Graph($this->GroupID, True, $Response);
            $this->Success = True;
        } else $this->Success = False;
    }

    /**
     * Returns the Graph object.
     */
    public function Graph() {
        return $this->Graph;
    }

    /**
     * Returns the Meta object.
     */
    public function Meta() {
        return $this->Meta;
    }

    /**
     * Static function, returns all the Groups in the DB.
     */
    public static function ListAll() {
        $Query = "SELECT ID, GroupID, Admin, Meta FROM _group;";
        $Response = \TwoDot7\Database\Handler::Exec($Query)->fetchAll(\PDO::FETCH_ASSOC);
        $Result = new \TwoDot7\Util\_List;
        $Result->linearToggle();
        foreach ($Response as $Key => $Instance) {
            $Meta = new \TwoDot7\Group\Meta($Instance['GroupID'], True, $Instance);
            $Result->add($Meta->Get());
        }
        return $Result->get();
    }
}

/**
 * Creates a Meta Object of a group. Facilitates Addition/Update of the Meta.
 * @author Prashant Sinha <firstname><lastname>@outlook.com
 * @since v0.1 20141005
 * @version 0.2
 */
class Meta {

    /**
     * Holds the GroupID of the group whose meta it is holding.
     * @var String
     */
    private $GroupID;

    /**
     * Holds the Meta Array, fetched from the Database.
     * @var /TwoDot7/Util/Dictionary
     */
    private $Meta;

    /**
     * Contains the status of the Meta. Reflects if the Meta object was created or not.
     * @var Boolean
     */
    public  $Success;

    /**
     * Creates the Meta Object.
     * @param String  $GroupID          Required. The GroupID.
     * @param boolean $FetchOverride    Optional. Default False. If true, will require that the 
     *                                  $FetchSourceArray be passed, too. Will skip the Database call
     *                                  and save additional Database overhead.
     * @param Mixed   $FetchSourceArray Required, if $FetchOverride is true. The Database Response for
     *                                 the particular group ID.
     */
    function __construct($GroupID, $FetchOverride = False, $FetchSourceArray = NULL) {
        $this->GroupID = $GroupID;
        $this->FetchMeta($FetchOverride, $FetchSourceArray);
    }

    /**
     * Fetches Meta from the Database. Optionally, it can skip the Database call, if an existing
     * database response is passes to it.
     * @param boolean $FetchOverride    See __construct.
     * @param Mixed   $FetchSourceArray See __construct.
     */
    private function FetchMeta($FetchOverride = False, $FetchSourceArray = NULL) {
        $Response = False;
        if ($FetchOverride) {
            $Response = $FetchSourceArray;
        } else {
            $Query = "SELECT Meta FROM _group WHERE GroupID = :GroupID;";
            $Response = \TwoDot7\Database\Handler::Exec($Query, array('GroupID' => $this->GroupID))->fetch(\PDO::FETCH_ASSOC);
        }
        if ($Response) {
            $this->Success = True;
            $MetaJSON = json_decode($Response['Meta'], true);
            $this->Meta = $MetaJSON ? new Util\Dictionary($MetaJSON) : new Util\Dictionary;
        } else {
            $this->Success = False;
        }
    }

    /**
     * Pushes Meta in the Database.
     */
    private function PushMeta() {
        return (int)\TwoDot7\Database\Handler::Exec(
            "UPDATE _group SET Meta = :Meta WHERE GroupID = :GroupID;",
            array(
                'Meta' => json_encode($this->Meta->get()),
                'GroupID' => $this->GroupID
            ))->errorCode() === 0;
    }

    /**
     * Handles the Meta. If $Data is provided in the function call (that is, not NULL), then updates
     * the particular $Key in the Meta. Else, returns the value contained in the $Meta.
     * @param String $Key  The Meta Field.
     * @param Mixed  $Data Optional, if specified, updates the Meta with the specifies value against
     *                     given key.
     */
    private function MetaHandler($Key, $Data = NULL) {
        if (!is_string($Key)) throw new \TwoDot7\Exception\InvalidArgument("Key should be a valid string.");
        if (is_null($Data)) return $this->Meta->get($Key);
        else {
            $this->Meta->add($Key, $Data);
            return $this->PushMeta();
        }
    }

    /**
     * Returns the Curated Meta in an Array.
     */
    public function Get() {
        $Response = new \TwoDot7\Util\Dictionary;
        $Response->add("GroupID", $this->GroupID());
        $Response->add("Name", $this->Name());
        $Response->add("Description", $this->Description());
        $Response->add("DescriptionShort", $this->DescriptionShort());
        $Response->add("DescriptionParsed", $this->DescriptionParsed());
        $Response->add("GroupPicture", $this->GroupPicture());
        $Response->add("GroupBackground", $this->GroupBackground());
        $Response->add("URI", $this->URI());
        return $Response->get();
    }

    public function GroupID() {
        return $this->GroupID;
    }
    public function Description($Data = NULL) {
        return $this->MetaHandler("Description", $Data);
    }
    public function DescriptionParsed() {
        return \TwoDot7\Util\Marker($this->MetaHandler("Description"));
    }
    public function DescriptionShort($Data = NULL) {
        return $this->MetaHandler("DescriptionShort", $Data);
    }
    public function Name($Data = NULL) {
        return $this->MetaHandler("Name", $Data);
    }
    public function GroupPicture($Data = NULL) {
        $URI = $this->MetaHandler("GroupPicture", $Data);
        return $URI ? $URI : "/assetserver/userNameIcon/".$this->Name();
    }
    public function GroupBackground($Data = NULL) {
        $URI = $this->MetaHandler("GroupBackground", $Data);
        return $URI ? $URI : "/assetserver/generic/profileBackground";
    }
    public function URI() {
        return BASEURI."/~".$this->GroupID();
    }
}

/**
 * Creates a Graph Object of the group. Facilitates Addition/Update/Removal of Users in the Graph.
 * @author Prashant Sinha <firstname><lastname>@outlook.com
 * @since v0.1 20141005
 * @version 0.2
 */
class Graph {

    /**
     * The GroupID of the group whose Graph is being initialized.
     * @var String
     */
    private $GroupID;
    private $Graph;
    public $Success;

    function __construct($GroupID, $FetchOverride = False, $FetchSourceArray = NULL) {
        $this->GroupID = $GroupID;
        $this->FetchMeta($FetchOverride, $FetchSourceArray);
    }
    private function FetchMeta($FetchOverride = False, $FetchSourceArray = NULL) {
        $Response = False;
        if ($FetchOverride) {
            $Response = $FetchSourceArray;
        } else {
            $Query = "SELECT Graph FROM _group WHERE GroupID = :GroupID;";
            $Response = \TwoDot7\Database\Handler::Exec($Query, array('GroupID' => $this->GroupID))->fetch(\PDO::FETCH_ASSOC);
        }
        if ($Response) {
            $this->Success = True;
            $MetaJSON = json_decode($Response['Graph'], true);
            $this->Graph = $MetaJSON ? new Util\_List($MetaJSON) : new Util\_List;
        } else {
            $this->Success = False;
        }
    }
    private function PushGraph() {
        return (int)\TwoDot7\Database\Handler::Exec(
            "UPDATE _group SET Graph = :Graph WHERE GroupID = :GroupID;",
            array(
                'Graph' => json_encode($this->Graph->get()),
                'GroupID' => $this->GroupID
            ))->errorCode() === 0;
    }
    public function AddUser($UserName) {
        if (!userHasManipulationRights()) throw new \TwoDot7\Exception\AuthError("User not authenticated.");
        if ($this->CheckUser($UserName)) {
            return True;
        } else {
            // First check if user exists.
            if (\TwoDot7\Util\Redundant::UserName($UserName)) {
                // Exists. Add the user in graph, push the graph and if ok, add the token.
                $this->Graph->add($UserName);
                if ($this->PushGraph()) { // is successful.
                    return \TwoDot7\User\Access::Add(array(
                        'UserName' => $UserName,
                        'Domain' => $this->GroupID
                    ));
                } else {
                    \TwoDot7\Util\Log("Could not push the Graph.", "DEBUG");
                    return False;
                }
            } else return False;
        }
    }
    public function CheckUser($UserName) {
        // Checks if a particular user exists in the Graph AND the User has the Group Token.
        // This removes the User from Graph, if it doesn't have the Group Token.
        
        $Check1 = function () use ($UserName) {
            return $this->Graph->exists($UserName);
        };
        $Check2 = function () use ($UserName) {
            return \TwoDot7\User\Access::Check(array(
                'UserName' => $UserName,
                'Domain' => $this->GroupID
            ));
        };

        $Result = $Check1() && $Check2();

        if ($Result) return $Result;
        else {
            if ($Check1() && !$Check2()) {
                // If user exists in graph, but not have the Token.
                // Remove user from graph.
                $this->RemoveUser($UserName);
                return False;
            } elseif (!$Check1() && $Check2()) {
                // If user does not exists in group, but have the Token
                // Remove user token.
                \TwoDot7\User\Access::Revoke(array(
                    'UserName' => $UserName,
                    'Domain' => $this->GroupID
                ));
                return False;
            } else return False;
        }
    }
    public function ListAllUsers() {
        // Lists all users.
        return $this->Graph->get();
    }
    public function VerifyAndCleanUpGraph() {
        $Graph = $this->Graph->get();
        foreach ($Graph as $UserName) {
            $this->CheckUser($UserName);
        }
        return True;
    }
    public function RemoveUser($UserName) {
        if (!userHasManipulationRights() &&
            $UserName != \TwoDot7\User\Session::Data()['UserName']
        ) throw new \TwoDot7\Exception\AuthError("User not authenticated.");

        $this->Graph->remove($UserName);
        \TwoDot7\User\Access::Revoke(array(
            'UserName' => $UserName,
            'Domain' => $this->GroupID
        ));
        return $this->PushGraph();
    }
}

class Setup {
    /**
     * Creates the Group, and returns the Generated GroupID.
     */
    public static function Create() {
        if (userHasManipulationRights()) {
            $DatabaseHandler = new \TwoDot7\Database\Handler;

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
            $Response = $Response && \TwoDot7\User\Access::Add(array(
                'UserName' => $Defaults['Admin'],
                'Domain' => $Defaults['GroupID']
            ));
            if ($Response) {
                $NewGroupMeta = new \TwoDot7\Group\Meta($Defaults['GroupID'], True, $Defaults);
                return $NewGroupMeta->Get();
            }
            else return $Response;
        } else throw new \TwoDot7\Exception\AuthError("User not authenticated, or not authorized to perform this operation.");
    }

    /**
     * [Delete description]
     * @param [type] $GroupID [description]
     */
    public static function Delete($GroupID) {
        if (userHasManipulationRights()) {
            $Query = "DELETE FROM _group WHERE GroupID = :GroupID;";
            $Response = \TwoDot7\Database\Handler::Exec($Query, array(
                'GroupID' => $GroupID));
            return ((int) $Response->errorCode() === 0) && ((bool) $Response->rowCount());
        } else throw new \TwoDot7\Exception\AuthError("User not authenticated, or not authorized to perform this operation.");
    }

    /**
     * [$IterCount description]
     * @var integer
     */
    private static $IterCount = 0;

    /**
     * [UniqueGroupID description]
     */
    private static function UniqueGroupID() {
        self::$IterCount++;
        if (self::$IterCount>32) throw new \TwoDot7\Exception\GaveUp("Cannot generate a Unique ID in given time");
        $ID = "grp".substr(\TwoDot7\Util\Crypt::RandHash(), 0, 16);
        if (\TwoDot7\Util\Redundant::Group($ID)) {
            return self::UniqueGroupID();
        } else return $ID;
    }
}

function userHasManipulationRights() {
    return (\TwoDot7\User\Session::Exists() &&
            \TwoDot7\User\Access::Check(array(
                'UserName' => \TwoDot7\User\Session::Data()['UserName'],
                'Domain' => array(
                    'SYSADMIN',
                    'ADMIN',
                    'in.ac.ducic.grpadmin'
                    )
                )) &&
            \TwoDot7\User\Status::Correlate(11, \TwoDot7\User\Status::Get(\TwoDot7\User\Session::Data()['UserName'])));
}