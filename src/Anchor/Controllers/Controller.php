<?php namespace Anchor\Controllers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use RuntimeException;

abstract class Controller {

	protected $container;

	public function __get($property) {
		return $this->container[$property];
	}

	public function setContainer($container) {
		$this->container = $container;
	}

	public function getContainer() {
		return $this->container;
	}

}