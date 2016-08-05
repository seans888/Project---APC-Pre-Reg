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

drawHeader($errMsg);
drawPageTitle('List View: Tables');
?>

<?php drawButton('CANCEL');?>
<table border=1 width=100% cellspacing=1>
<tr class=tableHeader>
    <td>Operations</td>
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
            echo "<tr class='$class'><td align=center><a href='DetailView_Tables.php?Table_ID=$Table_ID'><img src='/SCV2/images/View.jpg' alt='View' title='View'></a>"
                ."&nbsp;&nbsp;<a href='Edit_Tables.php?Table_ID=$Table_ID'><img src='/SCV2/images/Edit.jpg' alt='Edit' title='Edit'></a>"
                ."&nbsp;&nbsp;<a href='Del_Tables.php?Table_ID=$Table_ID'><img src='/SCV2/images/Delete.jpg' alt='Delete' title='Delete'></a></td>";

            printf("<td>%s</td><td>%s</td></tr>\n", $row['Table_Name'], $row['Remarks']);
            $a++;
        }
        $result->close();
    }
    else die($mysqli->error);
?>
</table>
<?php drawButton('CANCEL');?>
<?php drawFooter(); ?>
