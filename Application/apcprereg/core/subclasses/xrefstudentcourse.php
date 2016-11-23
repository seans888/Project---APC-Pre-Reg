<?php
require_once 'xrefstudentcourse_dd.php';
class xrefstudentcourse extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = xrefstudentcourse_dd::load_dictionary();
        $this->relations  = xrefstudentcourse_dd::load_relationships();
        $this->subclasses = xrefstudentcourse_dd::load_subclass_info();
        $this->table_name = xrefstudentcourse_dd::$table_name;
        $this->tables     = xrefstudentcourse_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('student_id, course_id, flowchart, school_year, term, is_graduating, student_status, flow_id, course, term_id, fee');
            $this->set_values("?,?,?,?,?,?,?,?,?,?,?");

            $bind_params = array('sssssssiiis',
                                 &$this->fields['student_id']['value'],
                                 &$this->fields['course_id']['value'],
                                 &$this->fields['flowchart']['value'],
                                 &$this->fields['school_year']['value'],
                                 &$this->fields['term']['value'],
                                 &$this->fields['is_graduating']['value'],
                                 &$this->fields['student_status']['value'],
                                 &$this->fields['flow_id']['value'],
                                 &$this->fields['course']['value'],
                                 &$this->fields['term_id']['value'],
                                 &$this->fields['fee']['value']);

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
            $this->set_update("student_id = ?, course_id = ?, flowchart = ?, school_year = ?, term = ?, is_graduating = ?, student_status = ?, flow_id = ?, course = ?, term_id = ?, fee = ?");
            $this->set_where("student_id = ? AND course = ? AND term_id = ?");

            $bind_params = array('sssssssiiissii',
                                 &$this->fields['student_id']['value'],
                                 &$this->fields['course_id']['value'],
                                 &$this->fields['flowchart']['value'],
                                 &$this->fields['school_year']['value'],
                                 &$this->fields['term']['value'],
                                 &$this->fields['is_graduating']['value'],
                                 &$this->fields['student_status']['value'],
                                 &$this->fields['flow_id']['value'],
                                 &$this->fields['course']['value'],
                                 &$this->fields['term_id']['value'],
                                 &$this->fields['fee']['value'],
                                 $param['orig_student_id'],
                                 $param['orig_course'],
                                 $param['orig_term_id']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("student_id = ? AND course = ? AND term_id = ?");

        $bind_params = array('sii',
                             &$this->fields['student_id']['value'],
                             &$this->fields['course']['value'],
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
        $this->set_where("student_id = ? AND course = ? AND term_id = ?");

        $bind_params = array('sii',
                             &$this->fields['student_id']['value'],
                             &$this->fields['course']['value'],
                             &$this->fields['term_id']['value']);

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
        $this->set_where("student_id = ? AND course = ? AND term_id = ?");

        $bind_params = array('sii',
                             &$this->fields['student_id']['value'],
                             &$this->fields['course']['value'],
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
        //Next two lines just to get the orig_ pkey(s) from $param
        $this->escape_arguments($param);
        extract($param);

        $this->set_query_type('SELECT');
        $this->set_where("student_id = ? AND course = ? AND term_id = ? AND (student_id != '$orig_student_id' OR course != '$orig_course' OR term_id != '$orig_term_id')");

        $bind_params = array('sii',
                             &$this->fields['student_id']['value'],
                             &$this->fields['course']['value'],
                             &$this->fields['term_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
