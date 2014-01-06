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
	 * @param object stdClass
	 */
	public function create($row) {
		$record = get_object_vars($row);
		$post = new Post(new ArrayObject($record));

		$categories = new Categories($this->query);
		$post->category = $categories->find($post->category);

		$comments = new Comments($this->query);
		$post->total_comments = $comments->where('status', '=', 'published')->count();

		$users = new Users($this->query);
		$post->author = $users->find($post->author);

		return $post;
	}

	/**
	 * Fetch a buffered array of all posts
	 *
	 * @return object ArrayObject
	 */
	public function all($query = null) {
		return parent::all($this->query()
			->where('status', '=', 'published')
			->order('created', 'desc'));
	}

}