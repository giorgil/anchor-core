<?php namespace Anchor\Models;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Ship\Database\Record;
use Anchor\Services\Validator;
use Anchor\Services\Contracts\Validatable;

class User extends Record implements Validatable {

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

	public function getValidationRules(Validator $validator) {
		$validator->addRule('username', function($value, &$message) {
			if('' === $value) {
				$message = 'Please enter a username';
				return false;
			}

			return true;
		});
	}

}