<?php
require 'path.php';
init_cobalt();
require 'subclasses/xrefstudentcourse_doc.php';
$obj_doc = new xrefstudentcourse_doc;
$obj_doc->auto_doc();