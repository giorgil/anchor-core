<?php

/**
 * Returns the full uri includes the scheme and host
 *
 * @param string
 * @return string
 */
function full_url($url = '/') {
	global $app;

	return $app['uri']->to($url);
}

/**
 * Returns a uri relative to the current theme
 *
 * @param string
 * @return string
 */
function theme_url($file = '') {
	global $app;

	$theme = $app['meta']->get('theme');
	return $app['uri']->to('themes/'.$theme.'/'.$file);
}

/**
 * Include a theme file is the file exists and readable
 *
 * Returns true if the file was included
 *
 * @param string
 * @return bool
 */
function theme_include($file) {
	global $app;

	$theme = $app['meta']->get('theme');
	$path = 'themes/'.$theme.'/'.$file;

	if(is_file($path)) {
		return require $path;
	}
}

/**
 * Returns true if the current page ID match the home page ID
 *
 * @return bool
 */
function is_homepage() {
	global $app;

	return $app['pages']->home()->id == page_id();
}

/**
 * Returns true if the current page ID match the posts listing page ID
 *
 * @return bool
 */
function is_postspage() {
	global $app;

	return $app['pages']->posts()->id == page_id();
}

/**
 * Returns true if a article object has been set in the Registry
 *
 * @return bool
 */
function is_article() {
	global $app;

	return $app['registry']->has('article');
}

/**
 * Returns true if a post_category object has been set in the Registry
 *
 * @return bool
 */
function is_category() {
	global $app;

	return $app['registry']->has('category');
}

/**
 * Returns true if a page object has been set in the Registry
 *
 * @return bool
 */
function is_page() {
	global $app;

	return $app['registry']->has('page');
}