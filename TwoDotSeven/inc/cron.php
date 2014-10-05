<?php
namespace TwoDot7\CRON;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * Class wrapper for CRON Housekeeping functions.
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 25062014
 * @version 0.0
 */
class Housekeeping {
    /**
     * This function assists the Util\Log() function. It rolls over the log file, once it reaches 512 KB file size.
     * This function is tested to be working in Windows and UNIX environments.
     * @internal Function generates a Shell script and executes it, for portability.
     * @param   $AbsPath -string- Path to the Log file.
     * @param   $FileName -string- Generic name of the Log file.
     * @return  Boolean.
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 23062014
     * @version 0.0
     */
    public static function Log($AbsPath, $FileName) {
        if (@filesize($AbsPath."/".$FileName) > 524288) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $ShellScript = 
                    "cd $AbsPath\n".
                    "rename $FileName ".preg_split("/[.]/", $FileName)[0]."-Archive-".time().".log\n".
                    "del SHELL.bat";
                file_put_contents($AbsPath."/SHELL.bat", $ShellScript);
                @exec("$AbsPath/SHELL.bat");
            }
            else {
                $ShellScript = 
                    "cd $AbsPath\n".
                    "rename $FileName ".preg_split("/[.]/", $FileName)[0]."-Archive-".time().".log\n".
                    "rm SHELL.sh";
                file_put_contents($AbsPath."/SHELL.sh", $ShellScript);
                @exec("sh $AbsPath/SHELL.sh");
            }
            return True;
        }
        else {
            return False;
        }
    }
}