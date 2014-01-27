<?php

/**
 * Depreciate functions will be removed in furture releases.
 */

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
function asset_url($file = '') {
	return theme_url($file);
}

/**
 * Returns the current uri
 *
 * @return string
 */
function current_url() {
	global $app;

	return $app['request']->uri();
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
 * Sets a theme value in the config class
 *
 * @param string
 * @param string
 */
function set_theme_options($options, $value = null) {
	return;
}

/**
 * Retrieves a theme value in the config class
 *
 * @param string
 * @param string
 * @return string
 */
function theme_option($option, $default = '') {
	return;
}

/**
 * Returns the article description or the first n characters on the content
 * if there is no description
 *
 * @param int
 * @param string
 * @return string
 */
function article_excerpt($word_length = 50, $elips = '...') {
	return article_description();
}


/**
 * Returns the article category title
 *
 * @return string
 */
function article_category() {
	return category_title();
}

/**
 * Returns the article category slug
 *
 * @return string
 */
function article_category_slug() {
	return category_slug();
}

/**
 * Returns the article category url
 *
 * @return string
 */
function article_category_url() {
	return category_url();
}

/**
 * Returns the article total comments
 *
 * @return string
 */
function article_total_comments() {
	return article()->total_comments;
}

/**
 * Returns the article author username
 *
 * @return string
 */
function article_author() {
	return article()->author->real_name;
}

/**
 * Returns the article author ID (user ID)
 *
 * @return string
 */
function article_author_id() {
	return article()->author->id;
}

/**
 * Returns the article author bio (user bio)
 *
 * @return string
 */
function article_author_bio() {
	return article()->author->bio;
}

/**
 * Alias article content
 *
 * @return string
 */
function article_html() {
	return article_content();
}

/**
 * Alias article content
 *
 * @return string
 */
function article_markdown() {
	return article_content();
}

/**
 * Returns the article css
 *
 * @return string
 */
function article_css() {
	return article_custom_field('css');
}

/**
 * Returns the article js
 *
 * @return string
 */
function article_js() {
	return article_custom_field('js');
}

/**
 * Returns true if the article contents custom css or js code
 *
 * @return bool
 */
function customised() {
	return article_css() or article_js();
}

/**
 * Returns the site name
 *
 * @see Extend > Site Metadata > Site Name
 * @return string
 */
function site_name() {
	return site_meta('sitename');
}

/**
 * Returns the site description
 *
 * @see Extend > Site Metadata > Site Description
 * @return string
 */
function site_description() {
	return site_meta('description');
}


/**
 * Alias page content
 *
 * @return string
 */
function page_html() {
	return page_content();
}

/**
 * Alias page content
 *
 * @return string
 */
function page_markdown() {
	return page_content();
}

/**
 * Returns true if the current user is logged in.
 *
 * Sets the current user in the Registry
 *
 * @return bool
 */
function user_authed() {
	return;
}

/**
 * Returns the authed user ID
 *
 * @return string
 */
function user_authed_id() {
	return;
}

/**
 * Returns the authed user name
 *
 * @return string
 */
function user_authed_name() {
	return;
}


/**
 * Returns the authed user email
 *
 * @return string
 */
function user_authed_email() {
	return;
}

/**
 * Returns the authed user role (administrator, editor, user)
 *
 * @return string
 */
function user_authed_role() {
	return;
}

/**
 * Returns the authed user real name (display name)
 *
 * @return string
 */
function user_authed_real_name() {
	return;
}