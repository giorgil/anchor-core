<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Models\Page;
use Ship\Database\Contracts\TableInterface;

class Pages extends Base {

	protected $cached = array();

	protected $table = 'pages';

	protected $meta;

	public function setMeta(TableInterface $meta) {
		$this->meta = $meta;
	}

	public function home() {
		$id = $this->meta->get('home_page');

		if(isset($this->cached[$id])) {
			return $this->cached[$id];
		}

		return $this->cached[$id] = $this->find($id);
	}

	public function posts() {
		$id = $this->meta->get('posts_page');

		if(isset($this->cached[$id])) {
			return $this->cached[$id];
		}

		return $this->cached[$id] = $this->find($id);
	}

	public function create(array $row) {
		return new Page($row);
	}

	public function menuItems() {
		$query = $this->where('status', '=', 'published')
			->where('show_in_menu', '=', '1')
			->order('menu_order', 'asc');

		$results = $this->all($query);
		$results->buffer();

		return $results;
	}

	/**
	 * Publish a page
	 *
	 * @param object
	 * @param object
	 * @param object
	 */
	public function publish($page, $slugify, $markdown) {
		if('' === $page->slug) {
			$page->slug = $slugify->slugify($page->title);
		}

		$page->html = $markdown->parse($page->markdown);

		$this->save($page);
	}

}