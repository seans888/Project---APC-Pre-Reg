<?php
require_once 'user_dd.php';
class user extends data_abstraction
{
    var $fields = array();

    function __construct()
    {
        $this->fields     = user_dd::load_dictionary();
        $this->relations  = user_dd::load_relationships();
        $this->subclasses = user_dd::load_subclass_info();
        $this->table_name = user_dd::$table_name;
        $this->tables     = user_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('INSERT');
        $this->set_fields('username, password, salt, iteration, method, person_id, role_id, skin_id');
        $this->set_values("?,?,?,?,?,?,?,?");

        $bind_params = array('sssisiii',
                             $this->fields['username']['value'],
                             $this->fields['password']['value'],
                             $this->fields['salt']['value'],
                             $this->fields['iteration']['value'],
                             $this->fields['method']['value'],
                             $this->fields['person_id']['value'],
                             $this->fields['role_id']['value'],
                             $this->fields['skin_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function edit($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('UPDATE');
        $this->set_update("username = ?, person_id = ?, role_id = ?, skin_id = ?");
        $this->set_where("username = ?");

        $bind_params = array('siiis',
                             $this->fields['username']['value'],
                             $this->fields['person_id']['value'],
                             $this->fields['role_id']['value'],
                             $this->fields['skin_id']['value'],
                             $param['orig_username']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("username = ?");

        $bind_params = array('s',
                             $this->fields['username']['value']);

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
        $this->set_where("username = ?");

        $bind_params = array('s',
                             $this->fields['username']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }

    function check_uniqueness_for_editing($param)
    {
        $orig_username = $param['orig_username'];
        $this->escape_arguments($orig_username);
        $this->set_parameters($param);
        $this->set_query_type('SELECT');
        $this->set_where("username = ? AND (username != '$orig_username')");

        $bind_params = array('s',
                             $this->fields['username']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }

    function check_user($username)
    {
        $this->set_query_type('SELECT');
        $this->set_fields("username");
        $this->set_where("username = ?");

        $bind_params = array('s', $username);
        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows == 1) $this->user_exists = TRUE;
        else $this->user_exists = FALSE;

        return $this;
    }

    function get_role_users($role_id)
    {
        $this->set_query_type('SELECT');
        $this->set_fields("username");
        $this->set_where("role_id = ?");

        $bind_params = array('i',
                             $role_id);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute()->stmt_fetch()->stmt->close();

        $this->lst_user = '';
        if(isset($this->dump['username']) && is_array($this->dump['username']))
        {
            foreach($this->dump['username'] as $user)
            {
                make_list($this->lst_user, $user);
            }
        }

        return $this;
    }
}
