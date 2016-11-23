<?php
require_once 'refsubjectofferingdtl_dd.php';
class refsubjectofferingdtl_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'REFSUBJECTOFFERINGDTL_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'refsubjectofferingdtl_html';
    var $data_subclass = 'refsubjectofferingdtl';
    var $result_page = 'reporter_result_refsubjectofferingdtl.php';
    var $cancel_page = 'listview_refsubjectofferingdtl.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_refsubjectofferingdtl.php';

    function __construct()
    {
        $this->fields        = refsubjectofferingdtl_dd::load_dictionary();
        $this->relations     = refsubjectofferingdtl_dd::load_relationships();
        $this->subclasses    = refsubjectofferingdtl_dd::load_subclass_info();
        $this->table_name    = refsubjectofferingdtl_dd::$table_name;
        $this->tables        = refsubjectofferingdtl_dd::$table_name;
        $this->readable_name = refsubjectofferingdtl_dd::$readable_name;
        $this->get_report_fields();
    }
}
