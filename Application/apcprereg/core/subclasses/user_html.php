<?php
require_once 'user_dd.php';
class user_html extends html
{
    function __construct()
    {
        $this->fields        = user_dd::load_dictionary();
        $this->relations     = user_dd::load_relationships();
        $this->subclasses    = user_dd::load_subclass_info();
        $this->table_name    = user_dd::$table_name;
        $this->readable_name = user_dd::$readable_name;
    }
}
