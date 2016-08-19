<?php
require_once 'refstudent_dd.php';
class refstudent extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = refstudent_dd::load_dictionary();
        $this->relations  = refstudent_dd::load_relationships();
        $this->subclasses = refstudent_dd::load_subclass_info();
        $this->table_name = refstudent_dd::$table_name;
        $this->tables     = refstudent_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('student_id, student_last_name, student_first_name, student_middle_name, birth_date, birth_place, admission_date, entry_level, admission_credential, mail_grades_to, exit_level, nationality, gender, address, postal_code, tel_num, mobile_num, email, religion, civil_status, box_num');
            $this->set_values("?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?");

            $bind_params = array('sssssssssssssssssssss',
                                 &$this->fields['student_id']['value'],
                                 &$this->fields['student_last_name']['value'],
                                 &$this->fields['student_first_name']['value'],
                                 &$this->fields['student_middle_name']['value'],
                                 &$this->fields['birth_date']['value'],
                                 &$this->fields['birth_place']['value'],
                                 &$this->fields['admission_date']['value'],
                                 &$this->fields['entry_level']['value'],
                                 &$this->fields['admission_credential']['value'],
                                 &$this->fields['mail_grades_to']['value'],
                                 &$this->fields['exit_level']['value'],
                                 &$this->fields['nationality']['value'],
                                 &$this->fields['gender']['value'],
                                 &$this->fields['address']['value'],
                                 &$this->fields['postal_code']['value'],
                                 &$this->fields['tel_num']['value'],
                                 &$this->fields['mobile_num']['value'],
                                 &$this->fields['email']['value'],
                                 &$this->fields['religion']['value'],
                                 &$this->fields['civil_status']['value'],
                                 &$this->fields['box_num']['value']);

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
            $this->set_update("student_id = ?, student_last_name = ?, student_first_name = ?, student_middle_name = ?, birth_date = ?, birth_place = ?, admission_date = ?, entry_level = ?, admission_credential = ?, mail_grades_to = ?, exit_level = ?, nationality = ?, gender = ?, address = ?, postal_code = ?, tel_num = ?, mobile_num = ?, email = ?, religion = ?, civil_status = ?, box_num = ?");
            $this->set_where("student_id = ?");

            $bind_params = array('ssssssssssssssssssssss',
                                 &$this->fields['student_id']['value'],
                                 &$this->fields['student_last_name']['value'],
                                 &$this->fields['student_first_name']['value'],
                                 &$this->fields['student_middle_name']['value'],
                                 &$this->fields['birth_date']['value'],
                                 &$this->fields['birth_place']['value'],
                                 &$this->fields['admission_date']['value'],
                                 &$this->fields['entry_level']['value'],
                                 &$this->fields['admission_credential']['value'],
                                 &$this->fields['mail_grades_to']['value'],
                                 &$this->fields['exit_level']['value'],
                                 &$this->fields['nationality']['value'],
                                 &$this->fields['gender']['value'],
                                 &$this->fields['address']['value'],
                                 &$this->fields['postal_code']['value'],
                                 &$this->fields['tel_num']['value'],
                                 &$this->fields['mobile_num']['value'],
                                 &$this->fields['email']['value'],
                                 &$this->fields['religion']['value'],
                                 &$this->fields['civil_status']['value'],
                                 &$this->fields['box_num']['value'],
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
        $this->set_where("student_id = ?");

        $bind_params = array('s',
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
        $this->set_where("student_id = ?");

        $bind_params = array('s',
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
        $this->set_where("student_id = ?");

        $bind_params = array('s',
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
        $this->set_where("student_id = ? AND (student_id != '$orig_student_id')");

        $bind_params = array('s',
                             &$this->fields['student_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
