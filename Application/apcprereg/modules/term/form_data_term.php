<?php
require 'components/get_listview_referrer.php';

require 'subclasses/term.php';
$dbh_term = new term;
$dbh_term->set_where("term_id='" . quote_smart($term_id) . "'");
if($result = $dbh_term->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

    $data = explode('-',$term_start);
    if(count($data) == 3)
    {
        $term_start_year = $data[0];
        $term_start_month = $data[1];
        $term_start_day = $data[2];
    }
    $data = explode('-',$term_end);
    if(count($data) == 3)
    {
        $term_end_year = $data[0];
        $term_end_month = $data[1];
        $term_end_day = $data[2];
    }
    $data = explode('-',$reg_start);
    if(count($data) == 3)
    {
        $reg_start_year = $data[0];
        $reg_start_month = $data[1];
        $reg_start_day = $data[2];
    }
    $data = explode('-',$reg_end);
    if(count($data) == 3)
    {
        $reg_end_year = $data[0];
        $reg_end_month = $data[1];
        $reg_end_day = $data[2];
    }
    $data = explode('-',$install1);
    if(count($data) == 3)
    {
        $install1_year = $data[0];
        $install1_month = $data[1];
        $install1_day = $data[2];
    }
    $data = explode('-',$install2);
    if(count($data) == 3)
    {
        $install2_year = $data[0];
        $install2_month = $data[1];
        $install2_day = $data[2];
    }
}

