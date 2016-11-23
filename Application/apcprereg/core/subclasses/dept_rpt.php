<?php
require_once 'dept_dd.php';
class dept_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'DEPT_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'dept_html';
    var $data_subclass = 'dept';
    var $result_page = 'reporter_result_dept.php';
    var $cancel_page = 'listview_dept.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_dept.php';

    function __construct()
    {
        $this->fields        = dept_dd::load_dictionary();
        $this->relations     = dept_dd::load_relationships();
        $this->subclasses    = dept_dd::load_subclass_info();
        $this->table_name    = dept_dd::$table_name;
        $this->tables        = dept_dd::$table_name;
        $this->readable_name = dept_dd::$readable_name;
        $this->get_report_fields();
    }
}
