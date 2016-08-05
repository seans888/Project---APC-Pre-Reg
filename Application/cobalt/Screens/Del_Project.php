<?php
require '../Core/SCV2_Core.php';
init_SCV2();

$mysqli = connect_DB();
$mysqli->real_query("SELECT `Project_Name`, `Client_Name`, `Project_Description`, `Base_Directory`, `Database_Connection_ID` 
                        FROM `project`  
                        WHERE `Project_ID`='$_SESSION[Project_ID]'");
if($result = $mysqli->use_result())
{
    $data = $result->fetch_assoc();
    extract($data);
}
else die($mysqli->error);

$mysqli = connect_DB();
$mysqli->real_query("SELECT `DB_Connection_Name` 
                        FROM `database_connection` 
                        WHERE `DB_Connection_ID`='$Database_Connection_ID'");
if($result = $mysqli->use_result()) 
{
    if($data = $result->fetch_assoc()) extract($data);
    $result->close();
}
else die($mysqli->error);


if(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header("location: " . HOME_PAGE);
        exit();
    }
    elseif($_POST['btnSubmit'])
    {
        //If base directory is composed of nested subdirectories, we only need the very first folder.
        $subdirectories = explode('/', $_POST['Base_Directory']);
        $base_directory = $subdirectories[0];

        if(is_dir("../Generator/Projects/" . $base_directory))
        {
            obliterate_dir("../Generator/Projects/" . $base_directory);
        }
        queryDeleteProject($_POST, $mysqli);
    }
}

drawHeader();
drawPageTitle('DESTROY PROJECT','YOU ARE ABOUT TO DESTROY AN ENTIRE PROJECT!<br>Are you sure you wish to permanently delete this project and all of its contents?');
?>
<input type=hidden name=Project_ID value="<?php echo $_SESSION['Project_ID'];?>">
<input type="hidden" name="Base_Directory" value="<?php echo $Base_Directory;?>">
<div class="container_mid_huge">
<fieldset class="top">
Delete Project Data and All Files
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php 
drawTextField('Project Name', 'Project_Name',TRUE);
drawTextField('Client Name', 'Client_Name',TRUE);
drawTextField('Base Directory', 'Base_Directory',TRUE);
drawTextField('Database Connection', 'DB_Connection_Name',TRUE);
drawTextField('Description','Project_Description',TRUE,'Textarea');
?>
</table>
</fieldset>
<fieldset class="bottom">
<?php
drawDeleteCancel();
?>
</fieldset>
</div>
<?php
drawFooter();
