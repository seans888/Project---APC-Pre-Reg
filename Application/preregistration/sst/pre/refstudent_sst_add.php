<?php
require 'subclasses/refstudent_sst.php';
$sst = new refstudent_sst;
$sst->auto_test();
$sst_script = $sst->script;