<?php
require_once 'sst_class.php';
require_once 'reftermperiod_dd.php';
class reftermperiod_sst extends sst
{
    function __construct()
    {
        $this->fields        = reftermperiod_dd::load_dictionary();
        $this->relations     = reftermperiod_dd::load_relationships();
        $this->subclasses    = reftermperiod_dd::load_subclass_info();
        $this->table_name    = reftermperiod_dd::$table_name;
        $this->readable_name = reftermperiod_dd::$readable_name;
        parent::__construct();
    }
}
