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
$mysqli->real_query("SELECT Table_ID, Table_Name, Remarks FROM `table` WHERE `Project_ID`='$_SESSION[Project_ID]' ORDER BY `Table_Name`");

drawHeader();
drawPageTitle('List View: Tables',$errMsg);
?>
<fieldset class="container">
<?php drawButton('CANCEL');?><a class='blue' href='CreateTables.php'>Create New Table</a> :: <a class=blue href=Import_Tables.php>Import Tables</a>
<table border=1 width=100% class="listView">
<tr class="listRowHead">
    <td width="140">Operations</td>
    <td>Table Name</td>
    <td>Remarks</td>
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

            $Table_ID = rawurlencode($Table_ID);
            echo "<tr class='$class'><td align=center><a href='DetailView_Tables.php?Table_ID=$Table_ID'><img src='../images/view.png' alt='View' title='View'></a>"
                ."&nbsp;&nbsp;<a href='Edit_Tables.php?Table_ID=$Table_ID'><img src='../images/edit.png' alt='Edit' title='Edit'></a>"
                ."&nbsp;&nbsp;<a href='Del_Tables.php?Table_ID=$Table_ID'><img src='../images/delete.png' alt='Delete' title='Delete'></a></td>";

            printf("<td>%s</td><td>%s</td></tr>\n", $row['Table_Name'], $row['Remarks']);
            $a++;
        }
        $result->close();
        if($a%2 == 0) $class='listRowEven';
        else $class='listRowOdd';
        echo '<tr><td colspan="3" class="' . $class . '">' . $a . ' records in total</td></tr>';        
    }
    else die($mysqli->error);
?>
</table>
<?php drawButton('CANCEL');?>
</fieldset>
<?php drawFooter(); ?>
