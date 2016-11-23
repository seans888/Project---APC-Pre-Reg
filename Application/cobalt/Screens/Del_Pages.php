<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Page_ID']))
{
    $Page_ID = rawurldecode($_GET['Page_ID']);

    $d = connect_DB();
    $stmt = $d->prepare("SELECT `Page_Name`, `Generator`, `Description`
                            FROM `page`
                            WHERE `Page_ID`=:p_id");
    $stmt->bindValue(':p_id', $Page_ID);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
    }
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
    elseif($_POST['btnSubmit'])
    {
        queryDeletePage($_POST);
        header("location: ../success.php?success_tag=DeletePages");
        exit();
    }
}

drawHeader();
drawPageTitle('Delete Page',$errMsg);
?>
<input type="hidden" name="Page_ID" value="<?php echo $Page_ID;?>">
<div class="container_mid">
<fieldset class="top">
Delete Page Generator
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php

drawTextField('Page Name', 'Page_Name',TRUE);
drawTextField('Generator','',TRUE);
drawTextField('Description','',TRUE);
?>
</table>
</fieldset>
<fieldset class="bottom">
<?php
drawDeleteCancel();
?>
</fieldset>
</div>
<?php
drawFooter(); ?>
