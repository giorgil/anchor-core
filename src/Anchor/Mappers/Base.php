<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Closure;
use Ship\Database\Table;

class Base extends Table {

	protected $iterator;

	public function loop(Closure $callback) {
		if(is_null($this->iterator)) {
			$this->iterator = $this->all()->getIterator();
		}

		if($this->iterator->valid()) {
			$callback($this->iterator->current());
			$this->iterator->next();
			return true;
		}

		$this->iterator = null;

		return false;
	}

	public function create($row) {
		return $row;
	}

}