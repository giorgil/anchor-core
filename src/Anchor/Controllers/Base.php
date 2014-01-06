<?php namespace Anchor\Controllers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use ErrorException;

use Ship\View;
use Ship\Exception\HttpNotFound;

use Anchor\Models\Page;
use Anchor\Services\Registry;

class Base {

	protected $app;

	public function __construct($app) {
		$this->app = $app;

		Registry::puts(array(
			'Date' => $this->app['date'],
			'Menu' => $this->app['pages'],
			'Meta' => $this->app['meta'],
			'Uri' => $this->app['uri']
		));
	}

	protected function getCurrentPage() {
		if($this->app['request']->uri() == '/') {
			return $this->app['pages']->home();
		}

		$parts = $this->app['request']->segments();
		$slug = end($parts);

		$page = $this->app['pages']->fetch($this->app['pages']->where('slug', '=', $slug));

		if($page) {
			return $page;
		}

		throw new HttpNotFound('Page not found');
	}

	protected function getTemplate($name, $slug = '') {
		if(strlen($slug) and $this->app['templates']->exists($name . '-' . $slug)) {
			return $this->app['templates']->find($name . '-' . $slug);
		}

		if($this->app['templates']->exists($name)) {
			return $this->app['templates']->find($name);
		}

		throw new ErrorException('Template not found');
	}

	protected function getLayout($name) {
		if($this->app['templates']->exists('layout-' . $name)) {
			return $this->app['templates']->find('layout-' . $name);
		}

		if($this->app['templates']->exists('layout')) {
			return $this->app['templates']->find('layout');
		}
	}

	protected function renderTemplate($name, $slug = '', $vars = array()) {
		// custom template
		$template = $this->getTemplate($name, $slug);

		// use layout wrapper
		if($layout = $this->getLayout($name)) {
			$view = new View($layout, $vars);
			$view->nest('body', new View($template, $vars));
		}
		// normal template
		else {
			$view = new View($template, $vars);
		}

		return $view->render();
	}

	public function notFound($title = 'Resource Not Found') {
		$page = $this->app['pages']->home();

		Registry::puts(array(
			'Page' => $page,
		));

		$html = $this->renderTemplate('404', '', array('message' => $title));

		return $this->app['response']->setStatusCode(404)->setBody($html);
	}

}