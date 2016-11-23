<?php
require 'path.php';
init_cobalt();
require 'subclasses/reftermperiod_doc.php';
$obj_doc = new reftermperiod_doc;
$obj_doc->auto_doc();