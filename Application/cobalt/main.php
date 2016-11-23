<?php
require 'Core/SCV2_Core.php';
init_SCV2();
drawHeader(FALSE);
drawPageTitle("Cobalt Control Center");
$img_height = '';
?>

<div class="container_mid_huge2">
    <fieldset class="top">
        Schema Control
    </fieldset>
    <fieldset class="middle">
        <table border=0 width=100%>
            <tr>
		    <td align="center" width="20%">
        		<a href="Screens/ListView_DBConnections.php" class="linkCC"><img height="<?php echo $img_height; ?>" src=/cobalt/images/icons/database.png><br>Database Connections</a>
		    </td>
		    <td align="center" width="20%">
        		<a href="Screens/ListView_Tables.php" class="linkCC"><img height="<?php echo $img_height; ?>" src=/cobalt/images/icons/tables.png><br>Tables</a>
		    </td>
		    <td align="center" width="20%">
        		<a href="Screens/ListView_TableFields.php" class="linkCC"><img height="<?php echo $img_height; ?>" src=/cobalt/images/icons/field.png><br>Fields</a>
		    </td>
		    <td align="center" width="20%">
        		<a href="Screens/ListView_TableRelations.php" class="linkCC"><img height="<?php echo $img_height; ?>" src=/cobalt/images/icons/tables_rel1.png><br>Relationships</a>
		    </td>
		    <td align="center" width="20%">
        		<a href="Screens/ListView_PredefinedLists.php" class="linkCC"><img height="<?php echo $img_height; ?>" src=/cobalt/images/icons/list.png><br>Predefined Lists</a>
		    </td>
	    </tr>
	    </table>
    </fieldset>
</div>
<div class="container_mid_huge2">
    <fieldset class="top">
        Project Control
    </fieldset>
    <fieldset class="middle">
	    <table border=0 width=100%>
	    <tr>
		    <td align="center" width="20%">
        		<a href="Screens/ListView_Pages.php" class="linkCC"><img height="<?php echo $img_height; ?>" src=/cobalt/images/icons/page.png><br>Pages</a>
		    </td>
		    <td align="center" width="20%">
        		<a href="Screens/Del_Project.php" class="linkCC"><img height="<?php echo $img_height; ?>" src=/cobalt/images/icons/destroy.png><br>Destroy Project</a>
		    </td>
		    <td align="center" width="20%">
        		<a href="Screens/Edit_Project.php?First_Run=TRUE" class="linkCC"><img height="<?php echo $img_height; ?>" src=/cobalt/images/icons/settings.png><br>Project Settings</a>
		    </td>
		    <td align="center" width="20%">
        		<a href="Screens/Export_Project.php?First_Run=TRUE" class="linkCC"><img height="<?php echo $img_height; ?>" src="/cobalt/images/icons/export.png"><br>Export Project</a>
		    </td>
		    <td align="center" width="20%">
        		<a href="Screens/Get_R_Done.php" class="linkCC"><img height="<?php echo $img_height; ?>" src="/cobalt/images/icons/get-er-done.png"><br>Generate Project</a>
		    </td>
		    <td align="center" width="20%">
		        &nbsp;
		    </td>
	    </tr>
	    </table>
    </fieldset>
</div>
<?php drawFooter(); ?>
