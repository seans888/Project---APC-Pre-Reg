<?php
require 'subclasses/term_sst.php';
$sst = new term_sst;
$sst->auto_test('delete');
$sst_script = $sst->script;