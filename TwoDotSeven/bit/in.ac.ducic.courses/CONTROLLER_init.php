<?php
namespace TwoDot7\Bit\in_ac_ducic_courses\Controller;
use \TwoDot7\Bit\in_ac_ducic_courses as Node;

function init() {
    switch ($_GET['BitAction']) {
        case 'interface':
        case 'landing':
            return array(
                'Call' => '_Interface',
                'Greet' => "Test Success!"
                );

        default:
            return array(
                'Call' => 'FourOFour');
     }
}

function Install() {
    $Step1 =    "CREATE TABLE IF NOT EXISTS `_bit_in.ac.ducic.courses.course` (".
                "  `CourseID` varchar(256) NOT NULL,".
                "  `Name` varchar(512) NOT NULL,".
                "  `Meta` mediumtext NOT NULL,".
                "  `Instructor` mediumtext NOT NULL,".
                "  `GroupID` varchar(256) NOT NULL".
                ") ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    $Step2 =    "CREATE TABLE IF NOT EXISTS `_bit_in.ac.ducic.courses.schedules` (".
                "  `ID` varchar(256) NOT NULL,".
                "  `Start` varchar(32) NOT NULL,".
                "  `Duration` varchar(16) NOT NULL,".
                "  `CourseID` varchar(256) NOT NULL,".
                "  `Extra` longtext NOT NULL".
                ") ENGINE=InnoDB DEFAULT CHARSET=latin1;"

    $Step3 =    "ALTER TABLE `_bit_in.ac.ducic.courses.course`".
                " ADD PRIMARY KEY (`CourseID`), ADD UNIQUE KEY `CourseID` (`CourseID`);";

    $Step4 =    "ALTER TABLE `_bit_in.ac.ducic.courses.schedules`".
                " ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `ID` (`ID`);";

    $DB = new \TwoDot7\Database\Handler;

    return  ((int)$DB->Query($Step1)->errorInfo()[0] === 0) &&
            ((int)$DB->Query($Step1)->errorInfo()[0] === 0) &&
            ((int)$DB->Query($Step1)->errorInfo()[0] === 0) &&
            ((int)$DB->Query($Step1)->errorInfo()[0] === 0);
}

?>