<?php
require 'components/get_listview_referrer.php';

require 'subclasses/user_links.php';
$dbh_user_links = new user_links;
$dbh_user_links->set_where("link_id='" . quote_smart($link_id) . "'");
if($result = $dbh_user_links->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);
}
