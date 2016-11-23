<?php
    echo '<tr>';
    $checked='';
    if(is_array($show_field))
    {
        if(in_array($arr_fields[$i], $show_field)) $checked='checked';
    }
    else
    {
        //first run, everything is checked by default
        $checked='checked';
    }
    echo '<td align="center"><input type="checkbox" name="show_field[]" value="' . $arr_fields[$i] . '" ' . $checked . '></td>';

    echo '<td align="right">' . $arr_fields[$i] . '&nbsp;</td>';

    echo '<td>';
        echo "<select name='operator[]'>\r\n";
        echo '<option></option>';
        $num_options = count($operator_settings['items']);
        for($a=0;$a<$num_options;$a++)
        {
            $selected='';
            if(isset($operator[$i]))
            {
                if((string) $operator[$i] == (string) $operator_settings['values'][$a])
                {
                    $selected='selected';
                }
            }
            echo '<option value="'. cobalt_htmlentities($operator_settings['values'][$a]) . '" '
                    . $selected . '> ' . $operator_settings['items'][$a] . '</option>' . "\r\n";
        }

        echo "</select>\r\n";
    echo '</td>';

    echo '<td>';
    echo '<input type="text" name="text_field[]" size="30" value="' . $text_field[$i] . '">';
    echo '</td>';

    $checked='';
    if(is_array($sum_field))
    {
        if(in_array($arr_fields[$i], $sum_field)) $checked='checked';
    }
    echo '<td align="center"><input type="checkbox" name="sum_field[]" value="' . $arr_fields[$i] . '" ' . $checked . '></td>';

    $checked='';
    if(is_array($count_field))
    {
        if(in_array($arr_fields[$i], $count_field)) $checked='checked';
    }
    echo '<td align="center"><input type="checkbox" name="count_field[]" value="' . $arr_fields[$i] . '" ' . $checked . '></td>';
    $checked='';
    if($group_field1==$arr_fields[$i]) $checked='checked';
    echo '<td align="center"><input type="radio" name="group_field1" value="' . $arr_fields[$i] . '" ' . $checked . ' style="margin-top: 0px;"></td>';

    $checked='';
    if($group_field2==$arr_fields[$i]) $checked='checked';
    echo '<td align="center"><input type="radio" name="group_field2" value="' . $arr_fields[$i] . '" ' . $checked . ' style="margin-top: 0px;"></td>';

    $checked='';
    if($group_field3==$arr_fields[$i]) $checked='checked';
    echo '<td align="center"><input type="radio" name="group_field3" value="' . $arr_fields[$i] . '" ' . $checked . ' style="margin-top: 0px;"></td>';

    echo '</tr>';
