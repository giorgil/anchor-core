<?php namespace Anchor\Mappers;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

use ArrayObject;
use Anchor\Models\Post;
use Anchor\Models\Category;
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
	public function create(array $row) {
		$post = new Post($row);

		$categories = new Categories($this->query);

		if($category = $categories->find($post->category)) {
			$post->setCategory($category);
		}
		else {
			$post->setCategory($categories->fetch());
		}

		//$comments = new Comments($this->query);
		//$post->total_comments = $comments->where('status', '=', 'published')->count();

		$users = new Users($this->query);
		$post->setAuthor($users->find($post->author));

		return $post;
	}

	/**
	 * Fetch published posts
	 *
	 * @return object Collection
	 */
	public function published() {
		return $this->all($this->query()
			->where('status', '=', 'published')
			->order('created', 'desc'));
	}

	/**
	 * Fetch latest posts
	 *
	 * @return object Collection
	 */
	public function latest() {
		return $this->all($this->query()
			->order('created', 'desc'));
	}

	/**
	 * Publish a post
	 *
	 * @param object
	 * @param object
	 * @param object
	 * @param object
	 */
	public function publish($post, $slugify, $markdown, $user) {
		if('' === $post->slug) {
			$post->slug = $slugify->slugify($post->title);
		}

		$post->html = $markdown->parse($post->markdown);
		$post->author = $user->id;

		$this->save($post);
	}

}