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
$stmt = $d->prepare('SELECT a.Table_Name, b.Field_Name, b.Field_ID, b.Data_Type, b.Nullable, b.Control_Type, b.Label FROM "table" a, table_fields b
                        WHERE a.Project_ID=:p_id AND a.Table_ID = b.Table_ID ORDER BY a.Table_Name, b.Field_Name');
$stmt->bindValue(':p_id', $_SESSION['Project_ID']);

drawHeader();
drawPageTitle('List View: Table Fields',$errMsg);
?>

<fieldset class="container">
<?php drawButton('CANCEL');?>&nbsp;<a class='blue' href='DefineTableFields.php'>Define New Field</a>
<table border=1 width=100% class="listView">
<tr class="listRowHead">
    <td>Operations</td>
    <td>Table</td>
    <td>Field</td>
    <td>Label</td>
    <td>Data Type</td>
    <td>Nullable</td>
    <td>Control Type</td>
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

            $Field_ID = rawurlencode($Field_ID);
            echo "<tr class='$class'><td align=center><a href='DetailView_TableFields.php?Field_ID=$Field_ID'><img src='../images/view.png' alt='View' title='View'></a>"
                ."&nbsp;&nbsp;<a href='Edit_TableFields.php?Field_ID=$Field_ID'><img src='../images/edit.png' alt='Edit' title='Edit'></a>"
                ."&nbsp;&nbsp;<a href='Del_TableFields.php?Field_ID=$Field_ID'><img src='../images/delete.png' alt='Delete' title='Delete'></a></td>";

            printf("<td> %s</td><td> %s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n", $row['Table_Name'], $row['Field_Name'], $row['Label'], $row['Data_Type'], $row['Nullable'], $row['Control_Type']);
            $a++;
        }
        if($a%2 == 0) $class='listRowEven';
        else $class='listRowOdd';
        echo '<tr><td colspan="7" class="' . $class . '">' . $a . ' records in total</td></tr>';
    }
?>
</table>
<?php drawButton('CANCEL');?>
</fieldset>
<?php drawFooter(); ?>
