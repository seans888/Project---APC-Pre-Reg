<?php
class base_reporter
{
    var $tables ='';
    var $session_array_name = '';
    var $report_title = '';
    var $html_subclass = '';
    var $data_subclass = '';
    var $result_page = '';
    var $cancel_page = '';
    var $header_bgcolor = '#999999';
    var $totals_bgcolor = '#999999';
    var $custom_join = '';
    var $arr_alias = array('b','c','d','e','f','g','h','i','j','k','l','m',
                           'n','o','p','q','r','s','t','u','v','w','x','y','z',
                           'aa','bb','cc','dd','ee','ff','gg','hh','ii','jj','kk','ll','mm',
                           'nn','oo','pp','qq','rr','ss','tt','uu','vv','ww','xx','yy','zz');

    var $arr_operators = array('EQUAL TO (=)',
                               'NOT EQUAL TO (!=)',
                               'LESS THAN (<)',
                               'LESS THAN OR EQUAL TO (<=)',
                               'GREATER THAN (>)',
                               'GREATER THAN OR EQUAL TO (>=)',
                               'CONTAINS (%..%)',
                               'DOES NOT CONTAIN (%..%)',
                               'STARTS WITH (..%)',
                               'ENDS WITH (%..)',
                               'IN (value1, value2, value3, ... valueN)',
                               'BETWEEN (value1, value2)',
                               'NOT BETWEEN (value1, value2)');

    var $arr_rpt_fields            = array(); //Ordered list of fields
    var $arr_rpt_fields_sql        = array(); //Key-value pairs of the field names to their corresponding query counterpart for SELECT/WHERE/GROUP purposes
    var $arr_rpt_column_alignments = array(); //Key-value pairs of field names to their default HTML table column alingment
    var $arr_rpt_column_formats    = array(); //Key-value pairs of field names to their default formatting for display
    var $arr_rpt_show_sum          = array(); //Key-value pairs of field names and their show sum setting (whether there will be a total at end row or not)

    function draw_report_interface_header()
    {
        echo '<table border="1">';
        echo '<tr >';
        echo '<th style="padding: 10px">
                Show Column<br>
                <a href="#" style="font-size: 11px" onClick="checkAll(); return false">Check All</a><br>
                <a href="#" style="font-size: 11px" onClick="uncheckAll();  return false">Uncheck All</a>
              </th>';
        echo '<th style="padding: 10px; min-width: 250px"> Field Name </th>';
        echo '<th style="padding: 10px"> Operator </th>';
        echo '<th style="padding: 10px"> Filter Value </th>';
        echo '<th style="padding: 10px">
                SUM <br/>';
        echo    '<a href="#" style="font-size: 11px" onClick="uncheckAllSum(); return false">Uncheck All</a>
             </th>';
        echo '<th style="padding: 10px">
                COUNT <br/>';
        echo    '<a href="#" style="font-size: 11px" onClick="uncheckAllCount(); return false">Uncheck All</a>
             </th>';
        echo '<th style="padding: 10px">
                GROUP BY (1)<br />
                <a href="#" style="font-size: 11px" onClick="removeGroup1(); return false">Remove</a><br>
             </th>';
        echo '<th style="padding: 10px">
                GROUP BY (2)<br />
                <a href="#" style="font-size: 11px" onClick="removeGroup2(); return false">Remove</a><br>
             </th>';
        echo '<th style="padding: 10px">
                GROUP BY (3)<br />
                <a href="#" style="font-size: 11px" onClick="removeGroup3(); return false">Remove</a><br>
             </th>';
        echo '</tr>';
        return $this;
    }

    function draw_report_interface_footer()
    {
        echo '</table>';
        return $this;
    }

    function get_custom_join()
    {
        $ENABLE_JOIN = FALSE;

        $alias_index = 0;

        //We don't just walk through $this->relations immediately because it has to follow the same alias as the
        //select fields, so we go through the same process and walk through each of the main table's fields, and
        //then look for included fields that are foreign keys, and get their info from $this->relations.
        foreach($this->fields as $dd_field_name=>$dd_field_data)
        {
            if($dd_field_data['rpt_in_report'] == TRUE && ($dd_field_data['attribute'] == 'foreign key' || $dd_field_data['attribute'] == 'primary&foreign key'))
            {
                foreach($this->relations as $relation_data)
                {
                    if($relation_data['link_child'] == $dd_field_name)
                    {
                        if($relation_data['type'] == '1-1')
                        {
                            if(!$ENABLE_JOIN)
                            {
                                $ENABLE_JOIN = TRUE;
                                $this->custom_join = $this->tables . ' a';
                            }

                            $alias = $this->arr_alias[$alias_index];
                            ++$alias_index;
                            $this->custom_join .= ' LEFT JOIN ' . $relation_data['table'] . ' ' . $alias . ' ON '
                                                 .'a.' . $relation_data['link_child'] . ' = ' . $alias . '.'
                                                 . $relation_data['link_parent'];
                        }
                    }
                }
            }
        }

        //If custom_join is still empty, that means no relationships were found; custom_join will default to the table
        if($this->custom_join == '')
        {
            $this->custom_join = $this->tables;
        }

        return $this;
    }

    function get_report_fields()
    {
        //Check if there are valid relationships
        $ENABLE_ALIAS = FALSE;
        foreach($this->relations as $relation_data)
        {
            if($relation_data['type'] == '1-1')
            {
                $ENABLE_ALIAS = TRUE;
                $alias_index = 0;
            }
        }

        foreach($this->fields as $dd_field_name=>$dd_field_data)
        {
            if($dd_field_data['rpt_in_report'] == TRUE && $dd_field_data['attribute'] != 'foreign key' && $dd_field_data['attribute'] != 'primary&foreign key')
            {
                $label = $dd_field_data['label'];
                $this->arr_rpt_fields[]                  = $label;
                $this->arr_rpt_column_alignments[$label] = $dd_field_data['rpt_column_alignment'];
                $this->arr_rpt_column_formats[$label]    = $dd_field_data['rpt_column_format'];
                $this->arr_rpt_show_sum[$label]          = $dd_field_data['rpt_show_sum'];

                if($ENABLE_ALIAS)
                {
                    $this->arr_rpt_fields_sql[$label] = 'a.'.$dd_field_name;
                }
                else
                {
                    $this->arr_rpt_fields_sql[$label] = $dd_field_name;
                }
            }

            if($dd_field_data['attribute'] == 'foreign key' || $dd_field_data['attribute'] == 'primary&foreign key')
            {
                foreach($this->relations as $relation_data)
                {
                    if($relation_data['type']=='1-1')
                    {
                        if($relation_data['link_child'] == $dd_field_name)
                        {
                            $obj_related_table = cobalt_load_class($relation_data['table']);
                            $arr_related_fields = $obj_related_table->fields;
                            $alias = $this->arr_alias[$alias_index];
                            ++$alias_index;
                            foreach($arr_related_fields as $rel_field_name=>$rel_field_data)
                            {
                                //We check if it is not a foreign key because we only want to include directly related tables.
                                if($rel_field_data['rpt_in_report'] == TRUE && $rel_field_data['attribute'] != 'foreign key')
                                {
                                    if(isset($relation_data['alias']) && $relation_data['alias'] != '')
                                    {
                                        $related_table_name = $relation_data['alias'];
                                    }
                                    else
                                    {
                                        $related_table_name = $relation_data['table'];
                                    }
                                    $label = '[' . ucwords(str_replace('_', ' ', $related_table_name)) . '] ' . $rel_field_data['label'];
                                    $this->arr_rpt_fields[]                  = $label;
                                    $this->arr_rpt_column_alignments[$label] = $rel_field_data['rpt_column_alignment'];
                                    $this->arr_rpt_column_formats[$label]    = $rel_field_data['rpt_column_format'];
                                    $this->arr_rpt_show_sum[$label]          = $rel_field_data['rpt_show_sum'];

                                    if($ENABLE_ALIAS)
                                    {
                                        $this->arr_rpt_fields_sql[$label] = $alias . '.' . $rel_field_name;
                                    }
                                    else
                                    {
                                        $this->arr_rpt_fields_sql[$label] = $rel_field_name;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $this;
    }

    function print_settings()
    {
        $this->get_custom_join();

        echo '<pre>';
        echo '//*** START OF REPORT SETTINGS ARRAYS & JOIN CLAUSE *********<br />';
        echo '//The proper place for these is inside the _rpt subclass of this module<br />';
        echo '    function get_custom_join()<br />';
        echo '    {<br />';
        echo '        $this->custom_join = \'' . $this->custom_join . '\';<br />';
        echo '        return $this;<br />';
        echo '    }<br /><br />';
        echo '    function get_report_fields()<br />';
        echo '    {<br />';
        echo '        $this->arr_rpt_fields = array(';
        foreach($this->arr_rpt_fields as $field)
        {
            echo "'$field'," . "<br />" . '                                      ';
        }
        echo ');<br /><br />';

        echo '        $this->arr_rpt_fields_sql = array(';
        $ctr_index=0;
        foreach($this->arr_rpt_fields_sql as $key=>$field)
        {
            echo "\$this->arr_rpt_fields[$ctr_index]=>'$field'," . "<br />" . '                                          ';
            ++$ctr_index;
        }
        echo ');<br /><br />';

        echo '        $this->arr_rpt_column_alignments = array(';
        $ctr_index=0;
        foreach($this->arr_rpt_column_alignments as $key=>$field)
        {
            echo "\$this->arr_rpt_fields[$ctr_index]=>'$field'," . "<br />" . '                                                 ';
            ++$ctr_index;
        }
        echo ');<br /><br />';

        echo '        $this->arr_rpt_column_formats = array(';
        $ctr_index=0;
        foreach($this->arr_rpt_column_formats as $key=>$field)
        {
            echo "\$this->arr_rpt_fields[$ctr_index]=>'$field'," . "<br />" . '                                              ';
            ++$ctr_index;
        }
        echo ');<br /><br />';

        echo '        $this->arr_rpt_show_sum = array(';
        $ctr_index=0;
        foreach($this->arr_rpt_show_sum as $key=>$field)
        {
            if($field === TRUE)
            {
                $field = 'TRUE';
            }
            elseif($field === FALSE)
            {
                $field = 'FALSE';
            }

            echo "\$this->arr_rpt_fields[$ctr_index]=>$field," . "<br />" . '                                        ';
            ++$ctr_index;
        }

        echo ');<br />';
        echo '        return $this;<br />';
        echo '    }<br /><br />';
        echo '</pre>';
        echo '//*** END OF REPORT SETTINGS ARRAYS & JOIN CLAUSE *********<br />';
        return $this;
    }

    function transform_value($value)
    {
        $transformed_value = $value;

        switch(trim($value))
        {
            case '@TODAY@':
                    $transformed_value = date('Y-m-d');
                    break;
            case '@THIS_WEEK':
                    $day_today = date('N'); //1-7 (ISO numeric date; Mon=1,Sun=7)
                    $distance_from_monday = $day_today - 1;
                    $distance_from_sunday = 7 - $day_today;
                    $start_date = date('Y-m-d', mktime(0,0,0,date('n'), date('j') - $distance_from_monday , date('Y')));
                    $end_date = date('Y-m-d', mktime(0,0,0,date('n'), date('j') + $distance_from_sunday , date('Y')));
                    $transformed_value = $start_date . ', ' . $end_date;
                    echo $transformed_value;
                    break;
            case '@THIS_MONTH@':
                    $transformed_value = date('Y-m');
                    break;
            case '@THIS_YEAR@':
                    $transformed_value = date('Y');
                    break;
        }

        return $transformed_value;
    }

    function preprocess($field, $value)
    {
        //Stub. This is meant to be overridden by subclasses if a reporter module
        //needs to do pre-processing on a submitted value before the query
        //(e.g., transforming a submitted string date to a UNIX timestamp transparently).
        //$field = name of field receiving the filter value (so that preprocessing can be selective per field)
        //$value = filter value submitted by user
        return $value;
    }


    //**********************************************************************************************************
    //FUNCTIONS BELOW: Experimental API for custom reporting purposes (bypassing the default interface provided)

    function set_show_fields($arr_fields)
    {
        $_SESSION[$this->session_array_name]['show_field'] = $arr_fields;
        return $this;
    }

    function set_sum_fields($arr_fields=array())
    {
        $_SESSION[$this->session_array_name]['sum_field'] = $arr_fields;
        return $this;
    }

    function set_count_fields($arr_fields=array())
    {
        $_SESSION[$this->session_array_name]['count_field'] = $arr_fields;
        return $this;
    }

    function set_operators($arr_operators=array())
    {
        $_SESSION[$this->session_array_name]['operator'] = $arr_operators;
        return $this;

    }

    function set_operands($arr_operands=array())
    {
        $_SESSION[$this->session_array_name]['text_field'] = $arr_operands;
        return $this;
    }

    function set_group_fields($arr_group_fields=null)
    {
        if($arr_group_fields == null)
        {
            $_SESSION[$this->session_array_name]['group_field1'] = '';
            $_SESSION[$this->session_array_name]['group_field2'] = '';
            $_SESSION[$this->session_array_name]['group_field3'] = '';
        }
        elseif(is_array($arr_group_fields) && count($arr_group_fields) >= 1)
        {
            foreach($arr_group_fields as $group_field => $field_name)
            {
                switch(strtolower($group_field))
                {
                    case 'group_field1':
                    case 'group_field2':
                    case 'group_field3':
                                        $_SESSION[$this->session_array_name][$group_field] = $field_name;
                                        break;
                    default:
                                        error_handler("Cannot set group field for the report.", " Invalid group_field specified.");
                }
            }
        }
        return $this;
    }

    function init()
    {
        $this->set_show_fields(array());
        $this->set_sum_fields();
        $this->set_count_fields();
        $this->set_operators();
        $this->set_operands();
        $this->set_group_fields();
        return $this;
    }

    function build()
    {
        $_GET['token'] = $_SESSION[$this->session_array_name]['token'] = generate_token();
        $reporter = $this;
        require 'components/reporter_result_query_constructor.php';
        require 'components/reporter_result_body.php';
        return $this;
    }

    function end()
    {
        unset($_SESSION[$this->session_array_name]);
        return $this;
    }
}
