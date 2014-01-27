<?php

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
 * Returns the value of a custom site variable
 *
 * @see Extend > Site Variables
 * @param string
 * @param string
 * @return string
 */
function site_meta($key, $default = '') {
	global $app;

	return $app['meta']->get($key, $default);
}