<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

	if($_POST['btnCancel']) 
	{
	    header("location: ListView_Users.php");
	    exit();
    }

	if($_POST['btnSubmit'])
	{
		extract($_POST);
		$errMsg = scriptCheckIfNull('Username', $Username,
									'Password', $Password);

		if($errMsg=="")
		{
		    if($Password == $Password_2)
		    {
    			queryCreateUser($_POST);
    			header("location: /SCV2/success.php?success_tag=CreateUsers");
    		}
    		else $errMsg = "Your passwords didn't match, please retype them.";
		}
	}
}

drawHeader($errMsg);
drawPageTitle('Create Users');
drawFieldSetStart();
drawTextField('Username', 'Username');
drawTextField('Password','Password',FALSE,'password');
drawTextField('Confirm password','Password_2',FALSE,'password');
drawSubmitCancel();
drawFieldSetEnd();
drawFooter();
?>
