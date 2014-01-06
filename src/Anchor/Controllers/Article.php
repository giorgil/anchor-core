<?php namespace Anchor\Controllers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Ship\Exception\HttpNotFound;
use Anchor\Services\Registry;

class Article extends Base {

	public function redirect($request, $route) {
		$params = $route->getParams();
		$id = $params[0];

		if($article = $this->app['posts']->find($id)) {
			$uri = $this->app['pages']->posts()->uri() . '/' . $article->uri();
			return $this->app['response']->setStatusCode(302)->setHeader('location', $uri);
		}

		throw new HttpNotFound('Post ID not found');
	}

	public function index($request, $route) {
		$page = $this->app['pages']->posts();

		$params = $route->getParams();
		$slug = $params[0];

		$article = $this->app['posts']->fetch($this->app['posts']->where('slug', '=', $slug));

		if($article) {
			Registry::puts(array(
				'Article' => $article,
				'Page' => $page,
				'Posts' => $this->app['posts'],
			));

			return $this->renderTemplate('article', $article->slug);
		}

		throw new HttpNotFound('Post not found');
	}

}