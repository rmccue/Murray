<?php

include(__DIR__ . '/library/Murray.php');

if (isset($_GET['update'])) {
	set_time_limit(0);
	Murray_Sources::update();
	die();
}

$entries = Murray_Entry::get_all();
include(Murray::$path . '/views/index.php');