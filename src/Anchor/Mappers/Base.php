<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Closure;
use Iterator;

use Ship\Database\Table;

class Base extends Table {

	protected $results;

	public function setResults(Iterator $results) {
		$this->results = $results;
	}

	public function loop(Closure $callback) {
		if(null === $this->results) {
			$this->results = new \ArrayIterator($this->all());
		}

		if($this->results->valid()) {
			$callback($this->results->current());

			$this->results->next();

			return true;
		}

		$this->results->rewind();

		return false;
	}

	public function create($row) {
		return $row;
	}

}