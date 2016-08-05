<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Username']))
{
    $Username = rawurldecode($_GET['Username']);
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT `Username`,`Password` 
                            FROM `user` 
                            WHERE `Username`='$Username'");
    if($result = $mysqli->use_result())
    {
        $data = $result->fetch_assoc();
        extract($data);
    }
    else die($mysqli->error);
}
elseif(xsrf_guard())
{
    init_var($_POST['btnCancel']);

    if($_POST['btnCancel'])
    {
        header('location: ListView_Users.php');
        exit();
    }
}

drawHeader($errMsg);
drawPageTitle('Detail View: Users');
drawFieldSetStart();
drawTextField('Username', 'Username',TRUE);
drawTextField('Password', 'Password',TRUE);
drawBackButton(); 
drawFieldSetEnd();
drawFooter(); ?>
