<?php
require 'components/get_listview_referrer.php';

require 'subclasses/dept.php';
$dbh_dept = new dept;
$dbh_dept->set_where("dept_id='" . quote_smart($dept_id) . "'");
if($result = $dbh_dept->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

}

