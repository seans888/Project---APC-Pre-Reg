<?php
require 'path.php';
init_cobalt();
require 'subclasses/dept_doc.php';
$obj_doc = new dept_doc;
$obj_doc->auto_doc();