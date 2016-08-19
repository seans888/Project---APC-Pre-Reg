<?php
require_once 'documentation_class.php';
require_once 'flowchartdtl_dd.php';
class flowchartdtl_doc extends documentation
{
    function __construct()
    {
        $this->fields        = flowchartdtl_dd::load_dictionary();
        $this->relations     = flowchartdtl_dd::load_relationships();
        $this->subclasses    = flowchartdtl_dd::load_subclass_info();
        $this->table_name    = flowchartdtl_dd::$table_name;
        $this->readable_name = flowchartdtl_dd::$readable_name;
        parent::__construct();
    }
}
