<?php
require '../Core/SCV2_Core.php';
init_SCV2();

if(isset($_GET['DB_ID']))
{
    //$DB_ID was passed, signalling that redirection came from option after creating the connection.
    //Short-circuit the process to simulate the choosing of this connection and hitting the submit button.

    $_SESSION['formKey'][$_SERVER['PHP_SELF']] ='x';
    $_POST['formKey']='x';
    $_POST['btnSubmit'] = TRUE;
    $_POST['DB_Connection_ID'] = rawurldecode($_GET['DB_ID']);
    $tablesReady=0;
}

$ShowTables=FALSE;

if(xsrf_guard())
{
    init_var($_POST['btnCancel']);
    init_var($_POST['btnSubmit']);

    if($_POST['btnCancel'])
    {
        header("location: ListView_Tables.php");
        exit();
    }

    if($_POST['btnSubmit'])
    {
        extract($_POST);
        $errMsg = scriptCheckIfNull('DB Connection', $DB_Connection_ID);

        //Verify that the DB_Connection_ID supplied is valid for this project
        $d = connect_DB();
        $stmt = $d->prepare("SELECT * FROM database_connection WHERE Project_ID=:p_id AND DB_Connection_ID=:db_id");
        $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
        $stmt->bindValue(':db_id', $DB_Connection_ID);

        $num_rows = 0;
        if($result = $stmt->execute())
        {
            while($row = $result->fetchArray())
            {
                ++$num_rows;
            }
        }
        $stmt->close();

        if($num_rows == 0)
        {
            $errMsg="Invalid database connection supplied. Please specify a valid connection from the drop-down list below";
        }

        if($tablesReady)
        {
            if(!isset($checkbox) || !is_array($checkbox))
            {
                $errMsg = 'No tables were imported.';
            }
        }

        if($errMsg=="")
        {
            //For large systems, default max execution time of PHP may not suffice (particularly on Windows).
            //Bump up max execution time if less than 3 minutes to be extremely safe
            $limit  = ini_get('max_execution_time');
            if($limit < 180)
            {
                ini_set('max_execution_time', '180');
            }

            $time_start = microtime(true);

            //Get the database credentials supplied, establish connection to server.
            $stmt = $d->prepare("SELECT Hostname, Username, Password, Database, DB_Connection_Name FROM database_connection WHERE DB_Connection_ID=:db_id");
            $stmt->bindValue(':db_id', $DB_Connection_ID);
            if($result = $stmt->execute())
            {
                $data = $result->fetchArray();
                extract($data);
            }
            else die('Error getting database credentials: '. $mysqli->error);
            $stmt->close();
            $d->close();

            //...this is where we establish connection to server using retrieved credentials.
            //FIXME: This should be replaced with appropriate data driver call to support multiple databases.
            $mysqli = @new mysqli($Hostname, $Username, $Password, $Database);
            if (mysqli_connect_errno())
            {
                $errMsg = "There seems to be an error in the database connection you specified.";
                drawHeader($errMsg);
                drawPageTitle('Import Tables', 'Cobalt cannot connect to the database using the database credentials specified in the chosen connection.');
                echo '<div class="container_mid">
                      <fieldset class="top">
                      Troubleshooting
                      </fieldset>
                      <fieldset class="middle">
                            To fix this error, try the following:<br /><br />
                            <ul>
                                <li> Go back to Database Connections and verify that you entered the correct
                                     HOSTNAME, DATABASE NAME, USERNAME and PASSWORD. <br><br>
                                <li> Log in to MySQL or phpMyAdmin and verify that the database you entered in
                                     Database Connections exists. <br><br>
                                <li> Also in MySQL/phpMyAdmin, verify that the user you entered in Database
                                     Connections exists.<br><br>
                                <li> Also in MySQL/phpMyAdmin, verify that the password you entered for the connection is
                                     the same password assigned to the user.<br><br>
                             </ul>
                      </table>
                      </fieldset>
                      <fieldset class="bottom">
                      <input type="submit" value="BACK" name="Back">
                      </fieldset>
                      </div>';
                drawFooter();
                die();
            }


            if($tablesReady==FALSE)
            {

                //Now let's get all the tables in the database.
                //NOTE: We should skip tables that are from the Cobalt framework: system_settings, user, user_links, etc.
                $SCV2_tables = array('cobalt_reporter', 'cobalt_sst', 'person','system_log','system_settings','system_skins','user','user_links',
                                      'user_passport','user_passport_groups','user_role','user_role_links');
                $tables_found = array();
                //FIXME: This should be replaced with appropriate data driver call to support multiple databases.
                $mysqli->real_query("SHOW TABLES");
                if($result = $mysqli->store_result())
                {
                    for($a=0; $a<$result->num_rows; $a++)
                    {
                        $data = $result->fetch_row();
                        if(!in_array($data[0], $SCV2_tables)) $tables_found[] = $data[0];
                    }
                    $ShowTables=TRUE;
                }
                else die('Error getting tables: ' . $mysqli->error());
            }
            else
            {
                //Create a new database object, using SCV2 connection.
                //We will use this object to insert records into SCV2 based on retrieved table and field info.
                $d = connect_DB();
                $d->exec("PRAGMA synchronous = OFF"); //performance, since we don't need enterprise-class reliability here

                //Delete existing conflicting tables first before beginning INSERT transaction
                foreach($checkbox as $key=>$current_table)
                {
                    $stmt = $d->prepare("SELECT Table_ID FROM \"table\" WHERE Table_Name = :t_name AND Project_ID = :p_id");
                    $stmt->bindParam(':t_name', $current_table);
                    $stmt->bindParam(':p_id', $_SESSION['Project_ID']);

                    //Check if a table with this name already exists and delete it if it does exist.
                    $result2 = $stmt->execute();
                    $num_rows = 0;
                    if($row = $result2->fetchArray())
                    {
                        ++$num_rows;
                    }
                    $stmt->close();

                    if($num_rows > 0)
                    {
                        queryDeleteTable($row);
                    }
                }

                $d->exec("BEGIN TRANSACTION");

                $stmt_tbl = $d->prepare("INSERT INTO \"table\"(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks)
                                        VALUES(:t_id, :p_id, :db_id, :t_name, '')");
                $stmt_tbl->bindParam(':t_id', $Table_ID);
                $stmt_tbl->bindParam(':p_id', $_SESSION['Project_ID']);
                $stmt_tbl->bindParam(':db_id', $DB_Connection_ID);
                $stmt_tbl->bindParam(':t_name', $current_table);

                $stmt_pages = $d->prepare("INSERT INTO table_pages(Table_ID, Page_ID, Path_Filename)
                                            VALUES(:t_id, :p_id, :p_fname)");
                $stmt_pages->bindParam(':t_id', $Table_ID);
                $stmt_pages->bindParam(':p_id', $Page_ID_param);
                $stmt_pages->bindParam(':p_fname', $P_Fname_param);

                $stmt_fields = $d->prepare("INSERT INTO table_fields(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Auto_Increment, Control_Type, Label, In_Listview,
                                                              Default_Value, Required, Size, Extra, Companion, Char_Set_Method, Char_Set_Allow_Space, Extra_Chars_Allowed,
                                                              Allow_HTML_Tags, Trim_Value, Valid_Set, Date_Default, Drop_Down_Has_Blank, RPT_In_Report, RPT_Column_Format,
                                                              RPT_Column_Alignment, RPT_Show_Sum)
                                        VALUES(:f_id, :t_id, :f_name, :d_type, :nullable, :length, :attrib, :auto, :c_type, :label, :in_lv, :def_val, :req, :size, :extra,
                                               :companion, :char_sm, :char_sas, :extra_ca, :a_html_t, :trim_val, :v_set, :date_def, :ddhb, :rpt_ir, :rpt_cf, :rpt_ca, :rpt_ss)");
                $stmt_fields->bindParam(':f_id', $Field_ID);
                $stmt_fields->bindParam(':t_id', $Table_ID);
                $stmt_fields->bindParam(':f_name', $field_name);
                $stmt_fields->bindParam(':d_type', $data_type);
                $stmt_fields->bindParam(':nullable', $field_null);
                $stmt_fields->bindParam(':length', $length);
                $stmt_fields->bindParam(':attrib', $attribute);
                $stmt_fields->bindParam(':auto', $auto_increment);
                $stmt_fields->bindParam(':c_type', $control_type);
                $stmt_fields->bindParam(':label', $label);
                $stmt_fields->bindParam(':in_lv', $in_listview);
                $stmt_fields->bindParam(':def_val', $Default_Value);
                $stmt_fields->bindParam(':req', $Required);
                $stmt_fields->bindParam(':size', $Size);
                $stmt_fields->bindParam(':extra', $Extra);
                $stmt_fields->bindParam(':companion', $Companion);
                $stmt_fields->bindParam(':char_sm', $Char_Set_Method);
                $stmt_fields->bindParam(':char_sas', $Char_Set_Allow_Space);
                $stmt_fields->bindParam(':extra_ca', $Extra_Chars_Allowed);
                $stmt_fields->bindParam(':a_html_t', $Allow_HTML_Tags);
                $stmt_fields->bindParam(':trim_val', $Trim_Value);
                $stmt_fields->bindParam(':v_set', $Valid_Set);
                $stmt_fields->bindParam(':date_def', $Date_Default);
                $stmt_fields->bindParam(':ddhb', $Drop_Down_Has_Blank);
                $stmt_fields->bindParam(':rpt_ir', $RPT_In_Report);
                $stmt_fields->bindParam(':rpt_cf', $RPT_Column_Format);
                $stmt_fields->bindParam(':rpt_ca', $RPT_Column_Alignment);
                $stmt_fields->bindParam(':rpt_ss', $RPT_Show_Sum);



                foreach($checkbox as $key=>$current_table)
                {

                    //Get new Table_ID
                    $Table_ID = get_token();
                    $stmt_tbl->execute();

                    $add_file = 'add_' . $current_table . '.php';
                    $edit_file = 'edit_' . $current_table . '.php';
                    $detail_file = 'detailview_' . $current_table . '.php';
                    $list_file = 'listview_' . $current_table . '.php';
                    $delete_file = 'delete_' . $current_table . '.php';
                    $CSV_file = 'csv_' . $current_table . '.php';
                    $report_interface_file = 'reporter_' . $current_table . '.php';
                    $report_result_file = 'reporter_result_' . $current_table . '.php';
                    $report_result_pdf_file = 'reporter_pdfresult_' . $current_table . '.php';

                    if($folder[$key] != '')
                    {
                        $add_file               = trim($folder[$key]) . '/' . $add_file;
                        $edit_file              = trim($folder[$key]) . '/' . $edit_file;
                        $detail_file            = trim($folder[$key]) . '/' . $detail_file;
                        $list_file              = trim($folder[$key]) . '/' . $list_file;
                        $delete_file            = trim($folder[$key]) . '/' . $delete_file;
                        $CSV_file               = trim($folder[$key]) . '/' . $CSV_file;
                        $report_interface_file  = trim($folder[$key]) . '/' . $report_interface_file;
                        $report_result_file     = trim($folder[$key]) . '/' . $report_result_file;
                        $report_result_pdf_file = trim($folder[$key]) . '/' . $report_result_pdf_file;
                    }

                    $Page_ID_param = '+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=';
                    $P_Fname_param = $add_file;
                    $stmt_pages->execute();

                    $Page_ID_param = 'alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=';
                    $P_Fname_param = $edit_file;
                    $stmt_pages->execute();

                    $Page_ID_param = 'AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=';
                    $P_Fname_param = $detail_file;
                    $stmt_pages->execute();

                    $Page_ID_param = 'Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=';
                    $P_Fname_param = $list_file;
                    $stmt_pages->execute();

                    $Page_ID_param = 'qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=';
                    $P_Fname_param = $delete_file;
                    $stmt_pages->execute();

                    $Page_ID_param = 'DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=';
                    $P_Fname_param = $CSV_file;
                    $stmt_pages->execute();

                    $Page_ID_param = 'X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=';
                    $P_Fname_param = $report_interface_file;
                    $stmt_pages->execute();

                    $Page_ID_param = '/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=';
                    $P_Fname_param = $report_result_file;
                    $stmt_pages->execute();

                    $Page_ID_param = 'EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=';
                    $P_Fname_param = $report_result_pdf_file;
                    $stmt_pages->execute();

                    $mysqli->real_query("SHOW COLUMNS FROM `$current_table`");
                    if($result2 = $mysqli->store_result())
                    {
                        //IMPORTER METADATA INTERPRETATION SCRIPT ***************************
                        $listview_counter = 0;
                        for($b=0; $b<$result2->num_rows; $b++)
                        {
                            $data = $result2->fetch_assoc();
                            $field_name  = $data['Field'];
                            $field_type  = $data['Type'];
                            $field_key   = $data['Key'];
                            $field_extra = $data['Extra'];
                            $field_null  = $data['Null'];
                            if($field_null == 'NO') $field_null = 'FALSE';
                            elseif($field_null == 'YES') $field_null = 'TRUE';


                            $Default_Value = '';
                            $Required = 'TRUE';
                            $Size = '';
                            $Extra = '';
                            $Companion = '';
                            $Char_Set_Method = '';
                            $Char_Set_Allow_Space = 'TRUE';
                            $Extra_Chars_Allowed = '';
                            $Allow_HTML_Tags = 'FALSE';
                            $Trim_Value = 'trim';
                            $Valid_Set = '';
                            $Date_Default = '';
                            $Drop_Down_Has_Blank = 'TRUE';
                            $RPT_In_Report = 'TRUE';
                            $RPT_Column_Format = 'normal';
                            $RPT_Column_Alignment = 'left';
                            $RPT_Show_Sum = 'FALSE';

                            $control_type = '';
                            $no_parentheses = array('double','float','date','text','tinytext','mediumtext','longtext');
                            if(!in_array($field_type, $no_parentheses))
                            {
                                $x = strpos($field_type, '(');
                                $y = strpos($field_type, ')');
                                if($x>0)
                                {
                                    $data_type = substr($field_type, 0, $x);
                                    if($data_type != 'enum') $length = substr($field_type, $x+1, $y-$x-1);
                                    else $length = '255';
                                }
                                else
                                {
                                    $errMsg .= "Currently unsupported data type has been used: '$field_type' for `$field_name` in table `$current_table`. This has been ignored and replaced with Varchar(255). <br>";
                                    $data_type = 'varchar';
                                    $length = '255';
                                }
                            }
                            else
                            {
                                $data_type = $field_type;
                                $length = 0;
                            }

                            $control_type='textbox';
                            switch($data_type)
                            {
                                case 'binary'       :
                                case 'varbinary'    : $data_type = 'binary'; break;

                                case 'tinyint'      :
                                case 'mediumint'    :
                                case 'bigint'       :
                                case 'int'          : $data_type               = 'integer';
                                                      $length                  = '20';
                                                      $Char_Set_Method         = 'generate_num_set';
                                                      $Extra_Chars_Allowed     = '-';
                                                      $Char_Set_Allow_Space    = 'FALSE';
                                                      $RPT_Column_Format       = 'number_format2';
                                                      $RPT_Column_Alignment    = 'right';
                                                      $RPT_Show_Sum            = 'TRUE';
                                                      break;

                                case 'enum'         :
                                case 'char'         :
                                case 'varchar'      : $data_type = 'varchar'; break;

                                case 'bool'         : $data_type = 'bool'; break;

                                case 'double'       :
                                case 'float'        : $data_type               = 'double or float';
                                                      $length                  = '20';
                                                      $Char_Set_Method         = 'generate_num_set';
                                                      $Extra_Chars_Allowed     = '- . ,';
                                                      $Char_Set_Allow_Space    = 'FALSE';
                                                      $RPT_Column_Format       = 'number_format2';
                                                      $RPT_Column_Alignment    = 'right';
                                                      $RPT_Show_Sum            = 'TRUE';
                                                      break;

                                case 'decimal'      : $length                  = '20';
                                                      $Char_Set_Method         = 'generate_num_set';
                                                      $Extra_Chars_Allowed     = '. ,'; //mysql doesn't accept (-) character if decimal
                                                      $Char_Set_Allow_Space    = 'FALSE';
                                                      $RPT_Column_Format       = 'number_format2';
                                                      $RPT_Column_Alignment    = 'right';
                                                      $RPT_Show_Sum            = 'TRUE';
                                                      break;

                                case 'text'         :
                                case 'tinytext'     :
                                case 'mediumtext'   :
                                case 'longtext'     : $data_type = 'text';
                                                      $control_type = 'textarea';
                                                      break;

                                case 'date'         : $control_type = 'date controls'; break;

                                default:
                            }

                            //Some field names are to be interpreted as needing a textarea
                            $textareaFieldNames = get_textarea_field_names();
                            if(in_array(strtoupper($field_name), $textareaFieldNames))
                            {
                                $control_type = 'textarea';
                            }

                            if($control_type == 'textbox')
                            {
                                $Size = '60';

                                if($data_type == 'decimal')
                                {
                                    $Size = '20';
                                }
                                elseif($data_type == 'year')
                                {
                                    $Size = '4';
                                }
                            }
                            elseif($control_type == 'textarea')
                            {
                                $Size = '58;5';
                            }

                            $in_listview = 'TRUE'; //this is the default, might be changed by some conditions found below
                            if(strtoupper($field_name) == 'ID')
                            {
                                $label = 'ID';
                            }
                            else
                            {
                                $label = str_replace('_',' ',$field_name);
                                $label = ucwords($label);

                                //if field contains "Id" as a word somewhere in the middle, change to "ID"
                                $label = str_replace(' Id ',' ID ', $label);
                                if(substr($label,0,3) == 'Id ')
                                {
                                    //Field name starts with 'Id', change to 'ID ' (e.g., field name was originally "id_number")
                                    $label = 'ID ' . substr($label, 3);
                                }
                                if(substr($label, strlen($label) -3) == ' Id')
                                {
                                    //Field name ends with 'Id', change to ' ID' (e.g., field name was originally "employee_id")
                                    $label = substr($label, 0, strlen($label) -3) . ' ID';
                                }
                            }

                            //rpt column settings override: 'ID' fields of any sort (i.e., fields named like 'id', 'emp_id', 'id_number', etc)
                            //should be explicitly set to normal format (just in case their data type is int) and center alignment, and no sum.
                            if(strpos($label, 'ID') !== FALSE)
                            {
                                $RPT_Column_Format    = 'normal';
                                $RPT_Column_Alignment = 'center';
                            }

                            if($field_key=="PRI") $attribute = 'primary key';
                            else $attribute = '';

                            $auto_increment = 'FALSE';
                            if($field_extra == 'auto_increment')
                            {
                                $control_type='none';
                                $in_listview = 'FALSE';
                                $auto_increment = 'TRUE';
                                $Required = 'FALSE';
                            }

                            if($listview_counter > 6)
                            {
                                $in_listview = 'FALSE';
                            }

                            if($in_listview == 'TRUE')
                            {
                                ++$listview_counter;
                            }


                            //Get new Field_ID
                            $Field_ID = get_token();
                            $stmt_fields->execute();
                        }
                    }
                    else die('Error getting columns of table: ' . $mysqli->error());
                }
                $d->exec("END TRANSACTION");
                $time_end = microtime(true);
                $process_time = $time_end - $time_start;

                //Draw success page.
                drawHeader();
                drawPageTitle('Successfully Imported Tables',
                              '<br>Cobalt successfully imported the tables you have chosen.
                               The process took ' . number_format($process_time,5,'.',',') .
                               ' seconds.<br><br>
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                               <input type=submit name=BACK value=BACK>', 'system');
                if($errMsg != '')
                {
                    displayInfo('<b>Table Import Notes:</b> <br />' . $errMsg);
                }
                drawFooter();
                die();
            }
        }
    }
}

drawHeader();
if($errMsg=='')
{
    $errMsg ='Cobalt will import all tables it can find using the database connection you specify.';
    $msgType = 'info';
}
drawPageTitle('Import Tables', $errMsg, $msgType);
?>

<script language="JavaScript" type="text/JavaScript">
function checkAll()
{

    var checkboxes = document.getElementsByTagName('input');
    for (var i = 0; i < checkboxes.length; i++)
    {
        if (checkboxes[i].type == 'checkbox')
        {
            checkboxes[i].checked = true;
        }
    }


}
function uncheckAll()
{
    var checkboxes = document.getElementsByTagName('input');
    for (var i = 0; i < checkboxes.length; i++)
    {
        if (checkboxes[i].type == 'checkbox')
        {
            checkboxes[i].checked = false;
        }
    }
}


</script>

<?php
if($ShowTables==FALSE)
{
    displayTip('Cobalt can handle multiple databases. <br />Add as many Database Connections pointing to different
                databases as you need and import all of their tables here, one connection at a time.');

    ?>
    <div class="container_mid">
    <fieldset class="top">
    Import Tables
    </fieldset>

    <fieldset class="middle">
    <table class="input_form">
    <?php
    drawSelectField('drawDBConnection', 'DB Connection', 'DB_Connection_ID');
    echo '<input type="hidden" name="tablesReady" value="0">';
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
}
else
{
    echo '<input type="hidden" name="tablesReady" value="1">';
    echo '<input type="hidden" name="DB_Connection_ID" value="' . $DB_Connection_ID . '">';
    ?>
    <div class="container_mid_huge">
    <fieldset class="container">
        <fieldset class="top">
        Import Tables
        </fieldset>

        <fieldset class="middle">
        <table width="100%" border="1" class="listView">
        <?php
            echo '<tr><td colspan="2">
                        <input type=submit name=BACK value=BACK class=button1>
                        <input type=button name=CHECK value="CHECK ALL" class=button1 onClick=\'checkAll();\'>
                        <input type=button name=UNCHECK value="UNCHECK ALL" class=button1 onClick=\'uncheckAll();\'>
                      </td></tr>';
            echo '<tr class="listRowHead"><td> Table </td><td> Folder / Subdirectory </td></tr>';
            for($a=0; $a<count($tables_found); $a++)
            {
                if($a%2==0) $class='listRowEven';
                else $class='listRowOdd';
                echo "<tr class=\"$class\">
                        <td>
                            <label style=\"display: block;\" for='checkfield[$a]'>
                                <input type=\"checkbox\" ID='checkfield[$a]' name='checkbox[$a]' value='$tables_found[$a]' checked>$tables_found[$a]
                            </label>
                        </td>
                        <td>";
                drawTextField(' ', "folder[$a]", FALSE, 'text', FALSE);
                echo '</td></tr>' . "\n";
            }
        ?>
        </table>
       </fieldset>
        <fieldset class="bottom">
        <?php
        drawSubmitCancel();
        ?>
        </fieldset>

    </fieldset>
    <br>
    </div>
    <?php
}
?>

<?php
drawFooter();
