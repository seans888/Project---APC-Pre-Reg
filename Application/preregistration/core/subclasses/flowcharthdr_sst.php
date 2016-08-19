<?php
require_once 'sst_class.php';
require_once 'flowcharthdr_dd.php';
class flowcharthdr_sst extends sst
{
    function __construct()
    {
        $this->fields        = flowcharthdr_dd::load_dictionary();
        $this->relations     = flowcharthdr_dd::load_relationships();
        $this->subclasses    = flowcharthdr_dd::load_subclass_info();
        $this->table_name    = flowcharthdr_dd::$table_name;
        $this->readable_name = flowcharthdr_dd::$readable_name;
        parent::__construct();
    }
}
