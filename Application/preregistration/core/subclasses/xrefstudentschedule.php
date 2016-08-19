<?php
require_once 'xrefstudentschedule_dd.php';
class xrefstudentschedule extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = xrefstudentschedule_dd::load_dictionary();
        $this->relations  = xrefstudentschedule_dd::load_relationships();
        $this->subclasses = xrefstudentschedule_dd::load_subclass_info();
        $this->table_name = xrefstudentschedule_dd::$table_name;
        $this->tables     = xrefstudentschedule_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('subject_offering_id, student_id, enrollment_status, date, term_id, subject_code');
            $this->set_values("?,?,?,?,?,?");

            $bind_params = array('isssss',
                                 &$this->fields['subject_offering_id']['value'],
                                 &$this->fields['student_id']['value'],
                                 &$this->fields['enrollment_status']['value'],
                                 &$this->fields['date']['value'],
                                 &$this->fields['term_id']['value'],
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
            $this->set_update("subject_offering_id = ?, student_id = ?, enrollment_status = ?, date = ?, term_id = ?, subject_code = ?");
            $this->set_where("subject_offering_id = ? AND student_id = ?");

            $bind_params = array('isssssis',
                                 &$this->fields['subject_offering_id']['value'],
                                 &$this->fields['student_id']['value'],
                                 &$this->fields['enrollment_status']['value'],
                                 &$this->fields['date']['value'],
                                 &$this->fields['term_id']['value'],
                                 &$this->fields['subject_code']['value'],
                                 $param['orig_subject_offering_id'],
                                 $param['orig_student_id']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("subject_offering_id = ? AND student_id = ?");

        $bind_params = array('is',
                             &$this->fields['subject_offering_id']['value'],
                             &$this->fields['student_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete_many($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("subject_offering_id = ? AND student_id = ?");

        $bind_params = array('is',
                             &$this->fields['subject_offering_id']['value'],
                             &$this->fields['student_id']['value']);

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
        $this->set_where("subject_offering_id = ? AND student_id = ?");

        $bind_params = array('is',
                             &$this->fields['subject_offering_id']['value'],
                             &$this->fields['student_id']['value']);

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
        $this->set_where("subject_offering_id = ? AND student_id = ? AND (subject_offering_id != '$orig_subject_offering_id' OR student_id != '$orig_student_id')");

        $bind_params = array('is',
                             &$this->fields['subject_offering_id']['value'],
                             &$this->fields['student_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
