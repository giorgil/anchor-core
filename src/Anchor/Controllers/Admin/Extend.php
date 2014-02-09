<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Extend extends Backend {

	public function index() {
		$vars['title'] = 'Extend';

		return $this->getCommonView('extend/index.phtml', $vars)->render();
	}

}