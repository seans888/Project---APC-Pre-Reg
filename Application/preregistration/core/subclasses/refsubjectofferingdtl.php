<?php
require_once 'refsubjectofferingdtl_dd.php';
class refsubjectofferingdtl extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = refsubjectofferingdtl_dd::load_dictionary();
        $this->relations  = refsubjectofferingdtl_dd::load_relationships();
        $this->subclasses = refsubjectofferingdtl_dd::load_subclass_info();
        $this->table_name = refsubjectofferingdtl_dd::$table_name;
        $this->tables     = refsubjectofferingdtl_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('subject_offering_id, time, time_start, time_end, day, room, room_type');
            $this->set_values("?,?,?,?,?,?,?");

            $bind_params = array('isiisss',
                                 &$this->fields['subject_offering_id']['value'],
                                 &$this->fields['time']['value'],
                                 &$this->fields['time_start']['value'],
                                 &$this->fields['time_end']['value'],
                                 &$this->fields['day']['value'],
                                 &$this->fields['room']['value'],
                                 &$this->fields['room_type']['value']);

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
            $this->set_update("subject_offering_id = ?, time = ?, time_start = ?, time_end = ?, day = ?, room = ?, room_type = ?");
            $this->set_where("");

            $bind_params = array('isiisss',
                                 &$this->fields['subject_offering_id']['value'],
                                 &$this->fields['time']['value'],
                                 &$this->fields['time_start']['value'],
                                 &$this->fields['time_end']['value'],
                                 &$this->fields['day']['value'],
                                 &$this->fields['room']['value'],
                                 &$this->fields['room_type']['value']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
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
        $this->set_where("");

        $bind_params = array('',
                             );

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
        $this->set_where(" AND ()");

        $bind_params = array('',
                             );

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
