<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Ship\View;

class Base {

	protected $viewpath;

	protected $nav;
	protected $uri;
	protected $lang;

	public function __construct(\Anchor\Services\Nav $nav,
								\Ship\I18n $lang,
								\Ship\Uri $uri) {
		$this->nav = $nav;
		$this->lang = $lang;
		$this->uri = $uri;
	}

	public function getViewPath() {
		return $this->viewpath;
	}

	public function setViewPath($path) {
		$this->viewpath = realpath($path);
	}

	protected function getView($template, array $vars = array()) {
		$view = new View($this->getViewPath() . '/' . ltrim($template, '/'), $vars);
		$view->setHelper('lang', $this->lang);
		$view->setHelper('uri', $this->uri);

		return $view;
	}

	protected function getLayout(array $vars = array()) {
		return $this->getView('layout.phtml', $vars);
	}

	protected function getPartial($template, array $vars = array()) {
		return $this->getView('partials/' . $template, $vars);
	}

	protected function getCommonView($template, array $vars = array()) {
		if( ! isset($vars['title'])) {
			$vars['title'] = 'Untitled';
		}

		$menu = $this->getPartial('menu.phtml');
		$menu->assign('nav', $this->nav);

		$main = $this->getView($template, $vars);
		$main->nest('menu', $menu);

		return $this->getLayout($vars)->nest('body', $main);
	}

}