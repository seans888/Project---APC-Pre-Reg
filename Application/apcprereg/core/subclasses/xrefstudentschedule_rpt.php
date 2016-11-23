<?php
require_once 'xrefstudentschedule_dd.php';
class xrefstudentschedule_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'XREFSTUDENTSCHEDULE_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'xrefstudentschedule_html';
    var $data_subclass = 'xrefstudentschedule';
    var $result_page = 'reporter_result_xrefstudentschedule.php';
    var $cancel_page = 'listview_xrefstudentschedule.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_xrefstudentschedule.php';

    function __construct()
    {
        $this->fields        = xrefstudentschedule_dd::load_dictionary();
        $this->relations     = xrefstudentschedule_dd::load_relationships();
        $this->subclasses    = xrefstudentschedule_dd::load_subclass_info();
        $this->table_name    = xrefstudentschedule_dd::$table_name;
        $this->tables        = xrefstudentschedule_dd::$table_name;
        $this->readable_name = xrefstudentschedule_dd::$readable_name;
        $this->get_report_fields();
    }
}
