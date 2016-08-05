<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(xsrf_guard())
{
    if($_POST['btnCancel'])
    {
        header("location: " . HOME_PAGE);
        exit();
    }
}

$mysqli = connect_DB();
$mysqli->real_query("SELECT Username, Password FROM `user` ORDER BY Username");

drawHeader($errMsg);
drawPageTitle('List View: Users');
?>
<?php drawButton('CANCEL');?><a class='blue' href='Create_Users.php'> Add a New User </a>
<table border=1 width=100% cellspacing=1>
<tr class=tableHeader>
    <td width=100>Operations</td>
    <td>User</td>
</tr>
<?php
    if($result = $mysqli->use_result())
    {
        $a=0;
        $class='';
        while($row = $result->fetch_assoc())
        {
            extract($row);
            if($a%2 == 0) $class='listRowEven';
            else $class='listRowOdd';

            $Username = rawurlencode($Username);
            echo "<tr class=$class><td align=center><a href='DetailView_Users.php?Username=$Username'><img src='/SCV2/images/View.jpg' alt='View' title='View'></a>"
                ."&nbsp;&nbsp;<a href='Edit_Users.php?Username=$Username'><img src='/SCV2/images/Edit.jpg' alt='Edit' title='Edit'></a>"
                ."&nbsp;&nbsp;<a href='Del_Users.php?Username=$Username'><img src='/SCV2/images/Delete.jpg' alt='Delete' title='Delete'></a></td>";

            printf("<td>%s</td></tr>\n", $row['Username']);
            $a++;
        }
        $result->close();
    }
    else die($mysqli->error);
?>
</table>
<?php drawButton('CANCEL');?>
<?php drawFooter(); ?>
