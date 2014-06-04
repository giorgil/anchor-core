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

abstract class Frontend extends Controller {

	protected function getSlug() {
		return substr(strrchr($this->request->getUri(), '/'), 1);
	}

	protected function getCurrentPage() {
		if($this->request->getUri() == '/') {
			return $this->pages->home();
		}

		$slug = $this->getSlug();
		$query = $this->pages->where('slug', '=', $slug);

		if($page = $this->pages->fetch($query)) {
			return $page;
		}

		throw new HttpNotFound(sprintf('Page "%s" not found', $slug));
	}

	protected function getTemplate($name, $slug = '') {
		if(strlen($slug) and $this->templates->exists($name . '-' . $slug)) {
			return $this->templates->find($name . '-' . $slug);
		}

		if($this->templates->exists($name)) {
			return $this->templates->find($name);
		}

		throw new ErrorException('Template not found');
	}

	protected function getLayout($name) {
		if($this->templates->exists('layout-' . $name)) {
			return $this->templates->find('layout-' . $name);
		}

		if($this->templates->exists('layout')) {
			return $this->templates->find('layout');
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

	public function notFound($title = 'Not Found') {
		$page = $this->pages->home();
		$this->registry->put('page', $page);

		return $this->renderTemplate('404', '', array('message' => $title));
	}

}