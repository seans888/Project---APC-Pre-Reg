<?php
require_once 'documentation_class.php';
require_once 'course_dd.php';
class course_doc extends documentation
{
    function __construct()
    {
        $this->fields        = course_dd::load_dictionary();
        $this->relations     = course_dd::load_relationships();
        $this->subclasses    = course_dd::load_subclass_info();
        $this->table_name    = course_dd::$table_name;
        $this->readable_name = course_dd::$readable_name;
        parent::__construct();
    }
}
