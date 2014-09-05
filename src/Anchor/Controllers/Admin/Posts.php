<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Models\Post as PostModel;
use Anchor\Forms\Post as PostForm;
use Anchor\Services\Validator;

class Posts extends Backend {

	public function index() {
		$perpage = 10;
		$page = $this->input->get('page', 1);
		$category = $this->input->get('category', 0);
		$offset = ($page - 1) * $perpage;

		// @todo: check for page overflow
		// @todo: check if category exists

		if($category) {
			$vars['posts'] = $this->posts->all(
				$this->posts->where('category', '=', $category)
					->order('created', 'desc')
					->skip($offset)
					->take($perpage)
			);
		}
		else {
			$vars['posts'] = $this->posts->all(
				$this->posts->order('created', 'desc')
					->skip($offset)
					->take($perpage)
			);
		}

		$vars['title'] = 'Posts';
		$vars['categories'] = $this->categories->all();

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		return $this->getCommonView('posts/index.phtml', $vars)->render();
	}

	public function create() {
		$post = new PostModel;

		$form = new PostForm;
		$form->setAttr('action', $this->uri->to('admin/posts/store'));
		$form->setAttr('method', 'POST');

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Creating a new post';

		$vars['form'] = $form;
		$vars['post'] = $post;

		$vars['categories'] = $this->categories->all();
		$vars['posts'] = $this->posts->latest();

		return $this->getCommonView('posts/create.phtml', $vars)->render();
	}

	public function store() {
		$post = new PostModel;
		$validator = new Validator;

		$post->hydrate($this->input->getArrayCopy());

		$validator->validate($post);

		if( ! $validator->isValid()) {
			//$this->session->flash($this->input->getArrayCopy());

			$this->messages->add('error', $validator->getMessages());

			return $this->response->redirect($this->uri->to('admin/posts/create'));
		}

		$this->posts->publish($post, $this->slugify, $this->markdown, $this->auth->user());

		$this->messages->info('Post created');

		return $this->response->redirect($this->uri->to('admin/posts/'.$post->id.'/edit'));
	}

	public function edit($request, $route) {
		// post ID
		$id = $route->getParam('id');

		// find post
		$post = $this->posts->find($id);

		if(null === $post) {
			$this->messages->error('Post not found');

			return $this->response->redirect($this->uri->to('admin/posts'));
		}

		$form = new PostForm;
		$form->setAttr('action', $this->uri->to('admin/posts/'.$post->id.'/update'));
		$form->setAttr('method', 'POST');
		$form->setValues($post->toArray());

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Editing &ldquo;' . $post->title . '&rdquo;';
		$vars['post'] = $post;
		$vars['categories'] = $this->categories->all();
		$vars['posts'] = $this->posts->latest();
		$vars['form'] = $form;

		return $this->getCommonView('posts/edit.phtml', $vars)->render();
	}

	public function update($request, $route) {
		// post ID
		$id = $route->getParam('id');

		// find post
		$post = $this->posts->find($id);

		if(null === $post) {
			$this->messages->error('Post not found');

			return $this->response->redirect($uri->to('admin/posts'));
		}

		// validate form input
		$validator = new Validator;

		$post->hydrate($this->input->getArrayCopy());

		$validator->validate($post);

		if( ! $validator->isValid()) {
			//$this->session->flash($this->input->getArrayCopy());

			$this->messages->add('error', $validator->getMessages());

			return $this->response->redirect($this->uri->to('admin/posts/'.$post->id.'/edit'));
		}

		$this->posts->publish($post, $this->slugify, $this->markdown, $this->auth->user());

		$this->messages->info('Post updated');

		return $this->response->redirect($this->uri->to('admin/posts/'.$post->id.'/edit'));
	}

	public function destroy($request, $route) {
		// post ID
		$id = $route->getParam('id');

		// find post
		$post = $this->posts->find($id);

		if(null === $post) {
			$this->messages->error('Post not found');

			return $this->response->redirect($this->uri->to('admin/posts'));
		}

		$this->posts->delete($post);

		$this->messages->info('Post deleted');

		return $this->response->redirect($this->uri->to('admin/posts'));
	}

}