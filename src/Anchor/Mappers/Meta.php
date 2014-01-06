<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Meta extends Base {

	protected $cached = array();

	protected $table = 'meta';

	public function get($key) {
		if(isset($this->cached[$key])) {
			return $this->cached[$key];
		}

		return $this->cached[$key] = $this->query()->select('value')->where('key', '=', $key)->column();
	}

}