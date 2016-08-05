<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Field_ID']))
{
    $Field_ID = rawurldecode($_GET['Field_ID']);
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT a.Table_Name, b.Field_Name, b.Field_ID, b.Data_Type, b.Control_Type, 
                                b.Length, b.Attribute, b.Label, b.In_Listview, b.Nullable
                            FROM `table` a, `table_fields` b 
                            WHERE a.Table_ID = b.Table_ID AND
                                  b.Field_ID = '$Field_ID' 
                            ORDER BY a.`Table_Name`, b.`Field_Name`");
                            
    if($result = $mysqli->use_result())
    {
        $data = $result->fetch_assoc();
        $result->close();
        extract($data);
    }
    else die($mysqli->error);
    $mysqli->close();

    $mysqli = connect_DB();
    $mysqli->real_query("SELECT Book_List_Generator 
                            FROM `table_fields_book_list` 
                            WHERE Field_ID='$Field_ID'");
    if($result = $mysqli->store_result())
    {
        $data = $result->fetch_assoc();
        $result->close();
        if($data!="") extract($data);
        else $Book_List_Generator="NONE";
    }
    else die($mysqli->error);
    $mysqli->close();

    $mysqli = connect_DB();
    $mysqli->real_query("SELECT b.List_Name 
                            FROM `table_fields_list` a, `table_fields_predefined_list` b 
                            WHERE a.Field_ID='$Field_ID' AND a.List_ID = b.List_ID");
    if($result = $mysqli->use_result())
    {
        $data = $result->fetch_assoc();
        if($data!="") extract($data);
        else $List_Name="NONE";
        $result->close();        
    }
    else die($mysqli->error);
    $mysqli->close();

    $mysqli = connect_DB();
    $mysqli->real_query("SELECT a.Field_Name FROM table_fields a, table_fields_list_source_link b WHERE a.Field_ID=b.Field_ID AND a.Field_ID='$Field_ID'");
    if($result = $mysqli->store_result())
    {
        $data = $result->fetch_assoc();
        $Link_Field = $data['Field_Name'];
    }    
    $mysqli->close();

    $mysqli_validation_routines = connect_DB();
    $mysqli_validation_routines->real_query("SELECT Validation_Routine 
                                                FROM `table_fields_secondary_validation` 
                                                WHERE Field_ID='$Field_ID'");

    $mysqli_select_parameters = connect_DB();
    $mysqli_select_parameters->real_query("SELECT b.Field_Name, a.Display  
                                                FROM `table_fields_list_source_select` a, 
                                                     `table_fields` b  
                                                WHERE a.Field_ID='$Field_ID' AND a.Select_Field_ID = b.Field_ID");

    $mysqli_where_parameters = connect_DB();
    $mysqli_where_parameters->real_query("SELECT b.Field_Name, a.Where_Field_Operand, a.Where_Field_Value, a.Where_Field_Connector 
                                                FROM `table_fields_list_source_where` a, 
                                                     `table_fields` b  
                                                WHERE a.Field_ID='$Field_ID' AND a.Where_Field_ID = b.Field_ID");
}
elseif(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header('location: ListView_TableFields.php');
        exit();
    }
    elseif($_POST['btnSubmit'])
    {
        queryDeleteTableField($_POST);
        header("location: ../success.php?success_tag=DeleteTableFields");
        exit();
    }
}

drawHeader();
drawPageTitle('Delete Table Field','Are you sure you wish to delete this table field?');
echo '<input type="hidden" name="Field_ID" value="' . $Field_ID . '">';
?>
<div class="container_mid">
<fieldset class="top">
Delete Table Field
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawTextField('Table','Table_Name',TRUE);
drawTextField('Field Name', 'Field_Name',TRUE);
drawTextField('Data Type','Data_Type',TRUE);
drawTextField('Nullable', 'Nullable', TRUE);
drawTextField('Length','',TRUE);
drawTextField('Attribute','',TRUE);
drawTextField('Control Type','Control_Type',TRUE);
drawTextField('Label','',TRUE);
drawTextField('Show in list view', 'In_Listview', TRUE);

echo '<tr><td colspan=2 align=center><hr> Secondary Validation Routines: <br><table align=center><tr><td align=left><ol>';
if($result = $mysqli_validation_routines->store_result())
{ 
    if($result->num_rows > 0)
        while($row = $result->fetch_assoc()) 
            echo '<li>' . $row['Validation_Routine'];
    else
        echo 'NONE';
}        
echo '</td></tr></table></ol><hr></td></tr>';


drawTextField('Booklist Generator', 'Book_List_Generator',TRUE);
drawTextField('Predefined List', 'List_Name', TRUE);


echo '<tr><td colspan=2 align=center><hr> List SELECT Parameters: <br><table align=center><tr><td align=left><ol>';
if($result = $mysqli_select_parameters->store_result())
{ 
    if($result->num_rows > 0)
        while($row = $result->fetch_assoc()) 
            echo '<li>' . $row['Field_Name'] . '&nbsp - &nbsp' . $row['Display'];
    else
        echo 'NONE';
}        
echo '</td></tr></table></ol><hr></td></tr>';

echo '<tr><td colspan=2 align=center><hr> List WHERE Parameters: <br><table align=center><tr><td align=left><ol>';
if($result = $mysqli_where_parameters->store_result())
{ 
    if($result->num_rows > 0)
        while($row = $result->fetch_assoc()) 
            echo '<li>' . $row['Field_Name'] . '&nbsp; - &nbsp;'
                        . $row['Where_Field_Operand']  . '&nbsp; - &nbsp;' 
                        . $row['Where_Field_Value'] . '&nbsp; - &nbsp;' 
                        . $row['Where_Field_Connector'];
    else
        echo 'NONE';
}        
echo '</td></tr></table></ol><hr></td></tr>';
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
