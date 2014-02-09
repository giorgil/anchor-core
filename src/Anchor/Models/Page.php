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

class Page extends Record implements Validatable {

	protected $fields = array(
		'id',
		'parent',
		'slug',
		'name',
		'title',
		'markdown',
		'html',
		'status',
		'redirect',
		'show_in_menu',
		'menu_order',
	);

	public function uri() {
		return $this->slug;
	}

	public function content() {
		return $this->html;
	}

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