<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Ship\View;

class Base {

	protected $app;

	public function __construct($app) {
		$this->app = $app;
		$this->viewpath = __DIR__ . '/../../../../views';
	}

	protected function getView($template, array $vars = array()) {
		$view = new View($this->viewpath . '/' . ltrim($template, '/'), $vars);
		$view->setHelper('uri', $this->app['uri']);

		return $view;
	}

	protected function getLayout(array $vars = array()) {
		return $this->getView('layout.phtml', $vars);
	}

	protected function getPartial($template, array $vars = array()) {
		return $this->getView('partials/' . $template, $vars);
	}

	protected function getCommonView($template, array $vars = array()) {
		$layout = $this->getLayout($vars);

		$main = $this->getView($template, $vars);

		$menu = $this->getPartial('menu.phtml');
		$menu->assign('nav', $this->app['nav']);

		$main->nest('menu', $menu);

		$layout->nest('body', $main);

		return $layout;
	}

}