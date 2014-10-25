<?php
namespace TwoDot7\Admin\Template\Dash_Broadcasts_Bits;
use TwoDot7\Admin\Template\Dash_Broadcasts_Bits as Node;
use TwoDot7\Util as Util;
#  _____                      _____ 
# /__   \__      _____       |___  |     _   ___              
#   / /\/\ \ /\ / / _ \         / /     | | / (_)__ _    _____
#  / /    \ V  V / (_) |  _    / /      | |/ / / -_) |/|/ (_-<
#  \/      \_/\_/ \___/  (_)  /_/       |___/_/\__/|__,__/___/

/**
 * _init throws the Markup.
 * @param   $Data -array- Override Dataset.
 * @param   $Data['Call'] -string- REQUIRED. Specifies function call.
 * @return  null
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 16072014
 * @version 0.0
 */
function _init($Data = False) {
    ?>
    <!DOCTYPE html>
    <html lang="en" class="app bg-light">
    <head>
        <?php Node\Head($Data); ?>
    </head>
    <body>
        <section class="hbox stretch">
            <aside class="<?php echo isset($Data['NavbarMood']) ? $Data['NavbarMood'] : "bg-black";?> aside" id="nav">
                <section class="vbox">
                    <header class="header header-md navbar navbar-fixed-top-xs bg" style="z-index:900">
                        <div class="navbar-header">
                            <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav">
                                <i class="fa fa-bars"></i> 
                            </a>
                            <a href="/" class="navbar-brand">
                                <img src="/data/core/static/images/1/logo.png" class="m-r-sm" height="25px">
                            </a>
                            <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
                                <i class="fa fa-cog"></i> 
                            </a>
                        </div>
                    </header>
                    <section class="w-f scrollable">
                        <?php 
                            echo \TwoDot7\Meta\Navigation::GetUserNavInfo();
                        ?>
                        <!-- nav -->
                        <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                            <?php
                                if(isset($Data['Navigation'])) {
                                    echo $Data['Navigation'];
                                }
                                else {
                                    echo \TwoDot7\Meta\Navigation::Get();
                                }
                            ?>
                        </div>
                    </section>
                    <footer class="footer hidden-xs text-center-nav-xs dker">
                        <a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
                            <i class="fa fa-angle-left text"></i>
                            <i class="fa fa-angle-right text-active"></i>
                        </a>
                    </footer>
                </section>
            </aside>
            <section id="content">
                <?php
                    if(method_exists("TwoDot7\Admin\Template\Dash_Broadcasts_Bits\Render", isset($Data['Call']) ? $Data['Call'] : False)) {
                        Node\Render::$Data['Call']($Data);
                    }
                    else {
                        echo "<h1>FATAL ERROR.</h1>";
                    }
                ?>
            </section>
        </section>
        <script src="/data/core/static/js/bootstrap.js"></script>
        <script src="/data/core/static/js/app.js"></script>
        <script src="/data/core/static/js/slimscroll/jquery.slimscroll.min.js"></script>
    </body>
    </html>
    <?php
}

function Head(&$Data) {
    ?>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title><?php echo (isset($Data['Title']) ? $Data['Title'].' | ' : '').('TwoDotSeven'); ?></title>

    <link rel="shortcut icon" href="/TwoDotSeven/admin/assets/images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon-precomposed" href="/TwoDotSeven/admin/assets/images/2.7/apple-touch-icon-precomposed.png" type="image/png" />

    <meta name="msapplication-TileImage" content="/TwoDotSeven/admin/assets/images/2.7/icon-Windows8-tile.png"/>
    <meta name="msapplication-TileColor" content="#343434"/>

    <meta name="description" content="<?php echo (isset($Data['MetaDescription']) ? $Data['MetaDescription'] : 'TwoDotSeven'); ?>" />
    <meta name="robots" content="index, follow" />
    <meta name="google" content="notranslate" />
    <meta name="generator" content="TwoDotSeven" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="/data/core/static/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="/data/core/static/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="/data/core/static/css/font.css" type="text/css" />
    <link rel="stylesheet" href="/data/core/static/css/app.css" type="text/css" />
    <link rel="stylesheet" href="/assetserver/css/backgroundstyles" type="text/css" />
    <link rel="stylesheet" href="/data/core/static/css/style.css" type="text/css" />
    <link rel="stylesheet" href="/data/core/static/js/datepicker/datepicker.css" type="text/css" />

    <script src="/data/core/static/js/jquery.min.js"></script>
    <!--[if lt IE 9]>   
        <script src="/TwoDotSeven/admin/assets/js/ie/html5shiv.js"></script>
        <script src="/TwoDotSeven/admin/assets/js/ie/respond.min.js"></script>
        <script src="/TwoDotSeven/admin/assets/js/ie/excanvas.js"></script>
    <![endif]-->
    <?php
}

class Render {
    public static function Broadcast($Data) {
        ?>
        <section class="scrollable padder bg-light  fill" id="broadcast">
            <div class="m-b-md row padder">
                <div class="col-lg-8">
                </div>
                <div class="col-lg-4">
                </div>
            </div>
            <?php
            if (isset($Data['BroadcastEnabled']) && $Data['BroadcastEnabled']) {
            ?>
                <div class="row m-b-lg">
                    <div class="col-lg-8">
                        <div class="broadcast-post m-b-lg" id="p">
                            <div class="clear row No-Margin-Padding-Override-Hack">
                                <textarea type="text" class="form-control m-b-sm" placeholder="Publish your Broadcast." id="broadcast-post-area"></textarea>
                            </div>
                            <div class="clear row No-Margin-Padding-Override-Hack">
                                <!--button class="btn btn-success m-t-xs " type="button" id="lol">Tag People</button-->
                                <button class="btn btn-success m-t-xs pull-right" type="button" id="broadcast-post-btn" style="display:none;">Broadcast to Everyone</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="row">
                <div class="col-lg-8">
                    <section class="panel broadcast-clear">
                        <ul class="list-group" id="broadcast-container">
                        </ul>
                    </section>
                    <div class="loadMore text-center">
                        <a href="#" class="btn btn-success" id="broadcast-load-post">Load more Broadcasts</a>
                    </div>
                </div>
            </div>
        </section>
        <script src="/data/core/static/js/app-broadcast.js"></script>
        <?php
    }
    public static function Dashboard($Data) {
        ?>
        <section class="scrollable padder bg-dark  fill">

            <div class="row">
                <article class="main-action">
                    <div class="container">
                        <div class="text-lt">
                            <div class="row m-b-sm padder text-center" style="background: url(/data/core/static/images/landing/download.png) repeat fixed;">
                                <h3 class="m-t-xl"><img src="/data/core/static/images/landing/logo.png" height="32px"></h3>
                                <span class="h3 text-lt m-t-lg">One, for all the CIC</span>
                                <br>
                                <br>
                                <br>
                                <?php echo !$Data['Show']->get("LoggedIn") ? '<h3><a href="/twodot7/login" class="btn btn-primary">Login</a> &nbsp; <a href="/twodot7/Signup" class="btn btn-success">Signup</a></h3>' : ""; ?>
                                <?php echo $Data['Show']->get("LoggedIn") ? '<h3><a href="/twodot7/broadcast" class="btn btn-dark">Go to Broadcast</a> &nbsp; <a href="/twodot7/profile" class="btn btn-success">View/Edit Your Profile</a></h3>' : ""; ?>
                                <h6 class="m-t-xl">(Alpha Version) Early Preview | Report bugs/issues at <a href="https://github.com/PrashntS/TwoDotSeven/issues/new">GitHub Issue Tracker</a> or, Mail at <a href="mailto:prashant@ducic.ac.in">prashant@ducic.ac.in</a></h6>
                            </div>
                            <div class="row text-center">
                                <div class="col-lg-4 padder">
                                    <h1><img src="/data/core/static/images/landing/profile-1-256.png" width="128px"></h1>
                                    <h3>Profile</h3>
                                    <h4>Create your official Profile, which doubles as your CV. Add your Projects, Achievements, and your Areas of Interest.</h4>
                                </div>
                                
                                <div class="col-lg-4 padder">
                                    <h1><img src="/data/core/static/images/landing/net-1-256.png" width="128px"></h1>
                                    <h3>Broadcast</h3>
                                    <h4>Connect and Share with your Classmates, Studymates, Teachers and Everyone at CIC. Broadcasts can be either public or targeted to another person.</h4>
                                    <h5>Broadcasts require a verified student, faculty or staff account.</h5>
                                </div>
                                
                                <div class="col-lg-4 padder">
                                    <h1><img src="/data/core/static/images/landing/cluster-1-256.png" width="128px"></h1>
                                    <h3>Join Clusters</h3>
                                    <h4>Be a part of a Cluster and Share ideas, news and files with everyone in it.</h4>
                                    <h5>Clusters are moderated by the Admin.</h5>
                                </div>
                            </div>
                            <div class="row text-center bg-dark lt text-lt">
                                <div class="col-lg-4 padder col-lg-offset-2">
                                    <h1><img src="/data/core/static/images/landing/git-1-256.png" width="128px"></h1>
                                    <h3>Git</h3>
                                    <h4>Develop and share your softwares, codes - The Right Way. With acces to the local Git network, you can have private repositories for your projects. Once ready, share it with the world via GitHub.</h4>
                                    <h5>Git is available in CIC Intranet only.</h5>
                                </div>
                                
                                <div class="col-lg-4 padder">
                                    <h1><img src="/data/core/static/images/landing/apps-1-256.png" width="128px"></h1>
                                    <h3>Modules</h3>
                                    <h4>Take benefits of many more modules, such as:</h4>
                                    <h5>Attendance: View and manage your attendance, get quick alerts if you're lagging behind!</h5>
                                    <h5>Forum: Broadcast doubles as a Forum post. Discuss and brainstorm over anything.</h5>
                                </div>
                            </div>
                            <div class="row m-b-sm padder text-center" style="background: url(/data/core/static/images/landing/download.png) repeat fixed;">
                                <h3>Proudly Open Source</h3>
                                <p>CIC One is built on TwoDot7 - A PHP framework for quick deployment.<br>TwoDot7 and its modules are Open Source, and were developed in the IT Innovations Lab, Cluster Innovation Centre.</p>
                                <a href="https://github.com/PrashntS/TwoDotSeven" target="_blank">
                                    <h1><img src="/data/core/static/images/landing/octo-64.png"></h1>
                                    <h4>View Project on Github.</h4>
                                    <h5><kbd>github.com/Prashnts/TwoDotSeven</kbd></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
        <?php
    }
    public static function UserManagement(&$Data) {
        ?>
        <section class="hbox stretch">
            <section class="vbox">
                <section class="scrollable padder">
                    <div class="m-b-md row padder">
                        <div class="col-lg-6">
                            <h3 class="m-b-none">User Management</h3>
                            <small>View and Manage the registered Users and their Sessions.</small>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-right m-b-n m-t-sm">

                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="container-xs-height m-b-md ">
                        <div class="row padder row-xs-height">
                            <div class="col-md-3 col-md-height bg-dark lt text-white r-r">
                                <div class="wrapper">
                                    <img src="/data/core/static/images/generic/icons/waitx120.png" class="pull-left m-b m-r-xs">
                                    <h2 class="text-muted">Warning</h2>
                                    <h4>Changes made on this Page are <strong>Persistent</strong> and <strong>immediate</strong>.<br>
                                    <small class="text-white">Please take appropriate care while executing actions.</small></h4>
                                </div>
                            </div>
                            <div class="col-md-9 col-md-height col-top bg-primary lt text-white r-r" style="height:100%">
                                <h2 class="text-muted">Quick Stats</h2>
                                <p>TODO</p>
                            </div>
                        </div>
                    </div>
                    <section class="panel panel-default">
                        <div class="table-responsive">
                            <table class="table table-striped b-t b-light">
                                <thead>
                                    <th width="5%">ID</th>
                                    <th width="65%">User</th>
                                    <th width="30%">Status</th>
                                </thead>
                                <tbody id="REST_UserManagementTable">
                                    <tr id="TableToggle1" class="Blur">
                                        <td>1</td>
                                        <td>
                                            <span class="thumb-sm avatar pull-left m-r-sm">
                                                <img src="/assetserver/userNameIcon/p">
                                            <span>
                                            <strong>Loading</strong>
                                            <p>loading@example.com</p
                                            <div class="line line-dashed b-b pull-in"></div>
                                            <div class="row padder">
                                                <span class="text-primary">Quick Edit</span> |
                                                <a href="#"><span class="text-success">View Profile</span></a> |
                                                <a href="#"><span class="text-warning">Send Message</span></a> |
                                                <a href="#"><span class="text-danger">Delete</span></a>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-default"><i class="fa fa-envelope-square"></i> Email</strong>: <span class="text-success"><i class="fa fa-check-circle"></i> Loading </span><br>
                                            <strong class="text-default"><i class="fa fa-user"></i> Profile</strong>: <span class="text-success"><i class="fa fa-check-circle"></i> Loading </span><br>
                                            <strong class="text-default"><i class="fa fa-power-off"></i> Active Sessions</strong>: <span class="text-success">Loading</span><br>
                                        </td>
                                    </tr>
                                    <tr id="TableToggle1" class="Blur">
                                        <td>1</td>
                                        <td>
                                            <span class="thumb-sm avatar pull-left m-r-sm">
                                                <img src="/assetserver/userNameIcon/p">
                                            <span>
                                            <strong>Loading</strong>
                                            <p>loading@example.com</p
                                            <div class="line line-dashed b-b pull-in"></div>
                                            <div class="row padder">
                                                <span class="text-primary">Quick Edit</span> |
                                                <a href="#"><span class="text-success">View Profile</span></a> |
                                                <a href="#"><span class="text-warning">Send Message</span></a> |
                                                <a href="#"><span class="text-danger">Delete</span></a>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-default"><i class="fa fa-envelope-square"></i> Email</strong>: <span class="text-success"><i class="fa fa-check-circle"></i> Loading </span><br>
                                            <strong class="text-default"><i class="fa fa-user"></i> Profile</strong>: <span class="text-success"><i class="fa fa-check-circle"></i> Loading </span><br>
                                            <strong class="text-default"><i class="fa fa-power-off"></i> Active Sessions</strong>: <span class="text-success">Loading</span><br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="AJAXLoader" id="UserListAJAXLoader">
                                <h2><img src="/TwoDotSeven/admin/assets/images/generic/728.gif"></h2>
                                <h4>Loading</h4>
                            </div>
                            <div class="AJAXLoadError" id="UserListAJAXLoadError">
                                <h2><img src="/TwoDotSeven/admin/assets/images/generic/alertx128.png" width="100px"></h2>
                                <h4>Whoops.</h4>
                                <h5>A fatal error occured. Please click reload below, or try again later.<br>
                                <small>If you think this is an Error, please review the Error Logs.</small></h5>
                                <button onclick="GetUserListMarkup()" class="btn btn-primary">Reload</button>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-4 text-center">
                                </div>
                                <div class="col-sm-12 text-center text-center-xs">
                                    <div id="REST_UserManagementPagination">
                                        <ul class="pagination pagination-sm m-t-none m-b-none">
                                            <li><a href="#"><i class="fa fa-chevron-left"></i></a>
                                            </li>
                                            <li class="active"><a href="#">-</a>
                                            </li>
                                            <li><a href="#"><i class="fa fa-chevron-right"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <small class="text-muted inline m-t-sm m-b-sm" id="REST_UserManagementPageLocation">Page - of -</small> 
                                </div>
                            </div>
                        </footer>
                    </section>
                </section>
            </section>
        </section>
        <style>

        </style>
        <script src="/data/core/static/js/app-direction.js"></script>
        <?php
    }
    public static function Bit($Data) {
        if (function_exists($Data['View'])) {
            $Data['View']($Data['ViewData']);
            //call_user_func($Data['View']);
        }
        else {
            $Data = array(
                'Mood'=>"RED",
                'ErrorMessageHead' => 'Invalid Path.',
                'ErrorMessageFoot' => 'The path specified in the URL is not handeled by current bit setup.',
                'ErrorCode' => 'UserError: Invalid Bit Action specified.',
                'Code' => 404,
                'Title' => '404 Bit ID not found',
                );

            \TwoDot7\Admin\Template\Login_SignUp_Error\Mood($Data);
            echo '<section class="scrollable padder fill">';

            //echo '<div style="position:relative; height:100%; width:100%" class="scrollable">';
                \TwoDot7\Admin\Template\Login_SignUp_Error\Render::Error($Data);
            //echo '</div>';
            echo '</section>';

        }
    }
    public static function Profile($Data) {
        ?>
        <section class="hbox stretch">
            <aside class="col-lg-6 bg-light lt b-r no-padder">
                <section class="vbox">
                    <section class="scrollable">
                        <div class="wrapper">
                            <section class="panel panel-default">
                                <?php if (!isset($Data['EditMode']) || !$Data['EditMode']) {
                                    ?>
                                    <div class="panel-heading no-border">
                                        <div class="clearfix m-b-sm">
                                            <span class="pull-left thumb-md avatar b-3x m-r">
                                                <img src="<?php Util\_echo($Data['Meta']['ProfilePicture']); ?>">
                                            </span>
                                            <div class="clear">
                                                <div class="h3 m-t-xs m-b-xs">
                                                <?php echo $Data['Meta']['FirstName']." ".$Data['Meta']['LastName']." @".$Data['Meta']['UserName'];?>
                                                </div>
                                                <?php if (isset($Data['Meta']['Self']) && $Data['Meta']['Self']) echo '<a href="/twodot7/profile/'.$Data['Meta']['UserName'].'/edit" class="btn btn-small btn-default btn-sm pull-right">Edit Profile</a>'; ?>
                                                <h5>
                                                    <?php Util\_echo($Data['Meta']['Designation'], "Unknown User"); ?> &bullet;
                                                    <?php Util\_echo($Data['Meta']['Course'], "Course Unspecified"); ?> &bullet;
                                                    <?php Util\_echo($Data['Meta']['Year']); ?>
                                                </h5> 
                                            </div>
                                        </div>
                                        <hr class="m-t-sm m-b-sm">
                                        <div class="paffe">
                                            <h3>Bio</h3>
                                                <div class="Marked">
                                                    <?php Util\_echo($Data['Meta']['BioParsed']); ?>
                                                </div>
                                            <?php if (isset($Data['Meta']['ShowExtraInfo']) && $Data['Meta']['ShowExtraInfo']) {
                                                ?>
                                                <h3>Personal Info</h3>
                                                <dl class="dl-horizontal">
                                                    <dt>Mobile</dt>
                                                    <dd><?php Util\_echo($Data['Meta']['Mobile'], "Unspecified"); ?></dd>
                                                    <dt>Public Email</dt>
                                                    <dd><?php Util\_echo($Data['Meta']['UserEMail'], "Unspecified"); ?></dd>
                                                    <dt>Date of Birth</dt>
                                                    <dd><?php Util\_echo($Data['Meta']['DOB'], "Unspecified"); ?></dd>
                                                    <dt>Address</dt>
                                                    <dd><?php Util\_echo($Data['Meta']['Address'], "Unspecified"); ?></dd>
                                                </dl>
                                                <?php }
                                            ?>
                                        <hr class="m-t-sm m-b-sm">
                                    </div>
                                    <?php } else {
                                    ?>
                                    <div class="panel-heading no-border m-t">
                                        <div class="row">
                                            <img src="\data\core\static\images\generic\profilex128.png" class="pull-left m-r-sm m-l" height="32">
                                            <span class="h3">@<?php Util\_echo($Data['Meta']['UserName']); ?></span>
                                            <a href="#" class="btn btn-success pull-right m-r" id="profile-update-save"><i class="fa fa-globe"></i>&nbsp; Save Changes</a>
                                            <a href="/twodot7/profile" class="btn btn-primary pull-right m-r-xs"><i class="fa fa-arrow-left"></i></a>
                                        </div>
                                        <hr class="m-t-sm m-b-sm">
                                        <div class="clearfix m-b-sm">
                                            <a href="#" class="pull-left thumb-md avatar b-3x m-r">
                                                <img src="<?php Util\_echo($Data['Meta']['ProfilePicture']); ?>">
                                            </a>
                                            <div class="clear">
                                                <div class="row padder">
                                                    <div class="col-lg-7 no-padder m-r-sm">
                                                        <input id="Profile-FirstName" onchange="ProfileUpdate.FirstName()" type="text" class="form-control has-success" placeholder="First Name" value="<?php Util\_echo($Data['Meta']['FirstName']); ?>">
                                                    </div>
                                                    <div class="col-lg-4 no-padder m-r-sm">
                                                        <input id="Profile-LastName" onchange="ProfileUpdate.LastName()" type="text" class="form-control" placeholder="Last Name" value="<?php Util\_echo($Data['Meta']['LastName']); ?>">
                                                    </div>
                                                </div>
                                                <div class="row padder m-t-sm">
                                                    <div class="col-lg-4 no-padder m-r-xs">
                                                        <select id="Profile-Designation" onchange="ProfileUpdate.Designation()" name="account" class="form-control input-sm col-lg-4">
                                                            <option <?php if (!$Data['Meta']['Designation']) echo "selected"; ?> value="" disabled>Designation</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Designation'], "Student") == 0) echo "selected"; ?> value="Student">Student</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Designation'], "Faculty") == 0) echo "selected"; ?> value="Faculty">Faculty</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Designation'], "Staff") == 0) echo "selected"; ?> value="Staff">Staff</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Designation'], "Others") == 0) echo "selected"; ?> value="Others">Others</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 no-padder m-r-xs">
                                                        <select id="Profile-Course" onchange="ProfileUpdate.Course()" class="form-control input-sm" name="Course" required>
                                                            <option <?php if (!$Data['Meta']['Course']) echo "selected"; ?> value="" disabled>Course</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Course'], "B.Tech. (IT and Mathematical Innovations)") == 0) echo "selected"; ?> value="B.Tech. (IT and Mathematical Innovations)">B.Tech. (IT &amp; Mathematical Innovations)</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Course'], "B.A. Honours (Humanities)") == 0) echo "selected"; ?> value="B.A. Honours (Humanities)">B.A. Honours (Humanities)</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Course'], "M.Sc. (Mathematics Education)") == 0) echo "selected"; ?> value="M.Sc. (Mathematics Education)">M.Sc. (Mathematics Education)</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Course'], "NA") == 0) echo "selected"; ?> value="NA">NA</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 no-padder m-r-xs">
                                                        <select id="Profile-Year" onchange="ProfileUpdate.Year()" name="account" class="form-control input-sm">
                                                            <option <?php if (!$Data['Meta']['Year']) echo "selected"; ?> value="" disabled >Year</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Year'], "First Year") == 0) echo "selected"; ?> value="First Year">First Year</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Year'], "Second Year") == 0) echo "selected"; ?> value="Second Year">Second Year</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Year'], "Third Year") == 0) echo "selected"; ?> value="Third Year">Third Year</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Year'], "Fourth Year") == 0) echo "selected"; ?> value="Fourth Year">Fourth Year</option>
                                                            <option <?php if (strcasecmp($Data['Meta']['Year'], "NA") == 0) echo "selected"; ?> value="NA">NA</option>
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="m-t-sm m-b-sm">
                                        <div class="paffe">
                                            <h3>Bio</h3>
                                            <textarea id="Profile-Bio" onchange="ProfileUpdate.Bio()"  type="text" class="form-control m-b-sm" placeholder="Short Description, Bio. Supports Markdown." rows="8"><?php Util\_echo($Data['Meta']['Bio']); ?></textarea>
                                            <h3>Personal Info</h3>
                                            <dl class="dl-horizontal">
                                                <dt class="m-t-sm">Mobile</dt>
                                                <dd class="m-t-sm"><input id="Profile-Mobile" onchange="ProfileUpdate.Mobile()" type="text" class="form-control" placeholder="Mobile Number" value="<?php Util\_echo($Data['Meta']['Mobile']); ?>"></dd>
                                                <dt class="m-t">Roll Number</dt>
                                                <dd class="m-t-sm"><input id="Profile-RollNumber" onchange="ProfileUpdate.RollNumber()"  type="text" class="form-control" placeholder="Roll Number" value="<?php Util\_echo($Data['Meta']['RollNumber']); ?>"></dd>
                                                <dt class="m-t">Gender</dt>
                                                <dd class="m-t-sm">
                                                    <select id="Profile-Gender" onchange="ProfileUpdate.Gender()"  name="account" class="form-control input-sm">
                                                        <option <?php if (!$Data['Meta']['Gender']) echo "selected"; ?> value="" disabled >Gender</option>
                                                        <option <?php if (strcasecmp($Data['Meta']['Gender'], "Female") == 0) echo "selected"; ?> value="Female">Female</option>
                                                        <option <?php if (strcasecmp($Data['Meta']['Gender'], "Male") == 0) echo "selected"; ?> value="Male">Male</option>
                                                        <option <?php if (strcasecmp($Data['Meta']['Gender'], "Other") == 0) echo "selected"; ?> value="Other">Other</option>
                                                    </select>
                                                </dd>
                                                <dt class="m-t">Date of Birth</dt>
                                                <dd class="m-t-sm"><input id="Profile-DOB" onchange="ProfileUpdate.DOB()"  class="input-sm input-s datepicker-input form-control" size="16" type="text" value="<?php Util\_echo($Data['Meta']['DOB']); ?>" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"></dd>
                                                <dt class="m-t-sm">Address</dt>
                                                <dd class="m-t-sm"><textarea id="Profile-Address" onchange="ProfileUpdate.Address()"  type="text" class="form-control m-b-sm" placeholder="Input your comment here"><?php Util\_echo($Data['Meta']['Address']); ?></textarea></dd>
                                            </dl>
                                        <hr class="m-t-sm m-b-sm">
                                        <div class="row">
                                            <a href="#" class="btn btn-success pull-right m-r" id="profile-update-save-btm"><i class="fa fa-globe"></i>&nbsp; Save Changes</a>
                                        </div>
                                    </div>
                                    <?php }
                                ?>
                            </section>
                        </div>
                    </section>
                </section>
            </aside>
            <aside class="col-lg-6 b-l no-padder">
                <section class="vbox">
                    <section class="scrollable">
                        <div class="wrapper">
                            <div class="row m-b-xs">
                                <div class="col-lg-12">
                                    <div class="broadcast-post m-b-lg" id="p">
                                        <div class="clear row No-Margin-Padding-Override-Hack">
                                            <textarea type="text" class="form-control m-b-sm" placeholder="Input your comment here" id="broadcast-post-area"></textarea>
                                        </div>
                                        <div class="clear row No-Margin-Padding-Override-Hack">
                                            <button class="btn btn-success m-t-xs pull-right" type="button" id="broadcast-post-btn" style="display:none;">Broadcast to Everyone</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <section class="panel broadcast-clear">
                                        <ul class="list-group" id="broadcast-container">
                                        </ul>
                                    </section>
                                    <div class="loadMore text-center">
                                        <a href="#" class="btn btn-success" id="broadcast-load-post">Load more Broadcasts</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </aside>
        </section>
        <script src="/data/core/static/js/app-broadcast.js"></script>
        <?php
    }
    public static function Group($Data) {
        ?>
        <section class="scrollable padder bg-dark  fill">
            <div class="m-b-md row padder">
                <div class="col-lg-6">
                    <h3 class="m-b-none"><img src="/data/core/static/images/landing/cluster-1-256.png" class="pull-left m-r-sm" height="45px"> Clusters </h3>
                    <small>Interact and Manage.</small>
                </div>
            </div>
            <div class="row bg-dark dker padder">
                <div class="m-t-sm m-b-sm col-xs-6 padder">
                    <span class="h4">Quick Stats</span><br>
                    10 Clusters. 100 Unique Users. 50k Broadcasts.<br>
                    Your Clusters: 10. Your Broadcasts in Clusters: 0.
                </div>
                <div class="m-t-sm m-b-sm padder col-xs-6">
                    <div id="Cluster-Add-Panel-Create" style="display:nosne">
                        <img src="/data/core/static/images/generic/icons/cluster-badge-plus-red-64.png" class="pull-left m-r">
                        <a href="#" class="btn btn- btn-success">Create a New Cluster</a>
                        <p>Click the button to create a new Cluster. After a Cluster is created, you'll have options to fill-in the Meta, and add Users.</p>
                    </div>
                    <div id="Cluster-Add-Panel-Success" style="display:none">
                        <img src="/data/core/static/images/generic/icons/cluster-badge-check-blue-64.png" class="pull-left m-r">
                        <p class="h4">Success!</p>
                        <p>
                            Created a New Cluster with GroupID <span class="label bg-dark">grp3293039</span>.
                            <br>
                            Cluster URI: <a href="<?php echo BASEURI."/~"."grp3293039"; ?>"><?php echo BASEURI."/~"."grp3293039"; ?></a>
                            <br>
                            <a href="#" class="btn btn-sm btn-dark m-t-sm"><i class="fa fa-undo"></i> Undo <span class="badge bg-danger" id="Cluster-Add-Timer">5</span> </a>
                            <a href="#" class="btn btn-sm btn-success m-t-sm"><i class="fa fa-external-link-square"></i> Go to Cluster</a>
                            <br>
                            <span class="small m-t-xs">You'll be automatically redirected after 5 seconds.</span>
                        </p>
                    </div>
                    <div id="Cluster-Add-Panel-Error" style="display:none">
                        <img src="/data/core/static/images/generic/icons/cluster-badge-times-red-64.png" class="pull-left m-r">
                        <p class="h4">Error Creating Cluster.</p>
                        <p>
                            Sorry, the process failed. Possible causes are insufficient privileges, network problem or server error. You can try again, or contact the Sysadmin.<br>
                            <a href="#" class="btn btn-sm btn-primary m-t-sm"><i class="fa fa-refresh"></i> Retry</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row padder bg-dark m-t-sm">
                <div id="group-grid" class="cards">
                </div>
            </div>
        </section>
        <style type="text/css">
            .cards {
                margin: 0 auto;
            }
            @media (min-width: 767px) {
                .grp-card {
                    width: 220px;
                    margin: 20px;
                    border-radius: 2px;
                }
            }
            @media (max-width: 768px) {
                .grp-card {
                    width: 220px;
                    margin: 10px;
                    border-radius: 5px;
                }
            }
            .grp-card {
                background: #ECF0F1;
                min-width: 200px;
                text-align: center;
                -webkit-transition: background .1s; /* For Safari 3.1 to 6.0 */
                transition: background .1s;
            }
            .grp-card:hover, .grp-card:focus {
                background: #8DC3E8;
            }
            .grp-card .border {
                border-top: 1px solid #364A5D;
                margin: 30px 0 5px 0;
            }
            .grp-card .title {
                color: #161E26;
                font-size: 1.4em;
                line-height: 1.2em;
            }
            .grp-card .subtitle {
                color: #364A5D;
                font-size: 1em;
            }
            .grp-card .padder {
                padding: 10px;
            }
            .grp-card .preview {
                color: #182129;
            }
            .grp-card img {
                border: 1px solid #161E26;
                -webkit-box-sizing: border-box;
                   -moz-box-sizing: border-box;
                        box-sizing: border-box;
                border-radius: 50%;
                width: 64px;
                height: 64px;
            }
        </style>
        <script type="text/javascript" src="/data/core/static/js/masonry.pkgd.min.js"></script>

        <script src="/data/core/static/js/app-group.js"></script>
        <?php
    }
}