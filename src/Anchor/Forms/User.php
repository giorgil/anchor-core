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
use Anchor\Forms\Fields\Password;
use Anchor\Forms\Fields\Button;

class User extends Form {

	public function __construct() {
		$this->append(new Text('username',
			array(
				'label' => 'Username'
			), array(
				'placeholder' => 'Username'
			)
		));

		$this->append(new Password('password',
			array(
				'label' => 'Password'
			), array(
				'placeholder' => 'A strong password'
			)
		));

		$this->append(new Text('email',
			array(
				'label' => 'Email'
			), array(
				'placeholder' => 'Email address'
			)
		));

		$this->append(new Text('real_name',
			array(
				'label' => 'Name'
			), array(
				'placeholder' => 'Your Name'
			)
		));

		$this->append(new Textarea('bio',
			array(
				'label' => 'About'
			), array(
				'placeholder' => 'Some words about this user'
			)
		));

		$this->append(new Select('status',
			array(
				'label' => 'status',
				'options' => array(
					'active' => 'Active'
				)
			)
		));

		$this->append(new Select('role',
			array(
				'label' => 'Role',
				'options' => array(
					'admin' => 'Admin'
				)
			)
		));

		$this->append(new Button('save',
			array(
				'label' => 'Save Changes'
			)
		));
	}

}