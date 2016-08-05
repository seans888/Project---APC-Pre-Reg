<?php
$rpt_subclass = $class_name . '_rpt';
$show_in_tasklist = 'No';
$module_permission_count = 0; //This module needs no extra permission, because it relies on the generic view permission

$script_content=<<<EOD

require_once('thirdparty/tcpdf/tcpdf.php');
require_once 'reporter_class.php';
\$reporter = cobalt_load_class('$rpt_subclass');
\$sess_var = \$reporter->session_array_name;
\$title = \$reporter->report_title;

require_once 'components/reporter_result_pdf.php';

// close and output PDF document
\$pdf_filename = \$_SESSION['user'] . '_' . \$sess_var . '_' . date('Y-m-d_h-ia') . '.pdf';
\$pdf->Output(\$pdf_filename, 'I');
EOD;
