<?php

/**
 * Returns the total number of categories and sets the Registry with an
 * array of all categories
 *
 * @return string
 */
function total_categories() {
	return;
}

/**
 * Returns true while there are still items in the array.
 *
 * Updates the current category object in the Registry on each call.
 *
 * @return bool
 */
function categories() {
	return;
}

/**
 * Returns the category object
 *
 * @return object Anchor\Model\Category
 */
function category() {
	global $app;

	if($app['registry']->has('category')) {
		return $app['registry']->get('category');
	}

	if($article = article()) {
		return $article->getCategory();
	}
}

/**
 * Returns the category ID
 *
 * @return string
 */
function category_id() {
	return category()->id;
}

/**
 * Returns the category title
 *
 * @return string
 */
function category_title() {
	return category()->title;
}

/**
 * Returns the category slug
 *
 * @return string
 */
function category_slug() {
	return category()->slug;
}

/**
 * Returns the category description
 *
 * @return string
 */
function category_description() {
	return category()->description;
}

/**
 * Returns the category url
 *
 * @return string
 */
function category_url() {
	return full_url(page_slug().'/'.category_slug());
}

/**
 * Returns the number of published posts in the current category
 *
 * @return string
 */
function category_count() {
	return category()->total_posts;
}