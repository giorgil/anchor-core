<?php namespace Anchor\Controllers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Services\Rss;

class Feeds extends Frontend {

	public function rss() {
		$rss = new Rss(
			$this->meta->get('sitename'),
			$this->meta->get('description'),
			$this->uri->to('/'),
			$this->config->get('app.lang')
		);

		$page = $this->pages->posts();

		foreach($this->posts->published() as $post) {
			$url = $this->uri->to($page->uri().'/'.$post->uri());

			$rss->item($post->title, $url, $post->html, $post->created);
		}

		return $this->response->setHeader('content-type', 'application/xml')
			->setBody($rss->output());
	}

	public function json() {
		$data = array();

		$page = $this->pages->posts();

		foreach($this->posts->published() as $post) {
			$url = $this->uri->to($page->uri().'/'.$post->uri());

			$data[] = array(
				'title' => $post->title,
				'link' => $url,
				'html' => $post->html,
				'date' => $post->created
			);
		}

		$json = json_encode($data);

		return $this->response->setHeader('content-type', 'application/json')
			->setBody($json);
	}

}