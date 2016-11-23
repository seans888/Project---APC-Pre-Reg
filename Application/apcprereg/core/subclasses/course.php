<?php
require_once 'course_dd.php';
class course extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = course_dd::load_dictionary();
        $this->relations  = course_dd::load_relationships();
        $this->subclasses = course_dd::load_subclass_info();
        $this->table_name = course_dd::$table_name;
        $this->tables     = course_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('course, course_id, course_name, GP_num, dept_id, is_offered');
            $this->set_values("?,?,?,?,?,?");

            $bind_params = array('isssss',
                                 &$this->fields['course']['value'],
                                 &$this->fields['course_id']['value'],
                                 &$this->fields['course_name']['value'],
                                 &$this->fields['GP_num']['value'],
                                 &$this->fields['dept_id']['value'],
                                 &$this->fields['is_offered']['value']);

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
            $this->set_update("course_id = ?, course_name = ?, GP_num = ?, dept_id = ?, is_offered = ?");
            $this->set_where("course = ?");

            $bind_params = array('sssssi',
                                 &$this->fields['course_id']['value'],
                                 &$this->fields['course_name']['value'],
                                 &$this->fields['GP_num']['value'],
                                 &$this->fields['dept_id']['value'],
                                 &$this->fields['is_offered']['value'],
                                 &$this->fields['course']['value']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("course = ?");

        $bind_params = array('i',
                             &$this->fields['course']['value']);

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
        $this->set_where("course = ?");

        $bind_params = array('i',
                             &$this->fields['course']['value']);

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
        $this->set_where("course = ? AND (course != ?)");

        $bind_params = array('ii',
                             &$this->fields['course']['value'],
                             &$this->fields['course']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
