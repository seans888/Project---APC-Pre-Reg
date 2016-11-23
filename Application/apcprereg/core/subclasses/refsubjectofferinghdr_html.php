<?php
require_once 'refsubjectofferinghdr_dd.php';
class refsubjectofferinghdr_html extends html
{
    function __construct()
    {
        $this->fields        = refsubjectofferinghdr_dd::load_dictionary();
        $this->relations     = refsubjectofferinghdr_dd::load_relationships();
        $this->subclasses    = refsubjectofferinghdr_dd::load_subclass_info();
        $this->table_name    = refsubjectofferinghdr_dd::$table_name;
        $this->readable_name = refsubjectofferinghdr_dd::$readable_name;
    }
}
