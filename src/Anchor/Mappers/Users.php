<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use ArrayObject;
use Anchor\Models\User;

class Users extends Base {

	protected $table = 'users';

	public function create($row) {
		$record = get_object_vars($row);

		return new User(new ArrayObject($record));
	}

}