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
        echo "nope.";
    }
    die();

    \TwoDot7\Admin\Template\Dash_Broadcasts_Bits\_init(array(
        'Page' => 'PRE_GROUP',
        'Call' => 'Group',
        'BroadcastEnabled' => \TwoDot7\User\Status::Correlate(11, \TwoDot7\User\Status::Get(\TwoDot7\User\Session::Data()['UserName'])),
        'Navigation' => \TwoDot7\Meta\Navigation::Get(array(
            'Page' => 'PRE_GROUP'   
            ))
        ));
}