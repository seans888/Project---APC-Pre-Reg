<?php
require_once 'term_dd.php';
class term extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = term_dd::load_dictionary();
        $this->relations  = term_dd::load_relationships();
        $this->subclasses = term_dd::load_subclass_info();
        $this->table_name = term_dd::$table_name;
        $this->tables     = term_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('term_id, school_year, term, term_start, term_end, reg_start, reg_end, install1, install2');
            $this->set_values("?,?,?,?,?,?,?,?,?");

            $bind_params = array('issssssss',
                                 &$this->fields['term_id']['value'],
                                 &$this->fields['school_year']['value'],
                                 &$this->fields['term']['value'],
                                 &$this->fields['term_start']['value'],
                                 &$this->fields['term_end']['value'],
                                 &$this->fields['reg_start']['value'],
                                 &$this->fields['reg_end']['value'],
                                 &$this->fields['install1']['value'],
                                 &$this->fields['install2']['value']);

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
            $this->set_update("school_year = ?, term = ?, term_start = ?, term_end = ?, reg_start = ?, reg_end = ?, install1 = ?, install2 = ?");
            $this->set_where("term_id = ?");

            $bind_params = array('ssssssssi',
                                 &$this->fields['school_year']['value'],
                                 &$this->fields['term']['value'],
                                 &$this->fields['term_start']['value'],
                                 &$this->fields['term_end']['value'],
                                 &$this->fields['reg_start']['value'],
                                 &$this->fields['reg_end']['value'],
                                 &$this->fields['install1']['value'],
                                 &$this->fields['install2']['value'],
                                 &$this->fields['term_id']['value']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("term_id = ?");

        $bind_params = array('i',
                             &$this->fields['term_id']['value']);

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
        $this->set_where("term_id = ?");

        $bind_params = array('i',
                             &$this->fields['term_id']['value']);

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
        $this->set_where("term_id = ? AND (term_id != ?)");

        $bind_params = array('ii',
                             &$this->fields['term_id']['value'],
                             &$this->fields['term_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
