<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['DB_Connection_ID']))
{
    $DB_Connection_ID = rawurldecode($_GET['DB_Connection_ID']);

    $d = connect_DB();
    $stmt = $d->prepare("SELECT DB_Connection_Name, Hostname, Username, Password, Database
                            FROM database_connection
                            WHERE DB_Connection_ID=:db_id");
    $stmt->bindValue(':db_id', $DB_Connection_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
    }

    $d = connect_DB();
    $stmt = $d->prepare("SELECT `Database_Connection_ID`
                            FROM `project`
                            WHERE Project_ID=:p_id");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    if($result = $stmt->execute())
    {
        $info = $result->fetchArray();
        if($info[0] == $DB_Connection_ID) $Default_Connection = 'Yes';
        else $Default_Connection = 'No';
    }
}

if(xsrf_guard())
{
    init_var($_POST['btnCancel']);

    if($_POST['btnCancel'])
    {
        header("location: ListView_DBConnections.php");
        exit();
    }
}

drawHeader();
drawPageTitle('Detail View: Database Connection',$errMsg);
?>

<div class="container_mid">
<fieldset class="top">
View DB Connection: <?php echo $DB_Connection_Name;?>
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
drawBackButton();
?>
</fieldset>
</div>
<?php
drawFooter();
