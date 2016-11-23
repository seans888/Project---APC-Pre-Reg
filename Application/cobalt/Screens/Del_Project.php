<?php
require '../Core/SCV2_Core.php';
init_SCV2();

$d = connect_DB();
$stmt = $d->prepare("SELECT Project_Name, Client_Name, Project_Description, Base_Directory, Database_Connection_ID
                        FROM project WHERE Project_ID=:p_id");
$stmt->bindValue(':p_id', $_SESSION['Project_ID']);
if($result = $stmt->execute())
{
    $data = $result->fetchArray();
    extract($data);
}

$stmt = $d->prepare("SELECT DB_Connection_Name FROM database_connection WHERE DB_Connection_ID=:db_id");
$stmt->bindValue(':db_id', $Database_Connection_ID);
if($result = $stmt->execute())
{
    if($data = $result->fetchArray()) extract($data);
}
$d->close();

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
        queryDeleteProject($_POST);
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
