<?php
require 'subclasses/refsubjectofferingdtl_sst.php';
$sst = new refsubjectofferingdtl_sst;
$sst->auto_test('delete');
$sst_script = $sst->script;