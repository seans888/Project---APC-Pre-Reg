<?php
require_once 'subclasses/' . $html_subclass . '.php';
$html = new $html_subclass;
$html->get_listview_fields();
if(empty($lst_fields))
{
    $lst_fields = $html->lst_fields;
}
if(empty($arr_fields))
{
    $arr_fields = $html->arr_fields;
}
if(empty($arr_field_labels))
{
    $arr_field_labels = $html->arr_field_labels;
}
if(empty($lst_filter_fields))
{
    $lst_filter_fields = $html->lst_filter_fields;
}
if(empty($arr_filter_field_labels))
{
    $arr_filter_field_labels = $html->arr_filter_field_labels;
}
if(empty($arr_subtext_separators))
{
    $arr_subtext_separators = $html->arr_subtext_separators;
}
