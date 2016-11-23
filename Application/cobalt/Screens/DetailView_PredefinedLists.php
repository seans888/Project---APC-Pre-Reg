<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['List_ID']))
{
    $List_ID = rawurldecode($_GET['List_ID']);

    $d = connect_DB();
    $stmt = $d->prepare("SELECT List_Name, Remarks FROM table_fields_predefined_list WHERE List_ID=:l_id");
    $stmt->bindValue(':l_id', $List_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
    }

    $stmt = $d->prepare("SELECT List_Item FROM table_fields_predefined_list_items WHERE List_ID=:l_id ORDER BY Number");
    $stmt->bindValue(':l_id', $List_ID);
}
elseif(xsrf_guard())
{
    init_var($_POST['btnCancel']);

    if($_POST['btnCancel'])
    {
        header('location: ListView_PredefinedLists.php');
        exit();
    }
}

drawHeader();
drawPageTitle('Detail View: Predefined Lists',$errMsg);
?>
<div class="container_mid">
<fieldset class="top">
View List: <?php echo $List_Name;?>
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawTextField('List Name', 'List_Name',TRUE);
drawTextField('Remarks','',TRUE);
echo '<tr><td align=right> <br>List items: </td><td></td></tr>
      <tr><td></td><td><ol>';
if($result = $stmt->execute()) while($row = $result->fetchArray()) echo '<li>' . $row['List_Item'];
echo '</ol></td></tr>';
?>
</table>
</fieldset>
<fieldset class="bottom">
<?php
drawBackButton();
?>
</fieldset>
</div>
<?php
drawFooter();
?>
