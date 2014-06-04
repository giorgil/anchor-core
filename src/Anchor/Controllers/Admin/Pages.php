<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Models\Page;
use Anchor\Forms\Page as PageForm;
use Anchor\Services\Validator;

class Pages extends Backend {

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
		$form = new PageForm;
		$form->setAttr('action', $this->uri->to('admin/pages/store'));
		$form->setAttr('method', 'POST');

		$form->setValues($this->session->get('_flash'));
		$this->session->remove('_flash');

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Create Page';
		$vars['pages'] = $this->pages->all();
		$vars['form'] = $form;

		return $this->getCommonView('pages/create.phtml', $vars)->render();
	}

	public function store() {
		$page = new Page;
		$validator = new Validator;

		$page->hydrate($this->input->getArrayCopy());

		$validator->validate($page);

		if( ! $validator->isValid()) {
			$this->session->put('_flash', $this->input->getArrayCopy());

			$this->messages->add('error', $validator->getMessages());

			return $this->response->redirect($this->uri->to('admin/pages/create'));
		}

		$this->pages->publish($page, $this->slugify, $this->markdown);

		$this->messages->info('Page created');

		return $this->response->redirect($this->uri->to('admin/pages/'.$page->id.'/edit'));
	}

	public function edit($request, $route) {
		$id = $route->getParam('id');

		$page = $this->pages->find($id);

		if(null === $page) {
			$this->messages->error('Page not found');

			return $this->response->redirect($this->uri->to('admin/pages'));
		}

		$form = new PageForm;
		$form->setAttr('action', $this->uri->to('admin/pages/'.$page->id.'/update'));
		$form->setAttr('method', 'POST');
		$form->setValues($page->toArray());

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Editing &ldquo;' . $page->title . '&rdquo;';
		$vars['page'] = $page;
		$vars['pages'] = $this->pages->all();
		$vars['form'] = $form;

		return $this->getCommonView('pages/edit.phtml', $vars)->render();
	}

	public function update($request, $route) {
		$id = $route->getParam('id');

		$page = $this->pages->find($id);

		if(null === $page) {
			$this->messages->error('Page not found');

			return $this->response->redirect($this->uri->to('admin/pages'));
		}

		// validate form input
		$validator = new Validator;

		$page->hydrate($this->input->getArrayCopy());

		$validator->validate($page);

		if( ! $validator->isValid()) {
			//$this->session->flash($this->input->getArrayCopy());

			$this->messages->add('error', $validator->getMessages());

			return $this->response->redirect($this->uri->to('admin/pages/'.$page->id.'/edit'));
		}

		$this->pages->publish($page, $this->slugify, $this->markdown);

		$this->messages->info('Page updated');

		return $this->response->redirect($this->uri->to('admin/pages/'.$page->id.'/edit'));
	}

	public function destroy() {
		// post ID
		$id = $route->getParam('id');

		$this->messages->info('Page deleted');

		return $this->response->redirect($this->uri->to('admin/pages'));
	}

}