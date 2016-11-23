<?php
require_once 'documentation_class.php';
require_once 'refstudent_dd.php';
class refstudent_doc extends documentation
{
    function __construct()
    {
        $this->fields        = refstudent_dd::load_dictionary();
        $this->relations     = refstudent_dd::load_relationships();
        $this->subclasses    = refstudent_dd::load_subclass_info();
        $this->table_name    = refstudent_dd::$table_name;
        $this->readable_name = refstudent_dd::$readable_name;
        parent::__construct();
    }
}
