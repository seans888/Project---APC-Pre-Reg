<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Username']))
{
    $Username = rawurldecode($_GET['Username']);
    $Orig_Username = $Username;
    unset($_GET);
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT `Username`, `Password`  
                            FROM `user` 
                            WHERE `Username`='$Username'");
    if($result = $mysqli->use_result())
    {
        $data = $result->fetch_assoc();
        extract($data);
        $Password_2 = $Password;
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
    
    if($_POST['btnSubmit'])
    {
        extract($_POST);
        $errMsg = scriptCheckIfNull('Username', $Username,
                                    'Password', $Password);

        if($errMsg=="")
        {
            $select = "SELECT `Username` FROM `user` WHERE `Username`='$Username' AND `Username`!='$Orig_Username'"; 
            $error = "The user you entered already exists. Please choose a new username if you wish to continue. <br>";
            $errMsg = scriptCheckIfUnique($select, $error);

            if($errMsg=="")
            {
                if($Password == $Password_2)
                {
                    queryUpdateUser($_POST);
                    header("location: /SCV2/success.php?success_tag=EditUsers");
                    exit();
                }
                else $errMsg = "Your passwords didn't match, please retype them.";
            }
        }
    }
}

drawHeader($errMsg);
drawPageTitle('Edit Users');
?>
<input type="hidden" name="Orig_Username" value="<?php echo $Orig_Username;?>">
drawFieldSetStart();
drawTextField('Username', 'Username');
drawTextField('Password','Password',FALSE,'password');
drawTextField('Confirm password','Password_2',FALSE,'password');
drawSubmitCancel();
drawFieldSetEnd();
drawFooter(); ?>
