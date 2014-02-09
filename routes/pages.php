<?php

use Ship\Routing\Route;

/*
 * Edit post
 */
$app['router']->add(new Route('admin/pages/:id/edit', [
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Pages', $app), 'edit')
]));

$app['router']->add(new Route('admin/pages/:id/update', [
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Pages', $app), 'update')
]));

/*
 * Create post
 */
$app['router']->add(new Route('admin/pages/create', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Pages', $app), 'create')
)));

$app['router']->add(new Route('admin/pages/store', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Pages', $app), 'store')
)));

/*
 * Delete post
 */
$app['router']->add(new Route('admin/pages/:id/delete', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Pages', $app), 'destroy')
)));

/*
 * List all pages and paginate through them
 */
$app['router']->add(new Route('admin/pages', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Pages', $app), 'index')
)));