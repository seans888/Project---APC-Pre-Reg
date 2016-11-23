<?php
require_once 'cobalt_sst_dd.php';
class cobalt_sst_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'COBALT_SST_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'cobalt_sst_html';
    var $data_subclass = 'cobalt_sst';
    var $result_page = 'reporter_result_cobalt_sst.php';
    var $cancel_page = 'listview_cobalt_sst.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_cobalt_sst.php';

    function __construct()
    {
        $this->fields        = cobalt_sst_dd::load_dictionary();
        $this->relations     = cobalt_sst_dd::load_relationships();
        $this->subclasses    = cobalt_sst_dd::load_subclass_info();
        $this->table_name    = cobalt_sst_dd::$table_name;
        $this->tables        = cobalt_sst_dd::$table_name;
        $this->readable_name = cobalt_sst_dd::$readable_name;
        $this->get_report_fields();
    }
}
