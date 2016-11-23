<?php
require 'components/get_listview_referrer.php';

require 'subclasses/addsubject.php';
$dbh_addsubject = new addsubject;
$dbh_addsubject->set_where("");
if($result = $dbh_addsubject->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

}

