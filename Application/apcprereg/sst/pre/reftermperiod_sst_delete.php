<?php
require 'subclasses/reftermperiod_sst.php';
$sst = new reftermperiod_sst;
$sst->auto_test('delete');
$sst_script = $sst->script;