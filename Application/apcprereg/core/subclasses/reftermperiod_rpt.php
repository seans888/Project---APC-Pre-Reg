<?php
require_once 'reftermperiod_dd.php';
class reftermperiod_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'REFTERMPERIOD_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'reftermperiod_html';
    var $data_subclass = 'reftermperiod';
    var $result_page = 'reporter_result_reftermperiod.php';
    var $cancel_page = 'listview_reftermperiod.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_reftermperiod.php';

    function __construct()
    {
        $this->fields        = reftermperiod_dd::load_dictionary();
        $this->relations     = reftermperiod_dd::load_relationships();
        $this->subclasses    = reftermperiod_dd::load_subclass_info();
        $this->table_name    = reftermperiod_dd::$table_name;
        $this->tables        = reftermperiod_dd::$table_name;
        $this->readable_name = reftermperiod_dd::$readable_name;
        $this->get_report_fields();
    }
}
