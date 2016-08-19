<?php
require 'subclasses/flowcharthdr_sst.php';
$sst = new flowcharthdr_sst;
$sst->auto_test('delete');
$sst_script = $sst->script;