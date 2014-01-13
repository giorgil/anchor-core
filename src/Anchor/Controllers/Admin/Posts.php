<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Models\Post;

class Posts extends Base {

	public function index() {
		$perpage = 10;
		$page = $this->app['input']->filter('page', 1, FILTER_SANITIZE_NUMBER_INT);
		$category = $this->app['input']->filter('category', 0, FILTER_SANITIZE_NUMBER_INT);
		$offset = ($page - 1) * $perpage;

		// @todo: check for page overflow
		// @todo: check if category exists

		if($category) {
			$vars['posts'] = $this->app['posts']->where('category', '=', $category)
				->skip($offset)->take($perpage)->all();
		}
		else {
			$vars['posts'] = $this->app['posts']->skip($offset)->take($perpage)->all();
		}

		$vars['title'] = 'Posts';
		$vars['categories'] = $this->app['categories']->all();

		$vars['messages'] = $this->app['messages']->render();
		$vars['token'] = $this->app['csrf']->token();

		return $this->getCommonView('posts/index.phtml', $vars)->render();
	}

	public function create() {
		// body
		$vars['messages'] = $this->app['messages']->render();
		$vars['token'] = $this->app['csrf']->token();

		$vars['title'] = 'Create Post';
		$vars['post'] = $post;
		$vars['categories'] = $this->app['categories']->all();
		$vars['statuses'] = array('published', 'draft', 'archived');

		return $this->getCommonView('posts/create.phtml', $vars)->render();
	}

	public function store() {
		$post = new Post;

		// filter and validate
		$values = array();

		$post->exchangeArray($values);

		$this->app['posts']->save($post);

		return $this->app['response']->redirect($this->app['uri']->to('admin/posts'));
	}

	public function show() {}

	public function edit($request, $route) {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		// find post
		$post = $this->app['posts']->where('id', '=', $id)->fetch();

		if(null === $post) {
			$this->app['messages']->error('Post not found');

			return $this->app['response']->redirect($this->app['uri']->to('admin/posts'));
		}

		// body
		$vars['messages'] = $this->app['messages']->render();
		$vars['token'] = $this->app['csrf']->token();

		$vars['title'] = 'Editing &ldquo;' . $post->title . '&rdquo;';
		$vars['post'] = $post;
		$vars['categories'] = $this->app['categories']->all();
		$vars['statuses'] = array('published', 'draft', 'archived');

		$vars['form'] = $this->app['adminPostForm'];
		$vars['form']->setAttr('action', $this->app['uri']->to('admin/posts/'.$id.'/update'));
		$vars['form']->setAttr('method', 'POST');

		return $this->getCommonView('posts/edit.phtml', $vars)->render();
	}

	public function update($request, $route) {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		// find post
		$post = $app['posts']->where('id', '=', $id)->fetch();

		if(null === $post) {
			$app['messages']->error('Post not found');

			return $app['response']->redirect($app['uri']->to('admin/posts'));
		}

		$app['messages']->info('Post updated');

		return $app['response']->redirect($app['uri']->to('admin/posts'));
	}

	public function destroy() {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		$app['messages']->info('Post deleted');

		return $app['response']->redirect($app['uri']->to('admin/posts'));
	}

}