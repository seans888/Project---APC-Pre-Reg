<?php
//****************************************************************************************
//Generated by Cobalt, a rapid application development framework. http://cobalt.jvroig.com
//Cobalt developed by JV Roig (jvroig@jvroig.com)
//****************************************************************************************
require 'path.php';
init_cobalt('Delete xrefstudentschedule');

if(isset($_GET['subject_offering_id']) && isset($_GET['student_id']))
{
    $subject_offering_id = urldecode($_GET['subject_offering_id']);
    $student_id = urldecode($_GET['student_id']);
    require_once 'form_data_xrefstudentschedule.php';
}

if(xsrf_guard())
{
    init_var($_POST['btn_cancel']);
    init_var($_POST['btn_delete']);
    require 'components/query_string_standard.php';

    if($_POST['btn_cancel'])
    {
        log_action('Pressed cancel button');
        redirect("listview_xrefstudentschedule.php?$query_string");
    }

    elseif($_POST['btn_delete'])
    {
        log_action('Pressed delete button');
        require_once 'subclasses/xrefstudentschedule.php';
        $dbh_xrefstudentschedule = new xrefstudentschedule;

        $object_name = 'dbh_xrefstudentschedule';
        require 'components/create_form_data.php';

        $dbh_xrefstudentschedule->delete($arr_form_data);


        redirect("listview_xrefstudentschedule.php?$query_string");
    }
}
require 'subclasses/xrefstudentschedule_html.php';
$html = new xrefstudentschedule_html;
$html->draw_header('Delete Xrefstudentschedule', $message, $message_type);
$html->draw_listview_referrer_info($filter_field_used, $filter_used, $page_from, $filter_sort_asc, $filter_sort_desc);

$html->draw_hidden('subject_offering_id');
$html->draw_hidden('student_id');

$html->detail_view = TRUE;
$html->draw_controls('delete');

$html->draw_footer();