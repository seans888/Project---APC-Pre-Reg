<?php
if(isset($enable_red_alert) && $enable_red_alert==TRUE)
{
    $username = $_SESSION['user'];
    $ip_address = get_ip();


    $message = 'You tried to access a module without sufficient privileges.<br>'
              .'Cobalt Security has detected and blocked this illegal access attempt.<br><br>'
              .'The following details have been logged and sent to the system administrator for review: '
              .'<br>*Date & time of illegal access attempt: ' . date('Y-m-d, h:ia')
              .'<br>*Username: ' . $username
              .'<br>*IP Address: ' . $ip_address
              .'<br>*Module: ' . basename($_SERVER['PHP_SELF'])
              .'<br><br>If you have seen this alert by mistake, or you believe you should have access, please ask the system administrator to review your permissions and relevant module settings.';
    $message_type='error';

    if(isset($_COOKIE[session_name()]))
    {
        setcookie (session_name(), "", time() - 86400);
    }

    $html = new html;
    $html->draw_header('Possible Hack Attempt Detected and Blocked', $message, $message_type);
    $html->draw_footer();

    $_SESSION = array();
    session_destroy();
    die();
}
