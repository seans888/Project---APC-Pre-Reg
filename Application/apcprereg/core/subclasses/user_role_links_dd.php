<?php
class user_role_links_dd
{
    static $table_name = 'user_role_links';
    static $readable_name = 'User Role Links';

    static function load_dictionary()
    {
        $fields = array(
                        'role_id' => array('value'=>'',
                                              'data_type'=>'integer',
                                              'length'=>11,
                                              'required'=>FALSE,
                                              'attribute'=>'primary&foreign key',
                                              'control_type'=>'none',
                                              'size'=>0,
                                              'drop_down_has_blank'=>TRUE,
                                              'label'=>'Role ID',
                                              'extra'=>'',
                                              'in_listview'=>TRUE,
                                              'char_set_method'=>'generate_num_set',
                                              'char_set_allow_space'=>FALSE,
                                              'extra_chars_allowed'=>'-',
                                              'allow_html_tags'=>FALSE,
                                              'trim'=>'trim',
                                              'valid_set'=>array(),
                                              'date_elements'=>array('','',''),
                                              'book_list_generator'=>'',
                                              'list_type'=>'',
                                              'list_settings'=>array(''),
                                              'rpt_in_report'=>TRUE,
                                              'rpt_column_format'=>'normal',
                                              'rpt_column_alignment'=>'right',
                                              'rpt_show_sum'=>FALSE),
                        'link_id' => array('value'=>'',
                                              'data_type'=>'integer',
                                              'length'=>11,
                                              'required'=>TRUE,
                                              'attribute'=>'primary&foreign key',
                                              'control_type'=>'drop-down list',
                                              'size'=>0,
                                              'drop_down_has_blank'=>TRUE,
                                              'label'=>'Link',
                                              'extra'=>'',
                                              'in_listview'=>TRUE,
                                              'char_set_method'=>'generate_num_set',
                                              'char_set_allow_space'=>FALSE,
                                              'extra_chars_allowed'=>'-',
                                              'allow_html_tags'=>FALSE,
                                              'trim'=>'trim',
                                              'valid_set'=>array(),
                                              'date_elements'=>array('','',''),
                                              'book_list_generator'=>'',
                                              'list_type'=>'sql generated',
                                              'list_settings'=>array('query' => "SELECT user_links.link_id AS `Queried_link_id`, user_links.descriptive_title FROM user_links",
                                                                     'list_value' => 'Queried_link_id',
                                                                     'list_items' => array('descriptive_title'),
                                                                     'list_separators' => array()),
                                              'rpt_in_report'=>TRUE,
                                              'rpt_column_format'=>'normal',
                                              'rpt_column_alignment'=>'right',
                                              'rpt_show_sum'=>FALSE),
                       );
        return $fields;
    }

    static function load_relationships()
    {
        $relations = array('1'=>array('type'=>'1-M',
                                      'table'=>'user_role',
                                      'link_parent'=>'role_id',
                                      'link_child'=>'role_id',
                                      'link_subtext'=>array(''),
                                      'where_clause'=>''),
                           '2'=>array('type'=>'1-1',
                                      'table'=>'user_links',
                                      'link_parent'=>'link_id',
                                      'link_child'=>'link_id',
                                      'link_subtext'=>array('descriptive_title'),
                                      'where_clause'=>''));

        return $relations;
    }

    static function load_subclass_info()
    {
        $subclasses = array('html_file'=>'user_role_links_html.php',
                            'html_class'=>'user_role_links_html',
                            'data_file'=>'user_role_links.php',
                            'data_class'=>'user_role_links');
        return $subclasses;
    }

}
