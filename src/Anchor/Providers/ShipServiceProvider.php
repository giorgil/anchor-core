<?php namespace Anchor\Providers;

/**
 * @package		Ship
 * @link		http://madebykieron.co.uk
 * @copyright	Copyright 2013 Kieron Wilson
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use Ship\Container;
use Ship\Contracts\ProviderInterface;

class ShipServiceProvider implements ProviderInterface {

	protected function registerMappers(Container $app) {
		/**
		 * Mappers
		 */
		$app['themes'] = function($app) {
			return new \Anchor\Mappers\Themes($app['meta']);
		};

		$app['templates'] = function($app) {
			return new \Anchor\Mappers\Templates($app['themes']->active());
		};

		$app['pages'] = function($app) {
			return new \Anchor\Mappers\Pages($app['query'], $app['meta']);
		};

		$app['posts'] = function($app) {
			return new \Anchor\Mappers\Posts($app['query']);
		};

		$app['categories'] = function($app) {
			return new \Anchor\Mappers\Categories($app['query']);
		};

		$app['users'] = function($app) {
			return new \Anchor\Mappers\Users($app['query']);
		};

		$app['meta'] = function($app) {
			return new \Anchor\Mappers\Meta($app['query']);
		};
	}

	protected function registerServices(Container $app) {
		/**
		 * Services
		 */
		$app['auth'] = function($app) {
			return new \Anchor\Services\Auth($app['session'], $app['users']);
		};

		$app['date'] = function($app) {
			$format = $app['meta']->get('date_format');

			return new \Anchor\Services\Date($app['timezone'], $format);
		};

		$app['messages'] = function($app) {
			return new \Anchor\Services\Messages($app['session']);
		};

		$app['csrf'] = function($app) {
			return new \Anchor\Services\Csrf($app['session']);
		};

		$app['registry'] = function() {
			return new \Anchor\Services\Registry;
		};

		$app['nav'] = function($app) {
			$nav = new \Anchor\Services\Nav($app['uri']);

			$nav->setPrefix('admin')->setActive($app['request']->getUri());

			$nav->add('Posts', 'posts', 'flaticon feather-1');
			//$nav->add('Comments', 'comments', 'flaticon writing-comment-2');
			$nav->add('Pages', 'pages', 'flaticon multiple-documents-1');
			//$nav->add('Menu', 'menu', 'flaticon menu-list-4');
			$nav->add('Categories', 'categories', 'flaticon tag-1');
			$nav->add('Users', 'users', 'flaticon user-1');
			//$nav->add('Extend', 'extend', 'flaticon cube-1');

			return $nav;
		};
	}

	protected function registerControllers(Container $app) {
		/**
		 * Controllers
		 */
		$app['articleController'] = function($app) {
			$controller = new \Anchor\Controllers\Article;

			$controller->setContainer($app);

			return $controller;
		};

		$app['pageController'] = function($app) {
			$controller = new \Anchor\Controllers\Page;

			$controller->setContainer($app);

			return $controller;
		};

		$app['postsController'] = function($app) {
			$controller = new \Anchor\Controllers\Posts;

			$controller->setContainer($app);

			return $controller;
		};

		$app['feedController'] = function($app) {
			$controller = new \Anchor\Controllers\Feeds;

			$controller->setContainer($app);

			return $controller;
		};

		/**
		 * Admin Controllers
		 */
		$app['anchorViewsPath'] = function() {
			return __DIR__ . '/../../../views';
		};

		$app['adminPostsController'] = function($app) {
			$controller = new \Anchor\Controllers\Admin\Posts;

			$controller->setContainer($app);

			$controller->setViewPath($app['anchorViewsPath']);

			return $controller;
		};

		$app['adminPagesController'] = function($app) {
			$controller = new \Anchor\Controllers\Admin\Pages;

			$controller->setContainer($app);

			$controller->setViewPath($app['anchorViewsPath']);

			return $controller;
		};

		$app['adminCategoriesController'] = function($app) {
			$controller = new \Anchor\Controllers\Admin\Categories;

			$controller->setContainer($app);

			$controller->setViewPath($app['anchorViewsPath']);

			return $controller;
		};

		$app['adminUsersController'] = function($app) {
			$controller = new \Anchor\Controllers\Admin\Users;

			$controller->setContainer($app);

			$controller->setViewPath($app['anchorViewsPath']);

			return $controller;
		};
	}

	public function register(Container $app) {

		$app['events']->attach('beforeDispatch', function() {
			// load theme functions before processing the request
			foreach(glob(__DIR__ . '/../../../functions/*.php') as $functions) {
				require $functions;
			}
		});

		$app['error']->handler(function(\Anchor\Exceptions\HttpNotFound $e) {
			echo '404';
		});

		$app['admin'] = strpos($app['request']->getUri(), '/admin') === 0;

		$this->registerMappers($app);
		$this->registerServices($app);
		$this->registerControllers($app);

		require __DIR__ . '/../../../routes.php';
	}

}