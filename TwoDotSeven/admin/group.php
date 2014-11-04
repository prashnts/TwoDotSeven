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

        $UserListArray = $Group->Graph()->ListAllUsers(); 

        if (count($UserListArray) > 8) {

        }

        \TwoDot7\Admin\Template\Dash_Broadcasts_Bits\_init(array(
            'Call' => 'GroupMeta',
            'Meta' => $Group->Meta()->get()
            ));
    } else {
        if ($_GET['GroupID']) {
            \TwoDot7\Admin\Template\Dash_Broadcasts_Bits\_init(array(
                'Call' => 'Group'
                ));
        } else {
            \TwoDot7\Admin\Template\Dash_Broadcasts_Bits\_init(array(
                'Call' => 'Group',
                'Title' => 'Groups'
                ));
        }
    }
    die();
}
