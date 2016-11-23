<?php
require_once 'sst_class.php';
require_once 'xrefstudentcourse_dd.php';
class xrefstudentcourse_sst extends sst
{
    function __construct()
    {
        $this->fields        = xrefstudentcourse_dd::load_dictionary();
        $this->relations     = xrefstudentcourse_dd::load_relationships();
        $this->subclasses    = xrefstudentcourse_dd::load_subclass_info();
        $this->table_name    = xrefstudentcourse_dd::$table_name;
        $this->readable_name = xrefstudentcourse_dd::$readable_name;
        parent::__construct();
    }
}
