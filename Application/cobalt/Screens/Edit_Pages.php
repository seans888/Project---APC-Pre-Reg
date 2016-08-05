<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Page_ID']))
{
    $Page_ID = rawurldecode($_GET['Page_ID']);
    $Orig_Page_ID = $Page_ID;
    unset($_GET);
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT `Page_Name`, `Generator`, `Description` 
                            FROM `page` 
                            WHERE `Page_ID`='$Page_ID'");
    if($result = $mysqli->use_result())
    {
        $data = $result->fetch_assoc();
        extract($data);
    }
    else die($mysqli->error);
}
elseif(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header('location: ListView_Pages.php');
        exit();
    }
    
    if($_POST['btnSubmit'])
    {
        extract($_POST);
        $errMsg = scriptCheckIfNull('Page Name', $Page_Name, 
                                    'Generator', $Generator,
                                    'Description', $Description);
                                    
        if($errMsg=="")
        {
            $select = "SELECT `Page_ID` FROM `page` WHERE `Page_Name`='$Page_Name' AND `Page_ID`!='$Orig_Page_ID'"; 
            $error = "The page name '$Page_Name' already exists. Please choose a new one. <br>";
            $errMsg = scriptCheckIfUnique($select, $error);

            if($errMsg=="")
            {
                queryUpdatePage($_POST);
                header("location: ../success.php?success_tag=EditPages");
                exit();
            }
        }
    }
}

drawHeader();
drawPageTitle('Edit Page',$errMsg);
?>
<input type="hidden" name="Orig_Page_ID" value="<?php echo $Orig_Page_ID;?>">
<div class="container_mid">
<fieldset class="top">
Modify Page Generator
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawTextField('Page Name', 'Page_Name');
drawTextField('Generator');
drawTextField('Description','','','Textarea');
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
