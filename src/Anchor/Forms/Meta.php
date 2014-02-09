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

class Meta extends Form {

	public function __construct() {
		$this->append(new Text('sitename',
			array(
				'label' => 'Site Name'
			), array(
				'placeholder' => 'My Blog'
			)
		));

		$this->append(new Text('description',
			array(
				'label' => 'Site Description'
			), array(
				'placeholder' => 'It’s not just any blog. It’s an Anchor blog.'
			)
		));

		$this->append(new Button('save',
			array(
				'label' => 'Save Changes'
			)
		));
	}

}