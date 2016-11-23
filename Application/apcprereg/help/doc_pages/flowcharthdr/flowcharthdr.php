<?php
require 'path.php';
init_cobalt();
require 'subclasses/flowcharthdr_doc.php';
$obj_doc = new flowcharthdr_doc;
$obj_doc->auto_doc();