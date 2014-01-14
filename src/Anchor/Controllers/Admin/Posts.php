<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Models\Post;

class Posts extends Base {

	protected $input;
	protected $posts;
	protected $categories;
	protected $form;
	protected $messages;
	protected $csrf;
	protected $response;
	protected $uri;
	protected $nav;

	public function __construct(\Anchor\Mappers\Posts $posts,
								\Anchor\Mappers\Categories $categories,
								\Anchor\Forms\Post $form,
								\Anchor\Services\Messages $messages,
								\Anchor\Services\Csrf $csrf,
								\Anchor\Services\Nav $nav,
								\Ship\Input $input,
								\Ship\Http\Response $response,
								\Ship\Uri $uri) {
		$this->input = $input;
		$this->posts = $posts;
		$this->categories = $categories;
		$this->form = $form;
		$this->messages = $messages;
		$this->csrf = $csrf;
		$this->response = $response;
		$this->uri = $uri;
		$this->nav = $nav;
	}

	public function index() {
		$perpage = 10;
		$page = $this->input->filter('page', 1, FILTER_SANITIZE_NUMBER_INT);
		$category = $this->input->filter('category', 0, FILTER_SANITIZE_NUMBER_INT);
		$offset = ($page - 1) * $perpage;

		// @todo: check for page overflow
		// @todo: check if category exists

		if($category) {
			$vars['posts'] = $this->posts->where('category', '=', $category)
				->skip($offset)->take($perpage)->all();
		}
		else {
			$vars['posts'] = $this->posts->skip($offset)->take($perpage)->all();
		}

		$vars['title'] = 'Posts';
		$vars['categories'] = $this->categories->all();

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		return $this->getCommonView('posts/index.phtml', $vars)->render();
	}

	public function create() {
		// body
		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Create Post';
		$vars['post'] = $post;
		$vars['categories'] = $this->categories->all();
		$vars['statuses'] = array('published', 'draft', 'archived');

		return $this->getCommonView('posts/create.phtml', $vars)->render();
	}

	public function store() {
		$post = new Post;

		// filter and validate
		$values = array();

		$post->exchangeArray($values);

		$this->posts->save($post);

		return $this->response->redirect($this->uri->to('admin/posts'));
	}

	public function show() {}

	public function edit($request, $route) {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		// find post
		$post = $this->posts->where('id', '=', $id)->fetch();

		if(null === $post) {
			$this->messages->error('Post not found');

			return $this->response->redirect($this->uri->to('admin/posts'));
		}

		// body
		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		$vars['title'] = 'Editing &ldquo;' . $post->title . '&rdquo;';
		$vars['post'] = $post;
		$vars['categories'] = $this->categories->all();
		$vars['statuses'] = array('published', 'draft', 'archived');

		$vars['form'] = $this->form;
		$vars['form']->setAttr('action', $this->uri->to('admin/posts/'.$id.'/update'));
		$vars['form']->setAttr('method', 'POST');

		return $this->getCommonView('posts/edit.phtml', $vars)->render();
	}

	public function update($request, $route) {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		// find post
		$post = $this->posts->where('id', '=', $id)->fetch();

		if(null === $post) {
			$this->messages->error('Post not found');

			return $this->response->redirect($uri->to('admin/posts'));
		}

		$this->messages->info('Post updated');

		return $this->response->redirect($this->uri->to('admin/posts'));
	}

	public function destroy() {
		// post ID
		$params = $route->getParams();
		$id = $params[0];

		$this->messages->info('Post deleted');

		return $this->response->redirect($this->uri->to('admin/posts'));
	}

}