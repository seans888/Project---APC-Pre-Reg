<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(xsrf_guard())
{
    if($_POST['btnCancel'])
    {
        header("location: " . HOME_PAGE);
        exit();
    }
}

$mysqli = connect_DB();
$mysqli->real_query("SELECT DB_Connection_ID, DB_Connection_Name, Hostname, Username FROM database_connection WHERE Project_ID='$_SESSION[Project_ID]'");

drawHeader();
drawPageTitle('List View: Database Connections', $errMsg);
?>
<fieldset class="container">
<?php drawButton('CANCEL');?> <a href='CreateDBConnections.php'> Create New Connection </a>
<table border="1" width="100%" cellspacing="1" class="listView">
<tr class="listRowHead">
    <td width="140">Operations</td>
    <td>DB Connection Name</td>
    <td>Hostname</td>
    <td>Username</td>
</tr>

<?php
    if($result = $mysqli->use_result())
    {
        $a=0;
        $class='';
        while($row = $result->fetch_assoc())
        {
            extract($row);
            if($a%2 == 0) $class='listRowEven';
            else $class='listRowOdd';
            
            $DB_Connection_ID = rawurlencode($DB_Connection_ID);
            echo "<tr class=$class><td align=center><a href='DetailView_DBConnections.php?DB_Connection_ID=$DB_Connection_ID'><img src='../images/view.png' alt='View' title='View'></a>"
                ."&nbsp;&nbsp;<a href='Edit_DBConnections.php?DB_Connection_ID=$DB_Connection_ID'><img src='../images/edit.png' alt='Edit' title='Edit'></a>"
                ."&nbsp;&nbsp;<a href='Del_DBConnections.php?DB_Connection_ID=$DB_Connection_ID'><img src='../images/delete.png' alt='Delete' title='Delete'></a></td>";

            printf("<td>%s</td><td>%s</td><td>%s</td></tr>\n", 
                    $row['DB_Connection_Name'], $row['Hostname'], $row['Username']);
                    
            $a++;
        }
        $result->close();
    }
    else die($mysqli->error);
?>
</table>
<?php drawButton('CANCEL');?>
</fieldset>
<?php drawFooter(); ?>
