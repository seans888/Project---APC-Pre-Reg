<?php
require 'subclasses/xrefstudentschedule_sst.php';
$sst = new xrefstudentschedule_sst;
$sst->auto_test('detail_view');
$sst_script = $sst->script;