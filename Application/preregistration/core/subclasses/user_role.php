<?php
require_once 'user_role_dd.php';
class user_role extends data_abstraction
{
    var $fields = array();

    function __construct()
    {
        $this->fields     = user_role_dd::load_dictionary();
        $this->relations  = user_role_dd::load_relationships();
        $this->subclasses = user_role_dd::load_subclass_info();
        $this->table_name = user_role_dd::$table_name;
        $this->tables     = user_role_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('INSERT');
        $this->set_fields('role_id, role, description');
        $this->set_values("?,?,?");

        $bind_params = array('iss',
                             $this->fields['role_id']['value'],
                             $this->fields['role']['value'],
                             $this->fields['description']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function edit($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('UPDATE');
        $this->set_update("role = ?, description = ?");
        $this->set_where("role_id = ?");

        $bind_params = array('ssi',
                             $this->fields['role']['value'],
                             $this->fields['description']['value'],
                             $this->fields['role_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("role_id = ?");

        $bind_params = array('i',
                             $this->fields['role_id']['value']);

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
        $this->set_where("role_id = ?");

        $bind_params = array('i',
                             $this->fields['role_id']['value']);

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
        $this->set_where("role_id = ? AND (role_id != ?)");

        $bind_params = array('ii',
                             $this->fields['role_id']['value'],
                             $this->fields['role_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }

    function get_role_name($role_id)
    {
        $this->escape_arguments($role_id);
        $this->set_fields('role');
        $this->set_where("role_id = '$role_id'");
        $this->exec_fetch('single');
        return $this;
    }
}
