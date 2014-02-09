<?php

use Ship\Routing\Route;

/*
 * List all
 */
$app['router']->add(new Route('admin/categories', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Categories', $app), 'index')
)));