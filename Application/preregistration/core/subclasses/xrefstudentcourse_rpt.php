<?php
require_once 'xrefstudentcourse_dd.php';
class xrefstudentcourse_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'XREFSTUDENTCOURSE_REPORT_CUSTOM';
    var $report_title = 'Xrefstudentcourse: Custom Reporting Tool';
    var $html_subclass = 'xrefstudentcourse_html';
    var $data_subclass = 'xrefstudentcourse';
    var $result_page = 'reporter_result_xrefstudentcourse.php';
    var $cancel_page = 'listview_xrefstudentcourse.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_xrefstudentcourse.php';

    function __construct()
    {
        $this->fields        = xrefstudentcourse_dd::load_dictionary();
        $this->relations     = xrefstudentcourse_dd::load_relationships();
        $this->subclasses    = xrefstudentcourse_dd::load_subclass_info();
        $this->table_name    = xrefstudentcourse_dd::$table_name;
        $this->tables        = xrefstudentcourse_dd::$table_name;
        $this->readable_name = xrefstudentcourse_dd::$readable_name;
        $this->get_report_fields();
    }
}
