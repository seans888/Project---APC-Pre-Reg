<?php
require_once 'person_dd.php';
class person_rpt extends reporter
{
    var $tables='person';
    var $session_array_name = 'PERSON_REPORT_CUSTOM';
    var $report_title = '%%: Custom Reporting Tool';
    var $html_subclass = 'person_html';
    var $data_subclass = 'person';
    var $result_page = 'reporter_result_person.php';
    var $cancel_page = 'listview_person.php';
    var $pdf_reporter_filename = 'reporter_pdfresult_person.php';

    function __construct()
    {
        $this->fields        = person_dd::load_dictionary();
        $this->relations     = person_dd::load_relationships();
        $this->subclasses    = person_dd::load_subclass_info();
        $this->table_name    = person_dd::$table_name;
        $this->tables        = person_dd::$table_name;
        $this->readable_name = person_dd::$readable_name;
        $this->get_report_fields();
    }
}
