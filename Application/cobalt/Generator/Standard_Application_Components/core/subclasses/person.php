<?php
require_once 'person_dd.php';
class person extends data_abstraction
{
    var $fields = array();

    function __construct()
    {
        $this->fields     = person_dd::load_dictionary();
        $this->relations  = person_dd::load_relationships();
        $this->subclasses = person_dd::load_subclass_info();
        $this->table_name = person_dd::$table_name;
        $this->tables     = person_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('INSERT');
        $this->set_fields('person_id, first_name, middle_name, last_name, gender');
        $this->set_values("?,?,?,?,?");

        $bind_params = array('issss',
                             $this->fields['person_id']['value'],
                             $this->fields['first_name']['value'],
                             $this->fields['middle_name']['value'],
                             $this->fields['last_name']['value'],
                             $this->fields['gender']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function edit($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('UPDATE');
        $this->set_update("first_name = ?, middle_name = ?, last_name = ?, gender = ?");
        $this->set_where("person_id = ?");

        $bind_params = array('ssssi',
                             $this->fields['first_name']['value'],
                             $this->fields['middle_name']['value'],
                             $this->fields['last_name']['value'],
                             $this->fields['gender']['value'],
                             $this->fields['person_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("person_id = ?");

        $bind_params = array('i',
                             $this->fields['person_id']['value']);

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
        $this->set_where("person_id = ?");

        $bind_params = array('i',
                             $this->fields['person_id']['value']);

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
        $this->set_where("person_id = ? AND (person_id != ?)");

        $bind_params = array('ii',
                             $this->fields['person_id']['value'],
                             $this->fields['person_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
