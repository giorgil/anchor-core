<?php

use Ship\Routing\Route;

/*
 * Edit post
 */
$app['router']->add(new Route('admin/pages/:id/edit', [
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['adminPagesController'], 'edit')
]));

$app['router']->add(new Route('admin/pages/:id/update', [
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['adminPagesController'], 'update')
]));

/*
 * Create post
 */
$app['router']->add(new Route('admin/pages/create', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['adminPagesController'], 'create')
)));

$app['router']->add(new Route('admin/pages/save', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['adminPagesController'], 'store')
)));

/*
 * Delete post
 */
$app['router']->add(new Route('admin/pages/:id/delete', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['adminPagesController'], 'destroy')
)));

/*
 * List all pages and paginate through them
 */
$app['router']->add(new Route('admin/pages', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['adminPagesController'], 'index')
)));