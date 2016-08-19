<?php
require 'subclasses/course_sst.php';
$sst = new course_sst;
$sst->auto_test();
$sst_script = $sst->script;