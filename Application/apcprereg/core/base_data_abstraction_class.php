<?php
class base_data_abstraction
{
    var $fields = array();
    var $relations = array();
    var $subclasses =array();

    var $mysqli='';
    var $db_host=DEFAULT_DB_HOST;
    var $db_user=DEFAULT_DB_USER;
    var $db_pass=DEFAULT_DB_PASS;
    var $db_use =DEFAULT_DB_USE;
    var $buffer_results = TRUE;

    var $affected_rows='';
    var $auto_id='';
    var $connection_exists=FALSE;
    var $dump = array(); //contains auto-fetched data through exec_fetch() or stmt_fetch()
    var $error='';
    var $group_by='';
    var $having='';
    var $join_clause='';
    var $limit_clause='';
    var $lst_error='';
    var $num_rows='';
    var $order_clause='';
    var $query='';
    var $query_type='';
    var $result='';
    var $selected_fields='';
    var $tables='';
    var $update_clause='';
    var $values='';
    var $where_clause='';
    var $stmt='';           //Holds the prepared statment object as returned by stmt_init();
    var $stmt_template = ''; //String, holds prepared statement template for later use with bind parameters.
    var $stmt_bind_args = array();  //Serves as the reference for stmt->bind_param parameters (param #2 and onwards).

    //Following fields are used by the custom reporting tool
    var $custom_join = '';
    var $custom_group_by = '';
    var $custom_where_clause = '';
    var $custom_select_fields = '';

    function __construct($new_db='', $new_tables='', $new_query_type='')
    {
        if($new_db != '') $this->db_use = $new_db;
        if($new_tables != '') $this->tables = $new_tables;
        if($new_query_type != '') $this->query_type = $new_query_type;
    }

    function close_db()
    {
        if($this->mysqli)
        {
            $this->mysqli->close();
            $this->connection_exists = FALSE;
        }
    }

    function connect_db()
    {
        $this->mysqli = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_use);

        if(mysqli_connect_errno())
        {
            printf("Failed to connect to database: %s\n", mysqli_connect_error());
            exit();
        }

        $this->connection_exists = TRUE;
        return $this;
    }

    function create_query_from_relationship($field, &$query, &$list_value, &$list_items)
    {
        foreach($this->relations as $id=>$rel)
        {
            if(back_quote_smart($rel['link_child']) == back_quote_smart($field))
            {
                $list_value = 'queried_' . strip_back_quote_smart($rel['link_parent']);
                $list_items = array();
                foreach($rel['link_subtext'] as $subtext)
                {
                    $list_items[] = strip_back_quote_smart($subtext);
                }

                //**************************************
                //Create the query:
                require_once 'Subclasses/' . strip_back_quote_smart($rel['table']) . '.php';
                $class = strip_back_quote_smart($rel['table']);
                $objDB = new $class;
                $database = $objDB->DB_USE;
                $objDB->close_DB();

                $value_field =  back_quote_smart($rel['link_parent']) . ' as `Queried_' . strip_back_quote_smart($rel['link_parent']) . '`';
                $items_field='';
                foreach($rel['link_subtext'] as $subtext)
                {
                    if(back_quote_smart($subtext) != back_quote_smart($rel['link_parent']))
                    {
                        make_list($items_field, strip_back_quote_smart($subtext), $delimiter=',', $quotes=TRUE, '`', '`');
                    }
                }
                $query = "SELECT $value_field";
                if($items_field != '') $query .= ', ' . $items_field;
                $query .= ' FROM ' . back_quote_smart($database) . '.' . back_quote_smart($rel['table']);

                if($rel['where_clause'] != '') $query .= ' WHERE ' . $rel['Where_clause'];

                if($items_field != '') $query .= " ORDER BY $items_field";
                else $query .= ' ORDER BY ' . back_quote_smart($rel['link_parent']);
            }
        }

        return $this;
    }


    function escape_arguments(&$param)
    {
        if(is_array($param))
        {
            $keys = array();
            foreach($param as $index=>$value)
            {
               $keys[] = $index;
            }

            for($a=0; $a<count($keys); ++$a)
            {
                $this->escape_arguments($param[$keys[$a]]);
            }
        }
        else
        {
            $param = quote_smart($param);
        }

        return $this;
    }

    function execute_query($query='', $log=TRUE)
    {
        if($query != '') $this->query = $query;

        if($this->connection_exists == FALSE)
        {
            $this->connect_db()->mysqli->real_query("SET NAMES 'utf8'");
        }
        $this->mysqli->real_query($this->query) or error_handler('Database error.',$this->mysqli->error);

        if($this->query_type=='')
        {
            if(strtoupper(substr($this->query, 0, 6)) == 'SELECT')
            {
                $this->query_type = 'SELECT';
            }
            elseif(strtoupper(substr($this->query, 0, 6)) == 'INSERT')
            {
                $this->query_type = 'INSERT';
            }
        }

        if(strtoupper($this->query_type) == "SELECT")
        {
            $this->error = $this->mysqli->error;
            if($this->buffer_results == TRUE)
            {
                $this->result = $this->mysqli->store_result();
                $this->num_rows = $this->result->num_rows;
            }
            else
            {
                $this->result = $this->mysqli->use_result();
                $this->num_rows = 0; //not known until we actually fetch them since this is an unbuffered result
            }
        }
        elseif(strtoupper($this->query_type) == "INSERT")
        {
            $this->auto_id = $this->mysqli->insert_id;
            $this->error = $this->mysqli->error;
        }
        else
        {
            $this->affected_rows = $this->mysqli->affected_rows;
        }

        if($log)
        {
            log_action('Query executed: ' . $this->query, $_SERVER['PHP_SELF']);
        }

        return $this;
    }

    function exec_fetch($result_type='array', $log=FALSE)
    {
        $this->make_query(TRUE, $log);
        $result = $this->result;

        //Valid types are 'single' and 'array'.
        //Default is 'array', and for robustness any other value
        //simply gets treated as 'array';

        //Result = single record, no need for arrays to store the result set
        if(strtoupper($result_type)=='SINGLE')
        {
            if($data = $result->fetch_assoc());
            {
                if(is_array($data))
                {
                    foreach($data as $key=>$value)
                    {
                        $this->dump[$key] = $value;
                    }
                }
            }
        }
        else //Result = multiple records, store in arrays
        {
            while($data = $result->fetch_assoc())
            {
                if(is_array($data))
                {
                    foreach($data as $key=>$value)
                    {
                        init_var($this->dump[$key]);
                        if(is_array($this->dump[$key])) ;
                        else $this->dump[$key] = array();
                        $this->dump[$key][] = $value;
                    }
                }
            }
        }

        return $this;
    }

    function get_info($arr_filters)
    {
        $where_clause = '';
        foreach($arr_filters as $field=>$value)
        {
            $this->escape_arguments($value);
            make_list($where_clause, "`$field`='$value'", ' AND ', FALSE);
        }
        $this->set_where($where_clause);
        $this->exec_fetch();

        return $this;
    }

    function get_join_clause($join_type='LEFT JOIN')
    {
        $this->join_clause = back_quote_smart($this->tables);

        foreach($this->relations as $key=>$rel)
        {
            if($rel['type'] == '1-1')
            {
                $this->join_clause .= ' ' . $join_type . ' '
                                    . back_quote_smart($rel['table']);

                if(isset($rel['alias']) && $rel['alias'] != '')
                {
                    $this->join_clause .= ' ' . back_quote_smart($rel['alias'])
                                        . ' ON '
                                        . back_quote_smart($this->tables) . '.' . back_quote_smart($rel['link_child']) . ' = '
                                        . back_quote_smart($rel['alias']) . '.' . back_quote_smart($rel['link_parent']);
                }
                else
                {
                    $this->join_clause .= ' ON '
                                        . back_quote_smart($this->tables) . '.' . back_quote_smart($rel['link_child']) . ' = '
                                        . back_quote_smart($rel['table']) . '.' . back_quote_smart($rel['link_parent']);
                }
            }
        }

        if($this->join_clause == '') $this->join_clause = $this->tables;

        return $this;
    }

    function make_query($execute=TRUE, $log=TRUE)
    {
        //****Before constructing the actual query, let's get the parameters straightened out.*******
        //Tables: Can never be empty.
        if($this->tables == '')
        {
            die("Data Abstraction Error: Please indicate what table(s) you wish to query.");
        }

        //Query type: SELECT, INSERT, UPDATE, or DELETE
        //For robustness, if query type is invalid, it defaults to "SELECT" instead of just dying.
        //Also convert to uppercase to make the query type passed case-insensitive.
        $this->query_type = strtoupper($this->query_type);
        if($this->query_type != "SELECT" && $this->query_type != "INSERT"  && $this->query_type != "UPDATE" && $this->query_type != "DELETE")
        {
            $this->query_type = "SELECT";
        }

        //Fields: Can only be empty for SELECT or DELETE, must have a value for INSERT queries.
        //If empty in a SELECT statement, default to '*'.
        if($this->selected_fields=="")
        {
            if($this->query_type=="SELECT")
            {
                $this->selected_fields='*';
            }
            elseif($this->query_type=="INSERT")
            {
                die('Data Abstraction Error: Please indicate the field(s) to work with in an INSERT query.');
            }
        }

        //Where clause: Can always be empty, but we generally don't want that in an UPDATE or DELETE query.
        if($this->where_clause=="" && ($this->query_type=="UPDATE" || $this->query_type=="DELETE"))
        {
            die('Data Abstraction Error: Please set a WHERE clause for an UPDATE or DELETE query.');
        }
        //Values: Only for INSERT queries, and must not be empty;
        if($this->query_type=='INSERT' && $this->values=='')
        {
            die('Data Abstraction Error: Please set the values to be inserted for an INSERT query.');
        }
        //Update clause: Only used in UPDATE queries and must not be empty.
        if($this->query_type=='UPDATE' && $this->update_clause=='')
        {
            die('Data Abstraction Error: Please set the update clause in an UPDATE query.');
        }

        $this->query = $this->query_type . ' ';
        switch($this->query_type)
        {
            case "SELECT": $this->query .=  $this->selected_fields . ' FROM ' . $this->tables;
                           if($this->where_clause != '') $this->query .= ' WHERE ' . $this->where_clause;
                           if($this->group_by != '') $this->query .= ' GROUP BY ' . $this->group_by . ' ';
                           if($this->having != '') $this->query .= ' HAVING ' . $this->having . ' ';
                           if($this->order_clause != '') $this->query .= ' ORDER BY ' . $this->order_clause;
                           if($this->limit_clause != '') $this->query .= ' LIMIT ' . $this->limit_clause;
                           break;

            case "INSERT": $this->query .= 'INTO ' . $this->tables . '(' .  $this->selected_fields . ') VALUES(' . $this->values . ')';
                           break;

            case "UPDATE": $this->query .= $this->tables . ' SET ' . $this->update_clause . ' WHERE ' . $this->where_clause;
                           break;

            case "DELETE": $this->query .= 'FROM ' . $this->tables;
                           if($this->where_clause != '') $this->query .= ' WHERE ' . $this->where_clause;
                           break;
        }

        if($execute)
        {
            if($this->query_type == 'SELECT')
            {
                $log = LOG_SELECT_QUERIES;
            }
            $this->execute_query('',$log);
        }

        return $this;
    }

    function sanitize(&$param)
    {
        $lst_error = '';
        require_once 'validation_class.php';
        require_once 'char_set_class.php';
        $validator = new validation;

        //Check if some required fields are left blank.
        foreach($this->fields as $field_name=>$field_details)
        {
            $label    = $field_details['label'];
            $required = $field_details['required'];
            if($required)
            {
                init_var($param[$field_name]);
                $lst_error .= $validator->check_if_null($label, $param[$field_name]);
            }
        }

        foreach($param as $unclean=>$unclean_value)
        {
            if(isset($this->fields[$unclean]))
            {
                $length               = $this->fields[$unclean]['length'];
                $data_type            = $this->fields[$unclean]['data_type'];
                $attribute            = $this->fields[$unclean]['attribute'];
                $control_type         = $this->fields[$unclean]['control_type'];
                $label                = $this->fields[$unclean]['label'];
                $char_set_method      = $this->fields[$unclean]['char_set_method'];
                $char_set_allow_space = $this->fields[$unclean]['char_set_allow_space'];
                $extra_chars_allowed  = $this->fields[$unclean]['extra_chars_allowed'];
                $trim                 = $this->fields[$unclean]['trim'];
                $valid_set            = $this->fields[$unclean]['valid_set'];

                //Apply trimming if specified.
                //Triming should be applied to $unclean_value for purposes of further filtering/checking,
                //and then also applied to $param[$unclean] so as to actually affect the POST variable.
                if(strtolower($trim) == 'trim')
                {
                    $unclean_value = trim($unclean_value);
                    $param[$unclean] = trim($unclean_value);
                }
                elseif(strtolower($trim) == 'ltrim')
                {
                    $unclean_value = ltrim($unclean_value);
                    $param[$unclean] = ltrim($unclean_value);
                }
                elseif(strtolower($trim) == 'rtrim')
                {
                    $unclean_value = rtrim($unclean_value);
                    $param[$unclean] = rtrim($unclean_value);
                }

                //Check length
                if($length > 0)
                {
                    if(strlen($unclean_value) > $length)
                        $lst_error .= "The field '$label' can only accept $length characters.<br>";
                }

                $validator = new validation;
                //If there is a set of valid inputs, check if 'unclean' conforms to it.
                if(count($valid_set) > 1)
                {
                    if($unclean_value == '')
                    {
                        //No need to check because no value was submitted.
                    }
                    else
                    {
                        $validator->check_data_set($unclean_value, $valid_set, TRUE);
                        if($validator->validity == FALSE)
                        {
                            $lst_error .= $validator->error_message . $label . '<br>';
                        }
                    }
                }
                else
                {
                    //If a char set method is given, check 'unclean' for invalid characters
                    if($char_set_method!='')
                    {
                        $cg = new char_set;
                        $cg->allow_space = $char_set_allow_space;
                        $cg->$char_set_method($extra_chars_allowed);
                        $allowed = $cg->allowed_chars;

                        $validator->field_name = $label;
                        $validator->validate_data($unclean_value, $data_type, $allowed);

                        if($validator->validity == FALSE)
                        {
                            $cntInvalidChars = count($validator->invalid_chars);
                            if($cntInvalidChars == 1)
                            {
                                $lst_error .= "Invalid character found in '$label': " . cobalt_htmlentities($validator->invalid_chars[0]) . '<br>';
                            }
                            elseif($cntInvalidChars > 1)
                            {
                                $lst_error .= "Invalid characters found in '$label': ";
                                for($a=0; $a<$cntInvalidChars; ++$a)
                                {
                                    $lst_error .= cobalt_htmlentities($validator->invalid_chars[$a]) . ' ';
                                }
                                $lst_error .= '<br>';
                            }
                        }
                    }
                }
            }
        }

        //determine if multifield data needs to be sanitized
        foreach($this->relations as $rel_info)
        {
            if($rel_info['type'] == '1-M')
            {
                $subclass = cobalt_load_class($rel_info['table']);
                $lst_error .= $subclass->sanitize_mf($param)->lst_error;
            }
        }

        $this->lst_error = $lst_error;

        return $this;
    }

    function sanitize_mf(&$param)
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

        $minimum_rows = 0;
        foreach($this->relations as $rel_info)
        {
            if($rel_info['type'] == 'M-1')
            {
                $minimum_rows = $rel_info['minimum'];
            }
        }

        $lst_error = '';
        require_once 'validation_class.php';
        require_once 'char_set_class.php';
        $validator = new validation;

        //Check if some required fields are left blank in the submitted rows.
        foreach($this->fields as $field_name=>$field_details)
        {
            $dd_field_name = $field_name;
            $field_name = 'cf_' . $this->table_name . '_' . $field_name;
            $label    = $field_details['label'];
            $required = $field_details['required'];
            if($required && $dd_field_name != $this->field_from_parent)
            {
                if(isset($param[$field_name]))
                {
                    $lst_error .= $validator->check_if_null($label, $param[$field_name]);
                }
            }
        }

        foreach($param as $unclean=>$unclean_value)
        {
            $prefix_length = strlen('cf_' . $this->table_name . '_');
            $unclean_no_prefix = substr($unclean, $prefix_length, strlen($unclean));

            if(isset($this->fields[$unclean_no_prefix]))
            {
                $length               = $this->fields[$unclean_no_prefix]['length'];
                $data_type            = $this->fields[$unclean_no_prefix]['data_type'];
                $attribute            = $this->fields[$unclean_no_prefix]['attribute'];
                $control_type         = $this->fields[$unclean_no_prefix]['control_type'];
                $label                = $this->fields[$unclean_no_prefix]['label'];
                $char_set_method      = $this->fields[$unclean_no_prefix]['char_set_method'];
                $char_set_allow_space = $this->fields[$unclean_no_prefix]['char_set_allow_space'];
                $extra_chars_allowed  = $this->fields[$unclean_no_prefix]['extra_chars_allowed'];
                $trim                 = $this->fields[$unclean_no_prefix]['trim'];
                $valid_set            = $this->fields[$unclean_no_prefix]['valid_set'];

                //Apply trimming if specified.
                //Triming should be applied to $unclean_value for purposes of further filtering/checking,
                //and then also applied to $param[$unclean] so as to actually affect the POST variable.
                //Note: since this is an mf-specialized method, we are dealing with arrays. Count first
                $num_items = 0;
                if(is_array($param[$unclean]))
                {
                    $num_items = count($param[$unclean]);
                }

                for($a=0; $a<$num_items; ++$a)
                {
                    if(strtolower($trim) == 'trim')
                    {
                        $unclean_value[$a] = trim($unclean_value[$a]);
                        $param[$unclean][$a] = trim($unclean_value[$a]);
                    }
                    elseif(strtolower($trim) == 'ltrim')
                    {
                        $unclean_value[$a] = ltrim($unclean_value[$a]);
                        $param[$unclean][$a] = ltrim($unclean_value[$a]);
                    }
                    elseif(strtolower($trim) == 'rtrim')
                    {
                        $unclean_value[$a] = rtrim($unclean_value[$a]);
                        $param[$unclean][$a] = rtrim($unclean_value[$a]);
                    }

                    //Check length
                    if($length > 0)
                    {
                        if(strlen($unclean_value[$a]) > $length)
                            $lst_error .= "The field '$label' (in line #" . ($a+1) . ") can only accept $length characters.<br>";
                    }

                    $validator = new validation;
                    //If there is a set of valid inputs, check if 'unclean' conforms to it.
                    if(count($valid_set) > 1)
                    {
                        if($unclean_value == '')
                        {
                            //No need to check because no value was submitted.
                        }
                        else
                        {
                            $validator->check_data_set($unclean_value[$a], $valid_set, TRUE);
                            if($validator->validity == FALSE)
                            {
                                $lst_error .= $validator->error_message . $label . '<br>';
                            }
                        }
                    }
                    else
                    {
                        //If a char set method is given, check 'unclean' for invalid characters
                        if($char_set_method!='')
                        {
                            $cg = new char_set;
                            $cg->allow_space = $char_set_allow_space;
                            $cg->$char_set_method($extra_chars_allowed);
                            $allowed = $cg->allowed_chars;

                            $validator->field_name = $label;
                            $validator->validate_data($unclean_value[$a], $data_type, $allowed);
                            if($validator->validity == FALSE)
                            {
                                $cntInvalidChars = count($validator->invalid_chars);

                                if($cntInvalidChars == 1)
                                {
                                    $lst_error .= "Invalid character found in '$label' in line #" . ($a+1) . ": " . cobalt_htmlentities($validator->invalid_chars[0]) . '<br>';
                                }
                                elseif($cntInvalidChars > 1)
                                {
                                    $lst_error .= "Invalid characters found in '$label' in line #" . ($a+1) . ": ";
                                    for($b=0; $b<$cntInvalidChars; ++$b)
                                    {
                                        $lst_error .= cobalt_htmlentities($validator->invalid_chars[$b]) . ' ';
                                    }
                                    $lst_error .= '<br>';
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->lst_error = $lst_error;

        return $this;
    }


    function set_database($new_database)
    {
        $this->db_use = $new_database;
        return $this;
    }

    function set_fields($new_fields)
    {
        $this->selected_fields = $new_fields;
        return $this;
    }

    function set_group_by($group)
    {
        $this->group_by = $group;
        return $this;
    }

    function set_having($having)
    {
        $this->having = $having;
        return $this;
    }

    function set_limit($offset, $limit)
    {
        $this->limit_clause = $offset . ', ' . $limit;
        return $this;
    }

    function set_order($new_order_clause)
    {
        $this->order_clause = $new_order_clause;
        return $this;
    }

    function set_query_type($new_query_type)
    {
        $this->query_type = $new_query_type;
        return $this;
    }

    function set_table($new_table)
    {
        $this->tables = $new_table;
        return $this;
    }

    function set_update($new_update_clause)
    {
        $this->update_clause = $new_update_clause;
        return $this;
    }

    function set_values($new_values)
    {
        if(is_array($new_values))
        {
            $this->values = implode('),(', $new_values);

        }
        else
        {
            $this->values = $new_values;
        }
        return $this;
    }

    function set_where($new_where_clause)
    {
        $this->where_clause = $new_where_clause;
        return $this;
    }

    function set_parameters($param)
    {
        foreach($this->fields as $field_name=>$field_data)
        {
            if(isset($param[$field_name]))
            {
                $this->fields[$field_name]['value'] = $param[$field_name];
            }
            else
            {
                if(isset($this->fields[$field_name]['nullable']) && $this->fields[$field_name]['nullable'] == TRUE)
                {
                    $this->fields[$field_name]['value'] = NULL;
                }
                else
                {
                    $this->fields[$field_name]['value'] = '';
                }
            }
        }
    }

    function set_bind_type($field_name, $data_type)
    {
        switch(strtolower($data_type))
        {
            case 'integer':  $this->bind_types .= 'i';
                             break;

            case 'double' :
            case 'float' :   $this->bind_types .= 'd';
                             break;

            case 'binary' :
            case 'blob' :    $this->bind_types .= 'b';

            case 'varchar':
            case 'text':
            default :        $this->bind_types .= 's';
        }
    }

    function stmt_set($query)
    {
        $this->stmt_template == $query;
        return $this;
    }

    function stmt_prepare($bind_params)
    {
        //If stmt_template was not manually given a value, try to create one from query components that may have been supplied.
        if($this->stmt_template == '')
        {
            $this->make_query(FALSE, FALSE); //do not execute, do not log (useless to log a prepared statement like this, no actual parameters present)
            $this->stmt_template = $this->query;
        }

        if($this->connection_exists == FALSE)
        {
            $this->connect_db()->mysqli->real_query("SET NAMES 'utf8'");
        }
        $this->stmt = $this->mysqli->stmt_init();
        $this->stmt->prepare($this->stmt_template);

        //Store args into a member
        $this->stmt_bind_args = $bind_params;

        //Transform args into array with references (stmt->bind_param requires the named parameters to be references, not values)
        //Making them reference $this->stmt_bind_args is also necessary so that we can just overwrite the values in $this->stmt_bind_args
        //to execute another prepared statement with stmt->execute() without having to bind_param() again.
        $arr_params=array();
        $cntr=0;
        foreach($this->stmt_bind_args as $key=>$value)
        {
            if($cntr>0)
            {
                $arr_params[] = &$this->stmt_bind_args[$key];
            }
            else
            {
                $arr_params[] = $value;
            }
            ++$cntr;
        }

        call_user_func_array(array($this->stmt, 'bind_param'), $arr_params);

        return $this;
    }

    function stmt_execute($log=TRUE)
    {
        $this->stmt->execute() or error_handler('Database error. ', $this->stmt->error);

        if($this->query_type == "SELECT")
        {
            if($this->buffer_results == TRUE)
            {
                $this->stmt->store_result();
                $this->num_rows = $this->stmt->num_rows;
            }
            else
            {
                $this->num_rows = 0; ////not known until we actually fetch them since this is an unbuffered result
            }
            $this->error = $this->stmt->error;
            $log=LOG_SELECT_QUERIES;
        }
        elseif($this->query_type == "INSERT")
        {
            $this->auto_id = $this->stmt->insert_id;
            $this->error = $this->stmt->error;
        }
        else
        {
            $this->affected_rows = $this->mysqli->affected_rows;
        }

        if($log) log_action('Query Executed: ' . $this->query . "\r\n" . print_r($this->stmt_bind_args, TRUE));
        return $this;
    }

    function stmt_fetch($result_type='array')
    {
        $this->stmt_execute();
        $result = $this->stmt;
        //Valid types are 'single' and 'array'.
        //Default is 'array', and for robustness any other value
        //simply gets treated as 'array';

        //Get number of fields
        $num_fields = $result->field_count;

        //create temporary bind result vars
        $arr_results = array();
        for($a=0; $a<$num_fields; ++$a)
        {
            $var_name = 'col' . $a;
            $$var_name='';
            $arr_results[] = &$$var_name;
        }
        call_user_func_array(array($this->stmt, 'bind_result'), $arr_results);

        //Get the field names
        $meta = $result->result_metadata();
        $arr_fieldnames = array();
        for($a=0; $a<$num_fields; ++$a)
        {
            $field = $meta->fetch_field();
            $arr_fieldnames[] = $field->name;
        }

        //Result = single record, no need for arrays to store the result set
        if(strtoupper($result_type)=='SINGLE')
        {
            $result->fetch();
            for($b=0; $b<$num_fields; ++$b)
            {
                $field_name = $arr_fieldnames[$b];
                $value = $arr_results[$b];
                $this->dump[$field_name] = $value;
            }
        }
        else //Result = multiple records, store in arrays
        {
            while($result->fetch())
            {
                for($b=0; $b<$num_fields; ++$b)
                {
                    $field_name = $arr_fieldnames[$b];
                    $value = $arr_results[$b];

                    init_var($this->dump[$field_name]);
                    if(is_array($this->dump[$field_name])) ;
                    else $this->dump[$field_name] = array();
                    $this->dump[$field_name][] = $value;
                }
            }
        }

        return $this;
    }

    function stmt_close()
    {
        $this->stmt_template='';
        $this->stmt->close();
        return $this;
    }

    function export_to_csv($arr_filters=null)
    {
        $csv_contents = '';
        $filter='';

        if(isset($arr_filters))
        {
            $this->escape_arguments($arr_filters);

            foreach($arr_filters as $field=>$value)
            {
                $new_filter='';
                $new_filter .= "$field = '$value'";

                make_list($filter, $new_filter, ' AND ', FALSE);
            }
        }
        else
        {
            $filter='1';
        }

        $result = $this->connect_db()->execute_query('SELECT * FROM ' . $this->tables . ' WHERE ' . $filter, LOG_SELECT_QUERIES)->result;

        while($data = $result->fetch_assoc())
        {
            extract($data);
            $new_csv_line='';
            foreach($this->fields as $field_name=>$field_data)
            {
                $$field_name = str_replace('"',"''", $$field_name);
                make_list($new_csv_line, $$field_name, ',', TRUE, '"');
            }
            $csv_contents .= $new_csv_line . "\r\n";
        }
        return $csv_contents;
    }

    function buffer($switch=TRUE)
    {
        $this->buffer_results = $switch;
        return $this;
    }

    //Used by the custom reporting tool to retreive data
    function custom_report()
    {
        $this->set_table($this->custom_join);
        $this->set_fields($this->custom_select_fields);
        $this->set_where($this->custom_where_clause);
        if($this->custom_group_by != '')
        {
            $this->set_group_by($this->custom_group_by);
        }
        $this->exec_fetch();
        return $this;
    }
}
