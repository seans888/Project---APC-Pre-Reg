<?php
require 'components/get_listview_referrer.php';

require 'subclasses/system_settings.php';
$dbh_system_settings = new system_settings;
$dbh_system_settings->set_where("setting='" . quote_smart($setting) . "'");
if($result = $dbh_system_settings->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);
}
