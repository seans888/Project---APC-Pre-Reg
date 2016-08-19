<?php
define('FULLPATH_BASE', dirname(__FILE__) . '/');
$path_to_core = FULLPATH_BASE . 'core';
$require = $path_to_core . '/cobalt_core.php';
$include_path = '.' . PATH_SEPARATOR . $path_to_core;
set_include_path($include_path);
require $require;
unset($require, $path_to_core, $include_path);