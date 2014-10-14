<?php
namespace TwoDot7\REST\Broadcast;
# - .-- --- -.. --- - --... REST

function init() {
    switch ($_GET['Action']) {
        case 'post':

            $ErrorToggle =  False;

            if (!isset($_POST['BroadcastText'])) $ErrorToggle = True;

            if (!\TwoDot7\User\Session::Exists()) $ErrorToggle = True;

            if (isset($_POST['TargetType'])) switch ($_POST['TargetType']) {
                case 'user':
                case 'group':
                case 'custom':
                case \TwoDot7\Broadcast\USER:
                case \TwoDot7\Broadcast\GROUP:
                case \TwoDot7\Broadcast\CUSTOM:
                    # Normalize the Request Variables.
                    if (!isset($_POST['Target'])) $ErrorToggle = True;
                    else $_POST['Target'] = preg_split("/[&]/", $_POST['Target']);

                    if ($_POST['TargetType'] === 'user') $_POST['TargetType'] = \TwoDot7\Broadcast\USER;
                    elseif ($_POST['TargetType'] === 'group') $_POST['TargetType'] = \TwoDot7\Broadcast\GROUP;
                    else $_POST['TargetType'] = \TwoDot7\Broadcast\CUSTOM;

                    break;

                default:
                    $ErrorToggle = True;
                    break;
            } else {
                $_POST['TargetType'] = \TwoDot7\Broadcast\_DEFAULT;
                $_POST['Target'] = array();
            }
            
            if (isset($_POST['Visible'])) switch ($_POST['Visible']) {
                case 'private':
                    $_POST['Visible'] = \TwoDot7\Broadcast\_PRIVATE;
                    break;
                case 'public':
                    $_POST['Visible'] = \TwoDot7\Broadcast\_PUBLIC;
                    break;
                default:
                    $_POST['Visible'] = \TwoDot7\Broadcast\_PUBLIC;
            } else $_POST['Visible'] = \TwoDot7\Broadcast\_PUBLIC;

            if ($ErrorToggle) {
                \TwoDot7\Util\REST::PutError(array(
                    'Params' => array(
                        array("BroadcastText", "POST", \TwoDot7\Util\REST::PARAMREQUIRED),
                        array("TargetType", "GET", \TwoDot7\Util\REST::PARAMOPTIONAL),
                        array("Target", "GET", \TwoDot7\Util\REST::PARAMDEPENDS),
                        array("Visible", "POST", \TwoDot7\Util\REST::PARAMOPTIONAL),
                    ),
                    'Usage' => "/dev/broadcast/post/[TargetType/Target]",
                    'SessionError' => !\TwoDot7\User\Session::Exists()
                ));
            }

            $AddRequest = array(
                'OriginType' => \TwoDot7\Broadcast\USER,
                'Origin' => \TwoDot7\User\Session::Data()['UserName'],
                'TargetType' => $_POST['TargetType'],
                'Target' => $_POST['Target'],
                'Visible' => $_POST['Visible'],
                'Data' => $_POST['BroadcastText']
            );

            $Response = \TwoDot7\Broadcast\Action::Add($AddRequest);

            if ($Response['Success']) {
                header('HTTP/1.0 251 Operation completed successfully.', true, 251);
                header('Content-Type: application/json');
                echo json_encode($Response);
            } else {
                header('HTTP/1.0 261 Bad Request. Operation cannot be completed.', true, 261);
                header('Content-Type: application/json');
                echo json_encode('NOPE');
            }
            die();
            break;

        case 'feed':
            switch ($_GET['ActionHook']) {
                case '<':
                case 'post':
                case '>':
                case 'pre':
                    $UserName = False;
                    $Begin = 0;
                    $Direction = "<";
                    if (\TwoDot7\User\Session::Exists()) $UserName = \TwoDot7\User\Session::Data()['UserName'];
                    if ($_GET['ActionHookData']) $Begin = $_GET['ActionHookData'];
                    if ($_GET['ActionHook'] == ">" || $_GET['ActionHook'] == "pre") $Direction = ">";
                    //elseif ($_GET['ActionHook'] == "<" || $_GET['ActionHook'] == "post") $Direction = "<";
                    else $Direction = "<";
                    $Feeds = \TwoDot7\Broadcast\Feed::_User($UserName, $Begin, $Direction)->get();
                    header('Content-Type: application/json');
                    echo json_encode($Feeds);
                    die();
                    break;
                default:
                    var_dump($_GET);
                    break;
            }
            break;
        case 'test':

        default:
            header('HTTP/1.0 450 Invalid Request.', true, 450);
            echo "<pre>";
            echo "usage /dev/broadcast/[add]\n";
            echo "Incomplete Request. Please read the Documentation.\n";
            echo "</pre>";
    }
}