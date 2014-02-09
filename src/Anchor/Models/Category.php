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

class Category extends Record implements Validatable {

	protected $fields = array(
		'id',
		'title',
		'slug',
		'description',
	);

	public function getValidationRules(Validator $validator) {
		$validator->addRule('title', function($value, &$message) {
			if('' === $value) {
				$message = 'Please enter a title';
				return false;
			}

			return true;
		});
	}

}