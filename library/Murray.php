<?php

class Murray {
	public static $db;
	public static $path;
	public static $url;

	public static function autoload($class) {
		$name = str_replace('_', '/', $class);
		if (file_exists(Murray::$path . '/library/' . $name . '.php')) {
			require_once(Murray::$path . '/library/' . $name . '.php');
		}
	}

	public static function config() {
		var_dump(json_decode(file_get_contents(Murray::$path . '/config.json')));
	}
}

date_default_timezone_set('UTC');
spl_autoload_register(array('Murray', 'autoload'));
Murray::$path = dirname(__DIR__);

require_once(Murray::$path . '/config.php');