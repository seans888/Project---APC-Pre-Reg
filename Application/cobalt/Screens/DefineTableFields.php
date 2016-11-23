<?php
require '../Core/SCV2_Core.php';
init_SCV2();

//radio controls
init_var($Nullable, 'FALSE');
init_var($Auto_Increment, 'FALSE');
init_var($In_Listview, 'TRUE');
init_var($Required, 'TRUE');
init_var($Char_Set_Allow_Space, 'TRUE');
init_var($Allow_HTML_Tags, 'FALSE');
init_var($Drop_Down_Has_Blank, 'TRUE');
init_var($RPT_In_Report, 'TRUE');
init_var($RPT_Show_Sum, 'FALSE');

if(xsrf_guard())
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
        init_var($DropdownType);

        switch($Data_Type)
        {
            case 'integer'          :
            case 'double or float'  : $Char_Set_Method         = 'generate_num_set';
                                      $Extra_Chars_Allowed     = '-';
                                      $Char_Set_Allow_Space    = 'FALSE';
                                      $RPT_Column_Format       = 'number_format2';
                                      $RPT_Column_Alignment    = 'right';
                                      $RPT_Show_Sum            = 'TRUE';
                                      break;

            case 'text'             : $Control_Type            = 'textarea';
                                      break;

            case 'date'             : $Control_Type            = 'date controls';
                                      $Size                    = 0;
                                      $Char_Set_Method         = '';
                                      $Extra_Chars_Allowed     = '';
                                      $Char_Set_Allow_Space    = 'TRUE';
                                      break;

            case 'text'             :
            case 'date'             : $RPT_Column_Format       = 'normal';
                                      $RPT_Column_Alignment    = 'left';
                                      $RPT_Show_Sum            = 'FALSE';
                                      break;

            default                 : $RPT_Column_Format       = 'normal';
                                      $RPT_Column_Alignment    = 'left';
                                      $RPT_Show_Sum            = 'FALSE';
                                      break;
        }

        if($Control_Type == '')
        {
            $Control_Type = 'textbox';
        }

        if($Control_Type == 'textbox')
        {
            if($Size == '')
            {
                $Size = '60';
            }
        }
        elseif($Control_Type == 'textarea')
        {
            if($Size == '')
            {
                $Size = '58;5';
            }
        }

        $errMsg = scriptCheckIfNull('Table', $Table_ID,
                                    'Field Name', $Field_Name,
                                    'Data Type', $Data_Type,
                                    'Nullable', $Nullable,
                                    'Length', $Length,
                                    'Attribute', $Attribute,
                                    'Auto Increment', $Auto_Increment,
                                    'Show in List View Page', $In_Listview,
                                    'Control Type', $Control_Type,
                                    'Drop-Down List Has Blank', $Drop_Down_Has_Blank,
                                    'Required', $Required,
                                    'Char Set Allow Space', $Char_Set_Allow_Space,
                                    'Allow HTML Tags', $Allow_HTML_Tags,
                                    'Reporter: In Report', $RPT_In_Report,
                                    'Reporter: Column Alignment', $RPT_Column_Alignment);

        if($Control_Type != "none") $errMsg .= scriptCheckIfNull('Label', $Label);

        if($Control_Type == "radio") $errMsg .= scriptCheckIfNull('Predefined List', $List_ID);
        elseif($Control_Type == "drop-down list")
        {
            $errMsg .=    scriptCheckIfNull('Drop-down Type (Additional Option #1)', $DropdownType);

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

        if($errMsg=="")
        {
            //Add additional info needed before passing $_POST
            queryDefineTableField();
            header("location: ../success.php?success_tag=DefineTableFields");
            exit();
        }
    }
}

drawHeader();
drawPageTitle('Define Table Fields',$errMsg);
?>
<div class="container_mid_huge2">
<fieldset class="top">
New Table Field
</fieldset>
<fieldset class="middle">

    <?php
    $arrayItems = array(
                        'Items' => array('TRUE','FALSE'),
                        'Values'=> array('TRUE','FALSE'),
                        'PerLine' => FALSE
                       );

    fieldsetStart('Data Settings');
    drawSelectField('drawTable', 'Table', 'Table_ID');
    drawTextField('Field Name', 'Field_Name');
    drawSelectField('drawDataType', 'Data Type', 'Data_Type');
    drawRadioField($arrayItems, 'Nullable');
    drawTextField('Length');
    drawSelectField('drawAttribute', 'Attribute');
    drawRadioField($arrayItems, 'Auto Increment', 'Auto_Increment');
    fieldsetEnd();

    fieldsetStart('HTML Settings');
    drawRadioField($arrayItems, 'Show in List View Page', 'In_Listview');
    drawSelectField('drawControlType', 'Control Type', 'Control_Type');
    drawTextField('Label');
    drawTextField('Size');
    drawTextField('Extra', 'Extra', FALSE, '', TRUE, FALSE, 0, 'size="32"');
    drawTextField('Companion', 'Companion', FALSE, 'textarea');
    drawRadioField($arrayItems, 'Drop-Down List Has Blank', 'Drop_Down_Has_Blank');
    fieldsetEnd();

    fieldsetStart('Validation Settings');
    drawRadioField($arrayItems, 'Required');
    drawSelectField('drawCharSetMethod', 'Char Set Method', 'Char_Set_Method');
    drawRadioField($arrayItems,'Char Set Allow Space', 'Char_Set_Allow_Space');
    drawTextField('Extra Chars Allowed', 'Extra_Chars_Allowed');
    drawTextField('Valid Set', 'Valid_Set');
    fieldsetEnd();

    fieldsetStart('Reporter Settings');
    drawRadioField($arrayItems, 'In Report', 'RPT_In_Report');
    drawTextField('Column Format', 'RPT_Column_Format');
    drawSelectField('drawColumnAlignment', 'Column Alignment', 'RPT_Column_Alignment');
    drawRadioField($arrayItems, 'Show Sum', 'RPT_Show_Sum');
    fieldsetEnd();

    fieldsetStart('Defaults');
    drawTextField('Default Value', 'Default_Value');
    drawTextField('Date Default', 'Date_Default');
    fieldsetEnd();

    fieldsetStart('Misc Settings');
    drawRadioField($arrayItems, 'Allow HTML Tags', 'Allow_HTML_Tags');
    drawSelectField('drawTrimValue', 'Trim Value', 'Trim_Value');
    fieldsetEnd();

    fieldsetStart('Additional Options');
    ?>
    <tr><td colspan="2">
        <ol class="normal">
            <li> If Control Type is "Drop-down List", choose the list source type: <br>

    <?php
    $arrayItems = array(
                        'Items' => array('Predefined list (choose specific list in #2)','SQL generated'),
                        'Values'=> array('Predefined','Source'),
                        'PerLine' => TRUE
                       );
    drawRadioField($arrayItems,'','DropdownType', FALSE);
    ?>

    <br>
    <li> If Control Type is 'Radio', choose a Predefined List. <br>
    Or if Control Type is 'Drop-down List' but you still want <br>
    to use a predefined list, choose the list you want here. <br>

    <?php drawSelectField('drawPredefinedList','Predefined List: ','List_ID',FALSE); ?>

    <br><br>
    <li> If Control Type is 'Drop-down List' and you chose <br>
    SQL generated source, specify the parameters here:<br>
        <table style="margin: 20px auto 20px auto; text-align: center">
        <tr><td>
            <table><tr><td>

    <?php
    if(!isset($selectCount))
    {
        $selectCount = 2;
        $Select_Field_Display[0] = 'No';
        $Select_Field_Display[1] = 'Yes';
    }
    $arrayMultiField = array(
                             "FieldLabels" => array('FIELD','DISPLAY (NO means use as value)'),
                             "FieldControls" => array('drawListSourceSelectField', 'drawListSourceSelectFieldDisplay'),
                             "FieldVariables" => array('Select_Field_ID','Select_Field_Display')
                            );
    drawMultiFieldAuto('List SELECT Parameters', $arrayMultiField, 'numSelect', 'selectCount');

    $arrayMultiField = array(
                             "FieldLabels" => array('FIELD','OPERAND','VALUE','CONNECTOR'),
                             "FieldControls" => array('drawListSourceWhereField', 'drawListSourceWhereFieldOperand',
                                                      'drawListSourceWhereFieldValue', 'drawListSourceWhereFieldConnector'),
                             "FieldVariables" => array('Where_Field_ID','Where_Field_Operand','Where_Field_Value','Where_Field_Connector')
                            );
    drawMultiFieldAuto('List WHERE Parameters', $arrayMultiField, 'numWhere', 'whereCount');
    ?>

            </td></tr></table>
        </td></tr></table>
    </ol>
    </td></tr>

    <?php fieldsetEnd(); ?>

</fieldset>
<fieldset class="bottom">
<?php
drawSubmitCancel();
?>
</fieldset>
</div>
<?php
drawFooter();
