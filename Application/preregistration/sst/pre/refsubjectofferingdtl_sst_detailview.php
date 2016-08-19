<?php
require 'subclasses/refsubjectofferingdtl_sst.php';
$sst = new refsubjectofferingdtl_sst;
$sst->auto_test('detail_view');
$sst_script = $sst->script;