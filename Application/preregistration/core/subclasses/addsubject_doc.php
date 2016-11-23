<?php
require_once 'documentation_class.php';
require_once 'addsubject_dd.php';
class addsubject_doc extends documentation
{
    function __construct()
    {
        $this->fields        = addsubject_dd::load_dictionary();
        $this->relations     = addsubject_dd::load_relationships();
        $this->subclasses    = addsubject_dd::load_subclass_info();
        $this->table_name    = addsubject_dd::$table_name;
        $this->readable_name = addsubject_dd::$readable_name;
        parent::__construct();
    }
}
