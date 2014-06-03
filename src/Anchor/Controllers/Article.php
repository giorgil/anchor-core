<?php namespace Anchor\Controllers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Anchor\Exceptions\HttpNotFound;

class Article extends Frontend {

	public function redirect($request, $route) {
		$id = $route->getParam(0);

		if($article = $this->posts->find($id)) {
			$uri = $this->uri->to($this->pages->posts()->uri() . '/' . $article->uri());

			return $this->response->setStatusCode(302)->setHeader('location', $uri);
		}

		throw new HttpNotFound('Post ID not found');
	}

	public function view($request, $route) {
		$page = $this->pages->posts();

		$slug = $route->getParam('slug');

		$article = $this->posts->fetch($this->posts->where('slug', '=', $slug));

		if($article) {
			$this->registry->put('article', $article);
			$this->registry->put('page', $page);

			return $this->renderTemplate('article', $article->slug);
		}

		throw new HttpNotFound('Post not found');
	}

}