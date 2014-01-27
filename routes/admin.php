<?php

use Ship\Routing\Route;
use Ship\Routing\Condition;

$auth = new Condition(function() use($app) {
	if($app['auth']->guest()) {
		$app['messages']->warning('Invalid Session');

		return $app['response']->redirect($app['uri']->to('admin/login'));
	}
});

$csrf = new Condition(function() use($app) {
	if($app['input']->has('token')) {
		if( ! $app['csrf']->verify($app['input']->get('token'))) {
			$app['messages']->warning('Invalid Token');

			return $app['response']->redirect($app['uri']->to('admin/login'));
		}
	}
});

/**
 * Admin routing
 */
$app['router']->add(new Route('admin', [
	'controller' => function() use($app) {
		$uri = $app['auth']->guest() ? 'admin/login' : 'admin/posts';

		return $app['response']->redirect($app['uri']->to($uri));
	}
]));

/*
 * Log in
 */
$app['router']->add(new Route('admin/login', [
	'conditions' => [$csrf],
	'requirements' => ['method' => 'GET'],
	'controller' => array($app['adminUsersController'], 'login')
]));

$app['router']->add(new Route('admin/login/attempt', [
	'conditions' => [$csrf],
	'requirements' => ['method' => 'POST'],
	'controller' => array($app['adminUsersController'], 'attempt')
]));

/*
 * Log out
 */
$app['router']->add(new Route('admin/logout', [
	'controller' => function() use($app) {
		$app['auth']->logout();

		return $app['response']->redirect($app['uri']->to('admin/login'));
	}
]));