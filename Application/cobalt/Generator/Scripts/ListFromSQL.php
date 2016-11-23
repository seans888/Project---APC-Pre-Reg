<?php

function list_from_SQL_settings($Field_ID, $num_databases)
{
    $d = connect_DB();
    $stmt = $d->prepare("SELECT b.Field_Name AS Select_Field_Name, a.Display, c.Table_Name, d.Database
                         FROM table_fields_list_source_select a, table_fields b, \"table\" c, database_connection d
                         WHERE a.Field_ID=:f_id AND
                               a.Select_Field_ID=b.Field_ID AND
                               b.Table_ID = c.Table_ID AND
                               c.DB_Connection_ID = d.DB_Connection_ID
                         ORDER BY a.Auto_ID ASC");
    $stmt->bindValue(':f_id', $Field_ID);

    if($result = $stmt->execute())
    {
        $select_fields   = array();
        $select_tables   = array();
        $select_display  = 'array(';
        $select_value    = ''; //We'll only accept one value for the select field's value, so we don't need an array
        $order_by_fields = array();
        while($data = $result->fetchArray())
        {
            extract($data);
            if(!in_array($Select_Field_Name, $select_fields))
            {
                if($Display=="Yes")
                {
                    if('Queried_' . $Select_Field_Name == $select_value) //field to be displayed is the same as field used as value
                    {
                        $Select_Field_Name = 'Queried_' . $Select_Field_Name;
                        $select_display .= "'$Select_Field_Name', ";
                    }
                    else
                    {
                        $select_display .= "'$Select_Field_Name', ";
                        $select_fields[] = array('Field'=>$Select_Field_Name, 'Table'=>$Table_Name);
                    }

                    $order_by_fields['Table'][] = $Table_Name;
                    $order_by_fields['Field'][] = $Select_Field_Name;
                }
                else
                {
                    $select_value = 'Queried_' . $Select_Field_Name;
                    $Select_Field_Name = $Select_Field_Name . ' AS `' . $select_value . '`';
                    $select_fields[] = array('Field'=>$Select_Field_Name, 'Table'=>$Table_Name);
                }
            }

            if($num_databases > 1)
            {
                if(!in_array($Database . '.' . $Table_Name, $select_tables))
                {
                    $select_tables[] = $Database . '.' . $Table_Name;
                }
            }
            else
            {
                if(!in_array($Table_Name, $select_tables))
                {
                    $select_tables[] = $Table_Name;
                }
            }
        }
        $select_display = substr($select_display, 0, strlen($select_display) - 2); //remove last comma and space.
        $select_display .= ')'; //close the array declaration.
    }
    $stmt->close();

    $stmt = $d->prepare("SELECT b.Field_Name AS `Where_Field_Name`, Where_Field_Operand, Where_Field_Value, Where_Field_Connector
                         FROM table_fields_list_source_where a, table_fields b
                         WHERE a.Field_ID='$Field_ID' AND
                               a.Where_Field_ID=b.Field_ID");
    $stmt->bindValue(':f_id', $Field_ID);

    if($result = $stmt->execute())
    {
        $num_rows=0;
        while($data = $result->fetchArray())
        {
            ++$num_rows;
            extract($data);
            $where_fields[] = array('Field' => $Where_Field_Name,
                                    'Operand' => $Where_Field_Operand,
                                    'Value' => $Where_Field_Value,
                                    'Connector' => $Where_Field_Connector);
        }

        if($num_rows == 0) $where_fields = "NONE"; //no 'where clause' in query.
    }
    $stmt->close();

    //****Create the query here.*********
    //Set the SELECT clause (fields)
    $select_query = 'SELECT ';
    $num_fields = count($select_fields);
    for($b=0; $b<$num_fields; $b++)
    {
        $select_query .= $select_fields[$b]['Table']  . '.' . $select_fields[$b]['Field'] . ', ';
    }
    $select_query = substr($select_query, 0, strlen($select_query) - 2); //removed last space and comma.

    //Set the FROM clause (tables)

    $select_query .= ' FROM ';
    foreach($select_tables as $table)
    {
        $select_query .= "$table, ";
    }
    $select_query = substr($select_query, 0, strlen($select_query) - 2); //removed last space and comma.

    //Set the WHERE clause (conditions)
    if($where_fields!='NONE')
    {
        $select_query .= ' WHERE ';
        foreach($where_fields as $where)
        {
            if($where['Connector']=='NONE') $where['Connector'] = '';
            $select_query .= $where['Field'] . $where['Operand'] . "'" . $where['Value'] . "' " . $where['Connector'] . ' ';
        }
    }

    //Set the ORDER BY clause based on the list of fields shown, ASC, ranked in the order they are displayed
    $select_query .= ' ORDER BY ';
    $include_table_name = TRUE;
    if(count($select_tables) == 1)
    {
        //There is only one table involved, no need to use `table`.`field` format, just `field`.
        $include_table_name = FALSE;
    }

    foreach($order_by_fields['Field'] as $key=>$order_field)
    {
        if($include_table_name)
        {
            $select_query .= '`' . $order_by_fields['Table'][$key] . '`.';
        }
        $select_query .= '`' . $order_field . '`, ';
    }
    $select_query = substr($select_query, 0, strlen($select_query) - 2); //removed last space and comma.
    //********Aaaaand, we're done creating the query!**********

    $settings='';
    $settings.=<<<EOD
'query' => "$select_query",
                                                                     'list_value' => '$select_value',
                                                                     'list_items' => $select_display,
                                                                     'list_separators' => array()
EOD;
    //NOTE: The indentations above are necessary so the resulting file will have the items lined up nicely.

    return $settings;
}
