<?php
class system_settings_dd
{
    static $table_name = 'system_settings';
    static $readable_name = 'System Settings';

    static function load_dictionary()
    {
        $fields = array(
                        'setting' => array('value'=>'',
                                              'data_type'=>'varchar',
                                              'length'=>255,
                                              'required'=>TRUE,
                                              'attribute'=>'primary key',
                                              'control_type'=>'textbox',
                                              'size'=>60,
                                              'drop_down_has_blank'=>TRUE,
                                              'label'=>'Setting',
                                              'extra'=>'',
                                              'in_listview'=>TRUE,
                                              'char_set_method'=>'',
                                              'char_set_allow_space'=>TRUE,
                                              'extra_chars_allowed'=>'',
                                              'allow_html_tags'=>FALSE,
                                              'trim'=>'trim',
                                              'valid_set'=>array(),
                                              'date_elements'=>array('','',''),
                                              'book_list_generator'=>'',
                                              'list_type'=>'',
                                              'list_settings'=>array(''),
                                              'rpt_in_report'=>TRUE,
                                              'rpt_column_format'=>'normal',
                                              'rpt_column_alignment'=>'left',
                                              'rpt_show_sum'=>FALSE),
                        'value' => array('value'=>'',
                                              'data_type'=>'varchar',
                                              'length'=>255,
                                              'required'=>TRUE,
                                              'attribute'=>'',
                                              'control_type'=>'textbox',
                                              'size'=>60,
                                              'drop_down_has_blank'=>TRUE,
                                              'label'=>'Value',
                                              'extra'=>'',
                                              'in_listview'=>TRUE,
                                              'char_set_method'=>'',
                                              'char_set_allow_space'=>TRUE,
                                              'extra_chars_allowed'=>'',
                                              'allow_html_tags'=>FALSE,
                                              'trim'=>'trim',
                                              'valid_set'=>array(),
                                              'date_elements'=>array('','',''),
                                              'book_list_generator'=>'',
                                              'list_type'=>'',
                                              'list_settings'=>array(''),
                                              'rpt_in_report'=>TRUE,
                                              'rpt_column_format'=>'normal',
                                              'rpt_column_alignment'=>'left',
                                              'rpt_show_sum'=>FALSE),
                       );
        return $fields;
    }

    static function load_relationships()
    {
        $relations = array();

        return $relations;
    }

    static function load_subclass_info()
    {
        $subclasses = array('html_file'=>'system_settings_html.php',
                            'html_class'=>'system_settings_html',
                            'data_file'=>'system_settings.php',
                            'data_class'=>'system_settings');
        return $subclasses;
    }

}
