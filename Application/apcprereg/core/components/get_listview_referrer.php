<?php
$page_from         = '';
$filter_used       = '';
$filter_field_used = '';
$filter_sort_asc   = '';
$filter_sort_desc  = '';

if(isset($_GET['filter_field_used']) && isset($_GET['filter_used']) && isset($_GET['page_from']))
{
    $page_from         = cobalt_htmlentities($_GET['page_from']);
    $filter_used       = cobalt_htmlentities($_GET['filter_used']);
    $filter_field_used = cobalt_htmlentities($_GET['filter_field_used']);
    $filter_sort_asc   = cobalt_htmlentities($_GET['filter_sort_asc']);
    $filter_sort_desc  = cobalt_htmlentities($_GET['filter_sort_desc']);
}