<?php
require 'path.php';
init_cobalt();
require 'subclasses/refstudent_doc.php';
$obj_doc = new refstudent_doc;
$obj_doc->auto_doc();