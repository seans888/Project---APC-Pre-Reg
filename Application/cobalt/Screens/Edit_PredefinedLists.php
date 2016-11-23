<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['List_ID']))
{
    $List_ID = rawurldecode($_GET['List_ID']);
    $Orig_List_ID = $List_ID;
    unset($_GET);

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
    if($result = $stmt->execute())
    {
        $numParticulars=0;
        $List_Item = array();
        while($row = $result->fetchArray())
        {
            $List_Item[] =  $row['List_Item'];
            ++$numParticulars;
        }
    }
}


if(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);
    init_var($_POST['particularButton']);

    if($_POST['btnCancel'])
    {
        header("location: ListView_PredefinedLists.php");
        exit();
    }

    if($_POST['btnSubmit'] || $_POST['particularButton'])
    {
        extract($_POST);
    }

    if($_POST['btnSubmit'])
    {
        $errMsg = scriptCheckIfNull('List Name', $List_Name,
                                    'Remarks', $Remarks);

        for($a=0;$a<$particularsCount;$a++)
        {
            $b = $a + 1;
            $errMsg .= scriptCheckIfNull("List Item #$b", $List_Item[$a]);
        }

        if($errMsg=="")
        {
            $d = connect_DB();
            $stmt = $d->prepare("SELECT List_ID FROM table_fields_predefined_list WHERE List_Name=:l_name AND List_ID != :orig_id AND Project_ID =:p_id");
            $stmt->bindValue(':l_name', $List_Name);
            $stmt->bindValue(':orig_id', $Orig_List_ID);
            $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
            $error = "The list name '$List_Name' already exists. Please choose a new one. <br>";
            $errMsg = scriptCheckIfUnique($stmt, $error);

            if($errMsg=="")
            {
                queryUpdatePredefinedList($_POST);
                header("location: ../success.php?success_tag=EditPredefinedLists");
                exit();
            }
        }
    }
}

drawHeader();
drawPageTitle('Edit Predefined Lists',$errMsg);
echo '<input type="hidden" name="Orig_List_ID" value="' .$Orig_List_ID . '">';
?>
<div class="container_mid">
<fieldset class="top">
Delete List
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawTextField('List Name', 'List_Name');
drawTextField('Remarks','','','Textarea');
drawMultiFieldStart('List Items');

    if($numParticulars<1) $numParticulars=1;
    for($a=0;$a<$numParticulars;$a++)
    {
        init_var($List_Item[$a]);
        echo "<li style='margin: 5'><input type='text' name='List_Item[$a]' value='$List_Item[$a]'>";
    }

drawMultiFieldEnd();
?>
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
?>
