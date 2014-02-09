<?php namespace Anchor\Services;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class MapperFactory {

	protected function className($class) {
		return ucfirst($class);
	}

	public function create($class, $container) {
		$class = '\\Anchor\\Mappers\\'.$this->className($class);

		$controller = new $class;
		$controller->setContainer($container);

		return $controller;
	}

}