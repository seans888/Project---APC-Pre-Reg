<?php
require 'subclasses/xrefstudentcourse_sst.php';
$sst = new xrefstudentcourse_sst;
$sst->auto_test('detail_view');
$sst_script = $sst->script;