<?php

// default controller
$controller = ($app['pages']->home()->id == $app['pages']->posts()->id) ? 'posts': 'page';

/**
 * The Default page
 */
$default = new Ship\Routing\Route('/');
//$default->setController(array($app[$controller.'Controller'], 'index'));
$default->setController(function() use($app) {
	return $app['response']->redirect($app['uri']->to($app['pages']->home()->uri()), 301);
});
$app['router']->add($default);

/**
 * The Home page
 */
$home = new Ship\Routing\Route($app['pages']->home()->uri());
$home->setController(array($app[$controller.'Controller'], 'index'));
$app['router']->add($home);

/**
 * Listing page
 */
$posts = new Ship\Routing\Route($app['pages']->posts()->uri());
$posts->setController(array($app['postsController'], 'index'));
$app['router']->add($posts);

/**
 * List posts by category
 */
$category = new Ship\Routing\Route($app['pages']->posts()->uri() . '/category/:any');
$category->setController(array($app['postsController'], 'category'));
$app['router']->add($category);

/**
 * Rss feed
 */
$rss = new Ship\Routing\Route('feeds/rss');
$rss->setController(array($app['feedController'], 'rss'));
$app['router']->add($rss);

/**
 * Json feed
 */
$json = new Ship\Routing\Route('feeds/json');
$json->setController(array($app['feedController'], 'json'));
$app['router']->add($json);

/**
 * Redirect by article ID
 */
$redirect = new Ship\Routing\Route('[0-9]+');
$redirect->setController(array($app['articleController'], 'redirect'));
$app['router']->add($redirect);

/**
 * View article
 */
$article = new Ship\Routing\Route($app['pages']->posts()->uri() . '/:any');
$article->setController(array($app['articleController'], 'view'));
$app['router']->add($article);

/**
 * Post a comment
 */
$comment = new Ship\Routing\Route($app['pages']->posts()->uri() . '/:any');
$comment->setRequirement('method', 'POST')->setController(array($app['articleController'], 'comment'));
$app['router']->add($comment);

/**
 * Search
 */
$search = new Ship\Routing\Route('search');
$search->setController(array($app['pageController'], 'search'));
$app['router']->add($search);

/**
 * View pages
 */
$page = new Ship\Routing\Route(':any');
$page->setController(array($app['pageController'], 'index'));
$app['router']->add($page);