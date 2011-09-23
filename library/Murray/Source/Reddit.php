<?php

class Murray_Source_Reddit implements Murray_Source {
	public function __construct($user) {
		$this->user = $user;

		Murray_Sources::register('reddit', $this);
	}

	public function update() {
		$this->update_from_feed('http://www.reddit.com/user/' . $this->user . '/comments/.rss', 'commented on <a href="%s">%s</a>', strlen($this->user) + 4);
		$this->update_from_feed('http://www.reddit.com/user/' . $this->user . '/submitted/.rss', 'submitted <a href="%s">%s</a>');
	}

	protected function update_from_feed($url, $title_format, $title_start = 0) {
		$feed = new SimplePie();
		$feed->set_feed_url($url);
		$feed->enable_cache(false);
		$feed->set_stupidly_fast(true);
		$feed->init();

		foreach ($feed->get_items() as $item) {
			$title = substr($item->get_title(), $title_start);
			$title = sprintf($title_format, $item->get_permalink(), $title);
			$data = array(
				'id' => $item->get_id(),
				'title' => $title,
				'content' => '',
				'source' => 'reddit',
				'timestamp' => $item->get_date('U')
			);

			Murray_Entry::create($data);
		}
	}
}