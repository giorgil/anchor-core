<?php namespace Anchor\Services;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Ship\Collection;

class Registry {

	protected $entities = array();

	protected static $instance;

	public static function __callStatic($method, $arguments) {
		return call_user_func_array(array(static::instance(), $method), $arguments);
	}

	public static function instance() {
		if(is_null(static::$instance)) {
			static::$instance = new Collection;
		}

		return static::$instance;
	}

	public static function puts($values) {
		foreach($values as $key => $value) {
			static::instance()->put($key, $value);
		}
	}

}