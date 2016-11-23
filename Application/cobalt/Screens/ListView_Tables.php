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

$d = connect_DB();
$stmt = $d->prepare("SELECT Table_ID, Table_Name, Remarks FROM \"table\" WHERE Project_ID=:p_id ORDER BY Table_Name");
$stmt->bindValue(':p_id', $_SESSION['Project_ID']);

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
    if($result = $stmt->execute())
    {
        $a=0;
        $class='';
        while($row = $result->fetchArray())
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
        if($a%2 == 0) $class='listRowEven';
        else $class='listRowOdd';
        echo '<tr><td colspan="3" class="' . $class . '">' . $a . ' records in total</td></tr>';
    }
?>
</table>
<?php drawButton('CANCEL');?>
</fieldset>
<?php drawFooter(); ?>
