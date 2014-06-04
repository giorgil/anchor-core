<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Meta extends Base {

	protected $data;

	protected $table = 'meta';

	public function get($key) {
		if(null === $this->data) {
			$this->data = $this->all()->toColumn('value', 'key');
		}

		return $this->data[$key];
	}

	public function toArray() {
		return $this->data;
	}

}