<?php
require 'components/get_listview_referrer.php';

require 'subclasses/course.php';
$dbh_course = new course;
$dbh_course->set_where("course='" . quote_smart($course) . "'");
if($result = $dbh_course->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

}

