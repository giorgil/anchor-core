<?php

/**
 * Returns the number of items in the menu
 *
 * @return string
 */
function has_menu_items() {
	return;
}

/**
 * Returns true while there are still items in the array.
 *
 * Updates the current menu_item object in the Registry on each call.
 *
 * @return bool
 */
function menu_items() {
	global $app;

	if(null === $app['pages']->getResults()) {
		$app['pages']->setResults($app['pages']->menuItems());
	}

	return $app['pages']->loop(function($page) use($app) {
		$app['registry']->put('item', $page);
	});
}

/**
 * Returns the menu_item
 *
 * @return string
 */
function menu_item() {
	global $app;

	return $app['registry']->get('item');
}

/**
 * Returns the menu_item ID
 *
 * @return string
 */
function menu_id() {
	return menu_item()->id;
}

/**
 * Returns the menu_item url
 *
 * @return string
 */
function menu_url() {
	global $app;

	return $app['uri']->to(menu_item()->uri());
}

/**
 * Returns the menu_item relative url (slug and parent slugs)
 *
 * @return string
 */
function menu_relative_url() {
	return menu_url();
}

/**
 * Returns the menu_item name (short title)
 *
 * @return string
 */
function menu_name() {
	return menu_item()->name;
}

/**
 * Returns the menu_item title
 *
 * @return string
 */
function menu_title() {
	return menu_item()->title;
}

/**
 * Returns true if the current slug matches the menu_item slug
 *
 * @return bool
 */
function menu_active() {
	return;
}

/**
 * Returns the menu_item parent ID
 *
 * @return string
 */
function menu_parent() {
	return;
}

/**
 * Renders a unodered list as a menu including any sub menus
 *
 * @param array array('parent' => 0, 'class' => '')
 * @return string
 */
function menu_render($params = array()) {
	return;
}