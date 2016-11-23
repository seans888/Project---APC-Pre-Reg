<?php
require 'components/get_listview_referrer.php';

require 'subclasses/reftermperiod.php';
$dbh_reftermperiod = new reftermperiod;
$dbh_reftermperiod->set_where("term_id='" . quote_smart($term_id) . "' AND period='" . quote_smart($period) . "'");
if($result = $dbh_reftermperiod->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

    $data = explode('-',$exam_start);
    if(count($data) == 3)
    {
        $exam_start_year = $data[0];
        $exam_start_month = $data[1];
        $exam_start_day = $data[2];
    }
    $data = explode('-',$exam_end);
    if(count($data) == 3)
    {
        $exam_end_year = $data[0];
        $exam_end_month = $data[1];
        $exam_end_day = $data[2];
    }
    $data = explode('-',$faculty_evaluation_start);
    if(count($data) == 3)
    {
        $faculty_evaluation_start_year = $data[0];
        $faculty_evaluation_start_month = $data[1];
        $faculty_evaluation_start_day = $data[2];
    }
    $data = explode('-',$faculty_evaluation_end);
    if(count($data) == 3)
    {
        $faculty_evaluation_end_year = $data[0];
        $faculty_evaluation_end_month = $data[1];
        $faculty_evaluation_end_day = $data[2];
    }
    $data = explode('-',$grade_submission_start);
    if(count($data) == 3)
    {
        $grade_submission_start_year = $data[0];
        $grade_submission_start_month = $data[1];
        $grade_submission_start_day = $data[2];
    }
    $data = explode('-',$grade_submission_end);
    if(count($data) == 3)
    {
        $grade_submission_end_year = $data[0];
        $grade_submission_end_month = $data[1];
        $grade_submission_end_day = $data[2];
    }
}

