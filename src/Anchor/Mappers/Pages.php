<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Models\Page;

class Pages extends Base {

	protected $cached = array();

	protected $table = 'pages';

	protected $meta;

	public function __construct($query, $meta) {
		$this->query = $query;
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

	public function create($row) {
		$record = get_object_vars($row);

		return new Page(new \ArrayObject($record));
	}

}