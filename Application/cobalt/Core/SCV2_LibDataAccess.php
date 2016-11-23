<?php
/*
 * SCV2_LibDataAccess.php
 * FRIDAY, November 28, 2006
 * Updated for SQLite3: March 19, 2016
 * JV Roig
 */

function connect_DB()
{
    $path = dirname(__FILE__)  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'metadata' . DIRECTORY_SEPARATOR;
    $d = new SQLite3($path . 'cobalt.db');
    return $d;
}

function cobalt_tables_self_check()
{
    connect_DB()->exec("SELECT * FROM database_connection") or trigger_error('MISSING TABLE: database_connection', E_USER_ERROR);
    connect_DB()->exec("SELECT * FROM page") or trigger_error('MISSING TABLE: page', E_USER_ERROR);
    connect_DB()->exec("SELECT * FROM project") or trigger_error('MISSING TABLE: project', E_USER_ERROR);
    connect_DB()->exec("SELECT * FROM `table`") or trigger_error('MISSING TABLE: table', E_USER_ERROR);
    connect_DB()->exec("SELECT * FROM table_fields") or trigger_error('MISSING TABLE: table_fields', E_USER_ERROR);
    //connect_DB()->exec("SELECT * FROM table_fields_book_list") or trigger_error('MISSING TABLE: table_fields_book_list', E_USER_ERROR);
    connect_DB()->exec("SELECT * FROM table_fields_list") or trigger_error('MISSING TABLE: table_fields_list', E_USER_ERROR);
    connect_DB()->exec("SELECT * FROM table_fields_list_source_select") or trigger_error('MISSING TABLE: table_fields_list_source_select', E_USER_ERROR);
    connect_DB()->exec("SELECT * FROM table_fields_list_source_where") or trigger_error('MISSING TABLE: table_fields_list_source_where', E_USER_ERROR);
    connect_DB()->exec("SELECT * FROM table_fields_predefined_list") or trigger_error('MISSING TABLE: table_fields_predefined_list', E_USER_ERROR);
    connect_DB()->exec("SELECT * FROM table_fields_predefined_list_items") or trigger_error('MISSING TABLE: table_fields_predefined_list_items', E_USER_ERROR);
    //connect_DB()->exec("SELECT * FROM table_fields_secondary_validation") or trigger_error('MISSING TABLE: table_fields_secondary_validation', E_USER_ERROR);
    connect_DB()->exec("SELECT * FROM table_pages") or trigger_error('MISSING TABLE: table_pages', E_USER_ERROR);
    connect_DB()->exec("SELECT * FROM table_relations") or trigger_error('MISSING TABLE: table_relations', E_USER_ERROR);
}

function recursive_trim(&$param)
{
    if(is_array($param))
    {
        foreach($param as $key=>$data)
        {
            if(is_array($data))
            {
                recursive_trim($data);
            }
            else
            {
                $param[$key] = trim($data);
            }
        }
    }
}

function queryProjectName($Project_ID)
{
    $d = connect_DB();
    $project_name = $d->querySingle("SELECT Project_Name FROM project WHERE Project_ID='$Project_ID'");
    return $project_name;
}

function queryCreateNewProject($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    //get new Project_ID
    $Project_ID = get_token();

    // create a prepared statement
    $stmt = $d->prepare("INSERT INTO project(Project_ID, Project_Name, Client_Name, Project_Description, Base_Directory)
                            VALUES (:project_id, :project_name, :client_name, :description, :base_dir)");
    $stmt->bindValue(':project_id',$Project_ID);
    $stmt->bindValue(':project_name',$Project_Name);
    $stmt->bindValue(':client_name',$Client_Name);
    $stmt->bindValue(':description',$Project_Description);
    $stmt->bindValue(':base_dir',$Base_Directory);
    if($stmt->execute())
    {
        $_SESSION['Project_Name'] = $Project_Name;
        $_SESSION['Project_ID']   = $Project_ID;
    }
    else die("Failed to create new project.");
}

function queryCreateDBConnection($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    //get new Database_Connection_ID
    $DB_ID = get_token();

    $stmt = $d->prepare('INSERT INTO database_connection(Project_ID, DB_Connection_ID, DB_Connection_Name, Hostname, Username, Password, "Database")
                            VALUES(:project_id, :db_con_id, :db_con_name, :hostname, :username, :password, :database)');
    $stmt->bindValue(':project_id', $Project_ID);
    $stmt->bindValue(':db_con_id', $DB_ID);
    $stmt->bindValue(':db_con_name', $DB_Connection_Name);
    $stmt->bindValue(':hostname', $Hostname);
    $stmt->bindValue(':username', $Username);
    $stmt->bindValue(':password', $Password);
    $stmt->bindValue(':database', $Database);
    $stmt->execute() or die("Failed to create database connection.");

    if($Default_Connection == 'Yes')
    {
        $stmt = $d->prepare("UPDATE project SET Database_Connection_ID=:db_con_id WHERE Project_ID=:project_id");
        $stmt->bindValue(':db_con_id',$DB_ID);
        $stmt->bindValue(':project_id', $Project_ID);
        $stmt->execute() or die("Failed to set default database connection.");
    }

    return $DB_ID;
}

function queryCreatePage($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    $Page_ID = get_token();

    $stmt = $d->prepare('INSERT INTO page(Page_ID, Page_Name, Generator, Description)
                            VALUES(:p_id, :p_name, :gen, :description)');
    $stmt->bindValue(':p_id', $Page_ID);
    $stmt->bindValue(':p_name', $Page_Name);
    $stmt->bindValue(':gen', $Generator);
    $stmt->bindValue(':description', $Description);
    $stmt->execute() or die('Failed to create page.');
}

function queryCreatePredefinedList($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    //get new List_ID
    $List_ID = get_token();

    $numItems = count($List_Item);

    $stmt = $d->prepare('INSERT INTO table_fields_predefined_list(List_ID, Project_ID, List_Name, Remarks)
                            VALUES(:list_id, :proj_id, :list_name, :remarks)');
    $stmt->bindValue(':list_id', $List_ID);
    $stmt->bindValue(':proj_id', $_SESSION['Project_ID']);
    $stmt->bindValue(':list_name', $List_Name);
    $stmt->bindValue(':remarks', $Remarks);
    $stmt->execute() or die('Failed to create predefined list.');

    $stmt = $d->prepare('INSERT INTO table_fields_predefined_list_items(List_ID, Number, List_Item)
                            VALUES(:list_id, :num, :item)');
    $stmt->bindValue(':list_id', $List_ID);
    $stmt->bindParam(':num', $Number);
    $stmt->bindParam(':item', $New_Item);
    for($a=0;$a<$numItems;++$a)
    {
        $Number = $a+1;
        $New_Item = $List_Item[$a];
        $stmt->execute() or die('Failed inserting list items - loop ' . $a . '.');
    }
}

function queryCreateStandardLists()
{
    $Project_ID = $_SESSION['Project_ID'];
    $d = connect_DB();

    $arr_list = array(0=>array('Male/Female','Male/Female gender list'),
                      1=>array('On/Off', 'On/Off status list'),
                      2=>array('TRUE/FALSE', 'TRUE/FALSE list'),
                      3=>array('M/F', 'Single character male/female gender list'),
                      4=>array('Yes/No', 'Yes/No list'),
                      5=>array('Y/N', 'Single character yes/no list'));

    $arr_list_item = array(0=>array('Male','Female'),
                           1=>array('On', 'Off'),
                           2=>array('TRUE','FALSE'),
                           3=>array('M','F'),
                           4=>array('Yes','No'),
                           5=>array('Y','N'));

    $stmt = $d->prepare('INSERT INTO table_fields_predefined_list(`List_ID`, `Project_ID`, `List_Name`, `Remarks`)
                            VALUES(:list_id, :proj_id, :list_name, :remarks)');
    $stmt->bindParam(':list_id', $List_ID);
    $stmt->bindParam(':proj_id', $Project_ID);
    $stmt->bindParam(':list_name', $List_Name);
    $stmt->bindParam(':remarks', $Remarks);

    $stmt_items = $d->prepare('INSERT INTO table_fields_predefined_list_items(`List_ID`, `Number`, `List_Item`)
                                VALUES(:list_id, :num, :item)');
    $stmt_items->bindParam(':list_id', $List_ID);
    $stmt_items->bindParam(':num', $item_counter);
    $stmt_items->bindParam(':item', $item);

    foreach($arr_list as $index=>$list)
    {
        //get new List_ID
        $List_ID = get_token();
        $List_Name = $list[0];
        $Remarks = $list[1];
        $stmt->execute() or die("Failed to create new list.");

        $item_counter=1;
        foreach($arr_list_item[$index] as $item)
        {
            $stmt_items->execute() or die("Failed to create list item.");
            ++$item_counter;
        }
    }
}
function queryCreateTable($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    //Get new Table_ID
    $Table_ID = get_token();

    $numPages = count($Page_ID);

    $stmt = $d->prepare('INSERT INTO "table" (Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks)
                            VALUES(:t_id, :p_id, :db_id, :t_name, :remarks)');
    $stmt->bindValue(':t_id', $Table_ID);
    $stmt->bindValue(':p_id', $Project_ID);
    $stmt->bindValue(':db_id', $DB_Connection_ID);
    $stmt->bindValue(':t_name', $Table_Name);
    $stmt->bindValue(':remarks', $Remarks);
    $stmt->execute() or die("Failed to create table.");

    $stmt = $d->prepare('INSERT INTO table_pages(Table_ID, Page_ID, Path_Filename)
                            VALUES(:t_id, :p_id, :path)');
    $stmt->bindParam(':t_id', $Table_ID);
    $stmt->bindParam(':p_id', $New_Page);
    $stmt->bindParam(':path', $New_Path_Filename);
    for($a=0; $a<$numPages; ++$a)
    {
        $New_Page = $Page_ID[$a];
        $New_Path_Filename = $Path_Filename[$a];
        $stmt->execute() or die("Failed to create table pages");
    }
}

function queryDefineTableField()
{
    $d = connect_DB();

    recursive_trim($_POST);
    extract($_POST);

    //Get new Field_ID
    $Field_ID = get_token();

    $stmt = $d->prepare('INSERT INTO table_fields(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Auto_Increment, Control_Type, Label, In_Listview,
                                                  Default_Value, Required, Size, Extra, Companion, Char_Set_Method, Char_Set_Allow_Space, Extra_Chars_Allowed,
                                                  Allow_HTML_Tags, Trim_Value, Valid_Set, Date_Default, Drop_Down_Has_Blank, RPT_In_Report, RPT_Column_Format,
                                                  RPT_Column_Alignment, RPT_Show_Sum)
                            VALUES(:f_id, :t_id, :f_name, :d_type, :null, :len, :attribute, :auto, :c_type, :label, :in_lv, :def_val, :req, :size, :extra,
                                   :companion, :char_sm, :char_sas, :extra_ca, :a_html_t, :trim_val, :v_set, :date_def, :ddhb, :rpt_ir, :rpt_cf, :rpt_ca, :rpt_ss)');

    $stmt->bindValue(':f_id', $Field_ID);
    $stmt->bindValue(':t_id', $Table_ID);
    $stmt->bindValue(':f_name', $Field_Name);
    $stmt->bindValue(':d_type', $Data_Type);
    $stmt->bindValue(':null', $Nullable);
    $stmt->bindValue(':len', $Length);
    $stmt->bindValue(':attribute', $Attribute);
    $stmt->bindValue(':auto', $Auto_Increment);
    $stmt->bindValue(':c_type', $Control_Type);
    $stmt->bindValue(':label', $Label);
    $stmt->bindValue(':in_lv', $In_Listview);
    $stmt->bindValue(':def_val', $Default_Value);
    $stmt->bindValue(':req', $Required);
    $stmt->bindValue(':size', $Size);
    $stmt->bindValue(':extra', $Extra);
    $stmt->bindValue(':companion', $Companion);
    $stmt->bindValue(':char_sm', $Char_Set_Method);
    $stmt->bindValue(':char_sas', $Char_Set_Allow_Space);
    $stmt->bindValue(':extra_ca', $Extra_Chars_Allowed);
    $stmt->bindValue(':a_html_t', $Allow_HTML_Tags);
    $stmt->bindValue(':trim_val', $Trim_Value);
    $stmt->bindValue(':v_set', $Valid_Set);
    $stmt->bindValue(':date_def', $Date_Default);
    $stmt->bindValue(':ddhb', $Drop_Down_Has_Blank);
    $stmt->bindValue(':rpt_ir', $RPT_In_Report);
    $stmt->bindValue(':rpt_cf', $RPT_Column_Format);
    $stmt->bindValue(':rpt_ca', $RPT_Column_Alignment);
    $stmt->bindValue(':rpt_ss', $RPT_Show_Sum);
    $stmt->execute() or die("Failed to create table field.");

    if($Control_Type != "textbox" &&
       $Control_Type != "textarea" &&
       $Control_Type != "upload" &&
       $Control_Type != "none" &&
       $Control_Type != "date controls")
    {
        $stmt = $mysqli->stmt_init();
        if($Control_Type=="radio buttons")
        {
            $stmt = $d->prepare('INSERT INTO table_fields_list(Field_ID, List_ID) VALUES (:f_id, :l_id)');
            $stmt->bindValue(':f_id', $Field_ID);
            $stmt->bindValue(':l_id', $List_ID);
            $stmt->execute() or die("Failed creating radio button list for field.");
        }
        elseif($Control_Type=="drop-down list")
        {
            if($DropdownType=="Predefined")
            {
                $stmt = $d->prepare('INSERT INTO table_fields_list(Field_ID, List_ID) VALUES (:f_id, :l_id)');
                $stmt->bindValue(':f_id', $Field_ID);
                $stmt->bindValue(':l_id', $List_ID);
                $stmt->execute() or die("Failed creating drop-down list for field.");
            }
            elseif($DropdownType=="Source")
            {
                $stmt = $d->prepare('INSERT INTO table_fields_list_source_select(Field_ID, Select_Field_ID, Display)
                                        VALUES(:f_id, :s_id, :display)');
                $stmt->bindParam(':f_id', $Field_ID);
                $stmt->bindParam(':s_id', $New_Select_Field_ID);
                $stmt->bindParam(':display', $New_Display);
                for($a=0;$a<$selectCount;++$a)
                {
                    $New_Select_Field_ID = $Select_Field_ID[$a];
                    $New_Display =  $Select_Field_Display[$a];
                    $stmt->execute() or die("Failed creating SELECT clause for drop-down field.");
                }

                $stmt = $d->prepare('INSERT INTO table_fields_list_source_where(Field_ID, Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector)
                                        VALUES(:f_id, :w_id, :w_operand, :w_value, :w_connector)');
                $stmt->bindParam(':f_id', $Field_ID);
                $stmt->bindParam(':w_id', $New_Where_Field_ID);
                $stmt->bindParam(':w_operand', $New_Where_Field_Operand);
                $stmt->bindParam(':w_value', $New_Where_Field_Value);
                $stmt->bindParam(':w_connector', $New_Where_Field_Connector);
                for($a=0;$a<$whereCount;++$a)
                {
                    if($Where_Field_ID[$a] == '(NONE)')
                    {
                        //skip
                    }
                    else
                    {
                        $New_Where_Field_ID        = $Where_Field_ID[$a];
                        $New_Where_Field_Operand   = $Where_Field_Operand[$a];
                        $New_Where_Field_Value     = $Where_Field_Value[$a];
                        $New_Where_Field_Connector = $Where_Field_Connector[$a];
                        $stmt->execute() or die("Failed creating WHERE clause for drop-down field.");
                    }
                }
            }
        }
        $stmt->close();
    }
}

function queryDefineTableRelation($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    if(!isset($Child_Field_Subtext)) $Child_Field_Subtext='';

    //Get new Relation_ID
    $Relation_ID = get_token();

    //Create relation label.
    $Label = $d->querySingle("SELECT a.Table_Name FROM \"table\" a, table_fields b WHERE a.Table_ID=b.Table_ID AND b.Field_ID='$Parent_Field_ID'");
    $Label .= "=>";

    $Label .= $d->querySingle("SELECT a.Table_Name FROM \"table\" a, table_fields b WHERE a.Table_ID=b.Table_ID AND b.Field_ID='$Child_Field_ID'");

    $stmt = $d->prepare('INSERT INTO table_relations(Relation_ID, Project_ID, Relation,
                                Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext)
                            VALUES(:r_id, :p_id, :rel, :parent, :child, :label, :subtext)');
    $stmt->bindValue(':r_id', $Relation_ID);
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    $stmt->bindValue(':rel', $Relation);
    $stmt->bindValue(':parent', $Parent_Field_ID);
    $stmt->bindValue(':child', $Child_Field_ID);
    $stmt->bindValue(':label', $Label);
    $stmt->bindValue(':subtext', $Child_Field_Subtext);
    $stmt->execute() or die("Busted: Failed to create relationship.");

    //****************************************************************************************************
    //If this is a ONE-to-ONE relationship, we have to update the child field to reflect the relationship.
    if($Relation == 'ONE-to-ONE')
    {
        //Attribute should be foreign key, or primary&foreign key if previously a primary key or primary&foreign key
        $d->exec("UPDATE table_fields SET Attribute='foreign key' WHERE Field_ID='$Child_Field_ID' AND (Attribute != 'primary key' AND Attribute != 'primary&foreign key')");
        $d->exec("UPDATE table_fields SET Attribute='primary&foreign key' WHERE Field_ID='$Child_Field_ID' AND (Attribute='primary key' OR Attribute='primary&foreign key')");

        //Control type should be "Drop-down List".
        $d->exec("UPDATE table_fields SET Control_Type='drop-down list' WHERE Field_ID='$Child_Field_ID'");

        //Make sure to delete any existing records in the predefined list table (`table_fields_list`) so that
        //we're sure the list source is not a predefined list, and then also clear the "select" and "where" clause
        //tables to make sure we start from scratch later (`table_fields_list_source_select` and `table_fields_list_source_where`).
        $d->exec("DELETE FROM table_fields_list WHERE Field_ID='$Child_Field_ID'");
        $d->exec("DELETE FROM table_fields_list_source_select WHERE Field_ID='$Child_Field_ID'");
        $d->exec("DELETE FROM table_fields_list_source_where WHERE Field_ID='$Child_Field_ID'");

        //Label: If it ends with " id" or " code", just trim that part
        //(The rationale for this is: the child field label may be "employee id" or "item code" (or whatever), but what
        //we are actually displaying now courtesy of the 1-1 relationship is actually the employee name or item name,
        //so we just do the developer a service by making the label "employee" or "item" instead of "employee id" or
        //"item code")
        $orig_label = $d->querySingle("SELECT Label FROM table_fields WHERE Field_ID='$Child_Field_ID'");
        $label = $orig_label;
        if(strtoupper(substr($label,-3, 3)) == ' ID') $label = substr($label, 0, strlen($label) -3);
        elseif(strtoupper(substr($label,-5, 5)) == ' CODE') $label = substr($label, 0, strlen($label) -5);

        if($label != $orig_label)
        {
            $d->exec("UPDATE table_fields SET Label='$label' WHERE Field_ID='$Child_Field_ID'");
        }

        //List Source Select: the link field (of the parent) serves as NO, while all the child field subtext entries
        //(which are also parent fields) are all YES (we're talking about Display)
        //Preliminary step: Before we can get the Field_ID of the child fields, we need the table ID (of the parent, not the child)
        //so we can match the child field subtext entries with the field names in the correct table
        $Table_ID = $d->querySingle("SELECT Table_ID FROM table_fields WHERE Field_ID='$Parent_Field_ID'");

        $stmt = $d->prepare("INSERT INTO table_fields_list_source_select(Field_ID, Select_Field_ID, Display)
                                VALUES(:f_id, :s_id, :display)");
        $Field_ID = $Child_Field_ID;
        $Select_Field_ID = $Parent_Field_ID;
        $Display = 'No';
        $stmt->bindParam(':f_id', $Field_ID);
        $stmt->bindParam(':s_id', $Select_Field_ID);
        $stmt->bindParam(':display', $Display);
        $stmt->execute() or die("Failed to insert list source value.");

        $cntr=0;
        $Subtext = explode(',', $Child_Field_Subtext);
        foreach($Subtext as $child_field)
        {
            ++$cntr;
            $child_field = trim($child_field);
            $Subtext_Field_ID = $d->querySingle("SELECT Field_ID FROM table_fields WHERE Table_ID='$Table_ID' AND Field_Name='$child_field'");
            $Field_ID = $Child_Field_ID;
            $Select_Field_ID = $Subtext_Field_ID;
            $Display = 'Yes';
            $stmt->execute();
        }
        $stmt->close();

        //List Source Where: none (0 for where_field_ID, blanks for all other fields)
        $d->exec("INSERT INTO table_fields_list_source_where(Field_ID, Where_Field_ID) VALUES ('$Child_Field_ID','0')");
    }


    //****************************************************************************************************
    //If this is a ONE-to-MANY relationship, we have to update the child field to reflect the relationship.
    if($Relation == 'ONE-to-MANY')
    {
        //Attribute should be foreign key, or primary&foreign key if previously a primary key
        $d->exec("UPDATE table_fields SET Attribute='foreign key' WHERE Field_ID='$Child_Field_ID' AND Attribute != 'primary key'");
        $d->exec("UPDATE table_fields SET Attribute='primary&foreign key' WHERE Field_ID='$Child_Field_ID' AND Attribute='primary key'");
    }
}

function queryDeleteDBConnection($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    $stmt = $d->prepare("DELETE FROM database_connection WHERE DB_Connection_ID=:db_id");
    $stmt->bindValue(':db_id', $DB_Connection_ID);
    $stmt->execute() or die("Failed to delete database connection.");

    //Check if this connection is the chosen default connection. If so, reset the Database_Connection_ID field in Project table to 0.
    $temp_id = $d->querySingle("SELECT Database_Connection_ID FROM project WHERE Project_ID='$_SESSION[Project_ID]' AND Database_Connection_ID='$DB_Connection_ID'");
    if($temp_id == $DB_Connection_ID)
    {
        //Deleted connection was indeed the default connection of the project
        $d->exec("UPDATE project SET Database_Connection_ID='0' WHERE Project_ID='$_SESSION[Project_ID]'");
    }
}

function queryDeletePage($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    $stmt = $d->prepare("DELETE FROM page WHERE Page_ID=:p_id");
    $stmt->bindValue(':p_id', $Page_ID);
    $stmt->execute() or die("Failed to delete page.");
}

function queryDeletePredefinedList($param)
{
    recursive_trim($param);
    extract($param);

    $d = connect_DB();
    $stmt = $d->prepare("DELETE FROM table_fields_predefined_list WHERE List_ID=:l_id");
    $stmt->bindValue(':l_id', $List_ID);
    $stmt->execute() or die("Failed to delete list header.");

    $stmt = $d->prepare("DELETE FROM table_fields_predefined_list_items WHERE List_ID=:l_id");
    $stmt->bindValue(':l_id', $List_ID);
    $stmt->execute() or die("Failed to delete list items.");
}

//FIXME: needs testing
function queryDeleteTable($param)
{
    recursive_trim($param);
    extract($param);

    $d = connect_DB();
    $d->exec("PRAGMA synchronous = OFF");
    $stmt = $d->prepare("DELETE FROM \"table\" WHERE Table_ID=:t_id");
    $stmt->bindValue(':t_id', $Table_ID);
    $stmt->execute() or die("Failed to delete table.");

    $stmt = $d->prepare("DELETE FROM table_pages WHERE Table_ID=:t_id");
    $stmt->bindValue(':t_id', $Table_ID);
    $stmt->execute() or die("Failed to delete table pages.");
    $stmt->close();


    $result = $d->query("SELECT Field_ID
                            FROM table_fields
                            WHERE Table_ID='$Table_ID'");

    $data = array();
    while($row = $result->fetchArray())
    {
        $data[] = array('Field_ID'=>$row[0]);
    }

    foreach($data as $row_data)
    {
        queryDeleteTableField($row_data);
    }
}

function queryDeleteTableField($param)
{
    recursive_trim($param);
    extract($param);

    $d = connect_DB();
    $d->exec("PRAGMA synchronous = OFF"); //Without this, SQLite3 will take a long time to delete several fields because it keeps pausing to wait for the OS
    $stmt = $d->prepare('DELETE FROM table_fields WHERE Field_ID=:f_id');
    $stmt->bindValue(':f_id', $Field_ID);
    $stmt->execute() or die("Failed to delete field.");

    $stmt = $d->prepare('DELETE FROM table_fields_list WHERE Field_ID=:f_id');
    $stmt->bindValue(':f_id', $Field_ID);
    $stmt->execute() or die("Failed to delete field list.");

    $stmt = $d->prepare('DELETE FROM table_fields_list_source_select WHERE Field_ID=:f_id');
    $stmt->bindValue(':f_id', $Field_ID);
    $stmt->execute() or die("Failed to delete field select clause.");

    $stmt = $d->prepare('DELETE FROM table_fields_list_source_where WHERE Field_ID=:f_id');
    $stmt->bindValue(':f_id', $Field_ID);
    $stmt->execute() or die("Failed to delete field where clause.");

    $stmt = $d->prepare('DELETE FROM table_relations WHERE Parent_Field_ID=:p_id OR Child_Field_ID=:c_id');
    $stmt->bindValue(':p_id', $Field_ID);
    $stmt->bindValue(':c_id', $Field_ID);
    $stmt->execute() or die("Failed to delete relations.");
}

//FIXME: needs testing
function queryDeleteTableRelation($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    rollback_field_from_relationship($Relation_ID);

    $stmt = $d->prepare("DELETE FROM `table_relations` WHERE Relation_ID=:r_id");
    $stmt->bindValue(':r_id', $Relation_ID);
    $stmt->execute() or die("Failed to delete relationship.");
}

//FIXME: needs testing
function queryDeleteProject($param)
{
    recursive_trim($param);
    extract($param);
    $d = connect_DB();
    $stmt = $d->prepare("DELETE FROM project WHERE Project_ID=:p_id");
    $stmt->bindValue(':p_id', $Project_ID);
    $stmt->execute() or die("Failed to delete project.");
    $stmt->close();

    //Delete all tables and fields, including all stuff related to those tables and fields
    //(table relations, field list sources, etc)
    $stmt = $d->prepare("SELECT Table_ID FROM \"table\" WHERE Project_ID=:p_id");
    $stmt->bindValue(':p_id', $Project_ID);
    $result = $stmt->execute();
    $arrResult = array();
    while($row = $result->fetchArray())
    {
        $arrResult[] = $row['Table_ID'];
    }
    $stmt->close();

    foreach($arrResult as $table_id)
    {
        queryDeleteTable(array('Table_ID'=>$table_id));
    }

    //Delete all predefined lists
    $result = $d->query("SELECT List_ID
                            FROM table_fields_predefined_list
                            WHERE Project_ID='$Project_ID'");
    $arrResult = array();
    while($row = $result->fetchArray())
    {
        $arrResult[] = $row['List_ID'];
    }

    foreach($arrResult as $list_id)
    {
            queryDeletePredefinedList(array('List_ID'=>$list_id));
    }

    //Delete all database connections
    $stmt = $d->prepare("DELETE FROM database_connection WHERE Project_ID=:p_id");
    $stmt->bindValue(':p_id', $Project_ID);
    $stmt->execute() or die("Failed to delete database connections of the project.");

    unset($_SESSION['Project_ID']);
    unset($_SESSION['Project_Name']);
}

function queryUpdateDBConnection($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    $stmt = $d->prepare("UPDATE database_connection
                            SET `DB_Connection_Name` = :db_name,
                                `Hostname` = :host,
                                `Username` = :user,
                                `Password` = :pass,
                                `Database` = :database
                            WHERE DB_Connection_ID = :db_id");
    $stmt->bindValue(':db_name', $DB_Connection_Name);
    $stmt->bindValue(':host', $Hostname);
    $stmt->bindValue(':user', $Username);
    $stmt->bindValue(':pass', $Password);
    $stmt->bindValue(':database', $Database);
    $stmt->bindValue(':db_id', $Orig_DB_Connection_ID);
    $stmt->execute() or die("Failed to update database connection.");


    if($Default_Connection == 'Yes')
    {
        $stmt = $d->prepare("UPDATE `project` SET Database_Connection_ID = :db_id WHERE Project_ID = :p_id");
        $stmt->bindValue(':db_id', $Orig_DB_Connection_ID);
        $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
        $stmt->execute() or die("Failed to update project's default database.");
    }
}

function queryUpdatePage($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    $stmt = $d->prepare("UPDATE page
                            SET `Page_Name` = :p_name,
                                `Generator` = :gen,
                                `Description` = :description
                            WHERE Page_ID=:p_id");
    $stmt->bindValue(':p_name', $Page_Name);
    $stmt->bindValue(':gen', $Generator);
    $stmt->bindValue(':description', $Description);
    $stmt->bindValue(':p_id', $Orig_Page_ID);
    $stmt->execute() or die("Failed to update page generator.");
}

function queryUpdatePredefinedList($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    $stmt = $d->prepare("UPDATE table_fields_predefined_list
                        SET `List_Name` = :l_name,
                            `Remarks`   = :remarks
                        WHERE List_ID   = :l_id");
    $stmt->bindValue(':l_name',$List_Name);
    $stmt->bindValue(':remarks',$Remarks);
    $stmt->bindValue(':l_id',$Orig_List_ID);
    $stmt->execute() or die("Failed to update predefined list header.");

    $stmt = $d->prepare("DELETE FROM table_fields_predefined_list_items WHERE List_ID=:l_id");
    $stmt->bindValue('l_id', $Orig_List_ID);
    $stmt->execute() or die("Failed to delete old list items.");

    $stmt = $d->prepare("INSERT INTO table_fields_predefined_list_items(`List_ID`, `Number`, `List_Item`)
                            VALUES(:l_id, :num, :l_item)");
    $stmt->bindParam(':l_id', $Orig_List_ID);
    $stmt->bindParam(':num', $Number);
    $stmt->bindParam(':l_item', $New_Item);
    for($a=0;$a<$particularsCount;++$a)
    {
        $Number = $a+1;
        $New_Item = $List_Item[$a];
        $stmt->execute() or die("Failed to insert list item, #" . $Number);
    }
}

function queryUpdateProject($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    $stmt = $d->prepare("UPDATE `project`
                        SET `Project_Name` = :p_name,
                            `Client_Name` = :c_name,
                            `Project_Description` = :p_desc,
                            `Base_Directory` = :base_dir,
                            `Database_Connection_ID` = :db_con_id
                        WHERE Project_ID=:p_id");
    $stmt->bindValue(':p_name', $Project_Name);
    $stmt->bindValue(':c_name', $Client_Name);
    $stmt->bindValue(':p_desc', $Project_Description);
    $stmt->bindValue(':base_dir', $Base_Directory);
    $stmt->bindValue(':db_con_id', $Database_Connection_ID);
    $stmt->bindValue(':p_id', $Orig_Project_ID);
    $stmt->execute() or die("Failed to update project information.");

    $_SESSION['Project_Name'] = $Project_Name;
}

function queryUpdateTable($param)
{
    $d = connect_DB();

    recursive_trim($param);
    extract($param);

    $stmt = $d->prepare("UPDATE `table`
                            SET `DB_Connection_ID` = :db_con_id,
                                `Table_Name` = :t_name,
                                `Remarks` = :remarks
                            WHERE Table_ID=:t_id");
    $stmt->bindValue(':db_con_id', $DB_Connection_ID);
    $stmt->bindValue(':t_name', $Table_Name);
    $stmt->bindValue(':remarks', $Remarks);
    $stmt->bindValue(':t_id', $Table_ID);
    $stmt->execute() or die ("Failed to update table information.");

    $stmt = $d->prepare("DELETE FROM `table_pages` WHERE Table_ID=:t_id");
    $stmt->bindValue(':t_id', $Table_ID);
    $stmt->execute() or die("Failed to delete table pages.");

    $numPages = count($Page_ID);

    $stmt = $d->prepare("INSERT INTO `table_pages` (Table_ID, Page_ID, Path_Filename) VALUES(:t_id, :p_id, :fname)");
    $stmt->bindParam(':t_id', $Table_ID);
    $stmt->bindParam(':p_id', $New_Page_ID);
    $stmt->bindParam(':fname', $New_Path_Filename);
    for($a=0;$a<$numPages;++$a)
    {
        $New_Page_ID = $Page_ID[$a];
        $New_Path_Filename = trim($Path_Filename[$a]);
        $stmt->execute() or die("Failed to insert table page ($New_Path_Filname)");
    }
    $stmt->close();
}

function queryUpdateTableField()
{
    $d = connect_DB();

    recursive_trim($_POST);
    extract($_POST);

    $stmt = $d->prepare("UPDATE `table_fields`
                            SET `Table_ID` = :t_id,
                                `Field_Name` = :f_name,
                                `Data_Type` = :d_type,
                                `Nullable` = :nullable,
                                `Length`= :length,
                                `Attribute`= :attrib,
                                `Control_Type`= :c_type,
                                `Label`= :label,
                                `In_Listview`= :in_lv,
                                `Auto_Increment`= :auto,
                                `Default_Value`= :def_val,
                                `Required`= :req,
                                `Size`= :size,
                                `Extra`= :extra,
                                `Companion`= :companion,
                                `Char_Set_Method`= :char_sm,
                                `Char_Set_Allow_Space`= :char_sas,
                                `Extra_Chars_Allowed`= :extra_ca,
                                `Allow_HTML_Tags`= :a_html_t,
                                `Trim_Value`= :trim_val,
                                `Valid_Set`= :v_set,
                                `Date_Default`= :date_def,
                                `Drop_Down_Has_Blank`= :ddhb,
                                `RPT_In_Report`= :rpt_ir,
                                `RPT_Column_Format`= :rpt_cf,
                                `RPT_Column_Alignment`= :rpt_ca,
                                `RPT_Show_Sum`= :rpt_ss
                            WHERE Field_ID=:f_id");
    $stmt->bindValue(':t_id', $Table_ID);
    $stmt->bindValue(':f_name', $Field_Name);
    $stmt->bindValue(':d_type', $Data_Type);
    $stmt->bindValue(':nullable', $Nullable);
    $stmt->bindValue(':length', $Length);
    $stmt->bindValue(':attrib', $Attribute);
    $stmt->bindValue(':c_type', $Control_Type);
    $stmt->bindValue(':label', $Label);
    $stmt->bindValue(':auto', $Auto_Increment);
    $stmt->bindValue(':in_lv', $In_Listview);
    $stmt->bindValue(':def_val', $Default_Value);
    $stmt->bindValue(':req', $Required);
    $stmt->bindValue(':size', $Size);
    $stmt->bindValue(':extra', $Extra);
    $stmt->bindValue(':companion', $Companion);
    $stmt->bindValue(':char_sm', $Char_Set_Method);
    $stmt->bindValue(':char_sas', $Char_Set_Allow_Space);
    $stmt->bindValue(':extra_ca', $Extra_Chars_Allowed);
    $stmt->bindValue(':a_html_t', $Allow_HTML_Tags);
    $stmt->bindValue(':trim_val', $Trim_Value);
    $stmt->bindValue(':v_set', $Valid_Set);
    $stmt->bindValue(':date_def', $Date_Default);
    $stmt->bindValue(':ddhb', $Drop_Down_Has_Blank);
    $stmt->bindValue(':rpt_ir', $RPT_In_Report);
    $stmt->bindValue(':rpt_cf', $RPT_Column_Format);
    $stmt->bindValue(':rpt_ca', $RPT_Column_Alignment);
    $stmt->bindValue(':rpt_ss', $RPT_Show_Sum);
    $stmt->bindValue(':f_id', $Field_ID);
    $stmt->execute() or die("Failed to update table header info.");

    if($Control_Type != "textbox" &&
       $Control_Type != "textarea" &&
       $Control_Type != "upload" &&
       $Control_Type != "none" &&
       $Control_Type != "date controls")
    {
        if($Control_Type=="radio buttons")
        {
            $stmt = $d->prepare("DELETE FROM `table_fields_list` WHERE Field_ID=:f_id");
            $stmt->bindValue(':f_id', $Field_ID);
            $stmt->execute() or die("Failed to delete old predefined list of the field (radio buttons).");

            $stmt = $d->prepare("INSERT INTO table_fields_list(Field_ID, List_ID) VALUES (:f_id, :l_id)");
            $stmt->bindValue(':f_id', $Field_ID);
            $stmt->bindValue(':l_id', $List_ID);
            $stmt->execute() or die("Failed to insert new predefined list of the field (radio buttons).");
        }
        elseif($Control_Type=="drop-down list")
        {
            if($DropdownType=="Predefined")
            {
                $stmt = $d->prepare("DELETE FROM `table_fields_list` WHERE Field_ID=:f_id");
                $stmt->bindValue(':f_id', $Field_ID);
                $stmt->execute() or die("Failed to delete old predefined list of the field (drop-down list).");

                $stmt = $d->prepare("INSERT INTO table_fields_list(Field_ID, List_ID) VALUES (:f_id, :l_id)");
                $stmt->bindValue(':f_id', $Field_ID);
                $stmt->bindValue(':l_id', $List_ID);
                $stmt->execute() or die("Failed to insert new predefined list of the field (drop-down list).");
            }
            elseif($DropdownType=="Source")
            {
                $stmt = $d->prepare("DELETE FROM `table_fields_list_source_select` WHERE Field_ID=:f_id");
                $stmt->bindValue(':f_id', $Field_ID);
                $stmt->execute() or die("Failed to delete old select clause of SQL-generated list of the field.");

                $stmt = $d->prepare("INSERT INTO table_fields_list_source_select(Field_ID, Select_Field_ID, Display) VALUES(:f_id, :sf_id, :display)");
                $stmt->bindParam(':f_id', $Field_ID);
                $stmt->bindParam(':sf_id', $New_Select_Field_ID);
                $stmt->bindParam(':display', $New_Display);
                for($a=0;$a<$selectCount;++$a)
                {
                    $New_Select_Field_ID = $Select_Field_ID[$a];
                    $New_Display =  $Select_Field_Display[$a];
                    $stmt->execute() or die("Failed to insert new list_source_select_field, loop #" . ($a+1));
                }

                $stmt = $d->prepare("DELETE FROM `table_fields_list_source_where` WHERE Field_ID=:f_id");
                $stmt->bindValue(':f_id', $Field_ID);
                $stmt->execute() or die("Failed to delete old where clause of SQL-generated list of the field");

                $stmt = $d->prepare("INSERT INTO table_fields_list_source_where(Field_ID, Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector)
                                        VALUES(:f_id, :wf_id, :wf_oper, :wf_val, :wf_con)");
                $stmt->bindParam(':f_id', $Field_ID);
                $stmt->bindParam(':wf_id', $New_Where_Field_ID);
                $stmt->bindParam(':wf_oper', $New_Where_Field_Operand);
                $stmt->bindParam(':wf_val', $New_Where_Field_Value);
                $stmt->bindParam(':wf_con', $New_Where_Field_Connector);
                for($a=0;$a<$whereCount;++$a)
                {
                    if($Where_Field_ID[$a] == '(NONE)')
                    {
                        //skip
                    }
                    else
                    {
                        $New_Where_Field_ID = $Where_Field_ID[$a];
                        $New_Where_Field_Operand = $Where_Field_Operand[$a];
                        $New_Where_Field_Value = $Where_Field_Value[$a];
                        $New_Where_Field_Connector = $Where_Field_Connector[$a];
                        $stmt->execute() or die("Failed to insert new list_source_where_field, loop $" . ($a+1));
                    }
                }
            }
        }
        $stmt->close();
    }
}

function queryUpdateTableRelation($param)
{
    queryDeleteTableRelation($param); // Delete the previous relationship
    queryDefineTableRelation($param); // Define the "updated" relationship (really a new one since we deleted the old)
}

function rollback_field_from_relationship($Relation_ID)
{
    //******************************************************************************
    //*** START: ROLLBACK OF FIELD INFO UPON REMOVAL OF RELATIONSHIP ***************
    //******************************************************************************
    //We have to undo changes in the child field

    $d = connect_DB();

    //Get the Child Field involved
    $Child_Field_ID = $d->querySingle("SELECT Child_Field_ID FROM `table_relations` WHERE Relation_ID='$Relation_ID'");

    //Delete the SQL list settings (for 1-1 relationships)
    $d->exec("DELETE FROM table_fields_list_source_select WHERE Field_ID='$Child_Field_ID'");
    $d->exec("DELETE FROM table_fields_list_source_where WHERE Field_ID='$Child_Field_ID'");

    //See what the attribute value is.
    //- if "primary&foregin key", change back to "primary".
    //- if "foreign key", change back to "none".
    $Child_Field_Attribute = $d->querySingle("SELECT Attribute FROM table_fields WHERE Field_ID='$Child_Field_ID'");

    if($Child_Field_Attribute == 'primary&foreign key')
    {
        $new_attribute = 'primary key';
    }
    else
    {
        $new_attribute = 'none';
    }

    $stmt = $d->prepare("UPDATE table_fields SET Attribute=:attrib WHERE Field_ID=:f_id");
    $stmt->bindValue(':attrib', $new_attribute);
    $stmt->bindValue(':f_id', $Child_Field_ID);
    $stmt->execute() or die("Failed to rollback field attribute.");

    //After undoing the attribute, we now have to undo the change to the control type (for 1-1 relationships).
    //We need to look at this field's metadata to determine how to roll it back to default
    $stmt = $d->prepare("SELECT Field_Name, Data_Type FROM table_fields WHERE Field_ID=:f_id");
    $stmt->bindValue(':f_id', $Child_Field_ID);
    $result = $stmt->execute();
    while($data = $result->fetchArray())
    {
        $Child_Field_Name = $data['Field_Name'];
        $Child_Data_Type  = $data['Data_Type'];
    }

    $arr_textarea_names = get_textarea_field_names();
    if(in_array(strtoupper($Child_Field_Name), $arr_textarea_names))
    {
        $control_type = 'textarea';
    }
    else
    {
        switch($Child_Data_Type)
        {
            case 'text' : $control_type = 'textarea'; break;
            case 'date' : $control_type = 'date controls'; break;
            default     : $control_type = 'textbox';
        }
    }

    if(strtoupper($Child_Field_Name) == 'ID')
    {
        $label = 'ID';
    }
    else
    {
        $label = str_replace('_',' ',$Child_Field_Name);
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

    $stmt = $d->prepare("UPDATE table_fields SET Control_Type=:c_type, Label=:label WHERE Field_ID=:f_id");
    $stmt->bindValue(':c_type', $control_type);
    $stmt->bindValue(':label', $label);
    $stmt->bindValue(':f_id', $Child_Field_ID);
    $stmt->execute() or die("Failed to rollback basic field information.");

    //******************************************************************************
    //*** END: ROLLBACK OF FIELD INFO UPON REMOVAL OF RELATIONSHIP *****************
    //******************************************************************************
}
?>
