<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Field_ID']))
{
    $Field_ID = rawurldecode($_GET['Field_ID']);

    $d = connect_DB();
    $stmt = $d->prepare('SELECT * FROM table_fields WHERE Field_ID = :f_id');
    $stmt->bindValue(':f_id', $Field_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
        $result->finalize();
    }

    $stmt = $d->prepare("SELECT List_ID FROM table_fields_list WHERE Field_ID=:f_id");
    $stmt->bindValue(':f_id', $Field_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        if($data!="")
        {
            extract($data);
            //Additionally, if there is a predefined list, we should set the dropdown type to "Predefined".
            $DropdownType='Predefined';
        }
        else $List_Name="NONE";
    }

    $stmt = $d->prepare('SELECT Select_Field_ID, Display FROM table_fields_list_source_select WHERE Field_ID=:f_id');
    $stmt->bindValue(':f_id', $Field_ID);
    if($result = $stmt->execute())
    {
        $selectCount = 0;
        while($data = $result->fetchArray())
        {
            $Select_Field_ID[$a] = $data['Select_Field_ID'];
            $Select_Field_Display[$a] =  $data['Display'];
            ++$selectCount;
        }

        //Additionally, we want to know if $selectCount actually has a value of 1 or more.
        //This is because we want to know if we will assign "Source" to $DropdownType.
        //We have to do this like this because the value of $DropdownType is actually never stored
        //in the database - it is only a means of making sure the user input is properly checked, so the
        //value is discarded into oblivion after the form is successfully submitted and processed.
        if($selectCount > 0) $DropdownType = 'Source';
    }

    $stmt = $d->prepare("SELECT Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector
                            FROM table_fields_list_source_where WHERE Field_ID=:f_id");
    $stmt->bindValue(':f_id', $Field_ID);
    if($result = $stmt->execute())
    {
        $whereCount = 0;
        while($data = $result->fetchArray())
        {
            $Where_Field_ID[$a] = $data['Where_Field_ID'];
            $Where_Field_Operand[$a] = $data['Where_Field_Operand'];
            $Where_Field_Value[$a] = $data['Where_Field_Value'];
            $Where_Field_Connector[$a] = $data['Where_Field_Connector'];
            ++$whereCount;
        }
    }
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
        init_var($DropdownType);

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

        if($Control_Type != "none") $errMsg = scriptCheckIfNull('Label', $Label);
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
<?php drawSubmitCancel(); ?>
</fieldset>
</div>
<?php
drawFooter();
