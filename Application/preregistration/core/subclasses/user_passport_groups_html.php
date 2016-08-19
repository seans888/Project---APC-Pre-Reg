<?php
require_once 'user_passport_groups_dd.php';
class user_passport_groups_html extends html
{
    function __construct()
    {
        $this->fields        = user_passport_groups_dd::load_dictionary();
        $this->relations     = user_passport_groups_dd::load_relationships();
        $this->subclasses    = user_passport_groups_dd::load_subclass_info();
        $this->table_name    = user_passport_groups_dd::$table_name;
        $this->readable_name = user_passport_groups_dd::$readable_name;
    }
}
