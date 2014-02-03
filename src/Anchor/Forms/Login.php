<?php namespace Anchor\Forms;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Forms\Fields\Text;
use Anchor\Forms\Fields\Hidden;
use Anchor\Forms\Fields\Password;
use Anchor\Forms\Fields\Button;

class Login extends Form {

	public function __construct() {
		$this->append(new Hidden('token'));

		$this->append(new Text('user',
			array(
				'label' => 'Username'
			), array(
				'placeholder' => 'Username',
				'autofocus' => 'autofocus',
			)
		));

		$this->append(new Password('pass',
			array(
				'label' => 'Password'
			), array(
				'placeholder' => 'Password'
			)
		));

		$this->append(new Button('login',
			array(
				'label' => 'Log In'
			), array(
				'class' => 'btn',
				'type' => 'submit'
			)
		));
	}

}