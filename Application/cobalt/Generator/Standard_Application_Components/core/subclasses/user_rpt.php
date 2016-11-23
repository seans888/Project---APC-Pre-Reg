<?php
require_once 'user_dd.php';
class user_rpt extends reporter
{
    var $tables='user';
    var $session_array_name = 'USER_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'user_html';
    var $data_subclass = 'user';
    var $result_page = 'reporter_result_user.php';
    var $cancel_page = 'listview_user.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_user.php';

    function __construct()
    {
        $this->fields        = user_dd::load_dictionary();
        $this->relations     = user_dd::load_relationships();
        $this->subclasses    = user_dd::load_subclass_info();
        $this->table_name    = user_dd::$table_name;
        $this->tables        = user_dd::$table_name;
        $this->readable_name = user_dd::$readable_name;
        $this->get_report_fields();
    }
}
