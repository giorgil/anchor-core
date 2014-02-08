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

class Post extends Record implements Validatable {

	protected $categoryModel;

	protected $userModel;

	protected $fields = array(
		'id',
		'title',
		'slug',
		'markdown',
		'html',
		'created',
		'author',
		'category',
		'status',
		'comments',
	);

	public function uri() {
		return $this->slug;
	}

	public function content() {
		return $this->html;
	}

	public function setCategory($category) {
		$this->categoryModel = $category;
	}

	public function getCategory() {
		return $this->categoryModel;
	}

	public function setAuthor($user) {
		$this->userModel = $user;
	}

	public function getAuthor() {
		return $this->userModel;
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