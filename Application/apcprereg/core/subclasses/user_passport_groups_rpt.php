<?php
require_once 'user_passport_groups_dd.php';
class user_passport_groups_rpt extends reporter
{
    var $tables='user_passport_groups';
    var $session_array_name = 'USER_PASSPORT_GROUPS_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'user_passport_groups_html';
    var $data_subclass = 'user_passport_groups';
    var $result_page = 'reporter_result_user_passport_groups.php';
    var $cancel_page = 'listview_user_passport_groups.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_user_passport_groups.php';

    function __construct()
    {
        $this->fields        = user_passport_groups_dd::load_dictionary();
        $this->relations     = user_passport_groups_dd::load_relationships();
        $this->subclasses    = user_passport_groups_dd::load_subclass_info();
        $this->table_name    = user_passport_groups_dd::$table_name;
        $this->tables        = user_passport_groups_dd::$table_name;
        $this->readable_name = user_passport_groups_dd::$readable_name;
        $this->get_report_fields();
    }
}
