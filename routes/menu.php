<?php

use Ship\Routing\Route;

/*
 * Menu
 */
$app['router']->add(new Route('admin/menu', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Menu', $app), 'index')
)));

$app['router']->add(new Route('admin/menu/update', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Menu', $app), 'update')
)));