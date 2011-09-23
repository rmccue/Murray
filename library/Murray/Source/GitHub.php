<?php

class Murray_Source_GitHub implements Murray_Source {
	public function __construct($user) {
		$this->user = $user;

		Murray_Sources::register('github', $this);
	}

	public function update() {
		$feed = new SimplePie();
		$feed->set_feed_url('https://github.com/' . $this->user . '.atom');
		$feed->enable_cache(false);
		$feed->set_stupidly_fast(true);
		$feed->init();

		foreach ($feed->get_items() as $item) {
			$id = $item->get_id();
			$title = substr($item->get_title(), strlen($this->user) + 1);
			$title = sprintf('<a href="%s">%s</a>', $item->get_permalink(), $title);
			$data = array(
				'id' => $id,
				'title' => $title,
				'content' => $item->get_content(),
				'source' => 'github',
				'timestamp' => $item->get_date('U')
			);

			/*$type = substr($id, 20, strpos($id, '/'));
			switch ($type) {
				case 'PushEvent':
				case 'IssueCommentEvent':
				case 'PullRequestEvent':
				case 'IssuesEvent':
				default:
					// no-op, standard stuff will work fine
					break;
			}*/
			Murray_Entry::create($data);
		}

	}
}