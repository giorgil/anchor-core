<?php namespace Anchor\Services\Contracts;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Services\Validator;

interface Validatable {

	public function getValidationRules(Validator $validator);

}