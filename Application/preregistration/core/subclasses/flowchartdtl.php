<?php
require_once 'flowchartdtl_dd.php';
class flowchartdtl extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = flowchartdtl_dd::load_dictionary();
        $this->relations  = flowchartdtl_dd::load_relationships();
        $this->subclasses = flowchartdtl_dd::load_subclass_info();
        $this->table_name = flowchartdtl_dd::$table_name;
        $this->tables     = flowchartdtl_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('flow_dtl_id, flow_id, subject_id, location_xy, with_prerequisite');
            $this->set_values("?,?,?,?,?");

            $bind_params = array('iiiss',
                                 &$this->fields['flow_dtl_id']['value'],
                                 &$this->fields['flow_id']['value'],
                                 &$this->fields['subject_id']['value'],
                                 &$this->fields['location_xy']['value'],
                                 &$this->fields['with_prerequisite']['value']);

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
            $this->set_update("flow_id = ?, subject_id = ?, location_xy = ?, with_prerequisite = ?");
            $this->set_where("flow_dtl_id = ?");

            $bind_params = array('iissi',
                                 &$this->fields['flow_id']['value'],
                                 &$this->fields['subject_id']['value'],
                                 &$this->fields['location_xy']['value'],
                                 &$this->fields['with_prerequisite']['value'],
                                 &$this->fields['flow_dtl_id']['value']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("flow_dtl_id = ?");

        $bind_params = array('i',
                             &$this->fields['flow_dtl_id']['value']);

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
        $this->set_where("flow_dtl_id = ?");

        $bind_params = array('i',
                             &$this->fields['flow_dtl_id']['value']);

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
        $this->set_where("flow_dtl_id = ? AND (flow_dtl_id != ?)");

        $bind_params = array('ii',
                             &$this->fields['flow_dtl_id']['value'],
                             &$this->fields['flow_dtl_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
