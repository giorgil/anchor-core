<?php

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