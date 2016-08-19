<?php
require 'path.php';
init_cobalt();
require 'subclasses/course_doc.php';
$obj_doc = new course_doc;
$obj_doc->auto_doc();