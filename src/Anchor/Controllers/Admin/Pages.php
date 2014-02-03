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
		$page = $this->input->filter('page', 1, FILTER_SANITIZE_NUMBER_INT);
		$offset = ($page - 1) * $perpage;

		// @todo: check for page overflow
		// @todo: check if category exists

		$vars['pages'] = $this->pages->all($this->pages->skip($offset)->take($perpage));
		$vars['title'] = 'Pages';

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		return $this->getCommonView('pages/index.phtml', $vars)->render();
	}

	public function create() {
		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Create Page';
		$vars['statuses'] = array('published', 'draft', 'archived');

		return $this->getCommonView('pages/create.phtml', $vars)->render();
	}

	public function store() {
		$page = new Page;

		// filter and validate
		$values = array();

		$page->exchangeArray($values);

		$this->pages->save($page);

		return $this->response->redirect($this->uri->to('admin/pages'));
	}

	public function show() {}

	public function edit($request, $route) {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		// find post
		$page = $this->pages->where('id', '=', $id)->fetch();

		if(null === $page) {
			$this->messages->error('Page not found');

			return $this->response->redirect($this->uri->to('admin/pages'));
		}

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

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
		$page = $this->pages->where('id', '=', $id)->fetch();

		if(null === $page) {
			$this->messages->error('Page not found');

			return $this->response->redirect($this->uri->to('admin/pages'));
		}

		$this->messages->info('Page updated');

		return $this->response->redirect($this->uri->to('admin/pages'));
	}

	public function destroy() {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		$this->messages->info('Page deleted');

		return $this->response->redirect($this->uri->to('admin/pages'));
	}

}