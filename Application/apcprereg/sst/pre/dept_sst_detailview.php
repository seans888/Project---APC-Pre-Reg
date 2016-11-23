<?php
require 'subclasses/dept_sst.php';
$sst = new dept_sst;
$sst->auto_test('detail_view');
$sst_script = $sst->script;