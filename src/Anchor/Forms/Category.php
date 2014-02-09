<?php namespace Anchor\Forms;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Forms\Fields\Text;
use Anchor\Forms\Fields\Textarea;
use Anchor\Forms\Fields\Select;
use Anchor\Forms\Fields\Hidden;
use Anchor\Forms\Fields\Button;

class Category extends Form {

	public function __construct() {
		$this->append(new Text('title',
			array(
				'label' => 'Title'
			), array(
				'placeholder' => 'Title'
			)
		));

		$this->append(new Text('slug',
			array(
				'label' => 'Slug'
			), array(
				'placeholder' => 'Slug'
			)
		));

		$this->append(new Textarea('description',
			array(
				'label' => 'Description'
			), array(
				'spell' => 'off',
				'placeholder' => 'Description'
			)
		));

		$this->append(new Button('save',
			array(
				'label' => 'Save Changes'
			)
		));
	}

}