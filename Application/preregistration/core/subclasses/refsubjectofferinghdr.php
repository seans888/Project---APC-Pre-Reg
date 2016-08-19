<?php
require_once 'refsubjectofferinghdr_dd.php';
class refsubjectofferinghdr extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = refsubjectofferinghdr_dd::load_dictionary();
        $this->relations  = refsubjectofferinghdr_dd::load_relationships();
        $this->subclasses = refsubjectofferinghdr_dd::load_subclass_info();
        $this->table_name = refsubjectofferinghdr_dd::$table_name;
        $this->tables     = refsubjectofferinghdr_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('subject_offering_id, term_id, subject_id, section, subject_code');
            $this->set_values("?,?,?,?,?");

            $bind_params = array('iiiss',
                                 &$this->fields['subject_offering_id']['value'],
                                 &$this->fields['term_id']['value'],
                                 &$this->fields['subject_id']['value'],
                                 &$this->fields['section']['value'],
                                 &$this->fields['subject_code']['value']);

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
            $this->set_update("term_id = ?, subject_id = ?, section = ?, subject_code = ?");
            $this->set_where("subject_offering_id = ?");

            $bind_params = array('iissi',
                                 &$this->fields['term_id']['value'],
                                 &$this->fields['subject_id']['value'],
                                 &$this->fields['section']['value'],
                                 &$this->fields['subject_code']['value'],
                                 &$this->fields['subject_offering_id']['value']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("subject_offering_id = ?");

        $bind_params = array('i',
                             &$this->fields['subject_offering_id']['value']);

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
        $this->set_where("subject_offering_id = ?");

        $bind_params = array('i',
                             &$this->fields['subject_offering_id']['value']);

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
        $this->set_where("subject_offering_id = ? AND (subject_offering_id != ?)");

        $bind_params = array('ii',
                             &$this->fields['subject_offering_id']['value'],
                             &$this->fields['subject_offering_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
