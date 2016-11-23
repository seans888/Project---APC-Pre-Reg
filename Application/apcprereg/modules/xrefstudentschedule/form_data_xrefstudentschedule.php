<?php
require 'components/get_listview_referrer.php';

require 'subclasses/xrefstudentschedule.php';
$dbh_xrefstudentschedule = new xrefstudentschedule;
$dbh_xrefstudentschedule->set_where("subject_offering_id='" . quote_smart($subject_offering_id) . "' AND student_id='" . quote_smart($student_id) . "'");
if($result = $dbh_xrefstudentschedule->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

    $data = explode('-',$date);
    if(count($data) == 3)
    {
        $date_year = $data[0];
        $date_month = $data[1];
        $date_day = $data[2];
    }
}

