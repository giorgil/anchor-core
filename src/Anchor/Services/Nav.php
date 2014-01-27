<?php namespace Anchor\Services;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use ArrayIterator;
use IteratorAggregate;

class Nav implements IteratorAggregate {

	private $items = array();

	private $uri;

	private $active;

	private $prefix;

	public function __construct($uri) {
		$this->uri = $uri;
	}

	public function add($title, $uri, $class = '') {
		$item = new \StdClass;
		$item->title = $title;
		$item->class = $class;
		$item->uri = $this->uri->to($this->prefix.'/'.$uri);
		$item->active = preg_match('#' . $this->prefix.'/'.$uri . '#', $this->active) > 0;
		$this->items[] = $item;
	}

	public function getIterator() {
		return new ArrayIterator($this->items);
	}

	public function setPrefix($prefix) {
		$this->prefix = '/' . trim($prefix, '/');

		return $this;
	}

	public function setActive($uri) {
		$this->active = $uri;

		return $this;
	}

}