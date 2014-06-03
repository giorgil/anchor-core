<?php namespace Anchor\Services;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Templates {

	protected $ext;

	public function __construct($theme, $ext = '.php') {
		$this->theme = $theme;
		$this->ext = $ext;
	}

	public function find($name) {
		return $this->theme . '/' . $name . $this->ext;
	}

	public function exists($name) {
		return file_exists($this->theme . '/' . $name . $this->ext);
	}

}