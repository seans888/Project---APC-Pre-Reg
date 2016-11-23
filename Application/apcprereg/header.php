<?php
require_once 'path.php';
init_cobalt('ALLOW_ALL',FALSE);
require $_SESSION['header'];
$target = 'target="content_frame"'; //menus should target the main content frame called "content_frame".
require 'header_menu.php';