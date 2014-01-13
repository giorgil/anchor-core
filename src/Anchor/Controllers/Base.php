<?php namespace Anchor\Controllers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use ErrorException;

use Anchor\Models\Page;
use Anchor\Exceptions\HttpNotFound;

use Ship\View;

class Base {

	protected $app;

	public function __construct($app) {
		$this->app = $app;
	}

	protected function getSlug() {
		return substr(strrchr($this->app['request']->getUri(), '/'), 1);
	}

	protected function getCurrentPage() {
		if($this->app['request']->getUri() == '/') {
			return $this->app['pages']->home();
		}

		$slug = $this->getSlug();
		$query = $this->app['pages']->where('slug', '=', $slug);

		if($page = $this->app['pages']->fetch($query)) {
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
		$this->app['registry']->put('page', $page);

		$html = $this->renderTemplate('404', '', array('message' => $title));

		return $this->app['response']->setStatusCode(404)->setBody($html);
	}

}