<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Models\Page;

class Pages extends Base {

	public function index() {
		$perpage = 10;
		$page = $this->app['input']->filter('page', 1, FILTER_SANITIZE_NUMBER_INT);
		$offset = ($page - 1) * $perpage;

		// @todo: check for page overflow
		// @todo: check if category exists

		$vars['pages'] = $this->app['pages']->skip($offset)->take($perpage)->all();
		$vars['title'] = 'Pages';

		$vars['messages'] = $this->app['messages']->render();
		$vars['token'] = $this->app['csrf']->token();

		return $this->getCommonView('pages/index.phtml', $vars)->render();
	}

	public function create() {
		$vars['messages'] = $this->app['messages']->render();
		$vars['token'] = $this->app['csrf']->token();

		$vars['title'] = 'Create Page';
		$vars['statuses'] = array('published', 'draft', 'archived');

		return $this->getCommonView('pages/create.phtml', $vars)->render();
	}

	public function store() {
		$page = new Page;

		// filter and validate
		$values = array();

		$page->exchangeArray($values);

		$this->app['pages']->save($page);

		return $this->app['response']->redirect($this->app['uri']->to('admin/pages'));
	}

	public function show() {}

	public function edit($request, $route) {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		// find post
		$page = $this->app['pages']->where('id', '=', $id)->fetch();

		if(null === $page) {
			$this->app['messages']->error('Page not found');

			return $this->app['response']->redirect($this->app['uri']->to('admin/pages'));
		}

		$vars['messages'] = $this->app['messages']->render();
		$vars['token'] = $this->app['csrf']->token();

		$vars['title'] = 'Editing &ldquo;' . $page->title . '&rdquo;';
		$vars['page'] = $page;
		$vars['statuses'] = array('published', 'draft', 'archived');

		return $this->getCommonView('pages/edit.phtml', $vars)->render();
	}

	public function update($request, $route) {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		// find post
		$page = $app['pages']->where('id', '=', $id)->fetch();

		if(null === $page) {
			$app['messages']->error('Page not found');

			return $app['response']->redirect($app['uri']->to('admin/pages'));
		}

		$app['messages']->info('Page updated');

		return $this->app['response']->redirect($this->app['uri']->to('admin/pages'));
	}

	public function destroy() {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		$this->app['messages']->info('Page deleted');

		return $this->app['response']->redirect($this->app['uri']->to('admin/pages'));
	}

}