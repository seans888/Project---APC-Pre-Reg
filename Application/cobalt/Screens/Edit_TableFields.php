<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Field_ID']))
{
    $Field_ID = rawurldecode($_GET['Field_ID']);
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT Table_ID, Field_Name, Field_ID, Data_Type, Control_Type, 
                                Length, Attribute, Label, In_Listview, Nullable
                            FROM `table_fields`
                            WHERE Field_ID = '$Field_ID'");
                            
    if($result = $mysqli->use_result())
    {
        $data = $result->fetch_assoc();
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
    $mysqli->real_query("SELECT List_ID 
                            FROM `table_fields_list`  
                            WHERE Field_ID='$Field_ID'");
    if($result = $mysqli->use_result())
    {
        $data = $result->fetch_assoc();
        if($data!="") 
        {
            extract($data);
            //Additionally, if there is a predefined list, we should set the dropdown type to "Predefined".
            $DropdownType='Predefined';
        }
        else $List_Name="NONE";
    }
    else die($mysqli->error);
    $mysqli->close();


    $mysqli = connect_DB();
    $mysqli->real_query("SELECT Validation_Routine 
                            FROM `table_fields_secondary_validation` 
                            WHERE Field_ID='$Field_ID'");
    if($result = $mysqli->store_result())
    {
        $particularsCount = $result->num_rows;
        for($a=0;$a<$particularsCount;$a++)
        {
            $data = $result->fetch_assoc();
            $Validation_Routine[$a] = $data['Validation_Routine'];
        }
    }
    else die($mysqli->error);
    $mysqli->close();


    $mysqli = connect_DB();
    $mysqli->real_query("SELECT Select_Field_ID, Display 
                            FROM `table_fields_list_source_select` 
                            WHERE Field_ID='$Field_ID'");
    if($result = $mysqli->store_result())
    {
        $selectCount = $result->num_rows;
        for($a=0;$a<$selectCount;$a++)
        {
            $data = $result->fetch_assoc();
            $Select_Field_ID[$a] = $data['Select_Field_ID'];
            $Select_Field_Display[$a] =  $data['Display'];
        }
        
        //Additionally, we want to know if $selectCount actually has a value of 1 or more.
        //This is because we want to know if we will assign "Source" to $DropdownType.
        //We have to do this like this because the value of $DropdownType is actually never stored
        //in the database - it is only a means of making sure the user input is properly checked, so the
        //value is discarded into oblivion after the form is successfully submitted and processed.
        if($selectCount > 0) $DropdownType = 'Source';
    }
    else die($mysqli->error);
    $mysqli->close();

    $mysqli = connect_DB();
    $mysqli->real_query("SELECT Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector 
                                                FROM `table_fields_list_source_where` 
                                                WHERE Field_ID='$Field_ID'");
    if($result = $mysqli->store_result())
    {
        $whereCount = $result->num_rows;
        for($a=0;$a<$whereCount;$a++)
        {
            $data = $result->fetch_assoc();
            $Where_Field_ID[$a] = $data['Where_Field_ID'];
            $Where_Field_Operand[$a] = $data['Where_Field_Operand'];
            $Where_Field_Value[$a] = $data['Where_Field_Value'];
            $Where_Field_Connector[$a] = $data['Where_Field_Connector'];
        }
    }
    else die($mysqli->error);
    $mysqli->close();
    
}
elseif(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);
    init_var($_POST['particularButton']);

    if($_POST['btnCancel'])
    {
        header("location: ListView_TableFields.php");
        exit();
    }

    if($_POST['btnSubmit'] || $_POST['particularButton'])
    {
        extract($_POST);
    }
    
    if($_POST['btnSubmit'])
    {
        init_var($In_Listview); //need to check if initialize because this comes from a radio control
        $errMsg = scriptCheckIfNull('Table', $Table_ID,
                                    'Field Name', $Field_Name,
                                    'Data Type', $Data_Type,
                                    'Length', $Length,
                                    'Attribute', $Attribute,
                                    'Control Type', $Control_Type,
                                    'Show in list view', $In_Listview);
    
        if($Control_Type != "None") $errMsg = scriptCheckIfNull('Label', $Label);
        if($Control_Type == "Special_Textbox") $errMsg .= scriptCheckIfNull('Book List Generator', $Book_List_Generator);
        elseif($Control_Type == "Radio") $errMsg .= scriptCheckIfNull('Predefined List', $List_ID);
        elseif($Control_Type == "Drop-down List")
        {
            $errMsg .=    scriptCheckIfNull('DropdownType', $DropdownType);

            if($DropdownType=="Source")
            {
                for($a=0;$a<$selectCount;$a++)
                {
                    $b = $a + 1;
                    $errMsg .= scriptCheckIfNull("SELECT parameter field #$b", $Select_Field_ID[$a],
                                                 "SELECT parameter display setting #$b", $Select_Field_Display[$a]);
                }
                
                for($a=0;$a<$whereCount;$a++)
                {
                    $b = $a + 1;
                    if($Where_Field_ID[$a] != '0')
                    {
                        $errMsg .= scriptCheckIfNull("WHERE parameter field #$b", $Where_Field_ID[$a],
                                                     "WHERE parameter operand #$b", $Where_Field_Operand[$a],
                                                     "WHERE parameter value #$b", $Where_Field_Value[$a],
                                                     "WHERE parameter conncetor #$b", $Where_Field_Connector[$a]);
                    }
                }
            }
            else
            {
                $errMsg .= scriptCheckIfNull('Predefined List', $List_ID);
            }
        }
        
        for($a=0;$a<$particularsCount;$a++)
        {
            $b = $a + 1;
            if($particularsCount > 1 && trim($Validation_Routine[0])!= "") 
                $errMsg .= scriptCheckIfNull("Validation Routine #$b", $Validation_Routine[$a]);
        }

        if($errMsg=="")
        {
            //Add additional info needed before passing $_POST
            queryUpdateTableField($_POST);
            header("location: ../success.php?success_tag=EditTableFields");
            exit();
        }
    }
}

drawHeader();
drawPageTitle('Edit Table Field', $errMsg);
echo '<input type="hidden" name="Field_ID" value="' . $Field_ID . '">';
?>
<div class="container_mid_huge2">
<fieldset class="top">
Modify Table Field
</fieldset>
<fieldset class="middle">
<table class="inputForm">
<?php
drawSelectField('drawTable', 'Table','Table_ID');
drawTextField('Field Name', 'Field_Name');
drawSelectField('drawDataType', 'Data Type', 'Data_Type');
drawSelectField('drawNullable', 'Nullable', 'Nullable');
drawTextField('Length');
drawSelectField('drawAttribute','Attribute');
drawSelectField('drawControlType','Control Type', 'Control_Type');
drawTextField('Label');

$arrayItems = array(
                    'Items' => array('Yes','No'),
                    'Values'=> array('yes','no'),
                    'PerLine' => FALSE
                   );
drawRadioField($arrayItems,'Show in list view?','In_Listview');

$arrayMultiField = array(
                         'FieldLabels' => array('VALIDATION ROUTINE'),
                         'FieldControls' => array('drawValidationRoutine'),
                         'FieldVariables' => array('Validation_Routine')
                        );
drawMultiFieldAuto('<br>Secondary validation routines for this field<br>', $arrayMultiField);

?>
<tr><td colspan="2">Additional Options<br><br></td></tr>
<tr><td colspan="2">
    <ol class="normal">
    <li> If Control Type is 'Special Textbox', choose a Book List Generator:<br>
        <?php drawSelectField('drawBookListGenerator','Book List Generator: ','Book_List_Generator', FALSE); ?>
        <br><br>
            
    <li> If Control Type is "Drop-down List", choose the list source type: <br>
        <?php
        $arrayItems = array(
                            'Items' => array('Predefined list (choose specific list in #3)','SQL generated'),
                            'Values'=> array('Predefined','Source'),
                            'PerLine' => TRUE
                           );
        drawRadioField($arrayItems,'','DropdownType', FALSE);
        ?><br>

    <li> If Control Type is 'Radio', choose a Predefined List. <br>
        Or if Control Type is 'Drop-down List' but you still want <br> 
        to use a predefined list, choose the list you want here. <br>
        <?php drawSelectField('drawPredefinedList','Predefined List: ','List_ID',FALSE); ?>
        <br><br>

    <li> If Control Type is 'Drop-down List' and you chose <br>
        SQL generated source, specify the parameters here:<br>
            <table align=center border=1>
            <tr><td>
                <table><tr><td>
            <?php

if($selectCount==0)
{
    $selectCount = 2;
    $Select_Field_Display[0] = 'No';
    $Select_Field_Display[1] = 'Yes';
}
$arrayMultiField = array("FieldLabels" => array('FIELD','DISPLAY (NO means use as value)'),
                         "FieldControls" => array('drawListSourceSelectField', 'drawListSourceSelectFieldDisplay'),
                         "FieldVariables" => array('Select_Field_ID','Select_Field_Display'));
drawMultiFieldAuto('List SELECT Parameters', $arrayMultiField, 'numSelect', 'selectCount');

$arrayMultiField = array("FieldLabels" => array('FIELD','OPERAND','VALUE','CONNECTOR'),
                         "FieldControls" => array('drawListSourceWhereField', 'drawListSourceWhereFieldOperand',
                                                  'drawListSourceWhereFieldValue', 'drawListSourceWhereFieldConnector'),
                         "FieldVariables" => array('Where_Field_ID','Where_Field_Operand','Where_Field_Value','Where_Field_Connector'));
drawMultiFieldAuto('List WHERE Parameters', $arrayMultiField, 'numWhere', 'whereCount');
            ?>
                </td></tr></table>
            </td></tr></table>
    </ol>
    </td>
</tr>
</table>
</fieldset>
<fieldset class="bottom">
<?php drawSubmitCancel(); ?>
</fieldset>
</div>
<?php
drawFooter();
