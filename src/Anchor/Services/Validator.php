<?php namespace Anchor\Services;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Closure;
use Anchor\Services\Contracts\Validatable;

class Validator {

	protected $valid = true;

	protected $rules = array();

	protected $messages = array();

	public function validate(Validatable $entity) {
		$entity->getValidationRules($this);

		foreach($this->rules as $field => $callback) {
			$value = isset($entity->$field) ? $entity->$field : null;
			$message = '';

			if( ! $callback($value, $message)) {
				$this->valid = false;
				$this->messages[$field] = $message;
			}
		}
	}

	public function isValid() {
		return $this->valid;
	}

	public function addRule($field, Closure $rule) {
		$this->rules[$field] = $rule;
	}

	public function getMessages() {
		return $this->messages;
	}

}