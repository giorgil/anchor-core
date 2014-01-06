<?php namespace Anchor\Controllers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Services\Registry;

class Page extends Base {

	public function index() {
		$page = $this->getCurrentPage();

		Registry::puts(array(
			'Page' => $page,
		));

		return $this->renderTemplate('page', $page->slug);
	}

}