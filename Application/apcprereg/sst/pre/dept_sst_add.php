<?php
require 'subclasses/dept_sst.php';
$sst = new dept_sst;
$sst->auto_test();
$sst_script = $sst->script;