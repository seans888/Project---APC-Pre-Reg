<?php
require 'components/get_listview_referrer.php';

require 'subclasses/xrefstudentcourse.php';
$dbh_xrefstudentcourse = new xrefstudentcourse;
$dbh_xrefstudentcourse->set_where("student_id='" . quote_smart($student_id) . "' AND course='" . quote_smart($course) . "' AND term_id='" . quote_smart($term_id) . "'");
if($result = $dbh_xrefstudentcourse->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

}

