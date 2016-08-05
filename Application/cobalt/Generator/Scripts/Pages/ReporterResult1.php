<?php
$rpt_subclass = $class_name . '_rpt';
$show_in_tasklist = 'No';
$module_permission_count = 0; //This module needs no extra permission, because it relies on the generic view permission

$script_content=<<<EOD

require 'reporter_class.php';
\$reporter = cobalt_load_class('$rpt_subclass');
require 'components/reporter_result_query_constructor.php';
require 'components/reporter_result_body.php';
EOD;
