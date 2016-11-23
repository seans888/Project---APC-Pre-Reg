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
                $sqlfile = fopen($filename,"ab");
                $d = connect_DB();

                $Project_ID   = $d->escapeString($_SESSION['Project_ID']);
                $Project_Name = $d->escapeString($_SESSION['Project_Name']);

                /* THIS BLOCK WAS COMMENTED OUT AFTER SQLite3 MIGRATION - NOT NEEDED ANYMORE
                //Optimize all tables to make sure they insert in our target machine in the expected order.
                //This is really only absolutely essential for table_fields, but since it is free and might also
                //be relevant in the future, we just optimize all of them.
                $file_contents = 'OPTIMIZE TABLE `project`, `database_connection`, `table`, `table_fields`, `table_fields_list`, '
                                 .'`table_fields_list_source_select`, `table_fields_list_source_where`, `table_pages`, `table_relations`,'
                                 .'`table_fields_predefined_list`, `table_fields_predefined_list_items`;';
                $file_contents .= "\r\n\r\n\r\n";
                fwrite($sqlfile, $file_contents);
                */

                //Project Details
                $file_contents = 'INSERT INTO project(Project_ID, Project_Name, Client_Name, Project_Description, Base_Directory, Database_Connection_ID) VALUES';
                if($stmt = $d->prepare("SELECT Client_Name, Project_Description, Base_Directory, Database_Connection_ID FROM project WHERE Project_ID = :p_id"))
                {
                    $stmt->bindValue(':p_id',$_SESSION['Project_ID']);
                    $result = $stmt->execute();
                    while($row = $result->fetchArray(SQLITE3_NUM))
                    {
                        $client     = $d->escapeString($row[0]);
                        $desc       = $d->escapeString($row[1]);
                        $base_dir   = $d->escapeString($row[2]);
                        $default_db = $d->escapeString($row[3]);

                        $file_contents .= "('" . $Project_ID . "', '" . $Project_Name . "', '" . $client . "', "
                                         . "'" . $desc . "', '" . $base_dir . "', '" . $default_db . "');" . "\r\n";
                    }
                }
                else
                {
                    die("Export query error for `project`: " . $d->lastErrorMsg());
                }
                $stmt->close();
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Database Connections
                $file_contents='';
                if($stmt = $d->prepare("SELECT DB_Connection_ID, DB_Connection_Name, Hostname, Username, Password, \"Database\" FROM database_connection WHERE Project_ID=:p_id"))
                {
                    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
                    $result = $stmt->execute();
                    while($row = $result->fetchArray(SQLITE3_NUM))
                    {
                        $dbc_id   = $d->escapeString($row[0]);
                        $dbc_name = $d->escapeString($row[1]);
                        $host     = $d->escapeString($row[2]);
                        $user     = $d->escapeString($row[3]);
                        $pass     = $d->escapeString($row[4]);
                        $db       = $d->escapeString($row[5]);

                        $file_contents .= 'INSERT INTO database_connection(DB_Connection_ID, Project_ID, DB_Connection_Name, Hostname, Username, Password, "Database") VALUES';
                        $file_contents .= "('" . $dbc_id . "', '" . $Project_ID . "', '" . $dbc_name . "', "
                                         . "'" . $host . "', '" . $user . "', '" . $pass . "','" . $db . "');" . "\r\n";
                    }
                }
                else
                {
                    die("Export query error for `database_connection`: " . $d->lastErrorMsg());
                }
                $stmt->close();
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);


                //Tables
                $file_contents='';
                if($stmt = $d->prepare("SELECT Table_ID, DB_Connection_ID, Table_Name, Remarks FROM \"table\" WHERE Project_ID=:p_id"))
                {
                    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
                    $result = $stmt->execute();
                    while($row = $result->fetchArray(SQLITE3_NUM))
                    {
                        $t_id    = $d->escapeString($row[0]);
                        $dbc_id  = $d->escapeString($row[1]);
                        $t_name  = $d->escapeString($row[2]);
                        $remarks = $d->escapeString($row[3]);

                        $file_contents .= 'INSERT INTO "table"(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks) VALUES';
                        $file_contents .= "('" . $t_id . "', '" . $Project_ID . "', '" . $dbc_id . "', "
                                         . "'" . $t_name . "', '" . $remarks . "');" . "\r\n";
                    }
                }
                else
                {
                    die("Export query error for `table`: " . $d->lastErrorMsg());
                }
                $stmt->close();
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Table Fields
                $file_contents='';
                if($stmt = $d->prepare("SELECT a.Field_ID, a.Table_ID, a.Field_Name, a.Data_Type, a.Nullable, a.Length,
                                               a.Attribute, a.Control_Type, a.Label, a.In_Listview, a.Auto_Increment,
                                               a.Default_Value, a.Required, a.Size, a.Upload_Path, a.Extra, a.Companion,
                                               a.Char_Set_Method, a.Char_Set_Allow_Space, a.Extra_Chars_Allowed,
                                               a.Allow_HTML_Tags, a.Trim_Value, a.Valid_Set, a.Date_Default,
                                               a.Drop_Down_Has_Blank, a.RPT_In_Report, a.RPT_Column_Format,
                                               a.RPT_Column_Alignment, a.RPT_Show_Sum
                                         FROM table_fields a, \"table\" b WHERE a.Table_ID=b.Table_ID AND b.Project_ID=:p_id"))
                {
                    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
                    $result = $stmt->execute();
                    while($row = $result->fetchArray(SQLITE3_NUM))
                    {
                        $f_id      = $d->escapeString($row[0]);
                        $t_id      = $d->escapeString($row[1]);
                        $f_name    = $d->escapeString($row[2]);
                        $data_type = $d->escapeString($row[3]);
                        $null      = $d->escapeString($row[4]);
                        $length    = $d->escapeString($row[5]);
                        $attr      = $d->escapeString($row[6]);
                        $c_type    = $d->escapeString($row[7]);
                        $label     = $d->escapeString($row[8]);
                        $in_lv     = $d->escapeString($row[9]);
                        $auto_inc  = $d->escapeString($row[10]);
                        $def_val  = $d->escapeString($row[11]);
                        $req  = $d->escapeString($row[12]);
                        $size  = $d->escapeString($row[13]);
                        $upath  = $d->escapeString($row[14]);
                        $extra  = $d->escapeString($row[15]);
                        $companion  = $d->escapeString($row[16]);
                        $char_sm = $d->escapeString($row[17]);
                        $char_sas  = $d->escapeString($row[18]);
                        $extra_ca = $d->escapeString($row[19]);
                        $a_html_t  = $d->escapeString($row[20]);
                        $trim_val  = $d->escapeString($row[21]);
                        $v_set  = $d->escapeString($row[22]);
                        $date_def  = $d->escapeString($row[23]);
                        $ddhb = $d->escapeString($row[24]);
                        $rpt_ir = $d->escapeString($row[25]);
                        $rpt_cf  = $d->escapeString($row[26]);
                        $rpt_ca  = $d->escapeString($row[27]);
                        $rpt_ss  = $d->escapeString($row[28]);

                        $file_contents .= 'INSERT INTO table_fields'
                                         .'(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment,
                                           Default_Value, Required, Size, Upload_Path, Extra, Companion, Char_Set_Method, Char_Set_Allow_Space,
                                           Extra_Chars_Allowed, Allow_HTML_Tags, Trim_Value, Valid_Set, Date_Default, Drop_Down_Has_Blank, RPT_In_Report,
                                           RPT_Column_Format, RPT_Column_Alignment, RPT_Show_Sum) VALUES';
                        $file_contents .= "('" . $f_id . "', '" . $t_id . "', '" . $f_name . "', '" . $data_type . "', "
                                         . "'" . $null . "', '" . $length . "', '" . $attr . "', '" . $c_type . "', "
                                         . "'" . $label . "', '" . $in_lv . "', '" . $auto_inc . "', '" . $def_val . "', "
                                         . "'" . $req . "', '" . $size . "', '" . $upath . "', '" . $extra . "', "
                                         . "'" . $companion . "', '" . $char_sm . "', '" . $char_sas . "', '" . $extra_ca . "', "
                                         . "'" . $a_html_t . "', '" . $trim_val . "', '" . $v_set . "', '" . $date_def . "', "
                                         . "'" . $ddhb . "', '" . $rpt_ir. "', '" . $rpt_cf . "', '" . $rpt_ca . "', '" . $rpt_ss . "');" . "\r\n";
                    }
                }
                else
                {
                    die("Export query error for `table_fields`: " . $d->lastErrorMsg());
                }
                $stmt->close();
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);


                //Table Fields List
                $file_contents='';
                if($stmt = $d->prepare("SELECT a.Field_ID, a.List_ID "
                                 ."FROM table_fields_list a, table_fields b, \"table\" c "
                                 ."WHERE a.Field_ID=b.Field_ID AND b.Table_ID=c.Table_ID AND c.Project_ID=:p_id"))
                {
                    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
                    $result = $stmt->execute();
                    while($row = $result->fetchArray(SQLITE3_NUM))
                    {
                        $f_id = $d->escapeString($row[0]);
                        $l_id = $d->escapeString($row[1]);

                        $file_contents .= 'INSERT INTO table_fields_list(Field_ID, List_ID) VALUES';
                        $file_contents .= "('" . $f_id . "', '" . $l_id . "');" . "\r\n";
                    }
                }
                else
                {
                    die("Export query error for `table_fields_list`: " . $d->lastErrorMsg());
                }
                $stmt->close();
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);


                //Table Fields List Source Select
                $file_contents='';
                if($stmt = $d->prepare("SELECT a.Field_ID, a.Auto_ID, a.Select_Field_ID, a.Display "
                                 ."FROM table_fields_list_source_select a, table_fields b, \"table\" c "
                                 ."WHERE a.Field_ID=b.Field_ID AND b.Table_ID=c.Table_ID AND c.Project_ID=:p_id"))
                {
                    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
                    $result = $stmt->execute();
                    while($row = $result->fetchArray(SQLITE3_NUM))
                    {
                        $f_id    = $d->escapeString($row[0]);
                        $auto_id = $d->escapeString($row[1]);
                        $sf_id   = $d->escapeString($row[2]);
                        $display = $d->escapeString($row[3]);

                        $file_contents .= 'INSERT INTO table_fields_list_source_select'
                                         .'(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES';
                        $file_contents .= "('" . $f_id . "', '" . $auto_id . "', '" . $sf_id . "', '" . $display . "');" . "\r\n";
                    }
                }
                else
                {
                    die("Export query error for `table_fields_list_source_select`: " . $d->lastErrorMsg());
                }
                $stmt->close();
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Table Fields List Source Where
                $file_contents='';
                if($stmt = $d->prepare("SELECT a.Field_ID, a.Where_Field_ID, a.Where_Field_Operand, a.Where_Field_Value, a.Where_Field_Connector "
                                 ."FROM table_fields_list_source_where a, table_fields b, \"table\" c "
                                 ."WHERE a.Field_ID=b.Field_ID AND b.Table_ID=c.Table_ID AND c.Project_ID = :p_id"))
                {
                    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
                    $result = $stmt->execute();
                    while($row = $result->fetchArray(SQLITE3_NUM))
                    {
                        $f_id  = $d->escapeString($row[0]);
                        $wf_id = $d->escapeString($row[1]);
                        $wfo   = $d->escapeString($row[2]);
                        $wfv   = $d->escapeString($row[3]);
                        $wfc   = $d->escapeString($row[4]);

                        $file_contents .= 'INSERT INTO table_fields_list_source_where'
                                         .'(Field_ID, Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector) VALUES';
                        $file_contents .= "('" . $f_id . "', '" . $wf_id . "', '" . $wfo . "', '" . $wfv .  "', '" . $wfc  . "');" . "\r\n";
                    }
                }
                else
                {
                    die("Export query error for `table_fields_list_source_where`: " . $d->lastErrorMsg());
                }
                $stmt->close();
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Table Pages
                $file_contents='';
                if($stmt = $d->prepare("SELECT a.Table_ID, a.Page_ID, a.Path_Filename "
                                 ."FROM table_pages a, \"table\" b WHERE a.Table_ID=b.Table_ID AND b.Project_ID = :p_id"))
                {
                    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
                    $result = $stmt->execute();
                    while($row = $result->fetchArray(SQLITE3_NUM))
                    {
                        $t_id   = $d->escapeString($row[0]);
                        $p_id   = $d->escapeString($row[1]);
                        $p_file = $d->escapeString($row[2]);

                        $file_contents .= 'INSERT INTO table_pages'
                                         .'(Table_ID, Page_ID, Path_Filename) VALUES';
                        $file_contents .= "('" . $t_id . "', '" . $p_id . "', '" . $p_file . "');" . "\r\n";
                    }
                }
                else
                {
                    die("Export query error for `table_pages`: " . $d->lastErrorMsg());
                }
                $stmt->close();
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Table Relations
                $file_contents='';
                if($stmt = $d->prepare("SELECT Relation_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext "
                                 ."FROM table_relations WHERE Project_ID = :p_id"))
                {
                    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
                    $result = $stmt->execute();
                    while($row = $result->fetchArray(SQLITE3_NUM))
                    {
                        $r_id     = $d->escapeString($row[0]);
                        $relation = $d->escapeString($row[1]);
                        $pf_id    = $d->escapeString($row[2]);
                        $cf_id    = $d->escapeString($row[3]);
                        $label    = $d->escapeString($row[4]);
                        $cf_sub   = $d->escapeString($row[5]);

                        $file_contents .= 'INSERT INTO table_relations(Relation_ID, Project_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext) VALUES';
                        $file_contents .= "('" . $r_id . "', '" . $Project_ID . "', '" . $relation . "', "
                                         . "'" . $pf_id . "', '" . $cf_id . "', '" . $label . "', '" . $cf_sub . "');" . "\r\n";
                    }
                }
                else
                {
                    die("Export query error for `table_relations`: " . $d->lastErrorMsg());
                }
                $stmt->close();
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Predefined Lists
                $file_contents='';
                if($stmt = $d->prepare("SELECT List_ID, List_Name, Remarks FROM table_fields_predefined_list WHERE Project_ID = :p_id"))
                {
                    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
                    $result = $stmt->execute();
                    while($row = $result->fetchArray(SQLITE3_NUM))
                    {
                        $l_id    = $d->escapeString($row[0]);
                        $l_name  = $d->escapeString($row[1]);
                        $remarks = $d->escapeString($row[2]);

                        $file_contents .= 'INSERT INTO table_fields_predefined_list(List_ID, Project_ID, List_Name, Remarks) VALUES';
                        $file_contents .= "('" . $l_id . "', '" . $Project_ID . "', '" . $l_name . "', '" . $remarks . "');" . "\r\n";
                    }
                }
                else
                {
                    die("Export query error for `table_fields_predefined_list`: " . $d->lastErrorMsg());
                }
                $stmt->close();
                $file_contents .= "\r\n\r\n";
                fwrite($sqlfile, $file_contents);

                //Predefined List Items
                $file_contents='';
                if($stmt = $d->prepare("SELECT a.List_ID, a.Number, a.List_Item "
                                 ."FROM table_fields_predefined_list_items a, table_fields_predefined_list b "
                                 ."WHERE a.List_ID=b.List_ID AND b.Project_ID = :p_id"))
                {
                    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
                    $result = $stmt->execute();
                    while($row = $result->fetchArray(SQLITE3_NUM))
                    {
                        $l_id = $d->escapeString($row[0]);
                        $num  = $d->escapeString($row[1]);
                        $item = $d->escapeString($row[2]);

                        $file_contents .= 'INSERT INTO table_fields_predefined_list_items(List_ID, Number, List_Item) VALUES';
                        $file_contents .= "('" . $l_id . "', '" . $num . "', '" . $item . "');" . "\r\n";
                    }
                }
                else
                {
                    die("Export query error for `table_fields_predefined_list_items`: " . $d->lastErrorMsg());
                }
                $stmt->close();
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
