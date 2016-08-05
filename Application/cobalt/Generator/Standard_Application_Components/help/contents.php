<?php
require_once 'path.php';
init_cobalt();

require 'pages.php';
$arr_pages = array();
foreach($content_pages as $subclass=>$dir_name)
{
    //We need to get the readable names
    require_once 'subclasses/' . $subclass . '.php';
    $obj_doc = new $subclass;

    $arr_pages[$obj_doc->readable_name] = $dir_name;
}

require_once 'documentation_class.php';
$obj_doc = new documentation();
$obj_doc->create_table_of_contents($arr_pages);