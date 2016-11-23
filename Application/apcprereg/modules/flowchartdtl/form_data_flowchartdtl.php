<?php
require 'components/get_listview_referrer.php';

require 'subclasses/flowchartdtl.php';
$dbh_flowchartdtl = new flowchartdtl;
$dbh_flowchartdtl->set_where("flow_dtl_id='" . quote_smart($flow_dtl_id) . "'");
if($result = $dbh_flowchartdtl->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

}

