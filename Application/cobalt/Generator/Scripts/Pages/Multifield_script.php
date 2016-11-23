<?php

function multifield_setup($setup_type, $Field_Name, $Field_ID)
{
    $d = connect_DB();
    $setup_content='';
    if($setup_type == 'Predefined List')
    {
        $stmt = $d->prepare("SELECT List_ID FROM table_fields_list WHERE Field_ID = :f_id");
        $stmt->bindValue(':f_id', $Field_ID);
        if($result = $stmt->execute())
        {
            $arr_list = array();
            while($data = $result->fetchArray(SQLITE3_NUM))
            {
                $create_query = FALSE;
                $arr_list[] = $data[0];
            }
        }
        $stmt->close();
        if(is_array($arr_list)) //We really only need ths here to retain the pre-refactoring indentation so we don't have to touch all the heredocs
        {
            foreach($arr_list as $List_ID)
            {
                //Now, get the items from the assigned list, and assign them to a string variable formatted
                //as an array definition which will be written to the resulting module.
                //Format:
                //$arrayItems = array('PerLine' => TRUE,
                //                    'Items' => array('Yes','No'),
                //                    'Values'=> array('Yes','No'));
                //Note that here, Items and Values arrays will contain pretty much the same thing - this can be modified later
                //by the user so that the items displayed will not necessarily be the same as the value used.
                //Also, the PerLine index is always TRUE right now since SCV2 doesn't yet allow users to specify it
                //during field definitions (not yet supported by database and interface, a minor oversight we can correct
                //easily later on.
                $options = ''; //variable whose contents will be printed in the generated module (containing the $arrayItems var in the example)
                $options_items = ''; //will correspond to the 'Items' index in the options array.
                $options_values = '';//will correspond to the 'Values' index in the options array.
                $stmt = $d->prepare("SELECT List_Item FROM table_fields_predefined_list_items WHERE List_ID=:l_id");
                $stmt->bindValue(':l_id', $List_ID);
                if($result = $stmt->execute())
                {
                    while($data = $result->fetchArray())
                    {
                        extract($data);
                        $List_Item = str_replace("'", "\'", $List_Item); //single quotes need escaping
                        $options_items .= "'$List_Item',";
                        $options_values .= "'$List_Item',";
                    }
                }
                $stmt->close();

                $options_items = substr($options_items,0,strlen($options_items)-1); //We just removed the last comma.
                $options_values = substr($options_values,0,strlen($options_values)-1); //We just removed the last comma.

                //$arrayItems should have a unique name, so prepend the field name to this variable's name.
                $arrayItems = $Field_Name . '_array_options';

                $options =<<<EOD

\$$arrayItems = array('items' => array($options_items),
                            'values' => array($options_values));
EOD;

        $setup_content.=<<<EOD

        $options
EOD;
            }
        }
    }
    elseif($setup_type == 'SQL Generated')
    {
        $stmt = $d->prepare("SELECT b.Field_Name AS new_field, a.Display, c.Table_Name
                             FROM table_fields_list_source_select a, table_fields b, \"table\" c
                             WHERE a.Field_ID=:f_id AND
                                   a.Select_Field_ID=b.Field_ID AND
                                   b.Table_ID = c.Table_ID");
        $stmt->bindValue(':f_id', $Field_ID);
        if($result = $stmt->execute())
        {
            $select_fields = array();
            $select_tables = array();
            $select_display = 'array(';
            $select_value = ''; //We'll only accept one value for the select field's value, so we don't need an array ^_^
            while($data = $result->fetchArray())
            {
                extract($data);
                if(!in_array($new_field, $select_fields))
                    $select_fields[] = array('Field'=>$new_field, 'Table'=>$Table_Name);

                if(!in_array($Table_Name, $select_tables))
                    $select_tables[] = $Table_Name;

                if($Display=="Yes")
                    $select_display .= "'$new_field', ";
                else
                    $select_value = $new_field;
            }
            $select_display = substr($select_display, 0, strlen($select_display) - 2); //remove last comma and space.
            $select_display .= ');'; //close the array declaration.
        }
        $stmt->close();

        $stmt = $d->prepare("SELECT b.Field_Name, Where_Field_Operand, Where_Field_Value, Where_Field_Connector
                             FROM table_fields_list_source_where a, table_fields b
                             WHERE a.Field_ID=:f_id AND a.Where_Field_ID=b.Field_ID");
        $stmt->bindValue(':f_id', $Field_ID);
        if($result = $stmt->execute())
        {
            $num_rows = 0;

            $where_fields = array();
            while($data = $result->fetchArray())
            {
                ++$num_rows;
                extract($data);
                $where_fields[] = array('Field' => $Field_Name,
                                        'Operand' => $Where_Field_Operand,
                                        'Value' => $Where_Field_Value,
                                        'Connector' => $Where_Field_Connector);
            }

            if($num_rows == 0)
            {
                $where_fields = NULL;
            }
        }
        $stmt->close();

        //****Create the query here.*********
        //Set the SELECT clause (fields)
        $select_query = 'SELECT ';
        $num_fields = count($select_fields);
        for($b=0; $b<$num_fields; $b++)
        {
            $select_query .= $select_fields[$b]['Table']  . '.' . $select_fields[$b]['Field'];
            if($select_fields[$b]['Field'] == $select_value)
            {
                $list_value = 'New_' . $select_fields[$b]['Field'];
                $select_query .= ' AS `' . $list_value . '`';
            }
            $select_query .= ', ';
        }
        $select_query = substr($select_query, 0, strlen($select_query) - 2); //removed last space and comma.

        //Set the FROM clause (tables)

        foreach($select_tables as $table)
        $select_query .= ' FROM ';
        {
            $select_query .= "$table, ";
        }
        $select_query = substr($select_query, 0, strlen($select_query) - 2); //removed last space and comma.

        //Set the WHERE clause (conditions) if applicable.
        if(is_null($where_fields))
        {
            //Nothing, no WHERE clause settings where found.
        }
        else
        {
            $select_query .= ' WHERE ';
            foreach($where_fields as $where)
            {
                if($where['Connector']=='NONE') $where['Connector'] = '';
                $select_query .= $where['Field'] . $where['Operand'] . "'" . $where['Value'] . "' " . $where['Connector'];
            }
        }

        //The names of the variables '$query_var', '$list_value_var', and '$list_items_var' need to be 'specialized' for this field,
        //so that the script will work despite having many of this type of control, otherwise, many controls of the same type
        //will end up depending on the same variable, which obviously won't work as expected.
        $query_var = $Field_Name . '_query';
        $list_value_var = $Field_Name . '_list_value';
        $list_items_var = $Field_Name . '_list_items';

        $setup_content.=<<<EOD

\$$query_var = "$select_query";
\$$list_value_var = "$list_value";
\$$list_items_var = $select_display
EOD;
    }

    return $setup_content;
}
