<?php
namespace TwoDot7\Util;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * List Implementation over Native Array. Provides objectified data-structure for
 * easier and manageable, Multiple, List Arrays.
 * @author Prashant Sinha <firstname><lastname>@outlook.com
 * @since v0.1 20141003
 * @version 0.1
 */
class _List {

    /**
     * The List container.
     * @var Array
     */
    private $Array;

    /**
     * Keeps the count of number of elements added in the List.
     * @var Integer
     */
    public  $Counter;

    /**
     * If set true, converts the list in a Add-Only Stack.
     * @var Boolean
     * @see linearToggle
     */
    private $Linear;

    /**
     * If true, it force checks all the elements for presence, while using "exists".
     * @var Boolean
     * @see exists
     */
    private $Strict;

    /**
     * Constructs the List Object.
     * @param array $Array Optional. Predefined array, or JSON Encoded array.
     */
    function __construct($Array = array()) {
        // Fail-safe. Checks if it is JSON string.
        if (is_string($Array)) $Array = json_decode($Array, True);

        if (!is_array($Array)) throw new \TwoDot7\Exception\InvalidArgument("Error in Arguments.");

        $this->Array   = $Array;
        $this->Counter = 0;
        $this->Linear  = False;
        $this->Strict  = False;
    }

    /**
     * Adds a entry in the List.
     * @param Mixed $Data Required. Can be either:
     *                    1. String/Boolean/Number Will be pushed in the List.
     *                    2. Array of multiple String/Boolean/Number Will be pushed in the list.
     * @return Boolean Depicts if the Elements were pushed.
     */
    public function add($Data = NULL) {
        $Routine = function($Data){
            if (!$this->Linear) {
                if ($this->exists($Data)) return True;
                elseif (is_bool($Data) || is_numeric($Data) || is_string($Data)) {
                    ++$this->Counter;
                    return array_push($this->Array, $Data);
                } else return False;
            } else {
                ++$this->Counter;
                return array_push($this->Array, $Data);
            }
        };

        if (!$this->Linear && is_array($Data)) {
            foreach ($Data as $Key => $Value) {
                $Routine($Value);
            }
            return True;
        } else {
            return $Routine($Data);
        }
    }

    /**
     * Checks if a particular entry or, a list of entries exists in the List.
     * @param  Mixed $Needles Required. Can be either:
     *                        1. String/Boolean/Number Will be checked for its existence in List.
     *                        2. Array of Multiple String/Boolean/Number Will be checked for its
     *                           existence in the List. However, if the Strict toggle is enabled,
     *                           ALL the items in the Array MUST be present for a Tautology, otherwise
     *                           it will return a Fallacy. In every other case, it is sufficient to
     *                           have Just One matching element to result in a Tautology.
     * @return Boolean
     */
    public function exists($Needles) {
        if ($this->Linear) throw new \TwoDot7\Exception\InvalidMethod("Method not applicable to this object.");

        if (is_array($Needles)) {
            $Found = False;
            foreach ($Needles as $Key => $Needle) {
                if (in_array($Needle, $this->Array)) $Found = True;
                elseif ($this->Strict) return False;
            }
            return $Found;
        } else {
            return in_array($Needles, $this->Array);
        }
    }

    /**
     * Returns the List as Array or JSON encoded Array String.
     * @param  boolean $JSON Optional. Toggles the Output of get(). If specified, returns a JSON encoded string.
     * @return Mixed
     */
    public function get($JSON = False) {
        if ($JSON) return json_encode($this->Array);
        else return $this->Array;
    }

    /**
     * Toggles a Linear List. If enabled, the list will turn into a Add-Only stack.
     * However. This will disable the "remove", "exists", and "update" methods.
     * Attempts to call those methods will result in an InvalidMethod exception.
     * @return Constant True
     */
    public function linearToggle() {
        $this->Linear = !$this->Linear;
        return True;
    }

    /**
     * Removes a particular entry, or, a list of entries from the list.
     * @param  Mixed $Needle Required. Can be either:
     *                       1. String/Boolean/Number Will be removed from the List if Present.
     *                       2. Array of String/Boolean/Number All found elements will be removed from the List.
     * @return Boolean
     */
    public function remove($Needle) {
        if ($this->Linear) throw new \TwoDot7\Exception\InvalidMethod("Method not applicable to this object.");

        $Routine = function($Needle) {
            if (!(is_bool($Needle) || is_numeric($Needle) || is_string($Needle))) return False;
            $this->Array = array_merge(array_diff(
                $this->Array,
                array($Needle)
            ));
            return True;
        };
        if (is_array($Needle)) {
            $Success = True;
            foreach ($Needle as $Key => $Value) {
                $Success = $Success && $Routine($Value);
            }
            return $Success;
        } else return $Routine($Needle);
    }

    /**
     * Updates the particular named entry from the list.
     * @param  Mixed $Old Required. The Old Entry, should be either of: String/Boolean/Number.
     * @param  Mixed $New Optional. The new, replacing Entry. Should be either of: String/Boolean/Number.
     * @return Boolean
     */
    public function update($Old, $New = NULL) {
        if ($this->Linear) throw new \TwoDot7\Exception\InvalidMethod("Method not applicable to this object.");

        $Success = $this->add($New);
        $Success ? $this->remove($Old) : NULL;
        return $Success;
    }

    /**
     * Toggles the Strict Flag. If enabled, will force "exists" to do an "eager" operation, and check ALL
     * the elements in the Argument.
     * @return Constant True
     */
    public function strictToggle() {
        $this->Strict = !$this->Strict;
        return True;
    }
}

/**
 * Class wrapper for Generating and Verifying URI components, valid for fixed duration.
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 20140828
 * @version 0.0
 */
class BriefURI {

    /**
     * Generates a String Valid for fixed duration.
     * @param   Int $Duration. The duration for the validity of URI. Default: 600 sec. 
     * @return  String. The Output string.
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140825
     * @version 0.0
     */
    public static function Create($Duration = 600) {
        $URI = array(
            'Padding' => rand(1, 10000),
            'Time' => time(),
            'Duration' => is_int($Duration) ? $Duration : 600
            );
        return Crypt::Encrypt(json_encode($URI));
    }

    /**
     * Verifies the Given String to be a Valid.
     * @param   String $URI Required. The string.
     * @return  Boolean.
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140825
     * @version 0.0
     */
    public static function Verify($URI) {
        $Data = json_decode(Crypt::Decrypt($URI), True);
        if (is_array($Data) &&
            isset($Data['Padding']) &&
            isset($Data['Time']) &&
            isset($Data['Duration'])) {
            $CurrentTime = time();
            $CandidateTime = $Data['Time'] + $Data['Duration'];
            if ($CurrentTime <= $CandidateTime) return True;
            else return False;
        } else return False;
    }
}

/**
 * Class wrapper for Cryptic functions.
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 20140620
 * @version 0.0
 */
class Crypt {

    /**
     * This function does a Eager Comparison of two String Candidates in Length-Constant time.
     * @param   $Str1, $Str2: String, Comparison strings.
     * @return  Boolean.
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140623
     * @version 0.0
     */
    public static function EagerCompare($Str1, $Str2) {
        $Diff = strlen($Str1) ^ strlen($Str2);
        for ($i=0; $i < strlen($Str1) && $i < strlen($Str2) ; $i++) { 
            $Diff |= ord($Str1[$i]) ^ ord($Str2[$i]);
        }
        return $Diff === 0;
    }

    /**
     * This function Encrypts a String Candidate.
     * @param   $Candidate: String, To-Be encrypted.
     * @param   $KeyOverride: Array, Overrides Keys set in Configuration.
     * @return  String, Encrypted String.
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140623
     * @version 0.0
     */
    public static function Encrypt($Candidate, $KeyOverride=False) {
        $Method = "AES-256-CBC";
        $Keys = $KeyOverride ? $KeyOverride : array(\TwoDot7\Config\SHA_PRIVATE, \TwoDot7\Config\SHA_INITIAL_VECTOR);
        $Key = hash('sha256', $Keys[0]);
        $Vector = substr(hash('sha256', $Keys[1]), 0, 16);
        return base64_encode(openssl_encrypt($Candidate, $Method, $Key, 0, $Vector));
    }

    /**
     * This function Decrypts an Encrypted String Candidate.
     * @param   $Candidate: String, To-Be decrypted.
     * @param   $KeyOverride: Array, Overrides Keys set in Configuration.
     * @return  String, Decrypted String.
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140623
     * @version 0.0
     */
    public static function Decrypt($Candidate, $KeyOverride=False) {
        $Method = "AES-256-CBC";
        $Keys = $KeyOverride ? $KeyOverride : array(\TwoDot7\Config\SHA_PRIVATE, \TwoDot7\Config\SHA_INITIAL_VECTOR);
        $Key = hash('sha256', $Keys[0]);
        $Vector = substr(hash('sha256', $Keys[1]), 0, 16);
        return openssl_decrypt(base64_decode($Candidate), $Method, $Key, 0, $Vector);
    }

    /**
     * Generates a pseudo-random 16 byte string.
     * @return  String, Pseudo-Random.
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 09072014
     * @version 0.0
     */
    public static function RandHash() {
        $Var=str_shuffle(time());
        $Var.=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15);
        return hash('sha256', $Var);
    }

    /**
     * Generates a Unique, 6 letter string. Could be used as a Confirmation Code.
     * @param   $Candidate -string- The initializer string. Eg. UserName.
     * @param   $Override -array- ('Valid': Overrides the default 32 hours of Code Validity., 
     *              'Length': Between 1 and 32, Overrides the default 6 letter string output.
     * @return  String, the 6 letter code.
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 09072014
     * @version 0.0
     */
    public static function CodeGen($Candidate, $Override = array(
        'Valid' => 115200,
        'Length' => 6,
        'ChangeCase' => True)) {
        # Validate Override.
        if ($Override['Length'] > 32 || 
            $Override['Length'] < 1 || 
            $Override['Valid'] < 0 || 
            $Override['Valid'] > 432000) {
            throw new \TwoDot7\Exception\InvalidArgument("Invalid \$Override");
        }

        $Candidate = $Override['ChangeCase'] ? strtolower($Candidate) : $Candidate;

        # 1. Find the UTC floor.
        $TimeNow = floor(time()/$Override['Valid']);

        # 2. Add salt, according to taste.
        $Candidate = $TimeNow.$Candidate.$TimeNow;
        $Var = strtoupper(substr(hash('sha256', $Candidate), 0, $Override['Length']));
        return $Var;
    }
}

/**
 * Class wrapper for PBKDF2.
 * This implementaion has been ported over to Class - Structure.
 * Password Hashing With PBKDF2 (http://crackstation.net/hashing-security.htm).
 * Copyright (c) 2013, Taylor Hornby
 * All rights reserved.
 * @author  Taylor Hornby
 * @since   v0.0 20140620
 * @version 0.0
 */ 
class PBKDF2 {
    /**
     * Initialization Constants. Can be changed without any effect to existing Hashes.
     * @copyright (c) 2013, Taylor Hornby
     */
    private static $PBKDF2_HASH_ALGORITHM ="sha256";
    private static $PBKDF2_ITERATIONS = 1000;
    private static $PBKDF2_SALT_BYTE_SIZE = 24;
    private static $PBKDF2_HASH_BYTE_SIZE = 24;

    private static $HASH_SECTIONS = 4;
    private static $HASH_ALGORITHM_INDEX = 0;
    private static $HASH_ITERATION_INDEX = 1;
    private static $HASH_SALT_INDEX = 2;
    private static $HASH_PBKDF2_INDEX = 3;

    public static function CreateHash($Password) {
        // format: Algorithm:iterations:Salt:hash
        $Salt = base64_encode(mcrypt_create_iv(self::$PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));
        return self::$PBKDF2_HASH_ALGORITHM . ":" . self::$PBKDF2_ITERATIONS . ":" .  $Salt . ":" .
            base64_encode(self::PBKDF2(
                self::$PBKDF2_HASH_ALGORITHM,
                $Password,
                $Salt,
                self::$PBKDF2_ITERATIONS,
                self::$PBKDF2_HASH_BYTE_SIZE,
                true
            ));
    }

    public static function ValidatePassword($Password, $CorrectHash) {
        $params = explode(":", $CorrectHash);
        if(Count($params) < self::$HASH_SECTIONS)
           return false;
        $PBKDF2 = base64_decode($params[self::$HASH_PBKDF2_INDEX]);
        return Crypt::EagerCompare(
            $PBKDF2,
            self::PBKDF2(
                $params[self::$HASH_ALGORITHM_INDEX],
                $Password,
                $params[self::$HASH_SALT_INDEX],
                (int)$params[self::$HASH_ITERATION_INDEX],
                strlen($PBKDF2),
                true
            )
        );
    }

    /**
     * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
     * @param   $Algorithm - The hash Algorithm to use. Recommended: SHA256
     * @param   $Password - The Password.
     * @param   $Salt - A Salt that is unique to the Password.
     * @param   $Count - Iteration Count. Higher is better, but slower. Recommended: At least 1000.
     * @param   $KeyLength - The length of the derived key in bytes.
     * @param   $RawOutput - If true, the key is returned in raw binary format. Hex encoded otherwise.
     * @return  A $KeyLength-byte key derived from the Password and Salt.
     *
     * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
     *
     * This implementation of PBKDF2 was originally created by https://defuse.ca
     * With improvements by http://www.variations-of-shadow.com
     */
    private static function PBKDF2($Algorithm, $Password, $Salt, $Count, $KeyLength, $RawOutput = false) {
        $Algorithm = strtolower($Algorithm);
        if(!in_array($Algorithm, hash_algos(), true))
            trigger_error('PBKDF2 ERROR: Invalid hash Algorithm.', E_USER_ERROR);
        if($Count <= 0 || $KeyLength <= 0)
            trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);

        if (function_exists("hash_self::PBKDF2")) {
            // The output length is in NIBBLES (4-bits) if $RawOutput is false!
            if (!$RawOutput) {
                $KeyLength = $KeyLength * 2;
            }
            return hash_self::PBKDF2($Algorithm, $Password, $Salt, $Count, $KeyLength, $RawOutput);
        }

        $hash_length = strlen(hash($Algorithm, "", true));
        $block_Count = ceil($KeyLength / $hash_length);

        $output = "";
        for($i = 1; $i <= $block_Count; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $Salt . pack("N", $i);
            // first iteration
            $last = $xorsum = hash_hmac($Algorithm, $last, $Password, true);
            // perform the other $Count - 1 iterations
            for ($j = 1; $j < $Count; $j++) {
                $xorsum ^= ($last = hash_hmac($Algorithm, $last, $Password, true));
            }
            $output .= $xorsum;
        }

        if($RawOutput)
            return substr($output, 0, $KeyLength);
        else
            return bin2hex(substr($output, 0, $KeyLength));
    }
}

/**
 * Class wrapper for Redundancy check functions.
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 20140625
 * @version 0.0
 */
class Redundant {
    /**
     * This function checks the Bit against the Database.
     * @param   string $Candidate The Bit ID.
     * @return  bool
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140805
     * @version 0.0
     */
    public static function Bit($Candidate) {
        $Query = "SELECT count(*) AS count FROM _bit WHERE ID=:ID";
        return \TwoDot7\Database\Handler::Exec($Query, array( 'ID' => $Candidate ))->fetch()['count'] ? True : False;
    }

    /**
     * This function checks the EMail against the Database.
     * @param   $Candidate -string- The EMail.
     * @return  bool
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140625
     * @version 0.0
     */
    public static function EMail($Candidate) {
        $Query = "SELECT count(*) AS count FROM _user WHERE EMail=:EMail";
        return \TwoDot7\Database\Handler::Exec($Query, array( 'EMail' => $Candidate ))->fetch()['count'] ? True : False;
    }
    
    /**
     * This function checks the Group ID against the Database.
     * @param   string $Candidate The EMail.
     * @return  bool
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140822
     * @version 0.0
     */
    public static function Group($Candidate) {
        $Query = "SELECT count(*) AS count FROM _group WHERE GroupID=:GroupID";
        return \TwoDot7\Database\Handler::Exec($Query, array( 'GroupID' => $Candidate))->fetch()['count'] ? True : False;
    }

    /**
     * This function checks the UserName against the Database.
     * @param   $Candidate -string- The UserName.
     * @return  bool
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140625
     * @version 0.0
     */
    public static function UserName($Candidate) {
        $Query = "SELECT count(*) AS count FROM _user WHERE UserName=:UserName";
        return \TwoDot7\Database\Handler::Exec($Query, array( 'UserName' => $Candidate ))->fetch()['count'] ? True : False;
    }
}

/**
 * Class wrapper for REST template functions.
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 20140829
 * @version 0.1
*/
class REST {
    
    /**
     * Parameter Span output style.
     * String PARAMREQUIRED <span style="color:#A60">Required</span>
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.1 20140829
     */
    const PARAMREQUIRED = '<span style="color:#A60">Required</span>';
    
    /**
     * Parameter Span output style.
     * String PARAMOPTIONAL <span style="color:#04F">Optional</span>
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.1 20140829
     */
    const PARAMOPTIONAL = '<span style="color:#04F">Optional</span>';
    
    /**
     * Parameter Span output style.
     * String PARAMDEPENDS <span style="color:#0A6">Depends on Parent</span>
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.1 20140829
     */
    const PARAMDEPENDS = '<span style="color:#0A6">Depends on Parent</span>';

    /**
     * Dumps the Error Message to the Browser.
     * @param   Mixed $Data The Error Data.
     * @return  bool
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140829
     * @version 0.1
     */
    public static function PutError($Data) {
        header('HTTP/1.0 450 Invalid Request.', true, 450);
        echo "<pre>";
        echo " ______            ____\n";
        echo "/_  __/    _____  /_  /\n";
        echo " / / | |/|/ / _ \_ / / \n";
        echo "/_/  |__,__/\___(_)_/  \n\n";
        echo "Usage\t<strong>".(isset($Data['Usage']) ? $Data['Usage'] : '')."</strong>\n";
        foreach ((isset($Data['Params']) ? $Data['Params'] : array()) as $key => $value) {
            echo    (isset($value[1]) ? $value[1] : "GET")."\t".
                    (isset($value[0]) ? $value[0] : "ERROR IN GETTING THE VARIABLE").
                    (isset($value[2]) ? " (".$value[2].") " : " (".self::PARAMOPTIONAL.")");
            echo "\n";
        }
        echo (isset($Data['SessionError']) && $Data['SessionError']) ? "<strong>Additionally, following Error occurred while processing your request:</strong>\n" : "";
        echo isset($Data['SessionError']) && $Data['SessionError'] ? "\t<span style=\"color: #A60\">Session cannot be created or Invalid Session Data Supplied.</span>\n" : "";
        echo "<strong>Response Headers:</strong>\n";
        echo "\t<span style=\"color: #A60\">HTTP/1.0 Status: 450 Invalid Request</span>\n";
        foreach (headers_list() as $key => $value) {
            echo "\t$value\n";
        }
        echo "</pre>";
        die();
    }
}

/**
 * Class wrapper for JSON-fy-able Data Structure manipulation.
 * @internal Moved From \User\Session
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 30062014
 * @version 0.0
 */
class Token {
    /**
     * This function Adds Token, Rolling over to a Max Size MAXIMUM_CONCURRENT_LOGINS in Config 
     * file, if parameter $Rollover is set.
     * @param   $Data -array- JSON initial string and Token to be added.
     * @param   $Data -array- JSON initial string and Token to be added.
     * @return  -string- JSON string containing Tokens.
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @throws  IncompleteArgument Exception.
     * @since   v0.0 20140629
     * @version 0.0
     */
    public static function Add($Data, $RollOver = False) {
        if( isset($Data['JSON']) &&
            isset($Data['Token'])) {
            $Tokens = json_decode($Data['JSON']);
            if(is_array($Tokens)) {
                if($RollOver && (count($Tokens) >= \TwoDot7\Config\MAXIMUM_CONCURRENT_LOGINS)) {
                    $Tokens = array_diff($Tokens, array($Tokens[0]));
                    $Tokens = array_merge($Tokens, array($Data['Token']));
                    return json_encode($Tokens);
                }
                else {
                    return json_encode(array_merge($Tokens, array($Data['Token'])));
                }
            }
            else {
                return json_encode(array(
                    $Data['Token']));
            }
        }
        else {
            throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\Util\\Token::Add");
        }
    }

    /**
     * This function Checks if a Key exists in the JSON string.
     * @param   Mixed $Data JSON initial string and Token to be checked.
     * @param   Bool $Strict If specified, checks against ALL the token. (AND Operator).
     * @return  Bool
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @throws  IncompleteArgument Exception.
     * @since   v0.0 20140629
     * @version 0.2
     */
    public static function Exists($Data, $Strict = False) {
        if( isset($Data['JSON']) &&
            isset($Data['Token'])) {
            $Tokens = json_decode($Data['JSON']);
            if(is_array($Tokens)) {
                if (is_array($Data['Token'])) {
                    $Success = False;
                    foreach ($Data['Token'] as $TokenVal) {
                        if (!in_array($TokenVal, $Tokens)) {
                            if ($Strict) return False;
                        } else $Success = $Success || True;
                    }
                    return $Success;
                } else {
                    return in_array($Data['Token'], $Tokens);
                }
            } else {
                return False;
            }
        } else {
            throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\Util\\Token::Exists");
        }
    }

    /**
     * Returns the Count of Tokens in the Encoded String.
     * @param   array $Data JSON initial.
     * @return  boolean
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @throws  IncompleteArgument Exception.
     * @since   v0.0 20140728
     * @version 0.0
     */
    public static function Count($Data) {
        if( isset($Data['JSON'])) {
            $Tokens = json_decode($Data['JSON']);
            if(is_array($Tokens)) {
                return count($Tokens);
            }
            else {
                return False;
            }
        }
        else {
            throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\Util\\Token::Count");
        }
    }

    /**
     * This function Returns all the Elements of Token.
     * @param   $Data -array- JSON initial string and Token to be checked.
     * @return  -boolean- Self Explanatory.
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @throws  IncompleteArgument Exception.
     * @since   v0.0 20140629
     * @version 0.0
     */
    public static function Get($Data) {
        if( isset($Data['JSON'])) {
            $Tokens = json_decode($Data['JSON'], True);
            if(is_array($Tokens)) {
                return $Tokens;
            }
            else {
                return False;
            }
        }
        else {
            throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\Util\\Token::Get");
        }
    }

    /**
     * This function Removes a token from the JSON string.
     * @param   $Data -array- JSON initial string and Token to be removed.
     * @return  -string- JSON string containing Tokens.
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @throws  IncompleteArgument Exception.
     * @since   v0.0 20140629
     * @version 0.0
     */
    public static function Remove($Data) {
        if( isset($Data['JSON']) &&
            isset($Data['Token'])) {
            $Tokens = json_decode($Data['JSON']);
            if(is_array($Tokens)) {
                return json_encode(array_merge(array_diff($Tokens, array($Data['Token']))));
            }
            else {
                return json_encode(array());
            }
        }
        else {
            throw new \TwoDot7\Exception\IncompleteArgument("Invalid Argument in Function \\Util\\Token::Remove");
        }
    }
}

/**
 * Class wrapper for Dictionary implementation of Arrays.
 * @internal Moved From \User\Profile
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 20140919
 * @version 0.1
 */
class Dictionary {

    /**
     * Stores the Instance of Dictionary.
     */
    private $DictionaryArray;

    /**
     * Enforces Strict. Prevents Overwrite of keys. 
     */
    private $Strict;

    /**
     * Constructs the Dictionary Object.
     * @param   Array $Array Optional. The initial array, to be converted in Dictionary.
     * @return  NaN
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140919
     * @version 0.1 
     */
    function __construct($Array = array(), $Strict = False) {
        if (is_string($Array)) $Array = json_decode($Array, True);
        
        if (!is_array($Array) || 
            !is_bool($Strict)) {
            throw new \TwoDot7\Exception\InvalidArgument("Error in Arguments.");
        }
        $this->DictionaryArray = $Array;
        $this->Strict = $Strict;
    }

    /**
     * Adds a key-value pair in Dictionary.
     * @param   String $Key Required. The Dictionary key.
     * @param   Mixed $Value Optional. The corresponding value.
     * @return  Boolean
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140919
     * @version 0.1 
     */
    public function add($Key, $Value = False) {
        if (array_key_exists($Key, $this->DictionaryArray)) {
            if ($Value && !$this->Strict) {
                $this->DictionaryArray[$Key] = $Value;
                return True;
            } elseif ($Value && $this->DictionaryArray) {
                return False;
            } else {
                $this->DictionaryArray[$Key] = False;
                return True;
            }
        } else {
            if ($Value) {
                $this->DictionaryArray[$Key] = $Value;
            } else {
                $this->DictionaryArray[$Key] = NULL;
            }
        }
        return True;
    }

    /**
     * Removes the given key from Dictionary.
     * @param   String $Key Required. The Dictionary key.
     * @return  Boolean
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140919
     * @version 0.1 
     */
    public function remove($Key) {
        if (array_key_exists($Key, $this->DictionaryArray)) {
            unset($this->DictionaryArray[$Key]);
            return True;
        } else return True;
    }

    /**
     * Gets the Dictionary array.
     * @param   String $Key Optional. The Dictionary key. If unspecified, full Array is returned.
     * @return  Mixed
     * @author  Prashant Sinha <firstname,lastname>@outlook.com
     * @since   v0.0 20140919
     * @version 0.1 
     */
    public function get($Key = False, $JSON = False) {
        if ($Key === False) return $JSON ? json_encode($this->DictionaryArray) : $this->DictionaryArray;
        elseif (array_key_exists($Key, $this->DictionaryArray)) {
            if (is_null($this->DictionaryArray[$Key])) return True;
            else return $this->DictionaryArray[$Key];
        }
        else return False;
    }
}

/**
 * Compares a String against several in an Array. Case insensitive.
 * @param   String $String Required. The subject string.
 * @param   Mixed $Array Required. The candidate array.
 * @return  Boolean.
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 20140921
 * @version 0.1
 */
function arrayStrCaseCmp($String, $Array) {
    $Success = False;
    foreach ($Array as $key => $value) {
        if (strcasecmp($String, $value) === 0) $Success = True;
    }
    return $Success;
}

function _concat($Variable, $Default = "") {
    return isset($Variable) && $Variable ? $Variable : $Default;
}

/**
 * Macro (like) for echo() function, compensating for Failsafe checks.
 * @internal Moved From \Template
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 20140921
 * @version 0.1
 */
function _echo($Variable, $Default = "") {
    echo isset($Variable) && $Variable ? $Variable : $Default;
}

function _wcf() {
    foreach (func_get_args() as $item) {
        if (!is_null($item)) {
            return $item;
        }
    }
}

/**
 * Markdown derivative. TODO
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 20140921
 * @version 0.1
 */
function Marker($Data) {
    if (class_exists("\Parsedown")) {
        $Parsedown = new \Parsedown;
        return $Parsedown->text(strip_tags($Data));
    } else {
        _Import($_SERVER['DOCUMENT_ROOT']."/TwoDotSeven/inc/external/parsedown.php");
        $Parsedown = new \Parsedown;
        return $Parsedown->text(strip_tags($Data));
    }
}

function CrustJS($Data) {
    return Marker($Data);
}

/**
 * Returns the HTTP Request Headers.
 * @return array Contains all the Request Headers.
 * @author limalopex.eisfux.de (From PHP.Net)
 * @link http://php.net/manual/en/function.apache-request-headers.php#70810
 * @since   v0.0 20140801
 * @version 0.0
 */
function RequestHeaders() {
    $arh = array();
    $rx_http = '/\AHTTP_/';
    foreach($_SERVER as $key => $val) {
        if( preg_match($rx_http, $key) ) {
            $arh_key = preg_replace($rx_http, '', $key);
            $rx_matches = array();
            $rx_matches = explode('_', $arh_key);
            if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
                foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
                $arh_key = implode('-', $rx_matches);
            }
            $arh[$arh_key] = $val;
        }
    }
    return( $arh );
}

/**
 * Puts a Log entry in logs folder. Creates a new log file if log file size gets larger than 512 KB.
 * @param   $Message - Logging message.
 * @param   $__Arg - Target Log file.
 * @return  null
 * @author  Prashant Sinha <firstname,lastname>@outlook.com
 * @since   v0.0 20140625
 * @version 0.0
 */
function Log($Message, $__Arg = "SILENT") {
    /**
     * @internal    Time Offset puts the Local Time.
     */
    $UTC = time();
    defined("TIME_OFFSET") ? True : define("TIME_OFFSET", 0);
    $FormattedTime = date("{D,d-M-Y, H:i:s}", $UTC+TIME_OFFSET);

    /**
     * @internal    This finds the Log folder, and eliminates the multiple Log File locations.
     */
    $AbsPath = $_SERVER['DOCUMENT_ROOT'];
    if (is_dir($AbsPath."/TwoDotSeven/logs")) {
        $AbsPath .= "/TwoDotSeven/logs";
    }
    elseif (is_dir($AbsPath."/TwoDotSeven")) {
        mkdir($AbsPath."/TwoDotSeven/logs");
        $AbsPath .= "/TwoDotSeven/logs";
    }
    elseif (is_dir($AbsPath."/logs")) {
        $AbsPath .= "/logs";
    }
    else {
        mkdir("logs.AUTOGENERATED");
        $AbsPath .= "/logs.AUTOGENERATED";
    }

    /**
     * @internal    This finds the correct Log File Name.
     */
    $FileName = "DebugLog.log";
    switch ($__Arg) {
        case "SILENT":
            $FileName = "InfoLog.log";
            break;
        case "DEBUG":
            $FileName = "DebugLog.log";
            break;
        case "ALERT":
            $FileName = "AlertLog.log";
            break;
        case "DIE":
            $FileName = "FatalLog.log";
            break;
        case "TRACK":
            $FileName = "Tracking.log";
            break;
    }

    /**
     * @internal    This calls the CRON cleanup Job.
     */
    \TwoDot7\CRON\Housekeeping::Log($AbsPath, $FileName);

    /**
     * @internal    This encrypts sensetive Log messages. Overrides the Initial vector to the $UTC.
     * @see Crypt::Encrypt
     */
    if ($__Arg === "TRACK")
        $Message = Crypt::Encrypt($Message, array(\TwoDot7\Config\SHA_PRIVATE, $UTC));
    /**
     * @internal    This appends Log message on top of Current Log file.
     */
    $LOG = json_encode(array(
        'Time' => "$FormattedTime",
        'UTC' => $UTC,
        'Log' => "$Message"))."\n".@file_get_contents($AbsPath."/".$FileName);
    @file_put_contents($AbsPath."/".$FileName, $LOG);

    if ($__Arg === "DIE")
        die("Implicit Call by Util\\Log()");

    return;
}
