<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Users extends Base {

	public function login() {
		// redirect valid sessions
		if( ! $this->app['auth']->guest()) {
			return $this->app['response']->redirect($this->app['uri']->to('admin/posts'));
		}

		// layout
		$view = $this->getLayout();
		$view->assign('title', 'Login');

		// body
		$vars['messages'] = $this->app['messages']->render();
		$vars['token'] = $this->app['csrf']->token();
		$vars['action'] = $this->app['uri']->to('admin/login/attempt');
		$vars['user'] = '';

		$body = $this->getView('login.phtml', $vars);
		$view->nest('body', $body);

		return $view->render();
	}

	public function attempt() {
		$attempt = $this->app['auth']->attempt(
			$this->app['input']->filter('user', '', FILTER_SANITIZE_STRING),
			$this->app['input']->get('pass')
		);

		if( ! $attempt) {
			$this->app['messages']->error('Invalid Login Details');

			return $this->app['response']->redirect($this->app['uri']->to('admin/login'));
		}

		return $this->app['response']->redirect($this->app['uri']->to('admin/posts'));
	}

}