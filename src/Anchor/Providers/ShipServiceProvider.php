<?php namespace Anchor\Providers;

/**
 * @package		Ship
 * @link		http://madebykieron.co.uk
 * @copyright	Copyright 2013 Kieron Wilson
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use DateTime;
use DateInterval;

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

		$app['pages'] = function($app) {
			$pages = new \Anchor\Mappers\Pages($app['query']);
			$pages->setMeta($app['meta']);

			return $pages;
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

		$app['templates'] = function($app) {
			return new \Anchor\Services\Templates($app['themes']->active());
		};

		$app['nav'] = function($app) {
			$nav = new \Anchor\Services\Nav($app['uri']);

			$nav->setPrefix('admin')->setActive($app['request']->getUri());

			$nav->add('Posts', 'posts', 'flaticon feather-1');
			$nav->add('Comments', 'comments', 'flaticon writing-comment-2');
			$nav->add('Pages', 'pages', 'flaticon multiple-documents-1');
			$nav->add('Menu', 'menu', 'flaticon menu-list-4');
			$nav->add('Categories', 'categories', 'flaticon tag-1');
			$nav->add('Users', 'users', 'flaticon user-1');
			$nav->add('Extend', 'extend', 'flaticon cube-1');

			return $nav;
		};

		$app['lang'] = function($app) {
			$lang = $app['config']->get('app.language', 'en_GB');

			return new \Anchor\Services\I18n($lang);
		};

		$app['controllers'] = function($app) {
			return new \Anchor\Services\ControllerFactory;
		};
	}

	public function register(Container $app) {

		$app['events']->attach('beforeResponse', function() use($app) {
			if($app['admin']) {
				$date = new DateTime();
				$date->sub(new DateInterval('P1Y'));
				$app['response']->setHeader('expires', $date->format(DateTime::RFC2822));
			}
		});

		$app['events']->attach('beforeDispatch', function() {
			// load theme functions before processing the request
			foreach(glob(__DIR__ . '/../../../functions/*.php') as $functions) {
				require $functions;
			}
		});

		if($app['config']->get('app.profiling')) {
			$app['events']->attach('beforeResponse', function() use($app) {
				$template = __DIR__.'/../../../views/partials/profile.phtml';
				$logs = $app['query']->getQueryLog();

				$view = new \Ship\View($template, array(
					'logs' => $logs
				));
				$body = str_replace('</body>', $view->render().'</body>', $app['response']->getBody());

				$app['response']->setBody($body);
			});

			$app['events']->attach('beforeResponse', function() use($app) {
				// Append elapsed time and memory usage
				$time_end = microtime(true);
				$elapsed_time = round(($time_end - $app['time_start']) * 1000);
				$memory = round(memory_get_peak_usage(true) / 1024 / 1024, 2);

				$tags = array('{elapsed_time}', '{memory_usage}');
				$values = array($elapsed_time, $memory);

				$body = str_replace($tags, $values, $app['response']->getBody());

				$app['response']->setBody($body);
			});
		}

		$app['error']->handler(function(\Anchor\Exceptions\HttpNotFound $e) use($app) {
			$html = $app['controllers']->frontend('page', $app)->notFound();

			return $app['response']->setStatusCode(404)->setBody($html)->send();
		});

		$app['error']->handler(function(\Exception $e) use($app) {
			ob_get_level() and ob_end_clean();

			if($app['config']->get('error.report')) {
				$html = '<!DOCTYPE html>
					<html>
					<head>
						<title>Whoops</title>
						<style>
							body { font-family: sans-serif; }
							h2 { font-weight: normal; }
						</style>
					</head>
					<body>
						<h2>'.$e->getMessage().'</h2>
						<p>'.$e->getFile().':'.$e->getLine().'</p>
						<p><pre>'.$e->getTraceAsString().'</pre></p>
					</body>
					</html>';
			}
			else {
				$html = '<!DOCTYPE html>
					<html>
					<head>
						<title>Whoops</title>
						<style>
							body { font-family: sans-serif; }
							h2 { font-weight: normal; }
						</style>
					</head>
					<body>
						<h2>Looks like something went wrong!</h2>
						<p>We track these errors automatically, but if the problem
						persists feel free to contact us. In the meantime, try refreshing.</p>
					</body>
					</html>';
			}

			return $app['response']->setStatusCode(500)->setBody($html)->send();
		});

		$app['admin'] = strpos($app['request']->getUri(), '/admin') === 0;

		$this->registerMappers($app);
		$this->registerServices($app);

		require __DIR__ . '/../../../routes.php';
	}

}