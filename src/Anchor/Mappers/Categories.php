<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use ArrayObject;
use Anchor\Models\Category;

class Categories extends Base {

	protected $table = 'categories';

	public function create(array $row) {
		return new Category($row);
	}

}