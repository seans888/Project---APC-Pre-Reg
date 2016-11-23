<?php
require 'components/get_listview_referrer.php';

require 'subclasses/refsubjectofferinghdr.php';
$dbh_refsubjectofferinghdr = new refsubjectofferinghdr;
$dbh_refsubjectofferinghdr->set_where("subject_offering_id='" . quote_smart($subject_offering_id) . "'");
if($result = $dbh_refsubjectofferinghdr->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

}

