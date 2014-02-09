<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Models\User;
use Anchor\Services\Validator;
use Anchor\Forms\User as UserForm;
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

	public function create() {
		$form = new UserForm;
		$form->setAttr('action', $this->uri->to('admin/users/store'));
		$form->setAttr('method', 'POST');
		$form->setAttr('autocomplete', 'off');

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Create User';
		$vars['users'] = $this->users->all();
		$vars['form'] = $form;

		return $this->getCommonView('users/create.phtml', $vars)->render();
	}

	public function store() {
		$user = new User;
		$validator = new Validator;

		$user->hydrate($this->input->getArrayCopy());

		$validator->validate($user);

		if( ! $validator->isValid()) {
			//$this->session->flash($this->input->getArrayCopy());

			$this->messages->add('error', $validator->getMessages());

			return $this->response->redirect($this->uri->to('admin/users/create'));
		}

		if('' !== $user->password) {
			$user->password = password_hash($user->password, PASSWORD_DEFAULT);
		}

		$this->users->save($user);

		$this->messages->info('User created');

		return $this->response->redirect($this->uri->to('admin/users/'.$user->id.'/edit'));
	}

	public function edit($request, $route) {
		$params = $route->getParams();
		$id = $params[0];

		$user = $this->users->find($id);

		if(null === $user) {
			$this->messages->error('User not found');

			return $this->response->redirect($this->uri->to('admin/users'));
		}

		$form = new UserForm;
		$form->setAttr('action', $this->uri->to('admin/users/'.$user->id.'/update'));
		$form->setAttr('method', 'POST');
		$form->setAttr('autocomplete', 'off');
		$form->setValues($user->toArray());

		$password = $form->getElement('password');
		$password->setName('change_password');
		$password->setLabel('Change Password');

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Editing &ldquo;' . $user->real_name . '&rdquo;';
		$vars['user'] = $user;
		$vars['users'] = $this->users->all();
		$vars['form'] = $form;

		return $this->getCommonView('users/edit.phtml', $vars)->render();
	}

	public function update($request, $route) {
		$params = $route->getParams();
		$id = $params[0];

		$user = $this->users->find($id);

		if(null === $user) {
			$this->messages->error('User not found');

			return $this->response->redirect($this->uri->to('admin/users'));
		}

		// validate form input
		$validator = new Validator;

		$user->hydrate($this->input->getArrayCopy());

		$validator->validate($user);

		if( ! $validator->isValid()) {
			//$this->session->flash($this->input->getArrayCopy());

			$this->messages->add('error', $validator->getMessages());

			return $this->response->redirect($this->uri->to('admin/users/'.$user->id.'/edit'));
		}

		$this->users->save($user);

		$this->messages->info('User updated');

		return $this->response->redirect($this->uri->to('admin/users/'.$user->id.'/edit'));
	}

	public function destroy() {
		$params = $route->getParams();
		$id = $params[0];

		$user = $this->users->find($id);

		if(null === $user) {
			$this->messages->error('User not found');

			return $this->response->redirect($this->uri->to('admin/users'));
		}

		$this->messages->info('User deleted');

		return $this->response->redirect($this->uri->to('admin/users'));
	}

}