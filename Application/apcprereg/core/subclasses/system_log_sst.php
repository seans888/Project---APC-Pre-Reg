<?php
require_once 'sst_class.php';
require_once 'system_log_dd.php';
class system_log_sst extends sst
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
