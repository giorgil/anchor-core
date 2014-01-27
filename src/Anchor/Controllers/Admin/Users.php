<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Users extends Base {

	protected $users;
	protected $auth;
	protected $input;
	protected $pages;
	protected $messages;
	protected $csrf;
	protected $response;
	protected $uri;
	protected $nav;
	protected $lang;

	public function __construct(\Anchor\Mappers\Users $users,
								\Anchor\Services\Auth $auth,
								\Anchor\Services\Messages $messages,
								\Anchor\Services\Csrf $csrf,
								\Anchor\Services\Nav $nav,
								\Ship\Input $input,
								\Ship\Http\Response $response,
								\Ship\I18n $lang,
								\Ship\Uri $uri) {
		$this->users = $users;
		$this->auth = $auth;
		$this->input = $input;
		$this->messages = $messages;
		$this->csrf = $csrf;
		$this->response = $response;
		$this->uri = $uri;
		$this->nav = $nav;
		$this->lang = $lang;
	}

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

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();
		$vars['action'] = $this->uri->to('admin/login/attempt');
		$vars['user'] = '';

		return $this->getCommonView('login.phtml', $vars)->render();
	}

	public function attempt() {
		$attempt = $this->auth->attempt(
			$this->input->filter('user', '', FILTER_SANITIZE_STRING),
			$this->input->get('pass')
		);

		if( ! $attempt) {
			$this->messages->error('Invalid Login Details');

			return $this->response->redirect($this->uri->to('admin/login'));
		}

		return $this->response->redirect($this->uri->to('admin/posts'));
	}

}