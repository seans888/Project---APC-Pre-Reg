<?php
require 'path.php';
init_cobalt('ALLOW_ALL',FALSE);

//Create a log entry that user logged out.
log_action('Logged out', $_SERVER['PHP_SELF']);

/********** Start of session cleanup. **********/
//First, unset all session variables.

$_SESSION = array();

//Second, delete the session cookie.
if(isset($_COOKIE[session_name()]))
{
    setcookie (session_name(), "", time() - 86400);
}

//Third and last step, destroy the session.
session_destroy();
/********** End of session cleanup. **********/

redirect('index.php');
?>
