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
$Project_ID = $mysqli->real_escape_string($_SESSION['Project_ID']);
$mysqli->real_query("SELECT List_ID, List_Name, Remarks FROM table_fields_predefined_list WHERE Project_ID='$Project_ID' ORDER BY List_Name");

drawHeader();
drawPageTitle('List View: Predefined Lists',$errMsg);
?>
<fieldset class="container">
<?php drawButton('CANCEL');?><a class='blue' href='CreatePredefinedLists.php'> Create New List </a>
<table border=1 width=100% class="listView">
<tr class="listRowHead">
    <td width="140">Operations</td>
    <td>List Name</td>
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

            $List_ID = rawurlencode($List_ID);
            echo "<tr class='$class'><td align=center><a href='DetailView_PredefinedLists.php?List_ID=$List_ID'><img src='../images/view.png' alt='View' title='View'></a>"
                ."&nbsp;&nbsp;<a href='Edit_PredefinedLists.php?List_ID=$List_ID'><img src='../images/edit.png' alt='Edit' title='Edit'></a>"
                ."&nbsp;&nbsp;<a href='Del_PredefinedLists.php?List_ID=$List_ID'><img src='../images/delete.png' alt='Delete' title='Delete'></a></td>";

            printf("<td>%s</td><td>%s</td></tr>\n", $row['List_Name'], $row['Remarks']);
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
