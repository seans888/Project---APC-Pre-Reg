<?php
$rpt_subclass = $class_name . '_rpt';
$show_in_tasklist = 'No';
$module_permission_count = 0; //This module needs no extra permission, because it relies on the generic view permission

$script_content=<<<EOD

require 'reporter_class.php';
\$reporter = cobalt_load_class('$rpt_subclass');

//\$reporter->print_settings(); //You can uncomment this line to get the PHP code for the settings arrays. You can
                               //use one or more of the arrays to customize the report output or deal with special cases 
                               //(adding special aliases, overriding labels for tables with similar field names, etc)

require 'components/reporter_interface_proc.php';
require 'components/reporter_interface_head.php';

for(\$i=0; \$i<\$num_fields; ++\$i)
{
    init_var(\$text_field[\$i]);
    require 'components/reporter_interface_body.php';
}

require 'components/reporter_interface_foot.php';
EOD;
