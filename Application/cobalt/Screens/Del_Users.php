<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Username']))
{
    $Username = rawurldecode($_GET['Username']);
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT `Username`
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
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header('location: ListView_Users.php');
        exit();
    }
    elseif($_POST['btnSubmit'])
    {
        queryDeleteUser($_POST);
        header("location: /SCV2/success.php?success_tag=DeleteUsers");
        exit();
    }
}

drawHeader($errMsg);
drawPageTitle('Detail View: User');
?>
<input type="hidden" name="Username" value="<?php echo $Username;?>">
<?php 
drawFieldSetStart();
drawTextField('Username', 'Username',TRUE);
drawDeleteCancel();
drawFieldSetEnd();
drawFooter();
