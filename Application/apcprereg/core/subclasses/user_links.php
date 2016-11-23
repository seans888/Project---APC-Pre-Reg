<?php
require_once 'user_links_dd.php';
class user_links extends data_abstraction
{
    var $fields = array();

    function __construct()
    {
        $this->fields     = user_links_dd::load_dictionary();
        $this->relations  = user_links_dd::load_relationships();
        $this->subclasses = user_links_dd::load_subclass_info();
        $this->table_name = user_links_dd::$table_name;
        $this->tables     = user_links_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('INSERT');
        $this->set_fields('link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority');
        $this->set_values("?,?,?,?,?,?,?,?,?,?");

        $bind_params = array('issssisssi',
                             $this->fields['link_id']['value'],
                             $this->fields['name']['value'],
                             $this->fields['target']['value'],
                             $this->fields['descriptive_title']['value'],
                             $this->fields['description']['value'],
                             $this->fields['passport_group_id']['value'],
                             $this->fields['show_in_tasklist']['value'],
                             $this->fields['status']['value'],
                             $this->fields['icon']['value'],
                             $this->fields['priority']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function edit($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('UPDATE');
        $this->set_update("name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ?");
        $this->set_where("link_id = ?");

        $bind_params = array('ssssisssii',
                             $this->fields['name']['value'],
                             $this->fields['target']['value'],
                             $this->fields['descriptive_title']['value'],
                             $this->fields['description']['value'],
                             $this->fields['passport_group_id']['value'],
                             $this->fields['show_in_tasklist']['value'],
                             $this->fields['status']['value'],
                             $this->fields['icon']['value'],
                             $this->fields['priority']['value'],
                             $this->fields['link_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("link_id = ?");

        $bind_params = array('i',
                             $this->fields['link_id']['value']);

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
        $this->set_where("link_id = ?");

        $bind_params = array('i',
                             $this->fields['link_id']['value']);

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
        $this->set_where("link_id = ? AND (link_id != ?)");

        $bind_params = array('ii',
                             $this->fields['link_id']['value'],
                             $this->fields['link_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
