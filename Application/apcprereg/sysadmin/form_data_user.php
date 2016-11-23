<?php
require 'components/get_listview_referrer.php';

require 'subclasses/user.php';
$dbh_user = new user;
$dbh_user->set_where("username='" . quote_smart($username) . "'");
if($result = $dbh_user->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);
}
