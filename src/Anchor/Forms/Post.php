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

class Post extends Form {

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

		$this->append(new Textarea('markdown',
			array(
				'label' => 'Markdown'
			), array(
				'spell' => 'off',
				'placeholder' => 'Your pearls of wisdom ...'
			)
		));

		$this->append(new Text('created',
			array(
				'label' => 'Created',
				'default' => date('Y-m-d H:i:s')
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

		$this->append(new Select('category',
			array(
				'label' => 'Status',
				'options' => array('Empty'),
			)
		));

		$this->append(new Select('comments',
			array(
				'label' => 'Allow Comments',
				'options' => array_combine(
					array(0, 1),
					array('Yes', 'No')
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