<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header("location: ListView_Pages.php");
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
            queryCreatePage($_POST);
            header("location: ../success.php?success_tag=CreatePages");
            exit();
        }
    }
}

drawHeader();
drawPageTitle('Create Page',$errMsg);
?>
<div class="container_mid">
<fieldset class="top">
New Page Generator
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
?>
