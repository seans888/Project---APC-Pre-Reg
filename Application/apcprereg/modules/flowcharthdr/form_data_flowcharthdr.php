<?php
require 'components/get_listview_referrer.php';

require 'subclasses/flowcharthdr.php';
$dbh_flowcharthdr = new flowcharthdr;
$dbh_flowcharthdr->set_where("flow_id='" . quote_smart($flow_id) . "'");
if($result = $dbh_flowcharthdr->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

}

