<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Menu extends Backend {

	public function index() {
		$vars['title'] = 'Menu';
		$vars['pages'] = $this->pages->all($this->pages->where('show_in_menu', '=', 1));

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		return $this->getCommonView('menu/index.phtml', $vars)->render();
	}

}