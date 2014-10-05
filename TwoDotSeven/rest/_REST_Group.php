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
        //
    } else {
        // Error time!
    }
}

function initList() {

}