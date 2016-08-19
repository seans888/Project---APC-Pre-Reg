<?php
require 'subclasses/flowchartdtl_sst.php';
$sst = new flowchartdtl_sst;
$sst->auto_test('delete');
$sst_script = $sst->script;