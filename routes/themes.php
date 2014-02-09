<?php

use Ship\Routing\Route;

/*
 * List Themes
 */
$app['router']->add(new Route('admin/extend/themes', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Themes', $app), 'index')
)));

/*
 * View Theme
 */
$app['router']->add(new Route('admin/extend/themes/:name', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Themes', $app), 'view')
)));

/*
 * Use Theme
 */
$app['router']->add(new Route('admin/extend/themes/:name/use', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->backend('Themes', $app), 'use')
)));