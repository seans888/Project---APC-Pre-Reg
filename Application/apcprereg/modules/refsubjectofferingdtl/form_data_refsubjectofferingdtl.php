<?php
require 'components/get_listview_referrer.php';

require 'subclasses/refsubjectofferingdtl.php';
$dbh_refsubjectofferingdtl = new refsubjectofferingdtl;
$dbh_refsubjectofferingdtl->set_where("");
if($result = $dbh_refsubjectofferingdtl->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

}

