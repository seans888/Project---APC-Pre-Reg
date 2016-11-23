<?php
$class_name_spaced = ucwords(str_replace('_',' ',$class_name));
$show_in_tasklist = 'No';
$module_permission_count = 0; //This module needs no extra permission, because it relies on the generic view permission

//Now let's get the number of fields we have, we'll get to use this information a lot.
$field_count = count($field);

//All primary key fields are aggregated in $Primary_Keys array.
$Primary_Keys= array();

//$Get_Primary_Keys is a string aggregate of primary keys that will be used to check if the proper keys have been passed; the string
//of primary keys will be formatted as follows: $Get_Primary_Keys = "isset($PK1) && isset($PK2) && isset($PK3)".
$Get_Primary_Keys = '';

//$Where_Primary_Keys is a string aggregate of primary keys that will be used as the WHERE clause in the main SELECT statement
//of the Edit function (querying the data of the chosen record to edit). This will be formatted as follows:
//$Where_Primary_Keys = "$PK1='$$PK1' AND $PK2='$$PK2' AND $PK3='$$PK3'";
$Where_Primary_Keys = '';

for($a=0;$a<$field_count;$a++)
{
    if($field[$a]['Attribute']=='primary key' || $field[$a]['Attribute']=='primary&foreign key')
    {
        $Primary_Keys[] = $field[$a]['Field_Name'];
        $Get_Primary_Keys .= "isset(\$_GET['{$field[$a]['Field_Name']}']) && ";

        $Where_Primary_Keys .= "{$field[$a]['Field_Name']}='\" . quote_smart(\${$field[$a]['Field_Name']}) . \"' AND ";
    }
}
$Get_Primary_Keys = substr($Get_Primary_Keys, 0, strlen($Get_Primary_Keys)-4); //Removed the last spaces and ampersand.
$Where_Primary_Keys = substr($Where_Primary_Keys, 0, strlen($Where_Primary_Keys)-5); //Removed the last space and 'AND' keyword.

//All primary keys should be run against urldecode since they were urlencoded in listview
$urldecode_script='';
foreach($Primary_Keys as $primary_key)
{
    if(!empty($urldecode_script))
    {
        $urldecode_script .= "\r\n";
    }
    $urldecode_script .= "    \$$primary_key = urldecode(\$_GET['$primary_key']);";
}

//Check to see if some fields are set to use Date Controls
//If one or more are, then we need to add something to the processing part later
$Date_Controls_Explode='';
for($a=0;$a<$field_count;$a++)
{
    if($field[$a]['Control_Type']=='date controls')
    {
        $field_name   = $field[$a]['Field_Name'];
        $dc_year[$a]  = $field_name . '_year';
        $dc_month[$a] = $field_name . '_month';
        $dc_day[$a]   = $field_name . '_day';

        if($field[$a]['Data_Type'] != 'unix timestamp')
        {
            $Date_Controls_Explode.=<<<EOD

    \$data = explode('-',\$$field_name);
    if(count(\$data) == 3)
    {
        \$$dc_year[$a] = \$data[0];
        \$$dc_month[$a] = \$data[1];
        \$$dc_day[$a] = \$data[2];
    }
EOD;
        }
    }
}


//We need to check if the current table is a parent table in a 1-M relationship.
//If it is, we need to go find its child table(s).
//For each child table, we need to create a loop that will select all records of
//that child table for the current value of the primary key.

$Child_Table_Select_Script = '';
$multifield_controls       = '';
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
    while($data = $result->fetchArray())
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
        $Child_Field_ID = $data[0];
        $Child_Field_Name = $data[1];
        $Parent_Field_Name = $data[2];

        $stmt = $d->prepare("SELECT a.Table_Name, a.Table_ID FROM \"table\" a, table_fields b WHERE b.Field_ID=':f_id' AND b.Table_ID=a.Table_ID");
        $stmt->bindValue(':f_id', $Child_Field_ID);
        if($result = $stmt->execute())
        {
            $data = $result->fetchArray();
        }
        $stmt->close();

        $Child_Table_Name = $data[0];
        $Child_Table_ID = $data[1];
        $Child_Classfile = $Child_Table_Name . '.php';
        $Child_Num_Particulars = 'num_' . $Child_Table_Name; //The specialized '$numParticulars' variable.

        //Now let's get the fields of the child table.
        //Although all we need right now is the field name and attribute, we also get a few more fields
        //and store all info in an array to avoid having to re-query later on when we need the child fields again
        //along with their relevant information.
        $Child_Table_Fields_Info = array('Field_Name'=>array(),
                                         'Field_ID'=>array(),
                                         'Control_Type'=>array(),
                                         'Label'=>array());
        $Child_Table_Where_Clause='';
        $Child_Table_Set_Fields='';
        $Child_Table_Fields_Assignment='';

        $stmt = $d->prepare("SELECT Field_ID AS Child_Field_ID, Field_Name, Attribute, Auto_Increment, Control_Type, Label
                                FROM table_fields WHERE Table_ID=:t_id");
        $stmt->bindValue(':t_id', $Child_Table_ID);
        if($result = $stmt->execute())
        {
            $inner_cntr = 0;
            while($data = $result->fetchArray())
            {
                extract($data);

                $Field_Var = '';
                if($Attribute=='primary key' && $Auto_Increment == 'TRUE')
                {
                    //Do nothing... ignore all auto_id's.
                }
                else
                {
                    if($Control_Type!='none' && $Field_Name != $Child_Field_Name)
                    {
                        //All non-primary-key fields will be stored in an array
                        //The "cf_" prepended is needed so that the field name of the child field will never collide with a similarly
                        //named field in the parent.
                        //The "$Child_Table_Name" prepended is needed so that the field name of the child field will never collide
                        //with a similarly named field in another child of the parent.
                        $Field_Var = '$cf_' . $Child_Table_Name . '_'  . $Field_Name . '[$a]';
                        $Child_Table_Fields_Info['Field_Name'][] = 'cf_' . $Child_Table_Name . '_' . $Field_Name;
                        $Child_Table_Fields_Info['Field_ID'][] = $Child_Field_ID;
                        $Child_Table_Fields_Info['Control_Type'][] = $Control_Type;
                        $Child_Table_Fields_Info['Label'][] = $Label;

                        $Child_Table_Set_Fields .= $Field_Name . ', ';

                        if($Control_Type == 'date controls')
                        {


                            $Child_Table_Fields_Assignment.=<<<EOD
        \$data_temp_cf_date = explode('-',\$data[$inner_cntr]);
        \$cf_{$Child_Table_Name}_{$Field_Name}_year[\$a] = \$data_temp_cf_date[0];
        \$cf_{$Child_Table_Name}_{$Field_Name}_month[\$a] = \$data_temp_cf_date[1];
        \$cf_{$Child_Table_Name}_{$Field_Name}_day[\$a] = \$data_temp_cf_date[2];

EOD;
                        }
                        else
                        {
                            $Child_Table_Fields_Assignment.=<<<EOD
        \$cf_{$Child_Table_Name}_{$Field_Name}[\$a] = \$data[$inner_cntr];

EOD;
                        }
                        ++$inner_cntr;
                    }
                    else //This means it's a primary and/or foreign key, no "cf_" needed in the name
                    {
                        $Field_Var = '$' . $Parent_Field_Name;
                        $Child_Table_Where_Clause .= $Field_Name . '=\'" . quote_smart(' . $Field_Var . ') . "\' AND ';
                    }
                }
            }
        }
        $stmt->close();

        $Child_Table_Where_Clause = substr($Child_Table_Where_Clause, 0, strlen($Child_Table_Where_Clause) - 5); //Removed the last 'AND' along with its spaces.
        $Child_Table_Set_Fields = substr($Child_Table_Set_Fields, 0, strlen($Child_Table_Set_Fields) - 2); //Removed the last space and comma.
        $Child_Table_Fields_Assignment = substr($Child_Table_Fields_Assignment, 0, strlen($Child_Table_Fields_Assignment) - 1); //Removed the last newline.

        $Child_Table_Select_Script.=<<<EOD
    require_once 'subclasses/$Child_Classfile';
    {$dbh_name} = new $Child_Table_Name;
    {$dbh_name}->set_fields('$Child_Table_Set_Fields');
    {$dbh_name}->set_where("$Child_Table_Where_Clause");
    if(\$result = {$dbh_name}->make_query()->result)
    {
        \$$Child_Num_Particulars = {$dbh_name}->num_rows;
        for(\$a=0; \$a<\$$Child_Num_Particulars; \$a++)
        {
            \$data = \$result->fetch_row();
$Child_Table_Fields_Assignment
        }
    }


EOD;

        //After finishing 1 full run of a child table creating its entire add script, now we create the multifield control for it.
        require_once 'Multifield_script.php';

        $child_field_count = count($Child_Table_Fields_Info['Field_Name']);

        $child_field_labels = '';
        $child_field_controls = '';
        $child_field_parameters = '';
        $multifield_setup = '';
        for($b=0; $b<$child_field_count; ++$b)
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
                            $child_field_controls .= "'draw_text_field_mf',";
                            $child_field_parameters .=<<<EOD
                                                    array('{$Child_Table_Fields_Info['Field_Name'][$b]}','text'),

EOD;
                        }
                        else
                        {
                            $USE_MULTIFIELD_SETUP = 'SQL Generated';
                            $child_field_controls .= "'draw_select_field_from_query_MF',";

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
\$html->detail_view = TRUE;
\$html->draw_multifield_auto('$multifield_heading', \$multifield_settings, '$Child_Num_Particulars');

EOD;

    }
}


//Create helper "form_data_" file (unifies form data fetching for detailview/edit/delete
$helper_file_name[0] = 'form_data_' . $class_name . '.php';
$helper_script[0]=<<<EOD
<?php
require 'components/get_listview_referrer.php';

require 'subclasses/$class_file';
{$dbh_name} = new $class_name;
{$dbh_name}->set_where("$Where_Primary_Keys");
if(\$result = {$dbh_name}->make_query()->result)
{
    \$data = \$result->fetch_assoc();
    extract(\$data);
$Date_Controls_Explode
}

$Child_Table_Select_Script
EOD;


$script_content=<<<EOD

if($Get_Primary_Keys)
{
$urldecode_script
    require 'form_data_$class_name.php';
}

if(xsrf_guard())
{
    init_var(\$_POST['btn_back']);

    if(\$_POST['btn_back'])
    {
        log_action('Pressed cancel button');
        require 'components/query_string_standard.php';
        redirect("$List_View_Page?\$query_string");
    }
}
EOD;

//Now let's start working on the body of the module, the forms section.

$script_content.=<<<EOD

require 'subclasses/$html_subclass_file';
\$html = new $html_subclass_name;
\$html->draw_header('Detail View: %%', \$message, \$message_type);
\$html->draw_listview_referrer_info(\$filter_field_used, \$filter_used, \$page_from, \$filter_sort_asc, \$filter_sort_desc);
\$html->detail_view = TRUE;
\$html->draw_controls('view');

EOD;
