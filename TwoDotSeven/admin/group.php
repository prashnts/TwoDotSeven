<?php
namespace TwoDot7\Admin\Group;

#  _____                      _____ 
# /__   \__      _____       |___  |      ___     __      _    
#   / /\/\ \ /\ / / _ \         / /      / _ |___/ /_ _  (_)__  
#  / /    \ V  V / (_) |  _    / /      / __ / _  /  ' \/ / _ \ 
#  \/      \_/\_/ \___/  (_)  /_/      /_/ |_\_,_/_/_/_/_/_//_/ 
    
/** 
 * init throws the Markup.  
 * @return  null    
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 18072014
 * @version 0.0 
 */
function init() {

    $Group = new \TwoDot7\Group\Instance($_GET['GroupID']);

    if ($Group->Success) {
        echo "yes, init group.";
    } else {
        if ($_GET['GroupID']) {
            echo "No, That group doesnt exists. Create new group?";
        } else {
            echo "Show group list, admin options.";
        }
    }
    die();
}