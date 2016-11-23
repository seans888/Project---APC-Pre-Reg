<?php
require 'components/get_listview_referrer.php';

require 'subclasses/cobalt_sst.php';
$dbh_cobalt_sst = new cobalt_sst;
$dbh_cobalt_sst->set_where("auto_id='" . quote_smart($auto_id) . "'");
if($result = $dbh_cobalt_sst->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);

}

