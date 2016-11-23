<?php
class base_html
{
    var $fields = array();
    var $exception = array();
    var $relations = array();
    var $subclasses =array();

    var $arr_fields = array();
    var $arr_field_labels = array();
    var $custom_header='';
    var $date_control_year_start='1950';
    var $date_control_year_end='2050';
    var $date_control_default_value = 'current';
    var $detail_view = FALSE;
    var $draw_table_tags = '';
    var $drop_down_has_blank = TRUE;
    var $form_name = 'cobalt_form';
    var $form_id = 'cobalt_form';
    var $lst_fields = '';
    var $lst_field_labels = '';
    var $mf_col_align = array(); //to specify the alignment of the columns in a multifield (left, right, center)
    var $tabindex = 0;

    var $upload_downloader = 'download_generic.php';
    var $upload_enable_link = TRUE;
    var $upload_token_length = 40;
    var $upload_show_file = TRUE;

    var $with_form = FALSE;
    var $year_set = '';

    var $bound_objects = array();

    function autofocus($field_name)
    {
        echo '<script>' . "\r\n";
        echo 'document.getElementById(\'' . $field_name . '\').focus();' . "\r\n";
        echo '</script>' . "\r\n";
    }

    function bind_child($object_name, $object)
    {
        $this->bound_objects[$object_name] = $object;
        return $this;
    }

    function display_error($message)
    {
        if($message!="")
        {
            echo '<div class="messageError">';
            echo '<table border="0" width="100%">';
            echo '<tr><td width="60" valign="top">';
            echo '<img src="/' . BASE_DIRECTORY . '/images/' . $_SESSION['icon_set'] . '/warn.png">';
            echo '</td>';
            echo '<td>';
            echo $message;
            echo '</td></tr></table></div>';
        }

        return $this;
    }

    function display_info($message)
    {
        if($message!="")
        {
            echo '<div class="messageInfo">';
            echo '<table border="0" width="100%">';
            echo '<tr><td width="60" valign="top">';
            echo '<img src="/' . BASE_DIRECTORY . '/images/' . $_SESSION['icon_set'] . '/info.png">';
            echo '</td>';
            echo '<td>';
            echo $message;
            echo '</td></tr></table></div>';
        }

        return $this;
    }

    function display_message($message)
    {
        if($message!="")
        {
            echo '<div class="messageSystem">';
            echo '<table border="0" width="100%">';
            echo '<tr><td width="60" valign="top">';
            echo '<img src="/' . BASE_DIRECTORY . '/images/' . $_SESSION['icon_set'] . '/ok.png">';
            echo '</td>';
            echo '<td>';
            echo $message;
            echo '</td></tr></table></div>';
        }

        return $this;
    }

    function display_tip($message)
    {
        if($message!="")
        {
            echo '<div class="messageTip">';
            echo '<table border="0" width="100%">';
            echo '<tr><td width="60" valign="top">';
            echo '<img src="/' . BASE_DIRECTORY . '/images/' . $_SESSION['icon_set'] . '/tip.png">';
            echo '</td>';
            echo '<td>';
            echo $message;
            echo '</td></tr></table></div>';
        }

        return $this;
    }

    function draw_container_div_start()
    {
        echo '<div class="container">' . "\r\n";
        echo '<fieldset class="container_invisible">' . "\r\n";

        return $this;
    }

    function draw_container_div_end()
    {
        echo '</fieldset>'. "\r\n";
        echo '</div>';
        return $this;
    }

    function draw_controls($type='', $title='')
    {
        if(trim($type)=='')
        {
            $type='add';
        }
        else
        {
            $type = strtolower($type);
        }

        if($title == '')
        {
            if($type == 'off')
            {
                $title = strtoupper($this->readable_name) . ' INFORMATION';
            }
            else
            {
                $title=strtoupper($type) . ' RECORD';
            }
        }

        $this->draw_container_div_start();
        $this->draw_fieldset_header($title);
        $this->draw_fieldset_body_start();

        //if no fieldsets defined, then default fieldset is all fields in DD, minus those in $this->exception
        if(empty($this->fieldsets))
        {
            foreach($this->fields as $field_name=>$field_struct)
            {
                if(!in_array($field_name,$this->exception))
                {
                    $this->fieldsets['default'][] = $field_name;
                }
            }
        }

        $arr_drawn_multifields = array();
        $first_field = '';
        foreach($this->fieldsets as $fieldset=>$fields)
        {
            if(substr($fieldset, 0, 6) == '__mf__')
            {
                //This is a multifield, not a regular field
                if(isset($this->bound_objects[$fields]))
                {
                    $subclass = $this->bound_objects[$fields];
                }
                else
                {
                    $subclass = cobalt_load_class($fields . '_html');
                }
                $subclass->detail_view = $this->detail_view;
                $subclass->tabindex = $this->tabindex;
                $subclass->draw_controls_mf();
                $this->tabindex = $subclass->tabindex;
                $arr_drawn_multifields[] = $fields;
            }
            else
            {
                if($fieldset != 'default' and !is_numeric($fieldset))
                {
                    echo '<fieldset  class="fieldset_group"><legend>' . $fieldset . '</legend>' . "\r\n";;
                }
                echo '<table class="input_form">' . "\r\n";

                foreach($fields as $field_name)
                {
                    if(!in_array($field_name,$this->exception))
                    {
                        $this->draw_field($field_name, TRUE);

                        if($first_field == '')
                        {
                            $first_field_type = $this->fields[$field_name]['control_type'];

                            if($first_field_type == 'none' OR $first_field_type == 'hidden' OR
                            strpos($this->fields[$field_name]['extra'], 'readonly') !== FALSE)
                            {
                                //ignore
                            }
                            else
                            {
                                if($first_field_type == 'date controls')
                                {
                                    $first_field = $this->fields[$field_name]['date_elements'][1]; //get month field
                                }
                                elseif($first_field_type == 'radio buttons')
                                {
                                    $first_field = $field_name . '[0]';
                                }
                                else
                                {
                                    $first_field = $field_name;
                                }
                            }
                        }
                    }
                }

                echo '</table>' . "\r\n";

                if($fieldset != 'default' and !is_numeric($fieldset))
                {
                    echo '</fieldset>' . "\r\n";;
                }
                echo '<br />';
            }
        }

        //determine if multifields need to be drawn
        foreach($this->relations as $rel_info)
        {
            if($rel_info['type'] == '1-M')
            {
                if(!in_array($rel_info['table'], $arr_drawn_multifields))
                {
                    if(isset($this->bound_objects[$rel_info['table']]))
                    {
                        $subclass = $this->bound_objects[$rel_info['table']];
                    }
                    else
                    {
                        $subclass = cobalt_load_class($rel_info['table'] . '_html');
                    }
                    $subclass->detail_view = $this->detail_view;
                    $subclass->tabindex = $this->tabindex;
                    $subclass->draw_controls_mf();
                    $this->tabindex = $subclass->tabindex;
                }
            }
        }

        $this->autofocus($first_field);
        $this->draw_fieldset_body_end();
        $this->draw_fieldset_footer_start();

        switch($type)
        {
            case 'off'      : break;
            case 'view'     : $this->draw_button('back'); break;
            case 'delete'   : $this->draw_submit_cancel(FALSE,0,'btn_delete','DELETE'); break;
            case 'add'      :
            case 'edit'     :
            default         : $this->draw_submit_cancel(FALSE); break;
        }

        $this->draw_fieldset_footer_end();
        $this->draw_container_div_end();

        return $this;
    }

    function draw_controls_mf($title='')
    {
        if(empty($this->field_from_parent))
        {
            foreach($this->relations as $rel_info)
            {
                if($rel_info['type'] == 'M-1')
                {
                    $this->field_from_parent = $rel_info['link_child'];
                }
            }
        }

        $arr_labels=array();
        $arr_controls=array();
        $arr_parameters=array();
        foreach($this->fields as $field_name=>$field_struct)
        {
            if(empty($this->field_from_parent) || $field_name != $this->field_from_parent)
            {
                $cf_name = 'cf_' . $this->table_name . '_' . $field_name;
                $size    = $field_struct['size'];
                $extra   = $field_struct['extra'];
                switch($field_struct['control_type'])
                {
                    case 'date controls'    :   $arr_labels[] = $field_struct['label'];
                                                $arr_controls[] = 'draw_date_field_mf';
                                                $arr_parameters[] = array('cf_' . $this->table_name . '_' . $field_struct['date_elements'][0],
                                                                          'cf_' . $this->table_name . '_' . $field_struct['date_elements'][1],
                                                                          'cf_' . $this->table_name . '_' . $field_struct['date_elements'][2],
                                                                          $this->year_set,
                                                                          $field_name);
                                                break;

                    case 'radio buttons'    :
                    case 'drop-down list'   :   $arr_labels[] = $field_struct['label'];
                                                if($field_struct['list_type'] == 'predefined')
                                                {
                                                    $arr_controls[] = 'draw_select_field_mf';
                                                }
                                                else
                                                {
                                                    $arr_controls[] = 'draw_select_field_from_query_mf';
                                                }
                                                $arr_parameters[] = array($field_struct['list_settings'], $cf_name, $extra);
                                                break;

                    case 'password'         :   $arr_labels[] = $field_struct['label'];
                                                $arr_controls[] = 'draw_text_field_mf';
                                                if($size > 0)
                                                {
                                                    $extra = ' size="' . $size . '" ' . $extra;
                                                }
                                                if($field_struct['length'] > 0) $extra .= ' maxlength="' . $field_struct['length'] . '" ';
                                                $arr_parameters[] = array($cf_name,'password',$extra);
                                                break;

                    case 'textbox'          :   $arr_labels[] = $field_struct['label'];
                                                $arr_controls[] = 'draw_text_field_mf';
                                                if($size > 0)
                                                {
                                                    $extra = ' size="' . $size . '" ' . $extra;
                                                }
                                                if($field_struct['length'] > 0) $extra .= ' maxlength="' . $field_struct['length'] . '" ';
                                                $arr_parameters[] = array($cf_name,'text',$extra);
                                                break;

                    case 'textarea'         :   $arr_labels[] = $field_struct['label'];
                                                $arr_controls[] = 'draw_text_field_mf';
                                                if($size != '')
                                                {
                                                    $arr_size = explode(';', $size);
                                                    if($arr_size[0] > 0)
                                                    {
                                                        $extra = ' cols="' . $arr_size[0] . '" ' . $extra;
                                                    }
                                                    if(isset($arr_size[1]) && $arr_size[1] > 0)
                                                    {
                                                        $extra = ' rows="' . $arr_size[1] . '" ' . $extra;
                                                    }
                                                }
                                                if($field_struct['length'] > 0) $extra .= ' maxlength="' . $field_struct['length'] . '" ';
                                                $arr_parameters[] = array($cf_name,'textarea',$extra);
                                                break;

                    case 'upload'           :   $arr_labels[] = $field_struct['label'];
                                                $arr_controls[] = 'draw_file_upload_mf';
                                                $arr_parameters[] = array($cf_name, $extra);
                                                break;

                    default                 :   break;

                }
            }
        }

        $multifield_settings = array('field_labels'    => $arr_labels,
                                     'field_controls'  => $arr_controls,
                                     'field_parameters'=> $arr_parameters);

        if(isset($this->mf_label))
        {
            $title = $this->mf_label;
        }
        else
        {
            $title = $this->readable_name;
        }
        $num_var = 'num_' . $this->table_name;
        $count_var = $this->table_name . '_count';
        global $$num_var, $$count_var;

        $this->draw_multifield_auto($title, $multifield_settings, $num_var, $count_var);
    }

    function draw_controls_multifield_end($button_set='submit')
    {
        echo '</fieldset>
              <fieldset class="bottom">';

        switch($button_set)
        {
            case 'view'   : $this->draw_button('back'); break;
            case 'delete' : $this->draw_submit_cancel(FALSE,2,'btn_delete','DELETE'); break;
            case 'submit' :
            default       : $this->draw_submit_cancel(); break;
        }

        echo '</fieldset>' . "\r\n" . '</fieldset>' . "\r\n" . '</div>' . "\r\n";

        return $this;
    }

    function draw_date_field($draw_table_tags=TRUE, $cobalt_field_label='Date', $cobalt_field_date_year='year', $cobalt_field_date_month='month', $cobalt_field_date_day='day', $year_set='', $detail_view=FALSE, $field_name='')
    {
        if($draw_table_tags) echo '<tr><td class="label">' . $cobalt_field_label . ':</td><td>' . "\r\n";

        if($year_set=='')
        {
            if($this->year_set == '')
            {
               for($a=$this->date_control_year_start; $a<$this->date_control_year_end; ++$a)
                {
                    make_list_array($year_set, $a);
                }
            }
            else
            {
                $year_set == $this->year_set;
            }
        }

        $array_year = array('items'  => $year_set,
                            'values' => $year_set);

        $array_month = array('items'  => array('January','February','March','April','May','June','July','August','September','October','November','December'),
                             'values' => array('01','02','03','04','05','06','07','08','09','10','11','12'));

        $array_day = array('items'  => array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16',
                                             '17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'),
                           'values' => array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16',
                                             '17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'));

        global $$cobalt_field_date_year, $$cobalt_field_date_month, $$cobalt_field_date_day;

        if($$cobalt_field_date_year==0 && $$cobalt_field_date_day==0 && $$cobalt_field_date_month==0 && $detail_view == FALSE)
        {
            $default_date = '';
            if(isset($this->fields[$field_name]['date_default']))
            {
                if($this->fields[$field_name]['date_default'] == 'default' || $this->fields[$field_name]['date_default'] == '')
                {
                    if($this->date_control_default_value == 'current')
                    {
                        $default_date = 'current';
                    }
                    elseif($this->date_control_default_value == 'blank')
                    {
                        $default_date = 'blank';
                    }
                }
                elseif($this->fields[$field_name]['date_default'] == 'current')
                {
                    $default_date = 'current';
                }
                elseif($this->fields[$field_name]['date_default'] == 'blank')
                {
                    $default_date = 'blank';
                }
                else
                {
                    $default_date = 'value';
                }
            }
            else
            {
                if($this->date_control_default_value == 'current')
                {
                    $default_date = 'current';
                }
                elseif($this->date_control_default_value == 'blank')
                {
                    $default_date = 'blank';
                }
            }
            switch($default_date)
            {
                case 'current': $date = date('m-j-Y');
                                $date = explode('-', $date);
                                $$cobalt_field_date_month = $date[0];
                                $$cobalt_field_date_day   = $date[1];
                                $$cobalt_field_date_year  = $date[2];
                                break;

                case 'blank':   $$cobalt_field_date_month = '';
                                $$cobalt_field_date_day   = '';
                                $$cobalt_field_date_year  = '';
                                break;

                case 'value':   $date = date('m-j-Y', strtotime($this->fields[$field_name]['date_default']));
                                $date = explode('-', $date);
                                $$cobalt_field_date_month = $date[0];
                                $$cobalt_field_date_day   = $date[1];
                                $$cobalt_field_date_year  = $date[2];
                                break;
            }
        }

        if($detail_view == FALSE)
        {
            $this->draw_select_field($array_month, '', $cobalt_field_date_month, FALSE);
            $this->draw_select_field($array_day, '', $cobalt_field_date_day, FALSE);
            $this->draw_select_field($array_year, '', $cobalt_field_date_year, FALSE);

            if(isset($this->fields[$field_name]['companion']))
            {
                echo $this->fields[$field_name]['companion'];
            }
        }
        else
        {
            echo '<p class="detail_view">' . $$cobalt_field_date_year . '-' . $$cobalt_field_date_month . '-' . $$cobalt_field_date_day . '</p>' . "\r\n";
        }

        if($draw_table_tags) echo '</td></tr>'. "\r\n";

        return $this;
    }

    function draw_date_field_mf($param, $cntr)
    {
        $detail_view = $this->detail_view;
        $cobalt_field_date_year   = '';
        $cobalt_field_date_month  = '';
        $cobalt_field_date_day    = '';
        $year_set    = '';

        if(isset($param[0])) $cobalt_field_date_year  = $param[0];
        if(isset($param[1])) $cobalt_field_date_month = $param[1];
        if(isset($param[2])) $cobalt_field_date_day   = $param[2];
        if(isset($param[3])) $year_set   = $param[3];
        if(isset($param[4])) $field_name = $param[4];

        if($cobalt_field_date_year=='')  $cobalt_field_date_year='year';
        if($cobalt_field_date_month=='') $cobalt_field_date_month='month';
        if($cobalt_field_date_day=='')   $cobalt_field_date_day='day';

        if($year_set=='')
        {
            if($this->year_set == '')
            {
               for($a=$this->date_control_year_start; $a<$this->date_control_year_end; ++$a)
                {
                    make_list_array($year_set, $a);
                }
            }
            else
            {
                $year_set == $this->year_set;
            }
        }

        $array_year = array('items'  => $year_set,
                            'values' => $year_set);

        $array_month = array('items'  => array('January','February','March','April','May','June','July','August','September','October','November','December'),
                             'values' => array('01','02','03','04','05','06','07','08','09','10','11','12'));

        $array_day = array('items'  => array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16',
                                             '17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'),
                           'values' => array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16',
                                             '17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'));

        global $$cobalt_field_date_year, $$cobalt_field_date_month, $$cobalt_field_date_day;
        init_var(${$cobalt_field_date_year}[$cntr]);
        init_var(${$cobalt_field_date_month}[$cntr]);
        init_var(${$cobalt_field_date_day}[$cntr]);

        if(${$cobalt_field_date_year}[$cntr]==0 &&
           ${$cobalt_field_date_month}[$cntr]==0 &&
           ${$cobalt_field_date_day}[$cntr]==0 &&
           $detail_view == FALSE)
        {
            $default_date = '';
            if(isset($this->fields[$field_name]['date_default']))
            {
                if($this->fields[$field_name]['date_default'] == 'default' || $this->fields[$field_name]['date_default'] == '')
                {
                    if($this->date_control_default_value == 'current')
                    {
                        $default_date = 'current';
                    }
                    elseif($this->date_control_default_value == 'blank')
                    {
                        $default_date = 'blank';
                    }
                }
                elseif($this->fields[$field_name]['date_default'] == 'current')
                {
                    $default_date = 'current';
                }
                elseif($this->fields[$field_name]['date_default'] == 'blank')
                {
                    $default_date = 'blank';
                }
                else
                {
                    $default_date = 'value';
                }
            }
            else
            {
                if($this->date_control_default_value == 'current')
                {
                    $default_date = 'current';
                }
                elseif($this->date_control_default_value == 'blank')
                {
                    $default_date = 'blank';
                }
            }
            switch($default_date)
            {
                case 'current': $date = date('m-j-Y');
                                $date = explode('-', $date);
                                ${$cobalt_field_date_month}[$cntr] = $date[0];
                                ${$cobalt_field_date_day}[$cntr]   = $date[1];
                                ${$cobalt_field_date_year}[$cntr]  = $date[2];
                                break;

                case 'blank':   ${$cobalt_field_date_month}[$cntr] = '';
                                ${$cobalt_field_date_day}[$cntr]   = '';
                                ${$cobalt_field_date_year}[$cntr]  = '';
                                break;

                case 'value':   $date = date('m-j-Y', strtotime($this->fields[$field_name]['date_default']));
                                $date = explode('-', $date);
                                ${$cobalt_field_date_month}[$cntr] = $date[0];
                                ${$cobalt_field_date_day}[$cntr]   = $date[1];
                                ${$cobalt_field_date_year}[$cntr]  = $date[2];
                                break;
            }
        }


        if($detail_view == FALSE)
        {
            $param = array($array_month, $cobalt_field_date_month);
            $this->draw_select_field_mf($param, $cntr);

            $param = array($array_day, $cobalt_field_date_day);
            $this->draw_select_field_mf($param, $cntr);

            $param = array($array_year, $cobalt_field_date_year);
            $this->draw_select_field_mf($param, $cntr);
        }
        else
        {
            echo ${$cobalt_field_date_year}[$cntr] . '-' . ${$cobalt_field_date_month}[$cntr] . '-' . ${$cobalt_field_date_day}[$cntr];
        }

        return $this;
    }

    function draw_field($field_name, $draw_table_tags=TRUE)
    {
        if($this->draw_table_tags === TRUE || $this->draw_table_tags === FALSE)
        {
            $draw_table_tags = $this->draw_table_tags;
        }

        if(isset($this->fields[$field_name]))
        {
            $field_struct = $this->fields[$field_name];
            $extra = $field_struct['extra'];
            $size = $field_struct['size'];

            switch($field_struct['control_type'])
            {

                case 'hidden'           :   $this->draw_hidden($field_name, $field_struct['value']);
                                            break;

                case 'date controls'    :   $this->draw_date_field($draw_table_tags, $field_struct['label'], $field_struct['date_elements'][0], $field_struct['date_elements'][1], $field_struct['date_elements'][2], $this->year_set, $this->detail_view, $field_name);
                                            break;

                case 'radio buttons'    :   if($this->detail_view==FALSE)
                                            {
                                                $this->draw_radio_buttons($field_struct['list_settings'], $field_struct['label'], $field_name, $draw_table_tags, $extra);
                                            }
                                            else
                                            {
                                                $this->draw_text_field($field_struct['label'], $field_name, TRUE, 'text', $draw_table_tags, $extra);
                                            }
                                            break;

                case 'drop-down list'   :   if($field_struct['list_type']=='predefined')
                                            {
                                                if($this->detail_view==FALSE)
                                                {
                                                    $this->draw_select_field($field_struct['list_settings'], $field_struct['label'], $field_name, $draw_table_tags, $extra);
                                                }
                                                else
                                                {
                                                    $this->draw_text_field($field_struct['label'], $field_name, TRUE, 'text', $draw_table_tags, $extra);
                                                }
                                            }
                                            elseif($field_struct['list_type']=='sql generated')
                                            {
                                                $this->draw_select_field_from_query($field_struct['list_settings']['query'], $field_struct['list_settings']['list_value'], $field_struct['list_settings']['list_items'], $field_struct['label'], $field_name, $this->detail_view, $draw_table_tags, $field_struct['list_settings']['list_separators'], $extra);
                                            }
                                            elseif($field_struct['list_type']=='relationship')
                                            {
                                                require_once 'subclasses/' . $this->subclasses['data_file'];
                                                $data_con = new $this->subclasses['data_class'];
                                                $data_con->create_query_from_relationship($field_name, $query, $list_value, $list_items);
                                                $this->draw_select_field_from_query($query, $list_value, $list_items, $field_struct['label'], $field_name, $this->detail_view, $draw_table_tags, $field_struct['list_settings']['list_separators'], $extra);
                                            }
                                            break;

                case 'password'         :   if($size > 0)
                                            {
                                                $extra = ' size="' . $size . '" ' . $extra;
                                            }
                                            if($field_struct['length'] > 0) $extra .= ' maxlength="' . $field_struct['length'] . '" ';
                                            $this->draw_text_field($field_struct['label'], $field_name, $this->detail_view, $field_struct['control_type'], $draw_table_tags, $extra);
                                            break;

                case 'textbox'          :   $field_struct['control_type'] = 'text';
                                            if($size > 0)
                                            {
                                                $extra = ' size="' . $size . '" ' . $extra;
                                            }
                                            if($field_struct['length'] > 0) $extra .= ' maxlength="' . $field_struct['length'] . '" ';
                                            $this->draw_text_field($field_struct['label'], $field_name, $this->detail_view, $field_struct['control_type'], $draw_table_tags, $extra);
                                            break;

                case 'textarea'         :   if($size != '')
                                            {
                                                $arr_size = explode(';', $size);
                                                if($arr_size[0] > 0)
                                                {
                                                    $extra = ' cols="' . $arr_size[0] . '" ' . $extra;
                                                }
                                                if(isset($arr_size[1]) && $arr_size[1] > 0)
                                                {
                                                    $extra = ' rows="' . $arr_size[1] . '" ' . $extra;
                                                }
                                            }
                                            if($field_struct['length'] > 0) $extra .= ' maxlength="' . $field_struct['length'] . '" ';
                                            $this->draw_text_field($field_struct['label'], $field_name, $this->detail_view, $field_struct['control_type'], $draw_table_tags, $extra);
                                            break;

                case 'upload'           :   $this->draw_file_upload($field_struct['label'], $field_name, $this->detail_view, $draw_table_tags);
                                            break;

                case 'none'             :   break;

                default                 :   error_handler('Invalid control type specified.', ' Field: ' . $field_name);
                                            break;
            }
        }
        else
        {
            error_handler("ERROR: Unable to draw field. Field '$field_name' does not exist in the current object.");
        }

        return $this;
    }

    function draw_field_label($field_name)
    {
        $field_struct = $this->fields[$field_name];
        echo $field_struct['label'];

        return $this;
    }

    function draw_fieldset_header($title)
    {
        echo '<fieldset class="top">' . $title . "\r\n";
        echo '</fieldset>' . "\r\n";

        return $this;
    }

    function draw_fieldset_body_start()
    {
        echo '<fieldset class="middle">' . "\r\n";

        return $this;
    }

    function draw_fieldset_body_end()
    {
        echo '</fieldset>' . "\r\n";

        return $this;
    }

    function draw_fieldset_footer_start()
    {
        echo '<fieldset class="bottom">' . "\r\n";

        return $this;
    }

    function draw_fieldset_footer_end()
    {
        echo '</fieldset>' . "\r\n";

        return $this;
    }

    function draw_file_upload($cobalt_text_field_label, $tf_control_name='', $detail_view=FALSE, $draw_table_tags=TRUE, $extra='')
    {
        if($tf_control_name=='') $tf_control_name=$cobalt_text_field_label;

        global $$tf_control_name;

        if($draw_table_tags)
        {
            echo '<tr><td class="label">' . $cobalt_text_field_label . ':</td><td>' . "\r\n";
        }

        $value = cobalt_htmlentities($$tf_control_name);

        //this removes the prepended token on the filename, resulting in the original filename as the displayed name
        $display_name = cobalt_htmlentities(substr($value, $this->upload_token_length));

        if($detail_view==FALSE)
        {
            echo '<div class="file_upload">';

            if($this->upload_show_file)
            {
                if($this->upload_enable_link)
                {
                    if($display_name != '')
                    {
                        echo '<a href="/' . BASE_DIRECTORY . '/' . $this->upload_downloader . '?filename=' . urlencode($value) . '">' . $display_name . '</a>&nbsp;';
                    }
                }
                else
                {
                    echo $display_name . '&nbsp;';
                }
            }

            ++$this->tabindex;
            echo '<input type="file" id="' . $tf_control_name . '" name="' . $tf_control_name . '" tabindex="' . $this->tabindex . '" ' . $extra . '>';
            echo '<input type="hidden" name="existing_' . $tf_control_name . '" value="' . $value . '">';
            echo '</div>';
        }
        else
        {
            if(trim($value)=='')
            {
                echo '<p class="detail_view">[No file uploaded]</p>';
            }
            else
            {
                echo '<p class="detail_view"><a href="/' . BASE_DIRECTORY . '/' . $this->upload_downloader . '?filename=' . urlencode($value) . '">' . $display_name . '</a></p>' . "\r\n";
            }
        }
        if($draw_table_tags) echo '</td></tr>' . "\r\n";
    }

    function draw_file_upload_mf($param, $cntr)
    {
        $detail_view       = $this->detail_view;
        $form_control_name = '';
        $extra             = '';

        if(isset($param[0])) $form_control_name = $param[0];
        if(isset($param[1])) $extra = $param[1];


        global $$form_control_name;

        init_var(${$form_control_name}[$cntr]);
        $value = cobalt_htmlentities(${$form_control_name}[$cntr]);

        //this removes the prepended token on the filename, resulting in the original filename as the displayed name
        $display_name = cobalt_htmlentities(substr($value, $this->upload_token_length));

        if($detail_view==FALSE)
        {
            echo '<div class="file_upload">';

            if($this->upload_show_file)
            {
                if($this->upload_enable_link)
                {
                    if($display_name != '')
                    {
                        echo '<a href="/' . BASE_DIRECTORY . '/' . $this->upload_downloader . '?filename=' . urlencode($value) . '">' . $display_name . '</a>&nbsp;';
                    }
                }
                else
                {
                    echo $display_name . '&nbsp;';
                }
            }

            ++$this->tabindex;
            echo '<input type="file" name="' . $form_control_name . '[' . $cntr . ']" tabindex="' . $this->tabindex . '" ' . $extra . '>';
            echo '<input type="hidden" name="existing_' . $form_control_name . '[' . $cntr . ']" value="' . $value . '">';
            echo '</div>';
        }
        else
        {
            if(trim($value)=='')
            {
                echo '[No file uploaded]';
            }
            else
            {
                echo '<a href="/' . BASE_DIRECTORY . '/' . $this->upload_downloader . '?filename=' . urlencode($value) . '">' . $display_name . '</a>' . "\r\n";
            }
        }
        echo "\r\n";
    }

    function draw_footer()
    {
        if($this->with_form == TRUE) echo '</form>' . "\r\n";
        if($_SESSION['footer']=='') $_SESSION['footer']='skins/default_footer.php';
        require $_SESSION['footer'];

        return $this;
    }

    function draw_footer_printable()
    {
        require 'skins/printview_footer.php';

        return $this;
    }

    function draw_header($page_title=null, $message=null, $message_type=null, $draw_form=TRUE, $upload=FALSE)
    {
        if(ENABLE_SIDEBAR)
        {
            if(isset($this->custom_header) && $this->custom_header)
            {
                require 'skins/' . $this->custom_header;
            }
            else
            {
                if($_SESSION['header']=='') $_SESSION['header']='skins/default_header.php';
                require $_SESSION['header'];
            }
        }
        else
        {
            require FULLPATH_BASE . '/header_alt.php';
        }

        //** SST Injection ***//
        if(isset($_SESSION['sst']) && $_SESSION['sst']['enabled'] == TRUE)
        {
            $injector = $_SESSION['sst']['tasks'][0]['pre'];
            require FULLPATH_BASE . 'sst/pre/' . $injector;
            echo $sst_script;
        }

        if($draw_form==TRUE)
        {
            $this->with_form = TRUE;

            if($upload)
            {
                echo '<form enctype="multipart/form-data" method="POST" action="' . basename($_SERVER['SCRIPT_NAME']) . '" name="' . $this->form_name . '" id="'. $this->form_id . '">' . "\r\n";
            }
            else
            {
                echo '<form method="POST" action="' . basename($_SERVER['SCRIPT_NAME']) . '" name="' . $this->form_name . '" id="'. $this->form_id . '">' . "\r\n";
            }

            //The following JS code makes sure forms are only submitted once
            echo '<script>
                  (function()
                  {
                      var firstSubmission = true;
                      ' . $this->form_name . '.onsubmit = function() {
                          if(firstSubmission)
                          {
                              firstSubmission = false;
                              show_loading_div();
                          }
                          else
                          {
                              return false;
                          }
                      }
                  })();
                  </script>' . "\r\n";

            enable_xsrf_guard();
        }

        if($page_title==null)
        {
            //no title
        }
        else
        {
            $this->draw_page_title($page_title);
        }

        if(strtoupper($message_type)=='SYSTEM') $this->display_message($message);
        elseif(strtoupper($message_type)=='INFO') $this->display_info($message);
        elseif(strtoupper($message_type)=='TIP') $this->display_tip($message);
        else $this->display_error($message);

        return $this;
    }

    function draw_header_printable()
    {
        require 'skins/printview_header.php';
        return $this;
    }

    function draw_hidden($tf_control_name='', $value='')
    {
        global $$tf_control_name;
        if($value == '')
        {
            $value = cobalt_htmlentities($$tf_control_name);
        }
        echo '<input type=hidden name="' . $tf_control_name . '" value="' . $value . '">' . "\r\n";
    }

    function draw_listview_referrer_info($filter_field, $filter, $page, $filter_sort_asc, $filter_sort_desc)
    {
        $filter = urldecode($filter);
        $filter_field = urldecode($filter_field);
        $filter_sort_asc = urldecode($filter_sort_asc);
        $filter_sort_desc = urldecode($filter_sort_desc);
        echo '<input type="hidden" name="filter_field_used" value="' . $filter_field . '">' . "\r\n";
        echo '<input type="hidden" name="filter_used" value="' . $filter . '">' . "\r\n";
        echo '<input type="hidden" name="filter_sort_asc" value="' . $filter_sort_asc . '">' . "\r\n";
        echo '<input type="hidden" name="filter_sort_desc" value="' . $filter_sort_desc . '">' . "\r\n";
        echo '<input type="hidden" name="page_from" value="' . $page . '">' . "\r\n";

        return $this;
    }

    function draw_page_title($title)
    {
        $pos = strpos($title, '%%');
        if($pos !== false)
        {
            $title = substr_replace($title, $this->readable_name, $pos, 2);
        }
        echo '<div class="pageHeaderDiv"><span class="pageHeaderText">'. $title .'</span></div>' . "\r\n";

        return $this;
    }

    function draw_radio_buttons($arrayItems, $cobalt_field_label, $form_control_name=null, $draw_table_tags=TRUE, $extra='')
    {
        if($form_control_name==null) $form_control_name=$cobalt_field_label;
        global $$form_control_name;
        global $$form_control_name;
        if(empty($$form_control_name) && $$form_control_name != '0')
        {
            if(isset($this->fields[$form_control_name]['value']))
            {
                $$form_control_name = $this->fields[$form_control_name]['value'];
            }
        }

        if($draw_table_tags)
        {
            echo '<tr><td class="label">' . $cobalt_field_label . ':</td><td>' . "\r\n";
        }

        ++$this->tabindex;
        $numItems = count($arrayItems['items']);
        for($a=0;$a<$numItems;++$a)
        {
            $mark="";
            $ending='';
            if($arrayItems['per_line']==TRUE) $ending="<br>";
            if((string) $arrayItems['values'][$a] == (string) $$form_control_name) $mark="checked";
            echo '<input type="radio" id="' . $form_control_name . '[' . $a . ']" name="' . $form_control_name . '" tabindex="' . $this->tabindex . '" value="' . cobalt_htmlentities($arrayItems['values'][$a]) . '" ' . $mark .' ' . $extra . '><label for="' . $form_control_name . '[' . $a . ']">' . cobalt_htmlentities($arrayItems['items'][$a]) . '</label>' . $ending . "\r\n";
        }

        if(isset($this->fields[$form_control_name]['companion']))
        {
            echo $this->fields[$form_control_name]['companion'];
        }

        if($draw_table_tags) echo '</td>' . "\r\n";

        return $this;
    }

    function draw_select_field($options, $cobalt_field_label, $form_control_name='', $draw_table_tags=TRUE, $extra='')
    {
        if($form_control_name=='') $form_control_name=$cobalt_field_label;
        global $$form_control_name;
        if(empty($$form_control_name) && $$form_control_name != '0')
        {
            if(isset($this->fields[$form_control_name]['value']))
            {
                $$form_control_name = $this->fields[$form_control_name]['value'];
            }
        }

        if($draw_table_tags)
        {
            echo '<tr><td class="label">' . $cobalt_field_label . ':</td><td>' . "\r\n";
        }

        ++$this->tabindex;
        echo "<select id=\"$form_control_name\" name=\"$form_control_name\" tabindex=\"$this->tabindex\" $extra>\r\n";

        if(isset($this->fields[$form_control_name]['drop_down_has_blank']))
        {
            if($this->fields[$form_control_name]['drop_down_has_blank'])
            {
                echo "<option></option>\r\n";
            }
        }
        elseif($this->drop_down_has_blank)
        {
                echo "<option></option>\r\n";
        }

        $num_options = count($options['items']);
        for($a=0;$a<$num_options;++$a)
        {
            $selected='';
            if((string) $$form_control_name == (string) $options['values'][$a]) $selected='selected';
            echo '<option value="'. cobalt_htmlentities($options['values'][$a]) . '" '
                    . $selected . '> ' . cobalt_htmlentities($options['items'][$a]) . '</option>' . "\r\n";
        }

        echo "</select>\r\n";

        if(isset($this->fields[$form_control_name]['companion']))
        {
            echo $this->fields[$form_control_name]['companion'];
        }


        if($draw_table_tags) echo '</td></tr>' . "\r\n";

        return $this;
    }

    function draw_select_field_mf($param, $cntr)
    {
        $detail_view       = $this->detail_view;
        $options           = '';
        $form_control_name = '';
        $extra             = '';

        if(isset($param[0])) $options = $param[0];
        if(isset($param[1])) $form_control_name = $param[1];
        if(isset($param[2])) $extra = $param[2];

        global $$form_control_name;

        if($detail_view != TRUE)
        {
            ++$this->tabindex;
            echo "<select name='$form_control_name" . "[$cntr]' tabindex='$this->tabindex' $extra> \r\n";

            if(isset($this->fields[$form_control_name]['drop_down_has_blank']))
            {
                if($this->fields[$form_control_name]['drop_down_has_blank'])
                {
                    echo "<option></option>\r\n";
                }
            }
            elseif($this->drop_down_has_blank)
            {
                    echo "<option></option>\r\n";
            }
        }

        $num_options = count($options['items']);
        for($a=0;$a<$num_options;++$a)
        {
            $selected='';
            if(isset(${$form_control_name}[$cntr]) && (string) ${$form_control_name}[$cntr] == (string) $options['values'][$a]) $selected='selected';

            if($detail_view != TRUE)
            {
                echo '<option value="'. cobalt_htmlentities($options['values'][$a]) . '" '
                        . $selected . '> ' . cobalt_htmlentities($options['items'][$a]) . '</option>' . "\r\n";
            }
            else
            {
                if($selected == 'selected')
                {
                    echo nl2br($options['items'][$a]);
                }
            }
        }

        echo "</select>\r\n";

        return $this;
    }

    function draw_select_field_from_query($query, $list_value, $list_items, $cobalt_field_label, $form_control_name='', $detail_view=FALSE, $draw_table_tags=TRUE, $list_separators='', $extra='')
    {
        if($form_control_name=='') $form_control_name=$cobalt_field_label;
        global $$form_control_name;
        if(empty($$form_control_name) && $$form_control_name != '0')
        {
            if(isset($this->fields[$form_control_name]['value']))
            {
                $$form_control_name = $this->fields[$form_control_name]['value'];
            }
        }

        if($draw_table_tags)
        {
            echo '<tr><td class="label">' . $cobalt_field_label . ':</td><td>' . "\r\n";
        }

        $num_display=count($list_items);

        if($detail_view != TRUE)
        {
            ++$this->tabindex;
            echo "<select id='$form_control_name' name='$form_control_name' tabindex='$this->tabindex' $extra>\r\n";

            if(isset($this->fields[$form_control_name]['drop_down_has_blank']))
            {
                if($this->fields[$form_control_name]['drop_down_has_blank'])
                {
                    echo "<option></option>\r\n";
                }
            }
            elseif($this->drop_down_has_blank)
            {
                    echo "<option></option>\r\n";
            }
        }

        $data_con = new data_abstraction;
        $data_con->query = $query;
        if($result = $data_con->execute_query('',LOG_SELECT_QUERIES)->result)
        {
            while($data = $result->fetch_assoc())
            {
                extract($data);

                $selected = '';
                if((string) $$form_control_name == (string) $$list_value) $selected='selected';

                $dropdown_item_entry='';
                for($a=0; $a<$num_display; ++$a)
                {
                    if(${$list_items[$a]} != '')
                    {
                        if(!isset($list_separators[$a]) || $list_separators[$a]=='') $list_separators[$a] = ' ';
                        $dropdown_item_entry .= ${$list_items[$a]} . $list_separators[$a];
                    }
                }

                $dropdown_item_entry = cobalt_htmlentities($dropdown_item_entry);
                if($detail_view != TRUE)
                {
                    echo '<option value="' . cobalt_htmlentities($$list_value) . '" ' . $selected . '>';
                    echo "$dropdown_item_entry </option>\r\n";
                }
                else
                {
                    if(trim($dropdown_item_entry)=='')
                    {
                        $dropdown_item_entry = '&nbsp;';
                    }
                    if($selected=='selected') echo '<p class="detail_view">' . nl2br($dropdown_item_entry) . '</p>' . "\r\n";
                }
            }
        }

        if($detail_view != TRUE)
        {
            echo "</select>\r\n";

            if(isset($this->fields[$form_control_name]['companion']))
            {
                echo $this->fields[$form_control_name]['companion'];
            }
        }

        if($draw_table_tags) echo '</td></tr>' . "\r\n";

        return $this;
    }

    function draw_select_field_from_query_mf($param, $cntr)
    {
        $detail_view       = $this->detail_view;
        $query             = '';
        $list_value        = '';
        $list_items        = '';
        $form_control_name = '';
        $extra             = '';
        $list_separators   = '';

        //$query, $list_value, $list_items, $form_control_name='', $extra=''
/*
        if(isset($param[0])) $query = $param[0];
        if(isset($param[1])) $list_value = $param[1];
        if(isset($param[2])) $list_items = $param[2];
        if(isset($param[3])) $form_control_name = $param[3];
        if(isset($param[4])) $extra = $param[4];
        if(isset($param[5])) $list_separators = $param[5];
*/
        if(isset($param[0]))
        {
            $query = $param[0]['query'];
            $list_value =  $param[0]['list_value'];
            $list_items = $param[0]['list_items'];
            $list_separators = $param[0]['list_separators'];
        }
        if(isset($param[1]))
        {
            $form_control_name = $param[1];
        }
        if(isset($param[2]))
        {
            $extra = $param[2];
        }


        //The query may have the "{[ ]}" marking, which means get the current value (using cntr) of the variable which is named
        //inside the {[ ]}
        //For example, a query with "WHERE myfield = '{[status]}'" in it means the actual query to be executed should be:
        //  WHERE myfield = '$status[$cntr]'
        while($start_replace = strpos($query, '{[', 0))
        {
            $end_replace = strpos($query, ']}', $start_replace);
            if($end_replace > $start_replace)
            {
                $query_part1 = substr($query, 0, $start_replace);
                $query_part2 = substr($query, $end_replace+2, strlen($query));
                $var_length = $end_replace - ($start_replace+2);
                $variable = substr($query, $start_replace+2, $var_length);
                global $$variable;
                $query = $query_part1 . ${$variable}[$cntr] . $query_part2;
            }
        }

        global $$form_control_name;
        init_var(${$form_control_name}[$cntr]);

        $num_display=count($list_items);

        if($detail_view != TRUE)
        {
            ++$this->tabindex;
            echo "<select name='$form_control_name" . "[$cntr]' tabindex='$this->tabindex' $extra>\r\n";

            if(isset($this->fields[$form_control_name]['drop_down_has_blank']))
            {
                if($this->fields[$form_control_name]['drop_down_has_blank'])
                {
                    echo "<option></option>\r\n";
                }
            }
            elseif($this->drop_down_has_blank)
            {
                    echo "<option></option>\r\n";
            }
        }

        $data_con = new data_abstraction;
        $data_con->query = $query;
        if($result = $data_con->execute_query('',LOG_SELECT_QUERIES)->result)
        {
            while($data = $result->fetch_assoc())
            {
                extract($data);

                $selected = '';
                if((string) ${$form_control_name}[$cntr] == (string) $$list_value) $selected='selected';

                $dropdown_item_entry='';
                for($a=0; $a<$num_display; ++$a)
                {
                    if(${$list_items[$a]} != '')
                    {
                        init_var($list_separators[$a]);
                        if($list_separators[$a]=='') $list_separators[$a] = ' ';
                        $dropdown_item_entry .= ${$list_items[$a]} . $list_separators[$a];
                    }
                }

                $dropdown_item_entry = cobalt_htmlentities($dropdown_item_entry);
                if($detail_view != TRUE)
                {
                    echo '<option value="' . cobalt_htmlentities($$list_value) . '" ' . $selected . '>' . $dropdown_item_entry . '</option>' . "\r\n";
                }
                else
                {
                    if(trim($dropdown_item_entry)=='')
                    {
                        $dropdown_item_entry = '&nbsp;';
                    }
                    if($selected=='selected') echo nl2br($dropdown_item_entry) . "\r\n";
                }
            }
        }
        else die($data_con->error);

        if($detail_view != TRUE) echo "</select>\r\n";

        return $this;
    }

    function draw_text_field($cobalt_field_label, $tf_control_name='', $detail_view=FALSE, $control_type='', $draw_table_tags=TRUE, $extra='')
    {
        if($tf_control_name=='') $tf_control_name=$cobalt_field_label;
        if($control_type=='') $control_type='text';

        global $$tf_control_name;
        if(empty($$tf_control_name) && $$tf_control_name != '0')
        {
            if(isset($this->fields[$tf_control_name]['value']))
            {
                $$tf_control_name = $this->fields[$tf_control_name]['value'];
            }
        }

        $control_type = strtolower($control_type);

        if($draw_table_tags)
        {
            echo '<tr><td class="label">' . $cobalt_field_label . ':</td><td>' . "\r\n";
        }

        if($detail_view == TRUE &&
            isset($this->fields[$tf_control_name]['allow_html_tags']) &&
            $this->fields[$tf_control_name]['allow_html_tags'] == TRUE)
        {
            $value = $$tf_control_name;
        }
        else
        {
            $value = cobalt_htmlentities($$tf_control_name);
        }

        if($detail_view==FALSE)
        {
            ++$this->tabindex;
            $tabindex = $this->tabindex;

            if($control_type=='textarea') echo "<textarea id='$tf_control_name' name='$tf_control_name' tabindex='$tabindex' $extra>" . $value . "</textarea>\r\n";
            else echo "<input type='$control_type' id='$tf_control_name' name='$tf_control_name' tabindex='$tabindex' value='" . $value . "' $extra>\r\n";

            if(isset($this->fields[$tf_control_name]['companion']))
            {
                echo $this->fields[$tf_control_name]['companion'];
            }
        }
        else
        {
            if(trim($value)=='')
            {
                $value = '&nbsp;';
            }
            echo '<p class="detail_view">' . nl2br($value) . '</p>' . "\r\n";
        }

        if($draw_table_tags) echo '</td></tr>' . "\r\n";

        return $this;
    }

    function draw_text_field_mf($param, $cntr)
    {
        $detail_view       = $this->detail_view;
        $form_control_name = '';
        $control_type      = '';
        $extra             = '';
        $html_flag         = '';

        if(isset($param[0])) $form_control_name = $param[0];
        if(isset($param[1])) $control_type = $param[1];
        if(isset($param[2])) $extra = $param[2];
        if(isset($param[3])) $html_flag = $param[3];

        if($control_type=='') $control_type='text';

        global $$form_control_name;

        $control_type = strtolower($control_type);
        init_var(${$form_control_name}[$cntr]);

        if($html_flag == 'ALLOW' && $detail_view == TRUE)
        {
            $value = ${$form_control_name}[$cntr];
        }
        else
        {
            $value = cobalt_htmlentities(${$form_control_name}[$cntr]);
        }

        if($detail_view==FALSE)
        {
            ++$this->tabindex;
            $tabindex = $this->tabindex;

            if($control_type=='textarea')
            {
                if($extra=='')
                {
                    $extra = 'rows="5" cols="30"';
                }
                echo "<textarea name='$form_control_name" . "[$cntr]' tabindex='$tabindex' $extra>" . $value . "</textarea>\r\n";
            }
            else
            {
                echo "<input type='$control_type' name='$form_control_name" ."[$cntr]' tabindex='$tabindex' value='" . $value . "' $extra>\r\n";
            }
        }
        else
        {
            if(trim($value)=='')
            {
                $value = '&nbsp;';
            }
            echo nl2br($value) . "\r\n";
        }

        return $this;
    }

    function draw_multifield_auto($label, $arr_multifield, $num_particulars_var=null, $particulars_count_var=null, $particular_button_var=null)
    {
        if($num_particulars_var==null) $num_particulars_var='num_particulars';
        if($particulars_count_var==null) $particulars_count_var='particulars_count';
        if($particular_button_var==null) $particular_button_var='particular_button';

        global $$num_particulars_var, $$particulars_count_var;

        //Get minimum according to DD
        $minimum=0;
        foreach($this->relations as $rel_info)
        {
            if($rel_info['type'] == 'M-1')
            {
                $minimum= $rel_info['minimum'];
            }
        }

        echo '<fieldset class="fieldset_group">' . "\r\n";
        if(empty($label))
        {
            //no title, no legend
        }
        else
        {
            echo '<legend>' . $label . '</legend>';
        }

        //if($$num_particulars_var>0) ;
        //else $$num_particulars_var=$$particulars_count_var;
        if(is_numeric($$num_particulars_var))
        {
            $$particulars_count_var = $$num_particulars_var;
        }
        else
        {
            $$num_particulars_var = $$particulars_count_var;
        }

        if($$num_particulars_var<$minimum)
        {
            $$num_particulars_var   = $minimum;
            $$particulars_count_var = $minimum;
        }

        if($this->detail_view==FALSE)
        {
            //if($$num_particulars_var!=0) echo "<input type=hidden name='" . $particulars_count_var . "' value=". $$num_particulars_var . ">\r\n";
            //else  echo "<input type=hidden name='" . $particulars_count_var . "' value=1>\r\n";
            echo "<input type=\"hidden\" name=\"" . $particulars_count_var . "\" value=\"". $$num_particulars_var . "\">\r\n";
        }

        echo '<table class="input_form"><tr><td>&nbsp;</td>' . "\r\n";

        //Count how many fields need to be drawn,
        //then loop the <td></td> tags with the corresponding labels.
        $numTDPairs = count($arr_multifield['field_labels']);
        for($a=0;$a<$numTDPairs;++$a)
        {
            echo '<td><p class="multifield_detail_view_label">' . $arr_multifield['field_labels'][$a] . '</p></td>' . "\r\n";
        }
        echo '</tr>' . "\r\n";

        for($a=0;$a<$$num_particulars_var;++$a)
        {
            echo '<tr><td class="label">&nbsp;' . ($a + 1) . '&nbsp;</td>' . "\r\n";

            for($b=0;$b<$numTDPairs;++$b)
            {
                init_var($this->mf_col_align[$b]);
                if($this->mf_col_align[$b] == '') $this->mf_col_align[$b]=='left';
                echo '<td align="' . $this->mf_col_align[$b] . '">';

                if($this->detail_view)
                {
                    echo '<p class="multifield_detail_view">';
                }
                else
                {
                    echo '<p>';
                }

                $this->{$arr_multifield['field_controls'][$b]}($arr_multifield['field_parameters'][$b], $a);
                echo '</p></td>' . "\r\n";

            }

            echo '</tr>' . "\r\n";
        }

        if($$num_particulars_var < 1)
        {
            $colspan = $numTDPairs + 1;
            if(isset($this->mf_label))
            {
                $label = $this->mf_label;
            }
            else
            {
                $label = $this->readable_name;
            }

            echo '<tr><td colspan="' . $colspan . '"><p class="multifield_detail_view">';

            if($this->detail_view)
            {
                echo '[No Data]';
            }
            else
            {
                echo '[Items for ' . $label . ' is set to zero. No data will be submitted for this section]';
            }
            echo '</p></td></tr>';
        }

        echo "</table>\r\n";

        if($this->detail_view==FALSE)
        {
            echo '<br> Change # of items to:';
            ++$this->tabindex;
            echo '<input type="text" size="2" maxlength="2" name="' . $num_particulars_var . '" tabindex="' . $this->tabindex . '">';
            ++$this->tabindex;
            echo '<input type="submit" name="' . $particular_button_var . '" tabindex="' . $this->tabindex . '" value="GO">' . "\r\n";
        }

        echo '</fieldset>' . "\r\n";
        echo '<br>' . "\r\n";

        return $this;
    }


    function draw_button($type=null, $button_class=null, $button_name=null, $button_label=null, $draw_table_tags=FALSE, $colspan="2", $extra='')
    {
        if($draw_table_tags==TRUE) echo "<tr><td align=center colspan=$colspan>\r\n";
        $button_type='submit'; //This is the default. This will only change if $type is set to "BUTTON"

        $type = strtolower($type);

        switch($type)
        {
            case "cancel":
                $button_class ='cancel';
                $button_name  ="btn_cancel";
                $button_label ="CANCEL";
                break;
            case "back":
                $button_name  ="btn_back";
                $button_label ="BACK";
                break;
            case "delete":
                $button_name  ="btn_delete";
                $button_label ="DELETE";
                break;
            case "go":
                $button_name  ="btn_go";
                $button_label ="GO";
                break;
            case "special":
                break;
            case "button":
                $button_type  ='button';
                break;
            default:
                $button_class ='submit';
                $button_name  ="btn_submit";
                $button_label ="SUBMIT";
        }

        ++$this->tabindex;
        echo '<input type="' . $button_type . '"
                     id="' . $button_name . '"
                     name="' . $button_name . '"
                     tabindex="' . $this->tabindex. '"
                     value="' . $button_label . '"
                     class="' . $button_class . '"
                            ' . $extra . '>' . "&nbsp;";

        if($draw_table_tags==TRUE) echo '</td></tr>' . "\r\n";

        return $this;
    }

    function draw_submit_cancel($draw_table_tags=FALSE, $colspan="2", $submit_name="btn_submit", $submit_label="SUBMIT", $submit_class="submit", $cancel_name="btn_cancel", $cancel_label="CANCEL", $cancel_class="cancel")
    {
        if($draw_table_tags==TRUE) echo "<tr><td align=center colspan=$colspan>\r\n";

        ++$this->tabindex;
        echo '<input type="submit"
                     id="' . $submit_name . '"
                     name="' . $submit_name . '"
                     tabindex="' . $this->tabindex. '"
                     value="' . $submit_label . '"
                     class="' . $submit_class. '">' . "&nbsp;" . "\r\n";

        ++$this->tabindex;
        echo '<input type="submit"
                     id="' . $cancel_name . '"
                     name="' . $cancel_name . '"
                     tabindex="' . $this->tabindex. '"
                     value="' . $cancel_label . '"
                     class="' . $cancel_class. '">' . "\r\n";

        if($draw_table_tags==TRUE) echo '</td></tr>' . "\r\n";

        return $this;
    }

    function get_listview_fields()
    {
        $table_name = $this->table_name;

        $this->arr_subtext_separators = array();
        foreach($this->fields as $field_name=>$field_struct)
        {
            if($field_struct['in_listview'] == TRUE)
            {
                $make_filter_label=TRUE;
                if($field_struct['attribute']=='foreign key' || $field_struct['attribute']=='primary&foreign key')
                {
                    $has_no_defined_relationship = TRUE;
                    //find the relationship information for this field; only 1-1
                    foreach($this->relations as $key=>$rel)
                    {
                        if(strip_back_quote_smart($rel['link_child']) == $field_name && $rel['type']=='1-1')
                        {
                            $has_no_defined_relationship = FALSE;
                            require_once 'subclasses/' . strip_back_quote_smart($rel['table']) . '.php';
                            $class = strip_back_quote_smart($rel['table']);
                            $data_con = new $class;
                            $database = $data_con->db_use;

                            $temp_field_name = '';
                            $filter_field_name = '';
                            $arr_subtexts = array();
                            $arr_subtext_labels = array();
                            $subtext_cntr=0;
                            foreach($rel['link_subtext'] as $subtext)
                            {
                                if($temp_field_name != '') $temp_field_name .= ', ';
                                if($filter_field_name != '') $filter_field_name .= ', ';

                                if(isset($rel['alias']) && $rel['alias'] != '')
                                {
                                    $temp_field_name .= back_quote_smart($database) . '.' . back_quote_smart($rel['alias']) . '.' . back_quote_smart($subtext) . ' AS ' . back_quote_smart($database . '_' . $rel['alias'] . '_' . $subtext);
                                    $filter_field_name .= back_quote_smart($database) . '.' . back_quote_smart($rel['alias']) . '.' . back_quote_smart($subtext);
                                    $arr_subtexts[] = $database . '_' . $rel['alias'] . '_' . $subtext;
                                }
                                else
                                {
                                    $temp_field_name .= back_quote_smart($database) . '.' . back_quote_smart($rel['table']) . '.' . back_quote_smart($subtext) . ' AS ' . back_quote_smart($database . '_' . $rel['table'] . '_' . $subtext);
                                    $filter_field_name .= back_quote_smart($database) . '.' . back_quote_smart($rel['table']) . '.' . back_quote_smart($subtext);
                                    $arr_subtexts[] = $database . '_' . $rel['table'] . '_' . $subtext;
                                }
                                $arr_subtext_labels[] = $data_con->fields[$subtext]['label'];
                                ++$subtext_cntr;
                            }

                            if($subtext_cntr>1)
                            {
                                foreach($arr_subtext_labels as $new_filter_label)
                                {
                                    make_list_array($this->arr_filter_field_labels, $new_filter_label);
                                }
                                $make_filter_label=FALSE;
                            }

                            if(isset($this->fields[$field_name]['list_settings']['list_separators']))
                            {
                                $this->arr_subtext_separators[] = $this->fields[$field_name]['list_settings']['list_separators'];
                            }

                            $related_field_name = $temp_field_name;
                            make_list($this->lst_fields, back_quote_smart($related_field_name), ',', FALSE);
                            make_list($this->lst_filter_fields, back_quote_smart($filter_field_name), ',', FALSE);
                            $this->arr_fields[] = $arr_subtexts;

                            if($field_struct['attribute']=='primary&foreign key')
                            {
                                //if foreign key is also a primary key, we also need the original field aside from the subtext field
                                $orig_field_name = back_quote_smart($table_name) . '.' . back_quote_smart($field_name);
                                make_list($this->lst_fields, back_quote_smart($orig_field_name), ',', FALSE);
                            }
                        }
                    }

                    if($has_no_defined_relationship)
                    {
                        error_handler('Cannot render ListView, incorrect configuration.',
                                      ' Missing relationship information for foreign-key column "' . $field_name . '".');
                    }
                }
                else
                {
                    make_list($this->lst_fields, back_quote_smart($table_name). '.' .  back_quote_smart($field_name), ',', FALSE);
                    make_list($this->lst_filter_fields, back_quote_smart($table_name). '.' .  back_quote_smart($field_name), ',', FALSE);
                    make_list_array($this->arr_fields, $field_name);
                }

                make_list($this->lst_field_labels, $field_struct['label'], ',');
                make_list_array($this->arr_field_labels, $field_struct['label']);

                if($make_filter_label)
                {
                    make_list_array($this->arr_filter_field_labels, $field_struct['label']);
                }
            }
            elseif($field_struct['attribute'] == 'primary key')
            {
                make_list($this->lst_fields, back_quote_smart($table_name) . '.' .  back_quote_smart($field_name), ',', FALSE);
            }
        }

        return $this;
    }
}
