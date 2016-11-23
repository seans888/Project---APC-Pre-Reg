<?php
require_once 'flowcharthdr_dd.php';
class flowcharthdr_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'FLOWCHARTHDR_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'flowcharthdr_html';
    var $data_subclass = 'flowcharthdr';
    var $result_page = 'reporter_result_flowcharthdr.php';
    var $cancel_page = 'listview_flowcharthdr.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_flowcharthdr.php';

    function __construct()
    {
        $this->fields        = flowcharthdr_dd::load_dictionary();
        $this->relations     = flowcharthdr_dd::load_relationships();
        $this->subclasses    = flowcharthdr_dd::load_subclass_info();
        $this->table_name    = flowcharthdr_dd::$table_name;
        $this->tables        = flowcharthdr_dd::$table_name;
        $this->readable_name = flowcharthdr_dd::$readable_name;
        $this->get_report_fields();
    }
}
