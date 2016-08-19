<?php
require_once 'system_skins_dd.php';
class system_skins_html extends html
{
    function __construct()
    {
        $this->fields        = system_skins_dd::load_dictionary();
        $this->relations     = system_skins_dd::load_relationships();
        $this->subclasses    = system_skins_dd::load_subclass_info();
        $this->table_name    = system_skins_dd::$table_name;
        $this->readable_name = system_skins_dd::$readable_name;
    }
}
