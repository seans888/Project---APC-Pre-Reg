<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);
    init_var($_POST['particularButton']);

    if($_POST['btnCancel'])
    {
        header("location: ListView_Tables.php");
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
            $Path_Filename[$a] = trim($Folder) . '/' . trim(basename($Filename[$a]));
        }

        if($errMsg=="")
        {
            $d = connect_DB();
            $stmt = $d->prepare('SELECT Table_Name FROM "table" WHERE Table_Name=:t_id AND Project_ID=:p_id');
            $stmt->bindValue(':t_id', $Table_Name);
            $stmt->bindValue(':p_id', $_SESSION['Project_ID']);

            $error = "The table name '$Table_Name' already exists. Please choose a new name. <br>";
            $errMsg = scriptCheckIfUnique($stmt, $error);

            if($errMsg=="")
            {
                //Add additional info needed before passing $_POST
                $_POST['Project_ID'] = $_SESSION['Project_ID'];
                $_POST['Path_Filename'] = $Path_Filename;
                queryCreateTable($_POST);
                header("location: ../success.php?success_tag=CreateTables");
                exit();
            }
        }
    }
}
init_var($particularsCount);
if($particularsCount <= 0)
{
    $numParticulars=6;
}

drawHeader();
drawPageTitle('Create Table',$errMsg);
?>

<div class="container_mid">
<fieldset class="top">
New Table
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
    init_var($Page_ID[$a]);
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
