<?php
if(xsrf_guard())
{
    init_var($_POST['btn_cancel']);
    init_var($_POST['btn_submit']);
    init_var($_POST['btn_save']);
    init_var($_POST['btn_load']);
    init_var($_POST['btn_delete']);
    init_var($show_field);
    init_var($sum_field);
    init_var($count_field);
    init_var($group_field);

    $operator   = $_POST['operator'];
    $text_field = $_POST['text_field'];

    if(isset($_SESSION[$reporter->session_array_name]['custom_title']))
    {
        //Clear the previously set custom title so that any custom report produced right after won't inherit the last custom title
        unset($_SESSION[$reporter->session_array_name]['custom_title']);
    }

    if($_POST['btn_cancel'])
    {
        log_action('Pressed cancel button');
        $cancel_page = $reporter->cancel_page;
        redirect($cancel_page);
    }

    if($_POST['btn_load'])
    {
        if(trim($_POST['chosen_report']) != '')
        {
            //retrieve saved reports (if any)
            $d = new data_abstraction;
            $d->set_table('cobalt_reporter');
            $d->set_where("module_name=? AND report_name=?");
            $reporter_mod_name = $reporter->session_array_name;
            $chosen_report = $_POST['chosen_report'];
            $bind_params = array('ss', $reporter_mod_name, $chosen_report);
            $d->stmt_prepare($bind_params);
            $d->stmt_fetch('single');
            $arr_report_details = $d->dump;
            $d = null;

            $show_field  = $_SESSION[$reporter->session_array_name]['show_field']  = unserialize($arr_report_details['show_field']);
            $operator    = $_SESSION[$reporter->session_array_name]['operator']    = unserialize($arr_report_details['operator']);
            $text_field  = $_SESSION[$reporter->session_array_name]['text_field']  = unserialize($arr_report_details['text_field']);
            $sum_field   = $_SESSION[$reporter->session_array_name]['sum_field']   = unserialize($arr_report_details['sum_field']);
            $count_field = $_SESSION[$reporter->session_array_name]['count_field'] = unserialize($arr_report_details['count_field']);
            $group_field1 = $_SESSION[$reporter->session_array_name]['group_field1'] = unserialize($arr_report_details['group_field1']);
            $group_field2 = $_SESSION[$reporter->session_array_name]['group_field2'] = unserialize($arr_report_details['group_field2']);
            $group_field3 = $_SESSION[$reporter->session_array_name]['group_field3'] = unserialize($arr_report_details['group_field3']);

            $token = generate_token();
            $_SESSION[$reporter->session_array_name]['token'] = $token;
            $token = rawurlencode($token);

            $result_page = $reporter->result_page;
            $open_result_page=TRUE;

            $_SESSION[$reporter->session_array_name]['custom_title'] = $_POST['chosen_report'];
        }
        else
        {
            $message = 'Please choose a saved report to run.';
        }
    }

    if($_POST['btn_save'])
    {
        if(trim($_POST['saved_report_title']) != '')
        {
            $arr_params['module_name'] = $reporter->session_array_name;

            $arr_params['show_field']  = '';
            $arr_params['operator']    = '';
            $arr_params['text_field']  = '';
            $arr_params['sum_field']   = '';
            $arr_params['count_field'] = '';
            $arr_params['group_field1'] = '';
            $arr_params['group_field2'] = '';
            $arr_params['group_field3'] = '';

            if(isset($_POST['show_field']))
            {
                $arr_params['show_field']  = serialize($_POST['show_field']);
            }
            if(isset($_POST['operator']))
            {
                $arr_params['operator']    = serialize($_POST['operator']);
            }
            if(isset($_POST['text_field']))
            {
                $arr_params['text_field']  = serialize($_POST['text_field']);
            }
            if(isset($_POST['sum_field']))
            {
                $arr_params['sum_field']   = serialize($_POST['sum_field']);
            }
            if(isset($_POST['count_field']))
            {
                $arr_params['count_field'] = serialize($_POST['count_field']);
            }
            if(isset($_POST['group_field1']))
            {
                $arr_params['group_field1'] = serialize($_POST['group_field1']);
            }
            if(isset($_POST['group_field2']))
            {
                $arr_params['group_field2'] = serialize($_POST['group_field2']);
            }
            if(isset($_POST['group_field3']))
            {
                $arr_params['group_field3'] = serialize($_POST['group_field3']);
            }

            //Delete any existing report with the same report_name + module_name in order to effectively overwrite similarly named reports
            $dbh = new data_abstraction;
            $dbh->set_query_type('DELETE');
            $dbh->set_table('cobalt_reporter');
            $dbh->set_where('module_name = ? AND report_name = ?');

            $bind_params = array('ss',
                                $arr_params['module_name'],
                                $_POST['saved_report_title']);

            $dbh->stmt_prepare($bind_params);
            $dbh->stmt_execute();

            //Insert new report
            $dbh = new data_abstraction;
            $dbh->set_query_type('INSERT');
            $dbh->set_table('cobalt_reporter');
            $dbh->set_fields('`module_name`,
                            `report_name`,
                            `username`,
                            `show_field`,
                            `operator`,
                            `text_field`,
                            `sum_field`,
                            `count_field`,
                            `group_field1`,
                            `group_field2`,
                            `group_field3`');
            $dbh->set_values('?,?,?,?,?,?,?,?,?,?,?');

            $bind_params = array('sssssssssss',
                            $arr_params['module_name'],
                            $_POST['saved_report_title'],
                            $_SESSION['user'],
                            $arr_params['show_field'],
                            $arr_params['operator'],
                            $arr_params['text_field'],
                            $arr_params['sum_field'],
                            $arr_params['count_field'],
                            $arr_params['group_field1'],
                            $arr_params['group_field2'],
                            $arr_params['group_field3']);

            $dbh->stmt_prepare($bind_params);
            $dbh->stmt_execute();


            $show_field  = $_POST['show_field'];
            $operator    = $_POST['operator'];
            $text_field  = $_POST['text_field'];
            if(isset($_POST['sum_field']))
            {
                $sum_field = $_POST['sum_field'];
            }

            if(isset($_POST['count_field']))
            {
                $count_field = $_POST['count_field'];
            }

            if(isset($_POST['group_field1']))
            {
                $group_field1 = $_POST['group_field1'];
            }
            if(isset($_POST['group_field2']))
            {
                $group_field2 = $_POST['group_field2'];
            }
            if(isset($_POST['group_field3']))
            {
                $group_field3 = $_POST['group_field3'];
            }

            $message = 'Report saved successfully!';
            $message_type = 'system';
        }
        else
        {
            $message = 'Please enter a Report Name in order to save the report';
        }
    }

    if($_POST['btn_delete'])
    {
        if(trim($_POST['chosen_report']) != '')
        {
            log_action('Pressed delete button');

            $reporter_mod_name = $reporter->session_array_name;
            $chosen_report = $_POST['chosen_report'];


            //Delete any existing report with the same report_name + module_name in order to effectively overwrite similarly named reports
            $dbh = new data_abstraction;
            $dbh->set_query_type('DELETE');
            $dbh->set_table('cobalt_reporter');
            $dbh->set_where('module_name = ? AND report_name = ?');

            $bind_params = array('ss',
                                $reporter_mod_name,
                                $chosen_report);

            $dbh->stmt_prepare($bind_params);
            $dbh->stmt_execute();
        }
        else
        {
            $message = 'Please choose a saved report to delete';
        }
    }

    if($_POST['btn_submit'])
    {
        log_action('Pressed submit button');

        if(!isset($_POST['show_field']) || !is_array($_POST['show_field']))
        {
            $message = 'Please check at least one column to be used for the report.';
            $show_field = array();
        }
        else
        {
            $show_field = $_POST['show_field'];
        }

        if($message == '')
        {
            $sess_var = $reporter->session_array_name;
            $_SESSION[$sess_var]['show_field']  = $_POST['show_field'];
            $_SESSION[$sess_var]['operator']    = $_POST['operator'];
            $_SESSION[$sess_var]['text_field']  = $_POST['text_field'];
            $_SESSION[$sess_var]['sum_field']   = '';
            $_SESSION[$sess_var]['count_field'] = '';
            $_SESSION[$sess_var]['group_field1'] = '';
            $_SESSION[$sess_var]['group_field2'] = '';
            $_SESSION[$sess_var]['group_field3'] = '';

            if(isset($_POST['sum_field']))
            {
                $sum_field = $_POST['sum_field'];
                $_SESSION[$sess_var]['sum_field']   = $sum_field;
            }

            if(isset($_POST['count_field']))
            {
                $count_field = $_POST['count_field'];
                $_SESSION[$sess_var]['count_field'] = $count_field;
            }

            if(isset($_POST['group_field1']))
            {
                $group_field1 = $_POST['group_field1'];
                $_SESSION[$sess_var]['group_field1'] = $group_field1;
            }
            if(isset($_POST['group_field2']))
            {
                $group_field2 = $_POST['group_field2'];
                $_SESSION[$sess_var]['group_field2'] = $group_field2;
            }
            if(isset($_POST['group_field3']))
            {
                $group_field3 = $_POST['group_field3'];
                $_SESSION[$sess_var]['group_field3'] = $group_field3;
            }

            $token = generate_token();
            $_SESSION[$sess_var]['token'] = $token;
            $token = rawurlencode($token);

            $result_page = $reporter->result_page;
            $open_result_page=TRUE;
        }
    }
}

//retrieve saved reports (if any)
$d = new data_abstraction;
$d->set_table('cobalt_reporter');
$d->set_fields('report_name');
$d->set_where("module_name=?");
$reporter_mod_name = $reporter->session_array_name;
$bind_params = array('s', $reporter_mod_name);
$d->stmt_prepare($bind_params);
$d->stmt_fetch();
$arr_saved_reports = $d->dump;
$d = null;
