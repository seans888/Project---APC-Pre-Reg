<?php
require_once 'system_settings_dd.php';
class system_settings_rpt extends reporter
{
    var $tables='system_settings';
    var $session_array_name = 'SYSTEM_SETTINGS_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'system_settings_html';
    var $data_subclass = 'system_settings';
    var $result_page = 'reporter_result_system_settings.php';
    var $cancel_page = 'listview_system_settings.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_system_settings.php';

    function __construct()
    {
        $this->fields        = system_settings_dd::load_dictionary();
        $this->relations     = system_settings_dd::load_relationships();
        $this->subclasses    = system_settings_dd::load_subclass_info();
        $this->table_name    = system_settings_dd::$table_name;
        $this->tables        = system_settings_dd::$table_name;
        $this->readable_name = system_settings_dd::$readable_name;
        $this->get_report_fields();
    }
}
