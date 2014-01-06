<?php namespace Anchor\Models;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Ship\Database\Record;

class Page extends Record {

	public function uri() {
		return $this->slug;
	}

	public function content() {
		return $this->html;
	}

}