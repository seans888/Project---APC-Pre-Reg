<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Relation_ID']))
{
    $Relation_ID = rawurldecode($_GET['Relation_ID']);

    $d = connect_DB();
    $stmt = $d->prepare("SELECT Relation_ID, Relation, Label, Parent_Field_ID, Child_Field_ID, Child_Field_Subtext
                            FROM table_relations WHERE Relation_ID=:r_id");
    $stmt->bindValue(':r_id', $Relation_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
    }
    $stmt = $d->prepare("SELECT a.Table_Name, b.Field_Name FROM \"table\" a, table_fields b WHERE a.Table_ID=b.Table_ID AND Field_ID=:f_id");
    $stmt->bindParam(":f_id", $Field_ID);
    $Field_ID = $Parent_Field_ID;
    $result = $stmt->execute();
    while($data = $result->fetchArray())
    {
        $Parent_Table = $data['Table_Name'];
        $Parent_Field = $data['Field_Name'];
    }
    $result->finalize();

    $Field_ID = $Child_Field_ID;
    $result = $stmt->execute();
    while($data = $result->fetchArray())
    {
        $Child_Table = $data['Table_Name'];
        $Child_Field = $data['Field_Name'];
    }

    $Parent = $Parent_Table . '.' . $Parent_Field;
    $Child  = $Child_Table . '.' . $Child_Field;
}
elseif(xsrf_guard())
{
    init_var($_POST['btnCancel']);

    if($_POST['btnCancel'])
    {
        header('location: ListView_TableRelations.php');
        exit();
    }
}

drawHeader();
drawPageTitle('Detail View: Relationship',$errMsg);
?>
<div class="container_mid_huge">
<fieldset class="top">
View Relationship
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawTextField('Label','',TRUE);
drawTextField('Relation','',TRUE);
drawTextField('Parent', '',TRUE);
drawTextField('Child', '',TRUE);
drawTextField('Child Field Subtext Fields','Child_Field_Subtext', TRUE);
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
