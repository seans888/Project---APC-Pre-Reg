<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(xsrf_guard())
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
        $d = connect_DB();
        $stmt = $d->prepare("SELECT Relation_ID FROM table_relations
                                WHERE Relation = :rel AND Parent_Field_ID = :pf_id AND Child_Field_ID = :cf_id");
        $stmt->bindValue(':rel', $Relation);
        $stmt->bindValue(':pf_id', $Parent_Field_ID);
        $stmt->bindValue(':cf_id', $Child_Field_ID);

        $message = "Cannot add relationship - this relationship already exists!<br />";
        $errMsg .= scriptCheckIfUnique($stmt, $message);

        if($Relation=="ONE-to-ONE")
        {
            $errMsg .= scriptCheckIfNull('Child Field Subtext', $Child_Field_Subtext);

            if($errMsg == '')
            {
                //Check if chosen fields actually exist in parent
                //--Get Table ID
                $Table_ID = '';
                $d = connect_DB();
                $stmt = $d->prepare("SELECT Table_ID FROM table_fields WHERE Field_ID = :pf_id");
                $stmt->bindValue(':pf_id', $Parent_Field_ID);
                if ($result = $stmt->execute())
                {
                    while($row = $result->fetchArray())
                    {
                        $Table_ID = $row['Table_ID'];
                    }
                }
                $result->finalize();

                //--Get the fields of this table
                $arr_fields = array();
                $stmt = $d->prepare("SELECT Field_Name FROM table_fields WHERE Table_ID = :t_id ORDER BY Field_Name ");
                $stmt->bindValue(':t_id', $Table_ID);
                if ($result = $stmt->execute())
                {
                    while($row = $result->fetchArray())
                    {
                        $arr_fields[] = $row['Field_Name'];
                    }
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
                        $errMsg .= 'Invalid child field subtext: ' . $subtext . '<br/>';
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
            queryDefineTableRelation($_POST);
            header("location: ../success.php?success_tag=DefineTableRelations");
            exit();
        }
    }
}
drawHeader();
drawPageTitle('Define Relationship', $errMsg);
?>
<div class="container_mid_huge">
<fieldset class="top">
New Relationship
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
