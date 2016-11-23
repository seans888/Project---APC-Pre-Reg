<?php
//********************************
//Transform single values of $_FILES to an array for compatibility
$tmp_x = $_FILES[$file_upload_control_name]['name'];
unset($_FILES[$file_upload_control_name]['name']);
$_FILES[$file_upload_control_name]['name'][0] = $tmp_x;

$tmp_x = $_FILES[$file_upload_control_name]['size'];
unset($_FILES[$file_upload_control_name]['size']);
$_FILES[$file_upload_control_name]['size'][0] = $tmp_x;

$tmp_x = $_FILES[$file_upload_control_name]['error'];
unset($_FILES[$file_upload_control_name]['error']);
$_FILES[$file_upload_control_name]['error'][0] = $tmp_x;

$tmp_x = $_FILES[$file_upload_control_name]['tmp_name'];
unset($_FILES[$file_upload_control_name]['tmp_name']);
$_FILES[$file_upload_control_name]['tmp_name'][0] = $tmp_x;
//********************************

//Transform single value of $_POST to an array for compatibility
$existing_file_upload_control_name = 'existing_' . $file_upload_control_name;
$tmp_x = $_POST[$existing_file_upload_control_name];
unset($_POST[$existing_file_upload_control_name]);
$_POST[$existing_file_upload_control_name][0] = $tmp_x;

//Set some stuff needed by the upload_generic_mf component
$upload_generic_auto_single = 1;
$mf_upload_counter_name  = 'upload_generic_auto_single';

//Call central component
require 'upload_generic_mf.php';

//END: Transform some arrays back into strings so the form can handle them
$arr_form_data[$file_upload_control_name] = $arr_form_data[$file_upload_control_name][0];
${$file_upload_control_name} = ${$file_upload_control_name}[0];
