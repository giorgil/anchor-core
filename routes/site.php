<?php

use Ship\Routing\Route;
use Ship\Routing\Condition;

// home and post uri
$homeUri = $app['pages']->home()->uri();
$postsUri = $app['pages']->posts()->uri();

// default controller
$controller = ($homeUri == $postsUri) ? 'Posts': 'Page';

/**
 * csrf condition to filter post comments
 */
$csrf = new Condition(function() use($app) {
	if($app['input']->has('token')) {
		if( ! $app['csrf']->verify($app['input']->get('token'))) {
			$app['messages']->warning('Invalid Token');

			return $app['response']->redirect($app['request']->getUri());
		}
	}
});

/**
 * The Default page
 */
$app['router']->add(new Route('/', array(
	'controller' => array($app['controllers']->frontend($controller, $app), 'index')
)));

/**
 * The Home page
 */
$app['router']->add(new Route($homeUri, array(
	'controller' => array($app['controllers']->frontend($controller, $app), 'index')
)));

/**
 * Listing page
 */
$app['router']->add(new Route($postsUri, array(
	'controller' => array($app['controllers']->frontend('Posts', $app), 'index')
)));

/**
 * List posts by category
 */
$app['router']->add(new Route($postsUri . '/category/:slug', array(
	'controller' => array($app['controllers']->frontend('Posts', $app), 'category')
)));

/**
 * Rss feed
 */
$app['router']->add(new Route('feeds/rss', array(
	'controller' => array($app['controllers']->frontend('Feeds', $app), 'rss')
)));

/**
 * Json feed
 */
$app['router']->add(new Route('feeds/json', array(
	'controller' => array($app['controllers']->frontend('Feeds', $app), 'json')
)));

/**
 * Redirect by article ID
 */
$app['router']->add(new Route('([0-9]+)', array(
	'controller' => array($app['controllers']->frontend('Article', $app), 'redirect')
)));

/**
 * View article
 */
$app['router']->add(new Route($postsUri . '/:slug', array(
	'controller' => array($app['controllers']->frontend('Article', $app), 'view')
)));

/**
 * Post a comment
 */
$app['router']->add(new Route($postsUri . '/:slug', array(
	'conditions' => array($csrf),
	'requirements' => array('method' => 'POST'),
	'controller' => array($app['controllers']->frontend('Article', $app), 'comment')
)));

/**
 * Search
 */
$app['router']->add(new Route('search', array(
	'controller' => array($app['controllers']->frontend('Page', $app), 'search')
)));

/**
 * View pages
 */
$app['router']->add(new Route(':slug', array(
	'controller' => array($app['controllers']->frontend('Page', $app), 'index')
)));