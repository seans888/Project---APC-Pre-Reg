<?php
require '../Core/SCV2_Core.php';
init_SCV2();

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
        init_var($In_Listview); //need to check if initialize because this comes from a radio control
        $errMsg = scriptCheckIfNull('Table', $Table_ID,
                                    'Field Name', $Field_Name,
                                    'Data Type', $Data_Type,
                                    'Length', $Length,
                                    'Attribute', $Attribute,
                                    'Control Type', $Control_Type,
                                    'Show in list view', $In_Listview);

        if($Control_Type != "None") $errMsg .= scriptCheckIfNull('Label', $Label);
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
            queryDefineTableField($_POST);
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
            </td>
        </tr>
</table>
</fieldset>
<fieldset class="bottom">
<?php 
drawSubmitCancel();
?>
</fieldset>
</div>
<?php
drawFooter();
