<?php namespace Anchor\Controllers\Admin;

/**
 * @package		Anchor Core
 * @link		http://anchorcms.com
 * @copyright	Copyright 2014 Anchor CMS
 * @license		http://opensource.org/licenses/GPL-3.0
 */

class Categories extends Base {

	protected $categories;
	protected $auth;
	protected $input;
	protected $pages;
	protected $messages;
	protected $csrf;
	protected $response;
	protected $uri;
	protected $nav;
	protected $lang;

	public function __construct(\Anchor\Mappers\Categories $categories,
								\Anchor\Services\Auth $auth,
								\Anchor\Services\Messages $messages,
								\Anchor\Services\Csrf $csrf,
								\Anchor\Services\Nav $nav,
								\Ship\Input $input,
								\Ship\Http\Response $response,
								\Ship\I18n $lang,
								\Ship\Uri $uri) {
		$this->categories = $categories;
		$this->auth = $auth;
		$this->input = $input;
		$this->messages = $messages;
		$this->csrf = $csrf;
		$this->response = $response;
		$this->uri = $uri;
		$this->nav = $nav;
		$this->lang = $lang;
	}

	public function index() {
		$vars['title'] = 'Categories';
		$vars['categories'] = $this->categories->all();

		$vars['messages'] = $this->messages->render();
		$vars['token'] = $this->csrf->token();

		return $this->getCommonView('categories/index.phtml', $vars)->render();
	}

}