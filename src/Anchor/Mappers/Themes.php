<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Themes {

	protected $meta;

	public function __construct($meta) {
		$this->meta = $meta;
	}

	public function active() {
		$active = $this->meta->select('value')
			->where('key', '=', 'theme')
			->column();

		return realpath('themes/' . $active);
	}

}