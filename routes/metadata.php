<?php

use Ship\Routing\Route;

/*
 * List Metadata
 */
$app['router']->add(new Route('admin/extend/meta', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Meta', $app), 'edit')
)));

$app['router']->add(new Route('admin/extend/meta/update', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Meta', $app), 'update')
)));