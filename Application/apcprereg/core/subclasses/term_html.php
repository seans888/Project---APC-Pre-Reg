<?php
require_once 'term_dd.php';
class term_html extends html
{
    function __construct()
    {
        $this->fields        = term_dd::load_dictionary();
        $this->relations     = term_dd::load_relationships();
        $this->subclasses    = term_dd::load_subclass_info();
        $this->table_name    = term_dd::$table_name;
        $this->readable_name = term_dd::$readable_name;
    }
}
