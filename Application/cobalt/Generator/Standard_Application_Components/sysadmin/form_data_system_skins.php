<?php
require 'components/get_listview_referrer.php';

require 'subclasses/system_skins.php';
$dbh_system_skins = new system_skins;
$dbh_system_skins->set_where("skin_id='" . quote_smart($skin_id) . "'");
if($result = $dbh_system_skins->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);
}
