<?php namespace Anchor\Controllers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use RuntimeException;

abstract class Controller {

	protected $dependencies = array();

	protected $container;

	public function __get($property) {
		// try the container if one is set
		if(isset($this->container[$property])) {
			return $this->container[$property];
		}

		// try dependencies if any are set
		if(isset($this->dependencies[$property])) {
			return $this->dependencies[$property];
		}

		throw new RuntimeException(sprintf('Undefined property "%s"', $property));
	}

	public function setDependency($property, $value) {
		$this->dependencies[$property] = $value;
	}

	public function setContainer($container) {
		$this->container = $container;
	}

	public function getContainer() {
		return $this->container;
	}

}