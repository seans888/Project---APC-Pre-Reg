<?php
require_once 'person_dd.php';
class person_html extends html
{
    function __construct()
    {
        $this->fields        = person_dd::load_dictionary();
        $this->relations     = person_dd::load_relationships();
        $this->subclasses    = person_dd::load_subclass_info();
        $this->table_name    = person_dd::$table_name;
        $this->readable_name = person_dd::$readable_name;
    }
}
