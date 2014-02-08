<?php namespace Anchor\Models;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Ship\Database\Record;

class User extends Record {

	protected $fields = array(
		'id',
		'username',
		'password',
		'email',
		'real_name',
		'bio',
		'status',
		'role',
	);

	protected $guarded = array(
		'password',
	);

}