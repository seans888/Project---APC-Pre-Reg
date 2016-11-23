<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Field_ID']))
{
    $Field_ID = rawurldecode($_GET['Field_ID']);

    $d = connect_DB();
    $stmt = $d->prepare('SELECT a.Table_Name, b.* FROM "table" a, table_fields b WHERE a.Table_ID = b.Table_ID AND b.Field_ID = :f_id');
    $stmt->bindValue(':f_id', $Field_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
        $result->finalize();
    }

    $stmt = $d->prepare('SELECT b.List_Name FROM table_fields_list a, table_fields_predefined_list b WHERE a.Field_ID=:f_id AND a.List_ID = b.List_ID');
    $stmt->bindValue(':f_id', $Field_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        if($data!="") extract($data);
        else $List_Name="NONE";
        $result->finalize();
    }

    $stmt_select = $d->prepare('SELECT b.Field_Name, a.Display FROM table_fields_list_source_select a, table_fields b
                                WHERE a.Field_ID=:f_id AND a.Select_Field_ID = b.Field_ID');
    $stmt_select->bindValue(':f_id', $Field_ID);


    $stmt_where = $d->prepare('SELECT b.Field_Name, a.Where_Field_Operand, a.Where_Field_Value, a.Where_Field_Connector
                                FROM table_fields_list_source_where a, table_fields b WHERE a.Field_ID=:f_id AND a.Where_Field_ID = b.Field_ID');
    $stmt_where->bindValue(':f_id', $Field_ID);
}
elseif(xsrf_guard())
{
    init_var($_POST['btnCancel']);

    if($_POST['btnCancel'])
    {
        header('location: ListView_TableFields.php');
        exit();
    }
}

drawHeader();
drawPageTitle('Detail View: Table Field',$errMsg);
?>
<div class="container_mid">
<fieldset class="top">
View Table Field: <?php echo $Field_Name;?>
</fieldset>

<fieldset class="middle">
    <?php
    fieldsetStart('Data Settings');
    drawTextField('Table','Table_Name',TRUE);
    drawTextField('Field Name','Field_Name',TRUE);
    drawTextField('Data Type','Data_Type',TRUE);
    drawTextField('Nullable', 'Nullable', TRUE);
    drawTextField('Length','',TRUE);
    drawTextField('Attribute','',TRUE);
    drawTextField('Auto Increment','Auto_Increment',TRUE);
    fieldsetEnd();

    fieldsetStart('HTML Settings');
    drawTextField('Show in List View Page','In_Listview', TRUE);
    drawTextField('Control Type','Control_Type',TRUE);
    drawTextField('Label','',TRUE);
    drawTextField('Size','',TRUE);
    drawTextField('Extra','',TRUE);
    drawTextField('Companion','',TRUE);
    drawTextField('Drop-Down List Has Blank','Drop_Down_Has_Blank',TRUE);
    drawTextField('Predefined List', 'List_Name', TRUE);
    fieldsetEnd();

    fieldsetStart('Validation Settings');
    drawTextField('Required','',TRUE);
    drawTextField('Char Set Method','Char_Set_Method',TRUE);
    drawTextField('Char Set Allow Space','Char_Set_Allow_Space',TRUE);
    drawTextField('Extra Chars Allowed','Extra_Chars_Allowed',TRUE);
    drawTextField('Valid Set','Valid_Set',TRUE);
    fieldsetEnd();

    fieldsetStart('Reporter Settings');
    drawTextField('In Report','RPT_In_Report',TRUE);
    drawTextField('Column Format', 'RPT_Column_Format',TRUE);
    drawTextField('Column Alignment', 'RPT_Column_Alignment',TRUE);
    drawTextField('Show Sum', 'RPT_Show_Sum',TRUE);
    fieldsetEnd();

    fieldsetStart('Defaults');
    drawTextField('Default Value','Default_Value',TRUE);
    drawTextField('Date Default','Date_Default',TRUE);
    fieldsetEnd();

    fieldsetStart('Misc Settings');
    drawTextField('Allow HTML Tags','Allow_HTML_Tags',TRUE);
    drawTextField('Trim Value','Trim_Value',TRUE);
    fieldsetEnd();

    fieldsetStart('Additional Options');
    echo '<tr><td colspan=2 align=center><hr> List SELECT Parameters: <br><table align=center><tr><td align=left><ol>';
    if($result = $stmt_select->execute())
    {
        $num_rows = 0;
        while($row = $result->fetchArray())
        {
            echo '<li>' . $row['Field_Name'] . '&nbsp; - &nbsp;' . $row['Display'];
            ++$num_rows;
        }
        if($num_rows == 0)
        {
            echo 'NONE';
        }
    }
    echo '</td></tr></table></ol><hr></td></tr>';

    echo '<tr><td colspan=2 align=center><hr> List WHERE Parameters: <br><table align=center><tr><td align=left><ol>';
    if($result = $stmt_where->execute())
    {
        $num_rows = 0;
        while($row = $result->fetchArray())
        {
            echo '<li>' . $row['Field_Name'] . '&nbsp; - &nbsp;'
                        . $row['Where_Field_Operand']  . '&nbsp; - &nbsp;'
                        . $row['Where_Field_Value'] . '&nbsp; - &nbsp;'
                        . $row['Where_Field_Connector'];
        }
        if($num_rows == 0)
        {
            echo 'NONE';
        }
    }
    echo '</td></tr></table></ol><hr></td></tr>';
    fieldsetEnd();
    fieldsetEnd();
    ?>
</fieldset>
<fieldset class="bottom">
<?php
drawBackButton();
?>
</fieldset>
</div>
<?php
drawFooter();
