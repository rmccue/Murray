<?php

class Murray_Entry {
	public $id;
	public $title;
	public $content;
	public $source;
	public $timestamp;

	public function __construct() {
	}

	public function get_source() {
		return Murray_Sources::get($this->source);
	}

	/**
	 * Create a new entry
	 *
	 * @param array $data
	 * @return Murray_Entry
	 */
	public static function create($data) {
		$stmt = Murray::$db->prepare('REPLACE INTO entries (id, title, content, source, timestamp) VALUES(:id, :title, :content, :source, :timestamp)');
		$stmt->bindValue(':id', $data['id']);
		$stmt->bindValue(':title', $data['title']);
		$stmt->bindValue(':content', $data['content']);
		$stmt->bindValue(':source', $data['source']);
		$stmt->bindValue(':timestamp', $data['timestamp']);
		$stmt->execute();

		//var_dump($stmt->errorInfo());
		return Murray_Entry::get((int) Murray::$db->lastInsertId());
	}

	/**
	 * Get an entry
	 *
	 * @param int $id
	 * @return Murray_Entry
	 */
	public static function get($id) {
		$stmt = Murray::$db->prepare('SELECT id, title, content, source, timestamp FROM entries WHERE id = :id LIMIT 1');
		$stmt->bindValue(':id', $id);
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_class());
		$stmt->execute();
		return $stmt->fetch();
	}

	/**
	 * Get all entries
	 *
	 * @return array
	 */
	public static function get_all($start = 0, $limit = 100) {
		$sql = sprintf('SELECT id, title, content, source, timestamp FROM entries ORDER BY timestamp DESC LIMIT %u OFFSET %u', $limit, $start);
		$stmt = Murray::$db->prepare($sql);
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_class());
		$stmt->execute();
		return $stmt->fetchAll();
	}
}