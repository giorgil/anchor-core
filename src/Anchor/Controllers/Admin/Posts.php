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
		$page = $this->input->filter('page', 1, FILTER_SANITIZE_NUMBER_INT);
		$category = $this->input->filter('category', 0, FILTER_SANITIZE_NUMBER_INT);
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

		if('' === $post->slug) {
			$post->slug = $this->slugify->slugify($post->title);
		}

		$post->html = $this->markdown->parse($post->markdown);

		$user = $this->auth->user();
		$post->author = $user->id;

		$this->posts->save($post);

		$this->messages->info('Post created');

		return $this->response->redirect($this->uri->to('admin/posts/'.$post->id.'/edit'));
	}

	public function edit($request, $route) {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

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
		$params = $route->getParams();
		$id = $params[0];

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

		if('' === $post->slug) {
			$post->slug = $this->slugify->slugify($post->title);
		}

		$post->html = $this->markdown->parse($post->markdown);

		$user = $this->auth->user();
		$post->author = $user->id;

		$this->posts->save($post);

		$this->messages->info('Post updated');

		return $this->response->redirect($this->uri->to('admin/posts/'.$post->id.'/edit'));
	}

	public function destroy() {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		$this->messages->info('Post deleted');

		return $this->response->redirect($this->uri->to('admin/posts'));
	}

}