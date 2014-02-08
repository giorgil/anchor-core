<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Forms\Login as LoginForm;

class Users extends Backend {

	public function index() {
		$vars['title'] = 'Users';
		$vars['users'] = $this->users->all();

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		return $this->getCommonView('users/index.phtml', $vars)->render();
	}

	public function login() {
		// redirect valid sessions
		if( ! $this->auth->guest()) {
			return $this->response->redirect($this->uri->to('admin/posts'));
		}

		$form = new LoginForm;
		$form->setAttr('method', 'post');
		$form->setAttr('action', $this->uri->to('admin/login/attempt'));

		$form->setValue('token', $this->csrf->token());

		if($this->session->has('_prev_input')) {
			$form->setValues($this->session->get('_prev_input'));
			$this->session->remove('_prev_input');
		}

		$vars['messages'] = $this->messages->render();
		$vars['title'] = 'Login';
		$vars['class'] = 'login';
		$vars['form'] = $form;

		return $this->getCommonView('login.phtml', $vars)->render();
	}

	public function attempt() {
		$attempt = $this->auth->attempt(
			$this->input->filter('user', '', FILTER_SANITIZE_STRING),
			$this->input->get('pass')
		);

		if( ! $attempt) {
			$this->messages->error('Invalid Login Details');

			$this->session->put('_prev_input', array(
				'user' => $this->input->filter('user', '', FILTER_SANITIZE_STRING)
			));

			return $this->response->redirect($this->uri->to('admin/login'));
		}

		return $this->response->redirect($this->uri->to('admin/posts'));
	}

}