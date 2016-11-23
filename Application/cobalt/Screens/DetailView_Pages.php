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

    if($_POST['btnCancel'])
    {
        header('location: ListView_Pages.php');
        exit();
    }
}

drawHeader();
drawPageTitle('Detail View: Page',$errMsg);
?>
<div class="container_mid">
<fieldset class="top">
View Page Generator: <?php echo $Page_Name;?>
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
drawBackButton();
?>
</fieldset>
</div>
<?php
drawFooter();
