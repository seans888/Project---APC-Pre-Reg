<?php
$class_name_spaced = ucwords(str_replace('_',' ',$class_name));
$show_in_tasklist = 'Yes';
$module_permission_count = 1;

//Now let's get the number of fields we have.
$field_count = count($field);

//We just need the primary keys...
$Primary_Keys='';
for($a=0;$a<$field_count;$a++)
{
    if($field[$a]['Attribute']=='primary key' || $field[$a]['Attribute']=='primary&foreign key')
    {
        $Primary_Keys .= "'{$field[$a]['Field_Name']}',";
    }
}

if($Primary_Keys != '')
{
    $Primary_Keys = substr($Primary_Keys, 0, strlen($Primary_Keys)-1); //Removed the last comma.
}

//Now we have to get the path and filename of the edit, delete, and detail view pages:
//FIXME: Why is the add path not processed here along with edit/del/detailview? Why is it in Create_Modules?
$Edit_Path = '';
$Delete_Path = '';
$DetailView_Path = '';

//Edit page first...
$mysqli->real_query("SELECT a.Path_Filename FROM table_pages a, page b WHERE a.Table_ID='$Table_ID' AND a.Page_ID=b.Page_ID AND b.Page_Name LIKE 'Edit%'");
if($result = $mysqli->store_result())
{
    while($data = $result->fetch_assoc())
        $Edit_Path = basename($data['Path_Filename']);
}
else die($mysqli->error);

if($Edit_Path=='') $Edit_Path = 'edit_' . $class_file;

//Delete page...
$mysqli->real_query("SELECT a.Path_Filename FROM table_pages a, page b WHERE a.Table_ID='$Table_ID' AND a.Page_ID=b.Page_ID AND b.Page_Name LIKE 'Delete%'");
if($result = $mysqli->store_result())
    while($data = $result->fetch_assoc())
        $Delete_Path = basename($data['Path_Filename']);

if($Delete_Path=='') $Delete_Path = 'delete_' . $class_file;

//DetailView page...
$mysqli->real_query("SELECT a.Path_Filename FROM table_pages a, page b WHERE a.Table_ID='$Table_ID' AND a.Page_ID=b.Page_ID AND b.Page_Name LIKE 'DetailView%'");
if($result = $mysqli->store_result())
    while($data = $result->fetch_assoc())
        $DetailView_Path = basename($data['Path_Filename']);

if($DetailView_Path=='') $DetailView_Path = 'detailview_' . $class_file;


//CSV module link
$mysqli->real_query("SELECT a.Path_Filename FROM table_pages a, page b WHERE a.Table_ID='$Table_ID' AND a.Page_ID=b.Page_ID AND b.Page_Name LIKE 'CSVExport%'");
if($result = $mysqli->store_result())
    while($data = $result->fetch_assoc())
        $CSV_Path = basename($data['Path_Filename']);

if($CSV_Path=='') $CSV_Path = 'csv_' . $class_file;

//reporter module link
$mysqli->real_query("SELECT a.Path_Filename FROM table_pages a, page b WHERE a.Table_ID='$Table_ID' AND a.Page_ID=b.Page_ID AND b.Page_Name LIKE 'ReporterInterface%'");
if($result = $mysqli->store_result())
    while($data = $result->fetch_assoc())
        $Reporter_Path = basename($data['Path_Filename']);

if($Reporter_Path=='') $Reporter_Path = 'reporter_' . $class_file;


$script_content=<<<EOD

\$page_title       = 'ListView: $class_name_spaced';
\$db_subclass      = '$class_name';
\$html_subclass    = '$html_subclass_name';
\$arr_pkey_name    = array($Primary_Keys);
\$results_per_page = LISTVIEW_RESULTS_PER_PAGE;

//user links / passport tags
\$add_link         = '$add_module_link_name';
\$edit_link        = '$edit_module_link_name';
\$delete_link      = '$delete_module_link_name';
\$view_link        = '$view_module_link_name';

//pages - set to empty if you don't want to include them in the listview
\$add_page         = '$add_module_link';
\$edit_page        = '$Edit_Path';
\$delete_page      = '$Delete_Path';
\$view_page        = '$DetailView_Path';
\$csv_page         = '$CSV_Path';
\$report_page      = '$Reporter_Path';

//Extra entries under operations column (name of include file, not html code)
\$operations_extra = '';

//Formatting and alignment options for data columns
\$arr_formatting   = array();
\$arr_alignment    = array();

//For custom join & select clause, you need to set the following variables so that the default
//listview components do not rely on DD data
\$join_clause       = '';
\$where_clause      = "";
\$lst_fields        = '';
\$arr_fields        = '';
\$arr_field_labels  = '';
\$lst_filter_fields = '';
\$arr_filter_field_labels = '';
\$arr_subtext_separators  = '';

//ORDER BY clause to use before a user clicks an ascending/descending column arrow.
\$default_sort_order = '';

//Uncomment \$print_settings and enable DEBUG_MODE to show the values of the settings for custom join & select
//\$print_settings=TRUE;


require 'components/listview_proc_head.php';
require 'components/listview_proc_html.php';
require 'components/listview_proc_query.php';
require 'components/listview_body_head.php';
require 'components/listview_body_data.php';
require 'components/listview_body_end.php';
EOD;
