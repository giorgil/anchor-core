<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Plugins extends Backend {

	public function index() {
		$vars['title'] = 'Plugins';
		$vars['plugins'] = array();

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		return $this->getCommonView('plugins/index.phtml', $vars)->render();
	}

}