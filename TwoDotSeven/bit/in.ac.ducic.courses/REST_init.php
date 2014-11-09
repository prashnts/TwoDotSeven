<?php
namespace TwoDot7\Bit\in_ac_ducic_courses\REST;
use \TwoDOt7\Bit\in_ac_ducic_courses\Controller as Controller;

require in_ac_ducic_courses."/CONTROLLER_init.php";

function init() {
    switch ($_GET['BitAction']) {
        case 'getJSON':
            echo "Works!";
            die();
            break;
        default:
            header('HTTP/1.0 450 Invalid Request.', true, 450);
            echo "<pre>";
            echo "usage /dev/bit/in.ac.ducic.courses/[getJSON]\n";
            echo "Incomplete Request. Please read the Documentation.\n";
            echo "</pre>";
            break;
     }
}
?>