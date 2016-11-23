<?php
require 'components/get_listview_referrer.php';

require 'subclasses/user_role.php';
$dbh_user_role = new user_role;
$dbh_user_role->set_where("role_id='" . quote_smart($role_id) . "'");
if($result = $dbh_user_role->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);
}
