<?php
require_once 'system_log_dd.php';
class system_log_rpt extends reporter
{
    var $tables='';
    var $session_array_name = 'SYSTEM_LOG_REPORT_CUSTOM';
    var $report_title = '%%';
    var $html_subclass = 'system_log_html';
    var $data_subclass = 'system_log';
    var $result_page = 'security_monitor2.php';
    var $cancel_page = 'listview_system_log.php';
    var $pdf_reporter_filename = 'security_monitor3.php';

    function __construct()
    {
        $this->fields        = system_log_dd::load_dictionary();
        $this->relations     = system_log_dd::load_relationships();
        $this->subclasses    = system_log_dd::load_subclass_info();
        $this->table_name    = system_log_dd::$table_name;
        $this->tables        = system_log_dd::$table_name;
        $this->readable_name = system_log_dd::$readable_name;
        $this->get_report_fields();
    }
}
