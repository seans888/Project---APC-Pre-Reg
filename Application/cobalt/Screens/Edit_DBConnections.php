<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['DB_Connection_ID']))
{
    $DB_Connection_ID = rawurldecode($_GET['DB_Connection_ID']);
    $Orig_DB_Connection_ID = $DB_Connection_ID;
    unset($_GET);

    $d = connect_DB();
    $stmt = $d->prepare("SELECT DB_Connection_Name, Hostname, Username, Password, Database
                            FROM database_connection
                            WHERE DB_Connection_ID=:db_id");
    $stmt->bindValue(':db_id', $DB_Connection_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
        $Orig_DB_Connection_Name = $DB_Connection_Name;
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
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header('location: ListView_DBConnections.php');
        exit();
    }

    if($_POST['btnSubmit'])
    {
        extract($_POST);
        $errMsg = scriptCheckIfNull('DB Connection Name', $DB_Connection_Name,
                                    'Hostname', $Hostname,
                                    'Database', $Database,
                                    'Username', $Username);

        if($errMsg=="")
        {
            $d = connect_DB();
            $stmt = $d->prepare("SELECT DB_Connection_ID FROM database_connection WHERE DB_Connection_Name=:db_name AND DB_Connection_ID!=:db_id AND DB_Connection_Name!=:db_orig_name");
            $stmt->bindValue(':db_name', $DB_Connection_Name);
            $stmt->bindValue(':db_id', $Orig_DB_Connection_ID);
            $stmt->bindValue(':db_orig_name', $Orig_DB_Connection_Name);
            $error = "The database connection name '$DB_Connection_Name' already exists. Please choose a new one. <br>";
            $errMsg = scriptCheckIfUnique($stmt, $error);

            if($errMsg=="")
            {
                queryUpdateDBConnection($_POST);
                header("location: ../success.php?success_tag=EditDBConnections");
                exit();
            }
        }
    }
}

drawHeader();
drawPageTitle('Edit Database Connection', $errMsg);
?>
<input type="hidden" name="Orig_DB_Connection_ID" value="<?php echo $Orig_DB_Connection_ID;?>">
<input type="hidden" name="Orig_DB_Connection_Name" value="<?php echo $Orig_DB_Connection_Name;?>">

<div class="container_mid">
<fieldset class="top">
Modify Database Connection
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawTextField('DB Connection Name', 'DB_Connection_Name');
drawTextField('Hostname');
drawTextField('Database');
drawTextField('Username');
drawTextField('Password');

$arrayItems = array(
                    'Items' => array('Yes','No'),
                    'Values'=> array('Yes','No'),
                    'PerLine' => FALSE
                   );
drawRadioField($arrayItems,'Use as Default?','Default_Connection');
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
drawFooter();
