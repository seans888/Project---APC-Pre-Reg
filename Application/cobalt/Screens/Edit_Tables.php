<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['Table_ID']))
{
    $Table_ID = rawurldecode($_GET['Table_ID']);
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT `Table_Name`, `Remarks`, `DB_Connection_ID` FROM `table` WHERE Table_ID = '$Table_ID'");
    if($result = $mysqli->use_result())
    {
        $data = $result->fetch_assoc();
        extract($data);
    }
    else die($mysqli->error);
    $mysqli->close();
    
    $mysqli = connect_DB();
    $mysqli->real_query("SELECT `Page_ID`, `Path_Filename` 
                            FROM `table_pages` 
                            WHERE `Table_ID` = '$Table_ID'");
    if($result = $mysqli->store_result())
    {
        $numParticulars = $result->num_rows;
        for($a=0;$a<$numParticulars;$a++)
        {
            $data = $result->fetch_assoc();
            $Page_ID[$a] = $data['Page_ID'];
            $Filename[$a] = basename($data['Path_Filename']);
            $Folder = dirname($data['Path_Filename']);
            if($Folder=='.') $Folder='';
        }
    }
    else die($mysqli->error);
    $mysqli->close();

    $Orig_Table_Name = $Table_Name;
}
elseif(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);
    init_var($_POST['particularButton']);

    if($_POST['btnCancel'])
    {
        header('location: ListView_Tables.php');
        exit();
    }
    
    if($_POST['btnSubmit'] || $_POST['particularButton'])
    {
        extract($_POST);
    }

    if($_POST['btnSubmit'])
    {
        $errMsg = scriptCheckIfNull('DB Connection', $DB_Connection_ID,
                                    'Table Name', $Table_Name);
        
        for($a=0;$a<$particularsCount;$a++)
        {
            $b = $a + 1;
            $errMsg .= scriptCheckIfNull("Table page #$b", $Page_ID[$a]);
            if(trim($Folder)!='')
            {
                $Path_Filename[$a] = trim($Folder) . '/' . trim(basename($Filename[$a]));
            }
            else
            {
                $Path_Filename[$a] = trim(basename($Filename[$a]));
            }
        }

        if($errMsg=="")
        {
            $select = "SELECT `Table_Name` FROM `table` WHERE `Table_Name`='$Table_Name' AND `Table_Name`!='$Orig_Table_Name' AND Project_ID='$_SESSION[Project_ID]'"; 
            $error = "The table name '$Table_Name' already exists. Please choose a new name. <br>";
            $errMsg = scriptCheckIfUnique($select, $error);

            if($errMsg=="")
            {
                $_POST['Path_Filename'] = $Path_Filename;
                queryUpdateTable($_POST);
                header("location: ../success.php?success_tag=EditTables");
                exit();
            }
        }
    }
}

drawHeader();
drawPageTitle('Edit Table',$errMsg);
echo '<input type="hidden" name="Table_ID" value="' . $Table_ID . '">';
echo '<input type="hidden" name="Orig_Table_Name" value="' . $Orig_Table_Name . '">';
?>
<div class="container_mid">
<fieldset class="top">
Modify Table
</fieldset>

<fieldset class="middle">
<table class="input_form">
<?php
drawSelectField('drawDBConnection', 'DB Connection', 'DB_Connection_ID');
drawTextField('Table Name', 'Table_Name');
drawTextField('Folder / Subdirectory', 'Folder');
drawTextField('Remarks','','','Textarea');

drawMultiFieldStart('Table Pages');
    if($numParticulars<1) $numParticulars=1;
    echo "<table>
          <tr>
              <td>&nbsp;</td>
              <td>Page</td>
              <td>Filename</td>
          </tr>";
    for($a=0;$a<$numParticulars;$a++)
    {
        echo "<tr><td>" . ($a+1) . "</td><td>";
        drawTablePage($Page_ID[$a], TRUE); echo "&nbsp;&nbsp;";
        echo "</td><td>";
        drawTextField('','Filename', FALSE, '', FALSE, TRUE, $a); echo "&nbsp;&nbsp;";
        echo "</td></tr>";
    }
    echo "</table>";
drawMultiFieldEnd();
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
