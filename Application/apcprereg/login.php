<?php
require_once 'path.php';
init_cobalt();

if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'Logged')
{
    redirect('start.php');
}

if(isset($_GET['reason']))
{
    if($_GET['reason'] == 'ipchange')
    {
        $error_message = 'You have been logged out because your IP address has changed. Please log in again.';
    }
}

if(xsrf_guard())
{
    init_var($_POST['btnSubmit']);

    if($_POST['btnSubmit'])
    {
        require 'password_crypto.php';

        $error_message = '';
        extract($_POST);

        //Deal with passwords longer than MAX_PASSWORD_LENGTH (possible DoS vulnerability)
        if(strlen($password) > MAX_PASSWORD_LENGTH)
        {
            //Reset password to an arbitrarily small string, thwarting any DoS attempt
            $password = 'x';
        }

        $data_con = new data_abstraction;
        $mysqli = $data_con->connect_db()->mysqli;
        $clean_username = $mysqli->real_escape_string($username);
        $clean_password = cobalt_password_hash('RECREATE', $password, $username);
        //FIXME: remember to update this ancient code to use prepared statement
        $mysqli->real_query("SELECT `username`, `skin_id`, `first_name`, `middle_name`, `last_name` FROM `user`, `person` WHERE `username`='$clean_username' AND `password`='$clean_password' AND `user`.`person_id` = `person`.`person_id`");
        if($result = $mysqli->use_result())
        {
            if($data = $result->fetch_assoc())
            {
                $result->close();
                extract($data);

                $_SESSION['logged']      = 'Logged';
                $_SESSION['user']        = $username;
                $_SESSION['first_name']  = $first_name;
                $_SESSION['middle_name'] = $middle_name;
                $_SESSION['last_name']   = $last_name;
                $_SESSION['ip_address']  = get_ip();

                $data_con = new data_abstraction;
                $data_con->set_fields('skin_name, header, footer, master_css, colors_css, fonts_css, override_css, icon_set');
                $data_con->set_table('system_skins');
                $data_con->set_where("skin_id=?");
                $bind_params = array('i', $skin_id);
                $data_con->stmt_prepare($bind_params);
                $data_con->stmt_fetch('single');
                if($data_con->num_rows==1)
                {
                    extract($data_con->dump);
                    $_SESSION['header']       = $header;
                    $_SESSION['footer']       = $footer;
                    $_SESSION['skin']         = $skin_name;
                    $_SESSION['master_css']   = $master_css;
                    $_SESSION['colors_css']   = $colors_css;
                    $_SESSION['fonts_css']    = $fonts_css;
                    $_SESSION['override_css'] = $override_css;
                    $_SESSION['icon_set']     = $icon_set;
                    if(trim($_SESSION['icon_set'] == ''))
                    {
                        $_SESSION['icon_set'] = 'cobalt';
                    }
                }
                $data_con->close_db();

                log_action('Logged in');

                //check if user must rehash his password due to updated method or work factor/iterations
                if(cobalt_password_must_rehash($username))
                {
                    $hashed_password = cobalt_password_hash('NEW',$password, $username, $new_salt, $new_iteration, $new_method);
                    $data_con = new data_abstraction;
                    $data_con->set_query_type('UPDATE');
                    $data_con->set_table('user');
                    $data_con->set_update("`password`=?, `salt`=?, `iteration`=?, `method`=?");
                    $data_con->set_where("username=?");
                    $bind_params = array('ssiss', $hashed_password, $new_salt, $new_iteration, $new_method, $username);
                    $data_con->stmt_prepare($bind_params);
                    $data_con->stmt_execute();
                }

                redirect('start.php');
            }
            else $error_message = "Check username and password.";
        }
        else die($mysqli->error);
        $data_con->close_db();
    }
}

$html = new html;
?>
<!DOCTYPE html>
<html>
<head>
    <script>
    if (top.location != location)
    {
        top.location.href = document.location.href ;
    }
    </script>
    <title> <?php echo GLOBAL_PROJECT_NAME;?> - Powered by Cobalt</title>
    <link href="css/login.css" rel="stylesheet" type="text/css">
    <meta http-equiv="content-type" content="text/html; charset=<?php echo MULTI_BYTE_ENCODING; ?>" />
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="document.getElementById('username').focus();">
<?php
echo '<form method="POST" action="' . basename($_SERVER['SCRIPT_NAME']) . '">';
$form_key = generate_token();
$form_identifier = $_SERVER['SCRIPT_NAME'];
$_SESSION['cobalt_form_keys'][$form_identifier] = $form_key;
echo '<input type="hidden" name="form_key" value="' . $form_key .'">';
?>
<div class="left_container">

    <div class="title">
        <?php echo GLOBAL_PROJECT_NAME;?>
    </div>

    <div class="flavor_text">
        <?php
        $enable_flavor_text = TRUE;
        require 'login_flavor_text.php';
        ?>
    </div>

</div>
<div class="right_container">
    <fieldset class="right_panel">
        <table border="0" width="100%" cellspacing="1">
        <tr>
            <td align="center">
                <img src="images/login_badge.png">
            </td>
        </tr>
        <tr>
            <td align="center">
            <?php $html->draw_text_field('','username',FALSE,'text',FALSE, 'id="username" size="37" autocomplete="off" placeholder="Username"'); ?>
            </td>
        </tr>
        <tr>
            <td align="center">
                <?php $html->draw_text_field('','password',FALSE,'password',FALSE,'maxlength="' . MAX_PASSWORD_LENGTH . '" size="37" autocomplete="off" placeholder="Password"'); ?>
            </td>
        </tr>
        <tr>
            <td align="center">
                <input type=submit value="LOG IN" name="btnSubmit">
                <?php
                init_var($error_message);
                $_SESSION['icon_set'] = 'cobalt';
                $html->display_error($error_message);
                ?>
            </td>
        </tr>
        </table>
    </fieldset>
</div>
</form>
</body>
</html>
