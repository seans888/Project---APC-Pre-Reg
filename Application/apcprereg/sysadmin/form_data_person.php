<?php
require 'components/get_listview_referrer.php';

require 'subclasses/person.php';
$dbh_person = new person;
$dbh_person->set_where("person_id='" . quote_smart($person_id) . "'");
if($result = $dbh_person->make_query()->result)
{
    $data = $result->fetch_assoc();
    extract($data);
}
