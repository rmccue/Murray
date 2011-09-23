<?php

class Murray_Source_Twitter implements Murray_Source {
	public function __construct($user) {
		$this->user = $user;

		Murray_Sources::register('twitter', $this);
	}

	public function update() {
		$feed = new SimplePie();
		$feed->set_feed_url('http://api.twitter.com/1/statuses/user_timeline.atom?screen_name=' . $this->user);
		$feed->enable_cache(false);
		$feed->set_stupidly_fast(true);
		$feed->init();

		foreach ($feed->get_items() as $item) {
			$title = substr($item->get_title(), strlen($this->user) + 2);
			$title = sprintf('<blockquote>%s</blockquote>', $title);
			$data = array(
				'id' => $item->get_id(),
				'title' => Twitter_Autolink::create($title)
					->setTarget(false)
					->setExternal(false)
					->addLinks(),
				'content' => '',
				'source' => 'twitter',
				'timestamp' => $item->get_date('U')
			);

			Murray_Entry::create($data);
		}


	}
}