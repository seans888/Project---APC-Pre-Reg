<?php
require_once 'reftermperiod_dd.php';
class reftermperiod extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = reftermperiod_dd::load_dictionary();
        $this->relations  = reftermperiod_dd::load_relationships();
        $this->subclasses = reftermperiod_dd::load_subclass_info();
        $this->table_name = reftermperiod_dd::$table_name;
        $this->tables     = reftermperiod_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('term_id, period, exam_start, exam_end, faculty_evaluation_start, faculty_evaluation_end, grade_submission_start, grade_submission_end');
            $this->set_values("?,?,?,?,?,?,?,?");

            $bind_params = array('isssssss',
                                 &$this->fields['term_id']['value'],
                                 &$this->fields['period']['value'],
                                 &$this->fields['exam_start']['value'],
                                 &$this->fields['exam_end']['value'],
                                 &$this->fields['faculty_evaluation_start']['value'],
                                 &$this->fields['faculty_evaluation_end']['value'],
                                 &$this->fields['grade_submission_start']['value'],
                                 &$this->fields['grade_submission_end']['value']);

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
            $this->set_update("term_id = ?, period = ?, exam_start = ?, exam_end = ?, faculty_evaluation_start = ?, faculty_evaluation_end = ?, grade_submission_start = ?, grade_submission_end = ?");
            $this->set_where("term_id = ? AND period = ?");

            $bind_params = array('isssssssis',
                                 &$this->fields['term_id']['value'],
                                 &$this->fields['period']['value'],
                                 &$this->fields['exam_start']['value'],
                                 &$this->fields['exam_end']['value'],
                                 &$this->fields['faculty_evaluation_start']['value'],
                                 &$this->fields['faculty_evaluation_end']['value'],
                                 &$this->fields['grade_submission_start']['value'],
                                 &$this->fields['grade_submission_end']['value'],
                                 $param['orig_term_id'],
                                 $param['orig_period']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("term_id = ? AND period = ?");

        $bind_params = array('is',
                             &$this->fields['term_id']['value'],
                             &$this->fields['period']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete_many($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("term_id = ? AND period = ?");

        $bind_params = array('is',
                             &$this->fields['term_id']['value'],
                             &$this->fields['period']['value']);

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
        $this->set_where("term_id = ? AND period = ?");

        $bind_params = array('is',
                             &$this->fields['term_id']['value'],
                             &$this->fields['period']['value']);

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
        $this->set_where("term_id = ? AND period = ? AND (term_id != '$orig_term_id' OR period != '$orig_period')");

        $bind_params = array('is',
                             &$this->fields['term_id']['value'],
                             &$this->fields['period']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
