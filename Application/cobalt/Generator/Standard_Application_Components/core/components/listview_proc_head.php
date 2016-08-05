<?php
$filter               = '';
$filter_field         = '';
$filter_sort_asc      = '';
$filter_sort_desc     = '';
$enc_filter           = '';
$enc_filter_field     = '';
$enc_filter_sort_asc  = '';
$enc_filter_sort_desc = '';
$result_pager         = '';
$current_page         = '';
$page_from            = '';

if(isset($_GET['filter']) || isset($_GET['filter_sort_asc']) || isset($_GET['filter_sort_desc']))
{
    if(isset($_GET['filter']))
    {
        $filter = urldecode($_GET['filter']);
    }
    if(isset($_GET['filter_field']))
    {
        $filter_field = urldecode($_GET['filter_field']);
    }
    if(isset($_GET['filter_sort_asc']))
    {
        $filter_sort_asc = urldecode($_GET['filter_sort_asc']);
    }
    if(isset($_GET['filter_sort_desc']))
    {
        $filter_sort_desc = urldecode($_GET['filter_sort_desc']);
    }
    if(isset($_GET['current_page']))
    {
        $current_page = urldecode($_GET['current_page']);
    }
    if(isset($_GET['page_from']))
    {
        $page_from = urldecode($_GET['page_from']);
    }

    if($current_page < 1)
    {
        $current_page = $page_from;
    }
}

if(xsrf_guard())
{
    init_var($_POST['btn_back']);

    if(isset($_POST['filter']))
    {
        $filter = $_POST['filter'];
    }
    if(isset($_POST['filter_field']))
    {
        $filter_field = $_POST['filter_field'];
    }
    if(isset($_POST['filter_sort_asc']))
    {
        $filter_sort_asc = $_POST['filter_sort_asc'];
    }
    if(isset($_POST['filter_sort_desc']))
    {
        $filter_sort_desc = $_POST['filter_sort_desc'];
    }
    if(isset($_POST['current_page']))
    {
        $current_page = $_POST['current_page'];
    }
    if(isset($_POST['result_pager']))
    {
        $result_pager = $_POST['result_pager'];
    }

    if($_POST['btn_back'])
    {
        log_action('Pressed cancel button');
        redirect(HOME_PAGE);
    }
}

$filter = quote_smart($filter);
$filter_field = quote_smart($filter_field);
$filter_sort_asc = quote_smart($filter_sort_asc);
$filter_sort_desc = quote_smart($filter_sort_desc);

if(trim($filter)!='')
{
    $enc_filter = urlencode($filter);
}
if(trim($filter_field)!='')
{
   $enc_filter_field = urlencode($filter_field);
}
if(trim($filter_sort_asc)!='')
{
   $enc_filter_sort_asc = urlencode($filter_sort_asc);
}
if(trim($filter_sort_desc)!='')
{
   $enc_filter_sort_desc = urlencode($filter_sort_desc);
}
