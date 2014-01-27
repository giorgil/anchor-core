<?php

/**
 * Returns the page
 *
 * @return object
 */
function page() {
	global $app;

	return $app['registry']->get('page');
}

/**
 * Returns the page ID
 *
 * @return string
 */
function page_id() {
	return page()->id;
}

/**
 * Returns the page url (including nested pages)
 *
 * @return string
 */
function page_url() {
	global $app;

	return $app['uri']->to(page()->uri());
}

/**
 * Returns the page slug
 *
 * @return string
 */
function page_slug() {
	return page()->slug;
}

/**
 * Returns the page name (short title to be used in menus)
 *
 * @return string
 */
function page_name() {
	return page()->name;
}

/**
 * Returns the page title
 *
 * @param string
 * @return string
 */
function page_title() {
	return page()->title;
}

/**
 * Returns the page content
 *
 * @return string
 */
function page_content() {
	return page()->content();
}

/**
 * Returns the page status (published, draft, archived)
 *
 * @return string
 */
function page_status() {
	return page()->status;
}

/**
 * Returns the value of a custom field for a page
 *
 * @param string
 * @param mixed
 * @return string
 */
function page_custom_field($key, $default = '') {
	return;
}