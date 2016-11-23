<?php
/*
 * SCV2_Core.php
 * FRIDAY, November 24, 2006
 * SCV2 Core file. Loads config & library files and initializes the session.
 * JV Roig
 */
ini_set('include_path', '.');
function init_SCV2()
{
    //Start the performance timer
    $start = microtime(true);
    define('PROCESS_START_TIME', $start);

    //Target directory for the code generator
    define('TARGET_DIRECTORY', 'Generator/Projects/');

    //Load the global config file and library files.
    require_once 'GlobalConfig.php';
    require_once 'SCV2_LibDataAccess.php';
    require_once 'SCV2_LibHTML.php';
    require_once 'SCV2_LibPHP.php';
    require_once 'SCV2_LibSecurity.php';

    date_default_timezone_set(TIMEZONE);

    //Start session.
    session_name("CobaltCG");
    session_start();
    //Initialize these two variables, they're practically on every page
    global $errMsg;
    global $msgType;
    $errMsg ='';
    $msgType='';


}

function custom_error_handler($err_num, $err_str, $err_file, $err_line)
{
    if (!(error_reporting() & $err_num)) {
        // This error code is not included in error_reporting
        return;
    }

    $skip_internal_php_error = TRUE;

    switch ($err_num)
    {
        case E_USER_ERROR:
        case E_USER_WARNING:
        case E_USER_NOTICE:
        case E_WARNING:
        case E_ERROR:
            //write html header and link to css file, to be sure the error message will display properly
            echo '<!DOCTYPE html>';
            echo '<html>
                <head><title>Cobalt</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
                <link href="/cobalt/css/cobalt.css" rel="stylesheet" type="text/css">
                </head>
                <body>';
            if(strtoupper(substr($err_str,0,16)) == 'UNKNOWN DATABASE')
            {
                $msg = "Cobalt failed to connect to its database: " . $err_str .
                       "<br />Perhaps you have not yet created the Cobalt database?";
                displayErrors($msg);
                exit();
            }
            elseif(strtoupper(substr($err_str,0,22)) == 'ACCESS DENIED FOR USER')
            {
                $msg = "Cobalt failed to connect to its database: " . $err_str .
                       "<br />Possible causes: <br /><br />
                   1.) If you have a password for the 'root' account of your database, you need to put that password into
                        the cobalt/Core/SCV2_LibDataAccess.php file (line 14) so that Cobalt can connect to your
                        database properly. <br /><br />
                   2.) If you prepared a special user for Cobalt instead of the default 'root' super account,
                        you need to replace 'root' with that user in cobalt/Core/SCV2_LibDataAccess.php file (line 13).";
                displayErrors($msg);
                exit();
            }
            elseif(substr($err_str,0,18) == 'MISSING EXTENSION:')
            {
                $module_name = substr($err_str, 19);
                $msg = "Required PHP module not found: $module_name.<br>
                       Please install the PHP $module_name module and make sure it is enabled.";
                displayErrors($msg);
            }
            elseif(substr($err_str,0,14) == 'MISSING TABLE:')
            {
                $table_name = substr($err_str, 15);
                /*
                //Old message, using MySQL infra
                $msg = "Cobalt table not found: $table_name.<br>
                       Have you imported the cobalt.sql file to properly create the Cobalt tables?";
                */
                $msg = "Cobalt table not found: $table_name.<br>
                       If this error persists, you may need to force Cobalt to recreate its metadata store.
                       <br>To force metadata recreation, delete the \"status\" file inside the cobalt/metadata directory.";
                displayErrors($msg);
                exit();
            }
            elseif(substr($err_str,0,23) == 'Unsupported PHP Version')
            {

                $msg ="You are running an old PHP version that Cobalt does not support.<br>Cobalt requires at least PHP version 5.3.0 (PHP Version ID 50300)
                       <br />Your version: " . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . '.' . PHP_RELEASE_VERSION . ' (PHP Version ID ' . PHP_VERSION_ID . ')';
                displayErrors($msg);
            }
            elseif(substr($err_str,0,43) == 'Cobalt "metadata" directory is not readable')
            {
                $path = substr($err_str, 45);
                $path = substr($path, 0, strlen($path)-2);
                $msg ="$err_str
                       <br />This directory needs to be world-readable so that Cobalt can access your project information."
                     ."<br /><br />You can correct this error by changing the properties of the metadata directory to be readable."
                     ."<br />In Linux/Unix, the command would be: chmod 0777 $path";
                displayErrors($msg);
            }
            elseif(substr($err_str,0,43) == 'Cobalt "metadata" directory is not writable')
            {
                $path = substr($err_str, 45);
                $path = substr($path, 0, strlen($path)-2);
                $msg ="$err_str
                       <br />This directory needs to be world-writable so that Cobalt can store your project information."
                     ."<br /><br />You can correct this error by changing the properties of the metadata directory to be writable."
                     ."<br />In Linux/Unix, the command would be: chmod 0777 $path";
                displayErrors($msg);
            }
            else
            {
                //echo '<hr>ERROR: ' . $err_str . '<hr>';
                //$skip_internal_php_error = FALSE;
            }
            echo '</body></html>';

            break;

        default:
            //echo "Unknown error type: [$err_num] $err_str<br />\n";
            $skip_internal_php_error = FALSE;
            break;
    }

    return $skip_internal_php_error;
}


function init_var(&$var, $initialized_value='')
{
    if(isset($var))
    {
        //Good
    }
    else
    {
        $var = $initialized_value;
    }
}

function get_token($length=16, &$crypto_secure=FALSE)
{
    $token='';
    if(function_exists('openssl_random_pseudo_bytes'))
    {
        $token = str_replace('=', '', base64_encode(openssl_random_pseudo_bytes($length, $crypto_secure)));
    }
    else
    {
        //This is not ideal at all. You should not be ending up in this branch unless you are on a very old
        //(and not officially Cobalt-supported) version of PHP.
        $token = sha1(uniqid(mt_rand(), TRUE));
    }

    return $token;
}

function make_list(&$list_var, $new_entry, $delimiter=',', $quotes=TRUE, $quote_string_start="'", $quote_string_end="")
{
    if($list_var != '') $list_var .= $delimiter;

    if($quotes==TRUE)
    {
        if($quote_string_end=='') $quote_string_end = $quote_string_start;
        $list_var .= $quote_string_start . $new_entry . $quote_string_end;
    }
    else $list_var .= "$new_entry";
}

function obliterate_dir($dir)
{
    if(is_dir($dir))
    {
        if($dh = opendir($dir))
        {
            while (($file = readdir($dh)) !== false)
            {
                if($file != '.' && $file != '..')
                {
                    if(is_dir($dir . '/' . $file))
                    {
                        obliterate_dir($dir . '/' . $file);
                    }
                    else
                    {
                        unlink($dir . '/' . $file);
                    }
                }
            }
            closedir($dh);
        }
        rmdir($dir);
    }
}

function redirect($location, $http_status_code=303)
{
   header('location: ' . $location, true, $http_status_code);
   exit();
}

function get_textarea_field_names()
{
    $textareaFieldNames = array('ADDRESS',
                                'COMMENT','COMMENTS',
                                'DESCRIPTION',
                                'REMARK','REMARKS',
                                'NOTE','NOTES');
    return $textareaFieldNames;
}

function xsrf_guard()
{
    $xsrf_passed = FALSE;
    $session_token_exists = FALSE;
    $form_key_validated = FALSE;

    if(isset($_SESSION['formKey'][$_SERVER['PHP_SELF']]))
    {
        $session_token_exists = TRUE;

        if(isset($_POST['formKey']) && isset($_SESSION['formKey']))
        {
            if($_POST['formKey'] === $_SESSION['formKey'][$_SERVER['PHP_SELF']])
            {
                $form_key_validated = TRUE;
            }
        }
    }

    if($session_token_exists && $form_key_validated)
    {
        $xsrf_passed = TRUE;
    }

    return $xsrf_passed;
}
?>
