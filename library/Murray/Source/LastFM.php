<?php

class Murray_Source_LastFM implements Murray_Source {
	public function __construct($user) {
		$this->user = $user;

		Murray_Sources::register('lastfm', $this);
	}

	public function update() {
		$feed = new SimplePie();
		$feed->set_feed_url('http://ws.audioscrobbler.com/1.0/user/' . $this->user . '/recenttracks.rss');
		$feed->enable_cache(false);
		$feed->set_stupidly_fast(true);
		$feed->init();

		foreach ($feed->get_items() as $item) {
			$title = sprintf('listened to <a href="%s">%s</a>', $item->get_permalink(), $item->get_title());
			$data = array(
				'id' => $item->get_id(),
				'title' => $title,
				'content' => '',
				'source' => 'lastfm',
				'timestamp' => $item->get_date('U')
			);

			Murray_Entry::create($data);
		}


	}
}