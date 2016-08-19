<?php
require_once 'system_skins_dd.php';
class system_skins extends data_abstraction
{
    var $fields = array();

    function __construct()
    {
        $this->fields     = system_skins_dd::load_dictionary();
        $this->relations  = system_skins_dd::load_relationships();
        $this->subclasses = system_skins_dd::load_subclass_info();
        $this->table_name = system_skins_dd::$table_name;
        $this->tables     = system_skins_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('INSERT');
        $this->set_fields('skin_id, skin_name, header, footer, master_css, colors_css, fonts_css, override_css, icon_set');
        $this->set_values("?,?,?,?,?,?,?,?,?");

        $bind_params = array('issssssss',
                             $this->fields['skin_id']['value'],
                             $this->fields['skin_name']['value'],
                             $this->fields['header']['value'],
                             $this->fields['footer']['value'],
                             $this->fields['master_css']['value'],
                             $this->fields['colors_css']['value'],
                             $this->fields['fonts_css']['value'],
                             $this->fields['override_css']['value'],
                             $this->fields['icon_set']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function edit($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('UPDATE');
        $this->set_update("skin_name = ?, header = ?, footer = ?, master_css = ?, colors_css = ?, fonts_css = ?, override_css = ?, icon_set = ?");
        $this->set_where("skin_id = ?");

        $bind_params = array('ssssssssi',
                             $this->fields['skin_name']['value'],
                             $this->fields['header']['value'],
                             $this->fields['footer']['value'],
                             $this->fields['master_css']['value'],
                             $this->fields['colors_css']['value'],
                             $this->fields['fonts_css']['value'],
                             $this->fields['override_css']['value'],
                             $this->fields['icon_set']['value'],
                             $this->fields['skin_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("skin_id = ?");

        $bind_params = array('i',
                             $this->fields['skin_id']['value']);

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
        $this->set_where("skin_id = ?");

        $bind_params = array('i',
                             $this->fields['skin_id']['value']);

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
        $this->set_where("skin_id = ? AND (skin_id != ?)");

        $bind_params = array('ii',
                             $this->fields['skin_id']['value'],
                             $this->fields['skin_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
