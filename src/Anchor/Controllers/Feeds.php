<?php namespace Anchor\Controllers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Services\Registry;

class Feeds extends Base {

	public function rss() {
		return 'rss';
	}

	public function json() {
		return 'json';
	}

}