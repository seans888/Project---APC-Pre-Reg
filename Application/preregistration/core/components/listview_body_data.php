<?php
    if($result = $data_con->make_query()->result)
    {
        $a=1;
        $show_edit_link = check_link($edit_link);
        $show_delete_link = check_link($delete_link);
        while($row = $result->fetch_assoc())
        {
            $separator_index=0;
            if($a%2 == 0) $class = 'listRowEven';
            else $class = 'listRowOdd';
            $a++;
            extract($row);

            $pkey_string='';
            if(is_array($arr_pkey_name))
            {
                foreach($arr_pkey_name as $pkey_name)
                {
                    $enc_pkey = urlencode($$pkey_name);
                    make_list($pkey_string, $pkey_name . '=' . $enc_pkey, '&amp;', FALSE);
                }
            }
            else
            {
                cobalt_error_handler('Could not create primary key string.','arr_pkey_name is not an array. arr_pkey_name must be an array that contains at least one primary key field name.');
            }

            echo '<tr class="' . $class . '"><td class="oper_col" align="center">';

            if($view_page != '')
            {
                echo "<a href=\"$view_page?filter_field_used=$enc_filter_field&amp;filter_used=$enc_filter&amp;filter_sort_asc=$enc_filter_sort_asc&amp;filter_sort_desc=$enc_filter_sort_desc&amp;page_from=$current_page&amp;$pkey_string\"><img src=\"/" . BASE_DIRECTORY . "/images/" . $_SESSION['icon_set'] . "/view.png\" alt=\"View\" title=\"View\"></a>";
            }
            if($edit_page != '')
            {
                if($show_edit_link)
                {
                    echo "&nbsp;&nbsp;<a href=\"$edit_page?filter_field_used=$enc_filter_field&amp;filter_used=$enc_filter&amp;filter_sort_asc=$enc_filter_sort_asc&amp;filter_sort_desc=$enc_filter_sort_desc&amp;page_from=$current_page&amp;$pkey_string\"><img src=\"/" . BASE_DIRECTORY . "/images/" . $_SESSION['icon_set'] . "/edit.png\" alt=\"Edit\" title=\"Edit\"></a>";
                }
            }
            if($delete_page != '')
            {
                if($show_delete_link)
                {
                    echo "&nbsp;&nbsp;<a href=\"$delete_page?filter_field_used=$enc_filter_field&amp;filter_used=$enc_filter&amp;filter_sort_asc=$enc_filter_sort_asc&amp;filter_sort_desc=$enc_filter_sort_desc&amp;page_from=$current_page&amp;$pkey_string\"><img src=\"/" . BASE_DIRECTORY . "/images/" . $_SESSION['icon_set'] . "/delete.png\" alt=\"Delete\" title=\"Delete\"></a>";
                }
            }

            if(isset($operations_extra) && $operations_extra != '')
            {
                require 'components/' . $operations_extra;
            }

            echo '</td>';

            $column=1;
            foreach($arr_fields as $field)
            {
                if(isset($arr_alignment[$column]))
                {
                    $align = $arr_alignment[$column];
                }
                else
                {
                    $align='left';
                }
                echo '<td align="' . $align . '">';

                $format='';
                if(isset($arr_formatting[$column]))
                {
                    $format = $arr_formatting[$column];
                }
                ++$column;

                $column_text = '';
                if(is_array($field))
                {
                    $sep_cntr=0;
                    foreach($field as $subtext)
                    {
                        if($$subtext != '')
                        {
                            $column_text .= $$subtext;
                            if(isset($arr_subtext_separators[$separator_index][$sep_cntr]))
                            {
                                $column_text .= $arr_subtext_separators[$separator_index][$sep_cntr];
                            }
                            else
                            {
                                $column_text .= ' ';
                            }
                        }
                        ++$sep_cntr;
                    }
                    ++$separator_index;
                }
                else
                {
                    $column_text = $$field;
                }
                $column_text = cobalt_htmlentities($column_text);

                if($format == '')
                {
                    echo $column_text;
                }
                else
                {
                    if(substr($format,0, 13) == 'number_format')
                    {
                        $decimal_places = substr($format, 13);
                        echo number_format((double)$column_text, $decimal_places);
                    }
                    else
                    {
                        echo $format($column_text);
                    }
                }

                echo '</td>';
            }
            echo "</tr>\n";
        }
        $result->close();
    }
    else error_handler('Encountered an error while retrieving records.', $data_con->error);
    $data_con->close_db();
?>
</table>
