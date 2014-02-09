<?php

use Ship\Routing\Route;

/*
 * Edit post
 */
$app['router']->add(new Route('admin/posts/:id/edit', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Posts', $app), 'edit')
)));

$app['router']->add(new Route('admin/posts/:id/update', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Posts', $app), 'update')
)));

/*
 * Create post
 */
$app['router']->add(new Route('admin/posts/create', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Posts', $app), 'create')
)));

$app['router']->add(new Route('admin/posts/store', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Posts', $app), 'store')
)));

/*
 * Delete post
 */
$app['router']->add(new Route('admin/posts/:id/delete', array(
	'conditions' => array($auth, $csrf),
	//'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Posts', $app), 'destroy')
)));

/*
 * List all posts and paginate through them
 */
$app['router']->add(new Route('admin/posts', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Posts', $app), 'index')
)));