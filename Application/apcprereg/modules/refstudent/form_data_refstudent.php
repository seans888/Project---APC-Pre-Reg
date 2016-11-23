<?php
require 'components/get_listview_referrer.php';

require 'subclasses/refstudent.php';
$dbh_refstudent = new refstudent;
$dbh_refstudent->set_where("student_id='" . quote_smart($student_id) . "'");
if($result = $dbh_refstudent->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

    $data = explode('-',$birth_date);
    if(count($data) == 3)
    {
        $birth_date_year = $data[0];
        $birth_date_month = $data[1];
        $birth_date_day = $data[2];
    }
    $data = explode('-',$admission_date);
    if(count($data) == 3)
    {
        $admission_date_year = $data[0];
        $admission_date_month = $data[1];
        $admission_date_day = $data[2];
    }
}

