<?php
namespace TwoDot7\REST\Redundant;
#  _____                      _____   
# /__   \__      _____       |___  |     ___  ______________
#   / /\/\ \ /\ / / _ \         / /     / _ \/ __/ __/_  __/
#  / /    \ V  V / (_) |  _    / /     / , _/ _/_\ \  / /   
#  \/      \_/\_/ \___/  (_)  /_/     /_/|_/___/___/ /_/    

function init() {
    switch ($_GET['Function']) {
        case 'username':
            # Response Code Cheat:
            # 262: Error in Input.
            # 252: UserName Already Exists.
            # 253: UserName Available.
            # 400: Syntax Error

            if(isset($_POST['UserName'])) {
                if(!\TwoDot7\Validate\UserName($_POST['UserName'], False)) {
                    header('HTTP/1.0 262 Error In Input', True, 262);
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'Success' => True,
                        'Info' => 'Username is Not Valid. Correct the Input.'));
                    die();
                }
                elseif(\TwoDot7\Util\Redundant::UserName($_POST['UserName'])) {
                    # User Exists
                    header('HTTP/1.0 252 UserName Taken', True, 252);
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'Success' => True,
                        'Info' => 'User '.$_POST['UserName'].' exists in the Database.',
                        'Addnl' => 'UserName is not available for registration.'));
                    die();
                }
                else {
                    header('HTTP/1.0 253 UserName Available', True, 253);
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'Success' => True,
                        'Info' => 'User '.$_POST['UserName'].' does not exists in the Database.',
                        'Addnl' => 'UserName is available for registration.'));
                    die();
                }
            }
            else {
                # Incomplete request
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(array(
                    'Success' => False,
                    'Info' => 'Incomplete request sent by the Client.'));
                die();
            }
            break;
        case 'email':
            # Response Code Cheat:
            # 262: Error in Input.
            # 252: EMail Already Exists.
            # 253: EMail Available.
            # 400: Syntax Error

            if(isset($_POST['EMail'])) {
                if(!\TwoDot7\Validate\EMail($_POST['EMail'], False)) {
                    header('HTTP/1.0 262 Error In Input', True, 262);
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'Success' => True,
                        'Info' => 'EMail is Not Valid. Correct the Input.'));
                    die();
                }
                elseif(\TwoDot7\Util\Redundant::EMail($_POST['EMail'])) {
                    # Email Exists
                    header('HTTP/1.0 252 EMail Taken', True, 252);
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'Success' => True,
                        'Info' => 'Email '.$_POST['EMail'].' exists in the Database.',
                        'Addnl' => 'EMail is not available for registration.'));
                    die();
                }
                else {
                    header('HTTP/1.0 253 EMail Available', True, 253);
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'Success' => True,
                        'Info' => 'EMail '.$_POST['EMail'].' does not exists in the Database.',
                        'Addnl' => 'EMail is available for registration.'));
                    die();
                }
            }
            else {
                # Incomplete request
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(array(
                    'Success' => False,
                    'Info' => 'Incomplete request sent by the Client.'));
                die();
            }
            break;

        default:
            header('HTTP/1.0 450 Invalid Request.', True, 450);
            header('Generator: TwoDot7 REST Engine.');
            echo "<pre>";
            echo "usage /dev/redundant/[email, username]\n";
            echo "Incomplete Request. Please read the Documentation.\n";
            echo "</pre>";
    }
}