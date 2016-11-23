<?php
require_once 'term_dd.php';
class term_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'TERM_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'term_html';
    var $data_subclass = 'term';
    var $result_page = 'reporter_result_term.php';
    var $cancel_page = 'listview_term.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_term.php';

    function __construct()
    {
        $this->fields        = term_dd::load_dictionary();
        $this->relations     = term_dd::load_relationships();
        $this->subclasses    = term_dd::load_subclass_info();
        $this->table_name    = term_dd::$table_name;
        $this->tables        = term_dd::$table_name;
        $this->readable_name = term_dd::$readable_name;
        $this->get_report_fields();
    }
}
