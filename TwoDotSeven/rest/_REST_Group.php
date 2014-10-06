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
            // Sets the Group Meta.
            break;
        case 'getMeta':
            // gets the Group Meta.
            break;
        case 'listUsers':
            // Returns the Username of everyone in the group.
            // Further meta can be fetched separately from another REST query.
            break;
        case 'addUser':
            // Adds a new user in the graph.
            break;
        case 'removeUser':
            // Removes a user from the graph.
            break;
        case 'checkUser':
            // Checks if a user is part of group.
            break;
    } else {
        $ERR_SHOW("The GroupID you specified doesn't exists.");
    }
}

function initAdmin() {
    switch ($_GET['Action']) {
        case 'create':
            // Create the group, and returns the group ID, and URI.
            break;
        case 'delete':
            // Delets the group.
            break;
        default:
        case 'list':
            // Lists all the users.
            break;
    }
}