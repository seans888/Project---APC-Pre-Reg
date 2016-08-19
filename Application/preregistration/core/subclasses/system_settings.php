<?php
require_once 'system_settings_dd.php';
class system_settings extends data_abstraction
{
    var $fields = array();

    function __construct()
    {
        $this->fields     = system_settings_dd::load_dictionary();
        $this->relations  = system_settings_dd::load_relationships();
        $this->subclasses = system_settings_dd::load_subclass_info();
        $this->table_name = system_settings_dd::$table_name;
        $this->tables     = system_settings_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('INSERT');
        $this->set_fields('setting, value');
        $this->set_values("?,?");

        $bind_params = array('ss',
                             $this->fields['setting']['value'],
                             $this->fields['value']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function edit($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('UPDATE');
        $this->set_update("setting = ?, value = ?");
        $this->set_where("setting = ?");

        $bind_params = array('sss',
                             $this->fields['setting']['value'],
                             $this->fields['value']['value'],
                             $param['orig_setting']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("setting = ?");

        $bind_params = array('s',
                             $this->fields['setting']['value']);

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
        $this->set_where("setting = ?");

        $bind_params = array('s',
                             $this->fields['setting']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }

    function check_uniqueness_for_editing($param)
    {
        $orig_setting = $param['orig_setting'];
        $this->escape_arguments($orig_setting);
        $this->set_parameters($param);
        $this->set_query_type('SELECT');
        $this->set_where("setting = ? AND (setting != '$orig_setting')");

        $bind_params = array('s',
                             $this->fields['setting']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }

    function get($setting_name, $strict_mode=TRUE)
    {
        $this->escape_arguments($setting_name);
        $this->set_fields('value');
        $this->set_where("setting='$setting_name'");
        $this->exec_fetch('single');


        if($this->num_rows == 0)
        {
            if($strict_mode)
            {
                error_handler('NO SETTING "' . $setting_name . '" FOUND!', ' Complete query was: ' . $this->query);
            }
            else
            {
                $this->value='';
                $this->dump['value'] = '';
            }
        }

        return $this;
    }
}
