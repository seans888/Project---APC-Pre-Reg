<?php
//****************************************************************************************
//Generated by Cobalt, a rapid application development framework. http://cobalt.jvroig.com
//Cobalt developed by JV Roig (jvroig@jvroig.com)
//****************************************************************************************
require 'path.php';
init_cobalt('Delete flowchartdtl');

if(isset($_GET['flow_dtl_id']))
{
    $flow_dtl_id = urldecode($_GET['flow_dtl_id']);
    require_once 'form_data_flowchartdtl.php';
}

if(xsrf_guard())
{
    init_var($_POST['btn_cancel']);
    init_var($_POST['btn_delete']);
    require 'components/query_string_standard.php';

    if($_POST['btn_cancel'])
    {
        log_action('Pressed cancel button');
        redirect("listview_flowchartdtl.php?$query_string");
    }

    elseif($_POST['btn_delete'])
    {
        log_action('Pressed delete button');
        require_once 'subclasses/flowchartdtl.php';
        $dbh_flowchartdtl = new flowchartdtl;

        $object_name = 'dbh_flowchartdtl';
        require 'components/create_form_data.php';

        $dbh_flowchartdtl->delete($arr_form_data);


        redirect("listview_flowchartdtl.php?$query_string");
    }
}
require 'subclasses/flowchartdtl_html.php';
$html = new flowchartdtl_html;
$html->draw_header('Delete Flowchartdtl', $message, $message_type);
$html->draw_listview_referrer_info($filter_field_used, $filter_used, $page_from, $filter_sort_asc, $filter_sort_desc);

$html->draw_hidden('flow_dtl_id');

$html->detail_view = TRUE;
$html->draw_controls('delete');

$html->draw_footer();