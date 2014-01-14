<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Models\Page;

class Pages extends Base {

	protected $input;
	protected $pages;
	protected $messages;
	protected $csrf;
	protected $response;
	protected $uri;
	protected $nav;

	public function __construct(\Anchor\Mappers\Pages $pages,
								\Anchor\Services\Messages $messages,
								\Anchor\Services\Csrf $csrf,
								\Anchor\Services\Nav $nav,
								\Ship\Input $input,
								\Ship\Http\Response $response,
								\Ship\Uri $uri) {
		$this->input = $input;
		$this->pages = $pages;
		$this->messages = $messages;
		$this->csrf = $csrf;
		$this->response = $response;
		$this->uri = $uri;
		$this->nav = $nav;
	}

	public function index() {
		$perpage = 10;
		$page = $this->input->filter('page', 1, FILTER_SANITIZE_NUMBER_INT);
		$offset = ($page - 1) * $perpage;

		// @todo: check for page overflow
		// @todo: check if category exists

		$vars['pages'] = $this->pages->skip($offset)->take($perpage)->all();
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