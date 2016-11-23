<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['First_Run']))
{
    $d = connect_DB();
    $stmt = $d->prepare("SELECT Project_Name, Client_Name, Project_Description, Base_Directory, Database_Connection_ID
                            FROM project WHERE Project_ID=:p_id");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
    }
}
if(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header("location: " . HOME_PAGE);
        exit();
    }

    if($_POST['btnSubmit'])
    {
        extract($_POST);
        init_var($Database_Connection_ID);
        $errMsg = scriptCheckIfNull('Project Name', $Project_Name,
                                    'Client Name', $Client_Name,
                                    'Description', $Project_Description,
                                    'Base Directory', $Base_Directory,
                                    'Database Connection', $Database_Connection_ID);

        if($errMsg=="")
        {
            $d = connect_DB();
            $stmt = $d->prepare("SELECT Project_ID FROM project WHERE Project_Name=:p_name AND Project_ID !=:p_id");
            $stmt->bindValue(':p_name', $Project_Name);
            $stmt->bindValue(':p_id', $Orig_Project_ID);
            $error = "The project name '$Project_Name' already exists. Please choose a new one. <br>";
            $errMsg = scriptCheckIfUnique($stmt, $error);

            if($errMsg=="")
            {
                queryUpdateProject($_POST);
                header("location: ../success.php?success_tag=EditProject");
                exit();
            }
        }
    }
}

drawHeader();
drawPageTitle('Edit Project',$errMsg);
?>
<input type="hidden" name="Orig_Project_ID" value="<?php echo $_SESSION['Project_ID'];?>">
<div class="container_mid_huge">
<fieldset class="top">
Modify Project Data
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawTextField('Project Name', 'Project_Name');
drawTextField('Client Name', 'Client_Name');
drawTextField('Base Directory', 'Base_Directory');
drawSelectField('drawDBConnection', 'Default DB Connection', 'Database_Connection_ID');
drawTextField('Description','Project_Description','','Textarea');
?>
</table>
</fieldset>
<fieldset class="bottom">
<?php
drawSubmitCancel();
?>
</fieldset>
</div>
<?php
drawFooter(); ?>
