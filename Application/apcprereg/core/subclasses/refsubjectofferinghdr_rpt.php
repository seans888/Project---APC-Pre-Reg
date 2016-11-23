<?php
require_once 'refsubjectofferinghdr_dd.php';
class refsubjectofferinghdr_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'REFSUBJECTOFFERINGHDR_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'refsubjectofferinghdr_html';
    var $data_subclass = 'refsubjectofferinghdr';
    var $result_page = 'reporter_result_refsubjectofferinghdr.php';
    var $cancel_page = 'listview_refsubjectofferinghdr.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_refsubjectofferinghdr.php';

    function __construct()
    {
        $this->fields        = refsubjectofferinghdr_dd::load_dictionary();
        $this->relations     = refsubjectofferinghdr_dd::load_relationships();
        $this->subclasses    = refsubjectofferinghdr_dd::load_subclass_info();
        $this->table_name    = refsubjectofferinghdr_dd::$table_name;
        $this->tables        = refsubjectofferinghdr_dd::$table_name;
        $this->readable_name = refsubjectofferinghdr_dd::$readable_name;
        $this->get_report_fields();
    }
}
