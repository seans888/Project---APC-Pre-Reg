<?php
require_once 'path.php';
init_cobalt('ALLOW_ALL',FALSE);

if(ENABLE_SIDEBAR)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD Xhtml 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
    <title> <?php echo GLOBAL_PROJECT_NAME;?> - Powered by Cobalt</title>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo MULTI_BYTE_ENCODING; ?>" />
</head>
<frameset rows="120,*" frameborder="1">
    <frame src="header.php" name="header_frame" frameborder="0">
    <frameset cols="200,*" frameborder="1">
        <frame frameborder="1" src="menus.php" name="menu_frame">
        <frame frameborder="1" src="main.php" name="content_frame">
    </frameset>
</frameset>
<?php
}
else
{
    redirect('main.php');
}
