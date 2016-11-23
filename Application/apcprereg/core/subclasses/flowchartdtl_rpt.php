<?php
require_once 'flowchartdtl_dd.php';
class flowchartdtl_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'FLOWCHARTDTL_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'flowchartdtl_html';
    var $data_subclass = 'flowchartdtl';
    var $result_page = 'reporter_result_flowchartdtl.php';
    var $cancel_page = 'listview_flowchartdtl.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_flowchartdtl.php';

    function __construct()
    {
        $this->fields        = flowchartdtl_dd::load_dictionary();
        $this->relations     = flowchartdtl_dd::load_relationships();
        $this->subclasses    = flowchartdtl_dd::load_subclass_info();
        $this->table_name    = flowchartdtl_dd::$table_name;
        $this->tables        = flowchartdtl_dd::$table_name;
        $this->readable_name = flowchartdtl_dd::$readable_name;
        $this->get_report_fields();
    }
}
