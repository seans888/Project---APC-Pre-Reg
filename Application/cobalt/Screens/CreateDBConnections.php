<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header("location: ListView_DBConnections.php");
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
            if($Confirm_Password != $Password) $errMsg = "Passwords do not match. Please re-enter the password.";
        }

        if($errMsg=="")
        {
            //Add additional info needed before passing $_POST
            $_POST['Project_ID'] = $_SESSION['Project_ID'];
            $DB_ID = rawurlencode(queryCreateDBConnection($_POST));
            header("location: ../success.php?success_tag=CreateDBConnections&DB_ID=$DB_ID");
            exit();
        }
    }
}

drawHeader();
if($errMsg=='')
{
    $errMsg = 'COMMON SENSE WARNING:<br>
               Please do not put the credentials of your real production server(s) here. <br>
                Use only your test server(s) credentials.';
}
drawPageTitle('Create Database Connection',$errMsg);


//********************************************************************************************
//Populate connection info with default information that is probably correct for 99% of users:
// -Connection label should be 'con1' if no connection has been made yet
// -Hostname should be 'localhost'
// -Username should be 'root'
// -Use as Default should be 'Yes' if there are no default connections made yet.
//********************************************************************************************

//Check if there is already an existing connection
$d = connect_DB();
$stmt = $d->prepare("SELECT DB_Connection_ID, DB_Connection_Name, Hostname, Username FROM database_connection WHERE Project_ID=:p_id");
$stmt->bindValue(':p_id', $_SESSION['Project_ID']);

$num_rows = 0;
if($result = $stmt->execute())
{
    while($row = $result->fetchArray())
    {
        $Hostname = $row['Hostname'];
        $Username = $row['Username'];
        ++$num_rows;
    }
}

if($num_rows == 0)
{
    $DB_Connection_Name = 'con1';
    $Hostname = 'localhost';
    $Username = 'root';
    $Default_Connection = 'Yes';
}
else
{
    //Check if there is already a default connection chosen.
    $stmt = $d->prepare("SELECT Database_Connection_ID FROM project WHERE Project_ID=:p_id");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    if($result = $stmt->execute())
    {
        while($row = $result->fetchArray())
        {
            extract($row);
        }
    }

    if($Database_Connection_ID == '')
    {
        //No default connection chosen yet.
        //Use as Default should be 'Yes' for this new connection being created.
        $Default_Connection = 'Yes';
    }
    else
    {
        $Default_Connection = 'No';
    }
}

?>

<div class="container_mid">
<fieldset class="top">
New Database Connection
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawTextField('DB Connection Name', 'DB_Connection_Name');
drawTextField('Hostname');
drawTextField('Database');
drawTextField('Username');
drawTextField('Password','','','password');
drawTextField('Confirm Password', 'Confirm_Password','','password');

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
