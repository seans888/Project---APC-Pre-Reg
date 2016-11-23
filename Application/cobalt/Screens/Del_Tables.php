<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Table_ID']))
{
    $Table_ID = rawurldecode($_GET['Table_ID']);

    $d = connect_DB();
    $stmt = $d->prepare("SELECT a.Table_Name, a.Remarks, b.DB_Connection_Name FROM \"table\" a, database_connection b
                            WHERE a.Table_ID=:t_id AND a.DB_Connection_ID = b.DB_Connection_ID");
    $stmt->bindValue(':t_id', $Table_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
    }

    $stmt = $d->prepare("SELECT c.Page_Name, b.Path_Filename FROM \"table\" a, table_pages b, page c
                            WHERE a.Table_ID = b.Table_ID AND b.Page_ID = c.Page_ID AND a.Table_ID = :t_id");
    $stmt->bindValue(':t_id', $Table_ID);
}
elseif(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header('location: ListView_Tables.php');
        exit();
    }
    elseif($_POST['btnSubmit'])
    {
        queryDeleteTable($_POST);
        header("location: ../success.php?success_tag=DeleteTables");
        exit();
    }
}

drawHeader();
drawPageTitle('Delete Table','Are you sure you wish to delete this table?');
echo '<input type="hidden" name="Table_ID" value="' . $Table_ID . '">';
?>
<div class="container_mid_large">
<fieldset class="top">
Delete Table
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawTextField('Table Name', 'Table_Name',TRUE);
drawTextField('DB Connection', 'DB_Connection_Name',TRUE);
drawTextField('Remarks','',TRUE);
echo '<tr><td colspan="2"><hr>Table pages: <br>'
    .'<table class="listView" border=1><tr class="listRowHead"> <td>#</td> <td>Page</td> <td>Path & Filename</td></tr>';
if($result = $stmt->execute())
{
    $a=1;
    while($row = $result->fetchArray())
    {
        echo '<tr><td>' .$a . '</td>'
            .'<td>' . $row['Page_Name'] . '</td>'
            .'<td>' . $row['Path_Filename'] . '</td></tr>';
        $a++;
    }
}
echo '</table></ol></td></tr>';
?>
</table>
</fieldset>
<fieldset class="bottom">
<?php
drawDeleteCancel();
?>
</fieldset>
</div>
<?php
drawFooter();
?>
