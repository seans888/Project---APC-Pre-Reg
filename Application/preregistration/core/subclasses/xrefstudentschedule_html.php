<?php
require_once 'xrefstudentschedule_dd.php';
class xrefstudentschedule_html extends html
{
    function __construct()
    {
        $this->fields        = xrefstudentschedule_dd::load_dictionary();
        $this->relations     = xrefstudentschedule_dd::load_relationships();
        $this->subclasses    = xrefstudentschedule_dd::load_subclass_info();
        $this->table_name    = xrefstudentschedule_dd::$table_name;
        $this->readable_name = xrefstudentschedule_dd::$readable_name;
    }
}
