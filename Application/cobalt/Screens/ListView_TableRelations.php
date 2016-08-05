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
$mysqli->real_query("SELECT Relation_ID, Relation, Label FROM `table_relations` WHERE `Project_ID`='$_SESSION[Project_ID]' ORDER BY `Relation`, `Label`");

drawHeader();
drawPageTitle('List View: Table Relationships',$errMsg);
?>
<fieldset class="container">
<?php drawButton('CANCEL');?><a class='blue' href='DefineTableRelations.php'> Define New Relationship </a>
<table border="1" width="100%" class="listView">
<tr class="listRowHead">
    <td width="140">Operations</td>
    <td>Relation</td>
    <td>Tables</td>
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

            $Relation_ID = rawurlencode($Relation_ID);
            echo "<tr class='$class'><td align=center><a href='DetailView_TableRelations.php?Relation_ID=$Relation_ID'><img src='../images/view.png' alt='View' title='View'></a>"
                ."&nbsp;&nbsp;<a href='Edit_TableRelations.php?Relation_ID=$Relation_ID'><img src='../images/edit.png' alt='Edit' title='Edit'></a>"
                ."&nbsp;&nbsp;<a href='Del_TableRelations.php?Relation_ID=$Relation_ID'><img src='../images/delete.png' alt='Delete' title='Delete'></a></td>";

            printf("<td>%s</td><td>%s</td></tr>\n", $row['Relation'], $row['Label']);
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
