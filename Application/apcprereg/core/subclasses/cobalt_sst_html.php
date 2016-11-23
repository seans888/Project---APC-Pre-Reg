<?php
require_once 'cobalt_sst_dd.php';
class cobalt_sst_html extends html
{
    function __construct()
    {
        $this->fields        = cobalt_sst_dd::load_dictionary();
        $this->relations     = cobalt_sst_dd::load_relationships();
        $this->subclasses    = cobalt_sst_dd::load_subclass_info();
        $this->table_name    = cobalt_sst_dd::$table_name;
        $this->readable_name = cobalt_sst_dd::$readable_name;
    }
}
