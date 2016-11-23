<?php
require_once 'user_links_dd.php';
class user_links_rpt extends reporter
{
    var $tables='user_links';
    var $session_array_name = 'USER_LINKS_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'user_links_html';
    var $data_subclass = 'user_links';
    var $result_page = 'reporter_result_user_links.php';
    var $cancel_page = 'listview_user_links.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_user_links.php';

    function __construct()
    {
        $this->fields        = user_links_dd::load_dictionary();
        $this->relations     = user_links_dd::load_relationships();
        $this->subclasses    = user_links_dd::load_subclass_info();
        $this->table_name    = user_links_dd::$table_name;
        $this->tables        = user_links_dd::$table_name;
        $this->readable_name = user_links_dd::$readable_name;
        $this->get_report_fields();
    }
}
