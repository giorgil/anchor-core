<?php

use Ship\Routing\Route;

/*
 * List Plugins
 */
$app['router']->add(new Route('admin/extend/plugins', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Plugins', $app), 'index')
)));

/*
 * View Plugin
 */
$app['router']->add(new Route('admin/extend/plugins/:name', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Plugins', $app), 'view')
)));

/*
 * Update Plugin (active/deactive)
 */
$app['router']->add(new Route('admin/extend/plugins/:name/update', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Plugins', $app), 'update')
)));