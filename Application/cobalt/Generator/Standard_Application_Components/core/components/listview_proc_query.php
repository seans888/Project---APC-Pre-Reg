<?php
require_once 'subclasses/' . $db_subclass . '.php';
$data_con = new $db_subclass;
if(empty($join_clause))
{
    $join_clause = $data_con->get_join_clause()->join_clause;
}
$data_con->set_table($join_clause);
$data_con->set_fields($lst_fields);
if(isset($where_clause))
{
    $data_con->set_where($where_clause);
}

if($filter!='')
{
    if($data_con->where_clause != '')
    {
        $data_con->where_clause .= " AND ";
    }

    if($filter_field == '')
    {
        //No field chosen, try to find match in all fields
        $data = explode(',', $lst_filter_fields);
        $num_fields = count($data);
        for($a=0; $a<$num_fields; ++$a)
        {
            $field_to_match = trim($data[$a]);

            if($a==0)
            {
                $data_con->where_clause .= '(';
            }
            else
            {
                $data_con->where_clause .= ' OR ';
            }

            $data_con->where_clause .= "$field_to_match LIKE '%$filter%'";
        }
        $data_con->where_clause .= ')';
    }
    else
    {
        $data_con->where_clause .= "($filter_field LIKE '%$filter%')";
    }
}
else
{
    $filter_field     = '';
    $enc_filter_field = '';
}

if($filter_sort_asc != '' || $filter_sort_desc != '')
{
    $filter_string = '';
    $sort_order    = '';
    if($filter_sort_asc != '')
    {
        $key = $filter_sort_asc;
        $sort_order = 'ASC';
    }
    else
    {
        $key = $filter_sort_desc;
        $sort_order = 'DESC';
    }

    if(is_array($arr_fields[$key]))
    {
        foreach($arr_fields[$key] as $filter_sort_field)
        {
            make_list($filter_string, $filter_sort_field . ' ' . $sort_order, ', ', FALSE);
        }
    }
    elseif(isset($arr_fields[$key]))
    {
        make_list($filter_string, $arr_fields[$key] . ' ' . $sort_order, ', ', FALSE);
    }
    else
    {
        //invalid field key, ignore
    }

    if($filter_string != '')
    {
        $data_con->set_order($filter_string);
    }
}
else
{
    if(isset($default_sort_order))
    {
        $data_con->set_order($default_sort_order);
    }
}



$data_con->make_query();
$total_records = $data_con->num_rows;

require_once 'paged_result_class.php';
$pager = new paged_result($total_records, $results_per_page);
$pager->get_page_data($result_pager, $current_page);
$current_page = $pager->current_page;
$data_con->set_limit($pager->offset, $pager->records_per_page);

if(DEBUG_MODE && isset($print_settings) && $print_settings == TRUE)
{
    echo '<pre>';
    echo '$join_clause = \'' . $join_clause . '\';<br>';
    echo '$where_clause = "' . $where_clause . '";<br>';
    echo '$lst_fields = \'' . $lst_fields . '\';<br>';
    echo '$arr_fields = ';
    array_to_source($arr_fields, FALSE, 20, 6, 'custom');
    echo '<br>';
    echo '$arr_field_labels = ';
    array_to_source($arr_field_labels, FALSE, 26, 6, 'custom');
    echo '<br>';
    echo '$lst_filter_fields = \'' . $lst_filter_fields . '\';<br>';
    echo '$arr_filter_field_labels = ';
    array_to_source($arr_filter_field_labels, FALSE, 33, 6, 'custom');
    echo '<br>';
    echo '$arr_subtext_separators = ';
    array_to_source($arr_subtext_separators, FALSE, 32, 6, 'custom');
    echo '<br>';
    echo '</pre>';
}
