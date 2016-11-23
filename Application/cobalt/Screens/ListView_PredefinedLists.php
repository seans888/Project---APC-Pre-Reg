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
    $d = connect_DB();
    $stmt = $d->prepare("SELECT List_ID, List_Name, Remarks FROM table_fields_predefined_list WHERE Project_ID=:p_id ORDER BY List_Name");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    if($result = $stmt->execute())
    {
        $a=0;
        $class='';
        while($row = $result->fetchArray())
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
    }
?>
</table>
<?php drawButton('CANCEL');?>
</fieldset>
<?php drawFooter(); ?>
