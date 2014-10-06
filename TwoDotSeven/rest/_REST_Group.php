<?php
namespace TwoDot7\REST\Group;
#  _____                      _____   
# /__   \__      _____       |___  |     ___  ______________
#   / /\/\ \ /\ / / _ \         / /     / _ \/ __/ __/_  __/
#  / /    \ V  V / (_) |  _    / /     / , _/ _/_\ \  / /   
#  \/      \_/\_/ \___/  (_)  /_/     /_/|_/___/___/ /_/    

function initRoutine() {
    $Grp = new \TwoDot7\Group\Instance($_GET['GroupID']);

    $ERR_SHOW = function ($Message = False) {
        header('HTTP/1.0 450 Invalid Request.', true, 450);
        echo "<pre>";
        echo " ______            ____\n";
        echo "/_  __/    _____  /_  /\n";
        echo " / / | |/|/ / _ \_ / / \n";
        echo "/_/  |__,__/\___(_)_/  \n\n";
        echo "usage <strong>/dev/group/[GroupID]/[action]/[subaction]</strong>\n";
        echo "ERROR: ".($Message ? $Message."\n" : "None\n");
        echo "<strong>Response Headers:</strong>\n";
        echo "\t<span style=\"color: #A60\">HTTP/1.0 Status: 450 Invalid Request</span>\n";
        foreach (headers_list() as $key => $value) {
            echo "\t$value\n";
        }
        die();
    };

    if ($Grp->Success) switch ($_GET['Action']) {
        case 'meta':
            if (!\TwoDot7\Group\userHasManipulationRights()) $ERR_SHOW("AUTH error. Either You aren't logged-in or you don't have enough Access Privilege to perform this action.");
            // Sets the Group Meta.
            $Success = False;
            switch ($_GET['SubAction']) {
                case 'Name':
                    $Success = $Grp->Meta()->Name(strip_tags($_POST['MetaUpdateValue']));
                    break;
                case 'Description':
                    $Success = $Grp->Meta()->Description(strip_tags($_POST['MetaUpdateValue']));
                    break;
                default:
                    $ERR_SHOW();
                    break;
            }
            if ($Success) {
                header('HTTP/1.0 251 Operation completed successfully.', true, 251);
                header('Content-Type: application/json');
                echo json_encode($Success);
                die();
                break;
            } else {
                $ERR_SHOW();
            }
            break;
        case 'getMeta':
            // gets the Group Meta.
            header('HTTP/1.0 251 Operation completed successfully.', true, 251);
            header('Content-Type: application/json');
            echo json_encode($Grp->Meta()->Get());
            die();
            break;
        case 'listUsers':
            // Returns the Username of everyone in the group.
            // Further meta can be fetched separately from another REST query.
            header('HTTP/1.0 251 Operation completed successfully.', true, 251);
            header('Content-Type: application/json');
            echo json_encode($Grp->Graph()->ListAllUsers());
            die();
            break;
        case 'addUser':
            if (!\TwoDot7\Group\userHasManipulationRights()) $ERR_SHOW("AUTH error. Either You aren't logged-in or you don't have enough Access Privilege to perform this action.");
            // Adds a new user in the graph.
            if ($Grp->Graph()->AddUser($_GET['SubAction'])) {
                header('HTTP/1.0 251 Operation completed successfully.', true, 251);
                header('Content-Type: application/json');
                echo json_encode(True);
                die();
            } else {
                header('HTTP/1.0 461 Error while Processing the Action.', true, 461);
                header('Content-Type: application/json');
                echo json_encode(False);
                die();
            }
            break;
        case 'removeUser':
            if (!\TwoDot7\Group\userHasManipulationRights()) $ERR_SHOW("AUTH error. Either You aren't logged-in or you don't have enough Access Privilege to perform this action.");
            // Removes a user from the graph.
            if ($Grp->Graph()->RemoveUser($_GET['SubAction'])) {
                header('HTTP/1.0 251 Operation completed successfully.', true, 251);
                header('Content-Type: application/json');
                echo json_encode(True);
                die();
            } else {
                header('HTTP/1.0 461 Error while Processing the Action.', true, 461);
                header('Content-Type: application/json');
                echo json_encode(False);
                die();
            }
            break;
        case 'checkUser':
            // Checks if a user is part of group.
            $Response = $Grp->Graph()->CheckUser($_GET['SubAction']);
            if ($Response) {
                header('HTTP/1.0 HTTP/1.0 253 User is a Part of Group.', true, 253);
                header('Content-Type: application/json');
                echo json_encode(True);
            } else {
                header('HTTP/1.0 HTTP/1.0 254 User is not a Part of Group.', true, 254);
                header('Content-Type: application/json');
                echo json_encode(False);
            }
            die();
            break;
    } else {
        $ERR_SHOW("The GroupID you specified doesn't exists.");
    }
}

function initAdmin() {
    $ERR_SHOW = function ($Message = False) {
        header('HTTP/1.0 450 Invalid Request.', true, 450);
        echo "<pre>";
        echo " ______            ____\n";
        echo "/_  __/    _____  /_  /\n";
        echo " / / | |/|/ / _ \_ / / \n";
        echo "/_/  |__,__/\___(_)_/  \n\n";
        echo "usage <strong>/dev/groupadmin/[action]/[subaction]</strong>\n";
        echo "ERROR: ".($Message ? $Message."\n" : "None\n");
        echo "<strong>Response Headers:</strong>\n";
        echo "\t<span style=\"color: #A60\">HTTP/1.0 Status: 450 Invalid Request</span>\n";
        foreach (headers_list() as $key => $value) {
            echo "\t$value\n";
        }
        die();
    };
    switch ($_GET['Action']) {
        case 'create':
            // Create the group, and returns the group ID.
            if (!\TwoDot7\Group\userHasManipulationRights()) $ERR_SHOW("AUTH error. Either You aren't logged-in or you don't have enough Access Privilege to perform this action.");
            $Response = \TwoDot7\Group\Setup::Create();
            if ($Response) {
                header('HTTP/1.0 251 Operation completed successfully.', true, 251);
                header('Content-Type: application/json');
                echo json_encode($Response);
                die();
            } else {
                header('HTTP/1.0 461 Error while Processing the Action.', true, 461);
                header('Content-Type: application/json');
                echo json_encode(False);
                die();
            }
            break;
        case 'delete':
            // Delets the group.
            if (!\TwoDot7\Group\userHasManipulationRights()) $ERR_SHOW("AUTH error. Either You aren't logged-in or you don't have enough Access Privilege to perform this action.");
            if (\TwoDot7\Group\Setup::Delete($_GET['SubAction'])) {
                header('HTTP/1.0 251 Operation completed successfully.', true, 251);
                header('Content-Type: application/json');
                echo json_encode(True);
                die();
            } else {
                header('HTTP/1.0 461 Error while Processing the Action.', true, 461);
                header('Content-Type: application/json');
                echo json_encode(False);
                die();
            }
            break;
        default:
        case 'list':
            // Lists all the users.
            header('HTTP/1.0 251 Operation completed successfully.', true, 251);
            header('Content-Type: application/json');
            echo json_encode(\TwoDot7\Group\Instance::ListAll());
            die();
            break;
    }
}