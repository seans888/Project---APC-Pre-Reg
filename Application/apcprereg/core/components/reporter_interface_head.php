<?php
$html_subclass      = $reporter->html_subclass;
$title              = $reporter->report_title;
$arr_fields         = $reporter->arr_rpt_fields;
$num_fields         = count($arr_fields);
$arr_operators      = $reporter->arr_operators;
$operator_settings  = array('items' =>$arr_operators,
                            'values'=>$arr_operators);

$html = cobalt_load_class($html_subclass);
$html->draw_header($title, $message, $message_type);
require_once FULLPATH_BASE  .'javascript/reporting_tool.php';
$html->draw_container_div_start();
$html->draw_fieldset_header('Report Details');
$html->draw_fieldset_body_start();

$reporter->draw_report_interface_header();

init_var($show_field);
init_var($sum_field);
init_var($count_field);
init_var($group_field1);
init_var($group_field2);
init_var($group_field3);
