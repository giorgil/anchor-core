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
 * Returns a uri
 *
 * @param string
 * @return string
 */
function base_url($url = '') {
	return full_url($url);
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
 * Returns a uri relative to anchor admin
 *
 * @param string
 * @return string
 */
function asset_url($extra = '') {
	return;
}

/**
 * Returns the current uri
 *
 * @return string
 */
function current_url() {
	return;
}

/**
 * Returns the rss uri
 *
 * @return string
 */
function rss_url() {
	global $app;

	return $app['uri']->to('feeds/rss');
}

/**
 * Stores a function to be called in other template files
 *
 * Usage:
 *	<?php bind('home_page_slug.function_name', function() {return 'hello';}); ?>
 *
 * @param function Closure
 * @param string
 * @return string
 */
function bind($page, $fn) {
	return;
}

/**
 * Invokes a stored function
 *
 * Usage:
 *	<?php echo receive('function_name'); ?>
 *
 * @param string
 * @return string
 */
function receive($name = '') {
	return;
}

/**
 * Returns a CSS class of page types and current uri
 *
 * @return string
 */
function body_class() {
	return;
}

/**
 * Returns true if the current page ID match the home page ID
 *
 * @return bool
 */
function is_homepage() {
	return;
}

/**
 * Returns true if the current page ID match the posts listing page ID
 *
 * @return bool
 */
function is_postspage() {
	return;
}

/**
 * Returns true if a article object has been set in the Registry
 *
 * @return bool
 */
function is_article() {
	global $app;

	return $app['registry']->had('article');
}

/**
 * Returns true if a post_category object has been set in the Registry
 *
 * @return bool
 */
function is_category() {
	global $app;

	return $app['registry']->had('category');
}

/**
 * Returns true if a page object has been set in the Registry
 *
 * @return bool
 */
function is_page() {
	global $app;

	return $app['registry']->had('page');
}