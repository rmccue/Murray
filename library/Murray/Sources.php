<?php

class Murray_Sources {
	protected static $sources;

	public static function load($class, $params = null) {
		new $class($params);
	}

	public static function register($id, Murray_Source &$object) {
		self::$sources[$id] = &$object;
	}

	public static function get($id) {
		if (empty(self::$sources[$id])) {
			return null;
		}

		return self::$sources[$id];
	}

	public static function update() {
		foreach (self::$sources as $source) {
			$result = $source->update();
		}
	}
}