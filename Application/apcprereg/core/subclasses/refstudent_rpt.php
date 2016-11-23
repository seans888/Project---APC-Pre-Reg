<?php
require_once 'refstudent_dd.php';
class refstudent_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'REFSTUDENT_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'refstudent_html';
    var $data_subclass = 'refstudent';
    var $result_page = 'reporter_result_refstudent.php';
    var $cancel_page = 'listview_refstudent.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_refstudent.php';

    function __construct()
    {
        $this->fields        = refstudent_dd::load_dictionary();
        $this->relations     = refstudent_dd::load_relationships();
        $this->subclasses    = refstudent_dd::load_subclass_info();
        $this->table_name    = refstudent_dd::$table_name;
        $this->tables        = refstudent_dd::$table_name;
        $this->readable_name = refstudent_dd::$readable_name;
        $this->get_report_fields();
    }
}
