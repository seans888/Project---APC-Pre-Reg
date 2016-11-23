<?php
require_once 'user_role_links_dd.php';
class user_role_links_rpt extends reporter
{
    var $tables='user_role_links';
    var $session_array_name = 'USER_ROLE_LINKS_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'user_role_links_html';
    var $data_subclass = 'user_role_links';
    var $result_page = 'reporter_result_user_role_links.php';
    var $cancel_page = 'listview_user_role_links.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_user_role_links.php';

    function __construct()
    {
        $this->fields        = user_role_links_dd::load_dictionary();
        $this->relations     = user_role_links_dd::load_relationships();
        $this->subclasses    = user_role_links_dd::load_subclass_info();
        $this->table_name    = user_role_links_dd::$table_name;
        $this->tables        = user_role_links_dd::$table_name;
        $this->readable_name = user_role_links_dd::$readable_name;
        $this->get_report_fields();
    }
}
