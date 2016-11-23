<?php
require 'path.php';
init_cobalt();
require 'subclasses/term_doc.php';
$obj_doc = new term_doc;
$obj_doc->auto_doc();