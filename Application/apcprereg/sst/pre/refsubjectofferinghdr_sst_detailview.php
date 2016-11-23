<?php
require 'subclasses/refsubjectofferinghdr_sst.php';
$sst = new refsubjectofferinghdr_sst;
$sst->auto_test('detail_view');
$sst_script = $sst->script;