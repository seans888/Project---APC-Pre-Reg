<?php
require 'path.php';
init_cobalt('View cobalt sst');

if(isset($_GET['auto_id']))
{
    $_SESSION['sst'] = array();

    $auto_id = urldecode($_GET['auto_id']);
    require 'form_data_cobalt_sst.php';
    require 'config/' . $config_file;

    $_SESSION['sst']['enabled'] = TRUE;
    $_SESSION['sst']['config_file'] = $config_file;

    $location = '/' . BASE_DIRECTORY . '/' . $_SESSION['sst']['tasks'][0]['location'];
    header("location: $location"); //we can't use redirect() here yet, it will end up removing the first task
    exit();
}
else
{
    redirect("listview_sst.php");
}