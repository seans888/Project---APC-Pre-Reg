<?php
require 'components/get_listview_referrer.php';

require 'subclasses/user_passport_groups.php';
$dbh_user_passport_groups = new user_passport_groups;
$dbh_user_passport_groups->set_where("passport_group_id='" . quote_smart($passport_group_id) . "'");
if($result = $dbh_user_passport_groups->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);
}
