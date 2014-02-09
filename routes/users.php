<?php

use Ship\Routing\Route;

$app['resource']->add('admin/users', $app['controllers']->backend('Users', $app), array($auth, $csrf));

/**
 * Amnesia (sends a forgotten password email)
 */
$app['router']->add(new Route('admin/users/amnesia', [
	'conditions' => array($csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Users', $app), 'amnesia')
]));

$app['router']->add(new Route('admin/users/amnesia', [
	'conditions' => array($csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Users', $app), 'amnesia')
]));

/**
 * Reset password using token from email
 */
$app['router']->add(new Route('admin/users/reset/:token', [
	'conditions' => array($csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Users', $app), 'reset')
]));

$app['router']->add(new Route('admin/users/reset/:token', [
	'conditions' => array($csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Users', $app), 'reset')
]));