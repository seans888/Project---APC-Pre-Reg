<?php
if(session_status() != PHP_SESSION_ACTIVE)
{
    header("location: start.php");
    die();
}
require $_SESSION['header'];
$target = ''; //no frames, so no special target needed.
?>
<script>
if (top.location != location)
{
    top.location.href = document.location.href ;
}
</script>
<?php
require 'header_menu.php';