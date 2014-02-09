<?php namespace Anchor\Controllers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use ArrayIterator;

class Posts extends Frontend {

	public function index() {
		// setup post listings
		$perpage = $this->meta->get('posts_per_page', 10);
		$page = $this->input->filter('page', 1, FILTER_SANITIZE_NUMBER_INT);
		$offset = ($page - 1) * $perpage;

		$query = $this->posts->where('status', '=', 'published')
			->order('created', 'desc')->skip($offset)->take($perpage);

		$results = new ArrayIterator($this->posts->all($query));

		$this->posts->setResults($results);

		// get current page
		$page = $this->getCurrentPage();

		$this->registry->put('page', $page);

		return $this->renderTemplate('posts', $page->slug);
	}

	public function category() {
		$page = $this->getCurrentPage();

		$this->registry->put('page', $page);

		return $this->renderTemplate('posts', $page->slug);
	}

}