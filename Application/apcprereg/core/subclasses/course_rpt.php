<?php
require_once 'course_dd.php';
class course_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'COURSE_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'course_html';
    var $data_subclass = 'course';
    var $result_page = 'reporter_result_course.php';
    var $cancel_page = 'listview_course.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_course.php';

    function __construct()
    {
        $this->fields        = course_dd::load_dictionary();
        $this->relations     = course_dd::load_relationships();
        $this->subclasses    = course_dd::load_subclass_info();
        $this->table_name    = course_dd::$table_name;
        $this->tables        = course_dd::$table_name;
        $this->readable_name = course_dd::$readable_name;
        $this->get_report_fields();
    }
}
