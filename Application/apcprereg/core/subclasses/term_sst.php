<?php
require_once 'sst_class.php';
require_once 'term_dd.php';
class term_sst extends sst
{
    function __construct()
    {
        $this->fields        = term_dd::load_dictionary();
        $this->relations     = term_dd::load_relationships();
        $this->subclasses    = term_dd::load_subclass_info();
        $this->table_name    = term_dd::$table_name;
        $this->readable_name = term_dd::$readable_name;
        parent::__construct();
    }
}
