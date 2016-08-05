<?php
require 'Core/SCV2_Core.php';
init_SCV2();
$_SESSION = array();
if(isset($_COOKIE[session_name()]))
{
	setcookie (session_name(), "", time() - 86400);
}
session_destroy();
?>
<html>
<head><title> Logged out</title>
<link href="/SCV2/css/SCV2.css" rel="stylesheet" type="text/css">
</head>
<body>
<br><br><br><br><br>
<?php drawFieldSetStart('400','controlsContainerShort','You have logged out of SCV2');?>
<tr>
	<td>
		You have been logged out of the system. <br>
		All session files and cookies containing your personal and <br>
		account information that you used during this session have <br>
		been deleted successfully. <br><br>
        <a href="/SCV2/index.php"> Click here</a> to return to SCV2.<br><br>
	</td>
</tr>
<?php drawFieldSetEnd();?>
</body>
</html>
