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
$stmt = $d->prepare("SELECT Relation_ID, Relation, Label FROM table_relations WHERE Project_ID=:p_id ORDER BY Relation, Label");
$stmt->bindValue(':p_id', $_SESSION['Project_ID']);

drawHeader();
drawPageTitle('List View: Table Relationships',$errMsg);
?>
<fieldset class="container">
<?php drawButton('CANCEL');?>&nbsp;<a class='blue' href='DefineTableRelations.php'>Define New Relationship</a>
<table border="1" width="100%" class="listView">
<tr class="listRowHead">
    <td width="140">Operations</td>
    <td>Relation</td>
    <td>Tables</td>
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

            $Relation_ID = rawurlencode($Relation_ID);
            echo "<tr class='$class'><td align=center><a href='DetailView_TableRelations.php?Relation_ID=$Relation_ID'><img src='../images/view.png' alt='View' title='View'></a>"
                ."&nbsp;&nbsp;<a href='Edit_TableRelations.php?Relation_ID=$Relation_ID'><img src='../images/edit.png' alt='Edit' title='Edit'></a>"
                ."&nbsp;&nbsp;<a href='Del_TableRelations.php?Relation_ID=$Relation_ID'><img src='../images/delete.png' alt='Delete' title='Delete'></a></td>";

            printf("<td>%s</td><td>%s</td></tr>\n", $row['Relation'], $row['Label']);
            ++$a;
        }
    }
?>
</table>
<?php drawButton('CANCEL');?>
</fieldset>
<?php drawFooter(); ?>
