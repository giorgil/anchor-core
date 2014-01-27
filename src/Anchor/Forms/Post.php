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
use Anchor\Forms\Fields\Button;

class Post extends Form {

	public function __construct() {
		$this->append(new Text('title',
			array(
				'label' => 'Title'
			), array(
				'placeholder' => 'Title'
			)
		));

		$this->append(new Text('name',
			array(
				'label' => 'Name'
			), array(
				'placeholder' => 'Menu Name'
			)
		));

		$this->append(new Text('slug',
			array(
				'label' => 'Slug'
			), array(
				'placeholder' => 'Slug'
			)
		));

		$this->append(new Textarea('markdown',
			array(
				'label' => 'Markdown'
			), array(
				'spell' => 'off'
			)
		));

		$this->append(new Select('status',
			array(
				'label' => 'Status',
				'options' => array_combine(
					array('published', 'draft', 'archived'),
					array('Published', 'Draft', 'Archived')
				),
			)
		));

		$this->append(new Button('save',
			array(
				'label' => 'Save Changes'
			)
		));
	}

}