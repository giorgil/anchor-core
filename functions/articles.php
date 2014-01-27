<?php

/**
 * Returns the article object
 *
 * @return object Anchor\Model\Post
 */
function article() {
	global $app;

	return $app['registry']->get('article');
}

/**
 * Returns the article ID
 *
 * @return string
 */
function article_id() {
	return article()->id;
}

/**
 * Returns the article title
 *
 * @return string
 */
function article_title() {
	return article()->title;
}

/**
 * Returns the article slug
 *
 * @return string
 */
function article_slug() {
	return article()->slug;
}

/**
 * Returns the previous article url
 *
 * @return string
 */
function article_previous_url() {
	global $app;

	$previous = $app['posts']->previous(article());

	if($previous) {
		return full_url(page_slug() . '/' . $previous->uri());
	}
}

/**
 * Returns the next article url
 *
 * @return string
 */
function article_next_url() {
	global $app;

	$next = $app['posts']->next(article());

	if($next) {
		return full_url(page_slug() . '/' . $next->uri());
	}
}

/**
 * Returns the article url
 *
 * @return string
 */
function article_url() {
	return full_url(page_slug() . '/' . article_slug());
}

/**
 * Returns the article description
 *
 * @return string
 */
function article_description() {
	return article()->description;
}

/**
 * Returns the article content
 *
 * @return string
 */
function article_content() {
	return article()->content();
}

/**
 * Returns the article created date as a unix time stamp
 *
 * @return string
 */
function article_time() {
	global $app;

	return $app['date']->format(article()->created, 'U');
}

/**
 * Returns the article created date formatted
 *
 * @return string
 */
function article_date() {
	global $app;

	return $app['date']->format(article()->created);
}

/**
 * Returns the article status (published, draft, archived)
 *
 * @return string
 */
function article_status() {
	return article()->status;
}

/**
 * Returns the value of a custom field for a post (article)
 *
 * @param string
 * @param mixed
 * @return string
 */
function article_custom_field($key, $default = '') {
	return;
}