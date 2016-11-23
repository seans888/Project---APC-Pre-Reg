<?php
require 'subclasses/addsubject_sst.php';
$sst = new addsubject_sst;
$sst->auto_test();
$sst_script = $sst->script;