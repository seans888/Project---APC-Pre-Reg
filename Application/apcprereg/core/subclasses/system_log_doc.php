<?php
require_once 'documentation_class.php';
require_once 'system_log_dd.php';
class system_log_doc extends documentation
{
    function __construct()
    {
        $this->fields        = system_log_dd::load_dictionary();
        $this->relations     = system_log_dd::load_relationships();
        $this->subclasses    = system_log_dd::load_subclass_info();
        $this->table_name    = system_log_dd::$table_name;
        $this->readable_name = system_log_dd::$readable_name;
        parent::__construct();
    }
}
