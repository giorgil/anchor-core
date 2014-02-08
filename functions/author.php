<?php

/**
 * Returns the article author username
 *
 * @return string
 */
function author() {
	return article()->getAuthor();
}

/**
 * Returns the article author ID (user ID)
 *
 * @return string
 */
function author_id() {
	return author()->id;
}

/**
 * Returns the article author Name
 *
 * @return string
 */
function author_name() {
	return author()->real_name;
}

/**
 * Returns the article author email
 *
 * @return string
 */
function author_email() {
	return author()->email;
}

/**
 * Returns the article author bio (user bio)
 *
 * @return string
 */
function author_bio() {
	return author()->bio;
}