<?php
function init_cobalt($required_passport=null, $log=TRUE)
{
    //Start the performance timer
    $start = microtime(TRUE);
    define('PROCESS_START_TIME', $start);

    //Load the global config file and any other class or library files you want to be autoloaded at every page.
    require 'global_config.php';
    require 'data_abstraction_class.php';
    require 'html_class.php';

    if(DEBUG_MODE)
    {
        require_once 'core_debug.php';
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
    }

    //Set timezone as specified in global_config
    date_default_timezone_set(TIMEZONE_SETTING);

    //Start session. Prevent simple session fixation attacks by regenerating session ID when it is first set.
    session_name(GLOBAL_SESSION_NAME);
    session_start();
    if(!isset($_SESSION['initiated']))
    {
        //To mitigate session prediction attacks, ensure entropy length is at leats 16 bytes (128 bits)
        //and the hash function is SHA256 if supported, else SHA1.
        $sess_entropy_length = ini_get('session.entropy_length');
        if($sess_entropy_length < 16)
        {
            ini_set('session.entropy_length',16);
        }
        if(in_array('sha256', hash_algos()))
        {
            ini_set('session.hash_function','sha256');
        }
        else
        {
            ini_set('session.hash_function',1);
        }

        session_regenerate_id(TRUE);
        $_SESSION['initiated'] = TRUE;
    }

    //Default database link - for use with quote_smart()
    //and any other functions that rely on MySQL functions
    //which rely on a valid database link being opened at one point.
    global $default_db_link;
    $dbh = new data_abstraction;
    $default_db_link = $dbh->connect_db()->mysqli;

    if($required_passport!=null)
    {
        //Check if logged; if not, redirect to login page defined by global_config.php.
        if(!isset($_SESSION['logged']) || $_SESSION['logged'] != "Logged")
        {
            redirect(LOGIN_PAGE);
        }
        elseif($_SESSION['ip_address'] != get_ip())
        {
            if(IP_CHANGE_DETECTION)
            {
                //If IP changes, log user out to prevent potential session hijacks.
                log_action('Logged out due to IP address change, from ' . $_SESSION['ip_address'] . ' to ' . get_ip());
                $_SESSION = array();
                if(isset($_COOKIE[session_name()]))
                {
                    setcookie (session_name(), "", time() - 86400);
                }
                session_destroy();
                redirect(LOGIN_PAGE . '?reason=ipchange');
            }
        }

        if($required_passport != 'ALLOW_ALL') check_passport($required_passport);
    }

    //If magic_quotes_gpc is enabled in the server, we have to "clean" the POST data so
    //we always make use of 'virgin' input. This way, all other methods can rely on the fact
    //that all input data will be unescaped when they receive it.
    //OPTIMIZATION TIP: If you can set magic qoutes off in php.ini, do so. This will save processing time.
    if(get_magic_quotes_gpc())
    {
        reverse_magic_quotes($_POST);
    }

    mb_internal_encoding(MULTI_BYTE_ENCODING);

    //Initialize these two variables, they're practically in every page
    global $message;
    global $message_type;
    $message ='';
    $message_type='';

    if($log && LOG_MODULE_ACCESS)
    {
        if(empty($_POST['form_key'])) log_action('Module Access');
    }
}

function check_passport($required_passport)
{
    //Check if '$required_passport' is in the user's passport settings.
    //Not finding it here would mean an illegal access attempt.
    //Similarly, if we find that the module status of '$required_passport' is set to "Off",
    //it also constitutes an illegal access attempt, because modules that are turned off
    //are not displayed in the control center.
    $user = quote_smart($_SESSION['user']);
    $data_con = new data_abstraction;
    $data_con->set_fields('a.status');
    $data_con->set_table('user_links a LEFT JOIN user_passport b ON a.link_id = b.link_id');
    $data_con->set_where("a.name='$required_passport' AND
                          b.username='$user' AND
                          a.status='On'");
    $data_con->exec_fetch('single');
    $numrows = $data_con->num_rows;

    if($numrows==0)
    {
        //Verify that the required passport actually exists
        $data_con = new data_abstraction;
        $data_con->set_fields('link_id');
        $data_con->set_table('user_links');
        $data_con->set_where("name='$required_passport'");
        $data_con->exec_fetch('single');
        $numrows = $data_con->num_rows;
        if($numrows==1)
        {
            log_action("ILLEGAL ACCESS ATTEMPT - Tried to access '$_SERVER[PHP_SELF]' without sufficient privileges.", $_SERVER['PHP_SELF']);

            //Get the security level. Security level setting determines what to do in a detected illegal access attept.
            $data_con = new data_abstraction;
            $data_con->set_fields('value');
            $data_con->set_table('system_settings');
            $data_con->set_where("setting='Security Level'");
            if($result = $data_con->make_query()->result)
            {
                $data = $result->fetch_assoc();
                $security_level = $data['value'];
            }
            else error_handler("Error getting the security level! ",  $data_con->error);
            $data_con->close_db();

            if(strtoupper($security_level)=="HIGH")
            {
                $enable_red_alert=true;
                require 'components/red_alert_screen.php';
                die();
            }
            else
            {
                redirect(HOME_PAGE);
            }
        }
        else
        {
            error_handler("Passport tag does not exist in module list!", 'Passport tag: "' . $required_passport . '"');
        }
    }
}

function check_link($link, $user='')
{
    if($user=='') $user = $_SESSION['user'];
    $user = quote_smart($user);
    $in_passport=FALSE;

    $data_con = new data_abstraction;
    $data_con->set_fields('a.status');
    $data_con->set_table('user_links a LEFT JOIN user_passport b ON a.link_id = b.link_id');
    $data_con->set_where("a.name='$link' AND
                          b.username='$user' AND
                          a.status='On'");
    $data_con->exec_fetch('single');
    $numrows = $data_con->num_rows;
    if ($numrows==1) $in_passport=TRUE;

    return $in_passport;
}

function log_action($action, $module='')
{
    if(isset($_SESSION['user']))
    {
        $username = quote_smart($_SESSION['user']);
    }
    else
    {
        $username = 'Not Logged In';
    }

    if($module=='')
    {
        $module = $_SERVER['SCRIPT_NAME'];
    }

    $date = date("m-d-Y");
    $real_time = date("G:i:s");
    $new_date= explode("-", $date);
    $new_time= explode(":", $real_time);
    $datetime = date('Y-m-d H:i:s');
    $ip_address = get_ip();
    $action = quote_smart($action);

    $data_con = new data_abstraction;
    $data_con->set_query_type('INSERT');
    $data_con->set_table('system_log');
    $data_con->set_fields('ip_address, user, datetime, action, module');
    $data_con->set_values("'$ip_address', '$username', '$datetime', '$action', '$module'");
    $data_con->make_query(TRUE,FALSE);
}

function get_ip()
{
    $ip_address = '';
    if(isset($_SERVER['HTTP_CLIENT_IP']))
    {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    elseif(isset($_SERVER['HTTP_X_FORWARDED']))
    {
        $ip_address = $_SERVER['HTTP_X_FORWARDED'];
    }
    elseif(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
    {
        $ip_address = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    }
    elseif(isset($_SERVER['HTTP_FORWARDED_FOR']))
    {
        $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
    }
    elseif(isset($_SERVER['HTTP_FORWARDED']))
    {
        $ip_address = $_SERVER['HTTP_FORWARDED'];
    }

    if($ip_address == '')
    {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    else
    {
        $ip_address .= ' : ' . $_SERVER['REMOTE_ADDR'];
    }

    return $ip_address;
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

function make_list_array(&$array, $new_entry)
{
    if(!is_array($array)) $array = array();
    if(!in_array($new_entry, $array)) $array[] = $new_entry;
}

function back_quote_smart($var)
{
    if(substr($var,0,1) != '`')
    {
        $var = '`' . $var . '`';
    }

    return $var;
}

function cobalt_htmlentities($unclean, $flag=ENT_QUOTES)
{
    $clean = htmlspecialchars($unclean, $flag, MULTI_BYTE_ENCODING);
    return $clean;
}

function cobalt_htmlentities_decode($unclean, $flag=ENT_QUOTES)
{
    $clean = htmlspecialchars_decode($unclean, $flag, MULTI_BYTE_ENCODING);
    return $clean;
}

function cobalt_load_class($class_name, $class_file='', $subdirectory='')
{
    if($class_file == '')
    {
        $class_file = $class_name;
    }

    if($subdirectory== '')
    {
        $subdirectory = '';
    }
    else
    {
        $subdirectory = $subdirectory . '/';
    }

    require_once 'subclasses/' . $subdirectory . $class_file . '.php';
    return new $class_name;
}

function error_handler($generic_message, $debugging_message='')
{
    $error_message = $generic_message;
    if(DEBUG_MODE)
    {
        brpt();
        $error_message .= ' ' . $debugging_message;
    }
    die('An error occured: ' . $error_message);
}

function generate_token($length=16, $output_type='base64', &$crypto_secure=FALSE)
{
    if($length < 1)
    {
        $length = 16; //resulting length if purposely skipped by dev to settle on whatever is default
    }

    $token='';
    if(function_exists('openssl_random_pseudo_bytes'))
    {
        $token = openssl_random_pseudo_bytes($length, $crypto_secure);
        $output_type = strtolower($output_type);
        switch($output_type)
        {
            case 'base64': $token = str_replace('=', '', base64_encode($token));
                            //any '=' padding is removed, useless for tokens because they do not contribute to randomness, and
                            //only increase the size unnecessarily (e.g., for database storage as GUID or as salt for hash functions)
                           break;

            case 'fs'    : //Make the token safe for use as filesystem name tokens.
                           //sha1 is good here because it makes it fixed length (necessary for prepending tokens to uploaded files)
                           //plus makes sure we do not have any characters that are not safe for use in filenames in different platforms
                           $token = sha1($token);
                           break;

            case 'raw'   : break;

            default      : error_handler('Token generation failed.', 'Invalid output type specified for token');
        }
    }
    else
    {
        error_handler('Token generation failed.','No supported CSPRNG found.');
    }

    return $token;
}

function init_var(&$var, $initialized_value='')
{
    if(empty($var) && $var != '0')
    {
        $var = $initialized_value;
    }
}

function quote_smart($unclean)
{
    global $default_db_link;
    if(get_magic_quotes_gpc())
    {
        $unclean = stripslashes($unclean);
    }
    $clean = mysqli_real_escape_string($default_db_link, $unclean);
    return $clean;
}

function quote_smart_recursive(&$var)
{
    if(is_array($var))
    {
        foreach($var as $key=>$new_var)
        {
            quote_smart_recursive($new_var);
        }
    }
    else
    {
        $var = mysql_real_escape_string($var);
    }
}

function redirect($location, $http_status_code=303)
{
    //** SST Injection ***//
    if(isset($_SESSION['sst']) && $_SESSION['sst']['enabled'] == TRUE)
    {
        $injector = $_SESSION['sst']['tasks'][0]['post'];
        if($injector != '')
        {
            require FULLPATH_BASE . 'sst/post/' . $injector;
        }

        //After SST post script runs (if any), remove the current entry then go to next area.
        array_shift($_SESSION['sst']['tasks']); //removes index 0, which just wrapped up a while ago

        if(count($_SESSION['sst']['tasks']) > 0)
        {
            //More tasks to do, get to it
            $location = '/' . BASE_DIRECTORY . '/' . $_SESSION['sst']['tasks'][0][0];
        }
        else
        {
            //No more tasks to do, end SST.
            unset($_SESSION['sst']);

            //Return to SST listview page
            $location = '/' . BASE_DIRECTORY . '/sst/listview_cobalt_sst.php';
        }
    }

    header('location: ' . $location, true, $http_status_code);
    exit();
}

function reverse_magic_quotes(&$var)
{
    if(is_array($var))
    {
        foreach($var as $key=>$new_var)
        {
            reverse_magic_quotes($var[$key]);
        }
    }
    else
    {
        $var = stripslashes($var);
    }
}

function strip_back_quote_smart($var)
{
    if(substr($var,0,1) == '`')
    {
        $var = substr($var, 1, -1);
    }

    return $var;
}

function enable_xsrf_guard()
{
    $form_key = generate_token();
    $form_identifier = $_SERVER['PHP_SELF'];
    $_SESSION['cobalt_form_keys'][$form_identifier] = $form_key;
    echo '<input type="hidden" name="form_key" value="' . $form_key .'">' . "\r\n";

    //We don't want to accumulate an unlimited amount of Cobalt Form Keys, so once we exceed limit, we remove the oldest one.
    if(count($_SESSION['cobalt_form_keys']) > MAX_FORM_KEYS)
    {
        array_shift($_SESSION['cobalt_form_keys']);
    }
}

function xsrf_guard()
{
    $xsrf_passed = FALSE;
    $session_token_exists = FALSE;
    $form_key_validated = FALSE;

    if(isset($_SESSION['cobalt_form_keys'][$_SERVER['SCRIPT_NAME']]))
    {
        $session_token_exists = TRUE;

        if(isset($_POST['form_key']) && isset($_SESSION['cobalt_form_keys']))
        {
            if($_POST['form_key'] === $_SESSION['cobalt_form_keys'][$_SERVER['SCRIPT_NAME']])
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
