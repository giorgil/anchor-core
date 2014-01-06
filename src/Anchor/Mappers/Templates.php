<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Ship\View;

class Templates {

	public function __construct($theme) {
		$this->theme = $theme;
	}

	public function find($name) {
		return $this->theme . '/' . $name . '.php';
	}

	public function exists($name) {
		return file_exists($this->theme . '/' . $name . '.php');
	}

}