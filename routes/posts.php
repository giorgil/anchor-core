<?php

use Ship\Routing\Route;

/*
 * Edit post
 */
$app['router']->add(new Route('admin/posts/:id/edit', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['adminPostsController'], 'edit')
)));

$app['router']->add(new Route('admin/posts/:id/update', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['adminPostsController'], 'update')
)));

/*
 * Create post
 */
$app['router']->add(new Route('admin/posts/create', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['adminPostsController'], 'create')
)));

$app['router']->add(new Route('admin/posts/save', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['adminPostsController'], 'store')
)));

/*
 * Delete post
 */
$app['router']->add(new Route('admin/posts/:id/delete', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['adminPostsController'], 'destroy')
)));

/*
 * List all posts and paginate through them
 */
$app['router']->add(new Route('admin/posts', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['adminPostsController'], 'index')
)));