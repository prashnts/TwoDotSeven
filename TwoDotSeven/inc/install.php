<?php
namespace TwoDot7\Install;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * Sets Up the Environment for Setting up the Website.
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 20062014
 * @version 0.0
 */
class Installer {
    private $DatabaseHandle;
    function __construct() {
        $this->DatabaseHandle = new \TwoDot7\Database\Handler;
    }

    /**
     * Sets up the Tables in SQL.
     * @param boolean $CLI Toggles echo Mode;
     */
    public function BuildTables() {
        var_dump($this->DatabaseHandle->query(self::Queries('_user')));
    }

    private static function Queries($Key) {
        switch ($Key) {
            case "_user":
                return  "CREATE TABLE IF NOT EXISTS `_user` (
                    `ID` int(11) NOT NULL AUTO_INCREMENT,
                    `UserName` varchar(64) NOT NULL,
                    `Password` varchar(128) NOT NULL,
                    `EMail` varchar(255) NOT NULL,
                    `Hash` text NOT NULL,
                    `Tokens` text NOT NULL,
                    `Status` int(11) NOT NULL,
                    PRIMARY KEY (`ID`),
                    UNIQUE KEY `UserName` (`UserName`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        }
    }

}

class Setup {
    private $DatabaseHandle;
    function __construct() {
        $this->DatabaseHandle = new \TwoDot7\Database\Handler;
    }
    public function Navigation() {
        $BaseNavigation = array(
            'PRE_BROADCAST' => array(
                'Name' => 'Broadcast',
                'Icon' => 'fa fa-rss-square',
                'Badge' => array(
                    'Class' => 'bg-info'),
                'Visible' => array(
                    'LOGGEDIN' => True,
                    'NOTLOGGEDIN' => True
                    ),
                'Tokens' => False,                  # If this True, it overrides the 
                'Children' => False,
                'Target' => '/twodot7/broadcast'
                ),
            'PRE_DASHBOARD' => array(
                'Name' => 'Dash',
                'Icon' => 'fa fa-flash',
                'Badge' => array(
                    'Class' => 'bg-success'),
                'Visible' => array(
                    'LOGGEDIN' => True,
                    'NOTLOGGEDIN' => False
                    ),
                'Tokens' => False,
                'Children' => False,
                'Target' => '/twodot7/dash'
                ),
            'PRE_LOGIN' => array(
                'Name' => 'Sign In',
                'Icon' => 'fa fa-sign-in',
                'Badge' => False,
                'Visible' => array(
                    'LOGGEDIN' => False,
                    'NOTLOGGEDIN' => True
                    ),
                'Tokens' => False,
                'Children' => False,
                'Target' => '/twodot7/login'
                ),
            'PRE_REGISTER' => array(
                'Name' => 'Sign Up',
                'Icon' => 'fa fa-edit',
                'Badge' => False,
                'Visible' => array(
                    'LOGGEDIN' => False,
                    'NOTLOGGEDIN' => True
                    ),
                'Tokens' => False,
                'Children' => False,
                'Target' => '/twodot7/register'
                ),
            'PRE_BITS' => array(
                'Name' => 'Two.7 Bits',
                'Icon' => 'fa fa-cube',
                'Badge' => False,
                'Visible' => array(
                    'LOGGEDIN' => True,
                    'NOTLOGGEDIN' => False
                    ),
                'Tokens' => False,
                'Children' => array(
                    'PRE_BIT_ADD' => array(
                        'Name' => 'Get New Bits',
                        'Icon' => 'fa fa-plus-square-o',
                        'Badge' => False,
                        'Visible' => array(
                            'LOGGEDIN' => True,
                            'NOTLOGGEDIN' => False
                            ),
                        'Tokens' => False,
                        'Children' => False,
                        'Target' => '/twodot7/administration/user'
                        ),
                    'PRE_BIT_ADMIN' => array(
                        'Name' => 'Manage Installed Bits',
                        'Icon' => 'fa fa-circle-o',
                        'Badge' => False,
                        'Visible' => array(
                            'LOGGEDIN' => True,
                            'NOTLOGGEDIN' => False
                            ),
                        'Tokens' => False,
                        'Children' => False,
                        'Target' => '/twodot7/administration/user'
                        )

                    ),
                'Target' => '#'
                ),
            'PRE_ADMIN' => array(
                'Name' => 'Administration',
                'Icon' => 'fa fa-gear',
                'Badge' => array(
                    'Class' => 'bg-danger'),
                'Visible' => array(
                    'LOGGEDIN' => True,
                    'NOTLOGGEDIN' => False
                    ),
                'Tokens' => array(
                    'ADMIN'),
                'Children' => array(
                    'PRE_ADMIN_USERMGMT' => array(
                        'Name' => 'User Management',
                        'Icon' => 'fa fa-users',
                        'Badge' => array(
                            'Class' => 'bg-info'
                            ),
                        'Visible' => array(
                            'LOGGEDIN' => True,
                            'NOTLOGGEDIN' => False
                            ),
                        'Tokens' => False,
                        'Children' => False,
                        'Target' => '/twodot7/administration/user'
                        ),
                    'PRE_ADMIN_SYSSTATUS' => array(
                        'Name' => 'System Status',
                        'Icon' => 'fa fa-dashboard',
                        'Badge' => False,
                        'Visible' => array(
                            'LOGGEDIN' => True,
                            'NOTLOGGEDIN' => False
                            ),
                        'Tokens' => array(
                            'ADMIN',
                            'SYSADMIN'),
                        'Children' => False,
                        'Target' => '/twodot7/administration/status'
                        )
                    ),
                'Target' => '#'
                )
            );

        $NavigationQuery = "INSERT INTO _meta (Node, Value) VALUES (:Node, :Value) ON DUPLICATE KEY UPDATE Value=:Value";

        $this->DatabaseHandle->Query($NavigationQuery, array(
            'Node' => 'Navigation',
            'Value' => json_encode($BaseNavigation)
            ));
    }
}


?>