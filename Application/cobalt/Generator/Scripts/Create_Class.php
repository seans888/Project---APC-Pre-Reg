<?php

//This file creates the sub class definition for each table you generate.
//This process is divided into 4 phases:
//	1. Creating the $fields array, which contains the field information for all fields in the table.
//	2. Creating the table-specific connection information using the specified database connection for the table.
//	3. Creating the sub class methods - generic Add, Edit, Delete and Select methods using all specified table fields.
//  4. Define the data dictionary class file -> $Table_Name . '_DD'

//Additional (version 1.0+ specific) This also creates a _HTML subclass for each table, which extends the base
//HTML class instead of the Data_Abstraction class.

function createClass($Table_ID, $subclass_path, $num_databases)
{
    //PHASE 1: Creating the $fields array.
    //The structure of the $fields array is pretty simple. This array is a multidimensional array that contains all
    //the fields of the table you are generating, including all necessary field information you entered.
    //Each field name is an index (the first dimension) of $fields. This index then has an array as a value, which holds
    //all the settings for that specific field.
    //Example:
    //$fields = array(
    //               'Name' => array('Value'=>'',
    //                               'Data_Type'=>'Varchar',
    //                               'Length'=>'20',
    //                               'Attribute'=>'Required'),
    //               'Address' => array('Value'=>''.
    //                                  'Data_Type'=>'Text',
    //                                  'Length'=>'N/A',
    //                                  'Attribute'=>'NONE')
    //               );
    //Note that this example merely assumes that there are 2 fields in the table ('Name' and 'Address'), and that each field
    //only has 4 settings/values (Value, Data_Type, Length, Attribute), which certainly isn't the case as there are a few more.

    //Prep: get table info
    $d = connect_DB();
    $stmt  = $d->prepare("SELECT Table_Name FROM \"table\" WHERE Table_ID=:t_id");
    $stmt->bindValue(':t_id', $Table_ID);

    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);
    }
    $stmt->close();

    // 1.1 - Create empty class files. If one or both of the files already exist, delete them first.
    //Note: as of 2012-11-18, creation of empty class files have been postponed until right before the fwrite call.
    //FIXME: Since edit noted above, query above and below can probably be merged into one.

    // 1.2 - Query all field information.
    // 1.2.1 - Generic field information.
    $stmt = $d->prepare("SELECT * FROM table_fields WHERE Table_ID=:t_id");
    $stmt->bindValue(':t_id', $Table_ID);
    $arr_metadata = array();
    if($result = $stmt->execute())
    {
        while($row = $result->fetchArray())
        {
            $arr_metadata[] = $row;
        }
    }
    $stmt->close();

    $field_array = array(); //array for aggregating all field names; useful later in method generation.
    $field_attribute_array = array(); //array for aggregating all field attributes; useful later in method generation.
    $field_control_array = array(); //array for aggregating all field control types; useful later in the edit method generation.
    $field_data_type_array = array(); //array for aggregating all field data types corresponding to [i,d,s,b]; useful later for the subclass generation that needs to assemble a prepared statement
    $fields = '$fields = array(';

    foreach($arr_metadata as $row)
    {
        extract($row); //We only named this $row because it was named $row already before the refactoring that changed it into a foreach with $arr_metadata

        $Label = addslashes($Label);
        $Extra_Chars_Allowed = addslashes($Extra_Chars_Allowed);

        if($Data_Type == 'integer')
        {
            $field_data_type_array[] = 'i';
        }
        elseif($Data_Type == 'double or float')
        {
            $field_data_type_array[] = 'd';
        }
        else
        {
            //Normal input field, defaults to no filter.
            //This is fine since every data will be used in prepared statements or checked and escaped properly.
            $field_data_type_array[] = 's';
        }

        $field_array[] = $Field_Name; //aggregate all field names into this array.
        $field_attribute_array[] = $Attribute;
        $field_control_array[] = $Control_Type;
        $field_auto_increment_array[] = $Auto_Increment;

        $fields .= <<<EOD

                    '$Field_Name' => array('value'=>'$Default_Value',
                                          'nullable'=>$Nullable,
                                          'data_type'=>'$Data_Type',
                                          'length'=>$Length,
                                          'required'=>$Required,
                                          'attribute'=>'$Attribute',
                                          'control_type'=>'$Control_Type',
                                          'size'=>'$Size',
                                          'drop_down_has_blank'=>$Drop_Down_Has_Blank,
                                          'label'=>'$Label',
                                          'extra'=>'$Extra',
                                          'companion'=>'$Companion',
                                          'in_listview'=>$In_Listview,
                                          'char_set_method'=>'$Char_Set_Method',
                                          'char_set_allow_space'=>$Char_Set_Allow_Space,
                                          'extra_chars_allowed'=>'$Extra_Chars_Allowed',
                                          'allow_html_tags'=>$Allow_HTML_Tags,
                                          'trim'=>'$Trim_Value',
                                          'valid_set'=>array()
EOD;

        $BYPASS_LIST_SOURCE = "NOT YET";

        //1.2.2 - Check if necessary to create the necessary date controls elements
        if($Control_Type == 'date controls')
        {
            $dc_year  = $Field_Name . '_year';
            $dc_month = $Field_Name . '_month';
            $dc_day   = $Field_Name . '_day';

            $fields .= <<<EOD
,
                                          'date_elements'=>array('$dc_year','$dc_month','$dc_day')
EOD;
        }
        else $fields .= <<<EOD
,
                                          'date_elements'=>array('','','')
EOD;
        $fields .= <<<EOD
,
                                          'date_default'=>'$Date_Default'
EOD;

        // 1.2.3 - Check if "Predefined_List" is applicable .
        if($Control_Type == "radio buttons" || $Control_Type == "drop-down list")
        {
            $stmt = $d->prepare("SELECT List_ID FROM table_fields_list WHERE Field_ID=:f_id");
            $stmt->bindValue(':f_id', $Field_ID);

            $List_ID = '';
            if($result = $stmt->execute())
            {
                $data = $result->fetchArray();
                $List_ID = $data['List_ID'];
            }
            $stmt->close();

            if($List_ID != '')
            {
                //FIXME: Perhaps this query and the one above should be merged using a properly JOINed query?
                $stmt = $d->prepare("SELECT List_Item FROM table_fields_predefined_list_items WHERE List_ID=:l_id");
                $stmt->bindValue(':l_id', $List_ID);

                if($result = $stmt->execute())
                {
                    $list_items = '';
                    while($data = $result->fetchArray())
                    {
                        $data[0] = str_replace("'", "\'", $data[0]); //single quotes need escaping
                        $list_items .=  "'$data[0]',";
                    }
                    $list_items = substr($list_items,0,strlen($list_items)-1); //Remove the last comma.
                }
                $stmt->close();
                $BYPASS_LIST_SOURCE = "YES, PLEASE BYPASS!";

                $fields .= <<<EOD
,
                                      'list_type'=>'predefined',
                                      'list_settings'=>array('per_line'=>TRUE,
                                                             'items'  =>array($list_items),
                                                             'values' =>array($list_items))
EOD;
            }
        }
        else $BYPASS_LIST_SOURCE = 'NOPE';

        // 1.2.4 - Check if "List_Source_Select/Where" is applicable.
        if($Control_Type == "drop-down list" && $BYPASS_LIST_SOURCE != "YES, PLEASE BYPASS!")
        {
            require_once 'ListFromSQL.php';
            $settings = list_from_SQL_settings($Field_ID, $num_databases);

            $fields .= <<<EOD
,
                                          'list_type'=>'sql generated',
                                          'list_settings'=>array($settings)
EOD;

        }
        elseif($BYPASS_LIST_SOURCE == 'NOPE') $fields .= <<<EOD
,
                                          'list_type'=>'',
                                          'list_settings'=>array('')
EOD;

        //1.2.5 Adding the dictionary elements for the report feature
        $fields .= <<<EOD
,
                                          'rpt_in_report'=>$RPT_In_Report,
                                          'rpt_column_format'=>'$RPT_Column_Format',
                                          'rpt_column_alignment'=>'$RPT_Column_Alignment',
                                          'rpt_show_sum'=>$RPT_Show_Sum
EOD;

        //Closing parenthesis - remember that each field info is in an array, right? Well,
        //this is the closing parenthesis for that.
        $fields .= '),';
    }

    $fields = substr($fields,0, strlen($fields)-1);
    $fields .= "\r\n                       );"; //This line prints the closing ');' aligned with the opening '('.


    //PHASE 2: Creating the Database Connection variables.
    //Get the default database connection details
    $stmt = $d->prepare("SELECT a.DB_Connection_ID, a.Hostname, a.Username, a.Password, a.Database
                            FROM database_connection a, project b
                            WHERE a.DB_Connection_ID = b.Database_Connection_ID AND
                                  b.Project_ID = :p_id");
    $stmt->bindValue(':p_id', $_SESSION['Project_ID']);
    if($result = $stmt->execute())
    {
        $data = $result->fetchArray(SQLITE3_NUM);
        $def_DBCon = $data[0];
        $def_Host  = $data[1];
        $def_User  = $data[2];
        $def_Pass  = $data[3];
        $def_DB    = $data[4];
    }
    $stmt->close();

    //Query for the Hostname, Username, Password and Database of the connection specified in the current table.
    init_var($database_connection_variables);
    $stmt = $d->prepare("SELECT a.DB_Connection_ID, a.Hostname, a.Username, a.Password, a.Database
                            FROM database_connection a, \"table\" b
                            WHERE a.DB_Connection_ID = b.DB_Connection_ID AND
                                  b.Table_ID = :t_id");
    $stmt->bindValue(':t_id', $Table_ID);

    if($result = $stmt->execute())
    {
        $data = $result->fetchArray();
        extract($data);

        //Check if this is the project's default connection;
        //If not, check if some values are the same.
        //All values that are identical will not be overridden by the subclass.
        if($def_DBCon != $DB_Connection_ID)
        {
            if($def_Host !=  $Hostname)
            {
                $database_connection_variables.=<<<EOD

    var \$db_host='$Hostname';
EOD;
            }


            if($def_User !=  $Username)
            {
                $database_connection_variables.=<<<EOD

    var \$db_user='$Username';
EOD;
            }


            if($def_Pass !=  $Password)
            {
                $database_connection_variables.=<<<EOD

    var \$db_pass='$Password';
EOD;
            }


            if($def_DB !=  $Database)
            {
                $database_connection_variables.=<<<EOD

    var \$db_use='$Database';
EOD;
            }
        }
    }
    $stmt->close();

    //We also need to get the relationships of this table/class.
    //    $relations = array('1'=>array('Type'=>'1-1',
    //                                      'Table'=>'position',
    //                                      'Link_parent'=>'position_id',
    //                                      'Link_child'=>'position_id',
    //                                      'Link_subtext'=>array('position'),
    //                                      'Where_clause'=>''));
    $rel_index=0; //array index of relationships, should persist up to the M-1 section.
    $foreign_field = ''; //will hold the field name of the foreign_key field of the child ("M") in a 1-M relationship, if one exists for this table
    $stmt = $d->prepare("SELECT a.Relation_ID, a.Relation, a.Child_Field_ID, a.Child_Field_Subtext, b.Field_Name
                            FROM table_relations a, table_fields b
                            WHERE (a.Child_Field_ID = b.Field_ID AND b.Table_ID = :t_id AND a.Relation ='ONE-to-ONE') OR
                                  (a.Parent_Field_ID = b.Field_ID AND b.Table_ID = :t2_id AND a.Relation ='ONE-to-MANY')");
    $stmt->bindValue(':t_id', $Table_ID);
    $stmt->bindValue(':t2_id', $Table_ID);

    $arr_rel_data = array();
    if($result = $stmt->execute())
    {
        while($data = $result->fetchArray())
        {
            $arr_rel_data[] = $data; //FIXME: these can probably be just one line: while($arr_rel_data[] = $result->fetchArray());
        }
    }
    $stmt->close();

    $relations = '$relations = array(';
    $put_comma=FALSE;
    $rel_index = 0;

    if(count($arr_rel_data) > 0)
    {
        foreach($arr_rel_data as $data)
        {
            ++$rel_index;
            extract($data);

            $Link_child = $Field_Name;

            if($Relation == 'ONE-to-ONE') $Relation = '1-1';
            elseif($Relation == 'ONE-to-MANY') $Relation = '1-M';

            if($Relation == '1-1')
            {
                $arrSubtext = explode(',', $Child_Field_Subtext);
                $Child_Field_Subtext='';
                foreach($arrSubtext as $subtext)
                {
                    $subtext = trim($subtext);
                    if($Child_Field_Subtext != '') $Child_Field_Subtext .= ',';
                    $Child_Field_Subtext .= "'$subtext'";
                }
            }

            //Finally, get the involved table&field name
            if($Relation == '1-1')
            {
                $stmt = $d->prepare("SELECT b.Field_Name, c.Table_Name
                                            FROM table_relations a, table_fields b, \"table\" c
                                            WHERE a.Relation_ID = :r_id AND
                                                  a.Parent_Field_ID = b.Field_ID AND
                                                  b.Table_ID = c.Table_ID");
                $stmt->bindValue(':r_id', $Relation_ID);
            }
            elseif($Relation == '1-M')
            {
                $stmt = $d->prepare("SELECT b.Field_Name, c.Table_Name
                                            FROM table_relations a, table_fields b, \"table\" c
                                            WHERE a.Relation_ID = :r_id AND
                                                  a.Child_Field_ID = b.Field_ID AND
                                                  b.Table_ID = c.Table_ID");
                $stmt->bindValue(':r_id', $Relation_ID);
            }

            if($result = $stmt->execute())
            {
                $data = $result->fetchArray(SQLITE3_NUM);
                $Involved_Field = $data[0];
                $Involved_Table = $data[1];
            }
            $stmt->close();

            if($Involved_Field == $Link_child)
            {
                $Alias = '';
            }
            else
            {
                $Alias = $Link_child;
            }

            if($put_comma) $relations .= ",\n                           ";

            if($Relation == '1-1')
            {
                $relations .= "array('type'=>'$Relation',
                                 'table'=>'$Involved_Table',
                                 'alias'=>'$Alias',
                                 'link_parent'=>'$Involved_Field',
                                 'link_child'=>'$Link_child',
                                 'link_subtext'=>array($Child_Field_Subtext),
                                 'where_clause'=>'')";
            }
            elseif($Relation == '1-M')
            {
                $relations .= "array('type'=>'$Relation',
                                 'table'=>'$Involved_Table',
                                 'link_parent'=>'$Link_child',
                                 'link_child'=>'$Involved_Field',
                                 'where_clause'=>'')";
            }

            $put_comma = TRUE;

        }

        //Section above retrieved relationships of parent; this one retrieves relationships of a child (the "M") in a 1-M relationship
        $stmt = $d->prepare("SELECT a.Relation_ID, a.Relation, a.Child_Field_ID, a.Child_Field_Subtext, b.Field_Name
                                FROM table_relations a, table_fields b
                                WHERE a.Child_Field_ID = b.Field_ID AND b.Table_ID = :t_id AND a.Relation='ONE-to-MANY'");
        $stmt->bindValue(':t_id', $Table_ID);

        $arr_child_data = array();
        if($result = $stmt->execute())
        {
            while($data = $result->fetchArray())
            {
                $arr_child_data[] = $data;
            }
        }
        $stmt->close();

        $rel_index = 0;
        foreach($arr_child_data as $data)
        {
            ++$rel_index;
            extract($data);

            $Link_child = $Field_Name;
            //2014-12-03
            //This will be used in PHASE 3, in case this Foreign Key connected to Parent is not defined as Primary Key.
            $foreign_field = $Field_Name;

            $stmt = $d->prepare("SELECT b.Field_Name, c.Table_Name
                                        FROM table_relations a, table_fields b, \"table\" c
                                        WHERE a.Relation_ID = :r_id AND
                                              a.Parent_Field_ID = b.Field_ID AND
                                              b.Table_ID = c.Table_ID");
            $stmt->bindValue(':r_id', $Relation_ID);
            if($result = $stmt->execute())
            {
                $data = $result->fetchArray(SQLITE3_NUM);
                $Involved_Field = $data[0];
                $Involved_Table = $data[1];
            }
            $stmt->close();

            if($Involved_Field == $Link_child)
            {
                $Alias = '';
            }
            else
            {
                $Alias = $Link_child;
            }

            if($put_comma) $relations .= ",\n                           ";

            $relations .= "array('type'=>'M-1',
                             'table'=>'$Involved_Table',
                             'alias'=>'$Alias',
                             'link_parent'=>'$Involved_Field',
                             'link_child'=>'$Link_child',
                             'minimum'=>1,
                             'where_clause'=>'')";

            $put_comma = TRUE;
        }
    }
    $relations .= ');';


    //PHASE 3: Creating the subclass methods.
    //Using the fields conveniently aggregated into $fields_array, we simply create a set of generic methods for this subclass,
    //namely Add, Edit, Delete, and Select queries.
    //Primary keys can be found by looking at the $field_attributes_array. If an index contains "Primary Key", then the same index
    //in the $fields_array contains the primary key field.

    $num_fields = count($field_array);

    $edit_field_list='';
    $field_list='';
    $value_list='';
    $primary_key_list='';
    $get_orig_edit_keys='';             //Necessary to make the $parameterized_edit_field_list_for_keys work if there is an orig_ key involved (editable primary key field)
    $edit_primary_key_list='';          //We create a separate primary key list for the edit and delete queries because the edit query
    $delete_primary_key_list='';        //needs to make sure that editable primary key fields are compared with their original values.
    $reverse_edit_primary_key_list='';  //This one is identical to edit_primary_key_list, except that '=' is changed to '!=', and 'AND' is changed to 'OR', for uniqueness checking in edit scenarios
    $delete_many_primary_key_list='';   //Similar to delete_primary_key_list, but for the delete_many method meant for deleting all child records of a parent record.

    $temp_auto_id_key='';               //To hold any auto_id keys. If the table has no other identifiers, this will be used. Otherwise, the value here will simply be discarded.
    $temp_parameterized_edit_field_list_for_keys='';
    $temp_parameterized_edit_field_types_for_keys='';
    $temp_parameterized_delete_field_list_for_keys='';

    $temp_reverse_auto_id_key='';       //As above, but for the use of the reverse_edit_primary_key_list var.
    $temp_parameterized_uniqueness_edit_field_list = '';
    $temp_parameterized_uniqueness_edit_field_types = '';

    $parameterized_field_list='';       //Same content as field list, but formatted differently and uses $param[$var] instead of the $var directly, where $var is the field.
    $parameterized_field_types='';      //type specifier (i,d,s,b) for the prepared statement in the add method.
    $parameterized_edit_field_list='';  //Same content as edit_field_list, but formatted differently and uses $param[$var] instead of the $var directly, where $var is the field.
    $parameterized_edit_field_types=''; //type specifier (i,d,s,b) for the prepared statement in the edit methid.
    $parameterized_edit_field_list_for_keys='';  //Temp holder for parameterized edit field list derived from keys (where clause), because they should be appended at the end of $parameterized_edit_field_list
    $parameterized_edit_field_types_for_keys=''; //Temp holder for parameterized edit field types derived from keys (where clause), because they should be appended at the end of $parameterized_edit_field_types
    $parameterized_delete_field_list='';  //Same as parameterized_edit_field_list, but meant for delete method
    $parameterized_delete_field_types=''; //type specifier (i,d,s,b) for the prepared statement in the delete method.
    $parameterized_delete_many_field_list='';  //Same as parameterized_delete_field_list, but meant for delete_many method
    $parameterized_delete_many_field_types=''; //type specifier (i,d,s,b) for the prepared statement in the delete_many method.
    $parameterized_uniqueness_field_list='';  //Same as parameterized_delete_field_list, but meant for check_uniqueness method
    $parameterized_uniqueness_field_types=''; //type specifier (i,d,s,b) for the prepared statement in the check_uniqueness method.
    $parameterized_uniqueness_edit_field_list=''; //Same as parameterized_edit_field_list, but meant for check_uniqueness_for_editing method.
    $parameterized_uniqueness_edit_field_types='';//type specifier (i,d,s,b) for the prepared statement in the check_uniqueness_for_editing method.
    for($a=0; $a<$num_fields; $a++)
    {
        $field_list.= $field_array[$a] . ", ";
        $value_list.="?,";
        if($parameterized_field_list == '')
        {
            $parameterized_field_list .= '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
        }
        else
        {
            $parameterized_field_list .= "\r\n" . "                                 " . '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
        }
        $parameterized_field_types .= $field_data_type_array[$a];


        if($field_attribute_array[$a] != "primary key" && $field_attribute_array[$a] != "primary&foreign key")
        {
            $edit_field_list.= $field_array[$a] . " = ?, ";
            if($parameterized_edit_field_list == '')
            {
                $parameterized_edit_field_list .= '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
            }
            else
            {
                $parameterized_edit_field_list .= "\r\n" . "                                 " . '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
            }
            $parameterized_edit_field_types .= $field_data_type_array[$a];

            if($field_attribute_array[$a] == "foreign key" && $field_array[$a] == $foreign_field)
            {
                //2014-12-03
                //This branch was added to complement line 459-461 above (dated 2014-12-03), so that any foreign key from parent
                //will be used in delete_many even if not defined as primary key
                $delete_many_primary_key_list .= $field_array[$a] . " = ? AND ";
                if($parameterized_delete_many_field_list == '')
                {
                    $parameterized_delete_many_field_list .= '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
                }
                else
                {
                    $parameterized_delete_many_field_list .= "\r\n" . "                             " . '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
                }
                $parameterized_delete_many_field_types .= $field_data_type_array[$a];
            }

        }
        elseif(($field_attribute_array[$a] == "primary key" || $field_attribute_array[$a] == "primary&foreign key") && $field_control_array[$a] != 'none')
        {
            $edit_field_list.= $field_array[$a] . " = ?, ";
            if($parameterized_edit_field_list == '')
            {
                $parameterized_edit_field_list .= '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
            }
            else
            {
                $parameterized_edit_field_list .= "\r\n" . "                                 " . '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
            }
            $parameterized_edit_field_types .= $field_data_type_array[$a];


            //Here, for primary key fields that are editable (they have a control specified), they are compared
            //to their original value (value before the edit happened), hence the "$Orig_" prefix to the variable name.
            $edit_primary_key_list .= $field_array[$a] . " = ? AND ";
            $parameterized_edit_field_list_for_keys .= "\r\n" . "                                 " . '$param[' . "'" . 'orig_' . "$field_array[$a]'" . '],';
            $parameterized_edit_field_types_for_keys .= $field_data_type_array[$a];

            //This wil be needed to make the above work as expected
            $get_orig_edit_keys = <<<EOD
        //Next two lines just to get the orig_ pkey(s) from \$param
        \$this->escape_arguments(\$param);
        extract(\$param);
EOD;

            $reverse_edit_primary_key_list .= $field_array[$a] . " != '\$orig_" . $field_array[$a] . "' OR ";

            $delete_primary_key_list .= $field_array[$a] . " = ? AND ";
            if($parameterized_delete_field_list == '')
            {
                $parameterized_delete_field_list .= '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
            }
            else
            {
                $parameterized_delete_field_list .= "\r\n" . "                             " . '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
            }
            $parameterized_delete_field_types .= $field_data_type_array[$a];

            $delete_many_primary_key_list .= $field_array[$a] . " = ? AND ";
            if($parameterized_delete_many_field_list == '')
            {
                $parameterized_delete_many_field_list .= '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
            }
            else
            {
                $parameterized_delete_many_field_list .= "\r\n" . "                             " . '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
            }
            $parameterized_delete_many_field_types .= $field_data_type_array[$a];
        }
        elseif(($field_attribute_array[$a] == "primary key" || $field_attribute_array[$a] == "primary&foreign key") && $field_control_array[$a] == 'none')
        {
            if(strtoupper($field_auto_increment_array[$a]) == 'TRUE')
            {
                $edit_primary_key_list .= $field_array[$a] . " = ? AND ";
                $parameterized_edit_field_list_for_keys .= "\r\n" . "                                 " . '&$this->fields[' . "'" .  "$field_array[$a]'" . '][\'value\'],';
                $parameterized_edit_field_types_for_keys .= $field_data_type_array[$a];

                $reverse_edit_primary_key_list .= $field_array[$a] . " != ? OR ";
                $parameterized_uniqueness_edit_field_list .= "\r\n" . "                             " . '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
                $parameterized_uniqueness_edit_field_types .= $field_data_type_array[$a];

                $delete_primary_key_list .= $field_array[$a] . " = ? AND ";
                if($parameterized_delete_field_list == '')
                {
                    $parameterized_delete_field_list .= '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
                }
                else
                {
                    $parameterized_delete_field_list .= "\r\n" . "                             " . '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
                }
                $parameterized_delete_field_types .= $field_data_type_array[$a];
            }
            else
            {
                $edit_primary_key_list .= $field_array[$a] . " = ? AND ";
                $parameterized_edit_field_list_for_keys .= "\r\n" . "                                 " . '&$this->fields[' . "'" .  "$field_array[$a]'" . '][\'value\'],';
                $parameterized_edit_field_types_for_keys .= $field_data_type_array[$a];

                $reverse_edit_primary_key_list .= $field_array[$a] . " != ? OR ";
                $parameterized_uniqueness_edit_field_list .= "\r\n" . "                             " . '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
                $parameterized_uniqueness_edit_field_types .= $field_data_type_array[$a];

                $delete_primary_key_list .= $field_array[$a] . " = ? AND ";
                if($parameterized_delete_field_list == '')
                {
                    $parameterized_delete_field_list .= '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
                }
                else
                {
                    $parameterized_delete_field_list .= "\r\n" . "                             " . '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
                }
                $parameterized_delete_field_types .= $field_data_type_array[$a];

                $delete_many_primary_key_list .= $field_array[$a] . " = ? AND ";
                if($parameterized_delete_many_field_list == '')
                {
                    $parameterized_delete_many_field_list .= '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
                }
                else
                {
                    $parameterized_delete_many_field_list .= "\r\n" . "                             " . '&$this->fields[' . "'$field_array[$a]'" . '][\'value\'],';
                }
                $parameterized_delete_many_field_types .= $field_data_type_array[$a];
            }
        }
    }

    $parameterized_edit_field_list .= $parameterized_edit_field_list_for_keys;
    $parameterized_edit_field_types.= $parameterized_edit_field_types_for_keys;
    $parameterized_uniqueness_field_list = $parameterized_delete_field_list;
    $parameterized_uniqueness_field_types = $parameterized_delete_field_types;
    $parameterized_uniqueness_edit_field_list = $parameterized_delete_field_list . $parameterized_uniqueness_edit_field_list;
    $parameterized_uniqueness_edit_field_types = $parameterized_delete_field_types . $parameterized_uniqueness_edit_field_types;

    //Remove last comma
    $value_list = substr($value_list,0, strlen($value_list)-1);
    $parameterized_field_list = substr($parameterized_field_list,0, strlen($parameterized_field_list)-1);
    $parameterized_delete_field_list = substr($parameterized_delete_field_list,0, strlen($parameterized_delete_field_list)-1);
    $parameterized_delete_many_field_list = substr($parameterized_delete_many_field_list,0, strlen($parameterized_delete_many_field_list)-1);
    $parameterized_edit_field_list = substr($parameterized_edit_field_list,0, strlen($parameterized_edit_field_list)-1);
    $parameterized_uniqueness_field_list = substr($parameterized_uniqueness_field_list,0, strlen($parameterized_uniqueness_field_list)-1);
    $parameterized_uniqueness_edit_field_list = substr($parameterized_uniqueness_edit_field_list,0, strlen($parameterized_uniqueness_edit_field_list)-1);

    //Remove the last comma and whitespace:
    $field_list = substr($field_list,0, strlen($field_list)-2);
    $edit_field_list = substr($edit_field_list,0, strlen($edit_field_list)-2);

    //Remove the last 'AND' and whitespace:
    $primary_key_list = substr($primary_key_list,0, strlen($primary_key_list)-5);
    $edit_primary_key_list = substr($edit_primary_key_list,0, strlen($edit_primary_key_list)-5);
    $reverse_edit_primary_key_list = substr($reverse_edit_primary_key_list,0, strlen($reverse_edit_primary_key_list)-4);
    $delete_primary_key_list = substr($delete_primary_key_list,0, strlen($delete_primary_key_list)-5);
    $delete_many_primary_key_list = substr($delete_many_primary_key_list,0, strlen($delete_many_primary_key_list)-5);

    //For the methods that check the uniqueness of a new record being added or edited, they use similar
    //primary key lists to the edit and delete primary key lists.
    $check_uniqueness_primary_key_list = $delete_primary_key_list;
    $check_uniqueness_for_editing_primary_key_list = $delete_primary_key_list . ' AND (' . $reverse_edit_primary_key_list . ')';

    //PHASE 4: Defining the data dictionary class file (no-brainer)
    $DD_filename = $Table_Name . '_dd.php';
    $DD_classname = $Table_Name . '_dd';

    //END: Before writing to the file itself, aggregate all content into $subclass_content (data abstraction subclass)



$delete_many_method = <<<EOD

    function delete_many(\$param)
    {
        \$this->set_parameters(\$param);
        \$this->set_query_type('DELETE');
        \$this->set_where("$delete_many_primary_key_list");

        \$bind_params = array('$parameterized_delete_many_field_types',
                             $parameterized_delete_many_field_list);

        \$this->stmt_prepare(\$bind_params);
        \$this->stmt_execute();
        \$this->stmt_close();

        return \$this;
    }

EOD;

    $subclass_content = <<<EOD
<?php
require_once '$DD_filename';
class $Table_Name extends data_abstraction
{
    var \$fields = array();
$database_connection_variables

    function __construct()
    {
        \$this->fields     = $DD_classname::load_dictionary();
        \$this->relations  = $DD_classname::load_relationships();
        \$this->subclasses = $DD_classname::load_subclass_info();
        \$this->table_name = $DD_classname::\$table_name;
        \$this->tables     = $DD_classname::\$table_name;
    }

    function add(\$param)
    {
        \$this->set_parameters(\$param);

        if(\$this->stmt_template=='')
        {
            \$this->set_query_type('INSERT');
            \$this->set_fields('$field_list');
            \$this->set_values("$value_list");

            \$bind_params = array('$parameterized_field_types',
                                 $parameterized_field_list);

            \$this->stmt_prepare(\$bind_params);
        }

        \$this->stmt_execute();
        return \$this;
    }

    function edit(\$param)
    {
        \$this->set_parameters(\$param);

        if(\$this->stmt_template=='')
        {
            \$this->set_query_type('UPDATE');
            \$this->set_update("$edit_field_list");
            \$this->set_where("$edit_primary_key_list");

            \$bind_params = array('$parameterized_edit_field_types',
                                 $parameterized_edit_field_list);

            \$this->stmt_prepare(\$bind_params);
        }
        \$this->stmt_execute();

        return \$this;
    }

    function delete(\$param)
    {
        \$this->set_parameters(\$param);
        \$this->set_query_type('DELETE');
        \$this->set_where("$delete_primary_key_list");

        \$bind_params = array('$parameterized_delete_field_types',
                             $parameterized_delete_field_list);

        \$this->stmt_prepare(\$bind_params);
        \$this->stmt_execute();
        \$this->stmt_close();

        return \$this;
    }
$delete_many_method
    function select()
    {
        \$this->set_query_type('SELECT');
        \$this->exec_fetch('array');
        return \$this;
    }

    function check_uniqueness(\$param)
    {
        \$this->set_parameters(\$param);
        \$this->set_query_type('SELECT');
        \$this->set_where("$check_uniqueness_primary_key_list");

        \$bind_params = array('$parameterized_uniqueness_field_types',
                             $parameterized_uniqueness_field_list);

        \$this->stmt_prepare(\$bind_params);
        \$this->stmt_execute();
        \$this->stmt_close();

        if(\$this->num_rows > 0) \$this->is_unique = FALSE;
        else \$this->is_unique = TRUE;

        return \$this;
    }

    function check_uniqueness_for_editing(\$param)
    {
        \$this->set_parameters(\$param);
$get_orig_edit_keys

        \$this->set_query_type('SELECT');
        \$this->set_where("$check_uniqueness_for_editing_primary_key_list");

        \$bind_params = array('$parameterized_uniqueness_edit_field_types',
                             $parameterized_uniqueness_edit_field_list);

        \$this->stmt_prepare(\$bind_params);
        \$this->stmt_execute();
        \$this->stmt_close();

        if(\$this->num_rows > 0) \$this->is_unique = FALSE;
        else \$this->is_unique = TRUE;

        return \$this;
    }
}

EOD;

    //Write to the file - data abstraction subclass
    $filename = $subclass_path .  $Table_Name . '.php';
    if(file_exists($filename)) unlink($filename);
    $newfile=fopen($filename,"ab");
    fwrite($newfile, $subclass_content);
    fclose($newfile);
    chmod($filename, 0777);


    //Aggregate all content to $subclass_content, this time for the HTML subclass.
    $Table_Name_HTML = $Table_Name . '_html';

    $subclass_content = <<<EOD
<?php
require_once '$DD_filename';
class $Table_Name_HTML extends html
{
    function __construct()
    {
        \$this->fields        = $DD_classname::load_dictionary();
        \$this->relations     = $DD_classname::load_relationships();
        \$this->subclasses    = $DD_classname::load_subclass_info();
        \$this->table_name    = $DD_classname::\$table_name;
        \$this->readable_name = $DD_classname::\$readable_name;
    }
}

EOD;

    //Write to the file - HTML subclass
    $filename_HTML = $subclass_path .  $Table_Name . '_html.php';
    if(file_exists($filename_HTML)) unlink($filename_HTML);
    $newfile_HTML=fopen($filename_HTML,"ab");
    fwrite($newfile_HTML, $subclass_content);
    fclose($newfile_HTML);
    chmod($filename_HTML, 0777);



    //Aggregate all content to $subclass_content, this time for the rpt (report) subclass.
    $Table_Name_RPT = $Table_Name . '_rpt';
    $session_array_name = strtoupper($Table_Name) . '_REPORT_CUSTOM';
    $result_page = 'reporter_result_' . $Table_Name . '.php';
    $cancel_page = 'listview_' . $Table_Name . '.php';
    $report_title = '%%: Custom Reporting Tool';
    $pdf_reporter_filename = 'reporter_pdfresult_' . $Table_Name . '.php';

    $subclass_content = <<<EOD
<?php
require_once '$DD_filename';
class $Table_Name_RPT extends reporter
{
    var \$tables='';
    var \$session_array_name = '$session_array_name';
    var \$report_title = '$report_title';
    var \$html_subclass = '$Table_Name_HTML';
    var \$data_subclass = '$Table_Name';
    var \$result_page = '$result_page';
    var \$cancel_page = '$cancel_page';
    var \$pdf_reporter_filename = '$pdf_reporter_filename';

    function __construct()
    {
        \$this->fields        = $DD_classname::load_dictionary();
        \$this->relations     = $DD_classname::load_relationships();
        \$this->subclasses    = $DD_classname::load_subclass_info();
        \$this->table_name    = $DD_classname::\$table_name;
        \$this->tables        = $DD_classname::\$table_name;
        \$this->readable_name = $DD_classname::\$readable_name;
        \$this->get_report_fields();
    }
}

EOD;

    //Write to the file - rpt (report) subclass
    $filename_RPT = $subclass_path .  $Table_Name . '_rpt.php';
    if(file_exists($filename_RPT)) unlink($filename_RPT);
    $newfile_RPT=fopen($filename_RPT,"ab");
    fwrite($newfile_RPT, $subclass_content);
    fclose($newfile_RPT);
    chmod($filename_RPT, 0777);

    //Aggregate all content to $subclass_content, this time for the SST subclass.
    $Table_Name_SST = $Table_Name . '_sst';

    $subclass_content = <<<EOD
<?php
require_once 'sst_class.php';
require_once '$DD_filename';
class $Table_Name_SST extends sst
{
    function __construct()
    {
        \$this->fields        = $DD_classname::load_dictionary();
        \$this->relations     = $DD_classname::load_relationships();
        \$this->subclasses    = $DD_classname::load_subclass_info();
        \$this->table_name    = $DD_classname::\$table_name;
        \$this->readable_name = $DD_classname::\$readable_name;
        parent::__construct();
    }
}

EOD;

    //Write to the file - SST subclass
    $filename_SST = $subclass_path .  $Table_Name . '_sst.php';
    if(file_exists($filename_SST)) unlink($filename_SST);
    $newfile_SST=fopen($filename_SST,"ab");
    fwrite($newfile_SST, $subclass_content);
    fclose($newfile_SST);
    chmod($filename_SST, 0777);

    //Aggregate all content to $subclass_content, this time for the doc subclass.
    $Table_Name_Doc = $Table_Name . '_doc';

    $subclass_content = <<<EOD
<?php
require_once 'documentation_class.php';
require_once '$DD_filename';
class $Table_Name_Doc extends documentation
{
    function __construct()
    {
        \$this->fields        = $DD_classname::load_dictionary();
        \$this->relations     = $DD_classname::load_relationships();
        \$this->subclasses    = $DD_classname::load_subclass_info();
        \$this->table_name    = $DD_classname::\$table_name;
        \$this->readable_name = $DD_classname::\$readable_name;
        parent::__construct();
    }
}

EOD;

    //Write to the file - Doc subclass
    $filename_doc = $subclass_path .  $Table_Name . '_doc.php';
    if(file_exists($filename_doc)) unlink($filename_doc);
    $newfile_doc=fopen($filename_doc,"ab");
    fwrite($newfile_doc, $subclass_content);
    fclose($newfile_doc);
    chmod($filename_doc, 0777);


    //*******************************************************
    //Define the data dictionary class before writing to file

    //Here, we just set the filenames of the two subclasses, this will
    //also be stored by the data dictionary class
    $HTML_subclass_file = $Table_Name_HTML . '.php';
    $Data_subclass_file = $Table_Name . '.php';

    $Readable_Name = ucwords(str_replace('_', ' ', $Table_Name));
    $data_dictionary_class = <<<EOD
<?php
class $DD_classname
{
    static \$table_name = '$Table_Name';
    static \$readable_name = '$Readable_Name';

    static function load_dictionary()
    {
        $fields
        return \$fields;
    }

    static function load_relationships()
    {
        $relations

        return \$relations;
    }

    static function load_subclass_info()
    {
        \$subclasses = array('html_file'=>'$HTML_subclass_file',
                            'html_class'=>'$Table_Name_HTML',
                            'data_file'=>'$Data_subclass_file',
                            'data_class'=>'$Table_Name');
        return \$subclasses;
    }

}
EOD;

    //Write to the file - DD subclass
    $filename_DD = $subclass_path .  $Table_Name . '_dd.php';
    if(file_exists($filename_DD)) unlink($filename_DD);
    $newfile_DD=fopen($filename_DD,"ab");
    fwrite($newfile_DD, $data_dictionary_class);
    fclose($newfile_DD);
    chmod($filename_DD, 0777);

}
