<?php
require_once 'password_config.php';
function cobalt_password_hash($mode, $password, $username, &$salt='', &$iteration='', &$method='')
{
    if($mode == 'RECREATE')
    {
        $dbh = new data_abstraction;
        $mysqli = $dbh->connect_db()->mysqli;
        $clean_username = $mysqli->real_escape_string($username);

        $dbh->set_table('user');
        $dbh->set_fields('`salt`,`iteration`,`method`');
        $dbh->set_where("`username`='$clean_username'");
        $dbh->exec_fetch('single');
        if($dbh->num_rows == 1)
        {
            extract($dbh->dump);
        }
        else
        {
            //No result found. We should produce fake data, so that the hashing process still takes place,
            //mitigating probing / timing attacks
            $salt = generate_token();
            $method = cobalt_password_set_method();
            if($method == 'blowfish')
            {
                $iteration = AUTH_BLOWFISH_COST_FACTOR;
            }
            else
            {
                $min = constant('AUTH_' . strtoupper($method) . '_MIN_ROUNDS');
                $max = constant('AUTH_' . strtoupper($method) . '_MAX_ROUNDS');
                if($max < $min) $max = $min;
                $iteration = mt_rand($min, $max);
                echo $iteration . ' ' . $method . ' ' . $salt;
            }
        }
        $dbh->close_db();
    }
    elseif($mode == 'NEW')
    {
        $salt = generate_token();
        $method = cobalt_password_set_method();

        if($method == 'blowfish')
        {
            $iteration = AUTH_BLOWFISH_COST_FACTOR;
        }
        else
        {
            $min = constant('AUTH_' . strtoupper($method) . '_MIN_ROUNDS');
            $max = constant('AUTH_' . strtoupper($method) . '_MAX_ROUNDS');
            if($max < $min) $max = $min;
            $iteration = mt_rand($min, $max);
        }
    }
    else
    {
        error_handler("Cobalt encountered an error during password processing.","Cobalt Password Hash Error: Invalid mode specified.");
    }

    if($method == 'blowfish')
    {
        $digest = cobalt_password_hash_bcrypt($password, $salt, $iteration);
    }
    elseif(in_array($method, cobalt_password_methods()))
    {
        $digest = cobalt_password_hash_process($password, $salt, $iteration, $method);
    }
    else
    {
        error_handler("Cobalt encountered an error during password processing.","Cobalt Password Hash Error: Invalid hash method specified.");
    }

    return $digest;
}

function cobalt_password_hash_process($password, $salt, $iteration, $method)
{
    $method = strtolower($method);
    $digest = hash($method, $password . $salt, TRUE);
    for($a=0; $a<$iteration; ++$a)
    {
        $digest = hash($method, $digest, TRUE);
    }
    return str_replace('=', '', base64_encode($digest));
}

function cobalt_password_hash_bcrypt($password, $salt, $iteration)
{
    //Deal with blowfish bug in PHP < 5.3.7
    if(PHP_VERSION_ID < 50307)
    {
        error_handler("Cobalt encountered an error during password processing.","Cobalt Password Hash Error: Attempted to use bcrypt on onlder than PHP 5.3.7. This is a known security risk, and has been stopped. Please change preferred hashing method to an alternative. (SHA512 recommended)");
    }
    else
    {
        $blowfish_salt_start = '$2y$';
    }

    //make sure cost factor is two digit only and within the range 04-31, else crypt() will fail
    if($iteration > 31)
    {
        $iteration = 31;
    }
    if($iteration < 10)
    {
        $iteration = '0' . $iteration;
    }
    if($iteration < 4)
    {
        $iteration = '04';
    }
    $blowfish_cost = $iteration;
    $blowfish_key = '$' . $salt . '$'; 
    $blowfish_key=str_replace('+','.', $blowfish_key); //blowfish salt doesn't support + char
    $blowfish_salt = $blowfish_salt_start . $blowfish_cost . $blowfish_key;
    $digest = crypt($password . $salt, $blowfish_salt);
    return $digest;
}

function cobalt_password_hash_crypt($password, $salt, $iteration, $method='sha512')
{
    $method = strtolower($method);
    if($method = 'sha512')
    {
        $salt_start = '$5$';
    }
    elseif($method = 'sha256')
    {
        $salt_start = '$4$';
    }
    $salt = $salt_start . 'rounds=' . $iteration . '$' . $salt . '$';
    $digest = crypt($password, $salt);
    return $digest;
}

function cobalt_password_must_rehash($username)
{
    $must_rehash = FALSE;
    $dbh = new data_abstraction;
    $dbh->set_table('user');
    $dbh->set_fields('`iteration`, `method` AS `current_method`');
    $dbh->set_where("`username`= ?");
    $bind_params = array('s', $username);
    $dbh->stmt_prepare($bind_params);
    $dbh->stmt_fetch('single');

    if($dbh->num_rows == 1)
    {
        extract($dbh->dump);
    }

    $method = cobalt_password_set_method();
    if($method == $current_method)
    {
        if($method == 'blowfish')
        {
            $blowfish_cost_factor = AUTH_BLOWFISH_COST_FACTOR;
            if((int) $iteration <> (int) $blowfish_cost_factor)
            {
                $must_rehash = TRUE;
            }
        }
        else
        {
            $min = constant('AUTH_' . strtoupper($method) . '_MIN_ROUNDS');
            $max = constant('AUTH_' . strtoupper($method) . '_MAX_ROUNDS');
            if($max < $min) $max = $min;
            if($iteration < $min || $iteration > $max)
            {
                $must_rehash = TRUE;
            }
        }
    }
    else
    {
        $must_rehash = TRUE;
    }

    return $must_rehash;
}

function cobalt_password_methods()
{
    //methods supported by Cobalt
    return array('blowfish','sha512','sha256','sha1','ripemd256','ripemd320','whirlpool');
}

function cobalt_password_set_method()
{
    $preferred_method = strtolower(AUTH_PREFERRED_METHOD);
    $methods_available = hash_algos(); //methods available to the PHP install
    if(in_array($preferred_method, $methods_available) && in_array($preferred_method, cobalt_password_methods()))
    {
        //We had to check to be sure preferred method is available and not a misconfig/error by admin
        $method = $preferred_method; 
    }
    elseif (CRYPT_BLOWFISH == 1 AND PHP_VERSION_ID >= 50307)
    {
        //Use blowfish only on 5.3.7 and beyond, which contains the $2y$ salt prefix security fix
        $method = "blowfish";
    }
    elseif(in_array('sha512', $methods_available))
    {
        $method = 'sha512';
    }
    elseif(in_array('sha256', $methods_available)) 
    {
        $method = 'sha256';
    }
    elseif(in_array('whirlpool', $methods_available)) 
    {
        $method = 'whirlpool';
    }
    elseif(in_array('ripemd320', $methods_available)) 
    {
        $method = 'ripemd320';
    }
    elseif(in_array('ripemd256', $methods_available)) 
    {
        $method = 'ripemd256';
    }
    else
    {
        $method = 'sha1'; 
    }

    return $method;
}
