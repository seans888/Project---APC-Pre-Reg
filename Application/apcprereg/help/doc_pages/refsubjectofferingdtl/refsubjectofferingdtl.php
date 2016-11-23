<?php
require 'path.php';
init_cobalt();
require 'subclasses/refsubjectofferingdtl_doc.php';
$obj_doc = new refsubjectofferingdtl_doc;
$obj_doc->auto_doc();