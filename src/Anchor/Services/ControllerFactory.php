<?php namespace Anchor\Services;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class ControllerFactory {

	protected function className($class) {
		return ucfirst($class);
	}

	public function frontend($class, $container) {
		$class = '\\Anchor\\Controllers\\'.$this->className($class);

		$controller = new $class;
		$controller->setContainer($container);

		return $controller;
	}

	public function backend($class, $container) {
		$class = '\\Anchor\\Controllers\\Admin\\'.$this->className($class);

		$controller = new $class;
		$controller->setContainer($container);

		$controller->setViewPath(__DIR__ . '/../../../views');

		return $controller;
	}

}