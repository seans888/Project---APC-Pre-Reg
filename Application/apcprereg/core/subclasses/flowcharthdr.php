<?php
require_once 'flowcharthdr_dd.php';
class flowcharthdr extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = flowcharthdr_dd::load_dictionary();
        $this->relations  = flowcharthdr_dd::load_relationships();
        $this->subclasses = flowcharthdr_dd::load_subclass_info();
        $this->table_name = flowcharthdr_dd::$table_name;
        $this->tables     = flowcharthdr_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('flow_id, flow_code, flow_name, school_year_start, is_deleted, course_id');
            $this->set_values("?,?,?,?,?,?");

            $bind_params = array('issssi',
                                 &$this->fields['flow_id']['value'],
                                 &$this->fields['flow_code']['value'],
                                 &$this->fields['flow_name']['value'],
                                 &$this->fields['school_year_start']['value'],
                                 &$this->fields['is_deleted']['value'],
                                 &$this->fields['course_id']['value']);

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
            $this->set_update("flow_code = ?, flow_name = ?, school_year_start = ?, is_deleted = ?, course_id = ?");
            $this->set_where("flow_id = ?");

            $bind_params = array('ssssii',
                                 &$this->fields['flow_code']['value'],
                                 &$this->fields['flow_name']['value'],
                                 &$this->fields['school_year_start']['value'],
                                 &$this->fields['is_deleted']['value'],
                                 &$this->fields['course_id']['value'],
                                 &$this->fields['flow_id']['value']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("flow_id = ?");

        $bind_params = array('i',
                             &$this->fields['flow_id']['value']);

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
        $this->set_where("flow_id = ?");

        $bind_params = array('i',
                             &$this->fields['flow_id']['value']);

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
        $this->set_where("flow_id = ? AND (flow_id != ?)");

        $bind_params = array('ii',
                             &$this->fields['flow_id']['value'],
                             &$this->fields['flow_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }

    function get_student_flowchart($param)
    {
        $this->set_query_type('SELECT');
        $this->set_fields('refStudent.student_id, refStudent.student_last_name, refStudent.student_first_name, refStudent.student_middle_name');
        $this->set_table('refStudent
                            INNER JOIN xrefStudentCourse...');
        $this->set_where("refStudent.student_id = '" . $param['student_id'] . "'");
        $this->set_order_by('FlowchartDtl.location_xy');

        $this->exec_fetch('array');
        return $this;
    }
}
