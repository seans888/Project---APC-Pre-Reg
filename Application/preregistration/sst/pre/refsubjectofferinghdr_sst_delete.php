<?php
require 'subclasses/refsubjectofferinghdr_sst.php';
$sst = new refsubjectofferinghdr_sst;
$sst->auto_test('delete');
$sst_script = $sst->script;