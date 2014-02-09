<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Comments extends Backend {

	public function index() {
		$vars['title'] = 'Comments';
		$vars['comments'] = array();

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		return $this->getCommonView('comments/index.phtml', $vars)->render();
	}

}