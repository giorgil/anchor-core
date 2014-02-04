<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use ArrayObject;
use Anchor\Models\Post;
use Anchor\Mappers\Categories;
use Anchor\Mappers\Comments;
use Anchor\Mappers\Users;

class Posts extends Base {

	/**
	 * Stores the table name
	 *
	 * @var string
	 */
	protected $table = 'posts';

	/**
	 * Returns the next post
	 *
	 * @param object Post
	 * @return object/null
	 */
	public function next(Post $post) {
		$query = $this->query()
			->where('id', '>', $post->id)
			->where('status', '=', 'published');

		return $this->fetch($query);
	}

	/**
	 * Returns the previous post
	 *
	 * @param object Post
	 * @return object/null
	 */
	public function previous(Post $post) {
		$query = $this->query()
			->where('id', '<', $post->id)
			->where('status', '=', 'published')
			->order('id', 'desc');

		return $this->fetch($query);
	}

	/**
	 * Creates a new Post object
	 *
	 * @param object
	 */
	public function create($row) {
		$post = new Post($row);

		$categories = new Categories($this->query);
		$post->category = $categories->find($post->category);
		/*
		$comments = new Comments($this->query);
		$post->total_comments = $comments->where('status', '=', 'published')->count();
		*/
		$users = new Users($this->query);
		$post->author = $users->find($post->author);

		return $post;
	}

	/**
	 * Fetch a buffered array of published posts
	 *
	 * @return object ArrayObject
	 */
	public function published() {
		return $this->all($this->query()
			->where('status', '=', 'published')
			->order('created', 'desc'));
	}

	/**
	 * Fetch a buffered array of latest posts
	 *
	 * @return object ArrayObject
	 */
	public function latest() {
		return $this->all($this->query()
			->order('created', 'desc'));
	}

}