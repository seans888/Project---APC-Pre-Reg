<?php
require 'path.php';
init_cobalt();
require 'subclasses/addsubject_doc.php';
$obj_doc = new addsubject_doc;
$obj_doc->auto_doc();