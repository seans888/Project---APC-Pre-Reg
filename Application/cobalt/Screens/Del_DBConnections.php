<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['DB_Connection_ID']))
{
    $DB_Connection_ID = rawurldecode($_GET['DB_Connection_ID']);
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT `DB_Connection_Name`, `Hostname`, `Username`, `Password`, `Database` 
                            FROM `database_connection` 
                            WHERE `DB_Connection_ID`='$DB_Connection_ID'");
    if($result = $mysqli->use_result())
    {
        $data = $result->fetch_assoc();
        extract($data);
    }
    else die($mysqli->error);
    $mysqli->close();
    $result->close();
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT `Database_Connection_ID` 
                            FROM `project` 
                            WHERE Project_ID='$_SESSION[Project_ID]'");
    if($result = $mysqli->use_result())
    {
        $info = $result->fetch_row();
        if($info[0] == $DB_Connection_ID) $Default_Connection = 'Yes';
        else $Default_Connection = 'No';
    }
    else die($mysqli->error);
    $mysqli->close();
    $result->close();
}
elseif(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header("location: ListView_DBConnections.php");
        exit();
    }
    elseif($_POST['btnSubmit'])
    {
        queryDeleteDBConnection($_POST);
        header("location: ../success.php?success_tag=DeleteDBConnections");
        exit();
    }
}

drawHeader();
drawPageTitle('Delete Database Connection','Are you sure you want to delete this Database Connection?');
?>
<input type="hidden" name="DB_Connection_ID" value="<?php echo $DB_Connection_ID;?>">
<div class="container_mid">
<fieldset class="top">
Delete Database Connection
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawTextField('DB Connection Name', 'DB_Connection_Name',TRUE);
drawTextField('Hostname','',TRUE);
drawTextField('Database','',TRUE);
drawTextField('Username','',TRUE);
drawTextField('Password','',TRUE);
drawTextField('Use as Default','Default_Connection',TRUE);
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
