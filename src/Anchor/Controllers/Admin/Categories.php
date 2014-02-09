<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Models\Category;
use Anchor\Forms\Category as CategoryForm;
use Anchor\Services\Validator;

class Categories extends Backend {

	public function index() {
		$vars['title'] = 'Categories';
		$vars['categories'] = $this->categories->all();

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		return $this->getCommonView('categories/index.phtml', $vars)->render();
	}

	public function create() {
		$form = new CategoryForm;
		$form->setAttr('action', $this->uri->to('admin/categories/store'));
		$form->setAttr('method', 'POST');

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Create Category';
		$vars['categories'] = $this->categories->all();
		$vars['form'] = $form;

		return $this->getCommonView('categories/create.phtml', $vars)->render();
	}

	public function store() {
		$category = new Category;
		$validator = new Validator;

		$category->hydrate($this->input->getArrayCopy());

		$validator->validate($category);

		if( ! $validator->isValid()) {
			//$this->session->flash($this->input->getArrayCopy());

			$this->messages->add('error', $validator->getMessages());

			return $this->response->redirect($this->uri->to('admin/categories/create'));
		}

		if('' === $category->slug) {
			$category->slug = $this->slugify->slugify($category->title);
		}

		$this->categories->save($category);

		$this->messages->info('Category created');

		return $this->response->redirect($this->uri->to('admin/categories/'.$category->id.'/edit'));
	}

	public function edit($request, $route) {
		$params = $route->getParams();
		$id = $params[0];

		$category = $this->categories->find($id);

		if(null === $category) {
			$this->messages->error('Category not found');

			return $this->response->redirect($this->uri->to('admin/categories'));
		}

		$form = new CategoryForm;
		$form->setAttr('action', $this->uri->to('admin/categories/'.$category->id.'/update'));
		$form->setAttr('method', 'POST');
		$form->setValues($category->toArray());

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Editing &ldquo;' . $category->title . '&rdquo;';
		$vars['category'] = $category;
		$vars['categories'] = $this->categories->all();
		$vars['form'] = $form;

		return $this->getCommonView('categories/edit.phtml', $vars)->render();
	}

	public function update($request, $route) {
		$params = $route->getParams();
		$id = $params[0];

		$category = $this->categories->find($id);

		if(null === $category) {
			$this->messages->error('Category not found');

			return $this->response->redirect($this->uri->to('admin/categories'));
		}

		// validate form input
		$validator = new Validator;

		$category->hydrate($this->input->getArrayCopy());

		$validator->validate($category);

		if( ! $validator->isValid()) {
			//$this->session->flash($this->input->getArrayCopy());

			$this->messages->add('error', $validator->getMessages());

			return $this->response->redirect($this->uri->to('admin/categories/'.$category->id.'/edit'));
		}

		if('' === $category->slug) {
			$category->slug = $this->slugify->slugify($category->title);
		}

		$this->categories->save($category);

		$this->messages->info('Category updated');

		return $this->response->redirect($this->uri->to('admin/categories/'.$category->id.'/edit'));
	}

	public function destroy() {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		$this->messages->info('Category deleted');

		return $this->response->redirect($this->uri->to('admin/categories'));
	}

}