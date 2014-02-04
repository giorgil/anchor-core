<?php namespace Anchor\Services;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class I18n {

	public function __construct($lang, $path = null) {
		$this->setLang($lang);
		$this->path = $path;
	}

	public function setLang($lang) {
		$this->lang = $lang;
	}

}