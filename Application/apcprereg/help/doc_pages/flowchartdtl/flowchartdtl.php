<?php
require 'path.php';
init_cobalt();
require 'subclasses/flowchartdtl_doc.php';
$obj_doc = new flowchartdtl_doc;
$obj_doc->auto_doc();