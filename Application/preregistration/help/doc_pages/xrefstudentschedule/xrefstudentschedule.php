<?php
require 'path.php';
init_cobalt();
require 'subclasses/xrefstudentschedule_doc.php';
$obj_doc = new xrefstudentschedule_doc;
$obj_doc->auto_doc();