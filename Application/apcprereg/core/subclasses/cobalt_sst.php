<?php
require_once 'cobalt_sst_dd.php';
class cobalt_sst extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = cobalt_sst_dd::load_dictionary();
        $this->relations  = cobalt_sst_dd::load_relationships();
        $this->subclasses = cobalt_sst_dd::load_subclass_info();
        $this->table_name = cobalt_sst_dd::$table_name;
        $this->tables     = cobalt_sst_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('auto_id, title, description, config_file');
            $this->set_values("?,?,?,?");

            $bind_params = array('isss',
                                 &$this->fields['auto_id']['value'],
                                 &$this->fields['title']['value'],
                                 &$this->fields['description']['value'],
                                 &$this->fields['config_file']['value']);

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
            $this->set_update("title = ?, description = ?, config_file = ?");
            $this->set_where("auto_id = ?");

            $bind_params = array('sssi',
                                 &$this->fields['title']['value'],
                                 &$this->fields['description']['value'],
                                 &$this->fields['config_file']['value'],
                                 &$this->fields['auto_id']['value']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("auto_id = ?");

        $bind_params = array('i',
                             &$this->fields['auto_id']['value']);

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
        $this->set_where("auto_id = ?");

        $bind_params = array('i',
                             &$this->fields['auto_id']['value']);

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
        $this->set_where("auto_id = ? AND (auto_id != ?)");

        $bind_params = array('ii',
                             &$this->fields['auto_id']['value'],
                             &$this->fields['auto_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
