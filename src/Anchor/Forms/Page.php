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

class Page extends Form {

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
				'label' => 'Menu Name'
			), array(
				'placeholder' => 'Name'
			)
		));

		$this->append(new Text('slug',
			array(
				'label' => 'Slug'
			), array(
				'placeholder' => 'Slug'
			)
		));

		$this->append(new Text('redirect',
			array(
				'label' => 'Redirect'
			), array(
				'placeholder' => 'Redirect'
			)
		));

		$this->append(new Select('parent',
			array(
				'label' => 'Parent',
				'default' => 0,
				'options' => array(0 => 'None')
			)
		));

		$this->append(new Textarea('markdown',
			array(
				'label' => 'Markdown'
			), array(
				'spell' => 'off',
				'placeholder' => 'Your pearls of wisdom ...'
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

		$this->append(new Select('show_in_menu',
			array(
				'label' => 'Show in Menu',
				'default' => 0,
				'options' => array_combine(
					array(1, 0),
					array('Yes', 'No')
				),
			)
		));

		$this->append(new Text('menu_order',
			array(
				'label' => 'Menu Order',
				'default' => 0
			)
		));

		$this->append(new Button('save',
			array(
				'label' => 'Save Changes'
			)
		));
	}

}