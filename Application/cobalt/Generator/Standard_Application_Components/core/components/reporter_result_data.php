<?php
$result_size = 0;
$arr_results = array();
foreach($arr_result_fields as $field_name)
{
    if(isset($obj_custom_report->dump[$field_name]))
    {
        $arr_results[$field_name] = $obj_custom_report->dump[$field_name];
        if($result_size==0) $result_size = count($obj_custom_report->dump[$field_name]);
    }
}

$arr_report_data             = array();
$arr_report_data['num_rows'] = $result_size;
$arr_totals_aggregator       = array();
for($i=0; $i<$result_size; ++$i)
{
    $row_count = $i+1;
    foreach($arr_result_fields as $index=>$field_name)
    {
        $alignment = $arr_column_alignments[$index];
        $format = $arr_column_formats[$index];
        $cell_value = '';
        if(substr($format,0, 13) == 'number_format')
        {
            $decimal_places = substr($format, 13);
            $cell_value = number_format($arr_results[$field_name][$i],$decimal_places);
        }
        elseif($format == 'normal')
        {
            $cell_value = $arr_results[$field_name][$i];
        }
        else
        {
            $cell_value = $format($arr_results[$field_name][$i]);
        }

        if($arr_show_sum[$index])
        {
            if(isset($arr_totals_aggregator[$index]))
            {
                $arr_totals_aggregator[$index] += $arr_results[$field_name][$i];
            }
            else
            {
                $arr_totals_aggregator[$index] = $arr_results[$field_name][$i];
            }
        }
        else
        {
            $arr_totals_aggregator[$index] = '';
        }
        $nohtml_cell_value = nl2br(cobalt_htmlentities($cell_value));
        $arr_report_data[$i][$index] = $nohtml_cell_value;
    }
}

foreach($arr_totals_aggregator as $index=>$total)
{
    $alignment = $arr_column_alignments[$index];
    $cell_value='';
    if($total === '')
    {
        //triple equal needed above instead of double equal so that "0" does not get evaluated as the same as the empty string.
        //Do nothing if no aggregator total
    }
    else
    {
        $format = $arr_column_formats[$index];
        $decimal_places = substr($format, 13);
        $cell_value = number_format($total,$decimal_places);
    }

    $arr_report_data['total'][$index] = $cell_value;
}
