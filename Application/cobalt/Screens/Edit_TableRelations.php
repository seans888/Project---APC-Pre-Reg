<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Relation_ID']))
{
    $Relation_ID = rawurldecode($_GET['Relation_ID']);

    $mysqli = connect_DB();
    $mysqli->real_query("SELECT Relation_ID, Relation, Label,
                                Parent_Field_ID, Child_Field_ID, Child_Field_Subtext
                            FROM `table_relations`
                            WHERE `Relation_ID`='$Relation_ID'");
    if($result = $mysqli->use_result())
    {
        $data = $result->fetch_assoc();
        extract($data);
    }
    else die($mysqli->error);
    $mysqli->close();
}
elseif(xsrf_guard())
{
    init_var($Parent_Field_ID);
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);
    extract($_POST);

    if($_POST['btnCancel'])
    {
        header("location: ListView_TableRelations.php");
        exit();
    }

    if($_POST['btnSubmit'])
    {
        $errMsg = scriptCheckIfNull('Relation', $Relation,
                                    'Parent', $Parent_Field_ID,
                                    'Child', $Child_Field_ID);

        //Check for duplicate
        $errMsg .= scriptCheckIfUnique("SELECT Relation_ID
                                        FROM table_relations
                                        WHERE
                                                `Relation_ID` != '" . $Relation_ID . "' AND
                                                `Relation` = '" . $Relation . "' AND
                                                `Parent_Field_ID` = '" . $Parent_Field_ID . "' AND
                                                `Child_Field_ID` = '" . $Child_Field_ID . "'",
                                       "Cannot modify relationship - target relationship already exists!<br />");

        if($Relation=="ONE-to-ONE")
        {
            $errMsg .= scriptCheckIfNull('Child Field Subtext', $Child_Field_Subtext);

            if($errMsg == '')
            {
                //Check if chosen fields actually exist in parent
                //--Get Table ID
                $Table_ID = '';
                $db_handle = connect_DB();
                $db_handle->real_query("SELECT Table_ID
                                        FROM `table_fields`
                                        WHERE Field_ID = '$Parent_Field_ID'");
                if ($result = $db_handle->use_result())
                {
                    while($row = $result->fetch_assoc())
                    {
                        $Table_ID = $row['Table_ID'];
                    }
                    $result->close();
                }

                //--Get the fields of this table
                $arr_fields = array();
                $db_handle = connect_DB();
                $db_handle->real_query("SELECT Field_Name
                                        FROM `table_fields`
                                        WHERE Table_ID = '$Table_ID'
                                        ORDER BY Field_Name ");
                if ($result = $db_handle->use_result())
                {
                    while($row = $result->fetch_assoc())
                    {
                        $arr_fields[] = $row['Field_Name'];
                    }
                    $result->close();
                }

                //--breakdown the chosen fields
                $arr_chosen_fields = explode(',', $Child_Field_Subtext);

                //--see if all chosen fields exist in the retreived parent fields

                foreach($arr_chosen_fields as $subtext)
                {
                    $subtext = trim($subtext);
                    if(in_array($subtext, $arr_fields))
                    {
                        //found, valid
                    }
                    else
                    {
                        $errMsg .= 'Invalid child field subtext: "' . $subtext . '"<br/>';
                    }
                }
            }
        }
        else
        {
            $Child_Field_Subtext = '';
        }

        if($errMsg=="")
        {
            queryUpdateTableRelation($_POST);
            header("location: ../success.php?success_tag=EditTableRelations");
            exit();
        }
    }
}

drawHeader();
drawPageTitle('Edit Relationship',$errMsg);
echo '<input type="hidden" name="Relation_ID" value="' . $Relation_ID . '">';
?>
<div class="container_mid_huge">
<fieldset class="top">
Modify Relationship
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawSelectField('drawTableRelationType', 'Relation', 'Relation', TRUE,'id="relation_field" onChange="toggleChildFieldSubtext()"');
drawSelectField('drawFieldsParent', 'Parent', 'Parent_Field_ID');
drawSelectField('drawFields', 'Child', 'Child_Field_ID');
drawTextField('Child Field Subtext','Child_Field_Subtext',FALSE,'text',TRUE,FALSE,0,'size="50"');
?>
</table>
</fieldset>
<fieldset class="bottom">
<?php
drawSubmitCancel();
?>
</fieldset>
<?php drawSubtextFields($Parent_Field_ID);?>
</div>
<script>
function toggleChildFieldSubtext()
{
    var field = document.getElementById("relation_field");
    if(field.value == "ONE-to-MANY")
    {
        document.getElementById("subtext_div").style.visibility = 'hidden';
        document.getElementById("Child_Field_Subtext").disabled = true;
    }
    else
    {
        document.getElementById("Child_Field_Subtext").disabled = false;
        document.getElementById("subtext_div").style.visibility = 'visible';
    }

    var field = document.getElementById("Parent_Field_ID");
    if(field.value == "")
    {
        document.getElementById("subtext_div").style.visibility = 'hidden';
    }
}
toggleChildFieldSubtext();
</script>
<?php
drawFooter();
?>
