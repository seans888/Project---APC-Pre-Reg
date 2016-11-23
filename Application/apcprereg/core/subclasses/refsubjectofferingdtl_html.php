<?php
require_once 'refsubjectofferingdtl_dd.php';
class refsubjectofferingdtl_html extends html
{
    function __construct()
    {
        $this->fields        = refsubjectofferingdtl_dd::load_dictionary();
        $this->relations     = refsubjectofferingdtl_dd::load_relationships();
        $this->subclasses    = refsubjectofferingdtl_dd::load_subclass_info();
        $this->table_name    = refsubjectofferingdtl_dd::$table_name;
        $this->readable_name = refsubjectofferingdtl_dd::$readable_name;
    }
}
