<?php
//****************************************************************************************
//Generated by Cobalt, a rapid application development framework. http://cobalt.jvroig.com
//Cobalt developed by JV Roig (jvroig@jvroig.com)
//****************************************************************************************
require 'path.php';
init_cobalt('View xrefstudentcourse');

if(isset($_GET['student_id']) && isset($_GET['course']) && isset($_GET['term_id']))
{
    $student_id = urldecode($_GET['student_id']);
    $course = urldecode($_GET['course']);
    $term_id = urldecode($_GET['term_id']);
    require 'form_data_xrefstudentcourse.php';
}

if(xsrf_guard())
{
    init_var($_POST['btn_back']);

    if($_POST['btn_back'])
    {
        log_action('Pressed cancel button');
        require 'components/query_string_standard.php';
        redirect("listview_xrefstudentcourse.php?$query_string");
    }
}
require 'subclasses/xrefstudentcourse_html.php';
$html = new xrefstudentcourse_html;
$html->draw_header('Detail View: Xrefstudentcourse', $message, $message_type);
$html->draw_listview_referrer_info($filter_field_used, $filter_used, $page_from, $filter_sort_asc, $filter_sort_desc);
$html->detail_view = TRUE;
$html->draw_controls('view');

$html->draw_footer();