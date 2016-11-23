<?php
require_once 'addsubject_dd.php';
class addsubject_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'ADDSUBJECT_REPORT_CUSTOM';
    var $report_title = 'Addsubject: Custom Reporting Tool';
    var $html_subclass = 'addsubject_html';
    var $data_subclass = 'addsubject';
    var $result_page = 'reporter_result_addsubject.php';
    var $cancel_page = 'listview_addsubject.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_addsubject.php';

    function __construct()
    {
        $this->fields        = addsubject_dd::load_dictionary();
        $this->relations     = addsubject_dd::load_relationships();
        $this->subclasses    = addsubject_dd::load_subclass_info();
        $this->table_name    = addsubject_dd::$table_name;
        $this->tables        = addsubject_dd::$table_name;
        $this->readable_name = addsubject_dd::$readable_name;
        $this->get_report_fields();
    }
}
