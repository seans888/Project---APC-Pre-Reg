<?php

require 'path.php';
init_cobalt('Add refstudent');

require 'components/get_listview_referrer.php';

if(xsrf_guard())
{

}

require 'html_class.php';
$html = new html;
$html->draw_header('Add %%', $message, $message_type);
$html->draw_listview_referrer_info($filter_field_used, $filter_used, $page_from, $filter_sort_asc, $filter_sort_desc);
// html->draw_controls('add');
// $x = $_SESSION['last_name'];

require_once 'subclasses/flowcharthdr.php';
$dbh_flowcharthdr = new flowcharthdr;

$param = array('student_id' => $_SESSION['user']);
if ($result = $dbh_flowcharthdr->get_student_flowchart($param)->dump)
{

}



$html->draw_footer();

?>
