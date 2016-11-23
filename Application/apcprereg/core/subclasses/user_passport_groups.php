<?php
require_once 'user_passport_groups_dd.php';
class user_passport_groups extends data_abstraction
{
    var $fields = array();

    function __construct()
    {
        $this->fields     = user_passport_groups_dd::load_dictionary();
        $this->relations  = user_passport_groups_dd::load_relationships();
        $this->subclasses = user_passport_groups_dd::load_subclass_info();
        $this->table_name = user_passport_groups_dd::$table_name;
        $this->tables     = user_passport_groups_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('INSERT');
        $this->set_fields('passport_group_id, passport_group, priority, icon');
        $this->set_values("?,?,?,?");

        $bind_params = array('isis',
                             $this->fields['passport_group_id']['value'],
                             $this->fields['passport_group']['value'],
                             $this->fields['priority']['value'],
                             $this->fields['icon']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function edit($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('UPDATE');
        $this->set_update("passport_group = ?, priority = ?, icon = ?");
        $this->set_where("passport_group_id = ?");

        $bind_params = array('sisi',
                             $this->fields['passport_group']['value'],
                             $this->fields['priority']['value'],
                             $this->fields['icon']['value'],
                             $this->fields['passport_group_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("passport_group_id = ?");

        $bind_params = array('i',
                             $this->fields['passport_group_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;

    }

    function select()
    {
        $this->set_query_type('SELECT');
        $this->exec_fetch('array');
        return $this;
    }

    function check_uniqueness($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('SELECT');
        $this->set_where("passport_group_id = ?");

        $bind_params = array('i',
                             $this->fields['passport_group_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }

    function check_uniqueness_for_editing($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('SELECT');
        $this->set_where("passport_group_id = ? AND (passport_group_id != ?)");

        $bind_params = array('ii',
                             $this->fields['passport_group_id']['value'],
                             $this->fields['passport_group_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
