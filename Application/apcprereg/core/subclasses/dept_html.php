<?php
require_once 'dept_dd.php';
class dept_html extends html
{
    function __construct()
    {
        $this->fields        = dept_dd::load_dictionary();
        $this->relations     = dept_dd::load_relationships();
        $this->subclasses    = dept_dd::load_subclass_info();
        $this->table_name    = dept_dd::$table_name;
        $this->readable_name = dept_dd::$readable_name;
    }
}
