<?php
class refsubjectofferinghdr_dd
{
    static $table_name = 'refsubjectofferinghdr';
    static $readable_name = 'Refsubjectofferinghdr';

    static function load_dictionary()
    {
        $fields = array(
                        'subject_offering_id' => array('value'=>'',
                                              'nullable'=>FALSE,
                                              'data_type'=>'integer',
                                              'length'=>11,
                                              'required'=>FALSE,
                                              'attribute'=>'primary key',
                                              'control_type'=>'none',
                                              'size'=>0,
                                              'upload_path'=>'',
                                              'drop_down_has_blank'=>TRUE,
                                              'label'=>'Subject Offering ID',
                                              'extra'=>'',
                                              'companion'=>'',
                                              'in_listview'=>FALSE,
                                              'char_set_method'=>'generate_num_set',
                                              'char_set_allow_space'=>FALSE,
                                              'extra_chars_allowed'=>'-',
                                              'allow_html_tags'=>FALSE,
                                              'trim'=>'trim',
                                              'valid_set'=>array(),
                                              'date_elements'=>array('','',''),
                                              'date_default'=>'',
                                              'list_type'=>'',
                                              'list_settings'=>array(''),
                                              'rpt_in_report'=>TRUE,
                                              'rpt_column_format'=>'normal',
                                              'rpt_column_alignment'=>'center',
                                              'rpt_show_sum'=>FALSE),
                        'term_id' => array('value'=>'',
                                              'nullable'=>FALSE,
                                              'data_type'=>'integer',
                                              'length'=>5,
                                              'required'=>TRUE,
                                              'attribute'=>'',
                                              'control_type'=>'textbox',
                                              'size'=>60,
                                              'upload_path'=>'',
                                              'drop_down_has_blank'=>TRUE,
                                              'label'=>'Term ID',
                                              'extra'=>'',
                                              'companion'=>'',
                                              'in_listview'=>TRUE,
                                              'char_set_method'=>'generate_num_set',
                                              'char_set_allow_space'=>FALSE,
                                              'extra_chars_allowed'=>'-',
                                              'allow_html_tags'=>FALSE,
                                              'trim'=>'trim',
                                              'valid_set'=>array(),
                                              'date_elements'=>array('','',''),
                                              'date_default'=>'',
                                              'list_type'=>'',
                                              'list_settings'=>array(''),
                                              'rpt_in_report'=>TRUE,
                                              'rpt_column_format'=>'normal',
                                              'rpt_column_alignment'=>'center',
                                              'rpt_show_sum'=>FALSE),
                        'subject_id' => array('value'=>'',
                                              'nullable'=>FALSE,
                                              'data_type'=>'integer',
                                              'length'=>5,
                                              'required'=>TRUE,
                                              'attribute'=>'',
                                              'control_type'=>'textbox',
                                              'size'=>60,
                                              'upload_path'=>'',
                                              'drop_down_has_blank'=>TRUE,
                                              'label'=>'Subject ID',
                                              'extra'=>'',
                                              'companion'=>'',
                                              'in_listview'=>TRUE,
                                              'char_set_method'=>'generate_num_set',
                                              'char_set_allow_space'=>FALSE,
                                              'extra_chars_allowed'=>'-',
                                              'allow_html_tags'=>FALSE,
                                              'trim'=>'trim',
                                              'valid_set'=>array(),
                                              'date_elements'=>array('','',''),
                                              'date_default'=>'',
                                              'list_type'=>'',
                                              'list_settings'=>array(''),
                                              'rpt_in_report'=>TRUE,
                                              'rpt_column_format'=>'normal',
                                              'rpt_column_alignment'=>'center',
                                              'rpt_show_sum'=>FALSE),
                        'section' => array('value'=>'',
                                              'nullable'=>TRUE,
                                              'data_type'=>'varchar',
                                              'length'=>255,
                                              'required'=>TRUE,
                                              'attribute'=>'',
                                              'control_type'=>'textbox',
                                              'size'=>60,
                                              'upload_path'=>'',
                                              'drop_down_has_blank'=>TRUE,
                                              'label'=>'Section',
                                              'extra'=>'',
                                              'companion'=>'',
                                              'in_listview'=>TRUE,
                                              'char_set_method'=>'',
                                              'char_set_allow_space'=>TRUE,
                                              'extra_chars_allowed'=>'',
                                              'allow_html_tags'=>FALSE,
                                              'trim'=>'trim',
                                              'valid_set'=>array(),
                                              'date_elements'=>array('','',''),
                                              'date_default'=>'',
                                              'list_type'=>'',
                                              'list_settings'=>array(''),
                                              'rpt_in_report'=>TRUE,
                                              'rpt_column_format'=>'normal',
                                              'rpt_column_alignment'=>'left',
                                              'rpt_show_sum'=>FALSE),
                        'subject_code' => array('value'=>'',
                                              'nullable'=>FALSE,
                                              'data_type'=>'varchar',
                                              'length'=>250,
                                              'required'=>TRUE,
                                              'attribute'=>'',
                                              'control_type'=>'textbox',
                                              'size'=>60,
                                              'upload_path'=>'',
                                              'drop_down_has_blank'=>TRUE,
                                              'label'=>'Subject Code',
                                              'extra'=>'',
                                              'companion'=>'',
                                              'in_listview'=>TRUE,
                                              'char_set_method'=>'',
                                              'char_set_allow_space'=>TRUE,
                                              'extra_chars_allowed'=>'',
                                              'allow_html_tags'=>FALSE,
                                              'trim'=>'trim',
                                              'valid_set'=>array(),
                                              'date_elements'=>array('','',''),
                                              'date_default'=>'',
                                              'list_type'=>'',
                                              'list_settings'=>array(''),
                                              'rpt_in_report'=>TRUE,
                                              'rpt_column_format'=>'normal',
                                              'rpt_column_alignment'=>'left',
                                              'rpt_show_sum'=>FALSE)
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
        $subclasses = array('html_file'=>'refsubjectofferinghdr_html.php',
                            'html_class'=>'refsubjectofferinghdr_html',
                            'data_file'=>'refsubjectofferinghdr.php',
                            'data_class'=>'refsubjectofferinghdr');
        return $subclasses;
    }

}