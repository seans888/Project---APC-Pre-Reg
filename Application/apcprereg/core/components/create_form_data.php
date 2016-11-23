<?php
$arr_form_data=array();
if($$object_name != '' && is_object($$object_name))
{
    foreach($$object_name->fields as $field_name=>$metadata)
    {
        if(isset($_POST[$field_name]))
        {
            $arr_form_data[$field_name] = $_POST[$field_name];
        }

        if($metadata['control_type'] == 'date controls')
        {
            $var_year_element  = $metadata['date_elements'][0];
            $var_month_element = $metadata['date_elements'][1];
            $var_day_element   = $metadata['date_elements'][2];

            init_var($arr_form_data[$var_year_element]);
            init_var($arr_form_data[$var_month_element]);
            init_var($arr_form_data[$var_day_element]);

            if(isset($_POST[$var_year_element]))
            {
                $arr_form_data[$var_year_element] = $_POST[$var_year_element];
            }
            if(isset($_POST[$var_month_element]))
            {
                $arr_form_data[$var_month_element] = $_POST[$var_month_element];
            }
            if(isset($_POST[$var_day_element]))
            {
                $arr_form_data[$var_day_element] = $_POST[$var_day_element];
            }

            $arr_form_data[$field_name] = $arr_form_data[$var_year_element] . '-' . $arr_form_data[$var_month_element] . '-' . $arr_form_data[$var_day_element];

            if(strlen($arr_form_data[$field_name]) < 10)
            {
                $arr_form_data[$field_name] = '';
            }
        }
    }

    //determine if multifield data needs to be retrieved
    foreach($$object_name->relations as $rel_info)
    {
        if($rel_info['type'] == '1-M')
        {
            if(isset($arr_child[$rel_info['table']]))
            {
                $child = $arr_child[$rel_info['table']];
            }
            else
            {
                $child = cobalt_load_class($rel_info['table'] . '_html');
            }

            $num_var = 'num_' . $child->table_name;
            $count_var = $child->table_name . '_count';

            if(isset($_POST[$num_var]))
            {
                $arr_form_data[$num_var] = $_POST[$num_var];
            }

            if(isset($_POST[$count_var]))
            {
                $arr_form_data[$count_var] = $_POST[$count_var];
            }

            foreach($child->fields as $field_name=>$metadata)
            {
                $cf_name = 'cf_' . $child->table_name . '_' . $field_name;

                if(isset($_POST[$cf_name]))
                {
                    $arr_form_data[$cf_name] = $_POST[$cf_name];
                }

                if($metadata['control_type'] == 'date controls')
                {
                    $var_year_element  = 'cf_' . $child->table_name . '_' . $metadata['date_elements'][0];
                    $var_month_element = 'cf_' . $child->table_name . '_' . $metadata['date_elements'][1];
                    $var_day_element   = 'cf_' . $child->table_name . '_' . $metadata['date_elements'][2];

                    init_var($arr_form_data[$var_year_element]);
                    init_var($arr_form_data[$var_month_element]);
                    init_var($arr_form_data[$var_day_element]);

                    $num_dates=0;
                    if(isset($_POST[$var_year_element]))
                    {
                        $arr_form_data[$var_year_element] = $_POST[$var_year_element];
                        $num_dates = count($_POST[$var_year_element]);
                    }
                    if(isset($_POST[$var_month_element]))
                    {
                        $arr_form_data[$var_month_element] = $_POST[$var_month_element];
                    }
                    if(isset($_POST[$var_day_element]))
                    {
                        $arr_form_data[$var_day_element] = $_POST[$var_day_element];
                    }

                    for($a=0; $a<$num_dates; ++$a)
                    {
                        $arr_form_data[$cf_name][$a] = $arr_form_data[$var_year_element][$a] . '-' . $arr_form_data[$var_month_element][$a] . '-' . $arr_form_data[$var_day_element][$a];

                        if(strlen($arr_form_data[$cf_name][$a]) < 10)
                        {
                            $arr_form_data[$cf_name][$a] = '';
                        }
                    }
                }
            }
        }
    }
}
