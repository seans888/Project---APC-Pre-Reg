<?php
$add_method = 'add';
$show_in_tasklist = 'No';
$module_permission_count = 1;
$page_title = ucwords($module_link_name);

//Now let's get the number of fields we have, we'll get to use this information a lot.
$field_count = count($field);

//Check to see if some fields are set to use file uploads
//If one or more are, then we need to add something to the processing part later
$Upload_Controls_Script='';
for($a=0;$a<$field_count;$a++)
{
    if($field[$a]['Control_Type']=='upload')
    {
        $field_name = $field[$a]['Field_Name'];

        $Upload_Controls_Script .= "\r\n    \$file_upload_control_name = '$field_name';";
        $Upload_Controls_Script .= "\r\n    require 'components/upload_generic.php';";
    }
}


//We need to check if the current table is a parent table in a 1-M relationship.
//If it is, we need to go find its child table(s).
//For each child table, we need to create a loop that will call the add_ method of
//the subclass of that child table.

$Child_Table_Add_Script = '';
$multifield_controls    = '';
$stmt = $d->prepare("SELECT a.Child_Field_ID, child.Field_Name, parent.Field_Name as Parent_Field_Name
                        FROM table_relations a
                            LEFT JOIN table_fields parent ON a.Parent_Field_ID = parent.Field_ID
                            LEFT JOIN table_fields child ON a.Child_Field_ID = child.Field_ID
                        WHERE a.Relation='ONE-to-MANY' AND
                              parent.Table_ID = :t_id");
$stmt->bindValue(':t_id', $Table_ID);
if($result = $stmt->execute())
{
    $num_child_tables = 0;
    $arr_rel_data = array();
    while($data = $result->fetchArray(SQLITE3_NUM))
    {
        $arr_rel_data[] = $data;
        ++$num_child_tables;
    }
}
$stmt->close();

if($num_child_tables > 0) //We only had to keep this counter instead of going straight to a foreach is to keep the previous (pre-refactoring) indentations due to all the heredocs inside this block
{
    foreach($arr_rel_data as $data)
    {
        $Child_Field_ID    = $data[0];
        $Child_Field_Name  = $data[1];
        $Parent_Field_Name = $data[2];

        $stmt = $d->prepare("SELECT a.Table_Name, a.Table_ID FROM \"table\" a, table_fields b
                                WHERE b.Field_ID=:f_id AND b.Table_ID=a.Table_ID");
        $stmt->bindValue(':f_id', $Child_Field_ID);
        if($result = $stmt->execute())
        {
            $data = $result->fetchArray(SQLITE3_NUM);
        }
        $stmt->close();

        $Child_Table_Name = $data[0];
        $Child_Table_ID = $data[1];
        $Child_Classfile = $Child_Table_Name . '.php';
        $Child_Num_Particulars = 'num_' . $Child_Table_Name; //The specialized '$numParticulars' variable.
        $Child_Particulars_Count = $Child_Table_Name . '_count' ; //The specialized '$particularsCount' variable.
        $Child_Table_Add_Method = 'add';

        //We need to see if the child field has any field designated as 'date controls', so we can assemble the date value for it.
        $Child_Date_Field_Assembly = '';

        $stmt = $d->prepare("SELECT Field_Name FROM table_fields WHERE Table_ID=:t_id AND Control_Type='date controls'");
        $stmt->bindValue(':t_id', $Child_Table_ID);
        if($result = $stmt->execute())
        {
            while($data = $result->fetchArray())
            {
                extract($data);
                $Child_Date_Field_Assembly .= '$cf_' . $Child_Table_Name . '_' . $Field_Name . '[$a] = $cf_' . $Child_Table_Name . '_' . $Field_Name . '_year[$a] . \'-\' . $cf_' . $Child_Table_Name . '_' . $Field_Name . '_month[$a] . \'-\' . $cf_' . $Child_Table_Name . '_' . $Field_Name . '_day[$a];' .
"\r\n               ";
            }
        }
        $stmt->close();

        $Child_Table_Add_Script.=<<<EOD
            require_once 'subclasses/$Child_Classfile';
            {$dbh_name} = new $Child_Table_Name;
            for(\$a=0; \$a<\$$Child_Particulars_Count;\$a++)
            {
                $Child_Date_Field_Assembly
                \$param = array(

EOD;
        //Now let's get the fields of the child table.
        //Although all we need right now is the field name and attribute, we also get a few more fields
        //and store all info in an array to avoid having to re-query later on when we need the child fields again
        //along with their relevant information.
        $Child_Table_Fields_Info = array('Field_Name'=>array(),
                                         'Field_ID'=>array(),
                                         'Control_Type'=>array(),
                                         'Label'=>array());

        $stmt = $d->prepare("SELECT Field_ID AS 'Child_Field_ID', Field_Name, Attribute, Auto_Increment, Control_Type, Label
                                FROM table_fields WHERE Table_ID=:t_id");
        $stmt->bindValue(':t_id', $Child_Table_ID);
        if($result = $stmt->execute())
        {
            while($data = $result->fetchArray())
            {
                extract($data);

                $Field_Var='';

                if($Attribute=='primary key' && $Auto_Increment == 'TRUE')
                {
                    //Do nothing... ignore all auto_id's (i.e., auto increment primary keys)
                }
                else
                {
                    //All non-primary-key fields will be stored in an array
                    if($Control_Type!='none' && $Field_Name != $Child_Field_Name)
                    {
                        //The "cf_" prepended is needed so that the field name of the child field will never collide with a similarly
                        //named field in the parent.
                        //The "$Child_Table_Name" prepended is needed so that the field name of the child field will never collide
                        //with a similarly named field in another child of the parent.
                        $Field_Var = '$cf_' . $Child_Table_Name . '_'  . $Field_Name . '[$a]';
                        $Child_Table_Fields_Info['Field_Name'][] = 'cf_' . $Child_Table_Name . '_' . $Field_Name;
                        $Child_Table_Fields_Info['Field_ID'][] = $Child_Field_ID;
                        $Child_Table_Fields_Info['Control_Type'][] = $Control_Type;
                        $Child_Table_Fields_Info['Label'][] = $Label;
                    }
                    else //This means it's a primary and/or foreign key, no "cf_" needed in the name
                    {
                        $Field_Var = '$' . $Parent_Field_Name;
                    }
                }

                if($Field_Var!='')
                {
                    $Child_Table_Add_Script.=<<<EOD
                               '$Field_Name'=>$Field_Var,

EOD;
                }
            }
        }
        $stmt->close();
        $Child_Table_Add_Script = substr($Child_Table_Add_Script, 0, strlen($Child_Table_Add_Script) - 2); //Removed the last newline and comma.
        $Child_Table_Add_Script.=<<<EOD

                              );
                {$dbh_name}->$Child_Table_Add_Method(\$param);
            }


EOD;
        //After finishing 1 full run of a child table creating its entire add script, now we create the multifield control for it.
        require_once 'Multifield_script.php';

        $child_field_count = count($Child_Table_Fields_Info['Field_Name']);

        $child_field_labels = '';
        $child_field_controls = '';
        $child_field_parameters = '';
        $multifield_setup = '';
        for($b=0; $b<$child_field_count; $b++)
        {
            //Set Field Labels
            $child_field_labels .= "'" . ucwords($Child_Table_Fields_Info['Label'][$b]) . "',";

            $USE_MULTIFIELD_SETUP = ''; //This will contain a value if a control type is a radio button or a drop-down list.
            switch($Child_Table_Fields_Info['Control_Type'][$b])
            {
                case "textbox":
                case "textarea":
                case "special textbox":
                    $child_field_controls .= "'draw_text_field_mf',";
                    $child_field_parameters .=<<<EOD
                                                    array('{$Child_Table_Fields_Info['Field_Name'][$b]}','text'),

EOD;
                    break;
                case "date controls":
                    $child_field_controls .= "'draw_date_field_mf',";
                    $child_field_parameters .=<<<EOD
                                                    array('{$Child_Table_Fields_Info['Field_Name'][$b]}_year','{$Child_Table_Fields_Info['Field_Name'][$b]}_month','{$Child_Table_Fields_Info['Field_Name'][$b]}_day'),

EOD;
                    break;
                case "radio buttons":
                    $USE_MULTIFIELD_SETUP = 'Predefined List';
                    $child_field_controls .= "'draw_select_field_mf',";
                    break;

                case "drop-down list":

                    $stmt = $d->prepare("SELECT List_ID FROM table_fields_list WHERE Field_ID=:f_id");
                    $stmt->bindValue(':f_id', $Child_Table_Fields_Info['Field_ID'][$b]);
                    if($result = $stmt->execute())
                    {
                        $num_rows = 0;
                        while($data = $result->fetchArray())
                        {
                            ++$num_rows;
                        }

                        if($num_rows > 0)
                        {
                            $options = $Child_Table_Fields_Info['Field_Name'][$b] . '_array_options';
                            $USE_MULTIFIELD_SETUP = 'Predefined List';
                            $child_field_controls .= "'draw_select_field_mf',";
                            $child_field_parameters .=<<<EOD
                                                    array(\$$options, '{$Child_Table_Fields_Info['Field_Name'][$b]}'),

EOD;
                        }
                        else
                        {
                            $USE_MULTIFIELD_SETUP = 'SQL Generated';
                            $child_field_controls .= "'draw_select_field_from_query_mf',";

                            //The names of the variables '$query', '$list_value', and '$list_items' need to be 'specialized' for this field,
                            //so that the script will work despite having many of this type of control, otherwise, many controls of the same type
                            //will end up depending on the same variable, which obviously won't work as expected.
                            $query = $Child_Table_Fields_Info['Field_Name'][$b] . '_query';
                            $list_value = $Child_Table_Fields_Info['Field_Name'][$b] . '_list_value';
                            $list_items = $Child_Table_Fields_Info['Field_Name'][$b] . '_list_items';

                            $child_field_parameters .=<<<EOD
                                                    array(\$$query, \$$list_value, \$$list_items,'{$Child_Table_Fields_Info['Field_Name'][$b]}'),

EOD;
                        }
                    }
                    else die('Error checking for a predefined list while determining child field control type: ' . $d->lastErrorMsg);
                    $stmt->close();
                default: break;
            }

            if($USE_MULTIFIELD_SETUP!='')
            {
                $multifield_setup .= multifield_setup($USE_MULTIFIELD_SETUP,
                                                        $Child_Table_Fields_Info['Field_Name'][$b],
                                                        $Child_Table_Fields_Info['Field_ID'][$b]);
            }
        }
        $child_field_labels = substr($child_field_labels, 0, strlen($child_field_labels) - 1); //Removed last comma.
        $child_field_controls = substr($child_field_controls, 0, strlen($child_field_controls) - 1); //Removed last comma.
        $child_field_parameters = substr($child_field_parameters, 0, strlen($child_field_parameters) - 2); //Removed last newline and comma.

        //The heading for the dynamic fieldset is simply the table name, with all underscores (if any) removed.
        //Also, make sure the start of each word is uppercase.
        $multifield_heading = str_replace('_',' ',$Child_Table_Name);
        $multifield_heading = ucwords($multifield_heading);

        $multifield_controls.=<<<EOD

$multifield_setup

\$multifield_settings = array(
                             'field_labels' => array($child_field_labels),
                             'field_controls' => array($child_field_controls),
                             'field_parameters' => array(
$child_field_parameters
                                                        )
                            );
\$html->draw_multifield_auto('$multifield_heading', \$multifield_settings, '$Child_Num_Particulars', '$Child_Particulars_Count');

EOD;
        unset($Child_Table_Fields_Info);
    }
}

//If there's one or more child table, we need to see if the primary key of the
//parent table is an auto_increment field (simply, Control_Type=='None' and Attribute=='Primary')
//so we can add the fetch_auto_id_script part later in the processing part of the page.
$fetch_auto_id_script = '';
if($Child_Table_Add_Script != '')
{
    for($a=0;$a<$field_count;$a++)
    {
        if($field[$a]['Control_Type']=='none' && $field[$a]['Attribute']=='primary key')
        {
            $fetch_auto_id_script = "\${$field[$a]['Field_Name']} = {$dbh_name}->auto_id;";
        }
    }
}


$script_content=<<<EOD

require 'components/get_listview_referrer.php';

if(xsrf_guard())
{
    init_var(\$_POST['btn_cancel']);
    init_var(\$_POST['btn_submit']);
    require 'components/query_string_standard.php';
    require 'subclasses/$class_file';
    {$dbh_name} = new $class_name;

    \$object_name = '$object_name';
    require 'components/create_form_data.php';
    extract(\$arr_form_data);

    if(\$_POST['btn_cancel'])
    {
        log_action('Pressed cancel button');
        redirect("$List_View_Page?\$query_string");
    }
$Upload_Controls_Script

    if(\$_POST['btn_submit'])
    {
        log_action('Pressed submit button');

        \$message .= {$dbh_name}->sanitize(\$arr_form_data)->lst_error;
        extract(\$arr_form_data);

        if({$dbh_name}->check_uniqueness(\$arr_form_data)->is_unique)
        {
            //Good, no duplicate in database
        }
        else
        {
            \$message = "Record already exists with the same primary identifiers!";
        }

        if(\$message=="")
        {
            {$dbh_name}->$add_method(\$arr_form_data);
            $fetch_auto_id_script
$Child_Table_Add_Script
            redirect("$List_View_Page?\$query_string");
        }
    }
}
EOD;

//Now let's start working on the body of the module, the forms section.

$Extra_Flags = '';
if($Upload_Controls_Script != '')
{
    //Add flags needed by file uploads
    $Extra_Flags = ", TRUE, TRUE";
}

$script_content.=<<<EOD

require 'subclasses/$html_subclass_file';
\$html = new $html_subclass_name;
\$html->draw_header('Add %%', \$message, \$message_type$Extra_Flags);
\$html->draw_listview_referrer_info(\$filter_field_used, \$filter_used, \$page_from, \$filter_sort_asc, \$filter_sort_desc);
\$html->draw_controls('add');

EOD;
