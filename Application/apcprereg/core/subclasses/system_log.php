<?php
require_once 'system_log_dd.php';
class system_log extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = system_log_dd::load_dictionary();
        $this->relations  = system_log_dd::load_relationships();
        $this->subclasses = system_log_dd::load_subclass_info();
        $this->table_name = system_log_dd::$table_name;
        $this->tables     = system_log_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('entry_id, ip_address, user, datetime, action, module');
            $this->set_values("?,?,?,?,?,?");

            $bind_params = array('ississ',
                                 &$this->fields['entry_id']['value'],
                                 &$this->fields['ip_address']['value'],
                                 &$this->fields['user']['value'],
                                 &$this->fields['datetime']['value'],
                                 &$this->fields['action']['value'],
                                 &$this->fields['module']['value']);

            $this->stmt_prepare($bind_params);
        }

        $this->stmt_execute();
        return $this;
    }

    function edit($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('UPDATE');
            $this->set_update("ip_address = ?, user = ?, datetime = ?, action = ?, module = ?");
            $this->set_where("entry_id = ?");

            $bind_params = array('ssissi',
                                 &$this->fields['ip_address']['value'],
                                 &$this->fields['user']['value'],
                                 &$this->fields['datetime']['value'],
                                 &$this->fields['action']['value'],
                                 &$this->fields['module']['value'],
                                 &$this->fields['entry_id']['value']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("entry_id = ?");

        $bind_params = array('i',
                             &$this->fields['entry_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete_many($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("");

        $bind_params = array('',
                             );

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
        $this->set_where("entry_id = ?");

        $bind_params = array('i',
                             &$this->fields['entry_id']['value']);

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
        $this->set_where("entry_id = ? AND (entry_id != ?)");

        $bind_params = array('ii',
                             &$this->fields['entry_id']['value'],
                             &$this->fields['entry_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
