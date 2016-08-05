<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['List_ID']))
{
    $List_ID = rawurldecode($_GET['List_ID']);
    $Orig_List_ID = $List_ID;
    unset($_GET);
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT `List_Name`, `Remarks` 
                            FROM `table_fields_predefined_list` 
                            WHERE `List_ID`='$List_ID'");
    if($result = $mysqli->use_result())
    {
        $data = $result->fetch_assoc();
        extract($data);
    }
    else die($mysqli->error);
    $mysqli->close();
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT `List_Item` 
                            FROM `table_fields_predefined_list_items`
                            WHERE `List_ID`='$List_ID'
                            ORDER BY `Number`");

    if($result = $mysqli->store_result())
    {
        $numParticulars=$result->num_rows;
        $List_Item = array();
        while($row = $result->fetch_assoc()) $List_Item[] =  $row['List_Item'];
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
            $mysqli = connect_DB();
            $select = "SELECT `List_ID` FROM `table_fields_predefined_list` WHERE `List_Name`='" . $mysqli->real_escape_string($List_Name)
                    . "' AND `List_ID`!='" . $mysqli->real_escape_string($Orig_List_ID)
                    . "' AND `Project_ID`='" . $mysqli->real_escape_string($_SESSION['Project_ID']) . "'"; 
            $error = "The list name '$List_Name' already exists. Please choose a new one. <br>";
            $errMsg = scriptCheckIfUnique($select, $error);

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
