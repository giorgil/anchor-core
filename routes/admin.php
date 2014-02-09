<?php

use Ship\Routing\Route;
use Ship\Routing\Condition;

/**
 * Conditions
 */
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
 * Admin (redirect to posts listing)
 */
$app['router']->add(new Route('admin', array(
	'controller' => function() use($app) {
		$uri = $app['auth']->guest() ? 'admin/login' : 'admin/posts';

		return $app['response']->redirect($app['uri']->to($uri));
	}
)));

/*
 * Log in
 */
$app['router']->add(new Route('admin/login', array(
	'conditions' => array($csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Users', $app), 'login')
)));

$app['router']->add(new Route('admin/login/attempt', array(
	'conditions' => array($csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Users', $app), 'attempt')
)));

/*
 * Log out
 */
$app['router']->add(new Route('admin/logout', array(
	'controller' => function() use($app) {
		$app['auth']->logout();

		return $app['response']->redirect($app['uri']->to('admin/login'));
	}
)));

/*
 * Extend Landing page
 */
$app['router']->add(new Route('admin/extend', array(
	'conditions' => array($csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Extend', $app), 'index')
)));