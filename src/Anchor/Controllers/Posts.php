<?php namespace Anchor\Controllers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use ArrayIterator;
use OutOfBoundsException;

class Posts extends Frontend {

	public function index() {
		// Pagination
		$perpage = $this->meta->get('posts_per_page', 10);
		$page = $this->input->filter('page', 1, FILTER_SANITIZE_NUMBER_INT);
		$offset = ($page - 1) * $perpage;

		$postCount = $this->posts->count();
		$pages = ceil($postCount / $perpage);

		if($page < 1 or $page > $pages) {
			throw new OutOfBoundsException(sprintf('Page number out of range "%s"', $page));
		}

		// Save data in registry for theme functions
		$this->registry->put('post_next_page', ($page < $pages ? $page + 1 : 0));
		$this->registry->put('post_prev_page', ($page > 1 ? $page - 1 : 0));

		// Query posts
		$query = $this->posts
			->where('status', '=', 'published')
			->order('created', 'desc')
			->skip($offset)
			->take($perpage);

		$collection = $this->posts->all($query);
		$collection->buffer();

		// Get relationships
		$keys = $collection->toColumn('category');
		$query = $this->categories->whereIn('id', array_unique($keys));
		$collection->relate($this->categories->all($query), 'id', 'category');

		$keys = $collection->toColumn('author');
		$query = $this->users->whereIn('id', array_unique($keys));
		$collection->relate($this->users->all($query), 'id', 'author');

		// Set posts
		$this->posts->setResults($collection);

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