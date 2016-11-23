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

drawHeader();
drawPageTitle('List View: Pages',$errMsg);
?>
<fieldset class="container">
<?php drawButton('CANCEL');?><a class='blue' href='CreatePages.php'> Create New Page </a>
<table border=1 width=100% class="listView">
<tr class="listRowHead">
    <td width=140>Operations</td>
    <td>Page Name</td>
    <td>Generator</td>
    <td>Description</td>
</tr>
<?php
    $d = connect_DB();
    if($result = $d->query("SELECT Page_ID, Page_Name, Generator, Description FROM page ORDER BY Page_Name"))
    {
        $a=0;
        $class='';
        while($row = $result->fetchArray())
        {
            extract($row);
            if($a%2 == 0) $class='listRowEven';
            else $class='listRowOdd';

            $Page_ID = rawurlencode($Page_ID);
            echo "<tr class=$class><td align=center><a href='DetailView_Pages.php?Page_ID=$Page_ID'><img src='../images/view.png' alt='View' title='View'></a>"
                ."&nbsp;&nbsp;<a href='Edit_Pages.php?Page_ID=$Page_ID'><img src='../images/edit.png' alt='Edit' title='Edit'></a>"
                ."&nbsp;&nbsp;<a href='Del_Pages.php?Page_ID=$Page_ID'><img src='../images/delete.png' alt='Delete' title='Delete'></a></td>";

            printf("<td>%s</td><td>%s</td><td>%s</td></tr>\n", $row['Page_Name'], $row['Generator'], $row['Description']);
            $a++;
        }
    }
?>
</table>
<?php drawButton('CANCEL');?>
</fieldset>
<?php drawFooter(); ?>
