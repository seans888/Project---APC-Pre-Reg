<?php
require_once 'path.php';
init_cobalt('ALLOW_ALL');

if(xsrf_guard())
{
    init_var($_POST['btn_cancel']);
    init_var($_POST['btn_submit']);

    if($_POST['btn_cancel'])
    {
        redirect("main.php");
    }

    if($_POST['btn_submit'])
    {
        $old_password = $_POST['old_password'];
        $password1    = $_POST['password1'];
        $password2    = $_POST['password2'];

        require 'core/validation_class.php';
        $validator = new validation;
        $message = $validator->check_if_null('Old Password', $old_password, 'New Password', $password1, 'Confirm Password', $password2);

        if(strlen($old_password) > MAX_PASSWORD_LENGTH ||
           strlen($password1) > MAX_PASSWORD_LENGTH ||
           strlen($password2) > MAX_PASSWORD_LENGTH)
        {
            $message = 'Password must not be more than ' . MAX_PASSWORD_LENGTH . ' chars.<br>';
            $old_password = '';
            $password1    = '';
            $password2    = '';
        }
        elseif($password1 != $password2) $message.="New passwords do not match. <br>";

        if($message=='')
        {
            $data_con = new data_abstraction;
            $data_con->set_fields('password');
            $data_con->set_table('user');
            $data_con->set_where("username='" . quote_smart($_SESSION['user']) . "'");
            $result = $data_con->make_query()->result;
            $data_con->close_db();
            $data = $result->fetch_assoc();
            $result->close();

            require 'core/password_crypto.php';
            //Hash old password using default Cobalt password hashing technique
            $hashed_old_password = cobalt_password_hash('RECREATE', $old_password, $_SESSION['user']);

            if($hashed_old_password != $data['password']) $message.="The password you entered in 'Old Password' does not match the password in your records. <BR>";
        }
        
        if($message=='')
        {
            //Hash the password using default Cobalt password hashing technique
            $hashed_password = cobalt_password_hash('NEW',$password1, $_SESSION['user'], $new_salt, $new_iteration, $new_method);

            $data_con = new data_abstraction;
            $data_con->set_query_type('UPDATE');
            $data_con->set_table('user');
            $data_con->set_update("`password`='$hashed_password', `salt`='$new_salt', `iteration`='$new_iteration', `method`='$new_method'");
            $data_con->set_where("username='" . quote_smart($_SESSION['user']) . "'");
            $data_con->make_query();
            $message = 'Your password has been successfully updated! You can <a href="main.php"> click here </a> to go back to your control center or use the menu above.';
            $message_type='SYSTEM';

            $old_password = '';
            $password1   = '';
            $password2   = '';
        }
    }
}

$html = new html;
$html->draw_header('Change Password',$message,$message_type);

echo '<div class="container">
    <fieldset class="container_invisible">
    <fieldset class="top"> Password Management
    </fieldset>
    <fieldset class="middle">
    <table class="input_form">';
$html->draw_text_field('Old Password','old_password',FALSE,'password',TRUE,'maxlength="' . MAX_PASSWORD_LENGTH . '"');
$html->draw_text_field('New Password','password1',FALSE,'password',TRUE,'maxlength="' . MAX_PASSWORD_LENGTH . '"');
$html->draw_text_field('Confirm New Password','password2',FALSE,'password',TRUE,'maxlength="' . MAX_PASSWORD_LENGTH . '"');

echo '</table>
    </fieldset>
    <fieldset class="bottom">';

$html->draw_submit_cancel();
echo '</fieldset>';
echo '</fieldset>';
echo '</div>';

$html->draw_footer();
