<?php
$page_from         = urlencode($_POST['page_from']);
$filter_used       = urlencode($_POST['filter_used']);
$filter_field_used = urlencode($_POST['filter_field_used']);
$filter_sort_asc   = urlencode($_POST['filter_sort_asc']);
$filter_sort_desc  = urlencode($_POST['filter_sort_desc']);
$query_string = "filter_field=$filter_field_used&filter=$filter_used&page_from=$page_from&filter_sort_asc=$filter_sort_asc&filter_sort_desc=$filter_sort_desc";
