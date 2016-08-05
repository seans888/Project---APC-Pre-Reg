<?php
require '../Core/SCV2_Core.php';
init_SCV2();

$export_status='';
if(isset($_GET['First_Run']))
{
    $Export_Name = $_SESSION['Project_Name'] . '_' . date('Y-m-d_His');
    $export_status='first run';
}

if(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header("location: " . HOME_PAGE);
        exit();
    }

    if($_POST['btnSubmit'])
    {
        extract($_POST);
        init_var($Database_Connection_ID);
        $errMsg = scriptCheckIfNull('Export Name', $Export_Name);

        if($errMsg=="")
        {
            $export_dir = FULLPATH_CORE . '../' . EXPORT_DIRECTORY;
            if(is_writable($export_dir))
            {
                $file_contents='';
                $filename = $export_dir . '/' . $Export_Name . '.sql';
                if(file_exists($filename)) unlink($filename);
                $sqlfile=fopen($filename,"ab");
                $mysqli = connect_DB();

                $Project_ID   = $mysqli->real_escape_string($_SESSION['Project_ID']);
                $Project_Name = $mysqli->real_escape_string($_SESSION['Project_Name']);


                //Optimize all tables to make sure they insert in our target machine in the expected order.
                //This is really only absolutely essential for table_fields, but since it is free and might also
                //be relevant in the future, we just optimize all of them.
                $file_contents = 'OPTIMIZE TABLE `project`, `database_connection`, `table`, `table_fields`, `table_fields_list`, '
                                 .'`table_fields_list_source_select`, `table_fields_list_source_where`, `table_pages`, `table_relations`,'
                                 .'`table_fields_predefined_list`, `table_fields_predefined_list_items`;';

                $file_contents .= "\r\n\r\n\r\n";
                fwrite($sqlfile, $file_contents);


                //Project Details
                $file_contents = 'INSERT INTO `project`(Project_ID, Project_Name, Client_Name, Project_Description, Base_Directory, Database_Connection_ID) VALUES';
                $stmt =  $mysqli->stmt_init();
                if($stmt->prepare("SELECT Client_Name, Project_Description, Base_Directory, Database_Connection_ID FROM project WHERE Project_ID=?"))
                {
                    $stmt->bind_param('s', $_SESSION['Project_ID']);
                    $stmt->execute();
                    $stmt->bind_result($client, $desc, $base_dir, $default_db);
                    while($stmt->fetch())
                    {
                        $client = $mysqli->real_escape_string($client);
                        $desc = $mysqli->real_escape_string($desc);
                        $base_dir = $mysqli->real_escape_string($base_dir);
                        $default_db = $mysqli->real_escape_string($default_db);

                        $file_contents .= "('" . $Project_ID . "', '" . $Project_Name . "', '" . $client . "', "
                                         . "'" . $desc . "', '" . $base_dir . "', '" . $default_db . "');" . "\r\n";
                    }
                    $stmt->close();
                }
                else
                {
                    die("Export query error for `project`: " . $stmt->error);
                }
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Database Connections
                $file_contents='';
                $stmt =  $mysqli->stmt_init();
                if($stmt->prepare("SELECT DB_Connection_ID, DB_Connection_Name, Hostname, Username, Password, `Database` FROM database_connection WHERE Project_ID=?"))
                {
                    $stmt->bind_param('s', $_SESSION['Project_ID']);
                    $stmt->execute();
                    $stmt->bind_result($dbc_id, $dbc_name, $host, $user, $pass, $db);
                    while($stmt->fetch())
                    {
                        $dbc_id = $mysqli->real_escape_string($dbc_id);
                        $dbc_name = $mysqli->real_escape_string($dbc_name);
                        $host = $mysqli->real_escape_string($host);
                        $user = $mysqli->real_escape_string($user);
                        $pass = $mysqli->real_escape_string($pass);
                        $db = $mysqli->real_escape_string($db);

                        $file_contents .= 'INSERT INTO `database_connection`(DB_Connection_ID, Project_ID, DB_Connection_Name, Hostname, Username, Password, `Database`) VALUES';
                        $file_contents .= "('" . $dbc_id . "', '" . $Project_ID . "', '" . $dbc_name . "', "
                                         . "'" . $host . "', '" . $user . "', '" . $pass . "','" . $db . "');" . "\r\n";
                    }
                    $stmt->close();
                }
                else
                {
                    die("Export query error for `database_connection`: " . $stmt->error);
                }
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);


                //Tables
                $file_contents='';
                $stmt =  $mysqli->stmt_init();
                if($stmt->prepare("SELECT Table_ID, DB_Connection_ID, Table_Name, Remarks FROM `table` WHERE Project_ID=?"))
                {
                    $stmt->bind_param('s', $_SESSION['Project_ID']);
                    $stmt->execute();
                    $stmt->bind_result($t_id, $dbc_id, $t_name, $remarks);
                    while($stmt->fetch())
                    {
                        $t_id = $mysqli->real_escape_string($t_id);
                        $dbc_id = $mysqli->real_escape_string($dbc_id);
                        $t_name = $mysqli->real_escape_string($t_name);
                        $remarks = $mysqli->real_escape_string($remarks);

                        $file_contents .= 'INSERT INTO `table`(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks) VALUES';
                        $file_contents .= "('" . $t_id . "', '" . $Project_ID . "', '" . $dbc_id . "', "
                                         . "'" . $t_name . "', '" . $remarks . "');" . "\r\n";
                    }
                    $stmt->close();
                }
                else
                {
                    die("Export query error for `table`: " . $stmt->error);
                }
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Table Fields
                $file_contents='';
                $stmt =  $mysqli->stmt_init();
                if($stmt->prepare("SELECT a.Field_ID, a.Table_ID, a.`Field_Name`, a.`Data_Type`, a.`Nullable`, a.`Length`, a.`Attribute`, a.Control_Type, a.`Label`, a.In_Listview, a.Auto_Increment "
                                 ."FROM `table_fields` a, `table` b WHERE a.Table_ID=b.Table_ID AND b.Project_ID=?"))
                {
                    $stmt->bind_param('s', $_SESSION['Project_ID']);
                    $stmt->execute();
                    $stmt->bind_result($f_id, $t_id, $f_name, $data_type, $null, $length, $attr, $c_type, $label, $in_lv, $auto_inc);
                    while($stmt->fetch())
                    {
                        $f_id = $mysqli->real_escape_string($f_id);
                        $t_id = $mysqli->real_escape_string($t_id);
                        $f_name = $mysqli->real_escape_string($f_name);
                        $data_type = $mysqli->real_escape_string($data_type);
                        $null = $mysqli->real_escape_string($null);
                        $length = $mysqli->real_escape_string($length);
                        $attr = $mysqli->real_escape_string($attr);
                        $c_type = $mysqli->real_escape_string($c_type);
                        $label = $mysqli->real_escape_string($label);
                        $in_lv = $mysqli->real_escape_string($in_lv);
                        $auto_inc = $mysqli->real_escape_string($auto_inc);

                        $file_contents .= 'INSERT INTO `table_fields`'
                                         .'(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES';
                        $file_contents .= "('" . $f_id . "', '" . $t_id . "', '" . $f_name . "', '" . $data_type . "', "
                                         . "'" . $null . "', '" . $length . "', '" . $attr . "', '" . $c_type . "', "
                                         . "'" . $label . "', '" . $in_lv . "', '" . $auto_inc . "');" . "\r\n";
                    }
                    $stmt->close();
                }
                else
                {
                    die("Export query error for `table_fields`: " . $stmt->error);
                }
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);


                //Table Fields List
                $file_contents='';
                $stmt =  $mysqli->stmt_init();
                if($stmt->prepare("SELECT a.Field_ID, a.List_ID "
                                 ."FROM `table_fields_list` a, `table_fields` b, `table` c "
                                 ."WHERE a.Field_ID=b.Field_ID AND b.Table_ID=c.Table_ID AND c.Project_ID=?"))
                {
                    $stmt->bind_param('s', $_SESSION['Project_ID']);
                    $stmt->execute();
                    $stmt->bind_result($f_id, $l_id);
                    while($stmt->fetch())
                    {
                        $f_id = $mysqli->real_escape_string($f_id);
                        $l_id = $mysqli->real_escape_string($l_id);

                        $file_contents .= 'INSERT INTO `table_fields_list`(Field_ID, List_ID) VALUES';
                        $file_contents .= "('" . $f_id . "', '" . $l_id . "');" . "\r\n";
                    }
                    $stmt->close();
                }
                else
                {
                    die("Export query error for `table_fields_list`: " . $stmt->error);
                }
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);


                //Table Fields List Source Select
                $file_contents='';
                $stmt =  $mysqli->stmt_init();
                if($stmt->prepare("SELECT a.Field_ID, a.Auto_ID, a.Select_Field_ID, a.Display "
                                 ."FROM `table_fields_list_source_select` a, `table_fields` b, `table` c "
                                 ."WHERE a.Field_ID=b.Field_ID AND b.Table_ID=c.Table_ID AND c.Project_ID=?"))
                {
                    $stmt->bind_param('s', $_SESSION['Project_ID']);
                    $stmt->execute();
                    $stmt->bind_result($f_id, $auto_id, $sf_id, $display);
                    while($stmt->fetch())
                    {
                        $f_id = $mysqli->real_escape_string($f_id);
                        $auto_id = $mysqli->real_escape_string($auto_id);
                        $sf_id = $mysqli->real_escape_string($sf_id);
                        $display = $mysqli->real_escape_string($display);

                        $file_contents .= 'INSERT INTO `table_fields_list_source_select`'
                                         .'(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES';
                        $file_contents .= "('" . $f_id . "', '" . $auto_id . "', '" . $sf_id . "', '" . $display . "');" . "\r\n";
                    }
                    $stmt->close();
                }
                else
                {
                    die("Export query error for `table_fields_list_source_select`: " . $stmt->error);
                }
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Table Fields List Source Where
                $file_contents='';
                $stmt =  $mysqli->stmt_init();
                if($stmt->prepare("SELECT a.Field_ID, a.Where_Field_ID, a.Where_Field_Operand, a.Where_Field_Value, a.Where_Field_Connector "
                                 ."FROM `table_fields_list_source_where` a, `table_fields` b, `table` c "
                                 ."WHERE a.Field_ID=b.Field_ID AND b.Table_ID=c.Table_ID AND c.Project_ID=?"))
                {
                    $stmt->bind_param('s', $_SESSION['Project_ID']);
                    $stmt->execute();
                    $stmt->bind_result($f_id, $wf_id, $wfo, $wfv, $wfc);
                    while($stmt->fetch())
                    {
                        $f_id = $mysqli->real_escape_string($f_id);
                        $wf_id = $mysqli->real_escape_string($wf_id);
                        $wfo = $mysqli->real_escape_string($wfo);
                        $wfv = $mysqli->real_escape_string($wfv);
                        $wfc = $mysqli->real_escape_string($wfc);

                        $file_contents .= 'INSERT INTO `table_fields_list_source_where`'
                                         .'(Field_ID, Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector) VALUES';
                        $file_contents .= "('" . $f_id . "', '" . $wf_id . "', '" . $wfo . "', '" . $wfv .  "', '" . $wfc  . "');" . "\r\n";
                    }
                    $stmt->close();
                }
                else
                {
                    die("Export query error for `table_fields_list_source_where`: " . $stmt->error);
                }
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Table Pages
                $file_contents='';
                $stmt =  $mysqli->stmt_init();
                if($stmt->prepare("SELECT a.Table_ID, a.Page_ID, a.`Path_Filename` "
                                 ."FROM `table_pages` a, `table` b WHERE a.Table_ID=b.Table_ID AND b.Project_ID=?"))
                {
                    $stmt->bind_param('s', $_SESSION['Project_ID']);
                    $stmt->execute();
                    $stmt->bind_result($t_id, $p_id, $path_filename);
                    while($stmt->fetch())
                    {
                        $t_id = $mysqli->real_escape_string($t_id);
                        $p_id = $mysqli->real_escape_string($p_id);
                        $path_filename = $mysqli->real_escape_string($path_filename);

                        $file_contents .= 'INSERT INTO `table_pages`'
                                         .'(Table_ID, Page_ID, Path_Filename) VALUES';
                        $file_contents .= "('" . $t_id . "', '" . $p_id . "', '" . $path_filename . "');" . "\r\n";
                    }
                    $stmt->close();
                }
                else
                {
                    die("Export query error for `table_pages`: " . $stmt->error);
                }
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Table Relations
                $file_contents='';
                $stmt =  $mysqli->stmt_init();
                if($stmt->prepare("SELECT Relation_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext "
                                 ."FROM `table_relations` WHERE Project_ID=?"))
                {
                    $stmt->bind_param('s', $_SESSION['Project_ID']);
                    $stmt->execute();
                    $stmt->bind_result($r_id, $relation, $pf_id, $cf_id, $label, $cf_sub);
                    while($stmt->fetch())
                    {
                        $r_id = $mysqli->real_escape_string($r_id);
                        $relation = $mysqli->real_escape_string($relation);
                        $pf_id = $mysqli->real_escape_string($pf_id);
                        $cf_id = $mysqli->real_escape_string($cf_id);
                        $label = $mysqli->real_escape_string($label);
                        $cf_sub = $mysqli->real_escape_string($cf_sub);

                        $file_contents .= 'INSERT INTO `table_relations`(Relation_ID, Project_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext) VALUES';
                        $file_contents .= "('" . $r_id . "', '" . $Project_ID . "', '" . $relation . "', "
                                         . "'" . $pf_id . "', '" . $cf_id . "', '" . $label . "', '" . $cf_sub . "');" . "\r\n";
                    }
                    $stmt->close();
                }
                else
                {
                    die("Export query error for `table_relations`: " . $stmt->error);
                }
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Predefined Lists
                $file_contents='';
                $stmt =  $mysqli->stmt_init();
                if($stmt->prepare("SELECT List_ID, List_Name, Remarks "
                                 ."FROM `table_fields_predefined_list` WHERE Project_ID=?"))
                {
                    $stmt->bind_param('s', $_SESSION['Project_ID']);
                    $stmt->execute();
                    $stmt->bind_result($l_id, $l_name, $remarks);
                    while($stmt->fetch())
                    {
                        $l_id = $mysqli->real_escape_string($l_id);
                        $l_name = $mysqli->real_escape_string($l_name);
                        $remarks = $mysqli->real_escape_string($remarks);

                        $file_contents .= 'INSERT INTO `table_fields_predefined_list`(List_ID, Project_ID, List_Name, Remarks) VALUES';
                        $file_contents .= "('" . $l_id . "', '" . $Project_ID . "', '" . $l_name . "', "
                                         . "'" . $remarks . "');" . "\r\n";
                    }
                    $stmt->close();
                }
                else
                {
                    die("Export query error for `table_fields_predefined_list`: " . $stmt->error);
                }
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Predefined List Items
                $file_contents='';
                $stmt =  $mysqli->stmt_init();
                if($stmt->prepare("SELECT a.List_ID, a.Number, a.List_Item "
                                 ."FROM `table_fields_predefined_list_items` a, `table_fields_predefined_list` b "
                                 ."WHERE a.List_ID=b.List_ID AND b.Project_ID=?"))
                {
                    $stmt->bind_param('s', $_SESSION['Project_ID']);
                    $stmt->execute();
                    $stmt->bind_result($l_id, $num, $item);
                    while($stmt->fetch())
                    {
                        $l_id = $mysqli->real_escape_string($l_id);
                        $num = $mysqli->real_escape_string($num);
                        $item = $mysqli->real_escape_string($item);

                        $file_contents .= 'INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES';
                        $file_contents .= "('" . $l_id . "', '" . $num . "', '" . $item . "');" . "\r\n";
                    }
                    $stmt->close();
                }
                else
                {
                    die("Export query error for `table_fields_predefined_list_items`: " . $stmt->error);
                }
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);


                chmod($filename, 0777);

                $export_status = 'success';
            }
            else
            {
                $errMsg = 'The "Exports" directory (cobalt/Exports) is not writeable. <br />Please make this directory writeable to proceed.';
            }
        }
    }
}

drawHeader();
drawPageTitle('Export Project',$errMsg);

if($export_status=='success')
{
    displayMessage('Success! The SQL file can be found in the Exports directory (cobalt/Exports).');
}
elseif($export_status=='first run')
{
    displayTip('Export Project creates an SQL file that you can use to copy or transfer your project to another machine. '
              .'<br>You can also use this feature to back up this project to a separate location');
}


?>
<div class="container_mid_large">
<fieldset class="top">
Export Project as SQL File
</fieldset>
<fieldset class="middle">
<table class="input_form" width="92%">
<?php
drawTextField('Filename (SQL file)', 'Export_Name', FALSE, 'text', TRUE, FALSE, 0, 'size="40"');
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
drawFooter(); ?>
