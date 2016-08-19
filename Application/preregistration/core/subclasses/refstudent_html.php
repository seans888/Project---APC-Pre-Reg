<?php
require_once 'refstudent_dd.php';
class refstudent_html extends html
{
    function __construct()
    {
        $this->fields        = refstudent_dd::load_dictionary();
        $this->relations     = refstudent_dd::load_relationships();
        $this->subclasses    = refstudent_dd::load_subclass_info();
        $this->table_name    = refstudent_dd::$table_name;
        $this->readable_name = refstudent_dd::$readable_name;
    }
}
